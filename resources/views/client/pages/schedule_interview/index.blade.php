@extends('client.layout.main')
@section('title', 'Lịch phỏng vấn')

@section('css')

@endsection
@section('content')
    <div class="jp_img_wrapper">
        <div class="jp_slide_img_overlay"></div>
        <div class="jp_banner_heading_cont_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-5">
                        <div class="jp_tittle_heading_wrapper">
                            <div class="jp_tittle_heading">
                                <h2>Lịch phỏng vấn</h2>
                            </div>
                            <div class="jp_tittle_breadcrumb_main_wrapper">
                                <div class="jp_tittle_breadcrumb_wrapper">
                                    <ul>
                                        <li><a href="{{ route('home') }}">Trang chủ</a> <i class="fa fa-angle-right"></i>
                                        </li>
                                        <li><a href="{{ route('listScheduleInterView') }}">Lịch phỏng vấn</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="card-body">
                <div id="calendar" class="mt-4"></div>
            </div>
        </div>
    </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal " id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="schedule_interview_id" id="schedule_interview_id" value="">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Cuộc phỏng vấn <b style="color:#23c0e9" id="titleModal"></b>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 d-flex flex-wrap">
                        <label class="fw-bold">Tiêu đề:</label>
                        <p class="ps-2" id="eventTitle"></p>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <label class="fw-bold">Công việc:</label>
                        <p class="ps-2 font-bold"><a class="text-primary" href="#" id="eventNameJob"
                                target="_blank"></a></p>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <label class="fw-bold">Thời gian:</label>
                        <p class="ps-2" id="eventTime"></p>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <label class="fw-bold">Địa điểm:</label>
                        <p class="ps-2" id="eventLocation"></p>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <label class="fw-bold">Mô tả:</label>
                        <p class="ps-2" id="eventDescription"></p>
                    </div>
                    <div class="mb-3 d-flex flex-wrap" id="eventLinkContainer">
                        <label class="fw-bold">Link phỏng vấn:</label>
                        <p class="ps-2"><a class="text-primary" href="#" id="eventLink" target="_blank"></a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="handleChangeStatus({{ STATUS_UN_JOIN }})">Từ
                        chối</button>
                    <button type="button" class="btn btn-primary" onclick="handleChangeStatus({{ STATUS_JOIN }})">Tham
                        gia</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'vi',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Hôm nay',
                    month: 'Tháng',
                    week: 'Tuần',
                    day: 'Ngày',
                    list: 'Danh sách'
                },
                dayMaxEvents: 3,
                eventLimit: true,
                eventLimitText: "Xem thêm",
                events: {
                    url: "{{ route('refreshScheduleInterView') }}",
                },

                allDayText: 'Cả ngày',
                noEventsText: 'Không có cuộc phỏng vấn nào',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                firstDay: 1,
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventClick: true,
                eventClick: function(info) {
                    $('#eventLocation').parent().removeClass('d-none');
                    $('#eventDescription').parent().removeClass('d-none');
                    $('#eventLinkContainer').removeClass('d-none');

                    $('#eventTitle').text('');
                    $('#titleModal').text('');
                    $('#eventNameJob').attr('href', '').text('');
                    $('#eventTime').text('');
                    $('#eventLocation').text('');
                    $('#eventDescription').text('');
                    $('#eventLink').attr('href', '').text('');
                    $("#schedule_interview_id").val('');

                    $("#titleModal").text(info.event.extendedProps?.company?.name);
                    $("#schedule_interview_id").val(info.event.extendedProps?.interviews[0].id);
                    $('#eventTitle').text(info.event.title);

                    $(".modal-footer").html(`
        <button type="button" class="btn btn-danger" onclick="handleChangeStatus({{ STATUS_UN_JOIN }})">Từ chối</button>
        <button type="button" class="btn btn-primary" onclick="handleChangeStatus({{ STATUS_JOIN }})">Tham gia</button>
    `);

                    if ([{{ STATUS_JOIN }}, {{ STATUS_UN_JOIN }}].includes(info.event.extendedProps
                            ?.interviews[0].status)) {
                        const textStatus = info.event.extendedProps.interviews[0].status ==
                            {{ STATUS_JOIN }} ?
                            "Đã tham gia" : "Đã từ chối";
                        $(".modal-footer").html(
                            `<button type="button" class="btn btn-secondary" disabled>${textStatus}</button>`
                        );
                    }

                    if (info.event.extendedProps?.job) {
                        $('#eventNameJob')
                            .attr('href', `{{ route('detailJob', ':slug') }}`.replace(':slug', info
                                .event.extendedProps.job.slug))
                            .text(info.event.extendedProps.job.name)
                    } else {
                        $('#eventNameJob').parent().hide();
                    }
                    $('#eventTime').text(moment(info.event.start).format('DD/MM/YYYY HH:mm') +
                        ' - ' + moment(info.event.end).format('DD/MM/YYYY HH:mm'));

                    if (info.event.extendedProps.location) {
                        $('#eventLocation').text(info.event.extendedProps.location);
                    } else {
                        $('#eventLocation').parent().addClass('d-none');
                    }

                    if (info.event.extendedProps.description) {
                        $('#eventDescription').text(info.event.extendedProps.description);
                    } else {
                        $('#eventDescription').parent().addClass('d-none');
                    }

                    if (info.event.extendedProps.link) {
                        $('#eventLink').attr('href', info.event.extendedProps.link)
                            .text(info.event.extendedProps.link);
                    } else {
                        $('#eventLinkContainer').addClass('d-none');
                    }

                    $('#eventDetailsModal').modal('show');
                },
            });

            calendar.render();
            window.handleChangeStatus = function(status) {
                $.ajax({
                    url: "{{ route('changeStatusInterView') }}",
                    method: "POST",
                    data: {
                        schedule_interview_id: $("#schedule_interview_id").val(),
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('.btn-close').click();
                            calendar.refetchEvents();
                        } else {
                            toastr.error(response.message);
                            $('.btn-close').click();
                            calendar.refetchEvents();
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Đã có lỗi xảy ra');
                    }
                });
            };
        });
    </script>
@endsection
