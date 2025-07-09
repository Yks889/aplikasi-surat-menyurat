<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card w-100">
    <div class="card-header">
        <h3 class="card-title fs-5 mb-0">Edit Surat Masuk</h3>
    </div>
    <div class="card-body">
        <form action="/admin/surat-masuk/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6">
                    <!-- Nomor Surat -->
                    <div class="form-group">
                        <label for="nomor_surat">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                            value="<?= old('nomor_surat', $surat['nomor_surat']) ?>" required>
                    </div>

                    <!-- Perusahaan -->
                    <div class="form-group">
                        <label for="perusahaan_id">Perusahaan</label>
                        <select class="form-control" id="perusahaan_id" name="perusahaan_id" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($perusahaan as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= $p['id'] == $surat['perusahaan_id'] ? 'selected' : '' ?>>
                                    <?= esc($p['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dari -->
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="text" class="form-control" id="dari" name="dari"
                            value="<?= old('dari', $surat['dari']) ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tgl_surat">Tanggal Surat</label>
                        <input type="date" class="form-control" id="tgl_surat" name="tgl_surat"
                            value="<?= old('tgl_surat', $surat['tgl_surat']) ?>" required>
                    </div>

                    <!-- Perihal -->
                    <div class="form-group">
                        <label for="perihal">Perihal</label>
                        <textarea class="form-control" id="perihal" name="perihal" rows="2" required><?= old('perihal', $surat['perihal']) ?></textarea>
                    </div>

                    <!-- File Surat -->
                    <div class="form-group">
                        <label for="file_surat">File Surat (Kosongkan jika tidak ingin mengganti)</label>
                        <input type="file" class="form-control" id="file_surat" name="file_surat">
                        <?php if (!empty($surat['file_surat'])): ?>
                            <small class="text-muted d-block mt-1">File saat ini:
                                <a href="/uploads/surat_masuk/<?= esc($surat['file_surat']) ?>" target="_blank">
                                    <?= esc($surat['file_surat']) ?>
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="/admin/surat-masuk" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
