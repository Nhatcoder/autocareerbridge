<?php
return [
    'auth' => [
        'login' => 'Login',
        'register' => 'Register',
        'forgot_password' => 'Forgot password',
        'logout' => 'Logout',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm password',
        'user_name' => 'Username',
        'role' => 'Role',

        'page_login' => [
            'title_box_left' => 'Login to your administration account using your account information',
            'title_box_right' => 'Welcome back',
            'description_box_right' => 'The login page allows users to enter their login information to authenticate and access secure content.',
            'email_or_username' => 'Email / Username',
            'remember_me' => 'Remember me',
            'forgot_password' => 'Forgot password?',
            'dont_have_account' => 'Don\'t have an account?',
        ],

        'page_register' => [
            'title_box_left' => 'Register for an administration account using your account information',
            'title_box_right' => 'Welcome back',
            'description_box_right' => 'The registration page allows users to register with the administration account.',
            'company' => 'Company',
            'university' => 'University',
            'sub_admin' => 'Sub admin',
        ],

        'page_forgot_password' => [
            'title_box_left' => 'Don\'t worry, we\'re here to help you!',
            'description_box_left' => 'Just enter your email and we\'ll show you how to get a new password.',
            'title_box_right' => 'Welcome back',
            'description_box_right' => 'Enter your email and we\'ll send you a password recovery guide.',
            'email' => 'Email',
            'send' => 'Confirm',
            'have_acount' => 'Do you already have an account?',
        ],
    ],
    'admin' => [
        'back' => 'Back',
        'university' => 'University',
        'add_new' => 'Create',
        'update' => 'Update',
        'home' => 'Home',
        'search' => 'Search',
        'filter' => 'Filter',
        'clear_filter' => 'Clear filter',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
        'delete_confirm' => 'Are you sure you want to delete?',
        'add_success' => 'Add new success',
        'add_error' => 'Add new error',
        'update_success' => 'Update success',
        'update_error' => 'Update error',
        'delete_success' => 'Delete success',
        'delete_error' => 'Delete error',
        'no_permission_edit_admin' => 'You do not have permission to edit admin',
        'no_permission_edit_sub_admin' => "You don't have permission to edit sub admin",
        'account_not_found' => 'The account does not exist.',
        'status_update' => 'Status updated successfully!',
        'status_update_failed' => 'Failed to update status.',

        'sidebar' => [
            'dashboard' => 'Dashboard',
            'manager_job' => 'Jobs management',
            'workshops' => 'Workshops',
            'manager_user' => 'User management',
            'create' => 'Create',
            'list' => 'List',
        ],

        'dashboard' => [
            'total_user' => 'Total users',
            'total_company' => 'Total companies',
            'total_job' => 'Total current jobs',
            'total_university' => 'Total universities',
            'job_statistics' => 'Job statistics',
            'total' => 'Total',
            'months' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",],
            'com_uni_statistics' => 'Company and university statistics',
            'job_matching_statistics' => 'Job matching statistics',
            'job_matching_success' => 'Jobs successfully applied',
            'job_vacant' => 'Vacant jobs'

        ],

        'job' => [
            'title_list' => 'Job Post List',
            'job_company_name' => 'Job Name or Company Name',
            'status' => 'Status',
            'major' => 'Major',
            'title' => 'Title',
            'action' => 'Action',
            'created_at' => 'Posted Date',
            'select_status' => 'Select Status',
            'pending' => 'Pending Approval',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'select_major' => 'Select major',
            'detail' => 'Detail',
            'no_job' => 'No Jobs available.',
            'detail_job' => 'Job Post Details',
            'end_date' => 'End Date',
            'updated_at' => 'Last Updated',
            'skills' => 'Skills',
            'content' => 'Post Content',

        ],

        'user' => [
            'sub_admin' => 'Sub Admin',
            'title_list' => 'Account list',
            'user_name_or_email' => 'Username or email',
            'role' => 'Role',
            'select_role' => '--Select role--',
            'status' => 'Status',
            'select_status' => '--Select status--',
            'join_date' => 'Join date',
            'user_name' => 'Username',
            'action' => 'Action',
            'university' => 'University',
            'company' => 'Company',
            'admin' => 'Admin',
            'active' => 'Activity',
            'inactive' => 'Deactivate',
            'no_user' => 'No user found.',
            'account' => 'Account',
            'create_account' => 'Create account',
            'information_account' => 'Information Account',
            'detailed_information' => 'Detailed information',
            'password' => 'Password',
            'confirm_password' => 'Confirm password',
            'edit_account' => 'Edit account',
            'current_password' => 'Current password',
            'new_password' => 'New password',
            'confirm_new_password' => 'Confirm new password',
        ],

        'company' => 'Company',
        'profile' => [
            'information' => 'General information',
            'about' => 'About',
            'description' => 'Description',
            'information_detail' => 'Detailed information',
            'join_date' => 'Join Date',
            'last_updated' => 'Last updated',
            'province' => 'Province/City',
            'district' => 'District',
            'ward' => 'Commune/Ward',
            'address_detail' => 'Detailed address',
            'name' => 'Name',
            'size' => 'Size',
            'member' => 'Member',
            'phone' => 'Phone',
            'address' => 'Address',
            'image' => 'image',
            'add_staff' => 'More staff',
            'list_jobs' => 'Job new',
            'submit' => 'Submit',
            'web_link' => 'Website',
            'field' => 'Field',
            'select_field' => '--Select field--',
        ]
    ],
    'breadcrumb' => [
        'home' => 'Home',
        'detail' => 'Information Detail',
        'collaboration' => 'Collaboration',
        'profile' => 'Profile',
        'company' => 'Company',
        'company_information' => 'Company information',
        'update_profile' => 'Update profile',
    ],
    'client' => [
        'no_image' => 'No image',
        'title' => [
            'company_information' => "Company Information",
            'companies' => "Companies",
        ]
    ],
    'company' => [
        'job' => [
            'home' => 'Home',
            'about' => 'List of posts',
            'filter' => 'Filter',
            'title_search' => 'Title | Author',
            'select_status' => 'Select status',
            'status' => 'Status',
            'approved' => 'Approved',
            'pending' => 'Pending',
            'refused' => 'Refused',
            'major' => 'Major',
            'select_major' => '--Select major--',
            'title' => "Title",
            'author' => "Author",
            'required_major' => 'Required major',
            'posting_date' => 'Posting date',
            'expiration_date' => 'Expiration date',
            'action' => 'Action',
            'delete' => 'Delete',
            'cancel' => 'Cancel',
            'delete_confirm' => 'Are you sure you want to delete this job?',
            'clear_filter' => 'Clear filter',
            'no_jobs' => 'No jobs',
            'create' => 'Create',
            'create_job' => 'Create job',
            //Thêm mới
            'title_job' => 'Job',
            'detail' => 'Detail job',
            'slug' => 'Slug',
            'skill' => 'Skill',
            'information' => 'Information',
            'detailed_information' => 'Detailed information',
            'back' => 'Back',
            //Sửa
            'update' => 'Update',
            'edit_job' => 'Update job',
        ],
        'sidebar' => [
            'business_staff' => 'Business Staff',
            'job' => 'Manage job',
            'list' => 'List',
            'create' => 'Create',
            'dashboard' => 'Dashboard',
            'manage_hiring' => 'Manage hiring',
            'manage_collaboration' => 'Manage collaboration',
            'search_university' => 'Search university',
        ],
        'collaboration' => [
            'filter' => 'Filter',
            'reset' => 'Reset filter',
            'search_fields' => 'Search',
            'search_placeholder' => 'Search by name, company name',
            'date' => 'Start date - End date',
            'search_result' => 'Search results',
            'accept' => 'Accepted',
            'request' => 'Request',
            'reject' => 'Reject',
            'close' => 'Close',
            'content' => 'Content',
            'title' => 'Title',
            'company' => 'Company',
            'response_message' => 'Response',
            'start_date' => 'Start date',
            'end_date' => 'End date',
            'status' => 'Status',
            'action' => 'Action',
            'pagination_search' => 'No results found',
            'pagination' => 'No data available',
            'detail_colab' => "Detail colaboration",
            "size" => "Size",
            "approve" => "Approve",
            "created_at" => "Send date",
            "feedback" => "Feedback",
            "feedback_content" => "Feedback content",
            "feedback_placeholder" => "Enter feedback!",
            "send" => "Send",
            "cancel" => "Cancel",
            "complete" => "Complete",
            "active" => "Active",
            "completed" => "Completed",
            "pending" => "Pending",
            "rejected" => "Rejected",
            "revoke_confirm" => "Are you sure you want to revoke this collaboration request?",
            "revoke" => "Revoke",
            "not_found" => "No feedback found",
            "university" => "University",
        ],
        'dashboard' => [
            'home' => 'Home',
            'university' => 'University',
            'statistical' => 'Statistical',
            'total_employees' => 'Total employees',
            'total_collaborations' => 'Total collaborations',
            'total_jobs_posted' => 'Total jobs posted',
            'total_collaborative_workshops' => 'Total collaborative workshops',
            'job_statistics' => 'Job statistics',
            'collaborative_university_workshop' => 'Statistics on the number of partnered schools and collaborative workshops',
            'job_matching_university' => ' Job matching statistics with schools',
            'job_received' => 'Job received by the school',
            'vacant_job.' => 'Vacant job',
        ],
        'hiring' => [
            'filter' => 'Filter',
            'title_search' => 'Full name / Email',
            'clear_filter' => 'Clear Filter',
            'action' => 'Actions',
            'join_date' => 'Join Date',
            'employee_list' => 'Employee List',
            'name' => 'Full Name',
            'image' => 'Image',
            'user_name' => 'User Name',
            'phone' => 'Phone',
            'create_at' => 'Create At',
            'create' => 'Create',
            'home' => 'Home',
            'add' => [
                'company' => 'Company',
                'create_employee' => 'Create Employee',
                'profile_employee' => 'Profile Employee',
                'name' => 'Full Name',
                'phone' => 'Phone',
                'image_employee' => 'Image Employee',
                'choose' => 'Chosse Image',
                'information_details' => 'Information Details',
                'user_name' => 'User Name',
                'password' => 'Password',
                'password_confirmation' => 'Confirm password',
                'back' => 'Back',
                'add_new' => 'Add new',
            ],
            'edit' => [
                'employee' => 'Employee',
                'update_employee' => 'Update Employee',
                'profile_employee' => 'Profile Employee',
                'name' => 'Full Name',
                'phone' => 'Phone',
                'image_employee' => 'Image Employee',
                'choose' => 'Chosse Image',
                'information_details' => 'Information Details',
                'user_name' => 'User Name',
                'back' => 'Back',
                'update' => 'Update',
            ]

        ]

    ],
    'university' => [
        'list' => 'List',
        'back' => 'Back',
        'add_new' => 'Create',
        'update' => 'Update',
        'home' => 'Home',
        'search' => 'Search',
        'filter' => 'Filter',
        'clear_filter' => 'Clear filter',
        'title_search' => 'Name / Email / Phone',
        'action' => 'Actions',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
        'delete_confirm' => 'Are you sure you want to delete?',
        'no_avatar' => 'No avatar found.',
        'student' => [
            'error' => 'Error',
            'title' => 'Manage student',
            'list_student' => 'List student',
            'download_template' => 'Download Sample Import File',
            'import' => 'Import student',
            'name' => 'Name',
            'avatar' => 'Avatar',
            'select_avatar' => 'Select avatar',
            'email' => 'Email',
            'phone' => 'Phone',
            'major' => 'Major',
            'select_major' => '--Select major--',
            'entry_year' => 'Entry year',
            'graduation_year' => 'Graduation year',
            'entry_graduation_year_range' => 'Entry year - Graduation year',
            'select_entry_graduation_year_range' => 'Select entry year - Graduation year',
            'create_student' => 'Create student',
            'information_student' => 'Information student',
            'detailed_information' => 'Detailed information',
            'male_gender' => 'Male',
            'female_gender' => 'Female',
            'gender' => 'Gender',
            'student_code' => 'Student code',
            'description' => 'Description',
            'edit_student' => 'Edit student',
            'no_data' => 'No students found.',
        ],
        'sidebar' => [
            'manager_student' => 'Manage student',
        ],

        'collaboration' => [
            'filter' => 'Filter',
            'reset' => 'Reset filter',
            'search_fields' => 'Search',
            'search_placeholder' => 'Search by name, company name',
            'date' => 'Start date - End date',
            'search_result' => 'Search results',
            'accept' => 'Accepted',
            'request' => 'Request',
            'reject' => 'Reject',
            'close' => 'Close',
            'content' => 'Content',
            'title' => 'Title',
            'company' => 'Company',
            'response_message' => 'Response',
            'start_date' => 'Start date',
            'end_date' => 'End date',
            'status' => 'Status',
            'action' => 'Action',
            'pagination_search' => 'No results found',
            'pagination' => 'No data available',
            'detail_colab' => "Detail colaboration",
            "size" => "Size",
            "approve" => "Approve",
            "created_at" => "Send date",
            "feedback" => "Feedback",
            "feedback_content" => "Feedback content",
            "feedback_placeholder" => "Enter feedback!",
            "send" => "Send",
            "cancel" => "Cancel",
            "complete" => "Complete",
            "active" => "Active",
            "completed" => "Completed",
            "pending" => "Pending",
            "rejected" => "Rejected",
            "revoke_confirm" => "Are you sure you want to revoke this collaboration request?",
            "revoke" => "Revoke",
            "not_found" => "No feedback found",
            "university" => "University",
        ],
    ],
];
