<?= $this->extend('layouts/operator') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Daftar User Biasa</h3>
        <div>
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-funnel"></i> Filter
            </button>
            <a href="/operator/users/tambah" class="btn btn-primary btn-sm ms-2">
                <i class="bi bi-plus-circle"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="card-body">
        <?= view('components/alert') ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-primary w-100" id="usersTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $u): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($u['username']) ?></td>
                        <td><?= esc($u['full_name']) ?></td>
                        <td><?= esc($u['email'] ?? '-') ?></td>
                        <td><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <a href="/operator/users/edit/<?= $u['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $u['id'] ?>)" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="get" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label for="bulan" class="form-label">Bulan</label>
          <select name="bulan" id="bulan" class="form-select">
            <?php for ($i = 1; $i <= 12; $i++): ?>
              <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label for="tahun" class="form-label">Tahun</label>
          <select name="tahun" id="tahun" class="form-select">
            <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
              <option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-funnel-fill me-1"></i> Terapkan
        </button>
        <a href="/operator/users" class="btn btn-outline-secondary">Reset</a>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<style>
    .table th, .table td {
        white-space: nowrap;
    }
</style>

<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            responsive: true,
            autoWidth: false,
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus User?',
            text: "Data user akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/operator/users/delete/' + id;
            }
        });
    }

    <?php if (session()->getFlashdata('message')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('message') ?>',
            timer: 3000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>
