<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />
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
            <h2 class="h4 mb-1"><i class="bi bi-person-gear me-2 text-primary"></i>Edit User</h2>
        </div>
        <div>
            <a href="/admin/users" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="/admin/users/update/<?= $userData['id'] ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" 
                                id="username" name="username" value="<?= old('username', $userData['username']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                                id="password" name="password" placeholder="Kosongkan jika tidak diubah">
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control <?= ($validation->hasError('full_name')) ? 'is-invalid' : '' ?>" 
                                id="full_name" name="full_name" value="<?= old('full_name', $userData['full_name']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('full_name') ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>" 
                                id="role" name="role">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= old('role', $userData['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="operator" <?= old('role', $userData['role']) == 'operator' ? 'selected' : '' ?>>Operator</option>
                                <option value="user" <?= old('role', $userData['role']) == 'user' ? 'selected' : '' ?>>User Biasa</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('role') ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                        id="email" name="email" value="<?= old('email', $userData['email']) ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email') ?>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="/admin/users" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>