<?= $this->extend('layouts/operator') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Surat Masuk</h3>
    </div>
    <div class="card-body">
        <form action="/operator/surat-masuk/simpan" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nomor_surat">Nomor Surat</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nomor_surat')) ? 'is-invalid' : '' ?>" 
                            id="nomor_surat" name="nomor_surat" value="<?= old('nomor_surat') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nomor_surat') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="perusahaan_id">Perusahaan</label>
                        <select class="form-control <?= ($validation->hasError('perusahaan_id')) ? 'is-invalid' : '' ?>" 
                            id="perusahaan_id" name="perusahaan_id">
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
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="text" class="form-control <?= ($validation->hasError('dari')) ? 'is-invalid' : '' ?>" 
                            id="dari" name="dari" value="<?= old('dari') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('dari') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tgl_surat">Tanggal Surat</label>
                        <input type="date" class="form-control <?= ($validation->hasError('tgl_surat')) ? 'is-invalid' : '' ?>" 
                            id="tgl_surat" name="tgl_surat" value="<?= old('tgl_surat') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('tgl_surat') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="perihal">Perihal</label>
                <textarea class="form-control <?= ($validation->hasError('perihal')) ? 'is-invalid' : '' ?>" 
                    id="perihal" name="perihal" rows="3"><?= old('perihal') ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('perihal') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="file_surat">File Surat</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input <?= ($validation->hasError('file_surat')) ? 'is-invalid' : '' ?>" 
                        id="file_surat" name="file_surat">
                    <label class="custom-file-label" for="file_surat">Pilih file (PDF/DOC/JPEG/PNG)</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('file_surat') ?>
                    </div>
                    <small class="text-muted">Maksimal ukuran file: 5MB</small>
                </div>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
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
    // Menampilkan nama file yang dipilih
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
