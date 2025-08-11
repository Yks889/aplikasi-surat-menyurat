<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
     <!-- Watermark Background - Adjusted for sidebar -->
    <div class="position-fixed top-0 start-0 w-100 h-100" style="
        background-image: url('/uploads/logo.png');
        background-repeat: no-repeat;
        background-position: calc(50% + 140px) calc(40% + 40px);
        background-size: 55%;
        opacity: 0.10;
        pointer-events: none;
        z-index: -1;
    "></div>
    <!-- Notification Alert -->
    <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div><?= session()->getFlashdata('message') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-envelope me-2 text-primary"></i>History Surat Masuk</h2>
        </div>
        <div>
            <a href="/user/kirim-surat" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Kirim Surat Baru
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="suratMasukTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Perusahaan</th>
                            <th>Dari</th>
                            <th>Perihal</th>
                            <th>Tgl. Surat</th>
                            <th>Tgl. Diterima</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($suratMasuk as $index => $surat): ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>
                            <td><?= esc($surat['nomor_surat']) ?></td>
                            <td><?= esc($surat['perusahaan']) ?></td>
                            <td><?= esc($surat['dari']) ?></td>
                            <td><?= esc($surat['perihal']) ?></td>
                            <td><?= date('d/m/Y', strtotime($surat['tgl_surat'])) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($surat['waktu_diterima'])) ?></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="/uploads/surat_masuk/<?= esc($surat['file_surat']) ?>" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="Lihat File">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                    <?php if (($surat['status'] ?? '') === 'draft'): ?>
                                    <a href="/user/surat-masuk/edit/<?= $surat['id'] ?>" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#suratMasukTable').DataTable({
            responsive: true,
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
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>