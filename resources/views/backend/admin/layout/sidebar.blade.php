<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">

            <img class="app-brand-logo demo" src="{{ asset(config('settings.logo')) }}" width="80" alt="">
            <span
                class="app-brand-text display-6 menu-text fw-bolder ms-2">{{ config('settings.website_short_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        {{-- <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Dashboards</div>
                <div class="badge bg-danger rounded-pill ms-auto">5</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/dashboards-crm.html"
                        target="_blank" class="menu-link">
                        <div data-i18n="CRM">CRM</div>
                        <div class="badge bg-label-primary fs-tiny rounded-pill ms-auto">Pro</div>
                    </a>
                </li>
                <li class="menu-item active">
                    <a href="index.html" class="menu-link">
                        <div data-i18n="Analytics">Analytics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-ecommerce-dashboard.html"
                        target="_blank" class="menu-link">
                        <div data-i18n="eCommerce">eCommerce</div>
                        <div class="badge bg-label-primary fs-tiny rounded-pill ms-auto">Pro</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-logistics-dashboard.html"
                        target="_blank" class="menu-link">
                        <div data-i18n="Logistics">Logistics</div>
                        <div class="badge bg-label-primary fs-tiny rounded-pill ms-auto">Pro</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-academy-dashboard.html"
                        target="_blank" class="menu-link">
                        <div data-i18n="Academy">Academy</div>
                        <div class="badge bg-label-primary fs-tiny rounded-pill ms-auto">Pro</div>
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ URL::to('/admin/dashboard') }}" class="menu-link">
                {{-- <i class="menu-icon tf-icons bx bx-home-circle"></i> --}}
                <i class="menu-icon fa-solid fa-house"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">Web & Admin Settings</span></li>
        <!-- Forms -->
        <li class="menu-item {{ request()->is('admin/settings*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                {{-- <i class="menu-icon tf-icons bx bx-detail"></i> --}}
                <i class="menu-icon fa-solid fa-users-gear"></i>
                <div data-i18n="Admin Settings">Admin Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/settings/admin*') ? 'active' : '' }}">
                    <a href="{{ URL::to('admin/settings/admin') }}" class="menu-link">
                        <div data-i18n="Admin">Admin</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ request()->is('admin/settings/activity-log*') ? 'active' : '' }}">
                    <a href="{{ URL::to('admin/settings/activity-log') }}" class="menu-link">
                        <div data-i18n="Activity Log">Activity Log</div>
                    </a>
                </li> --}}
            </ul>
        </li>
        <li class="menu-item {{ request()->is('admin/web-settings*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                {{-- <i class="menu-icon tf-icons bx bx-detail"></i> --}}
                <i class="menu-icon fa-solid fa-snowflake"></i>
                <div data-i18n="Web Settings">Web Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/web-settings/activity-log*') ? 'active' : '' }}">
                    <a href="{{ URL::to('admin/web-settings/activity-log') }}" class="menu-link">
                        <div data-i18n="Activity Log">Activity Log</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/web-settings/setting*') ? 'active' : '' }}">
                    <a href="{{ URL::to('admin/web-settings/setting') }}" class="menu-link">
                        <div data-i18n="Setting">Setting</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
