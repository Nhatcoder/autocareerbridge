<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Layout 4444444</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef1f5;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .sidebar {
            background-color: #2b3f6c;
            color: #fff;
            padding: 30px 20px;
            box-sizing: border-box;
        }

        .sidebar h1 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .sidebar p {
            margin: 10px 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .sidebar .section-title {
            margin-top: 30px;
            font-size: 18px;
            font-weight: 500;
            text-transform: uppercase;
            border-bottom: 2px solid #ccd4e3;
            padding-bottom: 5px;
        }

        .sidebar .skills {
            margin-top: 15px;
        }

        .sidebar .skills div {
            margin-bottom: 10px;
        }

        .sidebar .skills span {
            background-color: #4b6584;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
        }

        .sidebar ul {
            padding-left: 25px;
        }

        .sidebar li {
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 100;
        }

        .main {
            padding: 30px;
            box-sizing: border-box;
        }

        .main h2 {
            font-size: 22px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .main h3 {
            font-size: 18px;
            margin-top: 20px;
        }

        .main ul {
            padding-left: 20px;
            list-style-type: disc;
        }

        .main ul li {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .project {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9fafc;
            border-left: 4px solid #4b6584;
            border-radius: 5px;
        }

        .project h4 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .project p {
            margin: 5px 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .avatar {
            text-align: center;
            margin-bottom: 30px;
        }

        .avatar img {
            width: 150px;
            height: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar" style="float: left; width: 30%">
            <div class="avatar">
                <img src="{{ asset('clients/images/content/blog_single_client3.jpg') }}"
                    alt="Profile Picture" width="100" height="100">
            </div>
            <h1>Khánh Nguyên</h1>
            <p style="font-size: 17px;">PHP Developer</p>

            <div class="section-title">Thông tin cá nhân</div>
            <p><strong><img src="{{ asset('clients/images/iconcv/phone.svg') }}" style="width: 16px;"> </strong> 0932476977</p>
            <p><strong><img src="{{ asset('clients/images/iconcv/email.svg') }}" style="width: 16px;"> </strong> nguyenthega2k2@gmail.com</p>
            <p><strong><img src="{{ asset('clients/images/iconcv/date.svg') }}" style="width: 16px;"> </strong> 20/4/2002</p>
            <p><strong><img src="{{ asset('clients/images/iconcv/address.svg') }}" style="width: 16px;"> </strong> Hoài Đức, Hà Nội</p>
            <p><strong><img src="{{ asset('clients/images/iconcv/link.svg') }}" style="width: 16px;"> </strong> jvb.com</p>

            <div class="section-title">HỌC VẤN</div>
            <p><strong>Đại Học Bách Khoa</strong></p>
            <p>01/2000 - Hiện tại</p>
            <p>Thợ Xây</p>

            <div class="section-title">KỸ NĂNG</div>
            <div class="skills">
                <div><span>Xách vữa</span></div>
                <div><span>Đào vữa</span></div>
                <div><span>Ném gạch</span></div>
            </div>

            <div class="section-title">CHỨNG CHỈ</div>
            <p><strong>Thợ Chính - 01/2000</strong></p>
            <p>Fc Xây Dựng Việt Nam</p>
            <p>Link: <a style="color: white;" href="topcv.vn/mau-cv" target="_blank">topcv.vn/mau-cv</a></p>
            <ul>
                <li>Đề xuất các chủ đề đào tạo mới.</li>
                <li>Thực hiện đào tạo hội nhập cho 50 CBNV mới mỗi tháng.</li>
            </ul>

            <div class="section-title">Giải thưởng</div>
            <p><strong>Thợ Chính - 01/2000</strong></p>
            <p>Fc Xây Dựng Việt Nam</p>
            <p>Link: <a style="color: white;" href="topcv.vn/mau-cv" target="_blank">topcv.vn/mau-cv</a></p>
            <ul>
                <li>Đề xuất các chủ đề đào tạo mới.</li>
                <li>Thực hiện đào tạo hội nhập cho 50 CBNV mới mỗi tháng.</li>
            </ul>
        </div>

        <div class="main" style="float: right; width: 55%">
            <div>
                <h2>Giới thiệu</h2>
                <h3>Chuyên Viên Đào Tạo</h3>
                <ul>
                    <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên.</li>
                    <li>Phân tích nhu cầu, lập kế hoạch, ngân sách 100 triệu mỗi quý.</li>
                    <li>Đề xuất các chủ đề đào tạo mới.</li>
                    <li>Thực hiện đào tạo hội nhập cho 50 CBNV mới mỗi tháng.</li>
                </ul>
            </div>

            <div>
                <h2>Kinh nghiệm làm việc</h2>
                <h3>Giám đốc công nghệ | Fc Thợ Xây</h3>
                <p>01/2000 - 01/2025</p>
                <ul>
                    <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên.</li>
                    <li>Phân tích nhu cầu, lập kế hoạch, ngân sách 100 triệu mỗi quý.</li>
                    <li>Đề xuất các chủ đề đào tạo mới.</li>
                    <li>Thực hiện đào tạo hội nhập cho 50 CBNV mới mỗi tháng.</li>
                </ul>

                <div class="project">
                    <h4>Dự Án:</h4>
                    <p><strong>Tên dự án:</strong> Viết mô tả ngắn gọn dự án</p>
                    <p><strong>Vai trò:</strong> Chức danh của bạn trong dự án</p>
                    <p><strong>Trách nhiệm:</strong> Trách nhiệm chính của bạn</p>
                    <p><strong>Công nghệ:</strong> Liệt kê các công nghệ đã sử dụng</p>
                    <p><strong>Nhóm:</strong> X thành viên</p>
                </div>

                <div class="personal-project">
                    <h3>DỰ ÁN CÁ NHÂN</h3>
                    <p>01/2000 - 01/2025</p>
                    <p><strong>Chuyên Viên Đào Tạo</strong></p>
                    <ul>
                        <li>Quản lý chương trình phát triển kỹ năng của 300 nhân viên.</li>
                        <li>Phân tích nhu cầu, lập kế hoạch, ngân sách 100 triệu mỗi quý.</li>
                        <li>Đề xuất các chủ đề đào tạo mới.</li>
                        <li>Thực hiện đào tạo hội nhập cho 50 CBNV mới mỗi tháng.</li>
                    </ul>
                    <p>Link: <a style="color: black" href="topcv.vn/mau-cv" target="_blank">topcv.vn/mau-cv</a></p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
