<form method="POST" action="{{ route('checkout.free', $file) }}">
    {{ csrf_field() }}

    <span class="field has-addons">
        <p class="control">
            <input type="email" name="email" id="email" class="input is-large" value="{{ old('email') }}"  placeholder="you@domain.tld" required>
        </p>
        <p class="control">
            <button class="button is-large is-primary">Download for free</button>
        </p>
    </span>
    @if ($errors->has('email'))
        <p class="help is-danger">{{ $errors->first('email') }}</p>
    @endif
</form>