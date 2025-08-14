<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>
<link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1">
                <i class="bi bi-info-circle me-2 text-primary"></i>Detail Pengajuan Surat Keluar
            </h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="<?= base_url('history-pengajuan') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Informasi Pengajuan -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">
                <i class="bi bi-envelope-paper me-2 text-primary"></i>Informasi Pengajuan
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" width="150">ID:</td>
                            <td><?= esc($pengajuan['id']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Judul:</td>
                            <td><?= esc($pengajuan['judul']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Deskripsi:</td>
                            <td><?= esc($pengajuan['deskripsi']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dari:</td>
                            <td><?= esc($pengajuan['dari']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" width="150">Kepada:</td>
                            <td><?= esc($pengajuan['kepada']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status:</td>
                            <td>
                                <span class="badge bg-<?= ($pengajuan['status'] === 'belum') ? 'warning text-dark' : (($pengajuan['status'] === 'proses') ? 'info' : 'success') ?>">
                                    <?= ucfirst($pengajuan['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Dibuat:</td>
                            <td><?= date('d/m/Y H:i', strtotime($pengajuan['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">File Surat:</td>
                            <td>
                                <?php if (!empty($pengajuan['file_surat'])): ?>
                                    <a href="<?= base_url('uploads/surat_keluar/' . $pengajuan['file_surat']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-text me-1"></i> Lihat File
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada file</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>