@extends('client.layout.main')
@section('title', 'Sửa CV')
@section('content')
    <style>
        .main-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            /* height: 100vh;
                                                                                                                                overflow: hidden; */
        }

        .form-container {
            width: 50%;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            max-height: 100vh;
        }

        .form-container h3 {
            margin-bottom: 20px;
            font-size: 18px;
            color: #007bff;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .cv-container {
            width: 50%;
            max-width: 794px;
            min-height: 1123px;
            background: white;
            overflow: visible;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            align-self: flex-start;
            top: 0px;
            font-family: {{ $cv->font }};
            /* max-height: 100vh; */
            zoom: 65%
        }


        /* .header h1 {
            margin: 0;
            margin-top: 20px;
            font-size: 30px;
            font-family: {{ $cv->font }};
            color: {{ $cv->color }};
        }

        .header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .content {
            display: flex;
            padding: 20px;
        }

        .left-section {
            width: 35%;
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }

        .right-section {
            width: 65%;
            padding-left: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .input-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section h3 {
            font-size: 18px;
            color: {{ $cv->color }};
            margin-bottom: 10px;
            font-weight: 600;
            font-family: {{ $cv->font }};
        } */

    </style>
    <div class="main-container">
        <!-- Form Section -->
        <div class="form-container">
            <h3>Nhập Thông Tin CV</h3>
            <form action="{{ route('updateCv', ['id' => $cv->id]) }}" method="PUT" enctype="multipart/form-data"
                data-id="{{ $cv->id }}" id="formCv">
                @csrf
                @method('PUT')
                <input type="hidden" name="template" value="{{ $template }}">
                <div class="cv-settings">
                    <h3>Tùy chỉnh CV</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cv-color" class="form-label">Chọn màu chủ đạo:</label>
                            <input type="color" id="cv-color" name="color" class="form-control"
                                value="{{ $cv->color ?? '#e74c3c' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="cv-font" class="form-label">Chọn font chữ:</label>
                            <select id="cv-font" name="font" class="form-control">
                                <option value="Roboto" {{ $cv->font == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                <option value="Arial" {{ $cv->font == 'Arial' ? 'selected' : '' }}>Arial</option>
                                <option value="Times New Roman" {{ $cv->font == 'Times New Roman' ? 'selected' : '' }}>
                                    Times
                                    New Roman</option>
                                <option value="Georgia" {{ $cv->font == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                                <option value="Verdana" {{ $cv->font == 'Verdana' ? 'selected' : '' }}>Verdana</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tiêu đề hồ sơ</label>
                    <input type="text" id="title" name="title" class="form-control"
                        placeholder="Nhập tiêu đề hồ sơ" value="{{ $cv->title }}">
                    <small class="text-danger error-message"></small>
                </div>
                <h3>Thông Tin Cơ Bản</h3>
                <div class="input-section">
                    <div class="row">
                        <div class="col-md-12 text-start mb-4">
                            <div>
                                <img src="{{ $cv->avatar ?? asset('clients/images/content/base.png') }}" alt="Avatar"
                                    id="avatarPreview" class="rounded-circle"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="mt-2">
                                <label for="avatar" class="form-label">Tải lên ảnh đại diện</label>
                                <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                                <small class="text-danger error-message"></small>
                            </div>
                        </div>
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và Tên</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Họ và tên" value="{{ $cv->username }}">
                                <small class="text-danger error-message"></small>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ $cv->email }}">
                                <small class="text-danger error-message"></small>

                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Ngày sinh</label>
                                <input type="date" id="birthdate" name="birthdate" class="form-control"
                                    placeholder="Ngày sinh" value="{{ $cv->birthdate }}">
                                <small class="text-danger error-message"></small>
                            </div>


                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Vị trí</label>
                                <input type="text" id="position" name="position_name" class="form-control"
                                    placeholder="Developer" value="{{ $cv->position }}">
                                <small class="text-danger error-message"></small>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Điện thoại</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="Điện thoại" value="{{ $cv->phone }}">
                                <small class="text-danger error-message"></small>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Địa chỉ</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="Địa chỉ" value="{{ $cv->address }}">
                                <small class="text-danger error-message"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Mục tiêu nghề nghiệp</label>
                            <textarea id="introduce" name="introduce" class="form-control" rows="4">{{ $cv->introduce }}</textarea>
                            <small class="text-danger error-message"></small>
                        </div>
                    </div>
                </div>


                <!-- Kinh Nghiệm Làm Việc -->
                <div>
                    <h3>Kinh Nghiệm Làm Việc</h3>
                    <div id="work-experience-container">

                    </div>
                    <button type="button" class="btn btn-primary mb-3" id="add-work-experience-button">
                        <i class="fas fa-plus"></i> Thêm Kinh Nghiệm Làm Việc
                    </button>
                </div>

                <!-- Học Vấn -->
                <div>
                    <h3>Học Vấn</h3>

                    <div id="education-container">
                    </div>

                    <button type="button" class="btn btn-primary mb-3" id="show-education-form-button">
                        <i class="fas fa-plus"></i> Thêm Học Vấn
                    </button>

                </div>

                <!-- Kỹ Năng -->
                <div>
                    <h3>Kỹ Năng</h3>
                    <div class="input-section">
                        @foreach ($cv->cv_skill as $skill)
                            <textarea id="skills" name="skills" rows="4" placeholder="Danh sách kỹ năng...">{{ $skill->name }}</textarea>
                            <small class="text-danger error-message"></small>
                        @endforeach
                    </div>
                </div>

                <!-- Chứng Chỉ -->
                <h3>Chứng Chỉ</h3>
                <div class="input-section">
                    @foreach ($cv->certificates as $certificate)
                        <textarea id="certifications" name="certifications" rows="4" placeholder="Danh sách chứng chỉ...">{{ $certificate->description }}</textarea>
                        <small class="text-danger error-message"></small>
                    @endforeach
                </div>

                <div>
                    <h3>Người giới thiệu</h3>
                    <div id="personal-introduce">
                    </div>

                    <button type="button" class="btn btn-primary mb-3" id="show-personal-introduce">
                        <i class="fas fa-plus"></i> Thêm người giới thiệu
                    </button>

                </div>

                <button type="submit">Lưu</button>
            </form>
        </div>



        <div class="cv-container">
            @if ($template == 'minimal')
                @include('client.pages.cv.edit.template.minimal')
            @elseif ($template == 'elegant')
                @include('client.pages.cv.edit.template.elegant')
            @elseif ($template == 'modern')
                @include('client.pages.cv.edit.template.modern')
            @else
                <p>Không tìm thấy mẫu CV phù hợp.</p>
            @endif
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#formCv').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                let cvId = $(this).data('id');

                $.ajax({
                    url: `/cv/${cvId}/update`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success("", response.message);

                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1500);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Xóa thông báo lỗi cũ
                            $('.error-message').text('');

                            $.each(errors, function(key, value) {
                                let keyParts = key.split('.');

                                if (keyParts.length > 1) {
                                    let fieldName = keyParts[0] + '[]';
                                    let index = parseInt(keyParts[1]);

                                    let inputField = $(`[name="${fieldName}"]`).eq(
                                        index);
                                    let errorContainer = inputField.closest('.mb-3')
                                        .find('.error-message');
                                    errorContainer.text(value[0]);
                                } else {
                                    let inputField = $('[name="' + key + '"]');

                                    if (inputField.attr('type') === 'file') {
                                        inputField.closest('.col-md-12').find(
                                            '.error-message').text(value[0]);
                                    } else if (inputField.is('textarea')) {
                                        inputField.closest('.input-section').find(
                                            '.error-message').text(value[0]);
                                    } else {
                                        inputField.closest('.mb-3').find(
                                            '.error-message').text(value[0]);
                                    }
                                }
                            });

                            toastr.error("", "Dữ liệu chưa hợp lệ, vui lòng kiểm tra lại!");
                        } else {
                            console.error('Lỗi khác:', xhr.status);
                            console.error('Response Text:', xhr.responseText);
                            toastr.error("", "Có lỗi xảy ra, vui lòng thử lại sau!");
                        }
                    }
                });
            });
        });
    </script>

@endsection
