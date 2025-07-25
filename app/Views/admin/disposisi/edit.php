<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1">
                <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Disposisi
            </h2>
            <p class="text-muted mb-0">Perbarui informasi disposisi surat</p>
        </div>
        <div>
            <a href="<?= base_url('admin/disposisi') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('admin/disposisi/update/' . $disposisi['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row g-3">
                    <!-- Info Surat (Read Only) -->
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h6 class="alert-heading mb-2">
                                <i class="bi bi-info-circle me-1"></i>Informasi Surat
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Nomor Surat:</strong> <?= esc($disposisi['nomor_surat']) ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Pengirim:</strong> <?= esc($disposisi['dari']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dari (Read Only) -->
                    <div class="col-md-6">
                        <label class="form-label">Dari</label>
                        <input type="text" class="form-control" value="<?= esc($disposisi['dari_nama']) ?>" disabled>
                        <small class="text-muted">Field ini tidak dapat diubah</small>
                    </div>

                    <!-- Kepada -->
                    <div class="col-md-6">
                        <label for="ke_user_id" class="form-label">Kepada <span class="text-danger">*</span></label>
                        <select name="ke_user_id" id="ke_user_id" class="form-select <?= $validation->hasError('ke_user_id') ? 'is-invalid' : '' ?>">
                            <option value="">-- Pilih Penerima --</option>
                            <?php foreach ($usersList as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= old('ke_user_id', $disposisi['ke_user_id']) == $user['id'] ? 'selected' : '' ?>>
                                <?= esc($user['nama']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation->hasError('ke_user_id')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('ke_user_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Status (Read Only) -->
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <div class="form-control-plaintext">
                            <span class="badge bg-<?= $disposisi['status'] == 'belum dibaca' ? 'secondary' : 'success' ?>">
                                <?= ucfirst($disposisi['status']) ?>
                            </span>
                        </div>
                        <small class="text-muted">Status akan direset menjadi "Belum Dibaca" setelah diperbarui</small>
                    </div>

                    <!-- Tanggal Dibuat (Read Only) -->
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Dibuat</label>
                        <input type="text" class="form-control" value="<?= date('d/m/Y H:i', strtotime($disposisi['created_at'])) ?>" disabled>
                    </div>

                    <!-- Catatan -->
                    <div class="col-12">
                        <label for="catatan" class="form-label">Catatan Disposisi <span class="text-danger">*</span></label>
                        <textarea name="catatan" id="catatan" rows="4" class="form-control <?= $validation->hasError('catatan') ? 'is-invalid' : '' ?>" placeholder="Masukkan catatan disposisi..."><?= old('catatan', $disposisi['catatan']) ?></textarea>
                        <?php if ($validation->hasError('catatan')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('catatan') ?>
                            </div>
                        <?php endif; ?>
                        <small class="text-muted">Minimal 5 karakter</small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('admin/disposisi') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Perbarui Disposisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
