<?php
return [
    'required' => ':attribute is required.',
    'email' => 'The email format is invalid.',
    'string' => ':attribute must be a string.',
    'min' => [
        'string' => ':attribute must be at least :min characters.',
        'numeric' => ':attribute must be greater than or equal to :min.',
        'array' => ':attribute must have at least :min items.',
    ],
    'max' => [
        'string' => ':attribute must not exceed :max characters.',
        'numeric' => ':attribute must not be greater than :max.',
        'array' => ':attribute must not have more than :max items.',
    ],
    'exists' => ':attribute does not exist.',
    'date' => ':attribute must be a valid date.',
    'array' => ':attribute must be an array.',
    'unique' => ':attribute already exists.',
    'integer' => ':attribute must be an integer.',
    'regex' => ':attribute format is invalid.',
    'image' => ':attribute must be a valid image file.',
    'mimes' => ':attribute must be a file of type: :values.',
    'in' => 'The selected :attribute is invalid.',
    'alpha_dash' => ':attribute must be normal and number.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date_format' => 'The :attribute format is invalid.',
    'date_after' => ':attribute cannot be later than :date.',

    'attributes' => [
        'slug' => 'Slug',
        'user_name' => 'User Name',
        'name' => 'Name',
        'phone' => 'Phone Number',
        'size' => 'Size',
        'province_id' => 'Province/City',
        'district_id' => 'District',
        'ward_id' => 'Ward',
        'specific_address' => 'Specific Address',
        'about' => 'Description',
        'detail' => 'Detail',
        'major_id' => 'Major',
        'major' => 'Major',
        'end_date' => 'End Date',
        'skill_name' => 'Skill',
        'field_id' => 'Filled',
        'student_code' => 'Student Code',
        'email' => 'Email',
        'gender' => 'Gender',
        'avatar_path' => 'Avatar',
        'date_range' => 'Date Range of Enrollment - Graduation',
        'entry_time' => "Time of Entry",
        'entry_time_lower' => 'time of entry',
        'graduation_time' => "Time of Graduation",
        'role' => 'Role',
        'password' => 'Password',
    ],

    'custom' => [
        'user_name' => [
            'regex' => 'User name must be lowercase and numbers.',
        ],
        'password' => [
            'regex' => 'Password must contain at least one uppercase letter, one lowercase letter, a number, and a special character.',
        ],
    ],
];
