<?= $this->extend('layouts/operator') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5>Edit User Biasa</h5>
    </div>
    <div class="card-body">
        <?= view('components/alert') ?>

        <form action="/operator/users/update/<?= $userData['id'] ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" value="<?= old('username', $userData['username']) ?>">
                <div class="invalid-feedback"><?= $errors['username'] ?? '' ?></div>
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" name="full_name" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" value="<?= old('full_name', $userData['full_name']) ?>">
                <div class="invalid-feedback"><?= $errors['full_name'] ?? '' ?></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email (Opsional)</label>
                <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= old('email', $userData['email']) ?>">
                <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (Opsional - kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= $errors['password'] ?? '' ?></div>
            </div>

            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Perubahan</button>
            <a href="/operator/users" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
