<header class="header">
    <div class="header-left">
        <h1>@yield('page-title', 'Dashboard')</h1>
    </div>
    
    <div class="header-right">
        <div class="user-menu">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
            <i class="bi bi-chevron-down"></i>
        </div>
    </div>
</header>