@extends('management.layout.main')

@section('title', 'Quản lý ứng tuyển công việc')
@section('css')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="col-xl-12">
            <div class="page-titles">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{ route('company.home') }}">{{ __('label.breadcrumb.home') }}</a></li>
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
    </div>

    <div class="modal fade bd-example-modal-lg" id="interviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mời <span id="candidateName"></span> phỏng vấn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="interviewForm" action="{{ route('company.changeStatusUserAplly') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="interviewTime" class="form-label">Chọn thời gian phỏng vấn:</label>
                            <input type="datetime-local" id="interviewTime" name="interview_time" class="form-control"
                                required>
                        </div>
                        <input type="hidden" id="applicationId" name="id">
                        <input type="hidden" id="statusApplication" name="status">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
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

            $(document).on('change', 'select.change_status', function(e) {
                var $select = $(this);
                var status = $select.val();
                var id = $select.data('id');
                var url = $select.data('url');
                let statusFit = $select.data('status');

                if (status == statusFit) {
                    $('#interviewModal').modal('show');
                    $('#applicationId').val(id);
                    $('#statusApplication').val(status);
                    $('#interviewModal').data('current-select', $select);
                }

                let dataNew = {
                    id: id,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                };

                if (status == 0 || status == statusFit) {
                    return;
                }

                if ($("#interviewModal").is(':visible') && status == 2) {
                    resetSelectBootstrap($select);
                }

                $.ajax({
                    url: url,
                    data: dataNew,
                    type: 'POST',
                    success: function(response) {
                        toastr.success("", response.message);
                        $select.addClass('disabled');
                    },
                    error: function(response) {
                        toastr.error("", response.message);
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
                $.ajax({
                    url: e.target.action,
                    data: formData,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            var $currentSelect = $('#interviewModal').data('current-select');
                            if ($currentSelect) {
                                $currentSelect.data('confirmed', true);
                                $currentSelect.data('initial-value', $currentSelect
                                    .val());
                            }
                            $('#interviewModal').modal('hide');
                            toastr.success("", response.message);
                        }

                    },
                    error: function(response) {
                        toastr.error("", response.message);
                    }
                });
            });

            // Hàm reset select của Bootstrap Select
            function resetSelectBootstrap($select) {
                var initialValue = $select.data('initial-value');
                $select.val(initialValue).selectpicker('refresh');
            }
        });
    </script>
@endsection
