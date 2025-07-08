<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<di class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title fs-5 mb-0">Jenis Surat</h3>
    <a href="/admin/jenis-surat/create" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-circle"></i> Tambah Jenis Surat
    </a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="jenisSuratTable">
        <thead class="table-light">
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
                <a href="/admin/jenis-surat/edit/<?= $row['id'] ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-sm btn-danger" title="Hapus">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- SweetAlert2 & DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    $('#jenisSuratTable').DataTable({
      responsive: true,
      dom: '<"top"lf>rt<"bottom"ip><"clear">',
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ entri per halaman",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "→",
          previous: "←"
        }
      }
    });
  });

  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data jenis surat akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '/admin/jenis-surat/delete/' + id;
      }
    });

  }

  <?php if (session()->getFlashdata('success')): ?>
          Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: '<?= session()->getFlashdata('success') ?>',
              timer: 3000,
              showConfirmButton: false
          });
  <?php endif; ?>
</script>
<?= $this->endSection() ?>
