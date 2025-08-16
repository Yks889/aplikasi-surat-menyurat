<?= $this->extend('layouts/user') ?>

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
            <h2 class="h4 mb-1"><i class="bi bi-send-check me-2 text-primary"></i>Pengajuan Surat Keluar</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="/user/disposisi" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Surat Masuk Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-envelope me-2 text-primary"></i>Informasi Surat Masuk</h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" width="150">Nomor Surat:</td>
                            <td><?= esc($surat['nomor_surat']) ?></td>
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

    <!-- Form Pengajuan -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-pencil-square me-2 text-primary"></i>Form Pengajuan Surat Keluar</h5>
            <form action="/user/disposisi/kirimPengajuan/<?= $surat['id'] ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Pengajuan</label>
                    <input type="text" name="judul" id="judul" class="form-control" required>
                </div>              
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan / Deskripsi</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>