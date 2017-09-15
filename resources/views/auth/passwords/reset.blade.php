@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container is-fluid">
            <div class="columns">
                <div class="column is-half is-offset-one-quarter">
                    <h1 class="title">Choose a new passsword</h1>
                    <form method="POST" action="{{ route('password.request') }}" class="form">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        {{--Email--}}
                        <div class="field">
                            <label for="email">Email</label>
                            <p class="control">
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="input{{ $errors->has('email') ? ' is-danger' : '' }}"
                                       value="{{ old('email') }}"
                                       autofocus>
                            </p>
                            @if ($errors->has('email'))
                                <p class="help is-danger">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        {{--Password--}}
                        <div class="field">
                            <label for="password">Password</label>
                            <p class="control">
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="input{{ $errors->has('password') ? ' is-danger' : '' }}">
                            </p>
                            @if ($errors->has('password'))
                                <p class="help is-danger">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>

                        {{--Submit--}}
                        <div class="field">
                            <p class="control">
                                <button type="submit" class="button is-primary">Sign in</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
