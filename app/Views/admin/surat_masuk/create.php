<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card w-100">
    <div class="card-header">
        <h3 class="card-title fs-5 mb-0">Tambah Surat Masuk</h3>
    </div>
    <div class="card-body">
        <form action="/admin/surat-masuk/simpan" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6">
                    <!-- Nomor Surat -->
                    <div class="form-group">
                        <label for="nomor_surat">Nomor Surat</label>
                        <input type="text" class="form-control <?= $validation->hasError('nomor_surat') ? 'is-invalid' : '' ?>"
                            id="nomor_surat" name="nomor_surat" value="<?= old('nomor_surat') ?>">
                        <div class="invalid-feedback"><?= $validation->getError('nomor_surat') ?></div>
                    </div>

                    <!-- Perusahaan -->
                    <div class="form-group">
                        <label for="perusahaan_id">Perusahaan</label>
                        <select class="form-control <?= $validation->hasError('perusahaan_id') ? 'is-invalid' : '' ?>"
                            id="perusahaan_id" name="perusahaan_id">
                            <option value="">-- Pilih Perusahaan --</option>
                            <?php foreach ($perusahaan as $pt): ?>
                                <option value="<?= $pt['id'] ?>" <?= old('perusahaan_id') == $pt['id'] ? 'selected' : '' ?>>
                                    <?= esc($pt['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('perusahaan_id') ?></div>
                    </div>

                    <!-- Dari -->
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="text" class="form-control <?= $validation->hasError('dari') ? 'is-invalid' : '' ?>"
                            id="dari" name="dari" value="<?= old('dari') ?>">
                        <div class="invalid-feedback"><?= $validation->getError('dari') ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tgl_surat">Tanggal Surat</label>
                        <input type="date" class="form-control <?= $validation->hasError('tgl_surat') ? 'is-invalid' : '' ?>"
                            id="tgl_surat" name="tgl_surat" value="<?= old('tgl_surat') ?>">
                        <div class="invalid-feedback"><?= $validation->getError('tgl_surat') ?></div>
                    </div>

                    <!-- Perihal -->
                    <div class="form-group">
                        <label for="perihal">Perihal</label>
                        <textarea class="form-control <?= $validation->hasError('perihal') ? 'is-invalid' : '' ?>"
                            id="perihal" name="perihal" rows="2"><?= old('perihal') ?></textarea>
                        <div class="invalid-feedback"><?= $validation->getError('perihal') ?></div>
                    </div>

                    <!-- File -->
                    <div class="form-group">
                        <label for="file_surat">File Surat</label>
                        <input type="file" class="form-control <?= $validation->hasError('file_surat') ? 'is-invalid' : '' ?>"
                            id="file_surat" name="file_surat">
                        <div class="invalid-feedback"><?= $validation->getError('file_surat') ?></div>
                        <small class="text-muted">PDF, DOC, JPG, PNG. Max 5MB.</small>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="/admin/surat-masuk" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
