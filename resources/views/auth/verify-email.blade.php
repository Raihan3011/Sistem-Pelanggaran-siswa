<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Sistem Pelanggaran Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #1d4ed8;
            --secondary: #60a5fa;
            --accent: #f59e0b;
            --success: #10b981;
            --warning: #f59e0b;
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

        .verification-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 550px;
        }

        .verification-left {
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

        .verification-left::before {
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

        .verification-right {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .verification-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .verification-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .verification-header p {
            color: #666;
            font-size: 1rem;
        }

        .verification-message {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            color: #0369a1;
            font-size: 0.95rem;
            line-height: 1.6;
            text-align: center;
        }

        .verification-message i {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 15px;
            display: block;
        }

        .success-message {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            color: #065f46;
            font-size: 0.95rem;
            text-align: center;
            animation: slideIn 0.5s ease;
        }

        .success-message i {
            color: var(--success);
            margin-right: 8px;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 30px;
        }

        .resend-form {
            text-align: center;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
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

        .logout-form {
            text-align: center;
        }

        .logout-button {
            padding: 12px 30px;
            background: transparent;
            color: #666;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
            text-decoration: none;
        }

        .logout-button:hover {
            border-color: var(--error);
            color: var(--error);
            transform: translateY(-2px);
        }

        .steps {
            margin-top: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid var(--primary);
        }

        .steps h4 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
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

        .timer {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #666;
        }

        .timer span {
            font-weight: 600;
            color: var(--primary);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .verification-container {
                flex-direction: column;
                max-width: 450px;
            }

            .verification-left {
                padding: 30px;
            }

            .verification-right {
                padding: 30px;
            }

            .welcome-text h1 {
                font-size: 1.8rem;
            }

            .illustration i {
                font-size: 80px;
            }

            .action-buttons {
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .verification-left, .verification-right {
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
    <div class="verification-container">
        <!-- Left Side - Welcome Section -->
        <div class="verification-left">
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
                <i class="bi bi-envelope-check"></i>
            </div>

            <div class="welcome-text">
                <h1>Verifikasi Email</h1>
                <p>Selesaikan pendaftaran akun Anda dengan memverifikasi alamat email yang telah didaftarkan.</p>
            </div>
        </div>

        <!-- Right Side - Verification Content -->
        <div class="verification-right">
            <div class="verification-header">
                <h2>Verifikasi Email Anda</h2>
                <p>Selesaikan proses pendaftaran akun</p>
            </div>

            <!-- Verification Message -->
            <div class="verification-message">
                <i class="bi bi-envelope-paper"></i>
                Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirim ke email Anda. Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.
            </div>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="success-message">
                    <i class="bi bi-check-circle-fill"></i>
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <form method="POST" action="{{ route('verification.send') }}" class="resend-form" id="resendForm">
                    @csrf
                    <button type="submit" class="primary-button" id="resendButton">
                        <i class="bi bi-send"></i> Kirim Ulang Email Verifikasi
                    </button>
                    <div class="timer" id="timer">
                        Dapat kirim ulang dalam: <span id="countdown">60</span> detik
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>

            <!-- Steps Information -->
            <div class="steps">
                <h4>
                    <i class="bi bi-info-circle"></i>
                    Langkah-langkah Verifikasi
                </h4>
                <ol>
                    <li>Buka inbox email Anda</li>
                    <li>Cari email verifikasi dari Sistem Pelanggaran Siswa</li>
                    <li>Klik tautan verifikasi dalam email</li>
                    <li>Kembali ke sistem dan login ulang</li>
                    <li>Akun Anda sudah aktif dan siap digunakan</li>
                </ol>
            </div>
        </div>
    </div>

    <script>
        // Timer for resend verification email
        let countdown = 60;
        let timerInterval;
        const resendButton = document.getElementById('resendButton');
        const timerElement = document.getElementById('timer');
        const countdownElement = document.getElementById('countdown');

        function startTimer() {
            resendButton.disabled = true;
            timerElement.style.display = 'block';
            
            timerInterval = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(timerInterval);
                    resendButton.disabled = false;
                    timerElement.style.display = 'none';
                    countdown = 60;
                    countdownElement.textContent = countdown;
                }
            }, 1000);
        }

        // Start timer on page load
        document.addEventListener('DOMContentLoaded', function() {
            startTimer();
        });

        // Form submission animation
        document.getElementById('resendForm').addEventListener('submit', function(e) {
            const button = document.getElementById('resendButton');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Mengirim...';
            button.disabled = true;
            
            // Restart timer after form submission
            setTimeout(() => {
                button.innerHTML = originalText;
                startTimer();
                
                // Show success message animation
                if (!document.querySelector('.success-message')) {
                    const successMessage = document.createElement('div');
                    successMessage.className = 'success-message';
                    successMessage.innerHTML = '<i class="bi bi-check-circle-fill"></i> Email verifikasi telah dikirim!';
                    document.querySelector('.action-buttons').insertBefore(successMessage, document.getElementById('resendForm'));
                    
                    // Remove success message after 5 seconds
                    setTimeout(() => {
                        successMessage.remove();
                    }, 5000);
                }
            }, 2000);
        });

        // Add animation to illustration
        const illustration = document.querySelector('.illustration i');
        setInterval(() => {
            illustration.style.animation = 'pulse 2s ease-in-out';
            setTimeout(() => {
                illustration.style.animation = '';
            }, 2000);
        }, 5000);

        // Auto-check for new verification (optional)
        function checkVerificationStatus() {
            // This would typically make an API call to check if user is verified
            console.log('Checking verification status...');
        }

        // Check every 30 seconds
        setInterval(checkVerificationStatus, 30000);
    </script>
</body>
</html>