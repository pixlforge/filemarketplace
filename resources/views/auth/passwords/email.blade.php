@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container is-fluid">
            <div class="columns">
                <div class="column is-half is-offset-one-quarter">

                    @if (session('status'))
                        <div class="notification is-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 class="title">Reset your password</h1>
                    <form method="POST" action="{{ route('password.email') }}" class="form">
                        {{ csrf_field() }}

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

                        {{--Submit--}}
                        <div class="field">
                            <p class="control">
                                <button type="submit" class="button is-primary">Send email</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection