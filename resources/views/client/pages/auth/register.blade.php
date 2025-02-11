@extends('client.layout.main')
@section('title', 'Đăng ký tài khoản')

@section('css')
@endsection
@section('content')
    <div class="register_section">
        <!-- register_form_wrapper -->
        <div class="register_tab_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="text-center mb-4">
                            <h1>Chào mừng bạn đến với JOBPRO</h1>
                            <p>Cùng xây dựng một hồ sơ nổi bật và nhận được các cơ hội sự nghiệp lý tưởng</p>
                        </div>
                        <div class="register_left_form">
                            <div class="row">
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <div class="form-group mb-3 col-md-6 col-sm-6 col-xs-12">
                                        <label for="">Họ tên <span class="text-danger">*</span></label>
                                        <input class="mb-0 invalid" type="text" name="name"
                                            value="{{ old('name') }}" placeholder="Nhập họ tên">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3 col-md-6 col-sm-6 col-xs-12">
                                        <label for="">Email <span class="text-danger">*</span></label>
                                        <input class="mb-0" type="email" name="email" value="{{ old('email') }}"
                                            placeholder="Email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3 col-xs-12">
                                        <label for="">Mật khẩu <span class="text-danger">*</span></label>
                                        <input id="password-field" class="mb-0" type="password" name="password"
                                            value="" placeholder="Nhập mật khẩu">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3 col-xs-12">
                                        <label for="">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                        <input class="mb-0 " type="password" name="password_confirmation" value=""
                                            placeholder="Nhập lại mật khẩu">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="register_btn_wrapper login_wrapper mb-0">
                                        <button type="submit" class="btn btn-primary login_btn text-center">Đăng
                                            ký</button>
                                    </div>

                                    <div class="register_wrapper">
                                        <h2>Hoặc</h2>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                                                <a href="#" class="btn btn-primary"> <span>Đăng nhập với
                                                        Facebook</span>
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
                                    </div>
                                </form>
                            </div>
                            <div class="login_message">
                                <p>Bạn đã có tài khoản? <a href="{{ route('viewLogin') }}"> Đăng nhập ngay </a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    </script>
@endsection
