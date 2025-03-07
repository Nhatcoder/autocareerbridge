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

        #calendar {
            width: 100% !important;
            max-width: 100%;
        }

        .fc-view-container {
            width: 100%;
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
                        <li class="breadcrumb-item"><a href="#"> {{ __('label.company.job.home') }}
                            </a></li>
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
    {{-- create --}}
    <div class="modal fade" id="createEventModal" tabindex="-1">
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
                                    <option value="{{ $userApplyJob->job->id }}">
                                        {{ $userApplyJob->job->name }}
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

    {{-- view --}}
    <div class="modal fade" id="eventDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailModalLabel">Chi tiết lịch phỏng vấn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" id="scheduleInterviewIdHidden">
                <div class="modal-body">
                    <p><strong>Tiêu đề:</strong> <span id="detailTitle"></span></p>
                    <p><strong>Công ty:</strong> <span id="detailCompany"></span></p>
                    <p><strong>Công việc:</strong> <span id="detailJob"></span></p>
                    <p><strong>Bắt đầu:</strong> <span id="detailStart"></span></p>
                    <p><strong>Kết thúc:</strong> <span id="detailEnd"></span></p>
                    <p><strong>Mô tả:</strong> <span id="detailDescription"></span></p>
                    <p><strong>Người tham gia:</strong></p>
                    <ul id="detailAttendees"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" id="deleteSchedule">Xóa</button>
                    <button type="button" class="btn btn-warning" id="editEvent">Sửa</button>
                </div>
            </div>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade" id="editEventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Sửa lịch phỏng vấn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        @csrf
                        <input type="hidden" name="id" id="editEventId">

                        <div class="mb-3">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" id="editTitle" class="form-control">
                            <div class="text-danger" id="errorEditTitle"></div>
                        </div>

                        <div class="mb-3">
                            <label>Công việc</label>
                            <select name="job_id" id="editJobSelect" class="form-control">

                            </select>
                            <div class="text-danger" id="errorEditJobSelect"></div>
                        </div>

                        <div class="mb-3">
                            <label>Người tham gia ứng tuyển</label>
                            <div id="editApplicantsList"
                                style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; padding: 5px;">
                                <p class="text-muted">Chọn công việc trước để hiển thị người tham gia.</p>
                            </div>
                            <div class="text-danger" id="errorEditApplicantsList"></div>
                        </div>

                        <div class="mb-3">
                            <label>Thời gian bắt đầu</label>
                            <input type="datetime-local" name="start_date" id="editStartDate" class="form-control">
                            <div class="text-danger" id="errorEditStartDate"></div>
                        </div>

                        <div class="mb-3">
                            <label>Thời gian kết thúc</label>
                            <input type="datetime-local" name="end_date" id="editEndDate" class="form-control">
                            <div class="text-danger" id="errorEditEndDate"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình thức <span style="color:red">*</span></label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" id="editType1" name="type" value="{{ TYPE_SCHEDULE_OFF }}"
                                        class="form-check-input">
                                    <label class="form-label m-0" for="editType1">Offline</label>
                                    <input type="radio" id="editType2" name="type" value="{{ TYPE_SCHEDULE_ON }}"
                                        class="form-check-input ml-3">
                                    <label class="form-label m-0" for="editType2">Online</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 eventLocationDiv">
                            <label class="form-label">Địa điểm <span style="color:red">*</span></label>
                            <input type="text" class="form-control" name="location" id="editLocation"
                                placeholder="Địa điểm">
                            <span class="text-danger eventLocation-error"></span>
                        </div>

                        <div class="mb-3">
                            <label>Mô tả</label>
                            <textarea name="description" id="editDescription" class="form-control"></textarea>
                            <div class="text-danger" id="errorEditDescription"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="updateEvent">Cập nhật</button>
                </div>
            </div>
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
                                            ${item.user.name ? item.user.name : item.user.user_name}
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
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                editable: true,
                selectable: true,
                dayMaxEvents: 3,
                eventLimit: true,
                eventLimitText: "Xem thêm",
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
                    const minTime = new Date(now.getTime() + (6 * 60 * 60 * 1000));

                    if (selectedStart < minTime) {
                        toastr.error('Vui lòng chọn thời gian phỏng vấn trước ít nhất 6 giờ.');
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
                eventClick: function(info) {
                    let eventId = info.event.id;
                    showLoading();

                    $.ajax({
                        url: `/company/schedule-interviews/${eventId}/attendees`,
                        method: 'GET',
                        success: function(dbData) {
                            $('#scheduleInterviewIdHidden').val(dbData
                                .schedule_interview_id);

                            $.ajax({
                                url: `/company/api/gg-calendar/${eventId}`,
                                method: 'GET',
                                success: function(googleData) {
                                    hideLoading();

                                    let attendeesHtml = '';
                                    if (!dbData.attendees || dbData.attendees
                                        .length === 0) {
                                        attendeesHtml =
                                            '<p class="text-muted">Không có người tham gia.</p>';
                                    } else {
                                        dbData.attendees.forEach(function(
                                            user) {
                                            attendeesHtml +=
                                                `<p>${user.name ? user.name : user.user_name} (${user.email})</p>`;
                                        });
                                    }

                                    $('#eventDetailModalLabel').text(
                                        'Chi tiết lịch phỏng vấn');
                                    $('#eventDetailModal').find('.modal-body')
                                        .html(`
                                    <p><strong>Tiêu đề:</strong> ${googleData.title || 'Không có'}</p>
                                    <p><strong>Công ty:</strong> ${dbData.company || 'Không có'}</p>
                                    <p><strong>Tin tuyển dụng:</strong> ${dbData.job || 'Không có'}</p>
                                    <p><strong>Bắt đầu:</strong> ${new Date(googleData.start).toLocaleString()}</p>
                                    <p><strong>Kết thúc:</strong> ${googleData.end ? new Date(googleData.end).toLocaleString() : 'N/A'}</p>
                                    <p><strong>${dbData.type == 2 ? 'Link Google Meet' : 'Địa điểm'}:</strong> ${dbData.type == 2 ? `<a class="text-primary" href="${googleData.hangoutLink}" target="_blank">Tham gia</a>` : (googleData.location || 'Không có')}</p>
                                    <p><strong>Mô tả:</strong> ${googleData.description || 'Không có'}</p>
                                    <p><strong>Người tham gia:</strong></p>
                                    <div>${attendeesHtml}</div>
                                `);

                                    $('#eventDetailModal').modal('show');
                                },
                                error: function(xhr, status, error) {
                                    hideLoading();
                                    toastr.error('Error adding event: ' +
                                        error);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            hideLoading();
                            toastr.error('Error adding event: ' +
                                error);
                        }
                    });
                },
                eventDragStart: false,
                eventDragStop: false,
            });
            calendar.render();

            $('#jobSelect').on('change', function() {
                let jobId = $(this).val();
                let applicantsList = $('#applicantsList');

                if (jobId) {
                    $.ajax({
                        // danh sách ứng viên đã apply vào job
                        url: '/company/jobs/applicants/' + jobId,
                        method: 'GET',
                        success: function(data) {
                            applicantsList.html('');
                            if (data.length === 0) {
                                applicantsList.html(
                                    '<p class="text-muted">Không có ứng viên nào.</p>');
                            } else {
                                data.forEach(function(user) {
                                    applicantsList.append(`
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="user_ids[]" value="${user.id}" id="user_${user.id}">
                            <label class="form-check-label" for="user_${user.id}">
                                            ${user.name ? user.name : user.user_name}
                            </label>
                        </div>
                    `);
                                });
                            }
                        },
                        error: function() {
                            applicantsList.html('<p class="text-danger">Lỗi tải ứng viên.</p>');
                        }
                    });
                } else {
                    applicantsList.html(
                        '<p class="text-muted">Chọn công việc trước để hiển thị người tham gia.</p>');
                }
            });


            let selectedUsers = [];

            $(document).on('click', '#editEvent', function() {
                let id = $('#scheduleInterviewIdHidden').val();

                $.ajax({
                    url: `/company/schedule-interviews/${id}/edit`,
                    method: 'GET',
                    success: function(data) {
                        $('#eventDetailModal').modal('hide');

                        $('#editEventId').val(data.id);
                        $('#editTitle').val(data.title);
                        $('#editStartDate').val(formatDateToInput(data.start_date));
                        $('#editEndDate').val(formatDateToInput(data.end_date));
                        $('#editDescription').val(data.description);
                        $('#editLocation').val(data.location);
                        if (data.type == 1) {
                            $('#editType1').prop('checked', true);
                        } else {
                            $('#editType2').prop('checked', true);
                        }

                        // Lưu sẵn danh sách user đã tham gia
                        selectedUsers = data.attendees.map(user => user.id);

                        $.ajax({
                            url: '/company/getAllJobInterview',
                            method: 'GET',
                            success: function(res) {
                                let jobSelect = $('#editJobSelect');
                                jobSelect.html(
                                    '<option value="">-- Chọn công việc --</option>'
                                );

                                res.data.forEach(item => {
                                    let selected = (item.job.id == data
                                            .job_id) ?
                                        'selected' : '';
                                    jobSelect.append(
                                        `<option value="${item.job.id}" ${selected}>${item.job.name}</option>`
                                    );
                                });

                                jobSelect.val(data.job_id);
                                jobSelect.selectpicker('refresh');

                                // Load danh sách ứng viên theo job_id hiện tại
                                loadApplicantsByJob(data.job_id);
                            }
                        });

                        $('#editEventModal').modal('show');
                    }
                });
            });

            function loadApplicantsByJob(jobId) {
                let attendeesList = $('#editApplicantsList');

                if (jobId) {
                    $.ajax({
                        url: `/company/jobs/applicants/${jobId}`,
                        method: 'GET',
                        success: function(data) {
                            attendeesList.html('');
                            if (data.length === 0) {
                                attendeesList.html('<p class="text-muted">Không có ứng viên nào.</p>');
                            } else {
                                data.forEach(function(user) {
                                    let isChecked = selectedUsers.includes(user.id) ?
                                        'checked' : '';

                                    function getStatusText(status) {
                                        switch (status) {
                                            case {{ STATUS_JOIN }}:
                                                return 'Tham gia';
                                            case {{ STATUS_UN_JOIN }}:
                                                return 'Không tham gia';
                                            case {{ STATUS_WAIT }}:
                                                return 'Chờ xác nhận';
                                            case {{ STATUS_NOT_INVITE }}:
                                                return 'Chưa mời tham gia';
                                            default:
                                                return 'Không xác định';
                                        }
                                    }

                                    let statusText = getStatusText(user.status);


                                    let statusColor = '';
                                    if (user.status === {{ STATUS_JOIN }}) {
                                        statusColor = 'text-success';
                                    } else if (user.status === {{ STATUS_UN_JOIN }}) {
                                        statusColor = 'text-danger';
                                    } else if (user.status === {{ STATUS_WAIT }}) {
                                        statusColor = 'text-warning';
                                    } else if (user.status === {{ STATUS_NOT_INVITE }}) {
                                        statusColor = 'text-secondary';
                                    } else {
                                        statusColor =
                                            'text-muted';
                                    }

                                    attendeesList.append(`
                                                <div class="form-check d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <input class="form-check-input" type="checkbox" name="user_ids[]" value="${user.id}" ${isChecked}>
                                                        <label class="form-check-label">${user.name ? user.name : user.user_name}</label>
                                                        <span class="${statusColor}">${statusText}</span>
                                                    </div>
                                                </div>
                                            `);
                                });
                            }
                        },
                        error: function() {
                            attendeesList.html('<p class="text-danger">Lỗi tải ứng viên.</p>');
                        }
                    });
                } else {
                    attendeesList.html('<p class="text-muted">Chọn công việc để hiển thị người tham gia.</p>');
                }
            }

            $(document).on('change', '#editJobSelect', function() {
                let jobId = $(this).val();

                selectedUsers = [];
                $('#editApplicantsList input[type="checkbox"]:checked').each(function() {
                    selectedUsers.push(parseInt($(this).val()));
                });

                loadApplicantsByJob(jobId);
            });

            function formatDateToInput(dateTimeString) {
                if (!dateTimeString) return '';

                let parts = dateTimeString.split(' ');
                let datePart = parts[0];
                let timePart = parts[1];

                return `${datePart}T${timePart.slice(0, 5)}`;
            }

            // cập nhật lịch
            document.getElementById('updateEvent').addEventListener('click', function() {
                const form = document.getElementById('editEventForm');
                let formData = new FormData(form);
                formData.append('_method', 'PUT');
                let eventId = document.getElementById('editEventId').value;

                if (!eventId) {
                    toastr.error('', 'Không tìm thấy ID sự kiện để cập nhật.');
                    return;
                }

                let url = `{{ url('company/schedule-interviews') }}/${eventId}`;

                document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            toastr.error('Lỗi: ' + data.error);
                        } else if (data.errors) {
                            console.log("Errors received:", data.errors);
                            Object.keys(data.errors).forEach(field => {
                                let errorField = null;

                                if (field === 'job_id') {
                                    errorField = document.getElementById('errorEditJobSelect');
                                } else if (field === 'user_ids') {
                                    errorField = document.getElementById(
                                        'errorEditApplicantsList');
                                } else {
                                    let fieldName = field.replace(/_([a-z])/g, (match,
                                        letter) => letter.toUpperCase());
                                    errorField = document.getElementById(
                                        `errorEdit${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}`
                                    );
                                }

                                if (errorField) {
                                    errorField.classList.add('text-danger');
                                    errorField.textContent = data.errors[field][0];
                                }
                            });
                        } else {
                            let event = calendar.getEventById(eventId);
                            if (event) event.remove();
                            calendar.addEvent(data.schedule);
                            $('#editEventModal').modal('hide');
                            toastr.success("", data.message);
                            calendar.refetchEvents();
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            });

            $('#editEventModal').on('hidden.bs.modal', function() {
                document.getElementById('editEventForm').reset();
                document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
            });

            // Delete schedule
            $(document).on('click', '#deleteSchedule', function() {
                let id = $('#scheduleInterviewIdHidden').val();
                Swal.fire({
                    title: "Bạn có muốn xóa cuộc phỏng vấn này không?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('label.company.job.delete') }}",
                    cancelButtonText: "{{ __('label.company.job.cancel') }}",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();
                        $.ajax({
                            url: "{{ route('company.deleteScheduleInterview') }}",
                            method: 'POST',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                hideLoading();
                                if (data.success) {
                                    toastr.success("", data.message);
                                } else {
                                    toastr.error("", data.message);
                                }
                                $('#eventDetailModal').modal('hide');
                                calendar.refetchEvents();
                            },
                            error: function(xhr, status, error) {
                                hideLoading();
                                toastr.error('Error deleting event:' + error);
                            }
                        });
                    }
                });
            });

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

            window.handleDeleteScheduleInterview = function(event_id) {
                if (confirm("Bạn có muốn xóa không?")) {
                    showLoading();
                    $.ajax({
                        url: "{{ route('company.deleteScheduleInterview') }}",
                        type: 'POST',
                        data: {
                            event_id: event_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            hideLoading();
                            if (response.success) {
                                toastr.success("", response.message);
                                calendar.refetchEvents();
                                $(".modal-footer").html(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>

                    <button type="button" class="btn btn-primary" onclick="scheduleInterviewUpdate('${info.event.id}')">Cập nhật</button>
                `);
                                $('#createEventModal').modal('hide');
                            } else {
                                toastr.error("", response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            hideLoading();
                            toastr.error('Lỗi khi xóa lịch phỏng vấn: ' + error);
                        }
                    });
                }
            }

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
