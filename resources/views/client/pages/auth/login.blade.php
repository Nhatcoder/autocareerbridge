@extends('client.layout.main')
@section('title', 'Đăng nhập')

@section('css')
@endsection
@section('content')
    <!-- jp login wrapper start -->
    <div class="login_section">
        <!-- login_form_wrapper -->
        <div class="login_form_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <!-- login_wrapper -->
                        <h1>Chào mừng bạn đến với JOBPRO</h1>
                        <p>Cùng xây dựng một hồ sơ nổi bật và nhận được các cơ hội sự nghiệp lý tưởng</p>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="login_wrapper">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                                        <a href="#" class="btn btn-primary"> <span>Đăng nhập với Facebook</span>
                                            <i class="fa-brands fa-facebook"></i>
                                        </a>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                                        <a href="{{ route('viewLoginWithGoogle') }}"
                                            class="btn btn-primary google-plus btn_login_google">
                                            Đăng nhập với Google
                                            <i class="fa-brands fa-google"></i>
                                        </a>
                                    </div>
                                </div>
                                <h2>hoặc</h2>
                                <div class="formsix-pos">
                                    <div class="form-group i-email">
                                        <input type="email" class="form-control" name="email" placeholder="Nhập email*">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="formsix-e">
                                    <div class="form-group i-password">
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Nhập mật khẩu *">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @if (Session::has('error'))
                                    <span class="text-danger">{{ Session::get('error') }}</span>
                                @endif
                                <div class="login_remember_box mt-0">
                                    <label class="">
                                    </label>
                                    <a href="#" class="forget_password">
                                        Quên mật khẩu ?
                                    </a>
                                </div>
                                <div class="login_btn_wrapper">
                                    <button type="submit" class="btn btn-primary login_btn"> Đăng nhập </button>
                                </div>
                                <div class="login_message">
                                    <p>Bạn chưa có tài khoản ? <a href="{{ route('viewRegister') }}"> Đăng ký ngay </a> </p>
                                </div>
                            </div>
                        </form>
                        <p>Trong trường hợp bạn đang sử dụng máy tính công khai/chia sẻ, chúng tôi khuyên bạn nên đăng xuất
                            để ngăn chặn mọi quyền truy cập không được ủy quyền vào tài khoản của bạn</p>
                        <!-- /.login_wrapper-->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.login_form_wrapper-->
    </div>


@endsection


@section('js')
@endsection
