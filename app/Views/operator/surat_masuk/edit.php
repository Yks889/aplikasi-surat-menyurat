<?= $this->extend('layouts/operator') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Surat Masuk</h3>
    </div>
    <div class="card-body">
        <?= view('components/alert') ?>

        <form action="/operator/surat-masuk/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                <input type="text" name="nomor_surat" class="form-control <?= isset($validation) && $validation->hasError('nomor_surat') ? 'is-invalid' : '' ?>" value="<?= old('nomor_surat', $surat['nomor_surat']) ?>">
                <div class="invalid-feedback"><?= $validation->getError('nomor_surat') ?></div>
            </div>

            <div class="mb-3">
                <label for="perusahaan_id" class="form-label">Perusahaan</label>
                <select name="perusahaan_id" class="form-select <?= isset($validation) && $validation->hasError('perusahaan_id') ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih Perusahaan --</option>
                    <?php foreach ($perusahaan as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $surat['perusahaan_id'] ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback"><?= $validation->getError('perusahaan_id') ?></div>
            </div>

            <div class="mb-3">
                <label for="dari" class="form-label">Dari</label>
                <input type="text" name="dari" class="form-control <?= isset($validation) && $validation->hasError('dari') ? 'is-invalid' : '' ?>" value="<?= old('dari', $surat['dari']) ?>">
                <div class="invalid-feedback"><?= $validation->getError('dari') ?></div>
            </div>

            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal</label>
                <input type="text" name="perihal" class="form-control <?= isset($validation) && $validation->hasError('perihal') ? 'is-invalid' : '' ?>" value="<?= old('perihal', $surat['perihal']) ?>">
                <div class="invalid-feedback"><?= $validation->getError('perihal') ?></div>
            </div>

            <div class="mb-3">
                <label for="tgl_surat" class="form-label">Tanggal Surat</label>
                <input type="date" name="tgl_surat" class="form-control <?= isset($validation) && $validation->hasError('tgl_surat') ? 'is-invalid' : '' ?>" value="<?= old('tgl_surat', $surat['tgl_surat']) ?>">
                <div class="invalid-feedback"><?= $validation->getError('tgl_surat') ?></div>
            </div>

            <div class="mb-3">
                <label for="file_surat" class="form-label">File Surat (PDF, DOCX, JPG, PNG - max 5MB)</label>
                <input type="file" name="file_surat" class="form-control <?= isset($validation) && $validation->hasError('file_surat') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= $validation->getError('file_surat') ?></div>
                <?php if (!empty($surat['file_surat'])): ?>
                    <small class="text-muted">File saat ini: <a href="/uploads/surat_masuk/<?= $surat['file_surat'] ?>" target="_blank">Lihat File</a></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
            <a href="/operator/surat-masuk" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
