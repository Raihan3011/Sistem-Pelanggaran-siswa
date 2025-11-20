<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div class="sidebar-title">
            SMK BN 666
        </div>
    </div>
    
    <nav class="sidebar-menu">
        <div class="menu-section">
            <div class="menu-title">Menu Utama</div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.siswa.index') }}" class="menu-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.pelanggaran.index') }}" class="menu-link {{ request()->routeIs('admin.pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Pelanggaran</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="menu-section">
            <div class="menu-title">Manajemen Data</div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ route('admin.kategori.index') }}" class="menu-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Kategori Pelanggaran</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.users.index') }}" class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-person-gear"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('tahun-ajaran.index') }}" class="menu-link {{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-range"></i>
                        <span>Tahun Ajaran</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="menu-section">
            <div class="menu-title">Laporan</div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ route('admin.laporan.pelanggaran') }}" class="menu-link {{ request()->routeIs('admin.laporan.pelanggaran') ? 'active' : '' }}">
                        <i class="bi bi-file-text"></i>
                        <span>Laporan Pelanggaran</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.laporan.statistik') }}" class="menu-link {{ request()->routeIs('admin.laporan.statistik') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i>
                        <span>Statistik</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.laporan.siswa') }}" class="menu-link {{ request()->routeIs('admin.laporan.siswa') ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Laporan Siswa</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="menu-section">
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ url('/') }}" class="menu-link">
                        <i class="bi bi-house"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>