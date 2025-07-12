<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Notification Alert -->
    <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div><?= session()->getFlashdata('message') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-pen me-2 text-primary"></i>Tanda Tangan Digital</h2>
        </div>
    </div>

    <!-- Signature Cards -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <?php foreach ($tandaTangan as $ttd): ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h5 class="card-title fs-5 mb-0"><?= $ttd['full_name'] ?></h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="/uploads/tanda_tangan/<?= $ttd['file'] ?>" 
                                 alt="Tanda Tangan <?= $ttd['full_name'] ?>" 
                                 class="img-fluid" 
                                 style="max-height: 150px;">
                            <p class="mt-2 text-muted small">
                                Diupload pada: <?= date('d/m/Y H:i', strtotime($ttd['uploaded_at'])) ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white text-center">
                            <button onclick="confirmDelete(<?= $ttd['id'] ?>)" 
                                    class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h4 class="h5 mb-0"><i class="bi bi-upload me-2"></i>Upload Tanda Tangan Baru</h4>
        </div>
        <div class="card-body">
            <form action="/admin/tanda-tangan/upload" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Admin</label>
                            <select class="form-select <?= ($validation->hasError('user_id')) ? 'is-invalid' : '' ?>" 
                                id="user_id" name="user_id" required>
                                <option value="">-- Pilih Admin --</option>
                                <?php foreach ($admins as $admin): ?>
                                <option value="<?= $admin['id'] ?>" <?= old('user_id') == $admin['id'] ? 'selected' : '' ?>>
                                    <?= $admin['full_name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('user_id') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="file_ttd" class="form-label">File Tanda Tangan</label>
                            <input type="file" class="form-control <?= ($validation->hasError('file_ttd')) ? 'is-invalid' : '' ?>" 
                                id="file_ttd" name="file_ttd" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('file_ttd') ?>
                            </div>
                            <small class="text-muted">Format: JPEG/PNG, Maksimal 1MB</small>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Show selected filename
    document.querySelector('#file_ttd').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        e.target.nextElementSibling.textContent = fileName;
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Tanda Tangan?',
            text: "Tanda tangan akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/tanda-tangan/delete/' + id;
            }
        });
    }
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>