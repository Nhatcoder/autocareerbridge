@extends('management.layout.main')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card quick_payment">
                        <div class="card-body p-0">
                            <div class="card-body">
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
        <div class="modal-dialog">
            <form id="createEventForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm lịch phỏng vấn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="eventTitle">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời gian bắt đầu</label>
                            <div class="d-flex gap-2">
                                <input type="date" class="form-control" id="eventStartDate">
                                <input type="time" class="form-control" id="eventStartTime">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời gian kết thúc</label>
                            <div class="d-flex gap-2">
                                <input type="date" class="form-control" id="eventEndDate">
                                <input type="time" class="form-control" id="eventEndTime">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa điểm</label>
                            <input type="text" class="form-control" id="eventLocation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" onclick="saveEvent()">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                editable: true,
                selectable: true,
                events: {
                    url: "{{ route('company.refreshEvents') }}"
                },
                select: function(info) {
                    document.getElementById('eventStartDate').value = info.startStr.split('T')[0];
                    document.getElementById('eventStartTime').value = info.startStr.split('T')[1]
                        ?.substring(0, 5) || '';

                    document.getElementById('eventEndDate').value = info.endStr.split('T')[0];
                    document.getElementById('eventEndTime').value = info.endStr.split('T')[1]
                        ?.substring(0, 5) || '';

                    var createEventModal = new bootstrap.Modal(document.getElementById(
                        'createEventModal'));
                    createEventModal.show();
                },
                dateClick: function(info) {
                    var date = info.dateStr;
                    document.getElementById('eventDate').value = date;
                    var createEventModal = new bootstrap.Modal(document.getElementById(
                        'createEventModal'));
                    createEventModal.show();
                },
            });
            calendar.render();
        });
    </script>
@endsection
