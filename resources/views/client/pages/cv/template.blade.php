@extends('client.layout.main')
@section('title', 'Tạo CV')
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
            /* font-family: 'Roboto' !important; */
            zoom: 65%
        }

        /* height: fit-content; */



        .input-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }




        .cv-settings {
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }


        /* css modal */

        .template-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #f9f9f9;
            padding: 10px;
        }

        .template-item img {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .template-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .template-item button {
            width: 200px;
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .template-item:hover button {
            opacity: 1;
            visibility: visible;
        }

        .template-item button:hover {
            background-color: #0056b3;
        }

        .template-name {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
    </style>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chọn mẫu CV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @php
                    $view = [
                        [
                            'title' => 'Mẫu cơ bản',
                            'image' => 'clients/images/cv/minimal.png',
                            'name_btn' => 'minimal',
                        ],
                        [
                            'title' => 'Mẫu hiện đại',
                            'image' => 'clients/images/cv/modern.png',
                            'name_btn' => 'modern',
                        ],
                    ];
                @endphp
                <div class="modal-body">
                    <div class="row">
                        @foreach ($view as $index => $item)
                            @if ($item['name_btn'] !== $template)
                                <div class="col-md-4 text-center">
                                    <div class="template-item" data-template="{{ $item['name_btn'] }}">
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="img-fluid">
                                        <a href="{{ route('cv.create', ['type' => $item['name_btn']]) }}">
                                            <button class="btn btn-primary mt-2">Dùng mẫu này</button>
                                        </a>
                                    </div>
                                    <p class="template-name mt-2">{{ $item['title'] }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Form và CV -->
    <div class="main-container">
        <!-- Form Section -->
        <div class="form-container">
            <div class="mb-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Đổi mẫu
                </button>
            </div>
            <h3>Nhập Thông Tin CV</h3>
            <form action="{{ route('createCv') }}" method="POST" enctype="multipart/form-data" id="formCv">
                @csrf
                @method('POST')
                <input type="hidden" name="template" value="{{ $template }}" id="templateInput">
                <div class="cv-settings">
                    <h3>Tùy chỉnh CV</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cv-color" class="form-label">Chọn màu chủ đạo:</label>
                            <input type="color" id="cv-color" name="color" class="form-control" value="#e74c3c">
                        </div>
                        <div class="col-md-6">
                            <label for="cv-font" class="form-label">Chọn font chữ:</label>
                            <select id="cv-font" name="font" class="form-control">
                                <option value="Roboto">Roboto</option>
                                <option value="Arial">Arial</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Verdana">Verdana</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tiêu đề hồ sơ</label><span class="text-danger"> *</span>
                    <input type="text" id="title" name="title" class="form-control"
                        placeholder="Nhập tiêu đề hồ sơ">
                    <small class="text-danger error-message"></small>
                </div>
                <h3>Thông Tin Cơ Bản</h3>
                <div class="input-section">
                    <div class="row">
                        <div class="col-md-12 text-start mb-4">
                            <div>
                                <img src="https://placehold.co/400" alt="Avatar" id="avatarPreview" class="rounded-circle"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="mt-2">
                                <label for="avatar" class="form-label">Tải lên ảnh đại diện</label>
                                <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*"
                                    onchange="previewAvatar(event)">
                                <small class="text-danger error-message"></small>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Họ và Tên - Vị trí -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ và Tên<span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Họ và tên">
                                    <small class="text-danger error-message"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Vị trí ứng tuyển<span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="position" name="position_name" class="form-control"
                                        placeholder="Developer">
                                    <small class="text-danger error-message"></small>
                                </div>
                            </div>

                            <!-- Email - Điện thoại -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="email" name="email" class="form-control"
                                        placeholder="Email">
                                    <small class="text-danger error-message"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Điện thoại<span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        placeholder="Điện thoại">
                                    <small class="text-danger error-message"></small>
                                </div>
                            </div>

                            <!-- Ngày sinh - Địa chỉ -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Ngày sinh<span class="text-danger">
                                            *</span></label>
                                    <input type="date" id="birthdate" name="birthdate" class="form-control"
                                        placeholder="Ngày sinh">
                                    <small class="text-danger error-message"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ<span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="address" name="address" class="form-control"
                                        placeholder="Địa chỉ">
                                    <small class="text-danger error-message"></small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contact" class="form-label">Mục tiêu nghề nghiệp</label>
                            <textarea id="introduce" name="introduce" class="form-control" rows="4"></textarea>
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
                        <textarea id="skills" name="skills" rows="4" placeholder="Danh sách kỹ năng..."></textarea>
                        <small class="text-danger error-message"></small>
                    </div>
                </div>

                <!-- Chứng Chỉ -->
                <h3>Chứng Chỉ</h3>
                <div class="input-section">
                    <textarea id="certifications" name="certifications" rows="4" placeholder="Danh sách chứng chỉ..."></textarea>
                    <small class="text-danger error-message"></small>

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



        <div class="cv-container" id="cvContainer">
            @include('client.pages.cv.all.' . $template)
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#formCv').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('createCv') }}",
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
                            toastr.error("", "Có lỗi xảy ra, vui lòng thử lại sau!");
                        }
                    }
                });
            });
        });
    </script>
@endpush
