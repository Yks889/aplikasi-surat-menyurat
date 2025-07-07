<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-lg-4 col-md-6">
        <div class="card bg-primary text-white shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title mb-0"><?= $totalSuratMasuk ?></h3>
                    <div class="icon-circle bg-white bg-opacity-25">
                        <i class="bi bi-envelope fs-4"></i>
                    </div>
                </div>
                <p class="card-text mb-3">Surat Masuk</p>
                <a href="/user/history-surat-masuk" class="mt-auto btn btn-sm btn-light align-self-start">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Aktivitas -->
<div class="row g-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentActivities)): ?>
                    <p class="text-muted">Belum ada aktivitas.</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($recentActivities as $activity): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?= esc($activity['title']) ?></h6>
                                <small><?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></small>
                            </div>
                            <p class="mb-1"><?= esc($activity['description']) ?></p>
                            <small class="text-muted"><?= esc($activity['type']) ?></small>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
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
.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>

<?= $this->endSection() ?>
