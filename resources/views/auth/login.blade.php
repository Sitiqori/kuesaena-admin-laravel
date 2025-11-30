<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - KUESAENA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-image: url('{{ asset("images/bg-auth.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(92, 64, 51, 0.4);
            backdrop-filter: blur(3px);
        }

        .container {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 60px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-section img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            padding: 8px;
        }

        .logo-section h1 {
            color: white;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .header-btn {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 12px 32px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .header-btn:hover {
            background: white;
            color: #5C4033;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .auth-card {
            background: white;
            padding: 50px 60px;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 480px;
        }

        .auth-card h2 {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            color: #5C4033;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: #5C4033;
            box-shadow: 0 0 0 3px rgba(92, 64, 51, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            font-size: 18px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .remember-me label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            margin: 0;
        }

        .forgot-password {
            color: #5C4033;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #5C4033;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 30px;
        }

        .submit-btn:hover {
            background: #4A3329;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(92, 64, 51, 0.3);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #ddd;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #999;
            font-size: 14px;
        }

        .social-login {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid #ddd;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .social-btn img {
            width: 24px;
            height: 24px;
        }

        .footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 25px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }

        @media (max-width: 768px) {
            .header {
                padding: 20px 30px;
            }

            .auth-card {
                padding: 40px 30px;
            }

            .logo-section h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-section">
                <img src="{{ asset('images/logo.png') }}" alt="KUESAENA">
                <h1>KUESAENA</h1>
            </div>
            <a href="{{ route('register') }}" class="header-btn">Daftar</a>
        </div>

        <div class="main-content">
            <div class="auth-card">
                <h2>MASUK</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="asep@example.com"
                               value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Sandi</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password"
                                   placeholder="••••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                👁️
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat Saya</label>
                        </div>
                        <a href="#" class="forgot-password">Lupa Sandi?</a>
                    </div>

                    <button type="submit" class="submit-btn">Masuk Akun</button>
                </form>

                <div class="divider">
                    <span>ATAU</span>
                </div>

                <div class="social-login">
                    <button class="social-btn" onclick="alert('Fitur Google login segera hadir!')">
                        <img src="https://cdn.cdnlogo.com/logos/g/35/google-icon.svg" alt="Google">
                    </button>
                    <button class="social-btn" onclick="alert('Fitur Facebook login segera hadir!')">
                        <img src="https://cdn.cdnlogo.com/logos/f/83/facebook.svg" alt="Facebook">
                    </button>
                </div>
            </div>
        </div>

        <footer class="footer">
            @ Copyright 2025, All Rights Reserved by Kuesaena
        </footer>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
        }
    </script>
</body>
</html>
