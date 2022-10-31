@extends('layouts.app')
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-xl-stretch">
                    <div class="card-header">
                        <h3 class="card-title">@lang('label.menu.role')</h3>
                        <div class="card-toolbar">
                            @can('create_role')
                            <a href="{{ route('settings.role.create') }}" class="btn btn-sm btn-primary" ><i class="bi bi-person-plus-fill mr-2"></i> @lang('settings::label.role.create_role')</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <table id="kt_datatable_example_5" class="table table-row-bordered gy-2 gs-5 border rounded">
                            <thead class="fs-8">
                                <tr class="fw-bolder text-gray-800 px-7">
                                    <th>@lang('label.no')</th>
                                    <th>@lang('settings::label.role.name')</th>
                                    <th>@lang('label.created_at')</th>
                                    <th >@lang('label.action')</th>
                                </tr>
                            </thead>
                            <tbody class="fs-8" style="vertical-align: middle;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalForm" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">

                </div>
            </div>
            <form id="data-form">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="form-group mb-7 ">
                    <label for="name">@lang('settings::label.role.name')<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="name" name="name">
                    <div class="fv-plugins-message-container invalid-feedback" id="error-name"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-bs-dismiss="modal">@lang('label.button.close')</button>
                <button type="submit" id="saveButton" class="btn btn-success font-weight-bold">@lang('label.button.save')</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var datatable = $("#kt_datatable_example_5").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax:{
                url:"{{ route('settings.role') }}",
                data:{
                    brand_code:function(){ return $('#check-brand').val(); }
                }
            },
            columns: [
                {
                "data":null, "sortable":false, "orderable":false,
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart+1
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'},

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
        $('#addButton').on('click', function(){
            cleanError();
            $('.modal-title').html('@lang('settings::label.role.create_role')');
            $('#modalForm').modal('show');
        });
        $('#data-form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                method:'POST',
                url:'{{ route("settings.role.store") }}',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function(res){
                    $('#saveButton').attr('disabled',true);
                    $('#saveButton').html('@lang("label.button.process")');
                    $('#name').removeClass('is-invalid');
                    $('#error-name').html('');
                    $('#error-role').html('');
                },
                success:function(res){
                    $('#saveButton').attr('disabled',false);
                    $('#saveButton').html('@lang("label.button.save")');
                    if(res.result){
                        $('#modalForm').modal('hide');
                        datatable.draw();
                        _success(res.message);
                    }else{
                        if(res.message.name){
                            $('#error-name').html(res.message.name[0]);
                            $('#name').addClass('is-invalid');
                        }
                        if(res.message.role){
                            $('#error-role').html(res.message.role[0]);
                        }
                    }
                },
                error:function(xhr, status, error){
                    $('#saveButton').attr('disabled',false);
                    $('#saveButton').html('@lang("label.button.save")');
                    var err = eval("(" + xhr.responseText + ")");
                    _error(err.message);
                }
            })
        });
        $('body').on('click', '.deleteData', function () {
            cleanError();
            const id = $(this).data('id');
            const name = $(this).data('name');
            var url = '{{ route("settings.role.delete", ":id") }}';
            url = url.replace(':id', id );
            Swal.fire({
                title: '@lang("label.button.delete") : '+name,
                text: '@lang("label.confirmation_delete")',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang("label.button.continue")',
                cancelButtonText: '@lang("label.button.cancel")',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method:'DELETE',
                        url:url,
                        data:{
                            "id":id,
                            "_token": "{{ csrf_token() }}",
                        },
                        dataType:'JSON',
                        processData:true,
                        success:function(res){
                            _success("@lang('messages.success.delete_data', ['title' => '"+name+"'])");
                            datatable.draw();
                        },
                        error:function(xhr, status, error){
                            var err = eval("(" + xhr.responseText + ")");
                            _error(err.message);
                        }
                    })
                }
            })
        });
    });
    function cleanError(){
        $('.roles').removeAttr('checked');
        $('#name').attr('readonly',false);
        $('#name').removeClass('is-invalid');
        $('#error-name').html('');
        $('#error-role').html('');
        $('#data-form').trigger('reset');
    }
</script>
@endsection
