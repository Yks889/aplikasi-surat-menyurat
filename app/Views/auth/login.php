<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />
    <title>Login | Sistem Arsip Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4bb543;
            --error-color: #ff3333;
            --labubu-pink: #FF9EB5;
            --labubu-purple: #B28DFF;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* Animasi floating elements */
        .floating-element {
            position: absolute;
            opacity: 0.15;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 5%;
            width: 60px;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            left: 80%;
            width: 80px;
            animation-delay: 1s;
        }

        .floating-element:nth-child(3) {
            top: 30%;
            left: 75%;
            width: 50px;
            animation-delay: 2s;
        }

        .floating-element:nth-child(4) {
            top: 80%;
            left: 10%;
            width: 70px;
            animation-delay: 3s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        /* Labubu character */
        .labubu-character {
            position: absolute;
            width: 120px;
            bottom: 20px;
            right: 20px;
            z-index: 1;
            transform-origin: bottom center;
            animation: labubuBounce 2s ease infinite;
        }

        @keyframes labubuBounce {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .login-container {
            width: 100%;
            max-width: 360px;
            animation: fadeInDown 0.6s;
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .login-header img {
            height: 90px;
            margin-bottom: 0.75rem;
            transition: transform 0.3s ease;
        }

        .login-header img:hover {
            transform: rotate(5deg) scale(1.05);
        }

        .login-header h1 {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
            font-size: 1.5rem;
        }

        .login-header p {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
            position: relative;
        }

        .login-card:hover {
            transform: translateY(-5px) rotate(1deg);
            box-shadow: 0 12px 30px rgba(67, 97, 238, 0.15);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--labubu-pink), var(--labubu-purple), var(--primary-color));
            background-size: 200% 100%;
            animation: gradientBG 3s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .login-card-body {
            padding: 1.75rem;
        }

        .form-control {
            height: 44px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding-left: 15px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            transform: translateY(-2px);
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            height: 44px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .btn-login:hover::after {
            left: 100%;
        }

        .form-floating-label {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .form-floating-label input {
            width: 100%;
            padding: 1rem 1rem 0.5rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            height: 44px;
            font-size: 0.9rem;
        }

        .form-floating-label label {
            position: absolute;
            top: 13px;
            left: 15px;
            color: #adb5bd;
            transition: all 0.2s;
            pointer-events: none;
            font-size: 0.9rem;
        }

        .form-floating-label input:focus+label,
        .form-floating-label input:not(:placeholder-shown)+label {
            top: 5px;
            left: 15px;
            font-size: 0.7rem;
            color: var(--primary-color);
        }

        .brand-name {
            background: linear-gradient(135deg, var(--labubu-pink), var(--labubu-purple), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            font-weight: 800;
            animation: gradientText 3s ease infinite;
            background-size: 200% 200%;
        }

        @keyframes gradientText {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .footer-text {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 1.5rem;
            animation: fadeIn 2s ease;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .forgot-link {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-link:hover {
            color: var(--primary-color);
            transform: translateX(3px);
        }

        .forgot-link::after {
            content: '→';
            position: absolute;
            right: -15px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .forgot-link:hover::after {
            opacity: 1;
            right: -20px;
        }

        .register-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.85rem;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-link a:hover {
            color: var(--labubu-purple);
            text-decoration: none;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--labubu-pink);
            transition: width 0.3s ease;
        }

        .register-link a:hover::after {
            width: 100%;
        }

        /* Alert styles */
        .alert {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
            transition: all 0.5s ease;
            transform-origin: top;
        }

        .alert.show {
            animation: alertPop 0.5s ease;
        }

        @keyframes alertPop {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            70% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card-body {
                padding: 1.5rem;
            }

            .labubu-character {
                width: 80px;
                bottom: 10px;
                right: 10px;
            }

            .floating-element {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Floating decorative elements -->
    <img src="<?= base_url('uploads/logo.png') ?>" class="floating-element animate__animated animate__fadeIn" alt="Labubu character">
    <img src="<?= base_url('uploads/logo.png') ?>" class="floating-element animate__animated animate__fadeIn" alt="Labubu character">
    <img src="<?= base_url('uploads/logo.png') ?>" class="floating-element animate__animated animate__fadeIn" alt="Labubu character">
    <img src="<?= base_url('uploads/logo.png') ?>" class="floating-element animate__animated animate__fadeIn" alt="Labubu character">
    <img src="<?= base_url('uploads/logo.png') ?>" class="floating-element animate__animated animate__fadeIn" alt="Labubu character">
    <img src="<?= base_url('uploads/logo.png') ?>" class="floating-element animate__animated animate__fadeIn" alt="Labubu character">

    <!-- Labubu character -->
    <img src="<?= base_url('uploads/logo1.png') ?>" class="labubu-character animate__animated animate__bounceInUp" alt="Labubu character">

    <div class="login-container animate__animated animate__fadeIn">
        <div class="login-header">
            <img src="/uploads/logo.png" alt="Logo Sistem Arsip Surat" class="logo-img animate__animated animate__rotateIn">
            <h1>Arsip Surat <span class="brand-name">Gonet</span></h1>
            <p class="animate__animated animate__fadeIn">Masuk untuk mengakses sistem</p>
        </div>

        <div class="card login-card">
            <div class="card-body login-card-body">
                <!-- Flashdata messages -->
                <?php if (session()->getFlashdata('message')) : ?>
                    <div class="alert alert-success alert-dismissible fade show show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= session()->getFlashdata('message') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0" style="font-size: 0.85rem;">
                            <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>

                <form action="/login" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="form-floating-label mb-3 animate__animated animate__fadeInLeft">
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                            name="username" placeholder=" " value="<?= old('username') ?>" required>
                        <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                            <?= $validation->getError('username') ?: 'Harap masukkan username Anda' ?>
                        </div>
                    </div>

                    <div class="form-floating-label mb-3 animate__animated animate__fadeInRight">
                        <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                            name="password" placeholder=" " required>
                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                            <?= $validation->getError('password') ?: 'Harap masukkan password Anda' ?>
                        </div>
                    </div>

                    <div class="remember-forgot mb-3 animate__animated animate__fadeInUp">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe" style="font-size: 0.85rem;">
                                Ingat saya
                            </label>
                        </div>
                        <a href="/forgot-password" class="forgot-link">Lupa password?</a>
                    </div>

                    <div class="d-grid mb-3 animate__animated animate__fadeInUp">
                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                        </button>
                    </div>

                    <div class="register-link animate__animated animate__fadeInUp">
                        Belum punya akun? <a href="/register">Daftar sekarang</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="footer-text text-center animate__animated animate__fadeIn">
            &copy; <?= date('Y') ?> Sistem Arsip Surat. All rights reserved.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function() {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Add animation to alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert.show');
            alerts.forEach(alert => {
                alert.classList.add('show');
            });

            // Make Labubu interactive
            const labubu = document.querySelector('.labubu-character');
            if (labubu) {
                labubu.addEventListener('click', function() {
                    this.classList.add('animate__animated', 'animate__tada');
                    setTimeout(() => {
                        this.classList.remove('animate__animated', 'animate__tada');
                    }, 1000);
                });
            }
        });
    </script>
</body>

</html>