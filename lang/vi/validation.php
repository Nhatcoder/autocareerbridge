<?php
return [
    'required' => ':attribute không được để trống.',
    'email' => 'Email không đúng định dạng.',
    'string' => ':attribute phải là chuỗi.',
    'min' => [
        'string' => ':attribute phải có ít nhất :min ký tự.',
        'numeric' => ':attribute phải có giá trị lớn hơn hoặc bằng :min.',
        'array' => ':attribute phải có ít nhất :min phần tử.',
    ],
    'max' => [
        'string' => ':attribute chỉ được tối đa :max ký tự.',
        'numeric' => ':attribute phải có giá trị nhỏ hơn hoặc bằng :max.',
        'array' => ':attribute chỉ được tối đa :max phần tử.',
    ],
    'exists' => ':attribute không tồn tại.',
    'date' => ':attribute phải là ngày hợp lệ.',
    'array' => ':attribute phải là một mảng.',
    'unique' => ':attribute đã được sử dụng.',
    'regex' => ':attribute không đúng định dạng.',
    'image' => ':attribute phải là một tệp hình ảnh.',
    'mimes' => ':attribute phải có định dạng: :values.',
    'in' => ':attribute không hợp lệ.',
    'alpha_dash' => ':attribute phải là chữ thường và số.',
    'confirmed' => ':attribute xác nhận không khớp.',
    'date_format' => ':attribute không hợp lệ.',
    'date_after' => ':attribute không được lớn hơn :date.',
    'digits' => ':attribute không hợp lệ.',
    'attributes' => [
        'slug' => 'Slug',
        'user_name' => 'Tên đăng nhập',
        'full_name' => 'Tên đầy đủ',
        'name' => 'Tên',
        'password' => 'Mật khẩu',
        'phone' => 'Số điện thoại',
        'size' => 'Kích thước',
        'province_id' => 'Tỉnh/Thành phố',
        'district_id' => 'Quận/Huyện',
        'ward_id' => 'Xã/Phường',
        'specific_address' => 'Địa chỉ cụ thể',
        'about' => 'Giới thiệu',
        'detail' => 'Chi tiết',
        'major_id' => 'Chuyên ngành',
        'major' => 'Chuyên ngành',
        'end_date' => 'Ngày hết hạn',
        'skill_name' => 'Kỹ năng',
        'field_id' => 'Lĩnh vực',
        'student_code' => 'Mã sinh viên',
        'email' => 'Email',
        'gender' => 'Giới tính',
        'avatar_path' => 'Ảnh đại diện',
        'date_range' => 'Khoảng thời gian nhập học - ra trường',
        'entry_year' => "Thời gian vào học",
        'entry_year_lower' => 'thời gian vào học',
        'graduation_year' => "Thời gian tốt nghiệp",
        'role' => 'Vai trò',
        'fields'=> 'Lĩnh vực',
        'description'=> 'Mô tả',
        'string'=> 'Chuỗi',
    ],

    'custom' => [
        'user_name' => [
            'regex' => 'Tên đăng nhập phải là chữ thường và số.',
        ],
        'password' => [
            'regex' => 'Mật khẩu phải chứa ít nhất một chữ cái hoa, một chữ cái thường, số và ký tự đặc biệt.',
        ],
        'avatar_path' => [
            'max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ],
    ],
];
