<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pelanggaran Siswa</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        /* CSS tetap sama seperti sebelumnya */
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

        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 600px;
        }

        .login-left {
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

        .login-left::before {
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
            font-size: 2.5rem;
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

        .login-right {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-header p {
            color: #666;
            font-size: 1rem;
        }

        .login-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
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
            padding: 15px 15px 15px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
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
            margin-top: 8px;
        }

        .error-message {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 4px;
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 2px solid #d1d5db;
        }

        .remember-me label {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .primary-button {
            width: 100%;
            padding: 15px;
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
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

        .session-error {
            padding: 12px 16px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #dc2626;
            font-size: 0.9rem;
        }

        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-to-home a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .back-to-home a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }

            .login-left {
                padding: 30px;
            }

            .login-right {
                padding: 30px;
            }

            .welcome-text h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .login-left, .login-right {
                padding: 25px;
            }

            .logo-container {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Welcome Section -->
        <div class="login-left">
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
                <h1>Selamat Datang</h1>
                <p>Masuk ke sistem pelanggaran siswa untuk mengelola dan memantau perkembangan disiplin siswa secara digital dan real-time.</p>
            </div>

            <ul class="features-list">
                <li><i class="bi bi-check-circle-fill"></i> Monitoring pelanggaran real-time</li>
                <li><i class="bi bi-check-circle-fill"></i> Laporan analitik otomatis</li>
                <li><i class="bi bi-check-circle-fill"></i> Notifikasi sistem cerdas</li>
                <li><i class="bi bi-check-circle-fill"></i> Keamanan data terjamin</li>
            </ul>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-header">
                <h2>Masuk ke Akun</h2>
                <p>Silakan masuk dengan username dan password Anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="session-error">
                    <strong>Login gagal!</strong> Periksa kembali username dan password Anda.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Username Field -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-with-icon">
                        <i class="bi bi-person"></i>
                        <input id="username" class="text-input @error('username') input-error @enderror" 
                               type="text" name="username" value="{{ old('username') }}" 
                               required autofocus autocomplete="username" 
                               placeholder="Masukkan username Anda">
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
                               required autocomplete="current-password"
                               placeholder="Masukkan password Anda">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-messages">
                            <div class="error-message">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Ingat saya</label>
                    </div>

                    <!-- HAPUS LINK REGISTER DI SINI -->
                    <!-- <a class="forgot-password" href="{{ route('register') }}"> -->
                    <!--     Buat akun baru? -->
                    <!-- </a> -->
                </div>

                <button type="submit" class="primary-button">
                    <span class="button-text">Masuk</span>
                </button>
            </form>

            <div class="back-to-home">
                <a href="{{ url('/') }}">← Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
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

        // Form submission animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = this.querySelector('.primary-button');
            const buttonText = button.querySelector('.button-text');
            
            buttonText.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Memproses...';
            button.disabled = true;
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

        // Auto-focus username field
        document.getElementById('username').focus();
    </script>
</body>
</html>