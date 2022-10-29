@extends('layouts.app')
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-xl-stretch">
                    <div class="card-header">
                        <h3 class="card-title">@lang('settings::label.role.create_role')</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">@lang('settings::label.role.name')</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="text" name="name" id="name" class="form-control">
                            <div class="fv-plugins-message-container invalid-feedback error-name"></div>
                        </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label ">Communication</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <!--begin::Options-->
                                <div class="d-flex align-items-center mt-3">
                                    <!--begin::Option-->
                                    <label class="form-check form-check-inline form-check-sm form-check-solid me-5">
                                        <input class="form-check-input" name="communication[]" type="checkbox" value="1">
                                        <span class="ps-2 fs-6">Email</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input class="form-check-input" name="communication[]" type="checkbox" value="2">
                                        <span class="fw-bold ps-2 fs-6">Phone</span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Options-->
                            <div class="fv-plugins-message-container invalid-feedback"><div data-field="communication[]" data-validator="notEmpty">Please select at least one communication method</div></div></div>
                            <!--end::Col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
