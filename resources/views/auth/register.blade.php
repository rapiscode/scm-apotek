<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | Apotek Saya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            background: #ffffff;
        }

        .register-page {
            min-height: 100vh;
            display: flex;
        }

        .register-left {
            width: 42%;
            background: linear-gradient(180deg, #5ea2ff 0%, #0d6efd 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
        }

        .register-left h1 {
            font-size: 34px;
            font-weight: 700;
            line-height: 1.3;
            max-width: 470px;
            margin-bottom: 30px;
        }

        .register-left img {
            max-width: 360px;
            width: 100%;
            height: auto;
        }

        .register-right {
            width: 58%;
            background: #fff;
            border-top-left-radius: 42px;
            border-bottom-left-radius: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
        }

        .register-card {
            width: 100%;
            max-width: 560px;
        }

        .register-title {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            margin-bottom: 40px;
        }

        .form-control.custom-input {
            border: none;
            border-bottom: 1px solid #d9d9d9;
            border-radius: 0;
            padding-left: 0;
            padding-right: 35px;
            padding-top: 14px;
            padding-bottom: 14px;
            font-size: 16px;
            box-shadow: none !important;
            background: transparent;
        }

        .form-control.custom-input:focus {
            border-bottom: 1px solid #0d6efd;
        }

        .input-group.custom-group {
            border-bottom: 1px solid #d9d9d9;
            align-items: center;
        }

        .input-group.custom-group .form-control {
            border: none !important;
            box-shadow: none !important;
            padding-left: 0;
            padding-top: 14px;
            padding-bottom: 14px;
            font-size: 16px;
            background: transparent;
        }

        .input-group.custom-group .btn {
            border: none !important;
            background: transparent !important;
            color: #8c8c8c;
            box-shadow: none !important;
            padding-right: 0;
        }

        .input-group.custom-group .btn i {
            font-size: 22px;
            transform: translateX(-4px);
        }

        .terms-text {
            font-size: 14px;
            color: #7d7d7d;
        }

        .terms-text a {
            color: #3d84f7;
            text-decoration: none;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        .btn-signup {
            background: #3d84f7;
            border: none;
            border-radius: 999px;
            font-size: 18px;
            font-weight: 600;
            padding: 14px;
            color: white;
            transition: 0.2s ease;
        }

        .btn-signup:hover {
            background: #2e73e6;
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9a9a9a;
            font-size: 14px;
            margin: 34px 0 28px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #d9d9d9;
        }

        .divider:not(:empty)::before {
            margin-right: 14px;
        }

        .divider:not(:empty)::after {
            margin-left: 14px;
        }

        .google-btn {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            border: 1px solid #d9d9d9;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            margin: 0 auto;
            transition: 0.2s ease;
        }

        .google-btn img {
            width: 26px;
            height: 26px;
        }

        .google-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        .signin-text {
            text-align: center;
            font-size: 14px;
            color: #8a8a8a;
            margin-top: 28px;
        }

        .signin-text a {
            color: #3d84f7;
            text-decoration: none;
            position: relative;
        }

        .signin-text a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 0;
            height: 1.5px;
            background: #3d84f7;
            transition: 0.3s;
        }

        .signin-text a:hover::after {
            width: 100%;
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        @media (max-width: 992px) {
            .register-page {
                flex-direction: column;
            }

            .register-left,
            .register-right {
                width: 100%;
                border-radius: 0;
            }

            .register-left {
                padding: 50px 25px 30px;
            }

            .register-left h1 {
                font-size: 28px;
                max-width: 100%;
            }

            .register-left img {
                max-width: 240px;
            }

            .register-right {
                padding: 35px 20px 50px;
            }

            .register-title {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <div class="register-page">
        <div class="register-left">
            <h1>Biar urusan apotek lebih gampang dan teratur</h1>

            <img src="{{ asset('images/register-apotek.png') }}" alt="Ilustrasi Apotek">
        </div>

        <div class="register-right">
            <div class="register-card">
                <h2 class="register-title">Create Account</h2>

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.process') }}">
                    @csrf

                    <div class="mb-4">
                        <input
                            type="text"
                            name="name"
                            class="form-control custom-input"
                            placeholder="Full Name"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <input
                            type="email"
                            name="email"
                            class="form-control custom-input"
                            placeholder="Email Address"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <div class="input-group custom-group">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Password"
                                required
                            >
                            <button type="button" class="btn" onclick="togglePassword()">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="agree" required>
                        <label class="form-check-label terms-text" for="agree">
                            I agree to the <a href="#">terms of service</a> and <a href="#">privacy policy</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-signup w-100">
                        Sign Up
                    </button>
                </form>

                <div class="divider">Or Sign Up With</div>

                <a href="#" class="google-btn">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                </a>

                <div class="signin-text">
                    Sudah Punya Akun?
                    <a href="{{ route('login') }}">Sign In</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>

</body>
</html>