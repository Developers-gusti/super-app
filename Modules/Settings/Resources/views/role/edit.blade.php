@extends('layouts.app')
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row">
            <form id="data-form">
            @csrf
            <input type="hidden" id="id" name="id">
            <div class="col-xl-12">
                <div class="card card-xl-stretch">
                    <div class="card-header">
                        <h3 class="card-title">@lang('settings::label.role.edit_role')</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">@lang('settings::label.role.name')</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="text" name="name" id="name" value="{{ $data_role->name }}" class="form-control form-control-solid" disabled>
                                <div class="fv-plugins-message-container invalid-feedback" id="error-name"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label ">@lang('label.menu.user')</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <div class="row">
                                    @foreach ($user as $item)
                                    <div class="col-lg-4 col-sm-6 form-check form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" name="permission_name[]" value="{{ $item->name }}" id="{{ $item->name }}" @if (in_array($item->name, $data_permission, true)) checked @endif/>
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label ">@lang('label.menu.role')</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <div class="row">
                                    @foreach ($role as $item)
                                    <div class="col-lg-4 col-sm-6 form-check form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" name="permission_name[]" value="{{ $item->name }}" id="{{ $item->name }}" @if (in_array($item->name, $data_permission, true)) checked @endif/>
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label ">@lang('label.menu.permission')</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <div class="row">
                                    @foreach ($permission as $item)
                                    <div class="col-lg-4 col-sm-6 form-check form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" name="permission_name[]" value="{{ $item->name }}" id="{{ $item->name }}" @if (in_array($item->name, $data_permission, true)) checked @endif/>
                                        <label class="form-check-label" for="{{ $item->name }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label "></label>

                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <div class="fv-plugins-message-container invalid-feedback" id="error-permission_name"></div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="saveButton" class="btn btn-primary">
                            @lang('label.button.save')
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
       $('#data-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ route('settings.role.update', $data_role->id) }}",
            data:new FormData(this),
            dataType:"JSON",
            contentType:false,
            cache:false,
            processData:false,
            beforeSend: function (response) {
                $('#saveButton').attr('disabled',true);
                $('#saveButton').html('@lang("label.button.process")');
                cleanError();
            },
            success: function (response) {
                $('#saveButton').attr('disabled',false);
                $('#saveButton').html('@lang("label.button.save")');
                if (response.result) {
                    _success(response.message);
                    location.href = '{{ route("settings.role") }}';
                }else{
                    if (response.message.name) {
                        $('#name').addClass('is-invalid');
                        $('#error-name').html(response.message.name[0]);
                    }
                    if (response.message.permission_name) {
                        $('#error-permission_name').html(response.message.permission_name[0]);
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
    function cleanError(){
        $('#name').removeClass('is-invalid');
        $('#error-name').html();
        $('#error-permission_name').html();
    }
</script>
@endsection
