<?= $this->extend('layouts/user'); ?>

<?= $this->section('content'); ?>
<?php $validation = session('validation') ?? \Config\Services::validation(); ?>
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
            <h2 class="h4 mb-1"><i class="bi bi-person me-2 text-primary"></i>Profil Pengguna</h2>
        </div>
    </div>

    <?php if (session()->get('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->get('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->get('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->get('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri - Foto Profil -->
                <div class="col-md-4 text-center">
                    <?php if ($user['photo']) : ?>
                        <img src="<?= base_url('uploads/profiles/' . $user['photo']) ?>" class="rounded-circle mb-3" width="150" height="150" alt="Foto Profil">
                    <?php else : ?>
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; margin: 0 auto;">
                            <i class="bi bi-person" style="font-size: 4rem; color: #6c757d;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/user/profile/update-photo" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Unggah Foto Baru</label>
                            <input class="form-control <?= $validation->hasError('photo') ? 'is-invalid' : '' ?>" 
                                type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg">
                            <div class="invalid-feedback">
                                <?= $validation->getError('photo') ?>
                            </div>
                            <small class="form-text text-muted">Format: JPG/PNG, maks 2MB</small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i> Unggah Foto
                            </button>
                            
                            <?php if ($user['photo']) : ?>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmRemovePhoto()">
                                    <i class="bi bi-trash me-1"></i> Hapus Foto
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                    
                    <?php if ($user['photo']) : ?>
                        <form id="removePhotoForm" action="/user/profile/remove-photo" method="post" class="d-none">
                            <?= csrf_field() ?>
                        </form>
                    <?php endif; ?>
                </div>
                
                <!-- Kolom Kanan - Form Data -->
                <div class="col-md-8">
                    <form action="<?= base_url('user/profile/update-photo') ?>" method="post">

                        <?= csrf_field() ?>
                        
                        <h5 class="mb-4"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Profil</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                                    id="username" name="username" value="<?= old('username', $user['username']) ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control <?= $validation->hasError('full_name') ? 'is-invalid' : '' ?>" 
                                    id="full_name" name="full_name" value="<?= old('full_name', $user['full_name']) ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('full_name') ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                                id="email" name="email" value="<?= old('email', $user['email']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <form action="/user/profile/update-password" method="post">

                        <?= csrf_field() ?>
                        
                        <h5 class="mb-4"><i class="bi bi-shield-lock me-2 text-primary"></i>Ubah Password</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control <?= $validation->hasError('current_password') ? 'is-invalid' : '' ?>" 
                                    id="current_password" name="current_password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('current_password') ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control <?= $validation->hasError('new_password') ? 'is-invalid' : '' ?>" 
                                    id="new_password" name="new_password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('new_password') ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control <?= $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>" 
                                    id="confirm_password" name="confirm_password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('confirm_password') ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-key me-1"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmRemovePhoto() {
    Swal.fire({
        title: 'Hapus Foto Profil?',
        text: "Anda yakin ingin menghapus foto profil?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('removePhotoForm').submit();
        }
    });
}
</script>
<?= $this->endSection(); ?>