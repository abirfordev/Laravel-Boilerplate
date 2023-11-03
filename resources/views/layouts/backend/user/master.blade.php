<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template-free">

<head>
    @include('layouts.common.head')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar -->
            @include('layouts.backend.user.sidebar')
            <!-- / Sidebar -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Topbar -->
                @include('layouts.backend.user.topbar')
                <!-- / Topbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Modal -->
                    @include('layouts.common.modal')
                    <!-- / Modal -->

                    <!-- Footer -->
                    @include('layouts.common.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Footer JS-->
    @include('layouts.common.footer-js')
    <!-- / Footer JS-->

</body>

</html>
