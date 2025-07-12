<?= $this->extend('layouts/operator') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
   <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-envelope-plus me-2 text-primary"></i>Tambah Surat Keluar</h2>
        </div>
        <div>
            <a href="/admin/surat-masuk" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="/operator/surat-keluar/simpan" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Perusahaan -->
                        <div class="mb-3">
                            <label for="perusahaan_id" class="form-label">Perusahaan</label>
                            <select class="form-select <?= ($validation->hasError('perusahaan_id')) ? 'is-invalid' : '' ?>"
                                    id="perusahaan_id" name="perusahaan_id" onchange="generateNomorSurat()">
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach ($perusahaan as $pt): ?>
                                    <option 
                                        value="<?= $pt['id'] ?>" 
                                        data-singkatan="<?= esc($pt['singkatan']) ?>" 
                                        <?= old('perusahaan_id') == $pt['id'] ? 'selected' : '' ?>>
                                        <?= esc($pt['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= esc($validation->getError('perusahaan_id')) ?></div>
                        </div>

                        <!-- Tanggal Surat -->
                        <div class="mb-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control <?= ($validation->hasError('tanggal_surat')) ? 'is-invalid' : '' ?>"
                                   id="tanggal_surat" name="tanggal_surat"
                                   value="<?= old('tanggal_surat', date('Y-m-d')) ?>" onchange="generateNomorSurat()">
                            <div class="invalid-feedback"><?= esc($validation->getError('tanggal_surat')) ?></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Jenis Surat -->
                        <div class="mb-3">
                            <label for="jenis_surat" class="form-label">Jenis Surat</label>
                            <select class="form-select <?= ($validation->hasError('jenis_surat')) ? 'is-invalid' : '' ?>"
                                    id="jenis_surat" name="jenis_surat" onchange="generateNomorSurat()">
                                <option value="">-- Pilih Jenis Surat --</option>
                                <?php foreach ($jenis_surat as $jenis): ?>
                                    <option 
                                        value="<?= $jenis['id'] ?>" 
                                        data-singkatan="<?= esc($jenis['singkatan']) ?>"
                                        <?= old('jenis_surat') == $jenis['id'] ? 'selected' : '' ?>>
                                        <?= esc($jenis['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= esc($validation->getError('jenis_surat')) ?></div>
                        </div>

                        <!-- Nomor Surat -->
                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_surat')) ? 'is-invalid' : '' ?>"
                                   id="nomor_surat" name="nomor_surat" readonly
                                   value="<?= old('nomor_surat') ?>">
                            <div class="invalid-feedback"><?= esc($validation->getError('nomor_surat')) ?></div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Untuk -->
                        <div class="mb-3">
                            <label for="untuk" class="form-label">Kepada Siapa</label>
                            <input type="text" class="form-control <?= ($validation->hasError('untuk')) ? 'is-invalid' : '' ?>"
                                   id="untuk" name="untuk" value="<?= old('untuk') ?>">
                            <div class="invalid-feedback"><?= esc($validation->getError('untuk')) ?></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Penandatangan -->
                        <div class="mb-3">
                            <label for="penandatangan_id" class="form-label">Penandatangan</label>
                            <select class="form-select <?= ($validation->hasError('penandatangan_id')) ? 'is-invalid' : '' ?>"
                                    id="penandatangan_id" name="penandatangan_id">
                                <option value="">-- Pilih Penandatangan --</option>
                                <?php foreach ($penandatangan as $admin): ?>
                                    <option value="<?= $admin['id'] ?>" <?= old('penandatangan_id') == $admin['id'] ? 'selected' : '' ?>>
                                        <?= esc($admin['full_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= esc($validation->getError('penandatangan_id')) ?></div>
                        </div>
                    </div>
                </div>

                <!-- Perihal -->
                <div class="mb-3">
                    <label for="perihal" class="form-label">Perihal</label>
                    <input type="text" class="form-control <?= ($validation->hasError('perihal')) ? 'is-invalid' : '' ?>"
                           id="perihal" name="perihal" value="<?= old('perihal') ?>">
                    <div class="invalid-feedback"><?= esc($validation->getError('perihal')) ?></div>
                </div>

                <!-- File Surat -->
                <div class="mb-4">
                    <label for="file_surat" class="form-label">File Surat</label>
                    <input type="file" class="form-control <?= ($validation->hasError('file_surat')) ? 'is-invalid' : '' ?>"
                           id="file_surat" name="file_surat">
                    <div class="invalid-feedback"><?= esc($validation->getError('file_surat')) ?></div>
                    <small class="text-muted">Format: PDF/DOC/JPEG/PNG (Maks. 5MB)</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    // Display selected file name
    document.getElementById('file_surat').addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || 'Pilih file';
        var nextSibling = e.target.nextElementSibling;
        if (nextSibling && nextSibling.nodeName === 'SMALL') {
            e.target.previousElementSibling.textContent = fileName;
        }
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

        const urutan = "001"; // default sementara

        const nomor = `${urutan}/${perusahaanSingkatan}-${jenisSingkatan}/${bulan}/${tahun}`;
        document.getElementById('nomor_surat').value = nomor;
    }
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>