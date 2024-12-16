@extends('management.layout.main')

@section('title', 'Danh sách giáo vụ')

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
                                <li class="breadcrumb-item active" aria-current="page">Danh sách giáo vụ</li>
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
                            <form method="GET" action="{{ route('university.academicAffairs') }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <label class="form-label">Tên đầy đủ / Email</label>
                                            <input type="text" class="form-control" name="search"
                                                value="{{ request()->search }}" placeholder="Tìm kiếm...">
                                        </div>
                                        <div class="col-xl-2 col-sm-6">
                                            <label class="form-label">Ngày tham gia</label>
                                            <div class="input-hasicon mb-sm-0 mb-3">
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ request()->date }}">
                                                <div class="icon"><i class="far fa-calendar"></i></div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 align-self-end mb-3">
                                            <button class="btn btn-primary me-2" title="Click here to Search"
                                                type="submit">
                                                <i class="fa-sharp fa-solid fa-filter me-2"></i>Lọc
                                            </button>
                                            <button class="btn btn-danger light" title="Click here to remove filter"
                                                type="button"
                                                onclick="window.location.href='{{ route('university.academicAffairs') }}'">
                                                Xóa bộ lọc
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
                            <h2 class="card-title">Danh sách giáo vụ</h2>
                            <a href="{{ route('university.createAcademicAffairs') }}" class="btn btn-primary">Thêm mới</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên đầy đủ</th>
                                                <th>Ảnh</th>
                                                <th>Tên đăng nhập</th>
                                                <th>Email</th>
                                                <th>Số điện thoại</th>
                                                <th>Ngày tham gia</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($academicAffairs as $academicAffair)
                                                <tr>

                                                    <td><strong>{{ $loop->iteration + ($academicAffairs->currentPage() - 1) * $academicAffairs->perPage() }}</strong>
                                                    </td>
                                                    <td>{{ $academicAffair->name }}</td>
                                                    @if ($academicAffair->avatar_path)
                                                        <td><img class="rounded-circle" width="45" height="45"
                                                                src=" {{ asset('storage/' . $academicAffair->avatar_path) }}"
                                                                alt=""></td>
                                                    @else
                                                        <td><img class="rounded-circle" width="45" height="45"
                                                                src=" {{ asset('management-assets/images/no-img-avatar.png') }}">
                                                        </td>
                                                    @endif
                                                    <td>{{ $academicAffair->user->user_name }}</td>
                                                    <td>{{ $academicAffair->user->email }}</td>
                                                    <td>{{ $academicAffair->phone }}</td>
                                                    <td class="py-2">
                                                        {{ $academicAffair->user->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('university.editAcademicAffairs', $academicAffair->user_id) }}"
                                                                class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                    class="fa fa-pencil"></i></a>


                                                            <form
                                                                action="{{ route('university.deleteAcademicAffairs', $academicAffair->user->id) }}"
                                                                method="POST" style="display:inline;" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-danger shadow btn-xs sharp btn-delete"
                                                                    data-id="{{ $academicAffair->user->id }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Không có giáo vụ nào.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center align-items-center mt-3">
                                        <div class="dataTables_paginate">
                                            {{ $academicAffairs->appends(request()->query())->links() }}
                                        </div>
                                    </div>
                                </div>
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
                monthSelectorType: "static",
                onClose: function(selectedDates, dateStr, instance) {
                    document.getElementById('dateRangePicker').value = dateStr;
                }
            });
        });
    </script>
     <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            let form = $(this).closest('.delete-form');
            Swal.fire({
                title: "{{ __('label.university.delete_confirm') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "{{ __('label.university.delete') }}",
                cancelButtonText: "{{ __('label.university.cancel') }}",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
