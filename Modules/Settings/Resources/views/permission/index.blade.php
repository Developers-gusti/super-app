@extends('layouts.app')
@section('content')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">@lang('label.menu.permission')
            <!--begin::Separator-->
            <span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
            <!--end::Separator-->
            <!--begin::Description-->
            <!--end::Description--></h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <!--begin::Filter menu-->
            <div class="m-0">
                <!--begin::Menu toggle-->
                <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"><i class="bi bi-funnel-fill"></i> Filter</a>
                <!--end::Menu toggle-->
               
            </div>
            <!--end::Filter menu-->
            <!--begin::Secondary button-->
            <!--end::Secondary button-->
            <!--begin::Primary button-->
            @can('create_permission')
                    <button type="button"  id="addButton" class="btn btn-sm btn-primary" ><i class="bi bi-person-plus-fill mr-2"></i> @lang('settings::label.permission.form.create_permission')</button>
                    @endcan
            <!--end::Primary button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-xl-stretch">
                    <div class="card-body pt-5">
                        <table id="kt_datatable_example_5" class="table table-row-bordered gy-2 gs-5 border rounded">
                            <thead class="fs-8">
                                <tr class="fw-bolder text-gray-800 px-7">
                                    
                                    <th>No</th>
                                    <th>@lang('settings::label.permission.table.name')</th>
                                    <th>@lang('settings::label.permission.table.created_at')</th>
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
                        <label for="name">@lang('settings::label.permission.table.name')<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Ex: function_menu">
                        <div class="fv-plugins-message-container invalid-feedback" id="error-name"></div>
                    </div>
                    <div class="form-grou mb-7">
                        <label class="mb-5" for="role">@lang('settings::label.permission.form.give_permission')<span class="text-danger">*</span></label>
                        @foreach ($role as $item)
                        <label class="form-check form-check-custom form-check-solid mb-3">
                            <input class="form-check-input roles" type="checkbox" name="role[]" id="{{ $item->name.$item->id }}" value="{{ $item->id }}"/>
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
            responsive: true,
            ajax:{
                url:"{{ route('settings.permission') }}",
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
            resetForm();
            $('.modal-title').html('@lang('settings::label.permission.form.create_permission')');
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
            resetForm();
            $('#name').attr('readonly',true);
            var id = $(this).data('id');
            var url = '{{ route("settings.permission.edit", ":id") }}';
            url = url.replace(':id', id );
            $.get(url, function (data) {
                $('.modal-title').html("@lang('settings::label.permission.form.create_permission')");
                $('#modalForm').modal('show');
                $('#id').val(data.permission.id);
                $('#name').val(data.permission.name);
                $.each(data.roles, function( index, value ) {
                    $('#'+value.name+value.id).attr('checked',true);
                });
            })
        });
        $('body').on('click', '.deleteData', function () {
            resetForm();
            const id = $(this).data('id');
            const name = $(this).data('name');
            var url = '{{ route("settings.permission.delete", ":id") }}';
            url = url.replace(':id', id );
            Swal.fire({
                title: "@lang('label.button.delete') : "+name,
                text: "@lang('label.confirmation_delete')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "@lang('label.button.continue')",
                cancelButtonText: "@lang('label.button.cancel')",
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
                            Swal.fire({
                                text:"@lang('messages.success.delete_data', ['title' => '"+name+"'])",
                                icon:"success",
                                buttonsStyling:!1,
                                confirmButtonText:"@lang('label.button.ok')",
                                customClass:{
                                confirmButton:"btn btn-primary"
                                }
                            });
                            datatable.draw();
                        },
                        error:function(xhr, status, error){
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
                }
            })
        });
    });
    function resetForm(){
        $('.roles').removeAttr('checked');
        $('#name').attr('readonly',false);
        $('#name').removeClass('is-invalid');
        $('#error-name').html('');
        $('#error-role').html('');
        $('#data-form').trigger('reset');
    }
</script>
@endsection
