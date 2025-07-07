<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Daftar Surat Masuk</h3>
        <a href="/admin/surat-masuk/tambah" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Surat Masuk
        </a>
    </div>
    <div class="card-body">
        <?= view('components/alert') ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover nowrap table-primary" id="suratMasukTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Perusahaan</th>
                        <th>Dari</th>
                        <th>Perihal</th>
                        <th>Tgl. Surat</th>
                        <th>Tgl. Diterima</th>
                        <th>Pengirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suratMasuk as $index => $surat): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($surat['nomor_surat']) ?></td>
                        <td><?= esc($surat['perusahaan']) ?></td>
                        <td><?= esc($surat['dari']) ?></td>
                        <td><?= esc($surat['perihal']) ?></td>
                        <td><?= date('d/m/Y', strtotime($surat['tgl_surat'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($surat['waktu_diterima'])) ?></td>
                        <td><?= esc($surat['pengirim']) ?></td>
                        <td>
                            <a href="/uploads/surat_masuk/<?= esc($surat['file_surat']) ?>" target="_blank" class="btn btn-sm btn-info" title="Lihat File">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>
                            <a href="/admin/surat-masuk/edit/<?= $surat['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $surat['id'] ?>)" class="btn btn-sm btn-danger" title="Hapus">
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- DataTables & SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Table Responsive Fix -->
<style>
    .table.nowrap td,
    .table.nowrap th {
        white-space: nowrap;
    }
</style>

<script>
    $(document).ready(function () {
        $('#suratMasukTable').DataTable({
            responsive: false,
            scrollX: true,
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
            title: 'Hapus Surat?',
            text: "Data surat akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/surat-masuk/hapus/' + id;
            }
        });
    }
</script>
<?= $this->endSection() ?>
    