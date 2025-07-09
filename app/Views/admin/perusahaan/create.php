<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="row justify-content-left">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title fs-5 mb-0">Tambah Perusahaan</h4>
        </div>
        <div class="card-body">
          <form action="/admin/perusahaan/store" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
              <label for="nama" class="form-label">Nama Perusahaan</label>
              <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>"
                     id="nama" name="nama" value="<?= old('nama') ?>">
              <div class="invalid-feedback">
                <?= $validation->getError('nama') ?>
              </div>
            </div>

            <div class="mb-3">
              <label for="singkatan" class="form-label">Singkatan</label>
              <input type="text" class="form-control <?= $validation->hasError('singkatan') ? 'is-invalid' : '' ?>"
                     id="singkatan" name="singkatan" value="<?= old('singkatan') ?>">
              <div class="invalid-feedback">
                <?= $validation->getError('singkatan') ?>
              </div>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="/admin/perusahaan" class="btn btn-secondary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
