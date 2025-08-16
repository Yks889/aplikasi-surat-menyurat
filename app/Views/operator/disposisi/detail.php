<?= $this->extend('layouts/operator') ?>

<?= $this->section('content') ?>
<link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />
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
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-info-circle me-2 text-primary"></i>Detail Disposisi Surat</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="/operator/surat-masuk" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Surat Information Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-envelope me-2 text-primary"></i>Informasi Surat</h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" width="150">Nomor Surat:</td>
                            <td><?= esc($surat['nomor_surat']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Perusahaan:</td>
                            <td><?= esc($surat['perusahaan_nama'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dari:</td>
                            <td><?= esc($surat['dari']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Perihal:</td>
                            <td><?= esc($surat['perihal']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" width="150">Tanggal Surat:</td>
                            <td><?= date('d/m/Y', strtotime($surat['tgl_surat'])) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Waktu Diterima:</td>
                            <td><?= date('d/m/Y H:i', strtotime($surat['waktu_diterima'])) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Pengirim:</td>
                            <td><?= esc($surat['pengirim_nama'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">File Surat:</td>
                            <td>
                                <a href="/uploads/surat_masuk/<?= esc($surat['file_surat']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-text me-1"></i> Lihat File
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Disposisi History Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-send me-2 text-primary"></i>Riwayat Disposisi</h5>
            <?php if (empty($disposisi)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <p class="text-muted mt-2">Surat ini belum pernah didisposisikan</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="disposisiDetailTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Disposisi</th>
                                <th>Dari</th>
                                <th>Kepada</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Dibaca Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grouped = [];
                            foreach ($disposisi as $d) {
                                $key = $d['id'] . '|' . $d['dari_nama'] . '|' . $d['catatan'];
                                if (!isset($grouped[$key])) {
                                    $grouped[$key] = [
                                        'id' => $d['id'],
                                        'created_at' => $d['created_at'],
                                        'dari_nama' => $d['dari_nama'],
                                        'catatan' => $d['catatan'],
                                        'recipients' => []
                                    ];
                                }
                                $grouped[$key]['recipients'][] = [
                                    'ke_nama' => $d['ke_nama'],
                                    'status' => $d['status'],
                                    'dibaca_pada' => $d['dibaca_pada']
                                ];
                            }
                            $index = 1;
                            ?>
                            <?php foreach ($grouped as $group): ?>
                                <tr>
                                    <td><?= $index++ ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($group['created_at'])) ?></td>
                                    <td><?= esc($group['dari_nama']) ?></td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            <?php foreach ($group['recipients'] as $recipient): ?>
                                                <li><?= esc($recipient['ke_nama']) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td><?= esc($group['catatan']) ?></td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            <?php foreach ($group['recipients'] as $recipient): ?>
                                                <li>
                                                    <span class="badge bg-<?= $recipient['status'] == 'belum dibaca' ? 'secondary' : 'success' ?>">
                                                        <?= ucfirst($recipient['status']) ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            <?php foreach ($group['recipients'] as $recipient): ?>
                                                <li><?= $recipient['dibaca_pada'] ? date('d/m/Y H:i', strtotime($recipient['dibaca_pada'])) : '-' ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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
        <?php if (!empty($disposisi)): ?>
        $('#disposisiDetailTable').DataTable({
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
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>