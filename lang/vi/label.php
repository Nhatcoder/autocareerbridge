<?php
return [
    'delete' => 'Xóa',
    'cancel' => 'Hủy',
    'delete_confirm' => 'Bạn có chắc muốn xóa ?',
    'irreversible_action' => 'Hành động này không thể khôi phục',
    'locale' => 'vi',
    'to' => 'đến',

    'auth' => [
        'login' => 'Đăng nhập',
        'register' => 'Đăng ký',
        'forgot_password' => 'Quên mật khẩu',
        'logout' => 'Đăng xuất',
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'password_confirmation' => 'Xác nhận mật khẩu',
        'user_name' => 'Tên đăng nhập',
        'role' => 'Vai trò',

        'page_login' => [
            'title_box_left' => 'Đăng nhập vào bảng điều khiển quản trị của bạn bằng thông tin đăng nhập của bạn',
            'title_box_right' => 'Chào mừng trở lại',
            'description_box_right' => 'Trang đăng nhập cho phép người dùng nhập thông tin đăng nhập để xác thực và truy cập vào nội dung an toàn.',
            'email_or_username' => 'E-mail / Tên đăng nhập',
            'remember_me' => 'Nhớ đăng nhập',
            'forgot_password' => 'Quên mật khẩu ?',
            'dont_have_account' => 'Bạn chưa có tài khoản ?',
        ],

        'page_register' => [
            'title_box_left' => 'Đăng kí vào bảng điều khiển quản trị của bạn bằng thông tin đăng nhập của bạn',
            'title_box_right' => 'Chào mừng trở lại',
            'description_box_right' => 'Trang đăng ký cho phép người dùng đăng ký với bảng điều khiển quản trị của bản.',
            'company' => 'Doanh nghiệp',
            'university' => 'Trường học',
            'sub_admin' => 'Nhân viên quản trị',
        ],

        'page_forgot_password' => [
            'title_box_left' => 'Đừng lo, chúng tôi ở đây để giúp bạn!',
            'description_box_left' => 'Chỉ cần nhập email, chúng tôi sẽ hướng dẫn bạn cách lấy ngay mật khẩu mới.',
            'title_box_right' => 'Chào mừng trở lại',
            'description_box_right' => 'Nhập email của bạn, chúng tôi sẽ gửi hướng dẫn lấy lại mật khẩu.',
            'email' => 'E-mail',
            'send' => 'Xác nhận',
            'have_acount' => 'Bạn đã có tài khoản ?',
        ]
    ],

    'admin' => [
        'admin' => 'Quản trị',
        'company' => 'Doanh nghiệp',
        'university' => 'Trường',
        'hiring' => 'Tuyển dụng',
        'back' => 'Quay lại',
        'add_new' => 'Thêm mới',
        'update' => 'Cập nhật',
        'home' => 'Trang chủ',
        'search' => 'Tìm kiếm',
        'filter' => 'Lọc',
        'clear_filter' => 'Xóa bộ lọc',
        'delete' => 'Xóa',
        'cancel' => 'Hủy',
        'delete_confirm' => 'Bạn có chắc muốn xóa không?',
        'add_success' => 'Thêm mới thành công',
        'add_error' => 'Thêm mới thất bại',
        'update_success' => 'Cập nhật thành công',
        'update_error' => 'Cập nhật thất bại',
        'delete_success' => 'Xóa thành công',
        'delete_error' => 'Xóa thất bại',
        'no_permission_edit_admin' => 'Bạn không có quyền sửa tài khoản Admin',
        'no_permission_edit_sub_admin' => "Bạn không có quyền sửa tài khoản Sub Admin",
        'account_not_found' => 'Tài khoản không tồn tại.',
        'status_update' => 'Cập nhật trạng thái thành công!',
        'status_update_failed' => 'Lỗi cập nhật trạng thái.',

        'sidebar' => [
            'dashboard' => 'Bảng điều khiển',
            'manager_job' => 'Bài tuyển dụng',
            'workshops' => 'Hội thảo',
            'manager_user' => 'Quản lý tài khoản',
            'manager_field' => 'Lĩnh vực',
            'manager_major' => 'Chuyên ngành',
            'create' => 'Thêm mới',
            'list' => 'Danh sách',
        ],

        'dashboard' => [
            'title' => 'Bảng điều khiển',
            'total_user' => 'Tổng người dùng',
            'total_company' => 'Tổng số doanh nghiệp',
            'total_job' => 'Tổng số job hiện tại',
            'total_university' => 'Tổng số trường đại học',
            'job_statistics' => 'Thống kê jobs',
            'job_posted' => 'Tin công khai',
            'job_deleted' => 'Tin đã xóa',
            'total' => 'Tổng',
            'months' => ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            'job_chart' => 'Thống kê tin tuyển dụng',
            'com_uni_statistics' => 'Thống kê số lượng trường và doanh nghiệp',
            'job_matching_statistics' => 'Thống kê job đã matching',
            'job_matching_success' => 'Job đã được apply thành công',
            'job_vacant' => 'Job còn trống',
            'select_date_range' => 'Khoảng thời gian',
            'default' => 'Mặc định',
            'quater' => 'Theo quý',
            'today' => 'Hôm nay',
            '365_days' => '365 ngày qua',
            '180_days' => '180 ngày qua',
            '90_days' => '90 ngày qua',
            '60_days' => '60 ngày qua',
            '30_days' => '30 ngày qua',
            '7_days' => '7 ngày qua',
            'spring' => 'Xuân',
            'summer' => 'Hạ',
            'autumn' => 'Thu',
            'winter' => 'Đông',
        ],

        'job' => [
            'title_list' => 'Danh sách bài tuyển dụng',
            'job_company_name' => 'Tên job hoặc tên doanh nghiệp',
            'status' => 'Trạng thái',
            'major' => 'Chuyên ngành',
            'title' => 'Tiêu đề',
            'created_at' => 'Ngày đăng',
            'action' => 'Thao tác',
            'select_status' => 'Chọn trạng thái',
            'pending' => 'Chờ phê duyệt',
            'approved' => 'Đã phê duyệt',
            'rejected' => 'Đã từ chối',
            'select_major' => 'Chọn chuyên ngành',
            'detail' => 'Chi tiết',
            'no_job' => 'Không có Jobs nào.',
            'detail_job' => 'Chi tiết bài tuyển dụng',
            'end_date' => 'Hạn nộp hồ sơ',
            'updated_at' => 'Lần cuối cập nhật',
            'skills' => 'Kỹ năng',
            'content' => 'Nội dung bài tuyển dụng',
            'create_by' => 'Đăng bởi',
            'empty' => 'Không có dữ liệu',
            'place' => 'Địa điểm',
            'size' => 'Quy mô',
            'approve' => 'Phê duyệt',
            'reject' => 'Từ chối',
        ],

        'workshop' => [
            'workshop_name_or_university_name' => 'Tên workshop hoặc tên trường',
            'pending' => 'Chưa tổ chức',
            'in_progress' => 'Đang diễn ra',
            'completed' => 'Đã hoàn thành',
            'list_workshop' => 'Danh sách hội thảo',
            'title_workshop' => 'Tên hội thảo',
            'university_create' => 'Trường tổ chức',
            'start_date' => 'Thời gian tổ chức',
            'end_date' => 'Thời gian kết thúc',
            'status' => 'Trạng thái',
            'action' => 'Thao tác',
            'no_workshop' => 'Không có hội thảo nào.',
            'detail' => 'Chi tiết',
            'detail_workshop' => 'Chi tiết hội thảo',
            'company_total' => 'Số doanh nghiệp tham gia/Tổng',
            'content' => 'Nội dung bài đăng',

        ],

        'user' => [
            'sub_admin' => 'Quản trị cơ bản',
            'title_list' => 'Danh sách tài khoản',
            'user_name_or_email' => 'Tên đăng nhập hoặc email',
            'role' => 'Vai trò',
            'select_role' => 'Chọn vai trò',
            'status' => 'Trạng thái',
            'select_status' => 'Chọn trạng thái',
            'join_date' => 'Ngày tham gia',
            'user_name' => 'Tên đăng nhập',
            'action' => 'Thao tác',
            'university' => 'Trường học',
            'company' => 'Doanh nghiệp',
            'admin' => 'Quản trị',
            'active' => 'Hoạt động',
            'inactive' => 'Khóa',
            'no_user' => 'Không có tài khoản nào',
            'account' => 'Tài khoản',
            'create_account' => 'Thêm mới tài khoản',
            'information_account' => 'Thông tin tài khoản',
            'detailed_information' => 'Thông tin chi tiết',
            'password' => 'Mật khẩu',
            'confirm_password' => 'Xác nhận mật khẩu',
            'edit_account' => 'Sửa tài khoản',
            'current_password' => 'Mật khẩu cũ',
            'new_password' => 'Mật khẩu mới',
            'confirm_new_password' => 'Xác nhận mật khẩu',
        ],

        'header' => [
            'profile' => 'Tài khoản',
            'notification' => 'Thông báo',
            'logout' => 'Đăng xuất',
        ],
        'profile' => [
            'information' => 'Thông tin chung',
            'about' => 'Giới thiệu',
            'description' => 'Mô tả',
            'information_detail' => 'Thông tin chi tiết',
            'join_date' => 'Ngày tham gia',
            'last_updated' => 'Cập nhật lần cuối',
            'end_date' => 'Ngày hết hạn',
            'name' => 'Tên',
            'slug' => 'Slug',
            'size' => 'Quy mô',
            'member' => 'Thành viên',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'avatar' => 'Hình ảnh',
            'staff_manager' => 'Quản lý nhân viên',
            'list_jobs' => 'Công việc mới',
            'province' => 'Tình/Thành phố',
            'district' => 'Quận/Huyện',
            'ward' => 'Xã/Phường',
            'specific_address' => 'Địa chỉ cụ thể',
            'submit' => 'Cập nhật',
            'web_link' => 'Trang web',
            'field' => 'Lĩnh vực',
            'select_field' => 'Chọn lĩnh vực',
            'placeholder_name' => 'Nhập tên công ty',
            'placeholder_slug' => 'Nhập slug công ty',
            'placeholder_website' => 'Nhập website công ty',
            'placeholder_size' => 'Nhập quy mô công ty',
            'placeholder_address_detail' => 'Nhập địa chỉ chi tiết công ty',
            'placeholder_province' => 'Chọn Tỉnh/Thành phố',
            'placeholder_district' => 'Chọn Quận/Huyện',
            'placeholder_ward' => 'Chọn xã/Phường',
        ],

        'management_university' => [
            'workshop' => [
                'title' => 'Quản lý workshop',
                'list_workshop' => 'Danh sách workshop',
                'add_workshop' => 'Thêm workshop',
                'edit_workshop' => 'Sửa workshop',
                'information_workshop' => 'Thông tin workshop',
                'detail_workshop' => 'Thông tin chi tiết',
                'name' => 'Tên workshop',
                'slug' => 'Slug',
                'avatar' => 'Ảnh',
                'select_avatar' => 'Chọn ảnh',
                'start_date' => 'Thời gian bắt đầu',
                'end_date' => 'Thời gian kết thúc',
                'amount' => 'Số lượng tham gia',
                'content' => 'Mô tả',
                'submit' => 'Cập nhật',
                'edit' => 'Sửa',
                'delete' => 'Xóa nhân viên',
            ],
        ],

        'fields' => [
            'list_fields' => 'Danh sách lĩnh vực',
            'name_field' => 'Tên lĩnh vực',
            'slug' => 'Slug',
            'description' => 'Mô tả',
            'action' => 'Hành động',
            'info_field' => 'Thông tin lĩnh vực',
            'no_fields' => 'Không có lĩnh vực nào',
        ],

        'majors' => [
            'list_majors' => 'Danh sách chuyên ngành',
            'name_major' => 'Tên chuyên ngành',
            'select_field' => 'Chọn lĩnh vực',
            'slug' => 'Slug',
            'description' => 'Mô tả',
            'action' => 'Hành động',
            'info_major' => 'Thông tin chuyên ngành',
            'no_majors' => 'Không có chuyên ngành nào',
        ],
    ],
    'breadcrumb' => [
        'home' => 'Trang chủ',
        'detail' => 'Thông tin chi tiết',
        'collaboration' => 'Quản lý hợp tác',
        'profile' => 'Thông tin',
        'company' => 'Doanh nghiệp',
        'company_information' => 'Thông tin doanh nghiệp',
        'update_profile' => 'Cập nhật thông tin',
    ],
    'client' => [
        'no_image' => 'Không có hình ảnh',
        'title' => [
            'company_information' => "Thông tin doanh nghiệp",
            'companies' => "Danh sách doanh nghiệp",
        ]
    ],

    'company' => [
        'job' => [
            'home' => 'Trang chủ',
            'about' => 'Danh sách bài tuyển dụng',
            'filter' => 'Tìm kiếm',
            'title_search' => 'Tiêu đề / Người đăng bài',
            'select_status' => 'Chọn trạng thái',
            'status' => 'Trạng thái',
            'approved' => 'Đã phê duyệt',
            'pending' => 'Chờ phê duyệt',
            'refused' => 'Từ chối',
            'rejected' => 'Đã từ chối',
            'major' => 'Chuyên ngành',
            'select_major' => 'Chọn chuyên ngành',
            'title' => "Tiêu đề",
            'author' => "Người đăng bài",
            'required_major' => "Chuyên ngành yêu cầu",
            'posting_date' => "Ngày đăng bài",
            'expiration_date' => "Ngày hết hạn bài tuyển dụng",
            'action' => "Thao tác",
            'delete' => 'Xóa',
            'cancel' => 'Hủy',
            'delete_confirm' => 'Bạn có chắc muốn xóa bài tuyển dụng không?',
            'clear_filter' => 'Xóa bộ lọc',
            'no_jobs' => 'Không có bài tuyển dụng nào',
            'create' => 'Thêm mới',
            'create_job' => 'Thêm mới bài tuyển dụng',
            //Thêm mới
            'title_job' => 'Bài tuyển dụng',
            'detail' => 'Chi tiết bài tuyển dụng',
            'slug' => 'Slug',
            'skill' => 'Kỹ năng',
            'information' => 'Thông tin',
            'detailed_information' => 'Thông tin chi tiết',
            'back' => 'Quay lại',
            //Sửa
            'update' => 'Cập nhật',
            'edit_job' => 'Sửa bài tuyển dụng',
            'show_job' => 'Chi tiết bài tuyển dụng',
            'deadline' => 'Hạn nộp hồ sơ',
            'list_internship' => 'Danh sách trường ứng tuyển',
            'no_internship' => 'Không có trường ứng tuyển nào',
            'university_name' => 'Tên trường học',
            'request_date' => 'Ngày gửi yêu cầu',
            'accept' => 'Phê duyệt',
            'reject' => 'Từ chối',
            //Trường học
            'list_applied_jobs' => 'Bài tuyển dụng đã ứng tuyển',
            'cancel_apply' => 'Hủy ứng tuyển',
        ],
        'dashboard' => [
            'home' => 'Trang chủ',
            'university' => 'Trường học',
            'statistical' => 'Thống kê',
            'total_employees' => 'Tổng số nhân viên',
            'total_collaborations' => 'Tổng số trường hợp tác',
            'total_jobs_posted' => 'Tổng số job đã đăng',
            'total_collaborative_workshops' => 'Tổng số WorkShop hợp tác',
            'job_statistics' => 'Thống kê Job',
            'collaborative_university_workshop' => 'Thống kê số lượng trường và WorkShop đã hợp tác',
            'job_matching_university' => 'Thống kê jobs đã matching với trường học',
            'job_received' => 'Job đã được trường học nhận',  
            'vacant_job' => 'Job còn trống',
            'job_pending' => 'Tin chờ duyệt',
            'job_aproved' => 'Tin đã duyệt',
            'job_reject' => 'Tin đã từ chối',
            'job_delete' => 'Tin đã xóa',
        ],
        'sidebar' => [
            'business_staff' => 'Nhân viên doanh nghiệp',
            'job' => 'Quản lý tin tuyển dụng',
            'list' => 'Danh sách',
            'create' => 'Thêm mới',
            'dashboard' => 'Bảng điều khiển',
            'manage_hiring' => 'Quản lý nhân viên',
            'manage_collaboration' => 'Quản lý trường hợp tác',
            'search_university' => 'Tìm kiếm trường học',
            'manage_applied_jobs' => 'Quản lý tin được ứng tuyển',
            'manage_workshop' => 'Bài workshop đã tham gia',
        ],
        'collaboration' => [
            'filter' => 'Lọc',
            'reset' => 'Xoá lọc',
            'search_fields' => 'Tìm kiếm',
            'search_placeholder' => 'Tìm kiếm tên, tên doanh nghiệp',
            'fill_date_placeholder' => 'Nhấn để chọn khoảng thời gian',
            'fill_status_placeholder' => 'Chọn trạng thái',
            'select_status' => 'Chọn trạng thái',
            'date' => 'Thời gian bắt đầu - kết thúc',
            'search_result' => 'Kết quả tìm kiếm',
            'accept' => 'Đang tiến hành',
            'request' => 'Yêu cầu',
            'reject' => 'Từ chối',
            'close' => 'Đóng',
            'content' => 'Nội dung',
            'title' => 'Tiêu đề',
            'company' => 'Doanh nghiệp',
            'response_message' => 'Phản hồi',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'status' => 'Trạng thái',
            'action' => 'Hành động',
            'pagination_search' => 'Không tìm thấy kết quả phù hợp',
            'pagination' => 'Không có dữ liệu nào',
            'detail_colab' => "Chi tiết yêu cầu",
            "size" => "Quy mô",
            "approve" => "Phê duyệt",
            "created_at" => "Ngày gửi",
            "feedback" => "Phản hồi",
            "feedback_content" => "Nội dung phản hồi",
            "feedback_placeholder" => "Nhập nội dung phản hồi!",
            "send" => "Gửi",
            "cancel" => "Quay lại",
            "complete" => "Hoàn thành",
            "active" => "Đang tiến hành",
            "completed" => "Đã hoàn thành",
            "pending" => "Chờ duyệt",
            "rejected" => "Đã từ chối",
            "revoke_confirm" => "Bạn có chắc muốn thu hồi yêu cầu hợp tác này!",
            "revoke" => "Thu hồi",
            "not_found" => "Không có phản hồi",
            "university" => "Trường học",
        ],
        'hiring' => [
            'filter' => 'Lọc',
            'clear_filter' => 'Xóa bộ lọc',
            'title_search' => 'Tên đầy đủ / Email',
            'action' => 'Hành Động',
            'join_date' => 'Ngày tham gia',
            'employee_list' => 'Danh sách nhân viên',
            'name' => 'Tên Đầy Đủ',
            'image' => 'Ảnh',
            'user_name' => 'Tên Đăng Nhập',
            'phone' => 'Số điện thoại',
            'create_at' => 'Ngày tham gia',
            'create' => 'Thêm mới',
            'home' => 'Trang chủ',
            'add' => [
                'company' => 'Doanh nghiệp',
                'create_employee' => 'Thêm mới nhân viên',
                'profile_employee' => 'Thông tin nhân viên',
                'image_employee' => 'Ảnh đại diện',
                'name' => 'Tên đầy đủ',
                'phone' => 'Số điện thoại',
                'choose' => 'Chọn ảnh',
                'information_details' => 'Thông tin chi tiết',
                'user_name' => 'Tên đăng nhập',
                'password' => 'Mật Khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu',
                'back' => 'Quay lại',
                'add_new' => 'Thêm mới',
            ],
            'edit' => [
                'employee' => 'Nhân Viên',
                'update_employee' => 'Cập nhật nhân viên',
                'profile_employee' => 'Thông Tin Nhân Viên',
                'name' => 'Tên đầy đủ',
                'phone' => 'Số điện thoại ',
                'image_employee' => 'Ảnh đại diện',
                'choose' => 'Chọn ảnh',
                'information_details' => 'Thông tin chi tiết',
                'user_name' => 'Tên đăng nhập',
                'back' => 'Quay lại',
                'update' => 'Cập nhật',
            ]

        ],
        'applyJob' => [
            'manage_applied_jobs' => 'Quản lí công việc ứng tuyển',
            "pending" => "Chờ duyệt",
            "rejected" => "Đã từ chối",
            "approved" => "Đã duyệt",
            "name" => "Tên công việc",
            "university" => "Trường học",
            "date" => "Ngày tạo",
            "action" => "Hành động",
            "status" => "Trạng thái",
            "approve" => "Phê duyệt",
            "reject" => "Từ chối",
            'no_data' => 'Không có dữ liệu nào.',
        ],
        'joinWorkshop' => [
            "pending" => "Chờ duyệt",
            "rejected" => "Đã từ chối",
            "approved" => "Đã duyệt",
            "name" => "Tên workshop",
            "university" => "Trường học đăng bài",
            "start_date" => "Thời gian bắt đầu",
            'end_date' => "Thời gian kết thúc",
            "status" => "Trạng thái",
            'no_data' => "Không có dữ liệu nào.",
            'manage_workshop' => 'Quản lý WorkShop ứng tuyển',
            'workshop_applied' => 'Các bài WorkShop ứng tuyển',
        ]
    ],
    'university' => [
        'list' => 'Danh sách',
        'back' => 'Quay lại',
        'add_new' => 'Thêm mới',
        'update' => 'Cập nhật',
        'home' => 'Trang chủ',
        'search' => 'Tìm kiếm',
        'filter' => 'Lọc',
        'clear_filter' => 'Xóa bộ lọc',
        'title_search' => 'Tên sinh viên / Email / Số điện thoại',
        'action' => 'Thao tác',
        'delete' => 'Xóa',
        'cancel' => 'Hủy',
        'delete_confirm' => 'Bạn có chắc muốn xóa?',
        'no_avatar' => 'Không có ảnh nào.',
        'student' => [
            'error' => 'Lỗi',
            'title' => 'Quản lý sinh viên',
            'list_student' => 'Danh sách sinh viên',
            'download_template' => 'Tải mẫu import',
            'import' => 'Import sinh viên',
            'name' => 'Tên sinh viên',
            'avatar' => 'Ảnh',
            'select_avatar' => 'Chọn Ảnh',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'major' => 'Chuyên ngành',
            'select_major' => 'Chọn chuyên ngành',
            'entry_year' => 'Ngày nhập học',
            'graduation_year' => 'Ngày ra trường',
            'entry_graduation_year_range' => 'Khoảng thời gian nhập học - ra trường',
            'select_entry_graduation_year_range' => 'Chọn khoảng thời gian',
            'create_student' => 'Thêm mới sinh viên',
            'information_student' => 'Thông tin sinh viên',
            'detailed_information' => 'Thông tin chi tiết',
            'male_gender' => 'Nam',
            'female_gender' => 'Nữ',
            'gender' => 'Giới tính',
            'student_code' => 'Mã sinh viên',
            'description' => 'Mô tả',
            'edit_student' => 'Chỉnh sửa sinh viên',
            'no_data' => 'Không có sinh viên nào.',
        ],
        'sidebar' => [
            'manager_student' => 'Quản lý sinh viên',
            'jobs_applied' => 'Bài tuyển dụng đã ứng tuyển',
            'colab_manager' => 'Quản lý hợp tác',
            'dashboard' => 'Trang quản trị',
            'manage_workshop' => ' Quản lý workshop',
            'manage_academic' => 'Quản lý giáo vụ',
            'dashboard' => 'Bảng điều khiển',
            'manage_major' => 'Quản lý chuyên ngành',
            'manage_workshop_applied' => 'Quản lý doanh nghiệp ứng tuyển workshop',
        ],
        'collaboration' => [
            'filter' => 'Lọc',
            'reset' => 'Xoá lọc',
            'search_fields' => 'Tìm kiếm',
            'search_placeholder' => 'Tìm kiếm tên, tên doanh nghiệp ,...',
            'date' => 'Thời gian bắt đầu - kết thúc',
            'search_result' => 'Kết quả tìm kiếm',
            'accept' => 'Đang tiến hành',
            'request' => 'Yêu cầu đã gửi',
            'received_request' => 'Yêu cầu đã nhận',
            'reject' => 'Từ chối',
            'close' => 'Đóng',
            'content' => 'Nội dung',
            'title' => 'Tiêu đề',
            'company' => 'Doanh nghiệp',
            'response_message' => 'Phản hồi',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'status' => 'Trạng thái',
            'action' => 'Hành động',
            'pagination_search' => 'Không tìm thấy kết quả phù hợp',
            'pagination' => 'Không có dữ liệu nào',
            'detail_colab' => "Chi tiết yêu cầu",
            "size" => "Quy mô",
            "approve" => "Phê duyệt",
            "created_at" => "Ngày gửi",
            "feedback" => "Phản hồi",
            "feedback_content" => "Nội dung phản hồi",
            "feedback_placeholder" => "Nhập nội dung phản hồi!",
            "send" => "Gửi",
            "cancel" => "Quay lại",
            "complete" => "Hoàn thành",
            "active" => "Đang tiến hành",
            "completed" => "Đã hoàn thành",
            "pending" => "Chờ duyệt",
            "rejected" => "Đã từ chối",
            "revoke_confirm" => "Bạn có chắc muốn thu hồi yêu cầu hợp tác này!",
            "revoke" => "Thu hồi",
            "not_found" => "Không có phản hồi",
            "university" => "Trường học",
        ],
        'academic' => [
            'filter' => 'Lọc',
            'clear_filter' => 'Xóa bộ lọc',
            'title_search' => 'Tên đầy đủ / Email',
            'action' => 'Hành Động',
            'join_date' => 'Ngày tham gia',
            'employee_list' => 'Danh sách giáo vụ',
            'name' => 'Tên Đầy Đủ',
            'image' => 'Ảnh',
            'user_name' => 'Tên Đăng Nhập',
            'phone' => 'Số điện thoại',
            'create_at' => 'Ngày tham gia',
            'create' => 'Thêm mới',
            'home' => 'Trang chủ',
            'add' => [
                'company' => 'Giáo vụ',
                'create_employee' => 'Thêm mới giáo vụ',
                'profile_employee' => 'Thông tin giáo vụ',
                'image_employee' => 'Ảnh đại diện',
                'name' => 'Tên đầy đủ',
                'phone' => 'Số điện thoại',
                'choose' => 'Chọn ảnh',
                'information_details' => 'Thông tin chi tiết',
                'user_name' => 'Tên đăng nhập',
                'password' => 'Mật Khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu',
                'back' => 'Quay lại',
                'add_new' => 'Thêm mới',
            ],
            'edit' => [
                'employee' => 'Giáo Vụ',
                'update_employee' => 'Cập nhật giáo cụ',
                'profile_employee' => 'Thông Tin giáo vụ',
                'name' => 'Tên đầy đủ',
                'phone' => 'Số điện thoại ',
                'image_employee' => 'Ảnh đại diện',
                'choose' => 'Chọn ảnh',
                'information_details' => 'Thông tin chi tiết',
                'user_name' => 'Tên đăng nhập',
                'back' => 'Quay lại',
                'update' => 'Cập nhật',
            ]
        ],
        'applyWorkshop' => [
            'manage_applied_workshops' => 'Quản lí công việc ứng tuyển',
            "pending" => "Chờ duyệt",
            "rejected" => "Đã từ chối",
            "approved" => "Đã duyệt",
            "name" => "Tên workshop",
            "company" => "Doanh nghiệp",
            "date" => "Ngày tạo",
            "action" => "Hành động",
            "status" => "Trạng thái",
            "approve" => "Phê duyệt",
            "reject" => "Từ chối",
            'no_data' => 'Không có dữ liệu nào.',
        ],

    ],
    'notification' => [
        'title' => 'Thông báo',
        'list_notification' => 'Danh sách thông báo',
        'mark_all_as_read' => 'Đánh dấu tất cả đã đọc',
        'view_all' => 'Xem tất cả',
        'no_notification' => 'Không có thông báo nào',
        'delete' => 'Xóa',
        'delete_confirm' => 'Bạn có chắc muốn xóa thông báo này?',
        'irreversible_action' => 'Hành động này không thể khôi phục',
        'created_at' => 'Ngày tạo',
        'status' => 'Trạng thái',
        'action' => 'Thao tác',
        'read' => 'Đã đọc',
        'unread' => 'Chưa đọc',
        'loading' => 'Đang tải...',
        'cancel' => 'Hủy',
        'read_all' => 'Xem tất cả thông báo',
        'name' => 'Thông báo',
    ],
];
