<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>
<link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-info-circle me-2 text-primary"></i>Detail Pengajuan Surat Keluar</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="<?= base_url('/user/history-pengajuan') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Informasi Pengajuan -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-envelope-paper me-2 text-primary"></i>Informasi Pengajuan</h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" width="150">ID:</td>
                            <td><?= esc($pengajuan['id']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Nomor Surat:</td>
                            <td><?= esc($pengajuan['nomor_surat']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Perihal:</td>
                            <td><?= esc($pengajuan['perihal']) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dari:</td>
                            <td><?= esc($pengajuan['dari_surat_masuk']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" width="150">Tanggal Surat:</td>
                            <td><?= date('d/m/Y', strtotime($pengajuan['tgl_surat'])) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Waktu Diterima:</td>
                            <td><?= date('d/m/Y H:i', strtotime($pengajuan['waktu_diterima'])) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status Pengajuan:</td>
                            <td>
                                <?php if ($pengajuan['status'] === 'diterima'): ?>
                                    <span class="badge bg-success">Diproses</span>
                                <?php elseif ($pengajuan['status'] === 'ditolak'): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Belum Diproses</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">File Surat:</td>
                            <td>
                                <?php if (!empty($pengajuan['file_surat'])): ?>
                                    <a href="<?= base_url('uploads/surat_masuk/' . $pengajuan['file_surat']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
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

    <!-- Daftar Form Pengajuan -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-list-check me-2 text-primary"></i>Form Pengajuan yang Dikirim</h5>

            <?php if (!empty($pengajuanForms)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Dari</th>
                                <th>Kepada</th>
                                <th>Status</th>
                                <th>Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pengajuanForms as $i => $form): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($form['judul']) ?></td>
                                    <td><?= esc($form['deskripsi']) ?></td>
                                    <td><?= esc($form['dari']) ?></td>
                                    <td><?= esc($form['kepada']) ?></td>
                                    <td>
                                        <?php if ($form['status'] === 'diterima'): ?>
                                            <span class="badge bg-success">Diproses</span>
                                        <?php elseif ($form['status'] === 'ditolak'): ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum Diproses</span>
                                        <?php endif; ?>

                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($form['created_at'])) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">Belum ada form pengajuan yang dikirim.</div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>