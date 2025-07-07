<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Jenis Surat</h3>
  </div>
  <div class="card-body">
    <form action="/admin/jenis-surat/update/<?= $jenisSurat['id'] ?>" method="post">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Jenis Surat</label>
        <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama', $jenisSurat['nama']) ?>">
        <div class="invalid-feedback"><?= $errors['nama'] ?? '' ?></div>
      </div>
      <div class="mb-3">
        <label for="singkatan" class="form-label">Singkatan</label>
        <input type="text" class="form-control <?= isset($errors['singkatan']) ? 'is-invalid' : '' ?>" id="singkatan" name="singkatan" value="<?= old('singkatan', $jenisSurat['singkatan']) ?>">
        <div class="invalid-feedback"><?= $errors['singkatan'] ?? '' ?></div>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="/admin/jenis-surat" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?= $this->endSection() ?>