<?= $this->extend('layouts/operator') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Notification Alert -->
    <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="h4 mb-1"><i class="bi bi-send me-2 text-primary"></i>History Disposisi Surat</h2>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="disposisiTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nomor Surat</th>
                            <th>Dari</th>
                            <th>Kepada</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Dibaca Pada</th>
                            <th>Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grouped = [];
                        foreach ($disposisi as $d) {
                            $key = $d['nomor_surat'] . '|' . $d['dari_nama'];
                            if (!isset($grouped[$key])) {
                                $grouped[$key] = [
                                    'nomor_surat' => $d['nomor_surat'],
                                    'dari_nama' => $d['dari_nama'],
                                    'file_surat' => $d['file_surat'],
                                    'created_at' => $d['created_at'],
                                    'catatan' => $d['catatan'],
                                    'id' => $d['id'],
                                    'details' => []
                                ];
                            }
                            $grouped[$key]['details'][] = [
                                'ke_nama' => $d['ke_nama'],
                                'status' => $d['status'],
                                'dibaca_pada' => $d['dibaca_pada']
                            ];
                        }
                        $index = 1;
                        ?>
                        <?php foreach ($grouped as $group): ?>
                        <tr>
                            <td class="text-center"><?= $index++ ?></td>
                            <td><?= esc($group['nomor_surat']) ?></td>
                            <td><?= esc($group['dari_nama']) ?></td>
                            <td>
                                <?php foreach ($group['details'] as $i => $det): ?>
                                    <?= esc($det['ke_nama']) ?><?= $i < count($group['details']) - 1 ? '<br>' : '' ?>
                                <?php endforeach ?>
                            </td>
                            <td><?= esc($group['catatan']) ?></td>
                            <td>
                                <?php foreach ($group['details'] as $i => $det): ?>
                                    <span class="badge bg-<?= $det['status'] == 'belum dibaca' ? 'secondary' : 'success' ?>">
                                        <?= ucfirst($det['status']) ?>
                                    </span><?= $i < count($group['details']) - 1 ? '<br>' : '' ?>
                                <?php endforeach ?>
                            </td>
                            <td>
                                <?php foreach ($group['details'] as $i => $det): ?>
                                    <?= $det['dibaca_pada'] ? date('d/m/Y H:i', strtotime($det['dibaca_pada'])) : '-' ?>
                                    <?= $i < count($group['details']) - 1 ? '<br>' : '' ?>
                                <?php endforeach ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($group['created_at'])) ?></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="/uploads/surat_masuk/<?= esc($group['file_surat']) ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat File">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                    <a href="<?= base_url('operator/disposisi/edit/' . $group['id']) ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $group['id'] ?>)" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="get" action="<?= base_url('operator/disposisi') ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel"><i class="bi bi-funnel me-2"></i>Filter Disposisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= isset($filter_bulan) && $i == $filter_bulan ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                        <option value="<?= $y ?>" <?= isset($filter_tahun) && $y == $filter_tahun ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="belum dibaca" <?= isset($filter_status) && $filter_status == 'belum dibaca' ? 'selected' : '' ?>>Belum Dibaca</option>
                        <option value="sudah dibaca" <?= isset($filter_status) && $filter_status == 'sudah dibaca' ? 'selected' : '' ?>>Sudah Dibaca</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="pengirim" class="form-label">Dari</label>
                    <select name="pengirim" id="pengirim" class="form-select">
                        <option value="">Semua Pengirim</option>
                        <?php foreach ($pengirimList ?? [] as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= isset($filter_pengirim) && $filter_pengirim == $p['id'] ? 'selected' : '' ?>>
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
                <a href="<?= base_url('operator/disposisi') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#disposisiTable').DataTable({
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
            }
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Disposisi?',
            text: "Data disposisi akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url() ?>operator/disposisi/delete/' + id;
            }
        });
    }
</script>
<?= $this->endSection() ?>
