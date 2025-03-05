@extends('management.layout.main')
@section('content')
    <style>
        .bootstrap-select .dropdown-toggle.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
            display: block !important;
            width: 100% !important;
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h2>Danh sách lịch phỏng vấn</h2>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    {{-- create --}}
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Tạo lịch phỏng vấn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        @csrf
                        <div class="mb-3">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Công việc</label>
                            <select name="job_id" id="jobSelect" class="form-control" required>
                                <option value="">Chọn công việc</option>
                                @foreach ($jobs as $job)
                                    <option value="{{ $job->id }}">{{ $job->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Người tham gia</label>
                            <div id="applicantsList"
                                style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; padding: 5px;">
                                <p class="text-muted">Chọn công việc trước để hiển thị người tham gia.</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Thời gian bắt đầu</label>
                            <input type="datetime-local" name="start_date" id="startDate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Thời gian kết thúc</label>
                            <input type="datetime-local" name="end_date" id="endDate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Địa điểm</label>
                            <input type="text" name="location" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="saveEvent">Lưu</button>
                </div>
            </div>
        </div>
    </div>


    {{-- view --}}
    <div class="modal fade" id="eventDetailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailModalLabel">Chi tiết lịch phỏng vấn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
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
                    <a href="#" id="googleMeetLink" target="_blank" class="btn btn-primary">Tham gia Google Meet</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-warning" id="editEvent">Sửa</button>
                </div>
            </div>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade" id="editEventModal" tabindex="-1">
        <div class="modal-dialog">
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
                            <label>Địa điểm</label>
                            <input type="text" name="location" id="editLocation" class="form-control">
                            <div class="text-danger" id="errorEditLocation"></div>
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
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                // events: {
                //     url: '{{ route('company.refreshEvents') }}'
                // },
                events: function(fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{ route('company.schedule-interviews.data') }}',
                        method: 'GET',
                        success: function(data) {
                            console.log('Data từ API:', data);
                            successCallback(data);
                        },
                        error: function(xhr, status, error) {
                            console.error('Lỗi gọi API:', error);
                            failureCallback(error);
                        }
                    });
                },
                selectable: true,
                select: function(info) {
                    $('#eventModal').modal('show');
                    document.getElementById('startDate').value = info.startStr.slice(0, 16);
                    document.getElementById('endDate').value = info.endStr.slice(0, 16);
                },
                eventClick: function(info) {
                    currentEvent = info.event;
                    let eventId = info.event.id;

                    $.ajax({
                        url: `/company/schedule-interviews/${eventId}/attendees`,
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            let attendeesHtml = '';
                            if (data.length === 0) {
                                attendeesHtml =
                                    '<p class="text-muted">Không có người tham gia.</p>';
                            } else {
                                data.forEach(function(user) {
                                    attendeesHtml +=
                                        `<p>${user.user_name} (${user.email})</p>`;
                                });
                            }

                            $('#eventDetailModalLabel').text('Chi tiết lịch phỏng vấn');
                            $('#eventDetailModal').find('.modal-body').html(`
                            <p><strong>Tiêu đề:</strong> ${info.event.title}</p>
                            <p><strong>Công ty:</strong> ${info.event.extendedProps.company}</p>
                            <p><strong>Tin tuyển dụng:</strong> ${info.event.extendedProps.job}</p>
                            <p><strong>Bắt đầu:</strong> ${info.event.start.toLocaleString()}</p>
                            <p><strong>Kết thúc:</strong> ${info.event.end ? info.event.end.toLocaleString() : 'N/A'}</p>
                            <p><strong>Link Google Meet:</strong> ${info.event.extendedProps.link || 'Không có'}</p>
                            <p><strong>Mô tả:</strong> ${info.event.extendedProps.description || 'Không có'}</p>
                            <p><strong>Người tham gia:</strong></p>
                            <div>${attendeesHtml}</div>
                    `);

                            $('#eventDetailModal').modal('show');
                        },
                        error: function() {
                            alert('Không tải được người tham gia');
                        }
                    });
                }


            });
            calendar.render();


            // Load danh sách ứng viên theo job_id
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
                                    ${user.user_name}
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


            let selectedUsers = []; // Lưu danh sách user đã chọn

            $(document).on('click', '#editEvent', function() {
                let eventId = currentEvent.id;

                $.ajax({
                    url: `/company/schedule-interviews/${eventId}/edit`,
                    method: 'GET',
                    success: function(data) {
                        console.log("edit", data);
                        $('#eventDetailModal').modal('hide');

                        $('#editEventId').val(data.id);
                        $('#editTitle').val(data.title);
                        $('#editStartDate').val(formatDateToInput(data.start_date));
                        $('#editEndDate').val(formatDateToInput(data.end_date));
                        $('#editDescription').val(data.description);
                        $('#editLocation').val(data.location);

                        // Lưu sẵn danh sách user đã tham gia
                        selectedUsers = data.attendees.map(user => user.id);

                        $.ajax({
                            url: '/company/getAllJobInterview',
                            method: 'GET',
                            success: function(jobs) {
                                let jobSelect = $('#editJobSelect');
                                jobSelect.html(
                                    '<option value="">-- Chọn công việc --</option>'
                                );

                                jobs.forEach(job => {
                                    let selected = (job.id == data.job_id) ?
                                        'selected' : '';
                                    jobSelect.append(
                                        `<option value="${job.id}" ${selected}>${job.name}</option>`
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
                                            default:
                                                return 'Chưa mời tham gia';
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
                                    } else {
                                        statusColor = 'text-secondary';
                                    }

                                    attendeesList.append(`
                            <div class="form-check d-flex align-items-center justify-content-between">
                                <div>
                                    <input class="form-check-input" type="checkbox" name="user_ids[]" value="${user.id}" ${isChecked}>
                                    <label class="form-check-label">${user.user_name}</label>
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


            // Xử lý khi thay đổi job trong edit modal
            $(document).on('change', '#editJobSelect', function() {
                let jobId = $(this).val();

                // Trước khi load mới -> lưu lại những người đang được check (nếu có)
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



            // Lưu lịch
            document.getElementById('saveEvent').addEventListener('click', function() {
                var form = document.getElementById('eventForm');
                var formData = new FormData(form);

                document.querySelectorAll('#applicantsList input[type="checkbox"]:checked').forEach(
                    function(input) {
                        formData.append('user_ids[]', input.value);
                    });

                fetch('{{ route('company.schedule-interviews.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert('Lỗi: ' + data.error);
                        } else {
                            calendar.addEvent(data);
                            $('#eventModal').modal('hide');
                        }
                    })
                    .catch(error => alert('Lỗi: ' + error));
            });

            // cập nhật lịch

            document.getElementById('updateEvent').addEventListener('click', function() {
                const form = document.getElementById('editEventForm');
                let formData = new FormData(form);
                formData.append('_method', 'PUT');
                let eventId = document.getElementById('editEventId').value;

                if (!eventId) {
                    alert('Không tìm thấy ID sự kiện để cập nhật.');
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
                        console.log("Response JSON:", data);

                        if (data.error) {
                            alert('Lỗi: ' + data.error);
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
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            });



        });
    </script>
@endsection
