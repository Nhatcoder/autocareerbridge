<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">

            {{-- Admin --}}
            @if (auth('admin')->user()->role == ROLE_ADMIN)
                <li>
                    <a href="{{ route('admin.home') }}" aria-expanded="false">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.jobs.index') }}" aria-expanded="false">
                        <i class="fa-solid fa-briefcase"></i>
                        <span class="nav-text">Bài tuyển dụng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.workshops.index') }}" aria-expanded="false">
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        <span class="nav-text">Workshops</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-text">Tài khoản</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.users.index') }}">Danh sách</a></li>
                        <li><a href="{{ route('admin.users.create') }}">Thêm mới</a></li>
                    </ul>
                </li>
            @endif

            {{-- Sub Admin --}}
            @if (auth('admin')->user()->role == ROLE_SUB_ADMIN)
                <li>
                    <a href="{{ route('admin.home') }}" aria-expanded="false">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.jobs.index') }}" aria-expanded="false">
                        <i class="fa-solid fa-briefcase"></i>
                        <span class="nav-text">Bài tuyển dụng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.workshops.index') }}" aria-expanded="false">
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        <span class="nav-text">Workshops</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-text">Role SUB ADMIN</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="#">Danh sách</a></li>
                        <li><a href="#">Thêm mới</a></li>
                    </ul>
                </li>
            @endif

            {{-- University --}}
            @if (auth('admin')->user()->role == ROLE_UNIVERSITY)
            <li><a class="has-arrow " href="{{ route('university.academicAffairs') }}" aria-expanded="false">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-text">Quản lí giáo vụ</span>
                    </a>
                <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-text">QL sinh viên</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('university.students.index') }}">Danh sách</a></li>
                        <li><a href="{{ route('university.students.create') }}">Thêm mới</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        <span class="nav-text">QL workshop</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('university.workshop.index') }}">Danh sách</a></li>
                        <li><a href="{{ route('university.workshop.create') }}">Thêm mới</a></li>
                    </ul>
                </li>
            @endif

            {{-- Sub University --}}
            @if (auth('admin')->user()->role == ROLE_SUB_UNIVERSITY)
                <li>
                    <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-text">Role SUB UNIVERSITY</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="#">Danh sách</a></li>
                        <li><a href="#">Thêm mới</a></li>
                    </ul>
                </li>
            @endif

            {{-- Company --}}
            @if (auth('admin')->user()->role == ROLE_COMPANY)
                <li>
                    <a href="{{ route('company.home') }}" aria-expanded="false">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">Thống kê</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.manageHiring') }}" aria-expanded="false">
                        <i class="material-icons">group</i>
                        <span class="nav-text">Quản lý nhân viên</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.searchUniversity') }}" aria-expanded="false">
                        <i class="material-icons">search</i>
                        <span class="nav-text">Tìm kiếm trường học</span>
                    </a>
                </li>
            @endif

            {{-- Hiring --}}
            @if (auth('admin')->user()->role == ROLE_HIRING)
                <li>
                    <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-text">Nhân viên doanh nghiệp</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="#">Danh sách</a></li>
                        <li><a href="#">Thêm mới</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </div>
</div>
