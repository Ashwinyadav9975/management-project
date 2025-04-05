@component('mail::message')
# Welcome, {{ $userName }}! 🎉

Thank you for registering with us. We're excited to have you on board!

If you have any questions, feel free to [contact our support team](mailto:ashwinyadav440@gmail.com).

@component('mail::button', ['url' => 'http://127.0.0.1:8000/home'])
Go to Dashboard
@endcomponent

Thanks,  
**{{ ('Ashwin') }}**
@endcomponent
