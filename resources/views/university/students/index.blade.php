@extends('management.layout.main')
@section('title', 'Danh sách sản phẩm')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-titles">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách sinh viên</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="filter cm-content-box box-primary">
                        <div class="content-title SlideToolHeader">
                            <div class="cpa">
                                <i class="fa-sharp fa-solid fa-filter me-2"></i>Lọc
                            </div>
                            <div class="tools">
                                <a href="javascript:void(0);" class="expand handle"><i class="fal fa-angle-down"></i></a>
                            </div>
                        </div>
                        <div class="cm-content-body form excerpt">
                            <form method="GET" action="{{ route('university.students.index') }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <label class="form-label">Tên sinh viên / Email / Số điện thoại</label>
                                            <input type="text" class="form-control" name="search"
                                                value="{{ request()->search }}" placeholder="Tìm kiếm...">
                                        </div>

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <label class="form-label">Chuyên ngành</label>
                                            <select name="major_id" class="form-control default-select">
                                                <option value="all">Chọn chuyên ngành</option>

                                            </select>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <label class="form-label">Khoảng thời gian nhập học - ra trường</label>
                                            <input type="text" id="dateRangePicker" class="form-control"
                                                name="date_range" placeholder="Chọn khoảng thời gian"
                                                style="background-color: #fff">
                                        </div>

                                        <div class="col-xl-3 col-sm-6 align-self-end mb-3">
                                            <button class="btn btn-primary me-2" title="Click here to Search"
                                                type="submit">
                                                <i class="fa-sharp fa-solid fa-filter me-2"></i>Tìm kiếm
                                            </button>
                                            <button class="btn btn-danger light" title="Click here to remove filter"
                                                type="button"
                                                onclick="window.location.href='{{ route('university.students.index') }}'">
                                                Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card quick_payment">
                        <div class="card-header border-0 pb-2 d-flex justify-content-between">
                            <h2 class="card-title">Danh sách sinh viên</h2>
                            <a href="{{ route('university.students.create') }}" class="btn btn-success">Thêm mới</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên workshop</th>
                                                <th>Ảnh</th>
                                                <th>Số điện thoại</th>
                                                <th>Chuyên ngành</th>
                                                <th>Ngày nhập học</th>
                                                <th>Ngày ra trường</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#dateRangePicker", {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "vn",
                onClose: function(selectedDates, dateStr, instance) {
                    document.getElementById('dateRangePicker').value = dateStr;
                }
            });
        });
    </script>
@endsection
