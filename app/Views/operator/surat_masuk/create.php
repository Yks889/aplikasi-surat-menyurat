<?= $this->extend('layouts/operator') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-envelope-plus me-2 text-primary"></i>Tambah Surat Masuk</h2>
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
            <form action="/operator/surat-masuk/simpan" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_surat')) ? 'is-invalid' : '' ?>" 
                                id="nomor_surat" name="nomor_surat" value="<?= old('nomor_surat') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nomor_surat') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="perusahaan_id" class="form-label">Perusahaan</label>
                            <select class="form-select <?= ($validation->hasError('perusahaan_id')) ? 'is-invalid' : '' ?>" 
                                id="perusahaan_id" name="perusahaan_id">
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach ($perusahaan as $pt): ?>
                                <option value="<?= $pt['id'] ?>" <?= old('perusahaan_id') == $pt['id'] ? 'selected' : '' ?>>
                                    <?= esc($pt['nama']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('perusahaan_id') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dari" class="form-label">Dari</label>
                            <input type="text" class="form-control <?= ($validation->hasError('dari')) ? 'is-invalid' : '' ?>" 
                                id="dari" name="dari" value="<?= old('dari') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('dari') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_surat" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control <?= ($validation->hasError('tgl_surat')) ? 'is-invalid' : '' ?>" 
                                id="tgl_surat" name="tgl_surat" value="<?= old('tgl_surat') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tgl_surat') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="perihal" class="form-label">Perihal</label>
                    <textarea class="form-control <?= ($validation->hasError('perihal')) ? 'is-invalid' : '' ?>" 
                        id="perihal" name="perihal" rows="3"><?= old('perihal') ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('perihal') ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="file_surat" class="form-label">File Surat</label>
                    <input type="file" class="form-control <?= ($validation->hasError('file_surat')) ? 'is-invalid' : '' ?>" 
                        id="file_surat" name="file_surat">
                    <div class="invalid-feedback">
                        <?= $validation->getError('file_surat') ?>
                    </div>
                    <small class="text-muted">Format: PDF/DOC/JPEG/PNG (Maks. 5MB)</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
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