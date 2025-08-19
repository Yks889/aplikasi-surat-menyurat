<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between mb-4">
        <h2 class="h4"><i class="bi bi-envelope-check text-success me-2"></i>Proses Pengajuan Surat Keluar</h2>
        <a href="/admin/ajukan" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    </div>

    <!-- Detail Pengajuan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">Detail Pengajuan</div>
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th>Judul</th>
                    <td><?= esc($pengajuan['judul']) ?></td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td><?= esc($pengajuan['deskripsi']) ?></td>
                </tr>
                <tr>
                    <th>Dari</th>
                    <td><?= esc($pengajuan['dari']) ?></td>
                </tr>
                <tr>
                    <th>Kepada</th>
                    <td><?= esc($pengajuan['kepada']) ?></td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td><?= date('d/m/Y H:i', strtotime($pengajuan['created_at'])) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Form Tambah Surat Keluar -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">Isi Surat Keluar</div>
        <div class="card-body">
            <form action="/admin/surat-keluar/simpan" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="pengajuan_id" value="<?= $pengajuan['id'] ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Perusahaan</label>
                        <select name="perusahaan_id" id="perusahaan_id" class="form-select" onchange="generateNomorSurat()" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            <?php foreach ($perusahaan as $pt): ?>
                                <option value="<?= $pt['id'] ?>" data-singkatan="<?= $pt['singkatan'] ?>">
                                    <?= esc($pt['nama']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Surat</label>
                        <select name="jenis_surat" id="jenis_surat" class="form-select" onchange="generateNomorSurat()" required>
                            <option value="">-- Pilih Jenis --</option>
                            <?php foreach ($jenis_surat as $j): ?>
                                <option value="<?= $j['id'] ?>" data-singkatan="<?= $j['singkatan'] ?>">
                                    <?= esc($j['nama']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Surat</label>
                        <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat"
                            value="<?= date('Y-m-d') ?>" onchange="generateNomorSurat()" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" readonly>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Kepada Siapa</label>
                        <input type="text" class="form-control" name="untuk"
                            value="<?= esc($pengajuan['kepada']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Penandatangan</label>
                        <select name="penandatangan_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($penandatangan as $ttd): ?>
                                <option value="<?= $ttd['id'] ?>"><?= esc($ttd['nama']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Perihal</label>
                    <input type="text" class="form-control" name="perihal" value="<?= esc($pengajuan['judul']) ?>" required>
                </div>

                <div class="mt-3">
                    <label class="form-label">File Surat</label>
                    <input type="file" name="file_surat" class="form-control" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
                    <a href="/admin/ajukan" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
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
        const urutan = "001"; // bisa diganti backend

        document.getElementById('nomor_surat').value = `${urutan}/${perusahaanSingkatan}-${jenisSingkatan}/${bulan}/${tahun}`;
    }
</script>
<?= $this->endSection() ?>