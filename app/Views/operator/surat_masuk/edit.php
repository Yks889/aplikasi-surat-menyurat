<?= $this->extend('layouts/operator') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title fs-5 mb-0">Edit Surat Masuk</h3>
    </div>
    <div class="card-body">
        <?= view('components/alert') ?>

        <form action="/operator/surat-masuk/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6">
                    <!-- Nomor Surat -->
                    <div class="form-group">
                        <label for="nomor_surat">Nomor Surat</label>
                        <input type="text" class="form-control <?= $validation->hasError('nomor_surat') ? 'is-invalid' : '' ?>" 
                            id="nomor_surat" name="nomor_surat" value="<?= old('nomor_surat', $surat['nomor_surat']) ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nomor_surat') ?>
                        </div>
                    </div>

                    <!-- Perusahaan -->
                    <div class="form-group">
                        <label for="perusahaan_id">Perusahaan</label>
                        <select class="form-control <?= $validation->hasError('perusahaan_id') ? 'is-invalid' : '' ?>" 
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
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="text" class="form-control <?= $validation->hasError('dari') ? 'is-invalid' : '' ?>" 
                            id="dari" name="dari" value="<?= old('dari', $surat['dari']) ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('dari') ?>
                        </div>
                    </div>

                    <!-- Tanggal Surat -->
                    <div class="form-group">
                        <label for="tgl_surat">Tanggal Surat</label>
                        <input type="date" class="form-control <?= $validation->hasError('tgl_surat') ? 'is-invalid' : '' ?>" 
                            id="tgl_surat" name="tgl_surat" value="<?= old('tgl_surat', $surat['tgl_surat']) ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('tgl_surat') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perihal -->
            <div class="form-group">
                <label for="perihal">Perihal</label>
                <textarea class="form-control <?= $validation->hasError('perihal') ? 'is-invalid' : '' ?>" 
                    id="perihal" name="perihal" rows="3"><?= old('perihal', $surat['perihal']) ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('perihal') ?>
                </div>
            </div>

            <!-- File Surat -->
            <div class="form-group">
                <label for="file_surat">File Surat</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input <?= $validation->hasError('file_surat') ? 'is-invalid' : '' ?>" 
                        id="file_surat" name="file_surat">
                    <label class="custom-file-label" for="file_surat">Pilih file (PDF/DOCX/JPEG/PNG)</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('file_surat') ?>
                    </div>
                    <small class="text-muted">Maksimal ukuran file: 5MB</small>
                </div>
                <?php if (!empty($surat['file_surat'])): ?>
                    <small class="text-muted d-block mt-2">File saat ini: <a href="/uploads/surat_masuk/<?= $surat['file_surat'] ?>" target="_blank">Lihat File</a></small>
                <?php endif; ?>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="/operator/surat-masuk" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    // Tampilkan nama file yang dipilih
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
