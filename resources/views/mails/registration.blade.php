<x-mail::message>
# Registered Successfully
Hello! {{$first_name}} {{$last_name}}, Thanks for registering an account with us.
<p>Find below your Log in Credentials:</p>
# Email: {{$email}}
# Password: {{$password}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
