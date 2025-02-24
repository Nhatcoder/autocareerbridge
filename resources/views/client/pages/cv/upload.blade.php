@extends('client.layout.main')
@section('title', 'Upload CV')
@section('content')
    <style>
        .container {
            max-width: 1000px;
            margin-top: 120px;
        }

        .box-main-upload-cv {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .box-header {
            background: #23c0e9;
            border-radius: 8px 8px 0 0;
            padding: 24px 32px;
        }

        .box-header .title {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 16px;
        }

        .box-header .sub-title {
            font-size: 16px;
            color: #fff;
        }

        .box-body {
            padding: 24px 32px;
        }

        .box-body .desc {
            font-size: 16px;
            color: #444;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .box-upload {
            background: #f8f9fa;
            padding: 20px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .box-upload:hover {
            border-color: #23c0e9;
        }

        .box-upload img {
            width: 80px;
            margin-bottom: 10px;
        }

        .box-upload_title span {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        .not-cv p {
            font-size: 14px;
            color: #777;
            margin: 10px 0;
        }

        .not-cv button {
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .not-cv button:hover {
            color: #fff;
        }

        #file-name {
            display: none;
            font-size: 14px;
            color: #28a745;
            font-weight: 600;
        }

        .btn-upload {
            background: #23c0e9;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 16px auto;
        }

        .btn-upload:hover {
            background: #23c0e9;
            color: #fff;
        }

        .upload-process {
            display: none;
            font-size: 14px;
            color: #23c0e9;
            text-align: center;
            margin-top: 10px;
        }

        .box-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 30px;
        }

        .box-info .item {
            width: 48%;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 15px;
        }

        .box-info .icon {
            font-size: 30px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .box-info .title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .box-info .sub-title {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
        }

        .box-main-upload-cv .box-body .box-info .icon1 i {
            color: #00b14f;
        }

        .box-main-upload-cv .box-body .box-info .icon2 i {
            color: #f70;
        }

        .box-main-upload-cv .box-body .box-info .icon3 i {
            color: #3b78dc;
        }

        .box-main-upload-cv .box-body .box-info .icon4 i {
            color: #dc2f2f;
        }

        @media (max-width: 768px) {
            .box-info {
                flex-direction: column;
            }

            .box-info .item {
                width: 100%;
            }
        }
    </style>

    <div class="container">
        <div class="box-main-upload-cv">
            <div class="box-header">
                <h1 class="title">Upload CV để các cơ hội việc làm tự tìm đến bạn</h1>
                <h2 class="sub-title">Giảm đến 50% thời gian cần thiết để tìm được một công việc phù hợp</h2>
            </div>
            <div class="box-body">
                <p class="desc">
                    Bạn đã có sẵn CV của mình, chỉ cần tải CV lên, hệ thống sẽ tự động đề xuất CV của bạn
                    tới những nhà tuyển dụng uy tín.<br>
                    Tiết kiệm thời gian, tìm việc thông minh, nắm bắt cơ hội và làm chủ đường đua nghề nghiệp của chính
                    mình.
                </p>

                <div class="box-upload">
                    <div class="box-upload_title">
                        <img src="https://www.topcv.vn/v4/image/upload-cv/upload-cloud.png" alt="">
                        <span>Tải lên CV từ máy tính, chọn hoặc kéo thả</span>
                    </div>

                    <div class="not-cv">
                        <p>Hỗ trợ pdf có kích thước dưới 5MB</p>

                        <button type="button" class="btn btn-secondary"
                            onclick="document.getElementById('file-upload-cv').click();">
                            Chọn CV
                        </button>

                        <p class="mt-2 text-success fw-bold" id="file-name">Chưa có file nào</p>
                    </div>

                    <form action="{{ route('cv.upload.store') }}" id="formUploadCv" action="https://www.topcv.vn/upload-cv"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ta_source" value="UploadCVInManagerCV">
                        <input type="file" name="file_upload_cv" id="file-upload-cv" class="d-none">
                    </form>
                </div>

                <div class="box-btn-upload">
                    <button id="btn-upload" class="btn btn-upload">Tải CV lên</button>
                    <p class="text-highlight upload-process">
                        Hệ thống đang xử lý CV của bạn thông thường mất từ 10 đến 15 giây, xin vui lòng đợi !!!
                    </p>
                </div>

                <div class="box-info">
                    <div class="item">
                        <div class="icon icon1"><i class="fa-solid fa-file"></i></div>
                        <h3 class="title">Nhận về các cơ hội tốt nhất</h3>
                        <h4 class="sub-title">CV của bạn sẽ được ưu tiên hiển thị với các nhà tuyển dụng đã xác thực.</h4>
                    </div>
                    <div class="item">
                        <div class="icon icon2"><i class="fa-solid fa-chart-simple"></i></div>
                        <h3 class="title">Theo dõi số liệu, tối ưu CV</h3>
                        <h4 class="sub-title">Theo dõi số lượt xem CV. Biết chính xác nhà tuyển dụng nào đang quan tâm.</h4>
                    </div>
                    <div class="item">
                        <div class="icon icon3"><i class="fa-solid fa-paper-plane"></i></div>
                        <h3 class="title">Chia sẻ CV bất cứ nơi đâu</h3>
                        <h4 class="sub-title">Upload một lần và sử dụng đường link gửi tới nhiều nhà tuyển dụng.</h4>
                    </div>
                    <div class="item">
                        <div class="icon icon4"><i class="fa-solid fa-message"></i></div>
                        <h3 class="title">Kết nối nhanh chóng với nhà tuyển dụng</h3>
                        <h4 class="sub-title">Dễ dàng kết nối với các nhà tuyển dụng quan tâm tới CV của bạn.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("file-upload-cv").addEventListener("change", function() {
            let fileName = this.files[0] ? this.files[0].name : "";
            let fileNameElement = document.getElementById("file-name");

            if (fileName) {
                fileNameElement.textContent = fileName;
                fileNameElement.style.display = "block";
            } else {
                fileNameElement.style.display = "none";
            }
        });

        document.getElementById('file-upload-cv').addEventListener('change', function(event) {
            let fileName = event.target.files[0] ? event.target.files[0].name : "Chưa có file nào";
            document.getElementById('file-name').textContent = fileName;
        });

        document.querySelector(".btn-upload").addEventListener("click", function() {
            document.querySelector(".upload-process").style.display = "block";
        });

        $(document).ready(function() {
            $("#btn-upload").click(function(e) {
                e.preventDefault();

                let formData = new FormData($("#formUploadCv")[0]);

                $.ajax({
                    url: "{{ route('cv.upload') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(".upload-process").show();
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('', response.message);
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1500);
                        } else {
                            toastr.error('Có lỗi xảy ra!');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = Object.values(errors).flat().join('<br>');

                            toastr.error('', errorMessages);
                        } else {
                            toastr.error('Có lỗi xảy ra!', 'Upload thất bại!');
                        }
                    },
                    complete: function() {
                        $(".upload-process").hide();
                    }
                });
            });
        });
    </script>


@endsection
