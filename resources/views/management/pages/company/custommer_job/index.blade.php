@extends('management.layout.main')

@section('title', 'Quản lý ứng tuyển công việc')
@section('css')

@endsection
@section('content')
    <div class="col-xl-12">
        <div class="page-titles">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('company.home') }}">{{ __('label.breadcrumb.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('label.company.applyJob.manage_applied_jobs') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xl-12">
                    <div class="filter cm-content-box box-primary">
                        <div class="content-title SlideToolHeader">
                        </div>
                        <div class="custom-tab-1" id="collaboration-container">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('tab') == 'all' ? 'active' : '' }}"
                                        href="{{ url()->current() }}?tab=all">
                                        <i class="la la-th-large mx-2"></i>
                                        {{ __('label.company.applyJob.all_data') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('tab') == 'w_eval' ? 'active' : '' }}"
                                        href="{{ url()->current() }}?tab=w_eval">
                                        <i class="la la-eye mx-2"></i>
                                        {{ __('label.company.applyJob.w_eval') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('tab') == 'fit' ? 'active' : '' }}"
                                        href="{{ url()->current() }}?tab=fit">
                                        <i class="la la-check-circle mx-2"></i>
                                        {{ __('label.company.applyJob.fit') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('tab') == 'interv' ? 'active' : '' }}"
                                        href="{{ url()->current() }}?tab=interv">
                                        <i class="la la-phone mx-2"></i>
                                        {{ __('label.company.applyJob.interv') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('tab') == 'hired' ? 'active' : '' }}"
                                        href="{{ url()->current() }}?tab=hired">
                                        <i class="la la-briefcase mx-2"></i>
                                        {{ __('label.company.applyJob.hired') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('tab') == 'unfit' ? 'active' : '' }}"
                                        href="{{ url()->current() }}?tab=unfit">
                                        <i class="la la-times-circle mx-2"></i>{{ __('label.company.applyJob.unfit') }}
                                    </a>
                                </li>
                            </ul>

                            <!-- Nội dung của các tab -->
                            <div class="tab-content">
                                <div class="tab-pane fade {{ request()->get('tab') == 'all' ? 'show active' : '' }}"
                                    id="all">
                                    <div id="pending-content">
                                        @include('management.pages.company.custommer_job.table', [
                                            'data' => $all,
                                        ])
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ request()->get('tab') == 'w_eval' ? 'show active' : '' }}"
                                    id="w_eval">
                                    <div id="pending-content">
                                        @include('management.pages.company.custommer_job.table', [
                                            'data' => $w_eval,
                                        ])
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ request()->get('tab') == 'fit' ? 'show active' : '' }}"
                                    id="fit">
                                    <div id="pending-content">
                                        @include('management.pages.company.custommer_job.table', [
                                            'data' => $fit,
                                        ])
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ request()->get('tab') == 'interv' ? 'show active' : '' }}"
                                    id="interv">
                                    <div id="pending-content">
                                        @include('management.pages.company.custommer_job.table', [
                                            'data' => $interv,
                                        ])
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ request()->get('tab') == 'hired' ? 'show active' : '' }}"
                                    id="hired">
                                    <div id="pending-content">
                                        @include('management.pages.company.custommer_job.table', [
                                            'data' => $hired,
                                        ])
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ request()->get('tab') == 'unfit' ? 'show active' : '' }}"
                                    id="unfit">
                                    <div id="pending-content">
                                        @include('management.pages.company.custommer_job.table', [
                                            'data' => $unfit,
                                        ])
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
    <script>
        $(document).ready(function() {
            // Lưu giá trị ban đầu của mỗi select
            $('select.change_status').each(function() {
                $(this).data('initial-value', $(this).val());
                $(this).data('confirmed', false);
            });
            var id = urlCheck = null;
            $(document).on('change', 'select.change_status', function(e) {
                var $select = $(this);
                var status = $select.val();
                id = $select.data('id');
                var url = $select.data('url');
                urlCheck = $select.data('check');
                let statusFit = $select.data('status');

                let dataNew = {
                    id: id,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                };

                if (status == 0 ) {
                    return;
                }

                if ($("#interviewModal").is(':visible') && status == 2) {
                    resetSelectBootstrap($select);
                }

                Swal.fire({
                    title: "{{ __('label.company.applyJob.message_confirm') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#23c0e9",
                    cancelButtonColor: "#fd5353",
                    cancelButtonText: "{{ __('label.company.job.cancel') }}",
                    confirmButtonText: "{{ __('label.company.applyJob.confirm') }}",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        checkSeenCv(id, urlCheck)
                            .then(res => {
                                if (res.success) {
                                    $select.data('confirmed', true);
                                    $select.selectpicker('refresh');
                                    $.ajax({
                                        url: url,
                                        data: dataNew,
                                        type: 'POST',
                                        success: function(response) {
                                            if (response.success) {
                                                toastr.success("", response
                                                    .message);
                                                $select.addClass('disabled');
                                            } else {
                                                toastr.error("", response.message);
                                                $select.val($select.data(
                                                    'initial-value'));
                                                $select.data('confirmed', false);
                                                $select.selectpicker('refresh');
                                            }
                                        },
                                        error: function(response) {
                                            toastr.error("", response.message);
                                            $select.val($select.data(
                                                'initial-value'));
                                            $select.data('confirmed', false);
                                            $select.selectpicker('refresh');
                                        }
                                    });
                                } else {
                                    toastr.error("", res.message);
                                    $select.val($select.data('initial-value'));
                                    $select.data('confirmed', false);
                                    $select.selectpicker('refresh');
                                }
                            });
                    } else {
                        $select.val($select.data('initial-value'));
                        $select.data('confirmed', false);
                        $select.selectpicker('refresh');
                    }
                });
            });

            // Xử lý khi modal bị đóng
            $('#interviewModal').on('hidden.bs.modal', function() {
                var $currentSelect = $(this).data('current-select');
                if ($currentSelect) {
                    if (!$currentSelect.data('confirmed')) {
                        resetSelectBootstrap($currentSelect);
                    }
                }
            });

            // Khi bấm nút "Xác nhận", giữ nguyên giá trị đã chọn
            $(document).on('submit', '#interviewForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                checkSeenCv(id, urlCheck)
                    .then(res => {
                        if (res.success) {
                            $.ajax({
                                url: e.target.action,
                                data: formData,
                                type: 'POST',
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.success) {
                                        var $currentSelect = $('#interviewModal').data(
                                            'current-select');
                                        if ($currentSelect) {
                                            $currentSelect.data('confirmed', true);
                                            $currentSelect.data('initial-value',
                                                $currentSelect
                                                .val());
                                        }
                                        $('#interviewModal').modal('hide');
                                        toastr.success("", response.message);
                                    }
                                },
                                error: function(response) {
                                    $('#interviewModal').modal('hide');
                                    toastr.error("", response.message);
                                }
                            });
                        } else {
                            toastr.error("", res.message);
                            $('#interviewModal').modal('hide');
                            $select.val($select.data('initial-value'));
                            $select.data('confirmed', false);
                            $select.selectpicker('refresh');
                            return;
                        }
                    })
            });

            // Hàm reset select của Bootstrap Select
            function resetSelectBootstrap($select) {
                var initialValue = $select.data('initial-value');
                $select.val(initialValue).selectpicker('refresh');
            }

            // check seen cv
            function checkSeenCv(idCheck, urlCheck) {
                return $.ajax({
                    url: urlCheck,
                    method: 'GET',
                    data: {
                        id: idCheck
                    }
                });
            }

            // Xem cv
            $(".seen_cv__user").on('click', function(e) {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('company.seenCvUserJob') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            })
        });
    </script>
@endsection
