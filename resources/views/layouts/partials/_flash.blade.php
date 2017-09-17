@if (session()->has('success'))
    <div class="notification has-text-centered is-success">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('info'))
    <div class="notification has-text-centered is-info">
        {{ session('info') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="notification has-text-centered is-warning">
        {{ session('warning') }}
    </div>
@endif

@if (session()->has('danger'))
    <div class="notification has-text-centered is-danger">
        {{ session('danger') }}
    </div>
@endif