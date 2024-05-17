<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="PGL">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="National Inland Waterways Authority, Self Service Portal (NIWA).">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./assets/images/logo.png">
    <!-- Page Title  -->
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <!-- StyleSheets  -->
    {{-- <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3"> --}}
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./back/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./back/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./back/css/style.css">
    @stack('styles')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #526484;
            line-height: 1.25rem;
            padding: 0.4375rem calc(2.125rem + 2px) 0.4375rem 1rem;
        }

        .notification-badge {
            background-color: red;
            color: white;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 50%;
            margin-left: 5px;
            /* Adjust the margin as needed */
        }

        .fs-3 {
            color: red;
            font-size: 1rem !important;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        @include('layouts.navbar')


        @php
            $userType = auth()->user()->user_type;

            $status = intval(auth()->user()->status);
            echo "User Type: $userType, Status: $status";
        @endphp



        @if ($userType == 'e-promota' && $status < 2)
            <!-- Do nothing, sidebar will not be included -->
        @else
            @include('layouts.sidebar')
        @endif




        <div class="page-wrapper">
            <div class="content">
                @if (session('success') || session('info') || session('warning') || session('error') || $errors->any())
                    <div class="row">
                        <div class="col-12 my-4">
                            @if (session('success'))
                                <div class="example-alert">
                                    <div class="alert alert-primary alert-icon alert-dismissible">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong style="font-size: 14pt;">Success:</strong>
                                        <span style="font-size: 14pt;">{{ session('success') }}</span>
                                        <button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @elseif (session('info'))
                                <div class="example-alert">
                                    <div class="alert alert-info alert-icon alert-dismissible">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>Info:</strong>
                                        <span>{{ session('info') }}</span>
                                        <button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @elseif (session('warning'))
                                <div class="example-alert">
                                    <div class="alert alert-warning alert-icon alert-dismissible">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>Warning:</strong>
                                        <span>{{ session('warning') }}</span>
                                        <button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @elseif (session('error'))
                                <div class="example-alert">
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>Error:</strong>
                                        <span>{{ session('error') }}</span>
                                        <button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="example-alert">
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>Error:</strong>
                                        <p>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        </p>
                                        <button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- CHECK IF ECS REGISTRATION DONE --}}
                {{--  @if (Auth::user()->paid_registration != 1)
                @include('payments.reg')
            @else
                @yield('content')
            @endif --}}
                @yield('content')
            </div>

            {{-- <div class="notification-box">
                <div class="msg-sidebar notifications msg-noti">
                    <div class="topnav-dropdown-header">
                        <span>Messages</span>
                    </div>
                    <div class="drop-scroll msg-list-scroll" id="msg_list">
                        <ul class="list-box">
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">R</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Richard Miles </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item new-message">
                                        <div class="list-left">
                                            <span class="avatar">J</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">John Doe</span>
                                            <span class="message-time">1 Aug</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">T</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Tarah Shropshire </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">M</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Mike Litorus</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">C</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Catherine Manseau </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">D</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Domenic Houston </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">B</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Buster Wigton </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">R</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Rolland Webber </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">C</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Claire Mapes </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">M</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Melita Faucher</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">J</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Jeffery Lalor</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">L</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Loren Gatlin</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">T</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Tarah Shropshire</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="chat.html">See all messages</a>
                    </div>
                </div>
            </div> --}}
        </div>


    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="./back/js/jquery-3.2.1.min.js"></script>
    <script src="./back/js/popper.min.js"></script>
    <script src="./back/js/bootstrap.min.js"></script>
    <script src="./back/js/jquery.slimscroll.js"></script>
    <script src="./back/js/Chart.bundle.js"></script>
    <script src="./back/js/chart.js"></script>
    <script src="./back/js/app.js"></script>

    <script src="./assets/js/bundle.js?ver=3.1.3"></script>
    <script src="./assets/js/scripts.js?ver=3.1.3"></script>

    @stack('scripts')

    @if (env('APP_ENV') == 'production')
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/64ef0da4a91e863a5c10a087/1h92sqjuh';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    @endif
</body>

</html>
