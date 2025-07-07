<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Surat Masuk</h3>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <form action="/user/kirim-surat/simpan" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6">
                    <!-- Nomor Surat -->
                    <div class="form-group">
                        <label for="nomor_surat">Nomor Surat</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nomor_surat')) ? 'is-invalid' : '' ?>" 
                               id="nomor_surat" name="nomor_surat" value="<?= old('nomor_surat') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nomor_surat') ?>
                        </div>
                    </div>

                    <!-- Perusahaan -->
                    <div class="form-group">
                        <label for="perusahaan_id">Perusahaan</label>
                        <select class="form-control <?= ($validation->hasError('perusahaan_id')) ? 'is-invalid' : '' ?>" 
                                id="perusahaan_id" name="perusahaan_id" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            <?php foreach ($perusahaan as $pt): ?>
                                <option value="<?= $pt['id'] ?>" <?= old('perusahaan_id') == $pt['id'] ? 'selected' : '' ?>>
                                    <?= $pt['nama'] ?>
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
                        <input type="text" class="form-control <?= ($validation->hasError('dari')) ? 'is-invalid' : '' ?>" 
                               id="dari" name="dari" value="<?= old('dari') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('dari') ?>
                        </div>
                    </div>

                    <!-- Tanggal Surat -->
                    <div class="form-group">
                        <label for="tgl_surat">Tanggal Surat</label>
                        <input type="date" class="form-control <?= ($validation->hasError('tgl_surat')) ? 'is-invalid' : '' ?>" 
                               id="tgl_surat" name="tgl_surat" value="<?= old('tgl_surat') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('tgl_surat') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perihal -->
            <div class="form-group">
                <label for="perihal">Perihal</label>
                <textarea class="form-control <?= ($validation->hasError('perihal')) ? 'is-invalid' : '' ?>" 
                          id="perihal" name="perihal" rows="3" required><?= old('perihal') ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('perihal') ?>
                </div>
            </div>

            <!-- File Surat -->
            <div class="form-group">
                <label for="file_surat">File Surat</label>
                <input type="file" class="form-control <?= ($validation->hasError('file_surat')) ? 'is-invalid' : '' ?>" 
                       id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('file_surat') ?>
                </div>
                <small class="text-muted">Maksimal ukuran 5MB</small>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-send"></i> Kirim Surat
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
