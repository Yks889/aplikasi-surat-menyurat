<?= $this->extend('layouts/operator') ?>
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
    <!-- Notification Alert -->
    <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div><?= session()->getFlashdata('message') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Dashboard Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Overview</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <form method="get" class="d-flex flex-column flex-md-row gap-2">
                <div class="position-relative">
                    <select name="bulan" id="bulan" class="form-select pe-4">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= ($i == $bulan) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="position-relative">
                    <select name="tahun" id="tahun" class="form-select pe-4">
                        <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                            <option value="<?= $y ?>" <?= ($y == $tahun) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="/operator/dashboard" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="mb-2"><?= $totalSuratMasuk ?></h3>
                            <p class="text-muted mb-3">Surat Masuk</p>
                            <a href="/operator/surat-masuk" class="btn btn-sm btn-outline-primary">
                                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-envelope fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="mb-2"><?= $totalSuratKeluar ?></h3>
                            <p class="text-muted mb-3">Surat Keluar</p>
                            <a href="/operator/surat-keluar" class="btn btn-sm btn-outline-primary">
                                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-envelope-open fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Documents Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <ul class="nav nav-tabs card-header-tabs" id="documentsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="incoming-tab" data-bs-toggle="tab" data-bs-target="#incoming" type="button" role="tab">
                        <i class="bi bi-envelope me-2"></i>Surat Masuk Terbaru
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="outgoing-tab" data-bs-toggle="tab" data-bs-target="#outgoing" type="button" role="tab">
                        <i class="bi bi-envelope-open me-2"></i>Surat Keluar Terbaru
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="documentsTabContent">
                <!-- Incoming Mail Tab -->
                <div class="tab-pane fade show active" id="incoming" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Pengirim</th>
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
                    <div class="d-flex justify-content-end mt-3">
                        <a href="/operator/surat-masuk" class="btn btn-link">
                            Lihat Semua Surat Masuk <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Outgoing Mail Tab -->
                <div class="tab-pane fade" id="outgoing" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentSuratKeluar as $index => $surat): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($surat['nomor_surat']) ?></td>
                                    <td><?= esc($surat['untuk']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($surat['tanggal_surat'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="/operator/surat-keluar" class="btn btn-link">
                            Lihat Semua Surat Keluar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>