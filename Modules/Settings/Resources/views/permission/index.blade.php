@extends('layouts.app')
@section('content')
<div id="kt_header" style="background-color:rgb(255, 255, 255);" class="header align-items-stretch">
    <div class="container-fluid py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
        <div class="page-title d-flex justify-content-center flex-column me-5">
            <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">@lang('label.menu.permission')</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="/metronic8/demo8/../demo8/index.html" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Settings</li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark">Permission</li>
            </ul>
        </div>
        <div class="d-flex align-items-stretch overflow-auto pt-3 pt-lg-0">
            <div class="d-flex align-items-center">
                <div class="d-flex">
                    @can('create_permission')
                    <button type="button"  id="addButton" class="btn btn-sm btn-primary" ><i class="bi bi-person-plus-fill mr-2"></i> @lang('settings::label.permission.form.create_permission')</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch">
                        <div class="card-body pt-5">
                            <table id="kt_datatable_example_5" class="table table-row-bordered gy-2 gs-3 border rounded">
                                <thead class="fs-8">
                                    <tr class="fw-bolder text-gray-800 px-7">
                                        <th></th>
                                        <th width="5%">No</th>
                                        <th>@lang('settings::label.permission.table.name')</th>
                                        <th>@lang('settings::label.permission.table.created_at')</th>
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
                        <label for="name">@lang('settings::label.permission.table.name')<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Ex: function_menu">
                        <div class="fv-plugins-message-container invalid-feedback" id="error-name"></div>
                    </div>
                    <div class="form-grou mb-7">
                        <label class="mb-5" for="role">@lang('settings::label.permission.form.give_permission')<span class="text-danger">*</span></label>
                        @foreach ($role as $item)
                        <label class="form-check form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox" name="role[]" value="{{ $item->id }}"/>
                            <span class="form-check-label">
                                {{ strtoupper($item->name) }}
                            </span>
                        </label>
                        @endforeach
                        <div class="fv-plugins-message-container invalid-feedback" id="error-role"></div>
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
        $('#addButton').on('click', function(){
            $('.modal-title').html('@lang('settings::label.permission.form.create_permission')');
            $('#name').removeClass('is-invalid');
            $('#error-name').html('');
            $('#error-role').html('');
            $('#data-form').trigger('reset');
            $('#modalForm').modal('show');
        });
        $('#data-form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                method:'POST',
                url:'{{ route("settings.permission.store") }}',
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
                        Swal.fire({
                            text:res.message,
                            icon:"success",
                            buttonsStyling:!1,
                            confirmButtonText:"@lang('label.button.ok')",
                            customClass:{
                            confirmButton:"btn btn-primary"
                            }
                        });
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
                    Swal.fire({
                        text:err.message,
                        icon:"error",
                        buttonsStyling:!1,
                        confirmButtonText:"@lang('label.button.ok')",
                        customClass:{
                            confirmButton:"btn btn-primary"
                        }
                    });
                }
            })
        });
        $('body').on('click', '.updateData', function () {
            var code = $(this).data('id');
            $.get("{{ route('settings.permission.edit') }}" +'/' + code +'/edit', function (data) {
                $('.modal-title').html("@lang('settings::label.permission.form.create_permission')");
                $('#modalForm').modal('show');
                $('#name').val(data.name);
            })
        });
    });
</script>
@endsection
