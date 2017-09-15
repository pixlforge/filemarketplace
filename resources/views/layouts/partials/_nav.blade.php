<nav class="nav">
    <div class="container">
        <div class="nav-left">
            <a href="{{ route('home') }}" class="nav-item is-brand">
                {{ config('app.name') }}
            </a>
        </div>

        <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </span>

        <div class="nav-right nav-menu">
            @auth
                <a href=""
                   class="nav-item"
                   onclick="event.preventDefault(); document.getElementById('logout').submit();">
                    Sign out
                </a>

                <a href="{{ route('account') }}" class="nav-item">
                    {{ auth()->user()->name }}
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-item">
                    Sign in
                </a>

                <div class="nav-item">
                    <a href="{{ route('register') }}" class="nav-item">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<form method="POST" action="{{ route('logout') }}" id="logout" class="is-hidden">
    {{ csrf_field() }}
</form>