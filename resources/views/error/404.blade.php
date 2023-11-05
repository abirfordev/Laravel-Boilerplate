<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template-free">

<head>
    @section('title', 'Page Not Found')
    @include('layouts.common.head')
</head>

<body>

    <!-- Content -->

    <!-- Error -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">Page Not Found</h2>
            <p class="mb-4 mx-2">Oops! 😖 The requested URL was not found.</p>
            <a href="javascript:history.back()" class="btn btn-primary">Please Go Back</a>
            <div class="mt-3">
                <img src="{{ asset('/assets/img/illustrations/page-misc-error-light.png') }}"
                    alt="page-misc-error-light" width="500" class="img-fluid"
                    data-app-dark-img="illustrations/page-misc-error-dark.png"
                    data-app-light-img="illustrations/page-misc-error-light.png" />
            </div>
        </div>
    </div>
    <!-- /Error -->

    <!-- / Content -->

    <!-- Footer JS-->
    @include('layouts.common.footer-js')
    <!-- / Footer JS-->

</body>

</html>

<!-- beautify ignore:end -->
