@extends('client.layout.main')
@section('title', 'Thay đổi mật khẩu | ' . config('app.name'))

@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="card" style="margin-top: 120px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">Thay đổi mật khẩu đăng nhập</h2>
                        <hr>
                        <form action="{{ route('account.updatePassword') }}" method="post">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email đăng nhập</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>
                            </div>

                            @if (Auth::check() && Auth::user()->password != null)
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="password_old">Mật khẩu hiện tại</label>
                                            <input type="password" class="form-control" id="password_old" name="password_old"
                                                value="">
                                            @error('password_old')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            @if (Session::has('password_old'))
                                                <span class="text-danger">{{ Session::get('password_old') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="password">Mật khẩu mới</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="password_confirmation">Nhập lại mật khẩu mới</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" value="">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <button class="btn text-white" style="background-color: #23c0e9">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
@endsection
