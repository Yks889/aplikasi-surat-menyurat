<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>Daftar Pengajuan Surat Keluar Langsung</h3>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <a href="/user/historypengajuan/create" class="btn btn-primary mb-3">+ Ajukan Baru</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Kepada</th>
                <th>Tanggal Diajukan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pengajuanSuratKeluar)) : ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada pengajuan surat keluar langsung.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($pengajuanSuratKeluar as $index => $pengajuan) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($pengajuan['judul']) ?></td>
                        <td><?= esc($pengajuan['deskripsi']) ?></td>
                        <td><?= esc($pengajuan['kepada']) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($pengajuan['created_at'])) ?></td>
                        <td>
                            <?php if ($pengajuan['status'] === 'belum'): ?>
                                <span class="badge bg-secondary">Belum diproses</span>
                            <?php elseif ($pengajuan['status'] === 'diterima'): ?>
                                <span class="badge bg-success">Diproses</span>
                            <?php elseif ($pengajuan['status'] === 'ditolak'): ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Status tidak diketahui</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>


<?= $this->endSection() ?>
