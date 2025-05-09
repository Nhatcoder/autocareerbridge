@php
    $userName = '';

    if (Auth::guard('admin')->check()) {
        if (Auth::guard('admin')->user()->role === ROLE_ADMIN) {
            $userName = Str::limit(Auth::guard('admin')->user()->user_name, 20);
        } elseif (Auth::guard('admin')->user()->role === ROLE_COMPANY) {
            $userName = Str::limit(Auth::guard('admin')->user()->company->name ?? '', 20);
        } elseif (Auth::guard('admin')->user()->role === ROLE_UNIVERSITY) {
            $userName = Str::limit(Auth::guard('admin')->user()->university->name ?? '', 20);
        } elseif (Auth::guard('admin')->user()->role === ROLE_SUB_UNIVERSITY) {
            $userName = Str::limit(Auth::guard('admin')->user()->user_name ?? '', 20);
        } elseif (Auth::guard('admin')->user()->role === ROLE_SUB_ADMIN) {
            $userName = Str::limit(Auth::guard('admin')->user()->user_name ?? '', 20);
        } elseif (Auth::guard('admin')->user()->role === ROLE_HIRING) {
            $userName = Str::limit(Auth::guard('admin')->user()->hirings->name ?? '', 20);
        } else {
            $userName = Str::limit('Unknown Role', 20);
        }
    } else {
        $userName = 'Guest';
    }
