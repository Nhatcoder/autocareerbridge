<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Cá Nhân</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .avatar img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
            margin-right: 40px;
        }

        .contact-info {
            margin-top: 10px;
        }

        .contact-info span {
            display: inline-block;
            margin-right: 15px;
            font-size: 14px;
        }

        .content {
            padding: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: 500;
        }

        .skills {
            display: flex;
            flex-wrap: wrap;
        }

        .skill {
            background: #e9ecef;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 5px;
            font-size: 14px;
        }

        .work-experience {
            font-size: 14px;
        }

        .work-experience p {
            margin: 5px 0;
        }

        strong {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <!-- Header -->
        <table style="background-color: #343a40; width: 100%; color:#ffffff; padding: 20px 0">
            <tr>
                <td style="width: 24%">
                    <div class="avatar">
                        <img style="margin-left: 20px" src="{{ asset('clients/images/content/blog_single_client3.jpg') }}"
                            alt="Profile Picture">
                    </div>
                </td>

                <td style="width: 38%;">
                    <div>
                        <h2 style="font-weight: 500; font-size: 25px;">Ha Danh</h2>
                        <p>GIÁM ĐỐC</p>
                    </div>
                    <br>
                    <p><img src="{{ asset('clients/images/iconcv/phone.svg') }}" style="width: 16px;"> 0987654321</p>
                    <p><img src="{{ asset('clients/images/iconcv/email.svg') }}" style="width: 16px;">
                        ha.danh.jvb@gmail.com</p>
                    <p><img src="{{ asset('clients/images/iconcv/link.svg') }}" style="width: 16px;"> <a
                            href="https://topcv.vn/mau-cv"
                            style="color: #ffffff; text-decoration: none;">topcv.vn/mau-cv</a></p>
                </td>

                <td style="padding-right: 20px; width: 38%">
                    <br>
                    <br>
                    <p><img src="{{ asset('clients/images/iconcv/date.svg') }}" style="width: 16px;"> 17/11/1998</p>
                    <p><img src="{{ asset('clients/images/iconcv/address.svg') }}" style="width: 16px;"> Số 1 Phạm Như
                        Trinh,Vân Canh, Hoài Đức, Thành Phố Hà Nội</p>
                </td>
            </tr>
        </table>

        <!-- Content -->
        <div class="content">
            <!-- Giới Thiệu -->
            <div class="section">
                <div class="section-title">Giới thiệu</div>
                <p><strong>Chuyên Viên Đào Tạo Nội Bộ</strong></p>
                <ul>
                    <li>Biên soạn và cập nhật 100+ tài liệu đào tạo theo lộ trình</li>
                    <li>Phân tích nhu cầu và lập kế hoạch đào tạo cho 500 nhân viên</li>
                    <li>Xây dựng, giám sát và cải tiến quy trình đào tạo theo định hướng của công ty</li>
                    <li>Theo dõi, đánh giá học viên sau đào tạo sử dụng phương pháp SMART</li>
                    <li>Trực tiếp đứng lớp 10 chương trình đào tạo theo kế hoạch</li>
                </ul>
            </div>

            <hr>

            <!-- Học Vấn -->
            <div class="section">
                <div class="section-title">Học vấn</div>
                <p><strong>Đại Học Back Khoa</strong></p>
                <p>01/2000 - HIỆN TẠI | Thợ Xây</p>
                <p><i>Không có gì</i></p>
            </div>

            <hr>

            <!-- Kỹ Năng -->
            <div class="section">
                <div class="section-title">Kỹ năng</div>
                <div class="skills" style="text-align: center">
                    <div class="skill">Xách vữa</div>
                    <div class="skill">Đào vữa</div>
                    <div class="skill">Ném gạch</div>
                </div>
            </div>

            <hr>

            <!-- Kinh Nghiệm Làm Việc -->
            <div class="section">
                <div class="section-title">Kinh nghiệm làm việc</div>
                <div class="work-experience">
                    <p><strong>GIÁM ĐỐC CÔNG NGHỆ | Cty Thợ Xây</strong></p>
                    <p>01/2000 - 06/2006</p>
                    <p><strong>Chuyên Viên Đào Tạo</strong></p>
                    <ul>
                        <li>Biên soạn và cập nhật 100+ tài liệu đào tạo theo lộ trình</li>
                        <li>Phân tích nhu cầu và lập kế hoạch đào tạo cho 500 nhân viên</li>
                        <li>Xây dựng, giám sát và cải tiến quy trình đào tạo theo định hướng của công ty</li>
                        <li>Theo dõi, đánh giá học viên sau đào tạo sử dụng phương pháp SMART</li>
                        <li>Trực tiếp đứng lớp 10 chương trình đào tạo theo kế hoạch</li>
                    </ul>
                    <p><strong>Link dự án: </strong><a href="topcv.vn/mau-cv" class="text-black"
                            target="_blank">topcv.vn/mau-cv</a></p>
                </div>
            </div>

            <hr>

            <!-- Chứng chỉ -->
            <div class="section">
                <div class="section-title">Chứng chỉ</div>
                <p><strong>Thợ Chính</strong></p>
                <p>05/2020 | Fc Xây Dựng Việt Nam</p>
                <p><strong>Link chứng chỉ: </strong><a href="topcv.vn/mau-cv" class="text-black"
                        target="_blank">topcv.vn/mau-cv</a></p>
                <ul>
                    <li>Biên soạn và cập nhật 100+ tài liệu đào tạo theo lộ trình</li>
                    <li>Phân tích nhu cầu và lập kế hoạch đào tạo cho 500 nhân viên</li>
                </ul>
            </div>

            <hr>

            <!-- Giải thưởng -->
            <div class="section">
                <div class="section-title">Giải thưởng</div>
                <p><strong>Thợ Xây Pro</strong></p>
                <p>03/2020 | Fc Xây Dựng Việt Nam</p>
                <p><strong>Chuyên Viên Đào Tạo Nội Bộ</strong></p>
                <ul>
                    <li>Biên soạn và cập nhật 100+ tài liệu đào tạo theo lộ trình</li>
                    <li>Phân tích nhu cầu và lập kế hoạch đào tạo cho 500 nhân viên</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
