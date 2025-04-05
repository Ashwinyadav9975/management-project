@component('mail::message')
# ⚠️ Security Alert: Multiple Failed Login Attempts

We detected **multiple failed login attempts** on your account. If this was you, no further action is needed.

However, if you did not attempt to log in, we strongly recommend that you:

- Reset your password immediately.
- Enable two-factor authentication (2FA) for added security.
- Review your account activity for any suspicious behavior.

@component('mail::button', ['url' => 'https://yourapp.com/reset-password'])
Reset Password
@endcomponent

Stay safe,  
**{{ config('app.name') }}**  
@endcomponent
