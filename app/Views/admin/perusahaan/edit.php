<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4>Edit Perusahaan</h4>

<form action="/admin/perusahaan/update/<?= $perusahaan['id'] ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group mb-3">
        <label for="nama">Nama Perusahaan</label>
        <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>"
               id="nama" name="nama" value="<?= old('nama', $perusahaan['nama']) ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('nama') ?>
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="singkatan">Singkatan</label>
        <input type="text" class="form-control <?= $validation->hasError('singkatan') ? 'is-invalid' : '' ?>"
               id="singkatan" name="singkatan" value="<?= old('singkatan', $perusahaan['singkatan']) ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('singkatan') ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="/admin/perusahaan" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
