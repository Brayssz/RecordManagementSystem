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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @vite(['resources/assets/css/style.css', 'resources/assets/css/sidebar.css'])
    {{-- @livewireStyles<!-- Styles - --}}
    @php
        use App\Utils\GetUserType;
        use App\Utils\GetProfilePhoto;

        $position = GetUserType::getUserType();

        $profilePhoto = GetProfilePhoto::getProfilePhotoUrl();

        $user = Auth::guard($position)->user();
    @endphp



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
            <div class="header-left active">
                <a href="index.html" class="logo logo-normal">
                    <img src="img/logo.jpg" alt="" />
                </a>
                <a href="index.html" class="logo logo-white">
                    <img src="assets/img/logo-white.png" alt="" />
                </a>
                <a href="index.html" class="logo-small">
                    <img src="assets/img/logo-small.jpg" alt="" />
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
                @if (Auth::guard('employee')->user()->position == 'Manager')
                    <!-- Notifications -->
                    <li class="nav-item dropdown nav-item-box">
                        <a href="javascript:void(0);" class="dropdown-toggle nav-link notification">
                            <i data-feather="bell"></i><span class="badge rounded-pill notif-count">2</span>
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Notifications</span>
                                <a href="javascript:void(0)" class="clear-noti"> Read All </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list">
                                    <li class="notification-message">
                                        <a>
                                            <div class="media d-flex">
                                                <span class="avatar avatar-md bg-success">
                                                    <span class="avatar-title">i</span>
                                                </span>
                                                <div class="media-body flex-grow-1">
                                                    <p class="noti-details">
                                                        {{-- <span class="noti-title">John Doe</span> added new
                                            task --}}
                                                        <span class="noti-title">Patient appointment booking sadasdsada
                                                            dasdadasd sadsadasdsadasdadada</span>
                                                    </p>
                                                    <div class="row">
                                                        <p class="noti-time col-lg-6">
                                                            <span class="notification-time">4 mins ago</span>
                                                        </p>
                                                        <p class="noti-time col-lg-6 text-end">
                                                            <span class="notification-time">Read</span>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                          
                        </div>
                    </li>
                    <!-- /Notifications -->
                @endif


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
                                    @if ($user->position == 'Manager' || $user->position == 'Clerk')
                                        <span class="user-role"><strong>{{ $user->branch->municipality }}
                                                Branch</strong> | {{ $user->position }}</span>
                                    @else
                                        <span class="user-role">{{ $user->position }}</span>
                                    @endif
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
            <!-- /Mobile Menu -->
        </div>
        <!-- /Header -->

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="submenu-open">
                            <h6 class="submenu-hdr">Main</h6>
                            <ul>
                                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                                    <a href="/dashboard"><i data-feather="grid"></i><span>Dashboard</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="submenu-open">
                            <h6 class="submenu-hdr">Management</h6>
                            <ul>
                                @if ($position == 'employee')
                                    @if ($user->position == 'Admin')
                                        <li class="{{ Request::is('employees') ? 'active' : '' }}">
                                            <a href="/employees"><i data-feather="user"></i><span>Employees</span></a>
                                        </li>
                                        <li class="{{ Request::is('jobs') ? 'active' : '' }}">
                                            <a href="/jobs"><i data-feather="briefcase"></i><span>Jobs</span></a>
                                        </li>
                                        <li class="{{ Request::is('branches') ? 'active' : '' }}">
                                            <a href="/branches"><i data-feather="home"></i><span>Branches</span></a>
                                        </li>
                                        <li class="{{ Request::is('employers') ? 'active' : '' }}">
                                            <a href="/employers"><i
                                                    data-feather="user-check"></i><span>Employers</span></a>
                                        </li>

                                        <li class="{{ Request::is('applicants') ? 'active' : '' }}">
                                            <a href="applicants"><i
                                                    data-feather="users"></i><span>Applicants</span></a>
                                        </li>
                                        <li class="{{ Request::is('application-records') ? 'active' : '' }}">
                                            <a href="/application-records"><i
                                                    data-feather="archive"></i><span>Application Records</span></a>
                                        </li>
                                    @endif

                                    @if ($user->position == 'Manager')
                                        <li class="{{ Request::is('employees') ? 'active' : '' }}">
                                            <a href="/employees"><i data-feather="user"></i><span>Employees</span></a>
                                        </li>

                                        <li class="{{ Request::is('application-records') ? 'active' : '' }}">
                                            <a href="/application-records"><i
                                                    data-feather="archive"></i><span>Application Records</span></a>
                                        </li>

                                        <li class="{{ Request::is('branch-schedules') ? 'active' : '' }}">
                                            <a href="/branch-schedules">
                                                <i data-feather="calendar"></i>
                                                <span>Interview Schedules</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if ($user->position == 'Clerk')
                                        <li class="{{ Request::is('application-records') ? 'active' : '' }}">
                                            <a href="/application-records"><i
                                                    data-feather="archive"></i><span>Application
                                                    Records</span></a>
                                        </li>
                                    @endif
                                @endif



                            </ul>
                        </li>

                        <li class="submenu-open">
                            <h6 class="submenu-hdr">Transactions</h6>
                            <ul>
                                @if ($position == 'employee')
                                    @if ($user->position == 'Admin')
                                        <li
                                            class="{{ Request::is('employer-pending-applications') ? 'active' : '' }}">
                                            <a href="/employer-pending-applications">
                                                <i data-feather="calendar"></i>
                                                <span>Interview Schedules</span>
                                            </a>
                                        </li>

                                        <li
                                            class="{{ Request::is('scheduled-employer-interviews') ? 'active' : '' }}">
                                            <a href="/scheduled-employer-interviews">
                                                <i data-feather="briefcase"></i>
                                                <span>Scheduled Interviews</span>
                                                <span class="badge-notif">1</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('hire-applicants') ? 'active' : '' }}">
                                            <a href="/hire-applicants"><i
                                                    data-feather="check-circle"></i><span>Applicant Hiring</span></a>
                                        </li>

                                        <li class="{{ Request::is('deploy-applicants') ? 'active' : '' }}">
                                            <a href="/deploy-applicants"><i data-feather="send"></i><span>Applicant
                                                    Deployment</span></a>
                                        </li>
                                    @endif

                                    @if ($user->position == 'Manager')
                                        <li class="{{ Request::is('scheduled-branch-interviews') ? 'active' : '' }}">
                                            <a href="/scheduled-branch-interviews">
                                                <i data-feather="briefcase"></i>
                                                <span>Scheduled Interviews</span>
                                                <span class="badge-notif interview-notif">0</span>
                                            </a>
                                        </li>
                                        {{-- <li class="{{ Request::is('approve-applications') ? 'active' : '' }}">
                                            <a href="/approve-applications"><i
                                                    data-feather="check-circle"></i><span>Application
                                                    Approval</span></a>
                                        </li> --}}

                                        <li class="{{ Request::is('applicant-documents') ? 'active' : '' }}">
                                            <a href="/applicant-documents"><i
                                                    data-feather="file"></i><span>Document Submission</span></a>
                                        </li>

                                        <li class="{{ Request::is('document-requests') ? 'active' : '' }}">
                                            <a href="/document-requests">
                                                <i data-feather="file-text"></i>
                                                <span>Document Request</span>
                                                <span class="badge-notif request-notif">1</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif

                                @if ($user->position == 'Clerk')
                                    <li class="{{ Request::is('applicant-documents') ? 'active' : '' }}">
                                        <a href="/applicant-documents"><i data-feather="file"></i><span>Document Submission</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                        @if ($position == 'employee')

                            @if ($user->position != 'Clerk')
                                <li class="submenu-open">
                                    <h6 class="submenu-hdr">Reports</h6>
                                    <ul>

                                        @if ($user->position == 'Admin')
                                            <li
                                                class="{{ Request::is('branch-performance-report') ? 'active' : '' }}">
                                                <a href="branch-performance-report"><i
                                                        data-feather="bar-chart-2"></i><span>Branch
                                                        Performance</span></a>
                                            </li>
                                            <li class="{{ Request::is('applications-report') ? 'active' : '' }}">
                                                <a href="applications-report"><i
                                                        data-feather="file"></i><span>Applications</span></a>
                                            </li>
                                            <li
                                                class="{{ Request::is('applicant-deployment-report') ? 'active' : '' }}">
                                                <a href="applicant-deployment-report"><i
                                                        data-feather="send"></i><span>Applicant
                                                        Deployment</span></a>
                                            </li>
                                            <li class="{{ Request::is('hired-applicant-report') ? 'active' : '' }}">
                                                <a href="hired-applicant-report"><i
                                                        data-feather="user-check"></i><span>Hired
                                                        Applicant</span></a>
                                            </li>
                                            <li
                                                class="{{ Request::is('employer-interview-report') ? 'active' : '' }}">
                                                <a href="employer-interview-report"><i
                                                        data-feather="file-text"></i><span>Employer
                                                        Interview</span></a>
                                            </li>
                                            <li
                                                class="{{ Request::is('registered-applicants-report') ? 'active' : '' }}">
                                                <a href="registered-applicants-report"><i
                                                        data-feather="users"></i><span>Registered Applicants</span></a>
                                            </li>
                                        @endif

                                        @if ($user->position == 'Manager')
                                            <li class="{{ Request::is('applications-report') ? 'active' : '' }}">
                                                <a href="applications-report"><i
                                                        data-feather="file"></i><span>Applications</span></a>
                                            </li>
                                            <li
                                                class="{{ Request::is('applicant-deployment-report') ? 'active' : '' }}">
                                                <a href="applicant-deployment-report"><i
                                                        data-feather="send"></i><span>Applicant
                                                        Deployment</span></a>
                                            </li>
                                            <li class="{{ Request::is('hired-applicant-report') ? 'active' : '' }}">
                                                <a href="hired-applicant-report"><i
                                                        data-feather="user-check"></i><span>Hired
                                                        Applicant</span></a>
                                            </li>
                                            <li class="{{ Request::is('branch-interview-report') ? 'active' : '' }}">
                                                <a href="branch-interview-report"><i
                                                        data-feather="file-text"></i><span>Branch
                                                        Interview</span></a>
                                            </li>

                                            <li
                                                class="{{ Request::is('registered-applicants-report') ? 'active' : '' }}">
                                                <a href="registered-applicants-report"><i
                                                        data-feather="users"></i><span>Registered Applicants</span></a>
                                            </li>
                                        @endif


                                    </ul>
                                </li>
                            @endif

                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            @yield('content')
        </div>

        @livewire('content.layout')
        @livewire('notification.app-notifications')

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
        localStorage.clear();
    </script>

    <!-- Feather Icon JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.1/feather.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.5.0/apexcharts.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

    <!-- Sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Mask JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

    <!-- Chart JS (Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @vite(['resources/assets/js/script.js', 'resources/assets/js/custom-select2.js', 'resources/assets/js/mask.js', 'resources/assets/js/theme-script.js', 'resources/assets/js/chart-data.js'])
    @livewireScripts

    @stack('scripts')



</body>

</html>
