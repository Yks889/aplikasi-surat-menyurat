<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title fs-5 mb-0">Tanda Tangan Digital</h3>
    </div>
    <div class="card-body">
        <?= view('components/alert') ?>
        
        <div class="row">
            <?php foreach ($tandaTangan as $ttd): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title fs-5 mb-0"><?= $ttd['full_name'] ?></h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="/uploads/tanda_tangan/<?= $ttd['file'] ?>" alt="Tanda Tangan <?= $ttd['full_name'] ?>" class="img-fluid" style="max-height: 150px;">
                        <p class="mt-2 text-muted">
                            Diupload pada: <?= date('d/m/Y H:i', strtotime($ttd['uploaded_at'])) ?>
                        </p>
                    </div>
                    <div class="card-footer text-center">
                        <button onclick="confirmDelete(<?= $ttd['id'] ?>)" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title fs-5 mb-0">Upload Tanda Tangan Baru</h4>
            </div>
            <div class="card-body">
                <form action="/admin/tanda-tangan/upload" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id">Admin</label>
                                <select class="form-control <?= ($validation->hasError('user_id')) ? 'is-invalid' : '' ?>" 
                                    id="user_id" name="user_id" required>
                                    <option value="">-- Pilih Admin --</option>
                                    <?php foreach ($admins as $admin): ?>
                                    <option value="<?= $admin['id'] ?>" <?= old('user_id') == $admin['id'] ? 'selected' : '' ?>>
                                        <?= $admin['full_name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('user_id') ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_ttd">File Tanda Tangan</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input <?= ($validation->hasError('file_ttd')) ? 'is-invalid' : '' ?>" 
                                        id="file_ttd" name="file_ttd" required>
                                    <label class="custom-file-label" for="file_ttd">Pilih file (JPEG/PNG)</label>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('file_ttd') ?>
                                    </div>
                                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    // Menampilkan nama file yang dipilih
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Tanda tangan akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/tanda-tangan/delete/' + id;
            }
        });
    }
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>