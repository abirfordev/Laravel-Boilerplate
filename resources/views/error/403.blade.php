<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template-free">

<head>
    @section('title', 'Unauthorized')
    @include('backend.admin.layout.head')
</head>

<body>

    <!-- Content -->

    <!-- Not Authorized -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">You are not authorized!</h2>
            <p class="mb-4 mx-2">You do not have permission to view this page using the credentials that you have
                provided while login. <br> Please contact your site administrator.</p>
            <a href="{{ route($link) }}" class="btn btn-primary">Go to Dashboard</a>
            <div class="mt-5">
                <img src="{{ asset('/assets/img/illustrations/girl-with-laptop-light.png') }}"
                    alt="page-misc-not-authorized-light" width="450" class="img-fluid"
                    data-app-light-img="illustrations/girl-with-laptop-light.png"
                    data-app-dark-img="illustrations/girl-with-laptop-dark.png">

            </div>
        </div>
    </div>
    <!-- /Not Authorized -->

    <!-- / Content -->

    <!-- Footer JS-->
    @include('backend.admin.layout.footer-js')
    <!-- / Footer JS-->

</body>

</html>

<!-- beautify ignore:end -->
