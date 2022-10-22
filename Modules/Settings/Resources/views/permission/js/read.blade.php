<script>
"use strict";
$(document).ready(function () {
    var datatable = $("#kt_datatable_example_5").DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url:"{{ route('settings.permission') }}",
            data:{
                brand_code:function(){ return $('#check-brand').val(); }
            }
        },
        columns: [
            {data: 'action', name: 'action'},
            {
            "data":null, "sortable":false, "orderable":false,
                render: function(data, type, row, meta){
                    return meta.row + meta.settings._iDisplayStart+1
                }
            },
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},

        ],
        dom:
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
    });
});
</script>
