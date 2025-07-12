<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Sistem Arsip Surat</title>
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
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        
        .register-container {
            max-width: 500px;
            animation: fadeInDown 0.6s;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .register-header img {
            height: 80px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .register-header h2 {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .register-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .register-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            background: white;
        }
        
        .register-card:hover {
            transform: translateY(-5px);
        }
        
        .register-card-body {
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
        
        .btn-register {
            background-color: var(--primary-color);
            border: none;
            height: 48px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .password-strength {
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            margin-top: 0.25rem;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        
        .password-hints {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        
        .password-hints ul {
            padding-left: 1.25rem;
            margin-bottom: 0;
        }
        
        .password-hints li {
            margin-bottom: 0.25rem;
        }
        
        .password-hints li.valid {
            color: var(--success-color);
        }
        
        .password-hints li.valid::before {
            content: "✓ ";
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
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .register-card-body {
                padding: 1.5rem;
            }
            
            .register-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="register-container w-100">
        <div class="register-header">
            <img src="https://cdn-icons-png.flaticon.com/512/3713/3713996.png" alt="Document Archive Icon">
            <h2>Buat Akun Baru</h2>
            <p>Daftarkan diri Anda untuk mengakses Sistem Arsip Surat</p>
        </div>

        <div class="card register-card">
            <div class="card-body register-card-body">
                <!-- Flash messages -->
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


                <form action="/register" method="POST" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="form-floating-label mb-4">
                        <input type="text" name="full_name" id="full_name" class="form-control <?= ($validation->hasError('full_name')) ? 'is-invalid' : '' ?>" 
                               placeholder=" " value="<?= old('full_name') ?>" required>
                        <label for="full_name"><i class="bi bi-person-badge me-2"></i>Nama Lengkap</label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('full_name') ?: 'Harap masukkan nama lengkap Anda' ?>
                        </div>
                    </div>

                    <div class="form-floating-label mb-4">
                        <input type="text" name="username" id="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" 
                               placeholder=" " value="<?= old('username') ?>" required>
                        <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?: 'Harap masukkan username Anda' ?>
                        </div>
                    </div>

                    <div class="form-floating-label mb-4">
                        <input type="email" name="email" id="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                               placeholder=" " value="<?= old('email') ?>" required>
                        <label for="email"><i class="bi bi-envelope me-2"></i>Alamat Email</label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?: 'Harap masukkan alamat email yang valid' ?>
                        </div>
                    </div>

                    <div class="form-floating-label mb-3">
                        <input type="password" name="password" id="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                               placeholder=" " required>
                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?: 'Harap masukkan password yang kuat' ?>
                        </div>
                        <div class="password-strength mt-2">
                            <div class="password-strength-bar" id="password-strength-bar"></div>
                        </div>
                        <div class="password-hints">
                            <ul>
                                <li id="length-requirement">Minimal 6 karakter atau lebih</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-floating-label mb-4">
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control <?= ($validation->hasError('password_confirm')) ? 'is-invalid' : '' ?>" 
                               placeholder=" " required>
                        <label for="password_confirm"><i class="bi bi-lock-fill me-2"></i>Konfirmasi Password</label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('password_confirm') ?: 'Konfirmasi password harus sama dengan password' ?>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui <a href="#">Syarat dan Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-register">
                            <i class="bi bi-check-circle me-2"></i> Daftar Sekarang
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="mb-0">Sudah punya akun? <a href="/login">Masuk disini</a></p>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <small>&copy; <?= date('Y') ?> Sistem Arsip Surat. All rights reserved.</small>
        </div>
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
    
    // Password strength meter
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('password-strength-bar');
        const lengthReq = document.getElementById('length-requirement');
        const upperReq = document.getElementById('uppercase-requirement');
        const numberReq = document.getElementById('number-requirement');
        const specialReq = document.getElementById('special-requirement');
        
        // Reset classes
        [lengthReq, upperReq, numberReq, specialReq].forEach(el => el.classList.remove('valid'));
        
        let strength = 0;
        
        // Check length
        if (password.length >= 6) {
            strength += 25;
            lengthReq.classList.add('valid');
        }
        
        
        
        // Update strength bar
        strengthBar.style.width = strength + '%';
        
        // Update color based on strength
        if (strength < 50) {
            strengthBar.style.backgroundColor = '#ff4444'; // Red
        } else if (strength < 75) {
            strengthBar.style.backgroundColor = '#ffbb33'; // Yellow
        } else {
            strengthBar.style.backgroundColor = '#00C851'; // Green
        }
    });
    
    // Confirm password matching
    document.getElementById('password_confirm').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        if (confirmPassword && password !== confirmPassword) {
            this.setCustomValidity('Password tidak cocok');
        } else {
            this.setCustomValidity('');
        }
    });
    
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