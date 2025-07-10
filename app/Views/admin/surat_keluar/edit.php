<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Surat Keluar</h3>
    </div>
    <div class="card-body">
        <form action="/admin/surat-keluar/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">
<div class="col-md-6">
    <label for="nomor_surat" class="form-label">Nomor Surat (Otomatis)</label>
    <input type="text" name="nomor_surat" id="nomor_surat"
        class="form-control" value="<?= old('nomor_surat', $surat['nomor_surat']) ?>" readonly>
    <small class="text-muted">Nomor ini akan digenerate ulang otomatis saat disimpan.</small>
</div>


                <div class="col-md-6">
                    <label for="perusahaan_id" class="form-label">Perusahaan</label>
                    <select name="perusahaan_id" id="perusahaan_id"
                        class="form-select <?= isset($validation) && $validation->hasError('perusahaan_id') ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Perusahaan --</option>
                        <?php foreach ($perusahaan as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= old('perusahaan_id', $surat['perusahaan_id']) == $p['id'] ? 'selected' : '' ?>>
                                <?= esc($p['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('perusahaan_id') : '' ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="jenis_surat" class="form-label">Jenis Surat</label>
                    <select name="jenis_surat" id="jenis_surat"
                        class="form-select <?= isset($validation) && $validation->hasError('jenis_surat') ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Jenis Surat --</option>
                        <?php foreach ($jenis_surat as $jenis): ?>
                            <option value="<?= $jenis['id'] ?>"
                                <?= old('jenis_surat', $surat['kode_surat']) == $jenis['singkatan'] ? 'selected' : '' ?>>
                                <?= esc($jenis['nama']) ?> (<?= esc($jenis['singkatan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('jenis_surat') : '' ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="untuk" class="form-label">Untuk</label>
                    <input type="text" name="untuk" id="untuk"
                        class="form-control <?= isset($validation) && $validation->hasError('untuk') ? 'is-invalid' : '' ?>"
                        value="<?= old('untuk', $surat['untuk']) ?>">
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('untuk') : '' ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="perihal" class="form-label">Perihal</label>
                    <input type="text" name="perihal" id="perihal"
                        class="form-control <?= isset($validation) && $validation->hasError('perihal') ? 'is-invalid' : '' ?>"
                        value="<?= old('perihal', $surat['perihal']) ?>">
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('perihal') : '' ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat"
                        class="form-control <?= isset($validation) && $validation->hasError('tanggal_surat') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_surat', $surat['tanggal_surat']) ?>">
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('tanggal_surat') : '' ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="penandatangan_id" class="form-label">Penandatangan</label>
                    <select name="penandatangan_id" id="penandatangan_id"
                        class="form-select <?= isset($validation) && $validation->hasError('penandatangan_id') ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Penandatangan --</option>
                        <?php foreach ($penandatangan as $admin): ?>
                            <option value="<?= $admin['id'] ?>" <?= old('penandatangan_id', $surat['penandatangan_id']) == $admin['id'] ? 'selected' : '' ?>>
                                <?= esc($admin['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('penandatangan_id') : '' ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="file_surat" class="form-label">File Surat (PDF/DOC/IMG)</label>
                    <input type="file" name="file_surat" id="file_surat"
                        class="form-control <?= isset($validation) && $validation->hasError('file_surat') ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('file_surat') : '' ?>
                    </div>
                    <?php if (!empty($surat['file_surat'])): ?>
                        <small class="text-muted">File saat ini:
                            <a href="/uploads/surat_keluar/<?= esc($surat['file_surat']) ?>" target="_blank">
                                <?= esc($surat['file_surat']) ?>
                            </a>
                        </small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update Surat
                </button>
                <a href="/admin/surat-keluar" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
