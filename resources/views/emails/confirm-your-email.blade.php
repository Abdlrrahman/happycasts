@component('mail::message')
# One more step before joining Happycasts !

The body of your message.

@component('mail::button', ['url' => route('confirm-email') . '?token=' . $user->confirm_token])
Confirm Your Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
