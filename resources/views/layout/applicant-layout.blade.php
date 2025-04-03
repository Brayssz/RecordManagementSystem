<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive" />
    <meta name="robots" content="noindex, nofollow" />
    <title>@yield('title', 'MMML')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo-small.jpg') }}" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.3.3/css/bootstrap-datetimepicker.min.css">

    <!-- Toatr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">

  


    @vite(['resources/assets/css/style.css', 'resources/assets/css/sidebar.css'])
    @php
        use App\Utils\GetUserType;
        use App\Utils\GetProfilePhoto;

        $position = GetUserType::getUserType();

        $profilePhoto = GetProfilePhoto::getProfilePhotoUrl();

        $user = Auth::guard($position)->user();
    @endphp
    {{-- <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
 --}}
    <!-- Scripts -->

</head>

<body>
    <div id="global-loader">
        <span class="loader"></span>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Logo -->
            <!-- Logo -->
            <div class="header-left active border-0">
                <a href="index.html" class="logo logo-normal">
                    <img src="img/logo.jpg" alt="">
                </a>
                <a href="index.html" class="logo logo-white">
                    <img src="img/logo-white.png" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="img/logo-small.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                    <i data-feather="chevrons-left" class="feather-16"></i>
                </a>
            </div>
            <!-- /Logo -->

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <!-- Header Menu -->
            <ul class="nav user-menu">
                <!-- Search -->
                <li class="nav-item nav-searchinputs">
                    <div class="top-nav-search">

                    </div>
                </li>
                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>


                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info">
                            <span class="user-letter">
                                @if ($user->profile_photo_path != null)
                                    <img src="{{ $profilePhoto }}" alt="" class="img-fluid" />
                                @else
                                    <span class="avatar avatar bg-success h-100">
                                        <span
                                            class="avatar-title">{{ strtoupper(substr($user->first_name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1)) }}</span>
                                    </span>
                                @endif
                            </span>
                            <span class="user-detail">
                                <span
                                    class="user-name">{{ $user->first_name . ' ' . ($user->middle_name != null ? substr($user->middle_name, 0, 1) . '. ' : '') . $user->last_name }}</span>
                                @if ($position == 'employee')
                                    <span class="user-role">{{ $user->position }}</span>
                                @else
                                    <span class="user-role">{{ ucfirst($position) }}</span>
                                @endif


                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img">
                                    @if ($user->profile_photo_path != null)
                                        <img src="{{ $profilePhoto }}" alt="" class="img-fluid" />
                                    @else
                                        <span class="avatar avatar-md bg-success">
                                            <span
                                                class="avatar-title">{{ strtoupper(substr($user->first_name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1)) }}</span>
                                        </span>
                                    @endif

                                    <span class="status online"></span>
                                </span>
                                <div class="profilesets">
                                    <h6>{{ $user->first_name . ' ' . ($user->middle_name != null ? substr($user->middle_name, 0, 1) . '. ' : '') . $user->last_name }}
                                    </h6>
                                    @if ($position == 'employee')
                                        <h5>{{ $user->position }}</h5>
                                    @else
                                        <h5>{{ ucfirst($position) }}</h5>
                                    @endif

                                </div>
                            </div>
                            <hr class="m-0" />
                            <a class="dropdown-item" href="/profile">
                                <i class="me-2" data-feather="user"></i> My Profile</a>
                            <a href="#" class="dropdown-item logout pb-0"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="img/icons/log-out.svg" class="me-2" alt="img" />Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile">My Profile</a>
                    <a class="dropdown-item logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
        <!-- /Header -->

        <!-- Sidebar -->
        <div class="sidebar horizontal-sidebar">
            <div id="sidebar-menu-3" class="sidebar-menu">
                <ul class="nav">
                    <li class="{{ Request::is('applicant-dashboard') ? 'active' : '' }}">
                        <a href="/job-offers"><i data-feather="user"></i><span>Job Offers</span></a>
                    </li>
                    <li class="{{ Request::is('job-offers') ? 'active' : '' }}">
                        <a href="/my-applications"><i data-feather="file-text"></i><span>My Transactions</span></a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="page-wrapper">
            @yield('content')
        </div>

        {{-- @livewire('notification.notification-manager') --}}

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FontAwesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Datatable JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.3.3/js/bootstrap-datetimepicker.min.js">
    </script>

    <script>
        localStorage.setItem('layoutStyle', 'modern');
    </script>
    <!-- Feather Icon JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.1/feather.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="assets/plugins/apexchart/chart-data.js"></script>

    <!-- Slimscroll JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

    <!-- Sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="assets/plugins/apexchart/chart-data.js"></script>
    <!-- Mask JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

    <!-- Chart JS (Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    @vite(['resources/assets/js/script.js', 'resources/assets/js/custom-select2.js', 'resources/assets/js/mask.js', 'resources/assets/js/theme-script.js'])
    @livewireScripts

    @stack('scripts')
</body>

</html>
