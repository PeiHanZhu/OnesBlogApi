@component('mail::message')
<h1>Hello!</h1>
<p>We have received your request to reset your account password</p>
<p>You can use the following code to recover your account:</p>

@component('mail::panel')
{{ $code }}
@endcomponent

<p>The allowed duration of the code is one hour from the time the message was sent</p>
<p>Regards,<br>OnesBlogApi</p>
@endcomponent
