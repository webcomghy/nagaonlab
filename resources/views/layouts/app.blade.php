<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Health Care Laboratory') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/favicon.ico">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.ico">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet"/>
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- <link href="{{ asset('material') }}/css/material-dashboard.min.css" rel="stylesheet" /> -->
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!-- <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" /> -->

    <style>
       .login-page{
        background-image: url("{{ asset('material') }}/img/imagelogin.jpg") !important;
       }

        .sidebar .logo {
        padding: 20px 2px;
        margin: 1px;
        display: block;
        position: relative;
        z-index: 18;
        }


        .sidebar .nav li a, .sidebar .nav li .dropdown-menu a {
            margin: 10px 15px 0;
            /* border-radius: 3px; */
            color: #fafafa !important;
            padding-left: 10px;
            padding-right: 10px;
            text-transform: capitalize;
            font-size: 13px;
            padding: 10px 15px;
        }

        .sidebar .logo .simple-text {
            text-transform: uppercase;
            padding: 5px 0px;
            display: inline-block;
            font-size: 17px !important;
            color: #fafafa !important;
            white-space: nowrap;
            font-weight: 400;
            line-height: 30px;
            overflow: hidden;
            text-align: center;
            display: block;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0px;
            left: 2px;
            z-index: 2;
            width: 258px !important;
            background: #343a40 !important;
            box-shadow: 0 16px 38px -12px rgb(0 0 0 / 56%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(0 0 0 / 20%);
            /* border-radius:14px !important; */
        }

        .footer {
            padding: 0.9375rem 7!important;
            text-align: right!important;
            display: -webkit-flex;
            display: flex;
            /*justify-content: right !important;*/
            justify-content: space-around !important;
        }

        .footer a {
            color: white;
            opacity: 1;
            position: relative;
        }

        .off-canvas-sidebar .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 10 !important;
        }


    </style>
        @yield('css')
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            {{-- @include('auth.login') --}}
           @include('layouts.page_templates.auth')
        @endauth
        @guest()
            @include('layouts.page_templates.guest')
        @endguest


        <!--   Core JS Files   -->
        <!-- <script src="{{ asset('material') }}/js/core/jquery.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
        <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
        <!--  Google Maps Plugin    -->
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE'"></script>
        <!-- Chartist JS -->
        <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script src="{{ asset('material') }}/demo/demo.js"></script>
        <script src="{{ asset('material') }}/js/settings.js"></script>

        {{-- Toggle switches --}}
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
        @stack('js')

        <!-- <script>
            $(document).ready(function () {
                // Function to toggle the sidebar
                function toggleSidebar() {
                $('#sidebar').toggleClass('active');
                }

                // Click event handler for the toggle button
                $(".navbar-toggler").on("click", function () {
                toggleSidebar();
                });

                // Check window width and toggle sidebar visibility accordingly
                function checkWindowWidth() {
                if ($(window).width() <= 900) {
                    $('#sidebar').removeClass('active'); // Ensure sidebar is hidden on small screens
                } else {
                    $('#sidebar').addClass('active'); // Show sidebar on larger screens
                }
                }

                // Check window width on page load and resize
                checkWindowWidth();
                $(window).resize(function () {
                checkWindowWidth();
                });
            });
        </script> -->

        {{-- <script>
            document.addEventListener("DOMContentLoaded", function () {
                const mobileToggle = document.getElementById("sidebar-toggle");
                const mobileMenu = document.getElementById("mobile-menu");

                mobileToggle.addEventListener("click", function () {
                    mobileMenu.classList.toggle("active");
                });
                });
        </script> --}}
    </body>
</html>
