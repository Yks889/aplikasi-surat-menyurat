<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-building me-2 text-primary"></i>Edit Perusahaan</h2>
        </div>
        <div>
            <a href="/admin/perusahaan" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="/admin/perusahaan/update/<?= $perusahaan['id'] ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Nama Perusahaan -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>"
                                   id="nama" name="nama" 
                                   value="<?= old('nama', $perusahaan['nama']) ?>" required>
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
                                   value="<?= old('singkatan', $perusahaan['singkatan']) ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('singkatan') ?>
                            </div>
                            <small class="text-muted">Digunakan untuk nomor surat (contoh: PT, CV)</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="/admin/perusahaan" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>