<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $forms = \App\Models\Form::all(); // select * from forms
        return view('forms.index', compact('forms'));
    }
}
