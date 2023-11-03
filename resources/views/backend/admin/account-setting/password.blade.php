@extends('backend.admin.layout.master')
@section('title', 'Change Password')
@section('nav-icon-title')
    <i class="fa-solid fa-lock m-2"></i>
    <p class="m-0 p-0">Change Password</p>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </nav>
        <!--/ Breadcrumb -->

        <!-- Form Card -->
        <div class="card">
            <!-- Form -->
            <div class="card-body">
                <form id='edit' action="" enctype="multipart/form-data" method="post" autocomplete="off"
                    accept-charset="utf-8" class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
                    <div id="status"></div>
                    {{ method_field('PATCH') }}

                    <div class="col-12 col-md-12 my-1 form-password-toggle">
                        <label class="form-label" for="old_password">Old Password <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input id="old_password" class="form-control" type="password" name="old_password" required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        <span id="error_old_password" class="text-danger error"></span>
                    </div>

                    <div class="col-12 col-md-12 my-1 form-password-toggle">
                        <label class="form-label" for="password">New Password <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input id="password" class="form-control" type="password" name="password" required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        <span id="error_password" class="text-danger error"></span>
                    </div>

                    <div class="col-12 col-md-12 my-1 form-password-toggle">
                        <label class="form-label" for="password_confirmation">Confirm New Password <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input id="password_confirmation" class="form-control" type="password"
                                name="password_confirmation" required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        <span id="error_password_confirmation" class="text-danger error"></span>
                    </div>



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

                </form>


            </div>
            <!--/ Form -->


        </div>

    </div>


    <script>
        $(document).ready(function() {

            $('.button-update').click(function() {
                // route name and record id
                update_others_form('/admin/password', "{{ $admin->id }}", "You want to change password!",
                    "Yes, change it!")
            });
        });
    </script>

@endsection
