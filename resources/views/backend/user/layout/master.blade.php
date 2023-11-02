<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template-free">

<head>
    @include('backend.user.layout.head')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar -->
            @include('backend.user.layout.sidebar')
            <!-- / Sidebar -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Topbar -->
                @include('backend.user.layout.topbar')
                <!-- / Topbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Modal -->
                    @include('backend.user.layout.modal')
                    <!-- / Modal -->

                    <!-- Footer -->
                    @include('backend.user.layout.footer')
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
    @include('backend.user.layout.footer-js')
    <!-- / Footer JS-->

</body>

</html>
