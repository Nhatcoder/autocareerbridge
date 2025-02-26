@extends('client.layout.main')
@section('title', 'Quản lý CV')
@section('content')
    <style>
        .container {
            display: flex;
            justify-content: center;
            margin-top: 120px;
        }

        .cv-container-my-cv {
            width: 1000px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
    </style>
    <div class="container">
        <div class="cv-container-my-cv">
            <h2 class="mb-4">Danh sách CV đã tạo</h2>
            <a href="{{ route('listCv') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tạo CV mới
            </a>
            <div class="row">
                @forelse ($cv_creates as $cv)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100" style="height: 420px;">
                            <img src="{{ asset('clients/images/cv/' . $cv->template . '.png') }}" class="card-img-top"
                                alt="Mẫu CV {{ $cv->title }}" height="300px">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $cv->title }}</h5>
                                    <p class="card-text"><small class="text-muted">Cập nhật lần cuối:
                                            {{ \Carbon\Carbon::parse($cv->updated_at)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                        </small></p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('cv.edit', ['id' => $cv->id]) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a target="_blank" href="{{ route('cv.view', ['id' => $cv->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <a href="{{ route('cv.download', ['id' => $cv->id]) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Tải xuống
                                    </a>
                                    <form class="form-cv" action="{{ route('cv.delete', ['id' => $cv->id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div
                            style="max-width: 600px; margin: 0 auto; height: 200px; display: inline-block; text-align: center;">
                            <p class="m-0">Bạn chưa tạo CV nào</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 16px">
        <div class="cv-container-my-cv">
            <h2 class="mb-4">Danh sách CV đã tải lên</h2>
            <a href="{{ route('cv.upload') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tải CV lên
            </a>
            <div class="row">
                @forelse ($cv_uploads as $cv)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100" style="height: 420px;">
                            <img src="{{ asset('clients/images/cv/default_cv.jpg') }}" class="card-img-top" alt="Mẫu CV"
                                height="300px">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $cv->title }}</h5>
                                    <p class="card-text"><small class="text-muted">Cập nhật lần cuối:
                                            {{ \Carbon\Carbon::parse($cv->updated_at)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                        </small></p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="#" class="btn btn-warning btn-sm btn-edit-cv"
                                        data-id="{{ $cv->id }}" data-title="{{ $cv->title }}" data-toggle="modal"
                                        data-target="#updateCVUpload">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>

                                    <a target="_blank" href="{{ route('cv.upload.view', ['id' => $cv->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <a href="{{ route('cv.upload.down', ['id' => $cv->id]) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Tải xuống
                                    </a>
                                    <form class="form-cv" action="{{ route('cv.delete', ['id' => $cv->id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div
                            style="max-width: 600px; margin: 0 auto; height: 200px; display: inline-block; text-align: center;">
                            <p class="m-0">Bạn chưa tải lên CV nào</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="updateCVUpload" class="modal fade in" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cv.upload.update', ['id' => $cv->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="cv_upload_id" value="" class="cv_upload_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Chỉnh sửa CV Upload</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="title_file_cv_upload">Tên CV (thường là vị trí ứng tuyển)</label>
                            <input type="name" class="form-control border-hover" name="title_file_cv_upload"
                                placeholder="Tên CV" required="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn-update-cv btn btn-sm btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".btn-edit-cv").click(function() {
                let cvId = $(this).data("id");
                let cvTitle = $(this).data("title");

                $("#updateCVUpload .cv_upload_id").val(cvId);
                $("#updateCVUpload input[name='title_file_cv_upload']").val(cvTitle);

                $("#updateCVUpload").modal("show");
            });
            $(".btn-update-cv").click(function(e) {
                e.preventDefault();
                let cvId = $("#updateCVUpload .cv_upload_id").val();
                let newTitle = $("#updateCVUpload input[name='title_file_cv_upload']").val();

                $.ajax({
                    url: "/cv/upload/" + cvId + "/update",
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        title_file_cv_upload: newTitle
                    },
                    success: function(response) {
                        toastr.success('', response.message);
                        setTimeout(function() {
                            window.location.href = '/my-cv';
                        }, 1500);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || "Cập nhật thất bại!", "Lỗi");
                    }
                });
            });


        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            let form = $(this).closest('.form-cv');
            Swal.fire({
                title: "Bạn có muốn xoá CV?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Xoá",
                cancelButtonText: "Huỷ",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
