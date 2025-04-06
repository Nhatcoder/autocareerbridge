# 🚀 AutoCareerBridge

> *Kết nối ứng viên, nhà tuyển dụng và nhà trường một cách thông minh và hiệu quả.*

---

## 🧩 Giới thiệu

**AutoCareerBridge** là một nền tảng web hỗ trợ đăng tin tuyển dụng, tìm kiếm việc làm, nhắn tin giữa các bên và phân tích thống kê tuyển dụng. Mục tiêu của dự án là tạo cầu nối giữa **ứng viên**, **nhà tuyển dụng** và **các trường đại học** nhằm mang đến giải pháp tìm việc toàn diện.

---

## 🛠️ Công nghệ sử dụng

| Công nghệ        | Mô tả                                                                 |
|------------------|-----------------------------------------------------------------------|
| **PHP**          | Ngôn ngữ lập trình phía server                                        |
| **Laravel**          | Ngôn ngữ lập trình phía server                                        |
| **HTML/CSS**     | Cấu trúc và tạo kiểu cho giao diện người dùng                        |
| **JavaScript**   | Xử lý tương tác người dùng phía client                               |
| **ReactJS**   | Xử lý phần nhắn tin ứng viên với doanh nghiệp                               |
| **Mysql**   | Lưu trữ hệ thống                               |
| **Jquery**   |    Quản trị admin hệ thống, doanh nghiệp, Nhà trường                            |
| **CKEditor 4**   | Trình soạn thảo văn bản WYSIWYG tích hợp                             |

---

## ✨ Tính năng chính

- ✅ **Đăng tin tuyển dụng**  
  Nhà tuyển dụng có thể tạo, chỉnh sửa và quản lý các bài đăng tuyển dụng dễ dàng.

- 🔍 **Tìm kiếm công việc**  
  Ứng viên có thể lọc và tìm kiếm việc làm theo vị trí, ngành nghề, địa điểm...

- 👤 **Quản lý thông tin người dùng**  
  Hệ thống phân loại và quản lý thông tin của ứng viên và nhà tuyển dụng hiệu quả.

- 💬 **Nhắn tin giữa ứng viên và doanh nghiệp**  
  Cho phép trao đổi trực tiếp giữa hai bên thông qua hệ thống chat nội bộ.

- 🏫 **Hợp tác giữa nhà trường và doanh nghiệp**  
  Kết nối các trường đại học với doanh nghiệp để hỗ trợ sinh viên tiếp cận cơ hội việc làm.

- 📊 **Thống kê tuyển dụng theo doanh nghiệp**  
  Hiển thị số lượng công việc, lượt ứng tuyển, và hiệu quả từng bài đăng theo doanh nghiệp.

- 📄 **Xuất PDF**  
  Tích hợp **CKEditor 4 Export to PDF** cho phép người dùng xuất nội dung ra file PDF.

---

## 🚀 Hướng dẫn cài đặt

1. **Clone dự án về máy:**

   ```bash
   git clone https://github.com/Nhatcoder/autocareerbridge.git
   ```

2. **Cấu hình môi trường:**

   ```bash
   cp .env.example .env
   ```

3. **Cài đặt Composer:**

   ```bash
   composer install
   ```

4. **Tạo key và migrate database:**

   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Khởi động server:**

   ```bash
   php artisan serve
   ```

---

## 📁 Cấu trúc dự án (cơ bản)

```
├── app/
├── public/
├── resources/
│   ├── views/
│   └── js/
├── routes/
│   └── web.php
├── .env
└── composer.json
```

---

## 📸 Giao diện (Screenshots)

> *(Thêm ảnh vào thư mục `assets/` và sử dụng link dưới đây để hiển thị)*

![Trang chủ](assets/homepage.png)
![Tìm việc](assets/job_search.png)

---

## 📜 Giấy phép

Dự án được phát hành theo [MIT License](LICENSE).

---

## 🙋 Liên hệ

- 👤 **Tác giả**: [Nhatcoder](https://github.com/Nhatcoder)
- 📧 Email: *your-email@example.com*

---

*Hãy ⭐ repo nếu bạn thấy dự án hữu ích!*
