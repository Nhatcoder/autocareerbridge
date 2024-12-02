@extends('management.layout.main')
@section('title', 'Danh sách ngành học')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('management-assets/css/admins/fields.css') }}">
    
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
                                <li class="breadcrumb-item active" aria-current="page">Danh sách ngành học</li>
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
                            <form method="GET" action="{{ route('university.majors.index') }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <label class="form-label">Tên chuyên ngành</label>
                                            <input type="text" class="form-control" name="search"
                                                value="{{ request()->search }}" placeholder="Tìm kiếm...">
                                        </div>

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <label class="form-label">Chuyên ngành</label>
                                            <select name="major_id" class="form-control default-select">
                                                <option value="all">Chọn chuyên ngành</option>
                                                @foreach ($majors_data as $major_data)
                                                    <option value="{{ $major_data->id }}">{{ $major_data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-xl-3 col-sm-6 align-self-end mb-3">
                                            <button class="btn btn-primary me-2" title="Click here to Search"
                                                type="submit">
                                                <i class="fa-sharp fa-solid fa-filter me-2"></i>Tìm kiếm
                                            </button>
                                            <button class="btn btn-danger light" title="Click here to remove filter"
                                                type="button"
                                                onclick="window.location.href='{{ route('university.majors.index') }}'">
                                                Xoá
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
                            <h2 class="card-title">Danh sách ngành học</h2>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('university.majors.create') }}" class="btn btn-success ms-2">Thêm mới</a>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên ngành</th>
                                                <th>Mô tả</th>
                                                <th>Thời gian tạo</th>
                                                <th>Lần cập nhật cuối</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($majors as $major)
                                                <tr>
                                                    <td><strong>{{ $loop->iteration + ($majors->currentPage() - 1) * $majors->perPage() }}</strong>
                                                    </td>
                                                    <td>{{ $major->major->name ?? 'N/A' }}</td>
                                                    <td >{{ $major->major->description ?? 'N/A' }}</td>
                                                    <td>{{ $major->created_at ?? 'N/A' }}</td>
                                                    <td>{{ $major->updated_at ?? 'N/A' }}</td>
                                                    <td>
                                                        <div>
                                                            <form
                                                                action="{{ route('university.majors.destroy', ['major' => $major->major_id]) }}"
                                                                method="POST" style="display:inline;" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-danger shadow btn-xs sharp btn-delete"
                                                                    data-id="">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12" class="text-center">Không có ngành học nào.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                {{ $majors->links() }}
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
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            let form = $(this).closest('.delete-form');
            Swal.fire({
                title: "Bạn có chắc muốn xóa không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
