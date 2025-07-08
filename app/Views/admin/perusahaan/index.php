<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title fs-5 mb-0">Daftar Perusahaan</h3>
        <a href="/admin/perusahaan/create" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Perusahaan
        </a>
    </div>
    <div class="card-body">

        <!-- TIDAK PERLU ALERT BAWAAN BOOTSTRAP, DIGANTI SWEETALERT -->
        <!-- Flash message akan muncul melalui SweetAlert -->

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="perusahaanTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Perusahaan</th>
                        <th>Singkatan</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($perusahaan as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($p['nama']) ?></td>
                        <td><?= esc($p['singkatan']) ?></td>
                        <td>
                            <a href="/admin/perusahaan/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $p['id'] ?>)" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
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
    $(document).ready(function() {
        $('#perusahaanTable').DataTable({
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
            title: 'Apakah Anda yakin?',
            text: "Data perusahaan akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/perusahaan/delete/' + id;
            }
        });
    }

    // ✅ Tampilkan alert jika ada flash message 'success'
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
