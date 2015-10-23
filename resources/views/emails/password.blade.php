@if (app()->environment() === 'testing')
    $url = 'http://sagd.app/password/reset/'
@else
    $url = 'http://sagd.app/password/reset/'
@endif

Click here to reset your password: {{ $url.$token) }}
