<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/faviconfix.jpeg') }}" type="image/jpeg" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <style>
        /* Language Switcher Toggle Styling */
        .language-switcher-toggle {
            display: flex;
            background: var(--gray-2);
            border-radius: 8px;
            padding: 4px;
            gap: 4px;
        }
        
        .language-switcher-toggle .lang-btn {
            background: transparent;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: var(--dark-3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .language-switcher-toggle .lang-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }
        
        .language-switcher-toggle .lang-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        /* Dark mode support */
        .dark .language-switcher-toggle {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .dark .language-switcher-toggle .lang-btn {
            color: var(--gray-4);
        }
        
        .dark .language-switcher-toggle .lang-btn.active {
            background: var(--dark-2);
            color: white;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo">
            <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                <span style="font-size: 1.25rem; font-weight: 700; color: #2563eb; letter-spacing: -0.5px;">Akadea</span>
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                {{-- Home Menu with Dashboard and Exam Students --}}
                <li class="nav-item nav-item-has-children">
                    <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_home"
                        aria-controls="ddmenu_home" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.7071 2.29289C10.3166 1.90237 9.68342 1.90237 9.29289 2.29289L2.29289 9.29289C1.90237 9.68342 1.90237 10.3166 2.29289 10.7071C2.68342 11.0976 3.31658 11.0976 3.70711 10.7071L4 10.4142V17C4 17.5523 4.44772 18 5 18H7C7.55228 18 8 17.5523 8 17V15C8 14.4477 8.44772 14 9 14H11C11.5523 14 12 14.4477 12 15V17C12 17.5523 12.4477 18 13 18H15C15.5523 18 16 17.5523 16 17V10.4142L16.2929 10.7071C16.6834 11.0976 17.3166 11.0976 17.7071 10.7071C18.0976 10.3166 18.0976 9.68342 17.7071 9.29289L10.7071 2.29289Z" />
                            </svg>
                        </span>
                        <span class="text">{{ __('app.home') ?? 'Home' }}</span>
                    </a>
                    <ul id="ddmenu_home" class="collapse dropdown-nav">
                        <li>
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                {{ __('app.dashboard') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.exams.index') }}" class="{{ request()->routeIs('student.exams.*') ? 'active' : '' }}">
                                {{ __('app.exam_students') ?? 'Exam Students' }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Management Menu with Students, SPP, and Exam Teachers --}}
                @role('teacher|admin')
                <li class="nav-item nav-item-has-children">
                    <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_3"
                        aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 1.66667C5.39746 1.66667 1.66667 5.39746 1.66667 10C1.66667 14.6025 5.39746 18.3333 10 18.3333C14.6025 18.3333 18.3333 14.6025 18.3333 10C18.3333 5.39746 14.6025 1.66667 10 1.66667ZM10 3.33333C13.6819 3.33333 16.6667 6.31814 16.6667 10C16.6667 13.6819 13.6819 16.6667 10 16.6667C6.31814 16.6667 3.33333 13.6819 3.33333 10C3.33333 6.31814 6.31814 3.33333 10 3.33333Z" />
                                <path
                                    d="M10 5C9.08333 5 8.33333 5.75 8.33333 6.66667V10C8.33333 10.9167 9.08333 11.6667 10 11.6667H12.5C13.0523 11.6667 13.5 11.2189 13.5 10.6667C13.5 10.1144 13.0523 9.66667 12.5 9.66667H10V6.66667C10 5.75 9.25 5 10 5Z" />
                            </svg>
                        </span>
                        <span class="text">{{ __('app.management') }}</span>
                    </a>
                    <ul id="ddmenu_3" class="collapse dropdown-nav">
                        <li>
                            <a href="{{ route('students.index') }}"> {{ __('app.students') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('spp.index') }}"> {{ __('app.spp_payments') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('exams.index') }}" class="{{ request()->routeIs('exams.*') ? 'active' : '' }}">
                                {{ __('app.exam_teachers') ?? 'Exam Teachers' }}
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole

                {{-- Settings Menu - Visible to ADMIN only --}}
                @role('admin')
                <li class="nav-item nav-item-has-children">
                    <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_4"
                        aria-controls="ddmenu_4" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.4333 10.0001C17.4333 10.3501 17.15 10.6334 16.8 10.6334H11.9C11.55 10.6334 11.2667 10.3501 11.2667 10.0001C11.2667 9.65008 11.55 9.36675 11.9 9.36675H16.8C17.15 9.36675 17.4333 9.65008 17.4333 10.0001Z" />
                                <path d="M8.73333 10.0001C8.73333 10.3501 8.45 10.6334 8.1 10.6334H3.2C2.85 10.6334 2.56667 10.3501 2.56667 10.0001C2.56667 9.65008 2.85 9.36675 3.2 9.36675H8.1C8.45 9.36675 8.73333 9.65008 8.73333 10.0001Z" />
                                <path d="M10 12.5667C11.4167 12.5667 12.5667 11.4167 12.5667 10C12.5667 8.58333 11.4167 7.43333 10 7.43333C8.58333 7.43333 7.43333 8.58333 7.43333 10C7.43333 11.4167 8.58333 12.5667 10 12.5667Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1.66667C5.39763 1.66667 1.66667 5.39763 1.66667 10C1.66667 14.6024 5.39763 18.3333 10 18.3333C14.6024 18.3333 18.3333 14.6024 18.3333 10C18.3333 5.39763 14.6024 1.66667 10 1.66667ZM3.33333 10C3.33333 6.31811 6.31811 3.33333 10 3.33333C13.6819 3.33333 16.6667 6.31811 16.6667 10C16.6667 13.6819 13.6819 16.6667 10 16.6667C6.31811 16.6667 3.33333 13.6819 3.33333 10Z" />
                            </svg>
                        </span>
                        <span class="text">{{ __('app.settings') }}</span>
                    </a>
                    <ul id="ddmenu_4" class="collapse dropdown-nav">
                        <li>
                            <a href="{{ route('roles.index') }}"> {{ __('app.role_management') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('teachers.index') }}"> {{ __('app.teachers') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('subjects.index') }}"> {{ __('app.subjects') }} </a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
        </nav>
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        <header class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-6">
                        <div class="header-left d-flex align-items-center">
                            <div class="menu-toggle-btn mr-15">
                                <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-chevron-left me-2"></i> {{ __('app.menu') ?? 'Menu' }}
                                </button>
                            </div>
                            <div class="header-search d-none d-md-flex">
                                <form action="#">
                                    <input type="text" placeholder="{{ __('app.search') }}..." />
                                    <button><i class="lni lni-search-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-6">
                        <div class="header-right">
                            <!-- dark mode switcher start -->
                            <div class="dark-mode-box ml-15 d-flex align-items-center">
                                <button id="theme-toggle" class="dark-mode-toggle" type="button" title="Toggle Dark Mode">
                                    <svg class="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="5"></circle>
                                        <line x1="12" y1="1" x2="12" y2="3"></line>
                                        <line x1="12" y1="21" x2="12" y2="23"></line>
                                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                        <line x1="1" y1="12" x2="3" y2="12"></line>
                                        <line x1="21" y1="12" x2="23" y2="12"></line>
                                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                                    </svg>
                                    <svg class="moon-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- dark mode switcher end -->
                            <!-- language switcher start -->
                            <div class="language-box ml-15 d-flex align-items-center">
                                <div class="language-switcher-toggle">
                                    <button class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}" onclick="switchLanguage('en')" title="English">
                                        🇬🇧 EN
                                    </button>
                                    <button class="lang-btn {{ app()->getLocale() == 'id' ? 'active' : '' }}" onclick="switchLanguage('id')" title="Indonesia">
                                        🇮🇩 ID
                                    </button>
                                </div>
                            </div>
                            <!-- language switcher end -->
                            <!-- notification start -->
                            <div class="notification-box ml-15 d-none d-md-flex">
                                <button class="dropdown-toggle" type="button" id="notification"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11 20.1667C9.88317 20.1667 8.88718 19.63 8.23901 18.7917H13.761C13.113 19.63 12.1169 20.1667 11 20.1667Z"
                                            fill="" />
                                        <path
                                            d="M10.1157 2.74999C10.1157 2.24374 10.5117 1.83333 11 1.83333C11.4883 1.83333 11.8842 2.24374 11.8842 2.74999V2.82604C14.3932 3.26245 16.3051 5.52474 16.3051 8.24999V14.287C16.3051 14.5301 16.3982 14.7633 16.564 14.9352L18.2029 16.6342C18.4814 16.9229 18.2842 17.4167 17.8903 17.4167H4.10961C3.71574 17.4167 3.5185 16.9229 3.797 16.6342L5.43589 14.9352C5.6017 14.7633 5.69485 14.5301 5.69485 14.287V8.24999C5.69485 5.52474 7.60672 3.26245 10.1157 2.82604V2.74999Z"
                                            fill="" />
                                    </svg>
                                    <span></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                                    <li>
                                        <a href="#0">
                                            <div class="image">
                                                <img src="{{ asset('assets/images/lead/lead-6.png') }}" alt="" />
                                            </div>
                                            <div class="content">
                                                <h6>New Notification</h6>
                                                <p>You have a new message from admin.</p>
                                                <span>Just now</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- notification end -->
                            <!-- profile start -->
                            <div class="profile-box ml-15">
                                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-info">
                                        <div class="info">
                                            <div class="image">
                                                <img src="{{ asset('assets/images/profile/profile-image.png') }}"
                                                    alt="" />
                                            </div>
                                            <div>
                                                <h6 class="fw-500">{{ auth()->user()->name ?? 'User' }}</h6>
                                                <p>{{ __('app.admin') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                    <li>
                                        <div class="author-info flex items-center !p-1">
                                            <div class="image">
                                                <img src="{{ asset('assets/images/profile/profile-image.png') }}"
                                                    alt="image">
                                            </div>
                                            <div class="content">
                                                <h4 class="text-sm">{{ auth()->user()->name ?? 'User' }}</h4>
                                                <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                                                    href="#">{{ auth()->user()->email ?? 'email@example.com' }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('profile.edit') }}">
                                            <i class="lni lni-user"></i> {{ __('app.view_profile') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#0">
                                            <i class="lni lni-alarm"></i> {{ __('app.notifications') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="lni lni-exit"></i> {{ __('app.logout') }}
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <!-- profile end -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- ========== section end ========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========== All Js files linkup ========= -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/dynamic-pie-chart.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/js/jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/world-merc.js') }}"></script>
    <script src="{{ asset('assets/js/polyfill.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        // Language Switcher Function
        function switchLanguage(locale) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/language/' + locale;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    @stack('scripts')
</body>

</html>