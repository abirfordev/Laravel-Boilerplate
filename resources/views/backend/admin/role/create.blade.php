@extends('layouts.backend.admin.master')
@section('title', 'Role')
@section('nav-icon-title')
    <i class="fa-solid fa-user-check m-2"></i>
    <p class="m-0 p-0">Role Create</p>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.role.index') }}">Role</a>
                </li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
        <!--/ Breadcrumb -->

        <!-- Form Card -->
        <div class="card">
            <!-- Form -->
            <div class="card-body">
                <form id='create' action="" enctype="multipart/form-data" autocomplete="off" method="post"
                    accept-charset="utf-8" class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
                    <div id="status"></div>

                    <div class="col-12 col-md-12 my-1">
                        <label class="form-label" for="name">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required
                            placeholder="Enter role name">
                        <span id="error_name" class="text-danger error"></span>
                    </div>

                    <div class="col-12">
                        <h4>Role Permissions</h4>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-medium">Administrator Access <i
                                                class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Allows a full access to the system"></i></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select_all" />
                                                <label class="form-check-label" for="select_all">
                                                    Select All
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($modules as $module)
                                        <tr>
                                            <td class="text-nowrap fw-medium">{{ $module->name }}</td>
                                            <td>
                                                @if (count($module->visible_permission) > 0)
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input permissionSelect checkbox"
                                                                type="checkbox" id="{{ $module->id }}" />
                                                            <label class="form-check-label" for="{{ $module->id }}">
                                                                All
                                                            </label>
                                                        </div>
                                                        @foreach ($module->visible_permission as $permission)
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input checkbox single_permission"
                                                                    value="{{ $permission->id }}" type="checkbox"
                                                                    data-module-id="{{ $module->id }}"
                                                                    id="{{ $permission->name }}" />
                                                                <label class="form-check-label"
                                                                    for="{{ $permission->name }}">
                                                                    {{ $permission->label }}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>


                    <div class="col-12 my-1 text-end">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-rotate-right me-1"></i>
                            Clear
                        </button>
                        <button type="submit" class="btn btn-primary button-submit">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Save
                        </button>
                    </div>
                </form>


            </div>
            <!--/ Form -->


        </div>

    </div>


    <script>
        $(document).ready(function() {

            $(".permissionSelect").click(function() {
                var id = $(this).attr('id');
                if ($(this).is(":checked")) {
                    $('*[data-module-id=' + id + ']').prop('checked', true);
                } else {
                    $('*[data-module-id=' + id + ']').prop('checked', false);
                }
            });

            $("#select_all").click(function() {
                if ($(this).is(":checked")) {
                    $('input:checkbox').prop('checked', true);
                } else {
                    $('input:checkbox').prop('checked', false);
                }
            });

            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }

                var data_module_id = $(this).attr('data-module-id');

                if ($('*[data-module-id=' + data_module_id + ']:checked').length == $('*[data-module-id=' +
                        data_module_id + ']').length) {
                    $('#' + data_module_id).prop('checked', true);
                } else {
                    $('#' + data_module_id).prop('checked', false);
                }
            });

            $('.button-submit').click(function() {

                $("#status").html("");
                $(".error").empty();
                $("#create").validate({
                    submitHandler: function(form) {

                        var permissions = [];
                        $(".single_permission:checked").each(function() {
                            permissions.push(this.value);
                        });
                        var myData = new FormData($("#create")[0]);
                        myData.append("_token", CSRF_TOKEN);
                        myData.append('permissions', permissions);

                        let response = "";

                        Swal.fire({
                            title: "Are you sure?",
                            text: "You want to submit!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, submit it!",
                            showLoaderOnConfirm: true,
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: "btn btn-success me-3",
                                cancelButton: "btn btn-secondary",
                            },
                            preConfirm: (t) =>
                                $.ajax({
                                    url: "/admin/settings/role",
                                    type: "POST",
                                    data: myData,
                                    dataType: "json",
                                    cache: false,
                                    processData: false,
                                    contentType: false,
                                    success: function(data) {
                                        response = data;
                                    },
                                }),
                            backdrop: !0,
                            allowOutsideClick: () => !Swal.isLoading(),
                        }).then(() => {
                            if (response.type === "success") {
                                // window.location.href = "/admin/demo";
                                $("#create")[0].reset();
                                location.reload();

                                Swal.fire({
                                    icon: "success",
                                    title: "That's Great!",
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 5000,
                                });
                            } else if (response.type === "error") {
                                if (response.errors) {
                                    $.each(response.errors, function(key, val) {
                                        $("#error_" + key).html(val);
                                    });
                                }
                                $("#status").html(response.message);
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Something going to wrong...",
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                            }
                        });
                    },
                });
            });

        });
    </script>

@endsection
