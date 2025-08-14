<?= $this->extend('layouts/admin') ?>
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
    <!-- Error Notification -->
    <?php if (session('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-envelope-open me-2 text-primary"></i>Edit Surat Keluar</h2>
        </div>
        <div>
            <a href="/admin/surat-keluar" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="/admin/surat-keluar/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Nomor Surat -->
                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" name="nomor_surat" id="nomor_surat"
                                class="form-control" 
                                value="<?= old('nomor_surat', $surat['nomor_surat']) ?>" readonly>
                            <small class="text-muted">Nomor akan digenerate ulang otomatis saat disimpan</small>
                        </div>

                        <!-- Perusahaan -->
                        <div class="mb-3">
                            <label for="perusahaan_id" class="form-label">Perusahaan</label>
                            <select name="perusahaan_id" id="perusahaan_id"
                                class="form-select <?= $validation->hasError('perusahaan_id') ? 'is-invalid' : '' ?>">
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach ($perusahaan as $p): ?>
                                    <option value="<?= $p['id'] ?>" 
                                        <?= old('perusahaan_id', $surat['perusahaan_id']) == $p['id'] ? 'selected' : '' ?>>
                                        <?= esc($p['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('perusahaan_id') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Jenis Surat -->
                        <div class="mb-3">
                            <label for="jenis_surat" class="form-label">Jenis Surat</label>
                            <select name="jenis_surat" id="jenis_surat"
                                class="form-select <?= $validation->hasError('jenis_surat') ? 'is-invalid' : '' ?>">
                                <option value="">-- Pilih Jenis Surat --</option>
                                <?php foreach ($jenis_surat as $jenis): ?>
                                    <option value="<?= $jenis['id'] ?>"
                                        <?= old('jenis_surat', $surat['kode_surat']) == $jenis['singkatan'] ? 'selected' : '' ?>>
                                        <?= esc($jenis['nama']) ?> (<?= esc($jenis['singkatan']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenis_surat') ?>
                            </div>
                        </div>

                        <!-- Tanggal Surat -->
                        <div class="mb-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" id="tanggal_surat"
                                class="form-control <?= $validation->hasError('tanggal_surat') ? 'is-invalid' : '' ?>"
                                value="<?= old('tanggal_surat', $surat['tanggal_surat']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal_surat') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Untuk -->
                        <div class="mb-3">
                            <label for="untuk" class="form-label">Untuk</label>
                            <input type="text" name="untuk" id="untuk"
                                class="form-control <?= $validation->hasError('untuk') ? 'is-invalid' : '' ?>"
                                value="<?= old('untuk', $surat['untuk']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('untuk') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Penandatangan -->
                        <div class="mb-3">
                            <label for="penandatangan_id" class="form-label">Penandatangan</label>
                            <select name="penandatangan_id" id="penandatangan_id"
                                class="form-select <?= $validation->hasError('penandatangan_id') ? 'is-invalid' : '' ?>">
                                <option value="">-- Pilih Penandatangan --</option>
                                <?php foreach ($penandatangan as $admin): ?>
                                    <option value="<?= $admin['id'] ?>" 
                                        <?= old('penandatangan_id', $surat['penandatangan_id']) == $admin['id'] ? 'selected' : '' ?>>
                                        <?= esc($admin['full_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('penandatangan_id') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Perihal -->
                        <div class="mb-3">
                            <label for="perihal" class="form-label">Perihal</label>
                            <input type="text" name="perihal" id="perihal"
                                class="form-control <?= $validation->hasError('perihal') ? 'is-invalid' : '' ?>"
                                value="<?= old('perihal', $surat['perihal']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('perihal') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- File Surat -->
                        <div class="mb-3">
                            <label for="file_surat" class="form-label">File Surat</label>
                            <input type="file" name="file_surat" id="file_surat"
                                class="form-control <?= $validation->hasError('file_surat') ? 'is-invalid' : '' ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('file_surat') ?>
                            </div>
                            <?php if (!empty($surat['file_surat'])): ?>
                                <small class="text-muted d-block mt-1">
                                    File saat ini: 
                                    <a href="/uploads/surat_keluar/<?= esc($surat['file_surat']) ?>" target="_blank">
                                        <?= esc($surat['file_surat']) ?>
                                    </a>
                                </small>
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti file</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="/admin/surat-keluar" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>