<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    @include('auth.layout.head')
</head>

<body>
    <!-- Content -->
    @yield('content')
    <!-- / Content -->


    <!-- Footer JS-->
    @include('auth.layout.footer-js')
    <!-- / Footer JS-->

</body>

</html>
