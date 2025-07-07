<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Sistem Arsip Surat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(to right, #e0f7fa, #ffffff);
    }

    .register-card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    .form-label {
      font-weight: 500;
    }

    .register-title h3 {
      font-weight: bold;
      color: #0d6efd;
    }

    .register-title p {
      color: #6c757d;
    }

    .btn-primary {
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="container py-5" style="min-height: 100vh;">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6 col-lg-5">
        <div class="text-center register-title mb-4">
          <h3><i class="bi bi-person-plus"></i> Registrasi Pengguna</h3>
          <p class="mb-0">Sistem Arsip Surat</p>
        </div>

        <div class="card register-card">
          <div class="card-body p-4">
            <?php if (session()->getFlashdata('message')): ?>
              <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (isset($validation)) : ?>
              <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
            <?php endif; ?>

            <form action="/register" method="POST">
              <?= csrf_field() ?>

              <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" name="full_name" class="form-control <?= ($validation->hasError('full_name')) ? 'is-invalid' : '' ?>" value="<?= old('full_name') ?>">
                <div class="invalid-feedback"><?= $validation->getError('full_name') ?></div>
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" value="<?= old('username') ?>">
                <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" value="<?= old('email') ?>">
                <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
              </div>

              <div class="mb-3">
                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirm" class="form-control <?= ($validation->hasError('password_confirm')) ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= $validation->getError('password_confirm') ?></div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-circle"></i> Daftar
                </button>
              </div>
            </form>

            <p class="mt-3 text-center">
              Sudah punya akun? <a href="/login">Login di sini</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
