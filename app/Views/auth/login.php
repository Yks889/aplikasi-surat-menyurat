<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | Sistem Arsip Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-wrapper {
            display: flex;
            max-width: 950px;
            width: 100%;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
        }

        .login-left {
            flex: 1;
            display: flex;
            background-image: url(/uploads/bg-login.png);
            background-size: cover;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 100px;
        }

        .login-right h2 {
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }

        .login-right p {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .btn-login {
            width: 100%;
            height: 48px;
            border-radius: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #4a6cf7, #6c8ff7);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #3c5edc, #5c7de6);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.95rem;
        }

        .register-link a {
            color: #4a6cf7;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            font-size: 0.8rem;
            color: #aaa;
            margin-top: 20px;
        }

        .brand-name {
            background: linear-gradient(135deg, #3f37c9, #4361ee, #4cc9f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        /* Animasi fade-in + slide */
        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-wrapper {
            animation: fadeSlideIn 1s ease-out;
        }

        .floating-element {
            position: absolute;
            opacity: 0.15;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 5%;
            left: 5%;
            width: 50px;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 10%;
            left: 80%;
            width: 70px;
            animation-delay: 0.5s;
        }

        .floating-element:nth-child(3) {
            top: 20%;
            left: 60%;
            width: 60px;
            animation-delay: 1s;
        }

        .floating-element:nth-child(4) {
            top: 35%;
            left: 15%;
            width: 80px;
            animation-delay: 1.5s;
        }

        .floating-element:nth-child(5) {
            top: 50%;
            left: 85%;
            width: 50px;
            animation-delay: 2s;
        }

        .floating-element:nth-child(6) {
            top: 65%;
            left: 10%;
            width: 75px;
            animation-delay: 2.5s;
        }

        .floating-element:nth-child(7) {
            top: 75%;
            left: 60%;
            width: 60px;
            animation-delay: 3s;
        }

        .floating-element:nth-child(8) {
            top: 85%;
            left: 30%;
            width: 50px;
            animation-delay: 3.5s;
        }

        .floating-element:nth-child(9) {
            top: 40%;
            left: 45%;
            width: 65px;
            animation-delay: 4s;
        }

        .floating-element:nth-child(10) {
            top: 90%;
            left: 80%;
            width: 55px;
            animation-delay: 4.5s;
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

        .gonet-brand {
            position: absolute;
            width: 120px;
            bottom: 20px;
            right: 20px;
            z-index: 1;
            transform-origin: bottom center;
            animation: gonetBounce 2s ease infinite;
        }

        @keyframes gonetBounce {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }
    </style>
</head>

<body>
    <!-- Floating decorative elements -->
    <?php for ($i = 1; $i <= 10; $i++): ?>
        <img src="<?= base_url('uploads/logo.png') ?>" class="floating-element animate__animated animate__fadeIn" alt="Gonet Logo">
    <?php endfor; ?>

    <img src="<?= base_url('uploads/logo1.png') ?>" class="gonet-brand animate__animated animate__bounceInUp" alt="gonet-brand">

    <div class="login-wrapper">
        <!-- Bagian kiri -->
        <div class="login-left">
        </div>

        <!-- Bagian kanan -->
        <div class="login-right">
            <div class="logo">
                <img src="<?= base_url('uploads/logo.png'); ?>" alt="Logo">
            </div>
            <h2>Arsip Surat <span class="brand-name">Gonet</span></h2>
            <p>Masuk untuk mengakses sistem</p>

            <!-- Flash Message -->
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('message'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="<?= base_url('login'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username"
                        value="<?= old('username'); ?>" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>
                <button type="submit" class="btn-login"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
            </form>

            <!-- Link Register -->
            <div class="register-link">
                Belum punya akun? <a href="<?= base_url('register'); ?>">Daftar sekarang</a>
            </div>

            <footer>© <?= date('Y'); ?> Sistem Arsip Surat. All rights reserved.</footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert.show');
            alerts.forEach(alert => {
                alert.classList.add('show');
            });

            const gonet = document.querySelector('.gonet-brand');
            if (gonet) {
                gonet.addEventListener('click', function() {
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