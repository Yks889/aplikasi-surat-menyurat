<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h4 class="mb-3">Disposisi Masuk</h4>

  <?php if (empty($disposisi)) : ?>
    <div class="alert alert-info">Tidak ada disposisi masuk.</div>
  <?php else : ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Nomor Surat</th>
            <th>Dari</th>
            <th>Catatan</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($disposisi as $i => $d) : ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= esc($d['nomor_surat']) ?></td>
              <td><?= esc($d['dari']) ?></td>
              <td><?= esc($d['catatan']) ?></td>
              <td><?= date('d/m/Y H:i', strtotime($d['created_at'])) ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php endif ?>
</div>

<?= $this->endSection() ?>
