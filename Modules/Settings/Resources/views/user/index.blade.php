@extends('layouts.app')
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row gy-5 g-xl-8">
            <div class="col-xl-12">
                <div class="card card-xl-stretch">
                    <div class="card-header">
                        <h3 class="card-title">@lang('label.menu.user')</h3>
                        <div class="card-toolbar">
                            @can('create_user')
                            <button type="button"  id="addButton" class="btn btn-sm btn-primary" ><i class="bi bi-person-plus-fill mr-2"></i> @lang('settings::label.user.create_user')</button>
                            @endcan
                        </div>
                    </div>
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
<div class="modal fade" id="modalForm" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                <div class="form-group mb-7 ">
                    <label for="email">@lang('label.email')<span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email">
                    <div class="fv-plugins-message-container invalid-feedback" id="error-email"></div>
                </div>
                <div id="user-section">
                    <div class="form-group mb-7 ">
                        <label for="name">@lang('label.username')<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name">
                        <div class="fv-plugins-message-container invalid-feedback" id="error-name"></div>
                    </div>
                    <div class="form-group mb-7">
                        <label for="" class="form-label">@lang('label.role')</label>
                        <select class="form-select form-select-sm " data-control="select2" data-dropdown-parent="#modalForm" name="role" id="role" data-placeholder="Select an option" data-allow-clear="true">
                            <option></option>
                            <option value=""></option>
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
            $('#email').addClass('form-control-solid');

            var id = $(this).data('id');
            var url = '{{ route("settings.user.edit", ":id") }}';
            url = url.replace(':id', id );
            $.get(url, function (response) {
                $('.modal-title').html("@lang('settings::label.user.edit_user')");
                $('#modalForm').modal('show');
                $('#id').val(response.user.id);
                $('#name').val(response.user.name);
                $('#email').val(response.user.email);
                $('#role').val(response.roles[0]);
                $('#role').trigger('change');

            })
        });
        $('body').on('click', '.changePassword', function () {
            cleanError();
            $('#email').attr('readonly',true);
            $('#email').addClass('form-control-solid');
            var id = $(this).data('id');
            var email = $(this).data('email');
            $('#password-section').show();
            $('#user-section').hide();
            $('.modal-title').html("@lang('settings::label.user.edit_user')");
            $('#modalForm').modal('show');
            $('#id').val(id);
            $('#email').val(email);

        });
        $('body').on('click', '.deleteData', function () {
            cleanError();
            const id = $(this).data('id');
            const name = $(this).data('name');
            var url = '{{ route("settings.user.delete", ":id") }}';
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
                            _error(err.message);
                        }
                    })
                }
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
        $('#email').attr('readonly',false);
        $('#email').removeClass('form-control-solid');

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
