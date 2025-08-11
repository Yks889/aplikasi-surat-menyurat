<?= $this->extend('layouts/operator') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
     <!-- Watermark Background - Adjusted for sidebar -->
    <div class="position-fixed top-0 start-0 w-100 h-100" style="
        background-image: url('/uploads/logo.png');
        background-repeat: no-repeat;
        background-position: calc(50% + 140px) calc(40% + 40px);
        background-size: 55%;
        opacity: 0.10;
        pointer-events: none;
        z-index: -1;
    "></div>
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-person-gear me-2 text-primary"></i>Edit User Biasa</h2>
        </div>
        <div>
            <a href="/operator/users" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?= view('components/alert') ?>
            
            <form action="/operator/users/update/<?= $userData['id'] ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" 
                                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                value="<?= old('username', $userData['username']) ?>">
                            <div class="invalid-feedback"><?= $errors['username'] ?? '' ?></div>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="full_name" 
                                class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" 
                                value="<?= old('full_name', $userData['full_name']) ?>">
                            <div class="invalid-feedback"><?= $errors['full_name'] ?? '' ?></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email (Opsional)</label>
                            <input type="email" name="email" 
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                value="<?= old('email', $userData['email']) ?>">
                            <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" 
                                class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                            <div class="invalid-feedback"><?= $errors['password'] ?? '' ?></div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="/operator/users" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>