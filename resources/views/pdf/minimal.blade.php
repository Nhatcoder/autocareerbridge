<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Layout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            width: 100%;
            padding: 20px;
        }

        .cv-container {
            width: 100%;
            margin: auto;
            background: white;
            overflow: hidden;
        }

        .content {
            padding: 20px;
        }

        .avatar {
            width: 100px;
            height: 100px;
        }

        h3 {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="cv-container">
        <table style="width: 100%; padding: 20px; background-color: #d3d3d3;">
            <tr>
                <td>
                    <h1 style="font-weight: 500">Hà Danh</h1>
                    <p>GIÁM ĐỐC</p>
                </td>
                <td style="text-align: right;">
                    <img class="avatar" src="{{ asset('clients/images/content/blog_single_client3.jpg') }}"
                        alt="Profile Picture">
                </td>`
            </tr>
        </table>

        <table class="content">
            <tr>
                <td style="padding-right: 10px; vertical-align: top;">
                    <div class="section">
                        <h3>THÔNG TIN CÁ NHÂN</h3>
                        <br>
                        <p>📞 0987654321</p>
                        <p>📧 hadanh.jyb@gmail.com</p>
                        <p>🎂 17/11/1998</p>
                        <p>📍 Hoài Đức, Hà Nội</p>
                        <p>🌐 <a href="https://topcv.vn/mau-cv">topcv.vn/mau-cv</a></p>
                    </div>
                    <br>
                    <div class="section">
                        <h3>GIỚI THIỆU</h3>
                        <br>
                        <p><strong>GIÁM ĐỐC CÔNG NGHỆ</strong></p>
                        <ul>
                            <li>Biên soạn và cập nhật 100+ tài liệu đào tạo nội bộ.</li>
                            <li>Phân tích nhu cầu và lập kế hoạch đào tạo cho 500 nhân viên.</li>
                            <li>Xây dựng, giám sát và cải tiến quy trình đào tạo theo định hướng của công ty.
                            </li>
                            <li>Theo dõi, đánh giá học viên sau đào tạo sử dụng phương pháp SMART.</li>
                            <li>Trực tiếp giảng dạy 10 chương trình đào tạo theo kế hoạch.</li>
                        </ul>
                    </div>
                    <br>
                    <div class="section">
                        <h3>HỌC VẤN</h3>
                        <br>
                        <p><strong>Đại Học Bách Khoa</strong></p>
                        <p>Thợ Xây</p>
                        <p>01/2000 - NOW</p>
                    </div>
                    <br>
                    <div class="section">
                        <h3>KỸ NĂNG</h3>
                        <br>
                        <ul>
                            <li>Xách vữa</li>
                            <li>Đào vữa</li>
                            <li>Ném gạch</li>
                        </ul>
                    </div>
                </td>

                <td style="border-left: 0.5px solid rgb(202, 200, 200);"></td>

                <td style="padding-left: 10px; vertical-align: top;">
                    <div class="section">
                        <h3>KINH NGHIỆM LÀM VIỆC</h3>
                        <br>
                        <p><strong>GIÁM ĐỐC CÔNG NGHỆ</strong></p>
                        <p>Fc Thợ Xây | 01/2000 - 01/2025</p>
                        <ul>
                            <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các hoạt
                                động và chính
                                sách công ty.</li>
                            <li>Phân tích nhu cầu, lập kế hoạch, ngân sách 100 triệu mỗi quý, chuẩn bị và tiến
                                hành thực
                                hiện các khóa đào tạo.</li>
                            <li>Đề xuất các chủ đề đào tạo mới, chịu trách nhiệm phối hợp với các phòng ban liên
                                quan để
                                nâng cao hiệu quả đào tạo và phát triển các vấn đề kỹ năng phát triển nguồn nhân
                                lực cho
                                nhân viên.</li>
                            <li>Đào tạo kỹ năng cho đội ngũ 30 giảng viên phối hợp với các đối tác chiến lược,
                                ngân sách
                                được duyệt.</li>
                            <li>Thực hiện đào tạo hội nhập cho khoảng 50 CBNV mới mỗi tháng.</li>
                        </ul>
                    </div>
                    <br>
                    <div class="section">
                        <h3>DỰ ÁN CÁ NHÂN</h3>
                        <br>
                        <p><strong>Chuyên Viên Đào Tạo</strong></p>
                        <ul>
                            <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên, phổ biến các hoạt
                                động và chính
                                sách công ty.</li>
                            <li>Phân tích nhu cầu, lập kế hoạch, ngân sách 100 triệu mỗi quý, chuẩn bị và tiến
                                hành thực
                                hiện các khóa đào tạo.</li>
                            <li>Đề xuất các chủ đề đào tạo mới, chịu trách nhiệm phối hợp với các phòng ban liên
                                quan để
                                khảo sát nhu cầu đào tạo phát triển về chuyên môn và kỹ năng phát triển nghề
                                nghiệp cho nhân
                                viên.</li>
                            <li>Đã hợp tác cùng 100 đơn vị đào tạo và 30 giảng viên phù hợp với các tiêu chí,
                                ngân sách được
                                phê duyệt.</li>
                        </ul>
                        <p>Link dự án: <a href="https://topcv.vn/mau-cv" class="text-black">https://topcv.vn/mau-cv</a>
                        </p>
                    </div>
                    <br>
                    <div class="section">
                        <h3>Chứng chỉ</h3>
                        <br>
                        <p><strong>Thợ Chính</strong></p>
                        <p>Link chứng chỉ: <a href="https://topcv.vn/mau-cv"
                                class="text-black">https://topcv.vn/mau-cv</a>
                        </p>
                        <ul>
                            <li>Xây dựng chương trình đào tạo kỹ năng cho 30 thành viên CLB.</li>
                            <li>Mời 2 chuyên gia về chia sẻ kỹ năng viết CV và phỏng vấn.</li>
                        </ul>
                    </div>
                    <br>
                    <div class="section">
                        <h3>Giải thưởng</h3>
                        <br>
                        <p><strong>Thợ Xây Pro</strong></p>
                        <p>03/2020 | Fc Xây Dựng Việt Nam</p>
                        <p><strong>Chuyên Viên Đào Tạo Nội Bộ</strong></p>
                        <ul>
                            <li>Biên soạn và cập nhật 100+ tài liệu đào tạo theo lộ trình</li>
                            <li>Phân tích nhu cầu và lập kế hoạch đào tạo cho 500 nhân viên</li>
                        </ul>
                    </div>
                    <br>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
