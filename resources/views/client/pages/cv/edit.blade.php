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
            margin-bottom: 15px;
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

        .header {
            background-color: #d3d3d3;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header h1 {
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
        }

        .cv-container p,
        li {
            font-size: 14px;
            color: #000;
        }
    </style>
    <div class="main-container">
        <!-- Form Section -->
        <div class="form-container">
            <h3>Nhập Thông Tin CV</h3>
            <form action="{{ route('updateCv', ['id' => $cv->id]) }}" method="POST" enctype="multipart/form-data">
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
                </div>
                <h3>Thông Tin Cơ Bản</h3>
                <div class="input-section">
                    <div class="row">
                        <div class="col-md-12 text-start mb-4">
                            <div>
                                <img src="{{ $cv->avatar }}" alt="Avatar" id="avatarPreview" class="rounded-circle"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="mt-2">
                                <label for="avatar" class="form-label">Tải lên ảnh đại diện</label>
                                <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và Tên</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Họ và tên" value="{{ $cv->username }}">
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ $cv->email }}">
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Ngày sinh</label>
                                <input type="date" id="birthdate" name="birthdate" class="form-control"
                                    placeholder="Ngày sinh" value="{{ $cv->birthdate }}">
                            </div>


                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Vị trí</label>
                                <input type="text" id="position" name="position_name" class="form-control"
                                    placeholder="Developer" value="{{ $cv->position }}">
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Điện thoại</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="Điện thoại" value="{{ $cv->phone }}">
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Địa chỉ</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="Địa chỉ" value="{{ $cv->address }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Mục tiêu nghề nghiệp</label>
                            <textarea id="introduce" name="introduce" class="form-control" rows="4">{{ $cv->introduce }}</textarea>
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
                        @endforeach
                    </div>
                </div>

                <!-- Chứng Chỉ -->
                <h3>Chứng Chỉ</h3>
                <div class="input-section">
                    @foreach ($cv->certificates as $certificate)
                        <textarea id="certifications" name="certifications" rows="4" placeholder="Danh sách chứng chỉ...">{{ $certificate->description }}</textarea>
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

@endsection
