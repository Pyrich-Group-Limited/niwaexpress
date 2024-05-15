<div class="header">
    <div class="header-left">
        <a href="{{ url('/') }}" class="logo">
            <img style="background: #f8f8f8;" src="{{ asset('assets/images/logo.png') }}" height="35" alt="">
            <span>NIWA</span>
        </a>
    </div>
    <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
    <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
    <ul class="nav user-menu float-right">
        <li class="nav-item dropdown d-none d-sm-block">
            @php
                $notifications = \App\Models\Notification::where('notifiable_id', auth()->user()->id)
                    ->orderBy('created_at', 'DESC')
                    ->where('read_at', null)
                    ->limit(5)
                    ->get();

                $count = $notifications->count();
            @endphp

            @if ($count > 0)
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i>
                    <span class="badge badge-pill bg-danger float-right">{{ $count }}</span></a>
            @else
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i>
                    <span class="badge badge-pill bg-secondary float-right">{{ $count }}</span></a>
            @endif

            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span>Notifications</span>
                </div>
                <div class="drop-scroll">
                    <ul class="notification-list">
                        {{-- <li class="notification-message">
                            <a href="{{ route('payment.inspection') }}">
                                <div class="media">
                                    <span class="avatar">
                                        <img alt="John Doe" src="./assets/images/logo.png" class="img-fluid">
                                    </span>
                                    <div class="media-body">
                                        <h3>Inspection Notification</h3>
                                        <p class="noti-details"><span
                                                class="noti-title">{{ 'Inspection Message: ' . $notify->data }}</span>
                                        </p>
                                        <p class="noti-time"><span
                                                class="notification-time">{{ 'Inspection Date: ' . \Carbon\Carbon::parse($notify->type)->format('F j, Y H:i:s') }}
                                            </span></p>
                                    </div>
                                </div>
                            </a>
                        </li> --}}
                        @foreach ($notifications as $notification)
                            <li>
                                <div class="media p-3">
                                    <div class="media-body">
                                        <p class="noti-details"><span
                                                class="noti-title">{{ 'Message: ' . $notification->data }}</span>
                                        </p>
                                        <p class="noti-time"><span
                                                class="notification-time">{{ 'Date: ' . \Carbon\Carbon::parse($notification->created_at)->format('F j, Y H:i:s') }}
                                            </span></p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="topnav-dropdown-footer">
                    <a href="{{ route('payment.inspection') }}">Pay For Inspection</a>
                </div> --}}
            </div>

        </li>
        {{-- <li class="nav-item dropdown d-none d-sm-block">
            <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">8</span></a>
        </li> --}}
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                {{-- <span class="user-img">
                    <img class="rounded-circle" src="assets/img/user.jpg" width="24" alt="Admin">
                    <span class="status online"></span>
                </span> --}}
                <span>{{ Auth::user()->company_name }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('employer.profile') }}">My Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
    <div class="dropdown mobile-user-menu float-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item" href="login.html">Logout</a>
        </div>
    </div>
</div>
