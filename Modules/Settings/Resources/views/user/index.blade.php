@extends('layouts.app')
@section('content')
<div id="kt_header" style="background-color:rgb(255, 255, 255);" class="header align-items-stretch">
    <div class="container-fluid py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
        <div class="page-title d-flex justify-content-center flex-column me-5">
            <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Users</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="/metronic8/demo8/../demo8/index.html" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Dashboards</li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark">Default</li>
            </ul>
        </div>
        <div class="d-flex align-items-stretch overflow-auto pt-3 pt-lg-0">
            <div class="d-flex align-items-center">
                <div class="d-flex">
                    <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6244763d93048">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5">
                            <div class="mb-10">
                                <label class="form-label fw-bold">Status:</label>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                            </div>
                        </div>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="addButton" class="btn btn-sm btn-primary"><i class="bi bi-person-plus-fill mr-2"></i> Buat User Baru</button>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch">

                        <div class="card-body pt-5">
                            <table id="kt_datatable_example_5" class="table table-row-bordered gy-3 gs-2 border rounded">
                                <thead class="fs-8">
                                    <tr class="fw-bolder text-gray-800 px-7">
                                        <th width="15%"></th>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-8" style="vertical-align: middle;"

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
        var table = $("#kt_datatable_example_5").DataTable({
            ajax:{
                url:"{{ route('settings.user') }}",
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
                {data: 'email', name: 'email'},
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
            $('.modal-title').html('@lang('settings::label.user.form.create_user')');
            $('#modalForm').modal('show');
        });
    })
</script>
@endsection