@endphp
<div class="jp_top_header_img_wrapper">
    <div class="jp_slide_img_overlay"></div>
    <div class="gc_main_menu_wrapper">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 hidden-xs hidden-sm">
                    <div class="gc_header_wrapper justify-content-end">
                        <div class="gc_header float-end">
                            <a href="{{ route('home') }}"><img src=" {{ asset('clients/images/header/logo.png') }}"
                                    alt="Logo" title="Job Pro" class="img-responsive"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 center_responsive">
                    <div class="gc_header_wrapper header-area hidden-menu-bar stick" id="sticker">
                        <!-- mainmenu start -->
                        <div class="mainmenu">
                            <ul class="gc_main_navigation">
                                <li class="has-mega gc_main_navigation {{ Request::routeIs('home') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}" class="gc_main_navigation">
                                        Trang chủ
                                    </a>
                                </li>
                                <li
                                    class="has-mega gc_main_navigation {{ Request::routeIs('search') ? 'active' : '' }}">
                                    <a href="javascript:void(0)"> Việc làm</a>
                                    @if (Auth::guard('web')->check())
                                        <ul>
                                            <li class="parent"><a href="{{ route('search') }}">Tìm việc làm</a></li>
                                            @if (Auth::guard('web')->user()->userJob()->count() > 0)
                                                <li class="parent"><a href="{{ route('historyJobApply') }}">Việc làm đã
                                                        ứng
                                                        tuyển</a></li>
                                            @endif
                                            <li class="parent"><a href="{{ route('listScheduleInterView') }}">Lịch phỏng
                                                    vấn</a></li>
                                            @if (auth()->check() && auth()->user()->role !== ROLE_COMPANY && auth()->user()->role !== ROLE_HIRING)
                                                <li class="parent"><a href="{{ route('job.wishlist.list') }}">Việc làm
                                                        đã
                                                        lưu</a></li>
                                            @endif
                                        </ul>
                                    @endif

                                </li>

                                <li
                                    class="gc_main_navigation parent {{ Request::routeIs('listUniversity') ? 'active' : '' }}">
                                    <a href="{{ route('listUniversity') }}" class="gc_main_navigation">Trường
                                        học</a>
                                </li>

                                <li
                                    class="gc_main_navigation parent {{ Request::routeIs('listCompany') ? 'active' : '' }}">
                                    <a href="{{ route('listCompany') }}" class="gc_main_navigation">Doanh
                                        nghiệp</a>
                                </li>
                                <li
                                    class="gc_main_navigation parent {{ Request::routeIs(['workshop', 'workshopDetail']) ? 'active' : '' }}">
                                    <a href="{{ route('workshop') }}" class="gc_main_navigation">Workshop</a>
                                </li>
                                @auth
                                    @if (auth()->user()->role == 7)
                                        <li
                                            class="gc_main_navigation parent {{ Request::routeIs('myCv') ? 'active' : '' }}">
                                            <a href="{{ route('myCv') }}" class="gc_main_navigation">Quản lý CV</a>
                                        </li>
                                    @endif
                                @endauth

                                <li>
                                    <div id="search_open" class="gc_search_box">
                                        <input type="text" placeholder="Search here">
                                        <button><i class="fa fa-search" aria-hidden="false"></i></button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- mainmenu end -->
                    </div>
                </div>
                <!-- mobile menu area start -->
                <header class="mobail_menu">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6">
                                <div class="gc_logo">
                                    <a href="{{ route('home') }}"><img
                                            src="{{ asset('clients/images/header/logo.png') }}" alt="Logo"
                                            title="Grace Church"></a>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="cd-dropdown-wrapper">
                                    <a class="house_toggle" href="#0">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px"
                                            y="0px" viewBox="0 0 31.177 31.177"
                                            style="enable-background:new 0 0 31.177 31.177;" xml:space="preserve"
                                            width="25px" height="25px">
                                            <g>
                                                <g>
                                                    <path class="menubar"
                                                        d="M30.23,1.775H0.946c-0.489,0-0.887-0.398-0.887-0.888S0.457,0,0.946,0H30.23    c0.49,0,0.888,0.398,0.888,0.888S30.72,1.775,30.23,1.775z"
                                                        fill="#ffffff" />
                                                </g>
                                                <g>
                                                    <path class="menubar"
                                                        d="M30.23,9.126H12.069c-0.49,0-0.888-0.398-0.888-0.888c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,8.729,30.72,9.126,30.23,9.126z"
                                                        fill="#ffffff" />
                                                </g>
                                                <g>
                                                    <path class="menubar"
                                                        d="M30.23,16.477H0.946c-0.489,0-0.887-0.398-0.887-0.888c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,16.079,30.72,16.477,30.23,16.477z"
                                                        fill="#ffffff" />
                                                </g>
                                                <g>
                                                    <path class="menubar"
                                                        d="M30.23,23.826H12.069c-0.49,0-0.888-0.396-0.888-0.887c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,23.43,30.72,23.826,30.23,23.826z"
                                                        fill="#ffffff" />
                                                </g>
                                                <g>
                                                    <path class="menubar"
                                                        d="M30.23,31.177H0.946c-0.489,0-0.887-0.396-0.887-0.887c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.398,0.888,0.888C31.118,30.78,30.72,31.177,30.23,31.177z"
                                                        fill="#ffffff" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                    <nav class="cd-dropdown">
                                        <h2><a href="#">Job<span>Pro</span></a></h2>
                                        <a href="#0" class="cd-close">Close</a>
                                        <ul class="cd-dropdown-content">
                                            <li>
                                                <a href="{{ route('home') }}">Trang chủ</a>
                                            </li>
                                            <!-- .has-children -->
                                            <li class="has-children">
                                                <a href="javascript:void(0)">Việc làm</a>

                                                <ul class="cd-secondary-dropdown is-hidden">
                                                    <li class="go-back">
                                                        <a href="javascript:void(0)">Quay lại</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('search') }}">Tìm việc
                                                            làm</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('historyJobApply') }}">Việc làm đã ứng
                                                            tuyển</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <!-- .has-children -->
                                            <li>
                                                <a href="{{ route('listUniversity') }}">Trường học</a>
                                            </li>
                                            <!-- .has-children -->
                                            <li>
                                                <a href="{{ route('listCompany') }}">Doanh nghiệp</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('workshop') }}">Workshop</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('myCv') }}">Quản lý CV</a>
                                            </li>
                                            @if (!Auth::guard('admin')->check() && !Auth::guard('web')->check())
                                                <li>
                                                    <a href="{{ route('viewRegister') }}">
                                                        Đăng ký
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('viewLogin') }}">
                                                        Đăng nhập</a>
                                                </li>
                                                <li>
                                                    <a target="_blank" href="{{ route('management.login') }}">Nhà quản
                                                        lý</a>
                                                </li>
                                            @endif
                                        </ul>
                                        <!-- .cd-dropdown-content -->
                                    </nav>
                                    <!-- .cd-dropdown -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .cd-dropdown-wrapper -->
                </header>
                <!-- mobile menu area end -->
                <div class="col-lg-3 col-md-3 col-sm-3 menu_mobile">
                    <div class="jp_navi_right_btn_wrapper float-end ">
                        <ul class="gc_header_wrapper menu-item dropdown d-flex gap-2">
                            @if (Auth::guard('admin')->check())
                                @if (Auth::guard('admin')->user()->role === ROLE_COMPANY || Auth::guard('admin')->user()->role === ROLE_HIRING)
                                    <a class="icon_notification" role="button" class="menu-link"
                                        data-bs-toggle="dropdown" aria-expanded="false" href="jvavascript:void(0);">
                                        <span data-count="{{ $notificationCount > 0 ? $notificationCount : 0 }}"
                                            class="notification_count {{ $notificationCount > 0 ? $notificationCount : 'd-none' }}">
                                            {{ $notificationCount }}</span>
                                        <i class="fa-regular fa-bell"></i>
                                    </a>

                                    <div class="dropdown-menu" style="width: 360px;">
                                        <div class="notification-box">
                                            <div class="box_header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0 fw-bold">Thông báo</h5>
                                                @if ($notificationCount > 0)
                                                    <a href="{{ route('markSeenAll') }}" class="mark-read">Đánh dấu
                                                        là đã
                                                        đọc</a>
                                                @endif
                                            </div>

                                            <div class="notification-list" data-role="{{ USER }}"
                                                data-id-chanel="{{ Auth::guard('admin')->user()->id }}">
                                                @forelse ($notificationsHeader as $item)
                                                    <a href="{{ $item->link }}" class="notification-item d-block"
                                                        data-id="{{ $item->id }}">
                                                        <div
                                                            class="title {{ $item->is_seen == UNSEEN ? 'fw-bold' : 'fw-medium' }}">
                                                            {{ $item->title }}
                                                        </div>
                                                        <div class="time">
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                                        </div>
                                                        @if ($item->is_seen == SEEN)
                                                            <div class="is-seen">
                                                                <i class="fa-solid fa-check"></i>
                                                            </div>
                                                        @endif
                                                    </a>
                                                @empty
                                                    <div class="no_notifycation title fw-medium text-center pt-2">Không
                                                        có thông báo
                                                        nào
                                                    </div>
                                                @endforelse
                                            </div>

                                        </div>
                                    </div>
                                    <a href="{{ route('conversations', ['id' => $userChatHeader->from_id ?? Auth::guard('admin')->user()->id]) }}"
                                        class="icon_message">
                                        <svg width="25px" height="25px" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" fill="#23b6dd">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <style>
                                                    .cls-1 {
                                                        fill: none;
                                                        stroke: #ffffff;
                                                        stroke-linecap: round;
                                                        stroke-linejoin: round;
                                                        stroke-width: 1.5px;
                                                    }
                                                </style>
                                                <g id="ic-contact-chat">
                                                    <path class="cls-1"
                                                        d="M4,3H14a2,2,0,0,1,2,2v6a2,2,0,0,1-2,2H11L8,16,5,13H4a2,2,0,0,1-2-2V5A2,2,0,0,1,4,3Z">
                                                    </path>
                                                    <path class="cls-1"
                                                        d="M16,8h4a2,2,0,0,1,2,2v6a2,2,0,0,1-2,2H18l-2,3-3-3H10a2,2,0,0,1-2-2H8">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                @endif
                                <a href="javascript:void(0);" role="button" class="menu-link"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <li class="gc_main_navigation d-inline-flex">
                                        <div class="img_thumb">
                                            @if (Auth::guard('admin')->user()->role === ROLE_ADMIN)
                                                <div id="avatar" data-avatar="{{ $userName }}"
                                                    class="avatar"></div>
                                            @elseif (Auth::guard('admin')->user()->role === ROLE_COMPANY && optional(Auth::guard('admin')->user()->company)->avatar_path)
                                                <img class="img_thumb_item"
                                                    src="{{ asset(Auth::guard('admin')->user()->company->avatar_path) }}"
                                                    alt="avatar">
                                            @elseif (Auth::guard('admin')->user()->role === ROLE_UNIVERSITY &&
                                                    optional(Auth::guard('admin')->user()->university)->avatar_path)
                                                <img class="img_thumb_item"
                                                    src="{{ asset('storage/' . Auth::guard('admin')->user()->university->avatar_path) }}"
                                                    alt="avatar">
                                            @elseif (Auth::guard('admin')->user()->role === ROLE_SUB_ADMIN)
                                                <div id="avatar" class="avatar"></div>
                                            @elseif (Auth::guard('admin')->user()->role === ROLE_HIRING && optional(Auth::guard('admin')->user()->hirings)->avatar_path)
                                                <img class="img_thumb_item"
                                                    src="{{ asset(Auth::guard('admin')->user()->hirings->avatar_path) }}"
                                                    alt="avatar">
                                            @else
                                                <div id="avatar" class="avatar"></div>
                                            @endif
                                        </div>
                                    </li>
                                </a>
                                <div class="dropdown-menu">
                                    @if (Auth::guard('admin')->user()->role === ROLE_COMPANY)
                                        <a href="{{ route('company.profile') }}" class="dropdown-item"><i
                                                class="fas fa-user-circle"></i>
                                            {{ __('label.admin.header.profile') }}</a>
                                    @elseif (Auth::guard('admin')->user()->role === ROLE_UNIVERSITY)
                                        <a href="{{ route('university.profile') }}" class="dropdown-item"><i
                                                class="fas fa-user-circle"></i>
                                            {{ __('label.admin.header.profile') }}</a>
                                    @endif

                                    @if (Auth::guard('admin')->user()->role === ROLE_ADMIN || Auth::guard('admin')->user()->role === ROLE_SUB_ADMIN)
                                        <a href="{{ route('admin.home') }}" class="dropdown-item"> <i
                                                class="fa-solid fa-screwdriver-wrench"></i>
                                            Vào trang quản trị</a>
                                    @elseif(Auth::guard('admin')->user()->role === ROLE_COMPANY || Auth::guard('admin')->user()->role === ROLE_HIRING)
                                        <a href="{{ route('company.home') }}" class="dropdown-item"> <i
                                                class="fa-solid fa-screwdriver-wrench"></i>
                                            Vào trang quản trị</a>
                                    @elseif(Auth::guard('admin')->user()->role === ROLE_UNIVERSITY &&
                                            Auth::guard('admin')->user()->role === ROLE_SUB_UNIVERSITY)
                                        <a href="{{ route('university.home') }}" class="dropdown-item"> <i
                                                class="fa-solid fa-screwdriver-wrench"></i>
                                            Vào trang quản trị</a>
                                    @endif
                                    <form action="{{ route('management.logout', Auth::guard('admin')->user()->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-button"><i
                                                class="fas fa-sign-out-alt"></i>{{ __('label.admin.header.logout') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                @if (Auth::guard(name: 'web')->user())
                                    <a class="icon_notification" role="button" class="menu-link"
                                        data-bs-toggle="dropdown" aria-expanded="false" href="jvavascript:void(0);">
                                        <span data-count="{{ $notificationCount > 0 ? $notificationCount : 0 }}"
                                            class="notification_count {{ $notificationCount > 0 ? $notificationCount : 'd-none' }}">
                                            {{ $notificationCount }}</span>
                                        <i class="fa-regular fa-bell"></i>
                                    </a>

                                    <div class="dropdown-menu" style="width: 360px;">
                                        <div class="notification-box">
                                            <div class="box_header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0 fw-bold">Thông báo</h5>
                                                @if ($notificationCount > 0)
                                                    <a href="{{ route('markSeenAll') }}" class="mark-read">Đánh dấu
                                                        là đã
                                                        đọc</a>
                                                @endif
                                            </div>

                                            <div class="notification-list" data-role="{{ USER }}"
                                                data-id-chanel="{{ Auth::guard('web')->user()->id }}">
                                                @forelse ($notificationsHeader as $item)
                                                    <a href="{{ $item->link }}" class="notification-item d-block"
                                                        data-id="{{ $item->id }}">
                                                        <div
                                                            class="title {{ $item->is_seen == UNSEEN ? 'fw-bold' : 'fw-medium' }}">
                                                            {{ $item->title }}
                                                        </div>
                                                        <div class="time">
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                                        </div>
                                                        @if ($item->is_seen == SEEN)
                                                            <div class="is-seen">
                                                                <i class="fa-solid fa-check"></i>
                                                            </div>
                                                        @endif
                                                    </a>
                                                @empty
                                                    <div class="no_notifycation title fw-medium text-center pt-2">Không
                                                        có thông báo
                                                        nào
                                                    </div>
                                                @endforelse
                                            </div>

                                        </div>
                                    </div>
                                    <a href="{{ route('conversations', ['id' => $userChatHeader->to_id ?? Auth::guard('web')->user()->id]) }}"
                                        class="icon_message">
                                        <svg width="25px" height="25px" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" fill="#23b6dd">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <style>
                                                    .cls-1 {
                                                        fill: none;
                                                        stroke: #ffffff;
                                                        stroke-linecap: round;
                                                        stroke-linejoin: round;
                                                        stroke-width: 1.5px;
                                                    }
                                                </style>
                                                <g id="ic-contact-chat">
                                                    <path class="cls-1"
                                                        d="M4,3H14a2,2,0,0,1,2,2v6a2,2,0,0,1-2,2H11L8,16,5,13H4a2,2,0,0,1-2-2V5A2,2,0,0,1,4,3Z">
                                                    </path>
                                                    <path class="cls-1"
                                                        d="M16,8h4a2,2,0,0,1,2,2v6a2,2,0,0,1-2,2H18l-2,3-3-3H10a2,2,0,0,1-2-2H8">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0);" role="button" class="menu-link"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <li class="gc_main_navigation d-inline-flex">
                                            <div class="img_thumb">
                                                <img class="img_thumb_item"
                                                    src="{{ Auth::guard('web')->user()->avatar_path ? (filter_var(Auth::guard('web')->user()->avatar_path, FILTER_VALIDATE_URL) ? Auth::guard('web')->user()->avatar_path : asset(Auth::guard('web')->user()->avatar_path)) : asset('clients/images/no-image.jpg') }}"
                                                    alt="avatar">
                                            </div>
                                        </li>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('account.profile') }}" class="dropdown-item"><i
                                                class="fas fa-user-circle"></i>
                                            {{ __('label.admin.header.profile') }}</a>
                                        <a href="{{ route('account.changePasswordForm') }}" class="dropdown-item"><i
                                                class="fas fa-key"></i>
                                            Đổi mật khẩu
                                        </a>

                                        <form action="{{ route('logout', '12') }}" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item logout-button"><i
                                                    class="fas fa-sign-out-alt"></i>{{ __('label.admin.header.logout') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <li><a href="{{ route('viewRegister') }}"><i class="fa fa-user"></i>&nbsp;
                                            Đăng ký
                                        </a>
                                    </li>
                                    <li><a href="{{ route('viewLogin') }}"><i class="fa fa-sign-in"></i>&nbsp;
                                            Đăng nhập</a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="{{ route('management.login') }}">Nhà quản lý</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
