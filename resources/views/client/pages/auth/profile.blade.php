@extends('client.layout.main')
@section('title', 'Tài khoản')

@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="card" style="margin-top: 120px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">Cài đặt thông tin cá nhân</h2>
                        <hr>
                        <form action="{{ route('account.updateProfile') }}" method="post">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Họ tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ Auth::user()->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ Auth::user()->phone }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <button class="btn text-white" style="background-color: #23c0e9">Lưu thông
                                            tin</button>
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
