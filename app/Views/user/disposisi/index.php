<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Notification Alert -->
    <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-send me-2 text-primary"></i>Disposisi Masuk</h2>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?php if (empty($disposisi)) : ?>
                <div class="alert alert-info">Tidak ada disposisi masuk.</div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="disposisiTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nomor Surat</th>
                                <th>Dari</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($disposisi as $index => $d): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td><?= esc($d['nomor_surat']) ?></td>
                                <td><?= esc($d['dari']) ?></td>
                                <td><?= esc($d['catatan']) ?></td>
                                <td>
                                    <span class="badge bg-<?= ($d['status'] ?? 'belum dibaca') == 'belum dibaca' ? 'secondary' : 'success' ?>">
                                        <?= ucfirst($d['status'] ?? 'belum dibaca') ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($d['created_at'])) ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#disposisiTable').DataTable({
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