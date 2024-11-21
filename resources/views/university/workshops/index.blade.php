@extends('management.layout.main')

@section('title', 'Danh sách sinh viên')

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
                            <form method="GET" action="{{ route('university.workshop.index') }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-5 col-sm-6 mb-3">
                                            <label class="form-label">Tên workshop</label>
                                            <input type="text" class="form-control" name="search"
                                                value="{{ request()->search }}" placeholder="Tìm kiếm...">
                                        </div>

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <label class="form-label">Thời gian bắt đầu - kết thức</label>
                                            <input type="text" id="dateRangePicker" class="form-control"
                                                name="date_range" placeholder="Chọn khoảng thời gian"
                                                style="background-color: #fff">
                                        </div>

                                        <div class="col-xl-4 col-sm-6 align-self-end mb-3">
                                            <button class="btn btn-primary me-2" title="Click here to Search"
                                                type="submit">
                                                <i class="fa-sharp fa-solid fa-filter me-2"></i>Tìm kiếm
                                            </button>
                                            <button class="btn btn-danger light" title="Click here to remove filter"
                                                type="button"
                                                onclick="window.location.href='{{ route('university.workshop.index') }}'">
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
                                                <th>Thời gian bắt đầu</th>
                                                <th>Thời gian kết thức</th>
                                                <th>Số lượng tham gia</th>
                                                <th>Trạng thái</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($workshops as $workshop)
                                                <tr>
                                                    <td><strong>{{ $loop->iteration + ($workshops->currentPage() - 1) * $workshops->perPage() }}</strong>
                                                    </td>
                                                    <td>{{ $workshop->name }}</td>
                                                    <td>
                                                        @if ($workshop->avatar_path)
                                                            <img src="{{ asset($workshop->avatar_path) }}"
                                                                alt="{{ $workshop->name }}"
                                                                style="max-width: 100px; max-height: 100px; object-fit: cover;" />
                                                        @else
                                                            <span class="text-muted">Chưa có ảnh</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $workshop->start_date }}</td>
                                                    <td>{{ $workshop->end_date }}</td>
                                                    <td>{{ $workshop->amount }}</td>
                                                    <td>
                                                        @if ($workshop->status == 0)
                                                            <span class="badge bg-success">Chờ duyệt</span>
                                                        @else
                                                            <span class="badge bg-danger">Đã duyệt</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a title="Sửa"
                                                            href="{{ route('university.workshop.edit', $workshop->id) }}"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                class="fa fa-pencil"></i></a>
                                                        <a class="btn btn-danger shadow btn-xs sharp me-1 btn-remove"
                                                            data-type="POST" href="javascript:void(0)"
                                                            data-url="{{ route('university.workshop.destroy', ['workshop' => $workshop->id]) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Không có workshop nào.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                {{ $workshops->appends(request()->query())->links() }}
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
