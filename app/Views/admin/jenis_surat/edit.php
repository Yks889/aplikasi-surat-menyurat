<?= $this->extend('layouts/admin') ?>
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
            <h2 class="h4 mb-1"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Edit Jenis Surat</h2>
        </div>
        <div>
            <a href="/admin/jenis-surat" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="/admin/jenis-surat/update/<?= $jenisSurat['id'] ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Nama Jenis Surat -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Jenis Surat</label>
                            <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" 
                                   id="nama" name="nama" 
                                   value="<?= old('nama', $jenisSurat['nama']) ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Singkatan -->
                        <div class="mb-3">
                            <label for="singkatan" class="form-label">Singkatan</label>
                            <input type="text" class="form-control <?= $validation->hasError('singkatan') ? 'is-invalid' : '' ?>" 
                                   id="singkatan" name="singkatan" 
                                   value="<?= old('singkatan', $jenisSurat['singkatan']) ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('singkatan') ?>
                            </div>
                            <small class="text-muted">Digunakan untuk penomoran surat (contoh: ND, SK)</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="/admin/jenis-surat" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>