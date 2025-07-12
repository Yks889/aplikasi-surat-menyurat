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
            max-width: 420px;
            animation: fadeInDown 0.6s;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header img {
            height: 80px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .login-header h1 {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
            background: white;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
        }
        
        .login-card-body {
            padding: 2.5rem;
        }
        
        .form-control {
            height: 48px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding-left: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        .input-group-text {
            background-color: white;
            border-left: none;
            color: #adb5bd;
        }
        
        .input-group .form-control {
            border-right: none;
        }
        
        .input-group .form-control:focus + .input-group-text {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-login {
            background-color: var(--primary-color);
            border: none;
            height: 48px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #adb5bd;
            font-size: 0.8rem;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .divider::before {
            margin-right: 1rem;
        }
        
        .divider::after {
            margin-left: 1rem;
        }
        
        .footer-links {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        /* Alert animations */
        .alert {
            border-radius: 8px;
            border-left: 4px solid;
            animation: fadeIn 0.5s;
        }
        
        .alert-success {
            border-left-color: var(--success-color);
        }
        
        .alert-danger {
            border-left-color: var(--error-color);
        }
        
        /* Floating label effect */
        .form-floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-floating-label input {
            width: 100%;
            padding: 1rem 1rem 0.5rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            height: 48px;
            font-size: 1rem;
        }
        
        .form-floating-label label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: #adb5bd;
            transition: all 0.2s;
            pointer-events: none;
        }
        
        .form-floating-label input:focus + label,
        .form-floating-label input:not(:placeholder-shown) + label {
            top: 5px;
            left: 15px;
            font-size: 0.75rem;
            color: var(--primary-color);
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card-body {
                padding: 1.5rem;
            }
            
            .login-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="login-container animate__animated animate__fadeIn">
    <div class="login-header">
        <img src="https://cdn-icons-png.flaticon.com/512/3713/3713996.png" alt="Document Archive Icon">
        <h1>Sistem Arsip Surat</h1>
        <p>Masuk untuk mengakses sistem arsip surat digital</p>
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
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <form action="/login" method="post" class="needs-validation" novalidate>
                <?= csrf_field() ?>

                <div class="form-floating-label mb-4">
                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                           name="username" placeholder=" " value="<?= old('username') ?>" required>
                    <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('username') ?: 'Harap masukkan username Anda' ?>
                    </div>
                </div>

                <div class="form-floating-label mb-4">
                    <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                           name="password" placeholder=" " required>
                    <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('password') ?: 'Harap masukkan password Anda' ?>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                    </button>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">
                        Ingat saya
                    </label>
                    <a href="/register" class ="btn btn-link float-end"><i class="bi bi-person-plus-fill"></i>Daftar Sekarang</a>
                </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted">
        <small>&copy; <?= date('Y') ?> Sistem Arsip Surat. All rights reserved.</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Form validation
    (function () {
        'use strict'
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
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
    
    // Add animation to input focus
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('animate__animated', 'animate__pulse', 'animate__faster');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('animate__animated', 'animate__pulse', 'animate__faster');
        });
    });
</script>
</body>
</html>