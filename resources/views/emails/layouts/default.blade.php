@if (isset($user))
    <p>Hi, {{ $user->name }}</p>
@else
    <p>Hi!</p>
@endif

@yield ('content')

<p>Thanks, <strong>{{ config('app.name') }}</strong></p>