<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
<link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />
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

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-envelope me-2 text-primary"></i>Daftar Surat Masuk</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
            <a href="/admin/surat-masuk/tambah" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-plus-circle me-1"></i> Tambah
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 modern-table" id="suratMasukTable">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nomor Surat</th>
                            <th>Perusahaan</th>
                            <th>Dari</th>
                            <th>Perihal</th>
                            <th>Tgl. Surat</th>
                            <th>Tgl. Diterima</th>
                            <th>Pengirim</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($suratMasuk as $index => $surat): ?>
                            <tr>
                                <td class="ps-4"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-semibold"><?= esc($surat['nomor_surat']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark"><?= esc($surat['perusahaan']) ?></span>
                                </td>
                                <td><?= esc($surat['dari']) ?></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="<?= esc($surat['perihal']) ?>">
                                        <?= esc($surat['perihal']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-nowrap">
                                        <?= date('d/m/Y', strtotime($surat['tgl_surat'])) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-nowrap">
                                        <?= date('d/m/Y H:i', strtotime($surat['waktu_diterima'])) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span><?= esc($surat['pengirim'] ?? '-') ?></span>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="/uploads/surat_masuk/<?= esc($surat['file_surat']) ?>" target="_blank" class="btn btn-sm btn-icon btn-outline-primary" title="Lihat File">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </a>
                                        <a href="/admin/disposisi/detail/<?= $surat['id'] ?>" class="btn btn-sm btn-icon btn-outline-info" title="Detail Disposisi">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                        <a href="/admin/surat-masuk/edit/<?= $surat['id'] ?>" class="btn btn-sm btn-icon btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $surat['id'] ?>)" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalDisposisi<?= $surat['id'] ?>">
                                            <i class="bi bi-send"></i>
                                        </button>
                                    </div>

                                    <!-- Disposisi Modal -->
                                    <div class="modal fade" id="modalDisposisi<?= $surat['id'] ?>" tabindex="-1" aria-labelledby="modalDisposisiLabel<?= $surat['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <form action="<?= base_url('admin/surat-masuk/' . $surat['id'] . '/disposisi') ?>" method="post">
                                                <?= csrf_field() ?>
                                                <div class="modal-content">
                                                    <div class="modal-header text-black">
                                                        <h5 class="modal-title" id="modalDisposisiLabel<?= $surat['id'] ?>">
                                                            <i class="bi bi-send me-2 text-primary"></i>Buat Disposisi
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Nomor Surat</label>
                                                                <input type="text" class="form-control" value="<?= esc($surat['nomor_surat']) ?>" readonly>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Perihal</label>
                                                                <input type="text" class="form-control" value="<?= esc($surat['perihal']) ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label for="catatan" class="form-label fw-bold">Catatan Disposisi</label>
                                                            <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan instruksi atau catatan disposisi..." required></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Tujuan Disposisi</label>
                                                            <div class="border rounded p-3 bg-light" style="max-height: 300px; overflow-y: auto;">
                                                                <div class="row g-3">
                                                                    <?php foreach ($users as $user): ?>
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="form-check d-flex align-items-center p-3 bg-white rounded shadow-sm border">
                                                                                <input class="form-check-input ms-auto me-2" type="checkbox" name="ke_user_ids[]" value="<?= $user['id'] ?>" id="user<?= $user['id'] ?>_<?= $surat['id'] ?>">
                                                                                <label class="form-check-label w-100" for="user<?= $user['id'] ?>_<?= $surat['id'] ?>">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="avatar me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-weight: bold;">
                                                                                            <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                                                                        </div>
                                                                                        <div>
                                                                                            <div class="fw-medium"><?= esc($user['full_name']) ?></div>
                                                                                            <small class="text-muted"><?= esc($user['jabatan'] ?? '-') ?></small>
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle me-1"></i> Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-send-check me-1"></i> Kirim Disposisi
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="get" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel"><i class="bi bi-funnel me-2"></i>Filter Surat Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                            <option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="perusahaan_id" class="form-label">Perusahaan</label>
                    <select name="perusahaan_id" id="perusahaan_id" class="form-select">
                        <option value="">Semua Perusahaan</option>
                        <?php foreach ($perusahaanList as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= $p['id'] == $perusahaan_id ? 'selected' : '' ?>>
                                <?= esc($p['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel-fill me-1"></i> Terapkan
                </button>
                <a href="/admin/surat-masuk/reset-filter" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<style>
.modern-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.modern-table thead th {
    background: linear-gradient(to bottom, #f8f9fc, #e9ecef);
    border-bottom: 2px solid #dee2e6;
    padding: 12px 16px;
    font-weight: 600;
    color: #495057;
    vertical-align: middle;
    position: sticky;
    top: 0;
    z-index: 10;
}

.modern-table tbody td {
    padding: 16px;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.modern-table tbody tr {
    transition: all 0.2s ease;
}

.modern-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

.modern-table .btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.modern-table .btn-icon:hover {
    transform: translateY(-2px);
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
    font-size: 0.75em;
}

@media (max-width: 768px) {
    .modern-table {
        display: block;
        overflow-x: auto;
    }
    
    .modern-table thead th {
        padding: 10px 12px;
        font-size: 0.875rem;
    }
    
    .modern-table tbody td {
        padding: 12px;
        font-size: 0.875rem;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#suratMasukTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>'
        });

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '<?= session()->getFlashdata('error') ?>',
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('message')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= session()->getFlashdata('message') ?>',
            });
        <?php endif; ?>
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Surat?',
            text: "Data surat akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/surat-masuk/delete/' + id;
            }
        });
    }
</script>
<?= $this->endSection() ?>