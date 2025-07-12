<?= $this->extend('layouts/operator') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah User Biasa</h3>
    </div>
    <div class="card-body">

        <!-- FLASH MESSAGE -->
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- VALIDASI -->
        <?php $validation = session('validation') ?? \Config\Services::validation(); ?>


        <form action="/operator/users/simpan" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" 
                            id="username" name="username" value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                            id="password" name="password">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name">Nama Lengkap</label>
                        <input type="text" class="form-control <?= ($validation->hasError('full_name')) ? 'is-invalid' : '' ?>" 
                            id="full_name" name="full_name" value="<?= old('full_name') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('full_name') ?>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                            id="email" name="email" value="<?= old('email') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="role" value="user">

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="/operator/users" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
