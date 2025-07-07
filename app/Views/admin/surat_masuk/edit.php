<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>Edit Surat Masuk</h3>
    </div>
    <div class="card-body">
        <form action="/admin/surat-masuk/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Nomor Surat</label>
                <input type="text" name="nomor_surat" class="form-control" value="<?= old('nomor_surat', $surat['nomor_surat']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Perusahaan</label>
                <select name="perusahaan_id" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($perusahaan as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $surat['perusahaan_id'] ? 'selected' : '' ?>>
                            <?= esc($p['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Dari</label>
                <input type="text" name="dari" class="form-control" value="<?= old('dari', $surat['dari']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Perihal</label>
                <input type="text" name="perihal" class="form-control" value="<?= old('perihal', $surat['perihal']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Surat</label>
                <input type="date" name="tgl_surat" class="form-control" value="<?= old('tgl_surat', $surat['tgl_surat']) ?>" required>
            </div>
            <div class="mb-3">
                <label>File Surat (biarkan kosong jika tidak ingin mengganti)</label>
                <input type="file" name="file_surat" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/admin/surat-masuk" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
