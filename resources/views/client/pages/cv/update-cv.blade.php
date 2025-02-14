@extends('client.layout.main')

@section('title', 'Cập nhật hồ sơ')

@section('content')

    <div class="jp_blog_cate_main_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 margin_top hidden-sm hidden-xs">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="jp_rightside_job_categories_wrapper jp_blog_right_box_search">
                                <div
                                    class="jp_rightside_job_categories_heading d-flex justify-content-between align-items-center">
                                    <h4>Thông tin cá nhân</h4>
                                    @php
                                        $slugCv = Auth::guard('admin')->user()->cv->slug;
                                    @endphp
                                    <a href="{{ route('editCv', $slugCv) }}" target="_blank"><i
                                            class="bi bi-pencil-square text-white me-3"></i></a>
                                </div>
                                <div class="jp_blog_right_search_wrapper">
                                    <h5 class="mb-3">{{ $cv->name }} - {{ $cv->position }}</h5>
                                    <p><i class="bi bi-envelope"></i> {{ $cv->email }}</p>
                                    <p><i class="bi bi-telephone"></i> {{ $cv->phone }}</p>
                                    <p><i class="bi bi-geo-alt"></i> Hoài Đức, Hà Nội </p>
                                    <p><i class="bi bi-gender-male"></i> {{ $cv->sex }}</p>
                                    <p><i class="bi bi-cake"></i> {{ $cv->date_birth }}</p>
                                    <p><i class="bi bi-link-45deg"></i> {{ $cv->url }}</p>
                                    <a class="btn btn-info w-100 mt-3" href="{{ route('listCv') }}">Xem và Tải CV</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="jp_blog_cate_left_main_wrapper">
                                <div class="jp_first_blog_post_main_wrapper">

                                    <div class="jp_first_blog_post_cont_wrapper rounded">
                                        <div class="d-flex justify-content-between align-items-baseline border-bottom mb-3">
                                            <h3 class="pt-0 pb-0 mb-3">Giới thiệu bản thân</h3>
                                            <a><i class="bi bi-pencil-square text-info"></i></a>

                                        </div>
                                        <p>Nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet
                                            nibh vulputate cursus a sit amet mris. Morbi accumsan ipsum velit. Nam nec
                                            tellus a odio tincidunt auctor a ornare odio. Sed non mauris
                                            vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora
                                            torquent..</p>
                                    </div>

                                    <div class="jp_first_blog_post_cont_wrapper rounded mt-4">
                                        <div class="d-flex justify-content-between align-items-baseline ">
                                            <h3 class="pt-0 pb-0 mb-3">Học vấn</h3>
                                            <a><i class="bi bi-plus-circle text-info"></i></a>
                                        </div>

                                        <div class="border-top pt-4">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Đại học Back Khoa</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Thợ xây</p>
                                            <p>01/2000 - HIỆN TẠI</p>
                                            <p>Không có gì</p>
                                        </div>

                                        <div style="margin-top: 100px" class="border-top pt-3">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Đại học Back Khoa</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Thợ xây</p>
                                            <p>01/2000 - HIỆN TẠI</p>
                                            <p>Không có gì</p>
                                        </div>
                                    </div>

                                    <div class="jp_first_blog_post_cont_wrapper rounded mt-4">
                                        <div class="d-flex justify-content-between align-items-baseline ">
                                            <h3 class="pt-0 pb-0 mb-3">Kinh nghiệm làm việc</h3>
                                            <a><i class="bi bi-plus-circle text-info"></i></a>
                                        </div>

                                        <div class="border-top pt-4">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Giám đốc công nghệ</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Fc Thợ Xây</p>
                                            <p>01/2000 - 01/2025</p>
                                            <p><b>Chuyên Viên Đào Tạo</b></p>
                                            <ul>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                            </ul>
                                        </div>

                                        <div style="margin-top: 300px" class="border-top pt-4">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Giám đốc công nghệ</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Fc Thợ Xây</p>
                                            <p>01/2000 - 01/2025</p>
                                            <p><b>Chuyên Viên Đào Tạo</b></p>
                                            <ul>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                                <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các
                                                    hoạt động và chính sách công ty. </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="jp_first_blog_post_cont_wrapper rounded mt-4">
                                        <div class="d-flex justify-content-between align-items-baseline border-bottom mb-3">
                                            <h3 class="pt-0 pb-0 mb-3">Kỹ năng</h3>
                                            <a><i class="bi bi-pencil-square text-info"></i></a>
                                        </div>
                                        <span class="badge text-bg-secondary p-2">Xách vữa</span>
                                        <span class="badge text-bg-secondary p-2">Đảo vữa</span>
                                        <span class="badge text-bg-secondary p-2">Ném gạch</span>
                                    </div>

                                    <div class="jp_first_blog_post_cont_wrapper rounded mt-4">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h3 class="pt-0 pb-0 mb-3">Chứng chỉ</h3>
                                            <a><i class="bi bi-plus-circle text-info"></i></a>
                                        </div>
                                        <div class="border-top pt-4">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Thợ Chính</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Fc Xây Dựng Việt Nam</p>
                                            <p>05/2020</p>
                                            <ul>
                                                <li>Xây dựng chương trình đào tạo kỹ năng cho 30 thành viên CLB.</li>
                                                <li>Mời 2 chuyên gia về chia sẻ kỹ năng viết CV và phỏng vấn.</li>
                                            </ul>
                                        </div>

                                        <div style="margin-top: 130px" class="border-top pt-4">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Thợ Chính</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Fc Xây Dựng Việt Nam</p>
                                            <p>05/2020</p>
                                            <ul>
                                                <li>Xây dựng chương trình đào tạo kỹ năng cho 30 thành viên CLB.</li>
                                                <li>Mời 2 chuyên gia về chia sẻ kỹ năng viết CV và phỏng vấn.</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="jp_first_blog_post_cont_wrapper rounded mt-4">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h3 class="pt-0 pb-0 mb-3">Giải thưởng</h3>
                                            <a><i class="bi bi-plus-circle text-info"></i></a>
                                        </div>
                                        <div class="border-top pt-4">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Thợ Chính</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Fc Xây Dựng Việt Nam</p>
                                            <p>05/2020</p>
                                            <ul>
                                                <li>Xây dựng chương trình đào tạo kỹ năng cho 30 thành viên CLB.</li>
                                                <li>Mời 2 chuyên gia về chia sẻ kỹ năng viết CV và phỏng vấn.</li>
                                            </ul>
                                        </div>

                                        <div style="margin-top: 130px" class="border-top pt-4">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h4 class="pt-0 pb-0 mb-3">Thợ Chính</h4>
                                                <div>
                                                    <a><i class="bi bi-pencil-square text-info me-2"></i></a>
                                                    <a><i class="bi bi-trash3 text-black"></i></a>
                                                </div>
                                            </div>
                                            <p>Fc Xây Dựng Việt Nam</p>
                                            <p>05/2020</p>
                                            <ul>
                                                <li>Xây dựng chương trình đào tạo kỹ năng cho 30 thành viên CLB.</li>
                                                <li>Mời 2 chuyên gia về chia sẻ kỹ năng viết CV và phỏng vấn.</li>
                                            </ul>
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

    {{-- <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông tin cá nhân</h1>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    @csrf
                    <input type="hidden" name="company_id">
                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <img src="https://cactusthemes.com/blog/wp-content/uploads/2018/01/tt_avatar_small.jpg"
                                alt="Avatar" width="150px" height="150px" class="rounded-circle">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="name" class="col-form-label required">Họ và Tên:</label>
                                    <input type="text" name="name" class="form-control p-3" id="name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="name" class="col-form-label required">Chức danh:</label>
                                    <input type="text" name="name" class="form-control p-3" id="name">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                        <button type="submit" id="collaborationRequestForm" onclick="submitForm()"
                            class="btn btn-primary">Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .jp_first_blog_post_cont_wrapper li {
            float: left;
            margin-left: 20px !important;
        }

        ul {
            list-style: disc;
        }

        ul li::marker {
            color: rgb(138, 136, 136);
            /* Đổi màu chấm đầu dòng */
            font-size: 1.2em;
            /* Tùy chỉnh kích thước nếu cần */
        }

        .jp_blog_right_search_wrapper {
            word-wrap: break-word;
            /* Tự động xuống dòng khi text vượt quá chiều rộng */
            overflow-wrap: break-word;
            /* Hỗ trợ thêm cho việc xuống dòng */
            white-space: normal;
            /* Đảm bảo text được xuống dòng */
            max-width: 300px;
            /* Giới hạn chiều rộng của khung chứa */
        }

        .jp_blog_right_search_wrapper h5 {
            font-size: 16px;
            /* Kích thước chữ tiêu đề */
            margin-bottom: 10px;
            /* Khoảng cách dưới tiêu đề */
        }

        .jp_blog_right_search_wrapper p {
            font-size: 14px;
            /* Kích thước chữ các đoạn văn */
            margin: 5px 0;
            /* Khoảng cách giữa các đoạn văn */
            word-wrap: break-word;
            /* Hỗ trợ xuống dòng cho đoạn text */
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@endsection
