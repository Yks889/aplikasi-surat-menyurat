<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        
        .login-container {
            width: 100%;
            max-width: 360px;
            animation: fadeInDown 0.6s;
            padding: 0 15px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .login-header img {
            height: 60px;
            margin-bottom: 0.75rem;
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
            transition: transform 0.3s ease;
            background: white;
        }
        
        .login-card:hover {
            transform: translateY(-3px);
        }
        
        .login-card-body {
            padding: 1.75rem;
        }
        
        .form-control {
            height: 44px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding-left: 15px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .btn-login {
            background-color: var(--primary-color);
            border: none;
            height: 44px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            border: none;
            height: 44px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        
        .btn-login:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
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
        
        .form-floating-label input:focus + label,
        .form-floating-label input:not(:placeholder-shown) + label {
            top: 5px;
            left: 15px;
            font-size: 0.7rem;
            color: var(--primary-color);
        }
        
        .brand-name {
            background: linear-gradient(135deg, #3f37c9, #4361ee, #4cc9f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            font-weight: 800;
        }
       
        .footer-text {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 1.5rem;
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
            transition: color 0.2s;
        }
        
        .forgot-link:hover {
            color: var(--primary-color);
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
            transition: all 0.2s;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        /* Alert styles */
        .alert {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="login-container animate__animated animate__fadeIn">
    <div class="login-header">
        <img src="/uploads/logo.png" alt="Logo Sistem Arsip Surat" class="logo-img">
        <h1>Arsip Surat <span class="brand-name">Gonet</span></h1>
        <p>Masuk untuk mengakses sistem</p>
    </div>

    <div class="card login-card">
        <div class="card-body login-card-body">
            <!-- Flashdata messages -->
            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

                <div class="form-floating-label mb-3">
                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                           name="username" placeholder=" " value="<?= old('username') ?>" required>
                    <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <?= $validation->getError('username') ?: 'Harap masukkan username Anda' ?>
                    </div>
                </div>

                <div class="form-floating-label mb-3">
                    <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                           name="password" placeholder=" " required>
                    <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <?= $validation->getError('password') ?: 'Harap masukkan password Anda' ?>
                    </div>
                </div>

                <div class="remember-forgot mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe" style="font-size: 0.85rem;">
                            Ingat saya
                        </label>
                    </div>
             
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                    </button>
                </div>

                <div class="register-link">
                    Belum punya akun? <a href="/register">Daftar sekarang</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="footer-text text-center">
        &copy; <?= date('Y') ?> Sistem Arsip Surat. All rights reserved.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Form validation
    (function () {
        'use strict'
        
        var forms = document.querySelectorAll('.needs-validation')
        
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
</body>
</html>