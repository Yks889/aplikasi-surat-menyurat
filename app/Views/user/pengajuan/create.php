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
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Form Pengajuan Surat Keluar</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="/user/pengajuan" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Pengajuan Baru -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-file-earmark-plus me-2 text-primary"></i>Buat Pengajuan Baru</h5>
            <form action="/user/history-pengajuan/store" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Pengajuan</label>
                    <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Catatan / Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required><?= old('deskripsi') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>