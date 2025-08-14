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
            <h2 class="h4 mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Disposisi</h2>
            <p class="text-muted mb-0">Perbarui informasi disposisi surat</p>
        </div>
        <div>
            <a href="<?= base_url('operator/disposisi') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('operator/disposisi/update/' . $disposisi['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Nomor Surat -->
                        <div class="mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" value="<?= esc($disposisi['nomor_surat']) ?>" disabled>
                        </div>

                        <!-- Pengirim Surat -->
                        <div class="mb-3">
                            <label class="form-label">Pengirim Surat</label>
                            <input type="text" class="form-control" value="<?= esc($disposisi['dari']) ?>" disabled>
                        </div>

                        <!-- Dari (User Pengirim) -->
                        <div class="mb-3">
                            <label class="form-label">Dari (User Pengirim)</label>
                            <input type="text" class="form-control" value="<?= esc($disposisi['dari_nama']) ?>" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Kepada (Penerima Disposisi) -->
                        <div class="mb-3">
                            <label class="form-label">Kepada (Penerima Disposisi) <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <?php foreach ($usersList as $user): ?>
                                    <div>
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="ke_user_ids[]" 
                                            id="user<?= $user['id'] ?>" 
                                            value="<?= $user['id'] ?>" 
                                            <?= in_array($user['id'], $selectedUserIds ?? []) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="user<?= $user['id'] ?>">
                                            <?= esc($user['full_name']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($validation->hasError('ke_user_ids')): ?>
                                <div class="text-danger mt-1">
                                    <?= $validation->getError('ke_user_ids') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan Disposisi <span class="text-danger">*</span></label>
                            <textarea name="catatan" id="catatan" rows="4" class="form-control <?= $validation->hasError('catatan') ? 'is-invalid' : '' ?>"><?= old('catatan', $disposisi['catatan']) ?></textarea>
                            <?php if ($validation->hasError('catatan')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('catatan') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Perbarui Disposisi
                    </button>
                    <a href="<?= base_url('operator/disposisi') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
