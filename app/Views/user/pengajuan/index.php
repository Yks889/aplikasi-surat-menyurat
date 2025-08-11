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
    <!-- Flash Message -->
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div><?= session()->getFlashdata('message') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-send-plus me-2 text-primary"></i>Pengajuan Surat Keluar</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="/user/history-pengajuan/create" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Ajukan Baru
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="pengajuanSuratKeluarTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Dari</th>
                            <th>Kepada</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengajuanSuratKeluar)) : ?>
                            <tr>
                                <td class="text-center" colspan="9">Belum ada pengajuan surat keluar.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($pengajuanSuratKeluar as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['judul']) ?></td>
                                    <td><?= esc($row['deskripsi']) ?></td>
                                    <td><?= esc($row['dari']) ?></td>
                                    <td><?= esc($row['kepada']) ?></td>
                                    <td>
                                        <?= !empty($row['surat_masuk_id']) ? 'Berdasarkan Surat Masuk' : 'Pengajuan Langsung' ?>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] === 'diterima'): ?>
                                            <span class="badge bg-success">Diproses</span>
                                        <?php elseif ($row['status'] === 'ditolak'): ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum Diproses</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                    <td class="text-end">
                                        <a href="/user/history-pengajuan/detail/<?= $row['id'] ?>" class="btn btn-sm btn-outline-info" title="Detail Pengajuan">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#pengajuanSuratKeluarTable').DataTable({
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