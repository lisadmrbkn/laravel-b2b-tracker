<?php

namespace App\Http\Controllers;

use App\Mail\FormSubmitted;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FormController extends Controller
{
    public function show(Form $form)
    {
        return view('forms.show', compact('form'));
    }

    public function fill(Request $request, Form $form)
    {
        // validate the request
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'answers' => ['required', 'array'],
            'answers.*.id' => ['required', Rule::exists('questions', 'id')->where('form_id', $form->id)],
            'answers.*.value' => ['required'],
        ]);

        // get questions and use them in the answers array
        $questions = Question::query()->whereIn('id', array_column($data['answers'], 'id'))->get();

        $answers = [];
        foreach ($questions as $question) {
            $value = $data['answers'][$question->id]['value'];
            if ($value instanceof UploadedFile) {
                // save the file to disk
                $path = $value->store('uploads');

                $value = Storage::url($path);
            }
            $answers[$question->id] = [
                'question' => $question->label,
                'value' => $value,
            ];
        }

        // create the form submission
        $formSubmission = FormSubmission::create([
            'form_id' => $form->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'answers' => $answers,
        ]);

        // email the form owner
        Mail::to($form->user)->send(new FormSubmitted($formSubmission));

        return redirect('/')->with('success', 'Form submitted successfully!');
    }
}
