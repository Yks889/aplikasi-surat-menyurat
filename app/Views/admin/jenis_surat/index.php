<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Jenis Surat</h3>
    <a href="/admin/jenis-surat/create" class="btn btn-primary">
      <i class="bi bi-plus-circle"></i> Tambah Jenis Surat
    </a>
  </div>
  <div class="card-body">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Singkatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($jenisSurat as $index => $row): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= esc($row['nama']) ?></td>
              <td><?= esc($row['singkatan']) ?></td>
              <td>
                <a href="/admin/jenis-surat/edit/<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                <a href="/admin/jenis-surat/delete/<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>