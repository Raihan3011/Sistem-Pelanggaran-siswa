<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Pelanggaran Siswa</title>
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

        .reset-container {
            display: flex;
            max-width: 1100px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 600px;
        }

        .reset-left {
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

        .reset-left::before {
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

        .reset-right {
            flex: 1.2;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .reset-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .reset-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .reset-header p {
            color: #666;
            font-size: 1rem;
        }

        .success-notice {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            color: #065f46;
            font-size: 0.95rem;
            line-height: 1.5;
            text-align: center;
        }

        .success-notice i {
            color: var(--success);
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .reset-form {
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

        .password-strength {
            margin-top: 8px;
            font-size: 0.8rem;
        }

        .strength-weak {
            color: var(--error);
        }

        .strength-medium {
            color: var(--accent);
        }

        .strength-strong {
            color: var(--success);
        }

        .password-requirements {
            background: #f8fafc;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            border-left: 4px solid var(--primary);
        }

        .password-requirements h4 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .requirements-list {
            list-style: none;
            color: #666;
            font-size: 0.85rem;
            line-height: 1.6;
        }

        .requirements-list li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s;
        }

        .requirements-list li.valid {
            color: var(--success);
        }

        .requirements-list li i {
            font-size: 0.8rem;
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

        .primary-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        @media (max-width: 768px) {
            .reset-container {
                flex-direction: column;
                max-width: 450px;
            }

            .reset-left {
                padding: 30px;
            }

            .reset-right {
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

            .reset-left, .reset-right {
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
    <div class="reset-container">
        <!-- Left Side - Welcome Section -->
        <div class="reset-left">
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
                <i class="bi bi-key-fill"></i>
            </div>

            <div class="welcome-text">
                <h1>Password Baru</h1>
                <p>Buat password baru yang kuat untuk mengamankan akun Anda di sistem pelanggaran siswa.</p>
            </div>
        </div>

        <!-- Right Side - Reset Password Form -->
        <div class="reset-right">
            <div class="reset-header">
                <h2>Reset Password</h2>
                <p>Buat password baru untuk akun Anda</p>
            </div>

            <!-- Success Notice -->
            <div class="success-notice">
                <i class="bi bi-check-circle-fill"></i>
                Link reset password telah diverifikasi. Silakan buat password baru untuk akun Anda.
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="reset-form" id="resetForm">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope"></i>
                        <input id="email" class="text-input @error('email') input-error @enderror" 
                               type="email" name="email" value="{{ old('email', $request->email) }}" 
                               required autofocus autocomplete="username" 
                               placeholder="email@sekolah.sch.id" readonly>
                    </div>
                    @error('email')
                        <div class="error-messages">
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <div class="input-with-icon">
                        <i class="bi bi-lock"></i>
                        <input id="password" class="text-input @error('password') input-error @enderror"
                               type="password"
                               name="password"
                               required autocomplete="new-password"
                               placeholder="Buat password baru yang kuat"
                               oninput="checkPasswordStrength()">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div id="password-strength" class="password-strength"></div>
                    @error('password')
                        <div class="error-messages">
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-with-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input id="password_confirmation" class="text-input"
                               type="password"
                               name="password_confirmation" 
                               required autocomplete="new-password"
                               placeholder="Ketik ulang password baru"
                               oninput="checkPasswordMatch()">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div id="password-match" class="password-strength"></div>
                    @error('password_confirmation')
                        <div class="error-messages">
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Password Requirements -->
                <div class="password-requirements">
                    <h4>
                        <i class="bi bi-shield-check"></i>
                        Kriteria Password yang Baik
                    </h4>
                    <ul class="requirements-list" id="requirements-list">
                        <li id="req-length"><i class="bi bi-circle"></i> Minimal 8 karakter</li>
                        <li id="req-uppercase"><i class="bi bi-circle"></i> Mengandung huruf besar</li>
                        <li id="req-lowercase"><i class="bi bi-circle"></i> Mengandung huruf kecil</li>
                        <li id="req-number"><i class="bi bi-circle"></i> Mengandung angka</li>
                        <li id="req-special"><i class="bi bi-circle"></i> Mengandung karakter khusus</li>
                    </ul>
                </div>

                <div class="form-actions">
                    <a class="back-link" href="{{ route('login') }}">
                        <i class="bi bi-arrow-left"></i> Kembali ke Login
                    </a>

                    <button type="submit" class="primary-button" id="submitButton" disabled>
                        <i class="bi bi-key"></i> Reset Password
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

        // Check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthIndicator = document.getElementById('password-strength');
            const submitButton = document.getElementById('submitButton');
            
            let strength = 0;
            let message = '';
            let className = '';

            // Check requirements
            const hasMinLength = password.length >= 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            // Update requirements list
            updateRequirement('req-length', hasMinLength);
            updateRequirement('req-uppercase', hasUpperCase);
            updateRequirement('req-lowercase', hasLowerCase);
            updateRequirement('req-number', hasNumbers);
            updateRequirement('req-special', hasSpecialChar);

            // Calculate strength
            if (password.length > 0) {
                if (password.length < 6) {
                    strength = 1;
                    message = 'Password terlalu lemah';
                    className = 'strength-weak';
                } else if (password.length < 8 || !hasUpperCase || !hasLowerCase || !hasNumbers) {
                    strength = 2;
                    message = 'Password cukup';
                    className = 'strength-medium';
                } else {
                    strength = 3;
                    message = 'Password kuat';
                    className = 'strength-strong';
                }
            }

            strengthIndicator.textContent = message;
            strengthIndicator.className = 'password-strength ' + className;

            // Enable submit button only if password is strong enough
            const isStrongEnough = strength >= 2 && hasMinLength;
            submitButton.disabled = !isStrongEnough;

            // Also check password match
            checkPasswordMatch();
        }

        // Update requirement indicator
        function updateRequirement(elementId, isValid) {
            const element = document.getElementById(elementId);
            const icon = element.querySelector('i');
            
            if (isValid) {
                element.classList.add('valid');
                icon.classList.remove('bi-circle');
                icon.classList.add('bi-check-circle', 'text-green-500');
            } else {
                element.classList.remove('valid');
                icon.classList.remove('bi-check-circle', 'text-green-500');
                icon.classList.add('bi-circle');
            }
        }

        // Check password confirmation match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchIndicator = document.getElementById('password-match');
            const submitButton = document.getElementById('submitButton');

            if (confirmPassword.length === 0) {
                matchIndicator.textContent = '';
                return;
            }

            if (password === confirmPassword) {
                matchIndicator.textContent = '✓ Password cocok';
                matchIndicator.className = 'password-strength strength-strong';
            } else {
                matchIndicator.textContent = '✗ Password tidak cocok';
                matchIndicator.className = 'password-strength strength-weak';
                submitButton.disabled = true;
            }
        }

        // Form submission animation
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const button = document.getElementById('submitButton');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Mereset Password...';
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

        // Initialize password strength check
        document.getElementById('password').addEventListener('input', checkPasswordStrength);
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
    </script>
</body>
</html>