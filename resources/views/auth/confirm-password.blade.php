<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password - Sistem Pelanggaran Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #1d4ed8;
            --secondary: #60a5fa;
            --accent: #f59e0b;
            --success: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
            --dark: #111827;
            --light: #f3f4f6;
            --gradient: linear-gradient(135deg, #1e3a8a, #3b82f6);
            --gradient-accent: linear-gradient(135deg, #f59e0b, #f97316);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(rgba(29, 78, 216, 0.9), rgba(30, 58, 138, 0.9)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .confirm-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 550px;
        }

        .confirm-left {
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

        .confirm-left::before {
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
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .logo i {
            font-size: 28px;
            color: var(--primary);
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

        .illustration {
            text-align: center;
            margin: 30px 0;
            position: relative;
            z-index: 2;
        }

        .illustration i {
            font-size: 120px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
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
        }

        .confirm-right {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .confirm-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .confirm-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .confirm-header p {
            color: #666;
            font-size: 1rem;
        }

        .security-notice {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            color: #92400e;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .security-notice i {
            color: var(--warning);
            margin-right: 8px;
        }

        .confirm-form {
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
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
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
            display: flex;
            align-items: center;
            gap: 5px;
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

        .session-status {
            padding: 15px 20px;
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 12px;
            margin-bottom: 25px;
            color: #92400e;
            font-size: 0.95rem;
            text-align: center;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        .back-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .primary-button {
            padding: 14px 35px;
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .primary-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(29, 78, 216, 0.3);
        }

        .security-features {
            margin-top: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid var(--primary);
        }

        .security-features h4 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-features ul {
            list-style: none;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .security-features li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-features li i {
            color: var(--success);
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .confirm-container {
                flex-direction: column;
                max-width: 450px;
            }

            .confirm-left {
                padding: 30px;
            }

            .confirm-right {
                padding: 30px;
            }

            .welcome-text h1 {
                font-size: 1.8rem;
            }

            .illustration i {
                font-size: 80px;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .confirm-left, .confirm-right {
                padding: 25px;
            }

            .logo-container {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="confirm-container">
        <!-- Left Side - Security Section -->
        <div class="confirm-left">
            <div class="logo-container">
                <div class="logo">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div class="school-name">
                    <h2>SMK Bakti Nusantara 666</h2>
                    <span>Sistem Pelanggaran Siswa</span>
                </div>
            </div>
            
            <div class="illustration">
                <i class="bi bi-shield-lock"></i>
            </div>

            <div class="welcome-text">
                <h1>Konfirmasi Keamanan</h1>
                <p>Area ini membutuhkan verifikasi identitas Anda untuk melanjutkan akses ke fitur sistem yang dilindungi.</p>
            </div>
        </div>

        <!-- Right Side - Confirm Password Form -->
        <div class="confirm-right">
            <div class="confirm-header">
                <h2>Konfirmasi Password</h2>
                <p>Verifikasi identitas Anda untuk melanjutkan</p>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <i class="bi bi-exclamation-triangle"></i>
                Ini adalah area aman dari aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    <i class="bi bi-info-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}" class="confirm-form">
                @csrf

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password Saat Ini</label>
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
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Security Features -->
                <div class="security-features">
                    <h4>
                        <i class="bi bi-shield-check"></i>
                        Fitur Keamanan
                    </h4>
                    <ul>
                        <li><i class="bi bi-check"></i> Verifikasi identitas pengguna</li>
                        <li><i class="bi bi-check"></i> Perlindungan akses tidak sah</li>
                        <li><i class="bi bi-check"></i> Enkripsi data sensitif</li>
                        <li><i class="bi bi-check"></i> Monitoring aktivitas sistem</li>
                    </ul>
                </div>

                <div class="form-actions">
                    <a class="back-link" href="{{ url()->previous() }}">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="primary-button">
                        <i class="bi bi-shield-check"></i> Konfirmasi
                    </button>
                </div>
            </form>
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

        // Add focus effects to form inputs
        document.querySelectorAll('.text-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Form submission animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = this.querySelector('.primary-button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Memverifikasi...';
            button.disabled = true;
            
            // Re-enable button after 3 seconds if form submission fails
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 3000);
        });

        // Auto-hide status message after 5 seconds
        const statusMessage = document.querySelector('.session-status');
        if (statusMessage) {
            setTimeout(() => {
                statusMessage.style.opacity = '0';
                statusMessage.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    statusMessage.remove();
                }, 500);
            }, 5000);
        }

        // Password strength indicator (optional)
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
            
            if (password.length === 0) {
                indicator.textContent = '';
                return;
            }
            
            if (password.length < 6) {
                indicator.textContent = 'Password terlalu pendek';
                indicator.style.color = '#ef4444';
            } else {
                indicator.textContent = '✓ Password valid';
                indicator.style.color = '#10b981';
            }
        });
    </script>
</body>
</html>