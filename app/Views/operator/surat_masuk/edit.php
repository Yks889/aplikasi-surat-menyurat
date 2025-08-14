<?= $this->extend('layouts/operator') ?>
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
            <h2 class="h4 mb-1"><i class="bi bi-envelope-check me-2 text-primary"></i>Edit Surat Masuk</h2>
        </div>
        <div>
            <a href="/operator/surat-masuk" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?= view('components/alert') ?>
            
            <form action="/operator/surat-masuk/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Nomor Surat -->
                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control <?= $validation->hasError('nomor_surat') ? 'is-invalid' : '' ?>" 
                                id="nomor_surat" name="nomor_surat" value="<?= old('nomor_surat', $surat['nomor_surat']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nomor_surat') ?>
                            </div>
                        </div>

                        <!-- Perusahaan -->
                        <div class="mb-3">
                            <label for="perusahaan_id" class="form-label">Perusahaan</label>
                            <select class="form-select <?= $validation->hasError('perusahaan_id') ? 'is-invalid' : '' ?>" 
                                id="perusahaan_id" name="perusahaan_id">
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach ($perusahaan as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= old('perusahaan_id', $surat['perusahaan_id']) == $p['id'] ? 'selected' : '' ?>>
                                        <?= esc($p['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('perusahaan_id') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Dari -->
                        <div class="mb-3">
                            <label for="dari" class="form-label">Dari</label>
                            <input type="text" class="form-control <?= $validation->hasError('dari') ? 'is-invalid' : '' ?>" 
                                id="dari" name="dari" value="<?= old('dari', $surat['dari']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('dari') ?>
                            </div>
                        </div>

                        <!-- Tanggal Surat -->
                        <div class="mb-3">
                            <label for="tgl_surat" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control <?= $validation->hasError('tgl_surat') ? 'is-invalid' : '' ?>" 
                                id="tgl_surat" name="tgl_surat" value="<?= old('tgl_surat', $surat['tgl_surat']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tgl_surat') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Perihal -->
                <div class="mb-3">
                    <label for="perihal" class="form-label">Perihal</label>
                    <textarea class="form-control <?= $validation->hasError('perihal') ? 'is-invalid' : '' ?>" 
                        id="perihal" name="perihal" rows="3"><?= old('perihal', $surat['perihal']) ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('perihal') ?>
                    </div>
                </div>

                <!-- File Surat -->
                <div class="mb-4">
                    <label for="file_surat" class="form-label">File Surat</label>
                    <input type="file" class="form-control <?= $validation->hasError('file_surat') ? 'is-invalid' : '' ?>" 
                        id="file_surat" name="file_surat">
                    <div class="invalid-feedback">
                        <?= $validation->getError('file_surat') ?>
                    </div>
                    <small class="text-muted">Format: PDF/DOCX/JPEG/PNG (Maks. 5MB)</small>
                    <?php if (!empty($surat['file_surat'])): ?>
                        <div class="mt-2">
                            <small class="text-muted">File saat ini: </small>
                            <a href="/uploads/surat_masuk/<?= $surat['file_surat'] ?>" target="_blank" class="text-primary">
                                <i class="bi bi-file-earmark-text me-1"></i>Lihat File
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    // Display selected file name
    document.getElementById('file_surat').addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || 'Pilih file';
        var nextSibling = e.target.nextElementSibling;
        if (nextSibling && nextSibling.nodeName === 'SMALL') {
            e.target.previousElementSibling.textContent = fileName;
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>