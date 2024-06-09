<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href=""><img src="../assets/images/logo.svg" width="25" alt="Aero"><span class="m-l-10">Aero</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="#"><img src="../assets/images/profile_av.jpg" alt="User"></a></div>
                    <div class="detail">
                        <h4>Michael</h4>
                        <small>Super Admin</small>
                    </div>
                </div>
            </li>
            <li class="{{ request()->routeIs('dashboard.index')  ? 'active open' : null }}"><a
                        href="{{route('dashboard.index')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
            </li>

            @canany(['index users','index roles','create users'])
                <li class="{{ Request::segment(2) === 'users' ? 'active open' : null }}">
                    <a href="#Users" class="menu-toggle"><i class="zmdi zmdi-folder-person"></i> <span>Users</span></a>
                    <ul class="ml-menu">
                        @can('index users')
                            <li class="{{ request()->routeIs('dashboard.users.index') ? 'active' : null }}"><a
                                        href="{{route('dashboard.users.index')}}">All Users</a></li>
                        @endcan
                        @can('create users')
                            <li class="{{ request()->routeIs('dashboard.users.create')  ? 'active' : null }}"><a
                                        href="{{route('dashboard.users.create')}}">Add New User</a></li>
                        @endcan
                        @can('index roles')

                            <li class="{{ request()->routeIs('dashboard.roles.index')  ? 'active' : null }}"><a
                                        href="{{route('dashboard.roles.index')}}">Roles</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['index settings','edit settings','delete settings','create settings','destroy settings'])
                <li class="{{ Request::segment(2) === 'settings' ? 'active open' : null }}">
                    <a href="#Setting" class="menu-toggle"><i class="zmdi zmdi-settings"></i> <span>Settings</span></a>
                    <ul class="ml-menu">
                        <li class="{{ request()->routeIs('dashboard.settings.index')  ? 'active' : null }}"><a
                                    href="{{ route('dashboard.settings.index') }}">General Settings</a></li>
                        <li class="{{ request()->routeIs('dashboard.languages.index') ? 'active' : null }}"><a
                                    href="{{ route('dashboard.languages.index') }}">Language</a></li>
                        <li class="{{ request()->routeIs('dashboard.translations.index') ? 'active' : null }}"><a
                                    href="{{ route('dashboard.translations.index') }}">Translation</a></li>
                    </ul>
                </li>
            @endcanany

            @canany(['index categories','edit categories','delete categories','create categories','destroy categories'])
                <li class="{{ Request::segment(2) === 'services_categories' ? 'active open' : null }}">
                    <a href="#Category" class="menu-toggle"><i class="zmdi zmdi-collection-item"></i> <span>Service Category</span></a>
                    <ul class="ml-menu">
                        @can('index categories')
                            <li class="{{ request()->routeIs('dashboard.services_categories.index')  ? 'active' : null }}">
                                <a
                                        href="{{ route('dashboard.services_categories.index') }}">All Service
                                    Categories</a></li>
                        @endcan
                        @can('create categories')
                            <li class="{{ request()->routeIs('dashboard.services_categories.create')  ? 'active' : null }}">
                                <a
                                        href="{{ route('dashboard.services_categories.create') }}">New Service
                                    Category</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['index categories','edit categories','delete categories','create categories','destroy categories'])
                <li class="{{ Request::segment(2) === 'blogs_categories' ? 'active open' : null }}">
                    <a href="#Category" class="menu-toggle"><i class="zmdi zmdi-collection-item"></i> <span>Blog Category</span></a>
                    <ul class="ml-menu">
                        @can('index categories')
                            <li class="{{ request()->routeIs('dashboard.blogs_categories.index')  ? 'active' : null }}">
                                <a
                                        href="{{ route('dashboard.blogs_categories.index') }}">All Blog Categories</a>
                            </li>
                        @endcan
                        @can('create categories')
                            <li class="{{ request()->routeIs('dashboard.blogs_categories.create')  ? 'active' : null }}">
                                <a
                                        href="{{ route('dashboard.blogs_categories.create') }}">New Blog Category</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['index services','edit services','delete services','create services','destroy services'])
                <li class="{{ Request::segment(2) === 'services' ? 'active open' : null }}">
                    <a href="#Service" class="menu-toggle"><i class="zmdi zmdi-book"></i> <span>Services</span></a>
                    <ul class="ml-menu">
                        @can('index services')
                            <li class="{{ request()->routeIs('dashboard.services.index')  ? 'active' : null }}"><a
                                        href="{{ route('dashboard.services.index') }}">All Services</a></li>
                        @endcan
                        @can('create services')
                            <li class="{{ request()->routeIs('dashboard.services.create')  ? 'active' : null }}"><a
                                        href="{{ route('dashboard.services.create') }}">New Service</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['index portfolios','edit portfolios','delete portfolios','create portfolios','destroy portfolios'])
                <li class="{{ Request::segment(2) === 'portfolios' ? 'active open' : null }}">
                    <a href="#Portfolios" class="menu-toggle"><i class="zmdi zmdi-account"></i> <span>Portfolios</span></a>
                    <ul class="ml-menu">
                        @can('index services')
                            <li class="{{ request()->routeIs('dashboard.portfolios.index')  ? 'active' : null }}"><a
                                        href="{{ route('dashboard.portfolios.index') }}">All Portfolios</a></li>
                        @endcan
                        @can('create services')
                            <li class="{{ request()->routeIs('dashboard.portfolios.create')  ? 'active' : null }}"><a
                                        href="{{ route('dashboard.portfolios.create') }}">New Portfolio</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['index leads','edit leads','destroy leads'])
                <li class="{{ Request::segment(2) === 'leads' ? 'active open' : null }}">
                    <a href="{{ route('dashboard.leads.index') }}"
                       class="{{ request()->routeIs('dashboard.leads.index')  ? 'active' : null }}"><i class="zmdi zmdi-account"></i> <span>Leads</span></a>

                </li>
            @endcanany
        </ul>
    </div>
</aside>
