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

        <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-house"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- / Dashboards -->

        <li class="menu-header small text-uppercase"><span class="menu-header-text">Web & Admin Settings</span></li>
        <li class="menu-item {{ request()->is('admin/settings*') ? 'active open' : '' }}">
            <div class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-users-gear"></i>
                <div data-i18n="Admin Settings">Admin Settings</div>
            </div>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/settings/module*') ? 'active' : '' }}">
                    <a href="{{ route('admin.module.index') }}" class="menu-link">
                        <div data-i18n="Module">Module</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('admin/settings/permission*') ? 'active' : '' }}">
                    <a href="{{ route('admin.permission.index') }}" class="menu-link">
                        <div data-i18n="Permission">Permission</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('admin/settings/admin*') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin.index') }}" class="menu-link">
                        <div data-i18n="Admin">Admin</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->is('admin/web-settings*') ? 'active open' : '' }}">
            <div class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-snowflake"></i>
                <div data-i18n="Web Settings">Web Settings</div>
            </div>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/web-settings/activity-log*') ? 'active' : '' }}">
                    <a href="{{ route('admin.activity-log.index') }}" class="menu-link">
                        <div data-i18n="Activity Log">Activity Log</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/web-settings/setting*') ? 'active' : '' }}">
                    <a href="{{ route('admin.setting.index') }}" class="menu-link">
                        <div data-i18n="Setting">Setting</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
