@extends('layouts.app')
@section('content')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Profile</h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Row-->
        <div class="row gy-5 g-xl-12">
           <div class="col-lg-6">
            <form id="user-form">
                @csrf
                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                <div class="card card-bordered">
                    <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#kt_docs_card_collapsible">
                        <h3 class="card-title">@lang('label.user_information')</h3>
                        <div class="card-toolbar rotate-180">
                            <span class="bi bi-arrow-up">
                            </span>
                        </div>
                    </div>
                    <div id="kt_docs_card_collapsible" class="collapse show">
                        <div class="card-body">
                            <div class="form-floating mb-7">
                                <input type="email" name="email" class="form-control  form-control-sm form-control-solid" id="floatingInput" placeholder="name@example.com" value="{{ auth()->user()->email }}" readonly/>
                                <label for="floatingInput">@lang('label.email')</label>
                            </div>
                            <div class="form-floating mb-7">
                                <input type="text" name="role" id="role" class="form-control  form-control-sm form-control-solid" id="floatingInput" placeholder="name@example.com" value="{{ preg_replace('/[^a-zA-Z0-9\']/', '',auth()->user()->getRoleNames()); }}" readonly/>
                                <label for="floatingInput">@lang('label.role')</label>
                                <div class="fv-plugins-message-container invalid-feedback" id="error-role"></div>
                            </div>
                            <div class="form-floating mb-7">
                                <input type="text" name="name" id="name" class="form-control  form-control-sm" id="floatingInput" placeholder="" value="{{ auth()->user()->name }}"/>
                                <label for="floatingInput">@lang('label.username')</label>
                                <div class="fv-plugins-message-container invalid-feedback" id="error-name"></div>
                            </div>
                        </div>
                        <div class="card-footer" style="text-align: right;">
                            <button id="saveButton" type="submit" class="btn btn-sm btn-primary "><i class="bi bi-save-fill fs-4 me-2"></i>@lang('label.button.update')</button>
                        </div>
                    </div>
                </div>
            </form>
           </div>
           <div class="col-lg-6">
            <form id="password-form">
                @csrf
                <div class="card card-bordered">
                    <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#kt_docs_card_collapsible_password">
                        <h3 class="card-title">@lang('label.change_password')</h3>
                        <div class="card-toolbar rotate-180">
                            <span class="bi bi-arrow-up">
                            </span>
                        </div>
                    </div>
                    <div id="kt_docs_card_collapsible_password" class="collapse show">
                        <div class="card-body">
                            <div class="form-floating mb-7">
                                <input type="password" name="current_password" class="form-control form-control-sm" id="current_password" placeholder="placeholder="@lang('label.current_password')"/>
                                <label for="current_password">@lang('label.current_password')</label>
                                <div class="fv-plugins-message-container invalid-feedback" id="error-current_password"></div>
                            </div>
                            <div class="form-floating mb-7">
                                <input type="password" name="password"class="form-control  form-control-sm " id="password" placeholder="@lang('label.new_password')"/>
                                <label for="password">@lang('label.new_password')</label>
                                <div class="fv-plugins-message-container invalid-feedback" id="error-password"></div>
                            </div>
                            <div class="form-floating mb-7">
                                <input type="password" name="password_confirmation" class="form-control  form-control-sm" id="password_confirmation" placeholder="@lang('label.new_password_confirmation')"/>
                                <label for="password_confirmation">@lang('label.new_password_confirmation')</label>
                                <div class="fv-plugins-message-container invalid-feedback" id="error-password_confirmation"></div>
                            </div>
                        </div>
                        <div class="card-footer" style="text-align: right;">
                            <button id="changePasswordButton" type="submit" class="btn btn-sm btn-primary "><i class="bi bi-key-fill fs-4 me-2"></i>@lang('label.button.change_password')</button>
                        </div>
                    </div>
                </div>
            </form>
           </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
<script>
    $(document).ready(function () {
        $('#user-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "{{ route('settings.profile.update') }}",
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                cache:false,
                processData:false,
                beforeSend: function (){
                    $('#saveButton').attr('disabled',true);
                    $('#saveButton').html('@lang("label.button.process")');
                    $('#name').removeClass('is-invalid');
                    $('#error-name').html('');
                },
                success: function (res) {
                    $('#saveButton').attr('disabled',false);
                    $('#saveButton').html('<i class="bi bi-save-fill fs-4 me-2"></i> @lang("label.button.update")');
                    if(res.result){
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
                    $('#saveButton').html('<i class="bi bi-save-fill fs-4 me-2"></i> @lang("label.button.save")');
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
            });
        });
        $('#password-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "{{ route('settings.profile.change.password') }}",
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                cache:false,
                processData:false,
                beforeSend: function (){
                    $('#changePasswordButton').attr('disabled',true);
                    $('#changePasswordButton').html('@lang("label.button.process")');
                    $('#current_password').removeClass('is-invalid');
                    $('#password').removeClass('is-invalid');
                    $('#password_confirmation').removeClass('is-invalid');
                    $('#error-current_password').html('');
                    $('#error-password').html('');
                    $('#error-password_confirmation').html('');
                },
                success: function (res) {
                    $('#changePasswordButton').attr('disabled',false);
                    $('#changePasswordButton').html('<i class="bi bi-key-fill fs-4 me-2"></i> @lang("label.button.change_password")');
                    if(res.result){
                        Swal.fire({
                            text:res.message,
                            icon:"success",
                            buttonsStyling:!1,
                            confirmButtonText:"@lang('label.button.ok')",
                            customClass:{
                            confirmButton:"btn btn-primary"
                            }
                        });
                        $( "#signout-account" ).click();
                    }else{
                        if(res.message.current_password){
                            $('#error-current_password').html(res.message.current_password[0]);
                            $('#current_password').addClass('is-invalid');
                        }
                        if(res.message.password){
                            $('#error-password').html(res.message.password[0]);
                            $('#password').addClass('is-invalid');

                        }
                    }
                },
                error:function(xhr, status, error){
                    $('#changePasswordButton').attr('disabled',false);
                    $('#changePasswordButton').html('<i class="bi bi-key-fill fs-4 me-2"></i> @lang("label.button.change_password")');
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
            });
        });
    })
</script>

@endsection
