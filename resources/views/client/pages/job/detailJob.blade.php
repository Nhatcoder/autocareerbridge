@extends('client.layout.main')
@section('title', $job->name ?? 'Chi tiết tuyển dụng')

@section('content')
    <div class="jp_img_wrapper">
        <div class="jp_slide_img_overlay"></div>
        <div class="jp_banner_heading_cont_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-5">
                        <div class="jp_tittle_heading_wrapper">
                            <div class="jp_tittle_heading">
                                <h2>{{ $job->name ?? 'Underfined' }}</h2>
                            </div>
                            <div class="jp_tittle_breadcrumb_main_wrapper">
                                <div class="jp_tittle_breadcrumb_wrapper">
                                    <ul>
                                        <li><a href="{{ route('home') }}">Trang chủ</a> <i class="fa fa-angle-right"></i>
                                        </li>
                                        <li><a href="{{ route('home') }}">Công việc mới</a> <i
                                                class="fa fa-angle-right"></i></li>
                                        <li>{{ $job->name ?? 'Underfined' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="jp_listing_single_main_wrapper">

        <div class="max-w-7xl mx-auto p-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-2">
                    {{ $job->name ?? 'Underfined' }}
                </h1>
                {{-- <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-dollar-sign text-[#23c0e9]"></i>
                        <span class="ml-2">30 - 39 triệu</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-[#23c0e9]"></i>
                        <span class="ml-2">Hà Nội</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-briefcase text-[#23c0e9]"></i>
                        <span class="ml-2">2 năm</span>
                    </div>
                </div> --}}
                <div class="flex items-center space-x-4 mb-4">
                    <span>Hạn nộp hồ sơ:
                        {{ $job->end_date ? \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') : 'Undefined' }}</span>
                </div>
                <div class="flex items-center space-x-4 mb-4">
                    @php
                        $university =
                            auth()->guard('admin')->user()->university ??
                            (auth()->guard('admin')->user()->academicAffair->university ?? null);
                        $jobUniversityStatus = null;
                        if ($university) {
                            $jobUniversityStatus = $university->universityJobs()->where('job_id', $job->id)->first();
                        }
                    @endphp

                    @if ($university)
                        @if (!$jobUniversityStatus)
                            <button id="joinButton"
                                data-url="{{ route('university.job.apply', ['job_id' => $job->id, 'university_id' => $university->id]) }}"
                                class="bg-[#23c0e9] text-white px-4 py-2 rounded-lg">
                                <i class="fa fa-plus-circle"></i> &nbsp;Ứng tuyển ngay
                            </button>
                        @elseif ($jobUniversityStatus)
                            <button class="bg-gray-400 text-white px-4 py-2 rounded-lg" disabled>
                                <i class="fa fa-check-circle"></i> &nbsp;Đã ứng tuyển
                            </button>
                        @endif
                    @elseif(auth()->guard('web')->check() && auth()->guard('web')->user()->role == ROLE_USER)
                        @if (in_array(auth()->guard('web')->user()->id, $job->userJob()->pluck('user_id')->toArray()))
                            <button class="bg-gray-400 text-white px-4 py-2 rounded-lg" disabled>
                                <i class="fa fa-check-circle"></i> &nbsp;Đã ứng tuyển
                            </button>
                        @else
                            <button class="bg-[#23c0e9] text-white px-4 py-2 rounded-lg" data-toggle="modal"
                                data-target="#exampleModal">
                                <i class="fa fa-plus-circle"></i> &nbsp;Ứng tuyển ngay
                            </button>
                        @endif
                    @endif
                    @php
                        $wishlist = auth()->check()
                            ? $job->wishlistByUsers->where('user_id', auth()->id())->first()
                            : null;
                    @endphp

                    <ul>
                        @if (auth()->check() && auth()->user()->role !== ROLE_COMPANY && auth()->user()->role !== ROLE_HIRING)
                            <li>
                                <a data-job-id="{{ $job->id }}" class="toggle-favorite"
                                    style="width:30px; height:30px; border-radius:10px; line-height: 30px; padding: 4px; {{ $wishlist && $wishlist->is_save == SAVE ? 'border: 1px solid red;' : 'border: 1px solid #e9e9e9;' }}"
                                    href="javascript:void(0)">
                                    <i class="fa-solid fa-heart favorite-icon"
                                        style="{{ $wishlist && $wishlist->is_save == SAVE ? 'color:red;' : 'color: #ccc;' }}"></i>
                                </a>
                            </li>
                        @endif
                    </ul>

                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Chi tiết tin tuyển dụng</h2>
                    <div class="card-body">
                        {!! $job->detail ?? '' !!}
                    </div>
                    <p class="mb-4">Hạn nộp hồ sơ:
                        {{ $job->end_date ? \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') : 'Undefined' }}</p>

                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-gray-700">Báo cáo tin tuyển dụng: Nếu bạn thấy tin tuyển dụng này không đúng hoặc có
                            dấu hiệu lừa đảo, hãy phản ánh với chúng tôi.</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center space-x-4 mb-4">
                            <img alt="Company logo" class="w-12 h-12 rounded-full" height="50"
                                src="{{ $job->company->avatar_path ? asset($job->company->avatar_path) : 'https://storage.googleapis.com/a1aa/image/s5BVY4OnMA5mHRcUdNNzyQE9LpotgfNIsuDivAe1LedJgv8nA.jpg' }}"
                                width="50" />
                            <div>
                                <h3 class="text-lg font-bold">{{ $job->company->name ?? '' }}</h3>
                                <p class="text-gray-700">{{ $job->company->size }} nhân viên</p>
                                <p class="text-gray-700">
                                    {{ implode(' / ', $company->fields->pluck('name')->toArray()) }}
                                </p>
                                <p class="text-gray-700">{{ $company->address }}</p>
                            </div>
                        </div>

                        <button class="bg-[#23c0e9] text-white px-4 py-2 rounded-lg w-full"
                            onclick="window.location.href='{{ route('detailCompany', $company->slug) }}'">Xem trang công
                            ty</button>
                    </div>
                    {{-- <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold mb-4">Thông tin chung</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-user text-[#23c0e9]"></i>
                                <span class="ml-2">Cấp bậc: Nhân viên</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-briefcase text-[#23c0e9]"></i>
                                <span class="ml-2">Kinh nghiệm: 2 năm</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-users text-[#23c0e9]"></i>
                                <span class="ml-2">Số lượng tuyển: 1 người</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-clock text-[#23c0e9]"></i>
                                <span class="ml-2">Hình thức làm việc: Toàn thời gian</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-graduation-cap text-[#23c0e9]"></i>
                                <span class="ml-2">Giới tính: Không yêu cầu</span>
                            </li>
                        </ul>
                    </div> --}}

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold mb-4">Kỹ năng cần có</h3>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach ($job->skills as $skill)
                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold mb-4">Khu vực</h3>
                        <ul class="space-y-2">
                            <li class="text-blue-500">{{ $company->district }} / {{ $company->province }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

  @if (auth('web')->check())
      <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  <form id="apply_job" action="{{ route('applyJob') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Ứng tuyển <b
                                  class="text-[#23c0e9]">{{ $job->name ?? 'Chi tiết tuyển dụng' }}</b>
                          </h1>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <input type="hidden" name="job_id" value="{{ $job->id }}">
                      <div class="modal-body overflow-y-auto h-[calc(100vh-290px)]">
                          <div class="mt-4">
                              <input type="file" class="hidden" id="upload_cv" value="" name="file_cv">
                              <label for="upload_cv"
                                  class="round w-full text-white flex justify-center items-center cursor-pointer fs-14 bg-[#23c0e9] px-4 py-2 rounded-lg"><i
                                      class="fa-solid fa-arrow-up-from-bracket"></i> Tải lên hồ sơ sẵn
                              </label>
                              <span class="text-opacity-75 fs-10 flex justify-center">Hỗ trợ định dạng pdf có
                                  kích thước dưới 5MB </span>
                          </div>

                          <div class="mt-4 list_cv">
                              @if ($cvApplyLate && $cvApplyLate->cv)
                                  <label for="cv_old"
                                      class="mt-2 flex gap-x-2 items-center border p-2 rounded-lg bg-gray-50 item_cv active bg-white">
                                      <input type="radio" name="cv_id" checked id="cv_old"
                                          value="{{ $cvApplyLate->cv->id ?? '' }}" class="m-0 fs-16">
                                      <div class="flex m-0 border-b-2 border-transparent">
                                          <span class="mr-2 ">CV ứng tuyển gần nhất:
                                              {{ $cvApplyLate->cv->title }}</span>
                                          <a target="_blank" href="{{ route('cv.view', ['id' => $cvApplyLate->cv->id]) }}"
                                              class="text-[#23c0e9] text-decoration-none hover:text-[#1a8fb0]">Xem</a>
                                      </div>
                                  </label>
                              @endif
                              <div class="mt-2 border w-100 p-2 rounded-lg bg-gray-50 item_cv btn_more__mycv bg-white">
                                  <label class="flex gap-x-2 items-center">
                                      <input type="radio" name="cv_id" id="cv_other" value=""
                                          class="m-0 fs-16">
                                      <div class="flex m-0 border-b-2 border-transparent">
                                          <span class="mr-2 text-[#333333] font-weight-[500]">Chọn CV khác trong thư viện của
                                              tôi</span>
                                      </div>
                                  </label>
                                  @if (count($cvCreate) > 0 || count($cvUploads) > 0)
                                      <div class="list_mycv hidden mt-2">
                                          <div class="cv-selected hidden d-flex justify-between">
                                              <div class="d-flex items-center">
                                                  <span
                                                      class="cv-selected_name mx-2 line-clamp-1 w-70 file_name leading-8 text-[#263a4d]">Abc
                                                      text selected</span>
                                                  <a target="_blank" href=""
                                                      class="cv-selected_view text-[#23c0e9] text-decoration-none hover:text-[#1a8fb0] mx-1 btn_view_cv">
                                                      Xem
                                                  </a>
                                              </div>
                                              <div class="cv-selected_action">
                                                  <button type="button"
                                                      class="btn btn-primary border-0 text-center bg-gray-400 text-white hover:bg-[#23c0e9] btn_change_cv_selected">
                                                      <i class="fa-solid fa-pen"></i> Thay đổi
                                                  </button>
                                              </div>
                                          </div>

                                          <div class="block_cv">
                                              @if (count($cvCreate) > 0)
                                                  <h4 class="py-2">CV online</h4>
                                                  @foreach ($cvCreate as $cvCr)
                                                      <div
                                                          class="border p-2 mb-1 mb-1 rounded-lg bg-gray-50 d-flex justify-between bg-white">
                                                          <div class="block_cv__item flex items-center flex-start">
                                                              <span class="mx-2 line-clamp-1 leading-8 file_name"
                                                                  style="width: 24rem;">{{ $cvCr->title }}</span>
                                                              @if ($cvCr->type == TYPE_CV_CREATE)
                                                                  <a target="_blank"
                                                                      href="{{ route('cv.view', ['id' => $cvCr->id]) }}"
                                                                      class="text-[#23c0e9] text-decoration-none hover:text-[#1a8fb0] btn_view_cv">
                                                                      Xem
                                                                  </a>
                                                              @elseif($cvCr->type == TYPE_CV_UPLOAD)
                                                                  <a target="_blank"
                                                                      href="{{ route('cv.upload.view', ['id' => $cvCr->id]) }}"
                                                                      class="text-[#23c0e9] text-decoration-none hover:text-[#1a8fb0] btn_view_cv">
                                                                      Xem
                                                                  </a>
                                                              @endif
                                                          </div>

                                                          <div class="float-right">
                                                              <span class="btn-sm btn-primary cursor-pointer btn-select-cv"
                                                                  data-id="{{ $cvCr->id }}">Chọn CV
                                                              </span>
                                                          </div>
                                                      </div>
                                                  @endforeach
                                              @endif
                                              @if (count($cvUploads) > 0)
                                                  <h4 class="py-2">CV đã tải lên</h4>
                                                  @foreach ($cvUploads as $cvUp)
                                                      <div
                                                          class="border p-2 mb-1 rounded-lg bg-gray-50 d-flex justify-between bg-white">
                                                          <div class="block_cv__item flex items-center flex-start">
                                                              <span class="mx-2 line-clamp-1 leading-8 file_name"
                                                                  style="width: 24rem;">{{ $cvUp->title }}</span>
                                                              @if ($cvUp->type == TYPE_CV_CREATE)
                                                                  <a target="_blank"
                                                                      href="{{ route('cv.view', ['id' => $cvUp->id]) }}"
                                                                      class="text-[#23c0e9] text-decoration-none hover:text-[#1a8fb0] btn_view_cv">
                                                                      Xem
                                                                  </a>
                                                              @elseif($cvUp->type == TYPE_CV_UPLOAD)
                                                                  <a target="_blank"
                                                                      href="{{ route('cv.upload.view', ['id' => $cvUp->id]) }}"
                                                                      class="text-[#23c0e9] text-decoration-none hover:text-[#1a8fb0] btn_view_cv">
                                                                      Xem
                                                                  </a>
                                                              @endif
                                                          </div>

                                                          <div class="float-right">
                                                              <span class="btn-sm btn-primary cursor-pointer btn-select-cv"
                                                                  data-id="{{ $cvUp->id }}">Chọn
                                                                  CV</span>
                                                          </div>
                                                      </div>
                                                  @endforeach
                                              @endif
                                          </div>
                                      </div>
                                  @endif

                              </div>
                          </div>

                          <div class="mt-4">
                              <label class="block fs-13 opacity-75 font-medium">Họ và tên <span
                                      class="text-[#ff0000]">*</span></label>
                              <input type="text" class="w-full border p-2 rounded-lg" name="name"
                                  value="{{ Auth::guard('web')->user()->name ?? '' }}"
                                  {{ auth('web')->user()->name ? 'disabled' : '' }} placeholder="Nhập họ và tên">
                              <span class="text-danger text-sm err_name"></span>

                          </div>

                          <div class="mt-4 grid grid-cols-2 gap-4">
                              <div>
                                  <label class="block fs-13 opacity-75 font-medium">Email <span
                                          class="text-[#ff0000]">*</span></label>
                                  <input type="text" class="w-full border p-2 rounded-lg"
                                      value="{{ Auth::guard('web')->user()->email ?? '' }}"
                                      {{ auth('web')->user()->email ? 'disabled' : '' }} name="email"
                                      placeholder="Nhập email">
                                  <span class="text-danger text-sm err_email"></span>

                              </div>
                              <div>
                                  <label class="block fs-13 opacity-75 font-medium">Số điện thoại <span
                                          class="text-[#ff0000]">*</span></label>
                                  <input type="text" class="w-full border p-2 rounded-lg"
                                      {{ auth('web')->user()->phone ? 'disabled' : '' }}
                                      value="{{ Auth::guard('web')->user()->phone ?? '' }}" name="phone"
                                      placeholder="Nhập số điện thoại">
                                  <span class="text-danger text-sm err_phone"></span>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                          <button type="submit" class="btn text-white bg-[#23c0e9] hover:bg-[#1a8fb0]"> Nộp
                              hồ sơ ứng tuyển
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  @endif
@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        .active {
            border-color: #23c0e9 !important;
        }

        .card-body {
            font-family: "Inter", serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            border-radius: 8px;
        }

        .card-body h1,
        .card-body h2,
        .card-body h3,
        .card-body h4 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .card-body h1 {
            font-size: 2rem;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        .card-body h2 {
            font-size: 1.75rem;
            border-bottom: 1px solid #2980b9;
            padding-bottom: 3px;
        }

        .card-body h3 {
            font-size: 1.5rem;
        }

        .card-body p {
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .card-body ul,
        .card-body ol {
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .card-body ul li,
        .card-body ol li {
            margin-bottom: 10px;
        }

        .card-body ul li::marker {
            color: #3498db;
        }

        .card-body ol li {
            color: #2980b9;
        }

        .card-body table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-body table th,
        .card-body table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .card-body table th {
            background-color: #3498db;
            color: #fff;
        }

        .card-body table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .card-body img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 10px 0;
            border-radius: 5px;
        }

        .card-body blockquote {
            font-style: italic;
            color: #555;
            border-left: 4px solid #3498db;
            margin: 15px 0;
            padding-left: 10px;
        }

        .card-body pre {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', Courier, monospace;
            margin-bottom: 20px;
        }

        .container {
            max-width: 1200px !important;
            margin: 0 auto !important;
        }

        .btn-close {
            position: absolute;
            top: 2%;
            right: 5%;
        }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let id = null;
            $(document).on('click', '.item_cv', function() {
                $('.item_cv').removeClass('active');
                $(this).addClass('active');
            });

            $(document).on('click', '.btn-select-cv', function() {
                let el = $(this).parent().prev('.block_cv__item');
                $(".list_mycv").find('.block_cv').addClass("hidden");
                $(".list_mycv").find('.cv-selected').removeClass("hidden");

                let elName = $(".list_mycv").find('.cv-selected_name');
                let elView = $(".list_mycv").find('.cv-selected_view');
                let cvSelectedName = el.find('.file_name').text();
                let cvSelectedView = el.find('.btn_view_cv').attr('href');

                id = $(this).attr('data-id');
                $("#cv_other").val(id);

                elName.text(cvSelectedName);
                elView.attr('href', cvSelectedView);
            });

            $(document).on('click', '.btn_change_cv_selected', function() {
                $(".list_mycv").find('.cv-selected').addClass("hidden");
                $(".list_mycv").find('.block_cv').removeClass("hidden");
            });

            $(".btn_more__mycv").on('click', function() {
                $(this).find("input[type=radio]").prop('checked', true);
                let element = $(this).parent().find('.list_mycv');
                if (element.hasClass('hidden')) {
                    element.removeClass('hidden');
                }
            })

            let i = 1000;
            $('#upload_cv').on('change', function(e) {
                let file = e.target.files[0];
                let fileType = file.type;
                let fileSize = file.size;
                if (fileType != 'application/pdf') {
                    toastr.error('Bạn chỉ được upload file theo định dạng PDF.', "", {
                        closeButton: true,
                        timeOut: 3000,
                        progressBar: true,
                    })
                    return;
                }
                if (fileSize > 5 * 1024 * 1024) {
                    toastr.error('Dung lượng file phải nhỏ hơn 5MB', "", {
                        closeButton: true,
                        timeOut: 3000,
                        progressBar: true,
                    })
                    return;
                }
                $(this).parent().hide();
                let fileName = file.name;

                if (i === 1000) {
                    $(".list_cv").prepend(`
                            <label for="cv${i}"
                                class="mt-2 flex justify-between gap-x-2 items-center border p-2 rounded-lg bg-gray-50 item_cv active">
                                <div class="flex m-0 border-b-2 border-transparent w-full">
                                    <div class="flex items-center w-full">
                                        <input type="radio" checked name="cv_id" id="cv${i}" value="" class="m-0 fs-16 ">
                                        <span class="mx-2 w-70 line-clamp-2 file_name__new">${fileName}</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary border-0 text-center bg-gray-400 text-white hover:bg-[#23c0e9] btn_change_cv">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i> Thay thế hồ sơ khác
                                </button>
                            </label>
                        `);
                    i++;
                } else {
                    $(".list_cv .item_cv .file_name__new").text(fileName);
                }
            });

            $(document).on('click', '.btn_change_cv', function(e) {
                $(`#cv${i}`).prop('checked', true);

                e.preventDefault();
                $('#upload_cv').click();
            });
        })

        // Applly job
        $(document).on('submit', '#apply_job', function(e) {
            e.preventDefault();
            let isValid = true;
            var applyUrl = $(this).attr('action');
            let formData = new FormData(this);

            if ($('input[name="cv_id"]:checked').length === 0) {
                toastr.error('Vui lòng chọn CV trước khi nộp hồ sơ ứng tuyển!', "", {
                    closeButton: true,
                    timeOut: 3000,
                    progressBar: true,
                });
                return;
            }

            $(".err_name, .err_email, .err_phone").text("");

            let name = $('input[name="name"]').val().trim();
            if (name === '') {
                $(".err_name").text("Vui lòng nhập họ và tên.");
                isValid = false;
            }

            let email = $('input[name="email"]').val().trim();
            if (email === '') {
                $(".err_email").text("Vui lòng nhập email.");
                isValid = false;
            } else if (!validateEmail(email)) {
                $(".err_email").text("Vui lòng nhập email đúng định dạng.");
                isValid = false;
            }

            let phone = $('input[name="phone"]').val().trim();
            if (phone === '') {
                $(".err_phone").text("Vui lòng nhập số điện thoại.");
                isValid = false;
            } else if (!validatePhone(phone)) {
                $(".err_phone").text("Vui lòng nhập số điện thoại đúng định dạng.");
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return
            }

            $.ajax({
                url: applyUrl,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success("", response.message)
                        setTimeout(function() {
                            location.reload();
                        }, 1000)
                    } else {
                        toastr.error("", response.message)
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("", "" + error.message);
                }
            });
        });

        function validateEmail(email) {
            let re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            let re = /^0[0-9]{9}$/;
            return re.test(phone);
        }

        $(document).on('click', '#joinButton', function(e) {
            e.preventDefault();
            let btnThis = $(this)
            var joinUrl = $(this).data('url');
            $.ajax({
                url: joinUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: 'join'
                },
                success: function(response) {
                    btnThis.html('<i class="fa fa-check-circle"></i> &nbsp;Đã gửi yêu cầu')
                        .addClass('bg-gray-400')
                        .removeClass('bg-blue-500')
                        .prop('disabled', true);
                    toastr.success("", "Yêu cầu ứng tuyển đã được gửi!")
                },
                error: function(xhr, status, error) {
                    toastr.error("", "" + error.message);
                }
            });
        });
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection
