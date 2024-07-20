<div class="d-none d-lg-flex flex-column flex-shrink-0 p-3 bg-body-tertiary"
    style="width: 280px; height: 100vh; position: fixed;" id="sidebarToggle">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="sidebar-brand h2">CorecTo</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('home') }}"
                class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} link-body-emphasis"
                aria-current="page">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="{{ route('home') }}"></use>
                </svg>
                Home
            </a>
        </li>
        <li>
            <a href="{{ route('pop.index') }}"
                class="nav-link {{ request()->routeIs('pop.*') ? 'active' : '' }} link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#icon-cluster"></use>
                </svg>
                Point Of Presence
            </a>
        </li>
        <li>
            <a href="{{ route('fdt.index') }}"
                class="nav-link {{ request()->routeIs('fdt.*') ? 'active' : '' }} link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#icon-cluster"></use>
                </svg>
                FDT Lists
            </a>
        </li>
        <li>
            <a href="#" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#table"></use>
                </svg>
                Help
            </a>
        </li>
    </ul>
</div>
