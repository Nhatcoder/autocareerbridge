@extends('management.layout.main')
@section('title', __('label.company.sidebar.schedule_interview'))

@section('css')
    <style>
        th {
            padding: 0 !important;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
@endsection
@section('content')
    <div class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="page-titles">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"> {{ __('label.company.job.home') }} </a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('label.company.sidebar.schedule_interview') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card quick_payment">
                        <div class="card-body p-0">
                            <div class="card-body ">
                                <!-- FullCalendar -->
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <form id="createEventForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm lịch phỏng vấn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề <span style="color:red">*</span></label>
                            <input type="text" name="title" class="form-control" id="eventTitle" placeholder="Tiêu đề">
                            <span class="text-danger title-error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Việc làm phỏng vấn <span style="color:red">*</span></label>
                            <select name="job_id" class="form-control" id="jobId">
                                <option value="">Chọn việc làm phỏng vấn</option>
                                @forelse ($userApplyJobs as $key => $userApplyJob)
                                    <option value="{{ $userApplyJob->job->id }}">{{ $userApplyJob->job->name }}
                                    </option>
                                @empty
                                    <option value="">Không có việc làm phỏng vấn nào</option>
                                @endforelse
                            </select>
                            <span class="text-danger jobId-error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ứng viên <span style="color:red">*</span></label>
                            <div class="list-user d-flex gap-2 overflow-x-scroll">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thời gian bắt đầu <span style="color:red">*</span></label>
                            <div class="d-flex gap-2">
                                <input type="date" class="form-control" id="eventStartDate">
                                <input type="time" class="form-control" id="eventStartTime">
                            </div>
                            <span class="text-danger eventStartDate-error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời gian kết thúc</label>
                            <div class="d-flex gap-2">
                                <input type="date" class="form-control" id="eventEndDate">
                                <input type="time" class="form-control" id="eventEndTime">
                            </div>
                            <span class="text-danger eventEndDate-error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình thức <span style="color:red">*</span></label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="radio" id="type1" checked name="type" value="{{ TYPE_SCHEDULE_OFF }}"
                                    class="form-check-input">
                                <label class="form-label m-0" for="type1">Offline</label>
                                <input type="radio" id="type2" name="type" value="{{ TYPE_SCHEDULE_ON }}"
                                    class="form-check-input ml-3">
                                <label class="form-label m-0" for="type2">Online</label>
                            </div>
                        </div>

                        <div class="mb-3 eventLocationDiv">
                            <label class="form-label">Địa điểm <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="eventLocation" placeholder="Địa điểm">
                            <span class="text-danger eventLocation-error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="descrption" id="eventDescrption" cols="30" rows="4"
                                placeholder="Mô tả"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" onclick="scheduleInterviewStore()">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showLoading() {
            $('.loading-overlay').css('display', 'flex');
        }

        function hideLoading() {
            $('.loading-overlay').css('display', 'none');
        }

        $(document).ready(function() {
            $('#createEventModal').on('shown.bs.modal');

            $("#jobId").on("change", function() {
                let jobId = $(this).val();

                if (jobId) {
                    $.ajax({
                        url: "{{ route('company.getUserJob') }}",
                        type: "GET",
                        data: {
                            jobId: jobId
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.list-user').html(response.data.map(function(item) {
                                    return (
                                        `
                                    <div class="d-flex gap-2">
                                        <input class="form-check-input" type="checkbox" name="user_ids[]" value="${item.user.id}"
                                            id="user_${item.user.id}">
                                        <label class="form-check-label'" style="color: #000;" for="user_${item.user.id}">
                                            ${item.user.name}
                                        </label>
                                    </div>
                                    `
                                    )
                                }));
                            }

                        },
                        error: function(xhr) {
                            console.error("Lỗi Ajax:", xhr.responseText);
                        }
                    });
                } else {
                    $("#userId").empty().trigger("change");
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            $("input[type='radio']").on('change', function() {
                let type = $(this).val();
                if (type == 2) {
                    $('.eventLocationDiv').removeClass('d-block').addClass('d-none')
                } else {
                    $('.eventLocationDiv').removeClass('d-none').addClass('d-block')
                }
            });

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                editable: true,
                selectable: true,
                loading: function(isLoading) {
                    if (isLoading) {
                        showLoading();
                    } else {
                        hideLoading();
                    }
                },
                events: {
                    url: "{{ route('company.refreshEvents') }}",
                    failure: function() {
                        hideLoading();
                        toastr.error('Error while fetching events!');
                    }
                },
                select: function(info) {
                    const now = new Date();
                    const selectedStart = new Date(info.start);
                    const minTime = new Date(now.getTime() + (24 * 60 * 60 * 1000));

                    if (selectedStart < minTime) {
                        toastr.error('Vui lòng chọn thời gian phỏng vấn trước ít nhất 24 giờ.');
                        return;
                    }

                    clearInput();
                    document.getElementById('eventStartDate').value = info.startStr.split('T')[0];
                    document.getElementById('eventStartTime').value = info.startStr.split('T')[1]
                        ?.substring(0, 5) || '';
                    document.getElementById('eventEndDate').value = info.endStr.split('T')[0];
                    document.getElementById('eventEndTime').value = info.endStr.split('T')[1]
                        ?.substring(0, 5) || '';

                    $('#createEventModal').modal('show');
                },
            });
            calendar.render();

            window.scheduleInterviewStore = function() {
                showLoading();

                $('.text-danger').text('');

                const title = $("#eventTitle").val().trim();
                const jobId = $("#jobId").val();
                const startDate = $("#eventStartDate").val();
                const startTime = $("#eventStartTime").val();
                const endDate = $("#eventEndDate").val();
                const endTime = $("#eventEndTime").val();
                const description = $("#eventDescrption").val().trim();
                const type = $("input[name='type']:checked").val();
                const location = $("#eventLocation").val().trim();

                const userIds = [];
                $("input[name='user_ids[]']:checked").each(function() {
                    userIds.push($(this).val());
                });

                let isValid = true;

                if (!title) {
                    isValid = false;
                    $(".title-error").text('Vui lòng nhập tiêu đề');
                }

                if (!jobId) {
                    isValid = false;
                    $(".jobId-error").text('Vui lòng chọn vị trí phỏng vấn');
                }

                if (!startDate || !startTime) {
                    isValid = false;
                    $(".eventStartDate-error").text('Vui lòng chọn thời gian bắt đầu');
                }

                if (!endDate || !endTime) {
                    isValid = false;
                    $(".eventEndDate-error").text('Vui lòng chọn thời gian kết thúc');
                }

                if (startDate && endDate && startTime && endTime) {
                    const startDateTime = new Date(`${startDate} ${startTime}`);
                    const endDateTime = new Date(`${endDate} ${endTime}`);

                    if (endDateTime <= startDateTime) {
                        isValid = false;
                        $(".eventEndDate-error").text('Thời gian kết thúc phải sau thời gian bắt đầu');
                    }
                }

                if (userIds.length === 0) {
                    isValid = false;
                    $(".list-user").after(
                        '<span class="text-danger">Vui lòng chọn ít nhất một ứng viên</span>');
                }

                if (!isValid) {
                    hideLoading();
                    return;
                }

                const dataEvent = {
                    title: title,
                    job_id: jobId,
                    startDate: `${startDate} ${startTime}`,
                    endDate: `${endDate} ${endTime}`,
                    location: location,
                    description: description,
                    user_ids: userIds,
                    type: type,
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    url: "{{ route('company.scheduleInterviewStore') }}",
                    type: 'POST',
                    data: JSON.stringify(dataEvent),
                    contentType: 'application/json',
                    processData: false,
                    context: this,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoading();
                        if (response.success) {
                            toastr.success("", response.message);
                            calendar.refetchEvents();
                            $('#createEventModal').modal('hide');
                            clearInput();
                        } else {
                            toastr.error("", response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        toastr.error('Error adding event: ' + error);
                    }
                });
            };

            // Add to clearInput function
            window.clearInput = function() {
                $("#eventTitle").val('');
                $("#eventStartDate").val('');
                $("#eventStartTime").val('');
                $("#eventEndDate").val('');
                $("#eventEndTime").val('');
                $("#eventLocation").val('');
                $("#eventDescrption").val('');
                $("input[name='user_ids[]']").prop('checked', false);
                $('.text-danger').text('');
                $(".list-user").empty();
            };
        });
    </script>
@endsection
