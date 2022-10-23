@component('mail::message')
<h1>Hello!</h1>
<p>Your verification code:</p>

@component('mail::panel')
{{ $code }}
@endcomponent

<p>The allowed duration of the code is one hour from the time the message was sent</p>
<p>Regards,<br>OnesBlogApi</p>
@endcomponent
