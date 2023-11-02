<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('user.dashboard') }}" class="app-brand-link">

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

        <li class="menu-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-house"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- / Dashboards -->


    </ul>
</aside>
