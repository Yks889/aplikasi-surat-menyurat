<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah User</h3>
    </div>
    <div class="card-body">
        <form action="/admin/users/simpan" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" 
                            id="username" name="username" value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                            id="password" name="password">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="full_name">Nama Lengkap</label>
                        <input type="text" class="form-control <?= ($validation->hasError('full_name')) ? 'is-invalid' : '' ?>" 
                            id="full_name" name="full_name" value="<?= old('full_name') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('full_name') ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>" 
                            id="role" name="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="operator" <?= old('role') == 'operator' ? 'selected' : '' ?>>Operator</option>
                            <option value="user" <?= old('role') == 'user' ? 'selected' : '' ?>>User Biasa</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('role') ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                    id="email" name="email" value="<?= old('email') ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('email') ?>
                </div>
            </div>
            
            <div class="form-group mt-3">
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