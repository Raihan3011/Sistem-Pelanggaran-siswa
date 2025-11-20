<header>
    <div class="logo-container">
        <div class="logo">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div class="school-name">
            <h2>SMK Bakti Nusantara 666</h2>
            <span>Teknologi & Inovasi</span>
        </div>
    </div>
    <nav>
        <a href="{{ url('/') }}">Beranda</a>
        <a href="#features">Fitur</a>
        <a href="#how-it-works">Cara Kerja</a>
        <a href="#contact">Kontak</a>
        
        @auth
            @if(Auth::user()->level === 'admin')
                <a href="{{ route('admin.dashboard') }}" style="background: rgba(255,255,255,0.2);">Dashboard Admin</a>
            @elseif(Auth::user()->level === 'guru')
                <a href="{{ route('guru.dashboard') }}" style="background: rgba(255,255,255,0.2);">Dashboard Guru</a>
            @elseif(Auth::user()->level === 'siswa')
                <a href="{{ route('siswa.dashboard') }}" style="background: rgba(255,255,255,0.2);">Dashboard Siswa</a>
            @else
                <a href="{{ url('/home') }}" style="background: rgba(255,255,255,0.2);">Dashboard</a>
            @endif
            
            <!-- Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: rgba(255,255,255,0.1); color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; transition: all 0.3s;">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" style="background: rgba(255,255,255,0.2);">Login</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" style="background: rgba(255,255,255,0.1);">Daftar</a>
            @endif
        @endauth
    </nav>
</header>

<style>
    /* Tambahkan style untuk button logout */
    #logout-form button:hover {
        background: rgba(255,255,255,0.2) !important;
        transform: translateY(-2px);
    }
</style>