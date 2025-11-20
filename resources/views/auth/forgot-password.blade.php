<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Pelanggaran Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #1d4ed8;
            --secondary: #60a5fa;
            --accent: #f59e0b;
            --success: #10b981;
            --error: #ef4444;
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

        .forgot-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 550px;
        }

        .forgot-left {
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

        .forgot-left::before {
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

        .forgot-right {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .forgot-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .forgot-header p {
            color: #666;
            font-size: 1rem;
        }

        .info-text {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            color: #0369a1;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .info-text i {
            color: var(--primary);
            margin-right: 8px;
        }

        .forgot-form {
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
        }

        .session-status {
            padding: 15px 20px;
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            margin-bottom: 25px;
            color: #065f46;
            font-size: 0.95rem;
            text-align: center;
        }

        .session-status.success {
            background: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
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

        .steps {
            margin-top: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
        }

        .steps h4 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .steps ol {
            padding-left: 20px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .steps li {
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .forgot-container {
                flex-direction: column;
                max-width: 450px;
            }

            .forgot-left {
                padding: 30px;
            }

            .forgot-right {
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

            .forgot-left, .forgot-right {
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
    <div class="forgot-container">
        <!-- Left Side - Welcome Section -->
        <div class="forgot-left">
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
                <i class="bi bi-key"></i>
            </div>

            <div class="welcome-text">
                <h1>Reset Password</h1>
                <p>Masukkan email Anda dan kami akan mengirimkan link untuk mereset password akun Anda.</p>
            </div>
        </div>

        <!-- Right Side - Forgot Password Form -->
        <div class="forgot-right">
            <div class="forgot-header">
                <h2>Lupa Password?</h2>
                <p>Jangan khawatir, kami akan membantu Anda</p>
            </div>

            <!-- Info Text -->
            <div class="info-text">
                <i class="bi bi-info-circle"></i>
                Masukkan alamat email yang terdaftar pada akun Anda. Kami akan mengirimkan link reset password ke email tersebut.
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="forgot-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope"></i>
                        <input id="email" class="text-input @error('email') input-error @enderror" 
                               type="email" name="email" value="{{ old('email') }}" 
                               required autofocus 
                               placeholder="contoh: email@sekolah.sch.id">
                    </div>
                    @error('email')
                        <div class="error-messages">
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Steps Information -->
                <div class="steps">
                    <h4>Proses Reset Password:</h4>
                    <ol>
                        <li>Masukkan email terdaftar</li>
                        <li>Periksa inbox email Anda</li>
                        <li>Klik link reset password</li>
                        <li>Buat password baru</li>
                        <li>Login dengan password baru</li>
                    </ol>
                </div>

                <div class="form-actions">
                    <a class="back-link" href="{{ route('login') }}">
                        <i class="bi bi-arrow-left"></i> Kembali ke Login
                    </a>

                    <button type="submit" class="primary-button">
                        <i class="bi bi-send"></i> Kirim Link Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
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
            button.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Mengirim...';
            button.disabled = true;
            
            // Re-enable button after 5 seconds if form submission fails
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 5000);
        });

        // Auto-hide success message after 5 seconds
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

        // Email validation on blur
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });
    </script>
</body>
</html>