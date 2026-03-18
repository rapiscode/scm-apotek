<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Apotek Saya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            background: linear-gradient(90deg, #5ea2ff 0%, #0d6efd 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 760px;
            padding: 24px;
        }

        .login-card {
            background: #fff;
            border-radius: 30px;
            padding: 85px 70px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.14);
        }

        .login-title {
            text-align: center;
            font-size: 44px;
            font-weight: 700;
            color: #111;
            margin-bottom: 60px;
        }

        .form-control.custom-input {
            border: none;
            border-bottom: 1px solid #d9d9d9;
            border-radius: 0;
            padding-left: 0;
            padding-right: 35px;
            padding-top: 16px;
            padding-bottom: 16px;
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
            padding-top: 16px;
            padding-bottom: 16px;
            font-size: 16px;
            background: transparent;
        }

        .input-group.custom-group .btn {
            border: none !important;
            background: transparent !important;
            color: #8c8c8c;
            box-shadow: none !important;
            padding-right: 10px;
            font-size: 26px;
        }

        .btn-login {
            background: #3d84f7;
            border: none;
            border-radius: 999px;
            font-size: 16px;
            font-weight: 600;
            padding: 15px;
            color: white;
            transition: 0.2s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #2e73e6;
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9a9a9a;
            font-size: 16px;
            margin: 36px 0 28px;
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
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: 1px solid #d9d9d9;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 26px;
            text-decoration: none;
            margin: 0 auto;
            transition: 0.2s ease;
        }

        .google-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        .signup-text {
            text-align: center;
            font-size: 17px;
            color: #8a8a8a;
            margin-top: 32px;
        }

        .signup-text a {
            color: #3d84f7;
            font-weight: 500;
            text-decoration: none;
            transition: 0.2s
        }

        .signup-text a:hover {
            text-decoration: underline;
        }

        .alert {
            font-size: 14px;
            border-radius: 10px;
        }

        @media (max-width: 576px) {
            .login-wrapper {
                max-width: 100%;
                padding: 18px;
            }

            .login-card {
                padding: 45px 28px;
                border-radius: 22px;
            }

            .login-title {
                font-size: 32px;
                margin-bottom: 36px;
            }

            .form-control.custom-input,
            .input-group.custom-group .form-control {
                font-size: 14px;
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .btn-login {
                font-size: 15px;
                padding: 13px;
            }

            .google-btn {
                width: 50px;
                height: 50px;
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card">

            <h2 class="login-title">Login</h2>

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

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

                <button type="submit" class="btn btn-login w-100">
                    Sign In
                </button>
            </form>

            <div class="divider">Or Sign In With</div>

            <a href="#" class="google-btn">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="24" />
            </a>

            <div class="signup-text">
                Belum Punya Akun?
                <a href="{{ route('register') }}">Sign Up</a>
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