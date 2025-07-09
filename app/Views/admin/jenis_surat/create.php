<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="row justify-content-left">
    <div class="col-md-6">
      <div class="card">
      <div class="card-header">
          <h3 class="card-title fs-5 mb-0">Tambah Jenis Surat</h3> <!-- Ganti jadi "Edit..." di edit.php -->
        </div>
        <div class="card-body">
          <form action="/admin/jenis-surat/store" method="post"> <!-- Ganti route di edit -->
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Jenis Surat</label>
              <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama', $jenisSurat['nama'] ?? '') ?>">
              <div class="invalid-feedback"><?= $errors['nama'] ?? '' ?></div>
            </div>

            <div class="mb-3">
              <label for="singkatan" class="form-label">Singkatan</label>
              <input type="text" class="form-control <?= isset($errors['singkatan']) ? 'is-invalid' : '' ?>" id="singkatan" name="singkatan" value="<?= old('singkatan', $jenisSurat['singkatan'] ?? '') ?>">
              <div class="invalid-feedback"><?= $errors['singkatan'] ?? '' ?></div>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="/admin/jenis-surat" class="btn btn-secondary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
