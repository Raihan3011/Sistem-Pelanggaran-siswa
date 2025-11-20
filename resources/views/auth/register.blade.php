<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Pelanggaran Siswa</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #0ea5e9;
            --secondary: #38bdf8;
            --accent: #f59e0b;
            --success: #10b981;
            --error: #ef4444;
            --dark: #111827;
            --light: #f3f4f6;
            --gradient: linear-gradient(135deg, #0ea5e9, #0284c7);
            --gradient-accent: linear-gradient(135deg, #f59e0b, #f97316);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(rgba(14, 165, 233, 0.9), rgba(2, 132, 199, 0.9)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            display: flex;
            max-width: 1100px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 700px;
            max-height: 90vh;
        }

        .register-left {
            flex: 1;
            background: var(--gradient);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .register-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
        }

        .logo {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo i {
            font-size: 28px;
            color: white;
        }

        .school-name h2 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
        }

        .school-name span {
            font-size: 1rem;
            opacity: 0.9;
        }

        .welcome-text {
            position: relative;
            z-index: 2;
        }

        .welcome-text h1 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .welcome-text p {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .features-list {
            list-style: none;
            position: relative;
            z-index: 2;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .features-list i {
            color: var(--accent);
        }

        .register-right {
            flex: 1.2;
            padding: 40px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .register-header p {
            color: #666;
            font-size: 1rem;
        }

        .register-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 1.1rem;
        }

        .text-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #f8fafc;
            font-family: inherit;
        }

        .text-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .input-error {
            border-color: var(--error) !important;
        }

        .error-messages {
            margin-top: 6px;
        }

        .error-message {
            color: var(--error);
            font-size: 0.8rem;
            margin-top: 3px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .role-selection {
            margin-bottom: 20px;
        }

        .role-selection label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark);
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .role-option {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8fafc;
        }

        .role-option:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .role-option.active {
            border-color: var(--primary);
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary);
            font-weight: 600;
        }

        .role-option i {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 6px;
        }

        .role-option .role-name {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .role-option .role-desc {
            font-size: 0.7rem;
            color: #666;
            line-height: 1.2;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
        }

        .login-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .primary-button {
            padding: 12px 30px;
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
        }

        .primary-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(14, 165, 233, 0.3);
        }

        .session-status {
            padding: 12px 16px;
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #065f46;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                max-width: 450px;
            }

            .register-left {
                padding: 30px;
            }

            .register-right {
                padding: 30px;
            }

            .welcome-text h1 {
                font-size: 1.8rem;
            }

            .role-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .register-left, .register-right {
                padding: 25px;
            }

            .logo-container {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Side - Welcome Section -->
        <div class="register-left">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ asset('storage/Logo_SMK.png') }}" alt="Logo SMK" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <i class="bi bi-mortarboard-fill" style="display: none;"></i>
                </div>
                <div class="school-name">
                    <h2>SMK Bakti Nusantara 666</h2>
                    <span>Sistem Pelanggaran Siswa</span>
                </div>
            </div>
            
            <div class="welcome-text">
                <h1>Buat Akun Baru</h1>
                <p>Bergabung dengan sistem pelanggaran siswa untuk mengelola dan memantau perkembangan disiplin siswa secara digital.</p>
            </div>

            <ul class="features-list">
                <li><i class="bi bi-check-circle-fill"></i> Akses sesuai peran pengguna</li>
                <li><i class="bi bi-check-circle-fill"></i> Monitoring real-time</li>
                <li><i class="bi bi-check-circle-fill"></i> Laporan otomatis</li>
                <li><i class="bi bi-check-circle-fill"></i> Keamanan terjamin</li>
            </ul>
        </div>

        <!-- Right Side - Register Form -->
        <div class="register-right">
            <div class="register-header">
                <h2>Daftar Akun Baru</h2>
                <p>Pilih peran dan lengkapi data diri Anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf

                <!-- Role Selection -->
                <div class="role-selection">
                    <label>Pilih Peran *</label>
                    <div class="role-grid">
                        <div class="role-option" data-role="admin">
                            <i class="bi bi-gear-fill"></i>
                            <div class="role-name">Admin</div>
                            <div class="role-desc">Full Access + Maintenance & Backup</div>
                        </div>
                        <div class="role-option" data-role="kepsek">
                            <i class="bi bi-award-fill"></i>
                            <div class="role-name">Kepala Sekolah</div>
                            <div class="role-desc">Monitoring & laporan</div>
                        </div>
                        <div class="role-option" data-role="kesiswaan">
                            <i class="bi bi-clipboard-data"></i>
                            <div class="role-name">Kesiswaan</div>
                            <div class="role-desc">Kelola data siswa & pelanggaran</div>
                        </div>
                        <div class="role-option" data-role="guru">
                            <i class="bi bi-person-workspace"></i>
                            <div class="role-name">Guru</div>
                            <div class="role-desc">Catat pelanggaran siswa</div>
                        </div>
                        <div class="role-option" data-role="wali_kelas">
                            <i class="bi bi-person-badge"></i>
                            <div class="role-name">Wali Kelas</div>
                            <div class="role-desc">Pantau siswa di kelas</div>
                        </div>
                        <div class="role-option" data-role="bk">
                            <i class="bi bi-chat-heart"></i>
                            <div class="role-name">Guru BK</div>
                            <div class="role-desc">Bimbingan & konseling siswa</div>
                        </div>
                        <div class="role-option" data-role="orang_tua">
                            <i class="bi bi-people"></i>
                            <div class="role-name">Orang Tua</div>
                            <div class="role-desc">Pantau perkembangan anak</div>
                        </div>
                        <div class="role-option active" data-role="siswa">
                            <i class="bi bi-person"></i>
                            <div class="role-name">Siswa</div>
                            <div class="role-desc">Lihat riwayat pelanggaran</div>
                        </div>
                    </div>
                    <input type="hidden" name="role" id="role" value="siswa" required>
                    @error('role')
                        <div class="error-messages">
                            <div class="error-message">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-with-icon">
                        <i class="bi bi-person"></i>
                        <input id="name" class="text-input @error('name') input-error @enderror" 
                               type="text" name="name" value="{{ old('name') }}" 
                               required autofocus autocomplete="name" 
                               placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name')
                        <div class="error-messages">
                            <div class="error-message">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-with-icon">
                        <i class="bi bi-person-circle"></i>
                        <input id="username" class="text-input @error('username') input-error @enderror" 
                               type="text" name="username" value="{{ old('username') }}" 
                               required autocomplete="username" 
                               placeholder="Masukkan username">
                    </div>
                    @error('username')
                        <div class="error-messages">
                            <div class="error-message">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="bi bi-lock"></i>
                        <input id="password" class="text-input @error('password') input-error @enderror"
                               type="password"
                               name="password"
                               required autocomplete="new-password"
                               placeholder="Buat password minimal 8 karakter">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-messages">
                            <div class="error-message">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-with-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input id="password_confirmation" class="text-input"
                               type="password"
                               name="password_confirmation" 
                               required autocomplete="new-password"
                               placeholder="Ketik ulang password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="error-messages">
                            <div class="error-message">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a class="login-link" href="{{ route('login') }}">
                        Sudah punya akun? Masuk
                    </a>

                    <button type="submit" class="primary-button">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = passwordInput.parentElement.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

        // Role selection functionality
        document.querySelectorAll('.role-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all options
                document.querySelectorAll('.role-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                
                // Add active class to clicked option
                this.classList.add('active');
                
                // Update hidden input value
                const role = this.getAttribute('data-role');
                document.getElementById('role').value = role;
                
                console.log('Selected role:', role);
            });
        });

        // Password strength indicator (optional enhancement)
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('password-strength');
            
            if (!strengthIndicator) {
                const indicator = document.createElement('div');
                indicator.id = 'password-strength';
                indicator.style.marginTop = '5px';
                indicator.style.fontSize = '0.8rem';
                this.parentElement.parentElement.appendChild(indicator);
            }
            
            const indicator = document.getElementById('password-strength');
            let strength = 'Lemah';
            let color = '#ef4444';
            
            if (password.length >= 8) {
                strength = 'Sedang';
                color = '#f59e0b';
            }
            if (password.length >= 12 && /[A-Z]/.test(password) && /[0-9]/.test(password)) {
                strength = 'Kuat';
                color = '#10b981';
            }
            
            indicator.textContent = `Kekuatan password: ${strength}`;
            indicator.style.color = color;
        });

        // Form submission animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = this.querySelector('.primary-button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Memproses...';
            button.disabled = true;
            
            // Re-enable button after 3 seconds if form submission fails
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 3000);
        });

        // Add focus effects to form inputs
        document.querySelectorAll('.text-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>