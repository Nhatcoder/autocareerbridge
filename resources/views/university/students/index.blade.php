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
                                                @foreach ($majors as $major)
                                                    <option value="{{ $major->id }}"
                                                        {{ request()->major_id == $major->id ? 'selected' : '' }}>
                                                        {{ $major->name }}
                                                    </option>
                                                @endforeach
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
                                                <th>Tên sinh viên</th>
                                                <th>Ảnh</th>
                                                <th>Email</th>
                                                <th>Số điện thoại</th>
                                                <th>Chuyên ngành</th>
                                                <th>Ngày nhập học</th>
                                                <th>Ngày ra trường</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($students as $student)
                                                <tr>
                                                    <td><strong>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</strong>
                                                    </td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>
                                                        @if ($student->avatar_path)
                                                            @if (str_starts_with($student->avatar_path, 'student/'))
                                                                <img src="{{ asset('storage/' . $student->avatar_path) }}"
                                                                    alt="{{ $student->name }}"
                                                                    style="max-width: 100px; max-height: 100px; object-fit: cover;" />
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">Chưa có ảnh</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>{{ $student->phone }}</td>
                                                    <td>{{ $student->major->name ?? 'N/A' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($student->entry_year)->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($student->graduation_year)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('university.students.edit', $student->slug) }}"
                                                                class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                    class="fa fa-pencil"></i></a>
                                                            <form
                                                                action="{{ route('university.students.destroy', $student->id) }}"
                                                                method="POST" style="display:inline;" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-danger shadow btn-xs sharp btn-delete"
                                                                    data-id="{{ $student->id }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Không có sinh viên nào.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                {{ $students->links() }}
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
