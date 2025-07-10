<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php if (session('errors') && is_array(session('errors'))): ?>
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
        <h3 class="card-title fs-5 mb-0">Tambah Surat Keluar</h3>
    </div>
    <div class="card-body">
        <form action="/admin/surat-keluar/simpan" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <!-- Perusahaan -->
                    <div class="form-group">
                        <label for="perusahaan_id">Perusahaan</label>
                        <select class="form-control <?= ($validation->hasError('perusahaan_id')) ? 'is-invalid' : '' ?>"
                                id="perusahaan_id" name="perusahaan_id" onchange="generateNomorSurat()">
                            <option value="">-- Pilih Perusahaan --</option>
                            <?php foreach ($perusahaan as $pt): ?>
                                <option 
                                    value="<?= $pt['id'] ?>" 
                                    data-singkatan="<?= $pt['singkatan'] ?>" 
                                    <?= old('perusahaan_id') == $pt['id'] ? 'selected' : '' ?>>
                                    <?= $pt['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('perusahaan_id') ?></div>
                    </div>

                    <!-- Tanggal Surat -->
                    <div class="form-group">
                        <label for="tanggal_surat">Tanggal Surat</label>
                        <input type="date" class="form-control <?= ($validation->hasError('tanggal_surat')) ? 'is-invalid' : '' ?>"
                               id="tanggal_surat" name="tanggal_surat"
                               value="<?= old('tanggal_surat', date('Y-m-d')) ?>" onchange="generateNomorSurat()">
                        <div class="invalid-feedback"><?= $validation->getError('tanggal_surat') ?></div>
                    </div>

                    <!-- Jenis Surat -->
                    <div class="form-group">
                        <label for="jenis_surat">Jenis Surat</label>
                        <select class="form-control <?= ($validation->hasError('jenis_surat')) ? 'is-invalid' : '' ?>"
                                id="jenis_surat" name="jenis_surat" onchange="generateNomorSurat()">
                            <option value="">-- Pilih Jenis Surat --</option>
                            <?php foreach ($jenis_surat as $pt): ?>
                                <option 
                                    value="<?= $pt['id'] ?>"
                                    data-singkatan="<?= $pt['singkatan'] ?>"
                                    <?= old('jenis_surat') == $pt['id'] ? 'selected' : '' ?>>
                                    <?= $pt['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('jenis_surat') ?></div>
                    </div>

                    <!-- Nomor Surat (Auto) -->
                    <div class="form-group">
                        <label for="nomor_surat">Nomor Surat</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nomor_surat')) ? 'is-invalid' : '' ?>"
                               id="nomor_surat" name="nomor_surat" readonly
                               value="<?= old('nomor_surat') ?>">
                        <div class="invalid-feedback"><?= $validation->getError('nomor_surat') ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Untuk -->
                    <div class="form-group">
                        <label for="untuk">Kepada Siapa</label>
                        <input type="text" class="form-control <?= ($validation->hasError('untuk')) ? 'is-invalid' : '' ?>"
                               id="untuk" name="untuk" value="<?= old('untuk') ?>">
                        <div class="invalid-feedback"><?= $validation->getError('untuk') ?></div>
                    </div>

                    <!-- Penandatangan -->
                    <div class="form-group">
                        <label for="penandatangan_id">Penandatangan</label>
                        <select class="form-control <?= ($validation->hasError('penandatangan_id')) ? 'is-invalid' : '' ?>"
                                id="penandatangan_id" name="penandatangan_id">
                            <option value="">-- Pilih Penandatangan --</option>
                            <?php foreach ($penandatangan as $admin): ?>
                                <option value="<?= $admin['id'] ?>" <?= old('penandatangan_id') == $admin['id'] ? 'selected' : '' ?>>
                                    <?= $admin['full_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('penandatangan_id') ?></div>
                    </div>
                </div>
            </div>

            <!-- Perihal -->
            <div class="form-group">
                <label for="perihal">Perihal</label>
                <input type="text" class="form-control <?= ($validation->hasError('perihal')) ? 'is-invalid' : '' ?>"
                       id="perihal" name="perihal" value="<?= old('perihal') ?>">
                <div class="invalid-feedback"><?= $validation->getError('perihal') ?></div>
            </div>

            <!-- File -->
            <div class="form-group">
                <label for="file_surat">File Surat</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input <?= ($validation->hasError('file_surat')) ? 'is-invalid' : '' ?>"
                           id="file_surat" name="file_surat">
                    <label class="custom-file-label" for="file_surat">Pilih file (PDF/DOC/JPEG/PNG)</label>
                    <div class="invalid-feedback"><?= $validation->getError('file_surat') ?></div>
                    <small class="text-muted">Maksimal ukuran file: 5MB</small>
                </div>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="/admin/surat-keluar" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    function generateNomorSurat() {
        const perusahaanSelect = document.getElementById('perusahaan_id');
        const jenisSelect = document.getElementById('jenis_surat');
        const tglSurat = document.getElementById('tanggal_surat').value;

        const perusahaanSingkatan = perusahaanSelect.options[perusahaanSelect.selectedIndex]?.getAttribute('data-singkatan');
        const jenisSingkatan = jenisSelect.options[jenisSelect.selectedIndex]?.getAttribute('data-singkatan');

        if (!perusahaanSingkatan || !jenisSingkatan || !tglSurat) return;

        const date = new Date(tglSurat);
        const bulanRomawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        const bulan = bulanRomawi[date.getMonth()];
        const tahun = date.getFullYear();

        const urutan = "003"; // Sementara, nanti digantikan oleh backend

        const nomor = `${urutan}/${perusahaanSingkatan}-${jenisSingkatan}/${bulan}/${tahun}`;
        document.getElementById('nomor_surat').value = nomor;
    }
</script>
<?= $this->endSection() ?>
