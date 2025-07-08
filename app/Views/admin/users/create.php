<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $validation = session('validation') ?? \Config\Services::validation(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah User</h3>
    </div>
    <div class="card-body">
        <form action="/admin/users/simpan" method="post">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username"
                        value="<?= old('username') ?>"
                        class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('username') ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('password') ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="full_name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name"
                        value="<?= old('full_name') ?>"
                        class="form-control <?= $validation->hasError('full_name') ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('full_name') ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role"
                        class="form-select <?= $validation->hasError('role') ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="operator" <?= old('role') == 'operator' ? 'selected' : '' ?>>Operator</option>
                        <option value="user" <?= old('role') == 'user' ? 'selected' : '' ?>>User Biasa</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('role') ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="email" class="form-label">Email (opsional)</label>
                    <input type="email" name="email" id="email"
                        value="<?= old('email') ?>"
                        class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email') ?>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="/admin/users" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
