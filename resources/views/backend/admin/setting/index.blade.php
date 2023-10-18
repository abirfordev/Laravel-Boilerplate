@extends('backend.admin.layout.master')
@section('title', 'Setting')
@section('nav-icon-title')
    <i class="fa-solid fa-screwdriver-wrench m-2"></i>
    <p class="m-0 p-0">Setting</p>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item active">Setting</li>
            </ol>
        </nav>
        <!--/ Breadcrumb -->

        <div class="col-xxl">
            <div class="card mb-4">

                {{-- Add new Button --}}
                <div class="d-flex flex-wrap justify-content-end mt-2">

                    <button class="btn rounded-pill btn-primary mt-1 me-1" type="button" onclick="create()">
                        <i class='bx bx-plus me-1'></i>
                        <span class="d-none d-sm-block">Add New Record</span>
                    </button>
                </div>
                {{-- / Add new Button --}}

                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Setting Options</h5>
                </div>
                <div class="card-body">
                    <form id='edit' action="" enctype="multipart/form-data" method="post" autocomplete="off"
                        accept-charset="utf-8" novalidate>
                        {{ method_field('PATCH') }}
                        @foreach ($settings as $setting)
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"
                                    for="{{ $setting->name }}">{{ $setting->label }}</label>
                                <div class="col-sm-10">
                                    <input id="{{ $setting->name }}" class="form-control" type="text"
                                        name="settings[{{ $setting->name }}]" value="{{ $setting->value }}" />
                                    <div class="form-text">{{ $setting->instruction }}</div>
                                </div>
                            </div>
                        @endforeach
                        @if (count($settings) > 0)
                            <div class="col-12 my-1 text-end">
                                <button class="btn btn-secondary button-reset" type="reset">
                                    <i class="fa-solid fa-arrow-rotate-right me-1"></i>
                                    Reset
                                </button>
                                <button class="btn btn-primary button-update" type="submit">
                                    <i class="fa-solid fa-square-pen me-1"></i>
                                    Update
                                </button>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        function create() {
            create_form_modal('/admin/web-settings/setting');
        }

        $(document).ready(function() {

            $('.button-update').click(function() {
                // route name and record id

                $("#edit").validate({
                    submitHandler: function(form) {
                        var myData = new FormData($("#edit")[0]);
                        myData.append("_token", CSRF_TOKEN);

                        let response = "";

                        Swal.fire({
                            title: "Are you sure?",
                            text: "You want to update!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, update it!",
                            showLoaderOnConfirm: true,
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: "btn btn-info me-3",
                                cancelButton: "btn btn-secondary",
                            },
                            preConfirm: (t) =>
                                $.ajax({
                                    url: "/admin/web-settings/setting/update",
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
                                location.reload();
                                $("#base_modal").modal("hide");

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
