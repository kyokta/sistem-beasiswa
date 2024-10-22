<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <ul class="navbar-nav w-100 justify-content-around">
            <li class="nav-item text-center flex-fill">
                <a class="nav-link {{ request()->routeIs('index') ? 'active-link' : '' }}" href="{{ route('index') }}">Beasiswa</a>
            </li>
            <li class="nav-item text-center flex-fill">
                <a class="nav-link {{ request()->routeIs('daftar') ? 'active-link' : '' }}" href="{{ route('daftar') }}">Daftar</a>
            </li>
            <li class="nav-item text-center flex-fill">
                <a class="nav-link {{ request()->routeIs('hasil') ? 'active-link' : '' }}" href="{{ route('hasil') }}">Hasil</a>
            </li>
        </ul>
    </div>
</nav>
