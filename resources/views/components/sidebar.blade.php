<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <div class="logo-box">
                <div class="logo-box">
                    <a href="{{ route('dashboard.index') }}" class="logo logo-light">
                        <img src="{{ asset('assets/public/img/logo/logo-admin.png') }}" alt="logo">

                    </a>
                    <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
                        <img src="{{ asset('assets/public/img/logo/logo-admin.png') }}" alt="logo">
                    </a>

                </div>
            </div>

            <ul id="side-menu">
                <li class="menu-title">Menu</li>

                <li class="{{ request()->routeIs('dashboard.*') ? 'menuitem-active' : '' }}">
                    <a class="tp-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                        href="{{ route('dashboard.index') }}">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('incomingmail.*') ? 'menuitem-active' : '' }}">
                    <a class="tp-link {{ request()->routeIs('incomingmail.*') ? 'active' : '' }}"
                        href="{{ route('incomingmail.index') }}">
                        <i data-feather="inbox"></i>
                        <span>Surat Masuk</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('outgoingmail.*') ? 'menuitem-active' : '' }}">
                    <a class="tp-link {{ request()->routeIs('outgoingmail.*') ? 'active' : '' }}"
                        href="{{ route('outgoingmail.index') }}">
                        <i data-feather="send"></i>
                        <span>Surat Keluar</span>
                    </a>
                </li>


            </ul>

            <ul id="side-menu">
                <li class="menu-title">Konfigurasi</li>

                <li class="{{ request()->routeIs('mailtype.*') ? 'menuitem-active' : '' }}">
                    <a class="tp-link {{ request()->routeIs('mailtype.*') ? 'active' : '' }}"
                        href="{{ route('mailtype.index') }}">
                        <i data-feather="file-text"></i>
                        <span>Jenis Surat</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('mailclassification.*') ? 'menuitem-active' : '' }}">
                    <a class="tp-link {{ request()->routeIs('mailclassification.*') ? 'active' : '' }}"
                        href="{{ route('mailclassification.index') }}">
                        <i data-feather="file-text"></i>
                        <span>Sifat Surat</span>
                    </a>
                </li>
                {{--                

                <li class="{{ request()->routeIs('admin.users.*') ? 'menuitem-active' : '' }}">
                    <a class="tp-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <i data-feather="users"></i>
                        <span>User</span>
                    </a>
                </li> --}}

            </ul>
        </div>
    </div>
</div>
