<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Arsip Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .login-card-body {
            padding: 30px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-logo">
        <h2><b>Sistem</b> Arsip Surat</h2>
    </div>

    <div class="card login-card">
        <div class="card-body login-card-body">

            <!-- Flashdata messages -->
            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <form action="/login" method="post">
                <?= csrf_field() ?>

                <div class="input-group mb-3">
                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                           name="username" placeholder="Username" value="<?= old('username') ?>">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <div class="invalid-feedback">
                        <?= $validation->getError('username') ?>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                           name="password" placeholder="Password">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <div class="invalid-feedback">
                        <?= $validation->getError('password') ?>
                    </div>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </div>
            </form>

            <p class="mt-3 mb-1 text-center">
                <a href="#">Lupa password?</a>
            </p>
            <p class="mb-0 text-center">
                Belum punya akun? <a href="/register">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
