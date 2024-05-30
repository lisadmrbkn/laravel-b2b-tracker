<x-mail::message>
# Hi, There is a new form submission.

<x-mail::table>
| Question      | Answer   |
| ------------- | --------:|
| Name       | {{ $formSubmission->name }}       |
| Email      | {{ $formSubmission->email }}      |
| Phone      | {{ $formSubmission->phone }}      |
@foreach($formSubmission->answers as $answer)
| {{$answer['question']}}      | {{$answer['value']}}      |
@endforeach
</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
