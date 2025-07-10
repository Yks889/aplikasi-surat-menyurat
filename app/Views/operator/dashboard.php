<?= $this->extend('layouts/operator') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<!-- Filter Bulan & Tahun -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-4 col-sm-6">
                <label for="bulan" class="form-label">Pilih Bulan</label>
                <select name="bulan" id="bulan" class="form-select">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= ($i == $bulan) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 col-sm-6">
                <label for="tahun" class="form-label">Pilih Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                        <option value="<?= $y ?>" <?= ($y == $tahun) ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 col-sm-12 d-grid">
                <label class="form-label invisible">Tombol</label>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Surat Masuk -->
    <div class="col-12 col-md-6">
        <div class="card bg-primary text-white shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title mb-0"><?= $totalSuratMasuk ?></h3>
                    <div class="icon-circle bg-white bg-opacity-25">
                        <i class="bi bi-envelope fs-4"></i>
                    </div>
                </div>
                <p class="card-text mb-3">Surat Masuk</p>
                <a href="/admin/surat-masuk" class="mt-auto btn btn-sm btn-light align-self-start">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Surat Keluar -->
    <div class="col-12 col-md-6">
        <div class="card bg-success text-white shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title mb-0"><?= $totalSuratKeluar ?></h3>
                    <div class="icon-circle bg-white bg-opacity-25">
                        <i class="bi bi-envelope-open fs-4"></i>
                    </div>
                </div>
                <p class="card-text mb-3">Surat Keluar</p>
                <a href="/admin/surat-keluar" class="mt-auto btn btn-sm btn-light align-self-start">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Surat Masuk dan Keluar Terbaru -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Surat Masuk Terbaru</h5>
                <a href="/operator/surat-masuk" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nomor Surat</th>
                                <th>Dari</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentSuratMasuk as $index => $surat): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($surat['nomor_surat']) ?></td>
                                    <td><?= esc($surat['dari']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($surat['tgl_surat'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Surat Keluar Terbaru</h5>
                <a href="/operator/surat-keluar" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kode Surat</th>
                                <th>Untuk</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentSuratKeluar as $index => $surat): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($surat['kode_surat']) ?></td>
                                    <td><?= esc($surat['untuk']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($surat['tanggal_surat'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}
</style>

<?= $this->endSection() ?>
