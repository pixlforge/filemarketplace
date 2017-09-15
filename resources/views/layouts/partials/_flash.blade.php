@if (session()->has('success'))
    <div class="notification is-success">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('info'))
    <div class="notification is-info">
        {{ session('info') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="notification is-warning">
        {{ session('warning') }}
    </div>
@endif

@if (session()->has('danger'))
    <div class="notification is-danger">
        {{ session('danger') }}
    </div>
@endif