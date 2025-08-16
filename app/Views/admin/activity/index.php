<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />
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

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
        <h2 class="h4 mb-1"><i class="bi bi-journal-text me-2 text-primary"></i>Aktivitas User</h2>
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
                <table class="table table-hover mb-0" id="activityTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th style="min-width: 150px;">User Name</th>
                            <th>Role</th>
                            <th>Judul Aktivitas</th>
                            <th>Deskripsi</th>
                            <th>Jenis</th>
                            <th>Waktu</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($activity as $act): 
                            $activityDate = date('Y-m-d', strtotime($act->created_at));
                            $activityTime = date('H:i:s', strtotime($act->created_at));
                        ?>
                        <tr data-date="<?= $activityDate ?>" data-time="<?= $activityTime ?>" data-role="<?= esc($act->role) ?>">
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-wrap" style="min-width: 150px;"><?= esc($act->username) ?></td>
                            <td>
                                <span class="badge <?= $act->role == 'admin' ? 'bg-danger' : ($act->role == 'operator' ? 'bg-primary' : 'bg-secondary') ?>">
                                    <?= esc($act->role) ?>
                                </span>
                            </td>
                            <td><?= esc($act->title) ?></td>
                            <td><?= esc($act->description) ?></td>
                            <td><?= esc($act->type) ?></td>
                            <td><?= $activityTime ?></td>
                            <td><?= date('d-m-Y', strtotime($act->created_at)) ?></td>
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
        <form method="get" class="modal-content" id="filterForm">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel"><i class="bi bi-funnel me-2"></i>Filter Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label for="filter_date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="filter_date" name="filter_date" value="<?= $filter_date ?? '' ?>">
                </div>
                <div class="col-md-6">
                    <label for="filter_time" class="form-label">Waktu (Opsional)</label>
                    <input type="time" class="form-control" id="filter_time" name="filter_time" value="<?= $filter_time ?? '' ?>">
                </div>
                <div class="col-md-12">
                    <label for="filter_role" class="form-label">Role</label>
                    <select name="filter_role" id="filter_role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="admin" <?= ($filter_role ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="operator" <?= ($filter_role ?? '') == 'operator' ? 'selected' : '' ?>>Operator</option>
                        <option value="user" <?= ($filter_role ?? '') == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel-fill me-1"></i> Terapkan
                </button>
                <button type="button" class="btn btn-outline-secondary" id="resetFilter">Reset</button>
            </div>
        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#activityTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Tidak ada data yang tersedia",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            // Server-side processing to ensure all data is available for filtering
            processing: true,
            serverSide: false, // Changed to false to ensure all data is loaded for filtering
            deferRender: true,
            // Custom filtering function
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    // Add filtering for specific columns if needed
                });
                
                // Apply any existing filters from URL parameters
                applyUrlFilters();
            }
        });

        // Function to apply filters from URL parameters
        function applyUrlFilters() {
            const urlParams = new URLSearchParams(window.location.search);
            const dateParam = urlParams.get('filter_date');
            const timeParam = urlParams.get('filter_time');
            const roleParam = urlParams.get('filter_role');
            
            if (dateParam || timeParam || roleParam) {
                $('#filter_date').val(dateParam || '');
                $('#filter_time').val(timeParam || '');
                $('#filter_role').val(roleParam || '');
                applyFilters();
            }
        }

        // Function to apply filters
        function applyFilters() {
            var dateFilter = $('#filter_date').val();
            var timeFilter = $('#filter_time').val();
            var roleFilter = $('#filter_role').val();
            
            // Combine all filters
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var rowDate = table.row(dataIndex).data()[7]; // Tanggal column index (changed from 8 to 7)
                    var rowTime = table.row(dataIndex).data()[6]; // Waktu column index (changed from 7 to 6)
                    var rowRole = table.row(dataIndex).data()[2]; // Role column index (changed from 3 to 2)
                    
                    // Convert displayed date format (dd-mm-yyyy) back to yyyy-mm-dd for comparison
                    var displayedDateParts = rowDate.split('-');
                    var formattedRowDate = displayedDateParts[2] + '-' + displayedDateParts[1] + '-' + displayedDateParts[0];
                    
                    var dateMatch = !dateFilter || formattedRowDate === dateFilter;
                    var timeMatch = !timeFilter || rowTime.includes(timeFilter);
                    var roleMatch = !roleFilter || rowRole.toLowerCase().includes(roleFilter.toLowerCase());
                    
                    return dateMatch && timeMatch && roleMatch;
                }
            );
            
            table.draw();
            
            // Remove the custom filter function so it doesn't stack
            $.fn.dataTable.ext.search.pop();
        }

        // Apply filters when form is submitted
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            applyFilters();
            $('#filterModal').modal('hide');
            
            // Update URL with filter parameters
            const params = new URLSearchParams();
            if ($('#filter_date').val()) params.set('filter_date', $('#filter_date').val());
            if ($('#filter_time').val()) params.set('filter_time', $('#filter_time').val());
            if ($('#filter_role').val()) params.set('filter_role', $('#filter_role').val());
            
            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.history.pushState({}, '', newUrl);
        });

        // Reset filters
        $('#resetFilter').on('click', function() {
            $('#filter_date').val('');
            $('#filter_time').val('');
            $('#filter_role').val('');
            
            // Clear all filters
            table.search('').columns().search('').draw();
            
            $('#filterModal').modal('hide');
            window.history.pushState({}, document.title, window.location.pathname);
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>