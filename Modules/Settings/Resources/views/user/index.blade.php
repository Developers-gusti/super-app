@extends('layouts.app')
@section('content')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">@lang('label.menu.user')
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
            @can('create_user')
                    <button type="button"  id="addButton" class="btn btn-sm btn-primary" ><i class="bi bi-person-plus-fill mr-2"></i> @lang('settings::label.user.create_user')</button>
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
        <div class="row gy-5 g-xl-8">
            <div class="col-xl-12">
                <div class="card card-xl-stretch">

                    <div class="card-body pt-5">
                        <table id="kt_datatable_example_5" class="table table-row-bordered gy-2 gs-5 border rounded">
                            <thead class="fs-8">
                                <tr class="fw-bolder text-gray-800 px-7">
                                    <th>@lang('label.no')</th>
                                    <th>@lang('label.username')</th>
                                    <th>@lang('label.email')</th>
                                    <th>@lang('label.action')</th>
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
<div class="modal bg-white fade" id="modalForm" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">

                </div>
            </div>
            <form id="data-form">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="id" id="id">
                <div id="user-section">
                    <div class="form-group mb-7 ">
                        <label for="name">@lang('label.username')<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name">
                        <div class="fv-plugins-message-container invalid-feedback" id="error-name"></div>
                    </div>
                    <div class="form-group mb-7 ">
                        <label for="email">@lang('label.email')<span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email">
                        <div class="fv-plugins-message-container invalid-feedback" id="error-email"></div>
                    </div>
                    <div class="form-grou mb-7">
                        <label class="mb-5" for="role">@lang('label.role')<span class="text-danger">*</span><label>
                        <select class="form-select form-select-sm" data-placeholder="Select an option" name="role" id="role">
                            <option></option>
                            @foreach ($role as $item)
                            <option value="{{ $item->name }}">{{ strtoupper($item->name) }}</option>
                            @endforeach
                        </select>
                        <div class="fv-plugins-message-container invalid-feedback" id="error-role"></div>
                    </div>
                </div>
                <div id="password-section">
                    <div class="form-group mb-7 ">
                        <label for="password">@lang('label.password')<span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm" id="password" name="password" maxlength="12" minlength="6">
                        <div class="fv-plugins-message-container invalid-feedback" id="error-password"></div>
                    </div>
                    <div class="form-group mb-7 ">
                        <label for="password_confirmation">@lang('label.password_confirmation')<span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" maxlength="12" minlength="6">
                        <div class="fv-plugins-message-container invalid-feedback" id="error-password_confirmation"></div>
                    </div>
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
        $('#role').select2({
            dropdownParent: $('#modalForm')
        });
        var datatable = $("#kt_datatable_example_5").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax:{
                url:"{{ route('settings.user') }}",
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
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action'},
            ],
            language: {
             "lengthMenu": "Show _MENU_",
            },
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
            $('.modal-title').html('@lang('settings::label.user.create_user')');
            $('#modalForm').modal('show');
            $('#data-form').trigger('reset');
            $('#password-section').show();
            cleanError();
        });
        $('body').on('click', '.editData', function () {
            cleanError();
            $('#password-section').hide();
            $('#email').attr('readonly',true);
            var id = $(this).data('id');
            var url = '{{ route("settings.user.edit", ":id") }}';
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
        $('#data-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "{{ route('settings.user.store') }}",
                data:new FormData(this),
                dataType: "JSON",
                contentType:false,
                cache:false,
                processData:false,
                beforeSend: function (response){
                    $('#saveButton').attr('disabled',true);
                    $('#saveButton').html('@lang("label.button.process")');
                    cleanError();
                },
                success: function (response) {
                    $('#saveButton').attr('disabled',false);
                    $('#saveButton').html('@lang("label.button.save")');
                    if (response.result) {
                        $('#saveButton').removeAttr('disabled');
                        $('#saveButton').html('@lang("label.button.save")');
                        datatable.draw();
                        $('#modalForm').modal('hide');
                        _success(response.message);
                    } else {
                        if (response.message.name) {
                            $('#name').addClass('is-invalid');
                            $('#error-name').html(response.message.name[0]);
                        }
                        if (response.message.email) {
                            $('#email').addClass('is-invalid');
                            $('#error-email').html(response.message.email[0]);
                        }
                        if (response.message.role) {
                            $('#role').addClass('is-invalid');
                            $('#error-role').html(response.message.role[0]);
                        }
                        if (response.message.password) {
                            $('#password').addClass('is-invalid');
                            $('#error-password').html(response.message.password[0]);
                        }
                    }
                },
                error:function(xhr, status, error){
                    $('#saveButton').attr('disabled',false);
                    $('#saveButton').html('@lang("label.button.save")');
                    var err = eval("(" + xhr.responseText + ")");
                    _error(err.message);
                }
            });
        });
    });
    function cleanError() {
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#role').removeClass('is-invalid');
        $('#password').removeClass('is-invalid');

        $('#error-name').html('');
        $('#error-email').html('');
        $('#error-role').html('');
        $('#error-password').html('');

    }
</script>
@endsection
