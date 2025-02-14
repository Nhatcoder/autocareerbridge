@extends('client.layout.main')
@section('title', 'Tài khoản')

@section('css')
    <style>
        .avatar_user {
            position: relative;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
        }

        .upload_avatar .avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .upload_avatar .icon_upload {
            position: absolute;
            bottom: 4px;
            font-size: 20px;
            padding: 3px 4px;
            color: #fff;
            background: #3b4774;
            left: 70px;
            border-radius: 50%;
            cursor: pointer;
        }

        .upload_avatar .icon_upload:hover {
            background: #23c0e9;
        }

        .box_info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .box_info_name {
            font-size: 18px;
            font-weight: 600;
            word-break: break-word;
            text-overflow: ellipsis;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .err_avatar {
            color: red;
            font-size: 12px
        }

        .content_box p {
            font-size: 16px;
        }

        .content_box li {
            font-size: 12px;
        }

        .content_box li:before {
            background: rgba(35, 192, 233, 0.2);
            border-radius: 20px;
            color: #23c0e9;
            content: "✓";
            font-family: Font Awesome\ 6 Pro;
            font-size: 12px;
            font-weight: 400;
            height: 16px;
            margin-right: 8px;
            padding: 4px 7px;
            width: 16px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-xs-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <h2 class="text-center">Tài khoản</h2>
                            <div class="col-md-12">
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
                                                <button class="btn text-white" style="background-color: #23c0e9">Cập
                                                    nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-xs-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="avatar_user gap-3 d-flex flex-start">
                                <div class="upload_avatar">
                                    <img src="{{ asset(Auth::user()->avatar_path) }}" alt="{{ Auth::user()->name ?? "avatar"}}" class="avatar"
                                        id="load_avatar">
                                    <label for="file_avatar" class="icon_upload">
                                        <i class="fa-solid fa-camera"></i>
                                    </label>
                                    <input type="file" class="d-none" name="file_avatar" id="file_avatar">
                                </div>
                                <div class="box_info">
                                    <span>Chào bạn trở lại,</span>
                                    <span class="box_info_name">{{ Auth::user()->name }}</span>
                                    <span class="text-danger err_avatar">Ảnh chỉ được tải dưới 5mb</span>
                                </div>
                            </div>
                        </form>

                        <div class="content_box">
                            <p class="fs-12 pt-1">
                                Khi có cơ hội việc làm phù hợp, NTD sẽ liên hệ và trao đổi với bạn qua:
                            </p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2">Nhắn tin qua Top Connect trên TopCV</li>
                                <li class="mb-2">Email và Số điện thoại của bạn</li>
                            </ul>
                            <div class="banner--app  d-flex align-items-center justify-content-center">
                                <img class="w-100" src="{{ asset('clients/images/banner_profile.jpg') }}"
                                    alt="Banner image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(document).on('change', '#file_avatar', function() {
                var file = this.files[0];
                if (!file) return;

                if (this.files[0].size > 5000000) {
                    toastr.error("", 'Vui lòng chọn ảnh dưới 5mb');
                    return;
                }

                if(this.files[0].type != 'image/jpeg' && this.files[0].type != 'image/png' && this.files[0].type != 'image/jpg') {
                    toastr.error("", 'Vui lòng chọn ảnh jpeg, jpg, png');
                    return;
                }

                var formData = new FormData();
                formData.append('avatar_path', file);
                formData.append('id', '{{ Auth::user()->id }}');
                formData.append('_token', '{{ csrf_token() }}');

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#load_avatar').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);

                $.ajax({
                    url: "{{ route('account.updateAvatar') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status) {
                            toastr.success("", response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('.err_avatar').text('Có lỗi xảy ra khi tải ảnh lên.');
                    }
                });
            });

        });
    </script>
@endsection
