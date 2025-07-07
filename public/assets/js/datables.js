// Extended DataTables Configuration
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Cari...",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        zeroRecords: "Tidak ada data yang ditemukan",
        paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Selanjutnya",
            previous: "Sebelumnya"
        }
    },
    responsive: true,
    autoWidth: false,
    processing: true,
    serverSide: false,
    pageLength: 10,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
         '<"row"<"col-sm-12"tr>>' +
         '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
    initComplete: function() {
        // Add custom class to length menu
        this.api().buttons().container().addClass('btn-group');
        
        // Style the pagination buttons
        $(this).closest('.dataTables_wrapper').find('.dataTables_paginate').addClass('pagination-sm');
    },
    drawCallback: function() {
        // Add tooltips to buttons after table is drawn
        $('[data-toggle="tooltip"]').tooltip();
    }
});

// Custom function to refresh DataTables
function refreshDataTable(tableId) {
    if ($.fn.DataTable.isDataTable(tableId)) {
        $(tableId).DataTable().ajax.reload(null, false);
    }
}

// Custom function to initialize DataTable with AJAX
function initAjaxDataTable(tableId, ajaxUrl, columns) {
    return $(tableId).DataTable({
        ajax: ajaxUrl,
        columns: columns,
        createdRow: function(row, data, dataIndex) {
            // Add custom attributes or classes to rows if needed
            if (data.status === 'inactive') {
                $(row).addClass('table-danger');
            }
        }
    });
}