<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name='csrf-token' content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/izitoast/css/iziToast.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    @yield('style')
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('img/favicon.ico') }}' />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn">
                                <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                                src="{{ asset('img/user.png') }}" class="user-img-radious-style"> <span
                                class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">Hello {{ Auth::guard('web')->user()->name }}</div>
                            {{-- <a href="profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i>
                                Profile
                            </a> --}}
                            <a href="{{ route('tax.list') }}" class="dropdown-item has-icon">
                                <i class="fas fa-percent"></i>
                                Tax
                            </a>
                            {{-- <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                                Activities
                            </a>
                            <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                                Settings
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('dashboard') }}"> <img alt="image" src="{{ asset('img/logo.png') }}"
                                class="header-logo" /> <span class="logo-name">Otika</span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>
                        <li class="dropdown">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i data-feather="monitor"></i>
                                <span> Dashboard</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ route('item.list') }}" class="nav-link">
                                <i data-feather="book"></i>
                                <span> Item</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ route('sale.person.list') }}" class="nav-link">
                                <i data-feather="user"></i>
                                <span> Sale Person</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="shopping-bag"></i><span>Purchases</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="{{ route('vendor.list') }}">
                                        Vendors
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('expense.list') }}">
                                        Expenses
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('bill.list') }}">
                                        Bills
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('vendorCredits.list') }}">
                                        Vendor Credits
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="clock"></i><span>Time Tracking</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="{{ route('project.list') }}">
                                        Projects
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('timesheet.list') }}">
                                        Timesheet
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="shopping-cart"></i><span>Sales</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="{{ route('customer.list') }}">
                                        Customers
                                    </a>
                                    <a class="nav-link" href="{{ route('quote.list') }}">
                                        Estimate
                                    </a>
                                    <a class="nav-link" href="{{ route('invoice.list') }}">
                                        Invoices
                                    </a>
                                    <a class="nav-link" href="{{ route('creditnotes.add') }}">
                                        Credit Notes
                                    </a>
                                    <a class="nav-link" href="{{ route('payment.received.add') }}">
                                        Payment Received
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="shopping-bag"></i><span>Purchases</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="{{ route('vendor.list') }}">
                                        Vendors
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('expense.list') }}">
                                        Expenses
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </aside>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <!-- add content here -->
                @yield('content')
            </div>
            <div class="settingSidebar">
                <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
                </a>
                <div class="settingSidebar-body ps-container ps-theme-default">
                    <div class=" fade show active">
                        <div class="setting-panel-header">Setting Panel
                        </div>
                        <div class="p-15 border-bottom">
                            <h6 class="font-medium m-b-10">Select Layout</h6>
                            <div class="selectgroup layout-color w-50">
                                <label class="selectgroup-item">
                                    <input type="radio" name="value" value="1"
                                        class="selectgroup-input-radio select-layout" checked>
                                    <span class="selectgroup-button">Light</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="value" value="2"
                                        class="selectgroup-input-radio select-layout">
                                    <span class="selectgroup-button">Dark</span>
                                </label>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <h6 class="font-medium m-b-10">Sidebar Color</h6>
                            <div class="selectgroup selectgroup-pills sidebar-color">
                                <label class="selectgroup-item">
                                    <input type="radio" name="icon-input" value="1"
                                        class="selectgroup-input select-sidebar">
                                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                        data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="icon-input" value="2"
                                        class="selectgroup-input select-sidebar" checked>
                                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                        data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                                </label>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <h6 class="font-medium m-b-10">Color Theme</h6>
                            <div class="theme-setting-options">
                                <ul class="choose-theme list-unstyled mb-0">
                                    <li title="white" class="active">
                                        <div class="white"></div>
                                    </li>
                                    <li title="cyan">
                                        <div class="cyan"></div>
                                    </li>
                                    <li title="black">
                                        <div class="black"></div>
                                    </li>
                                    <li title="purple">
                                        <div class="purple"></div>
                                    </li>
                                    <li title="orange">
                                        <div class="orange"></div>
                                    </li>
                                    <li title="green">
                                        <div class="green"></div>
                                    </li>
                                    <li title="red">
                                        <div class="red"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <div class="theme-setting-options">
                                <label class="m-b-0">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                        id="mini_sidebar_setting">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="control-label p-l-10">Mini Sidebar</span>
                                </label>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <div class="theme-setting-options">
                                <label class="m-b-0">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                        id="sticky_header_setting">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="control-label p-l-10">Sticky Header</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                            <a href="#" class="btn btn-sm icon-left btn-primary btn-restore-theme">
                                <i class="fas fa-undo"></i> Restore Default
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                <a href="https://trylotech.com">Trylotech</a></a>
            </div>
            <div class="footer-right">
            </div>
        </footer>
    </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('bundles/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/sweetalert.js') }}"></script>
    <script src="{{ asset('bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('js/page/toastr.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('js/custom.js') }}"></script>
    {{-- custom pages js --}}
    @yield('script')

</body>


<!-- blank.html  21 Nov 2019 03:54:41 GMT -->

</html>
