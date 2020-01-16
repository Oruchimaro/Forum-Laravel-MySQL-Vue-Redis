@component('mail::message')
# One Last Step
Dear {{ $user->name }},
We Just Need You To Confirm You Are Human !!!

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
