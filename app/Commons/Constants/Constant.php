<?php
define('ROLE_ADMIN', 1);
define('ROLE_COMPANY', 2);
define('ROLE_UNIVERSITY', 3);
define('ROLE_HIRING', 4);
define('ROLE_SUB_ADMIN', 5);
define('ROLE_SUB_UNIVERSITY', 6);
define('ROLE_USER', 7);

define('ACTIVE', 1);
define('INACTIVE', 2);

define('LIMIT_10', 10);

define('MALE_GENDER', 1);
define('FEMALE_GENDER', 0);

define('SEEN', 1);
define('UNSEEN', 0);

define('PAGINATE_CHATMESSAGE', 25);
define('PAGINATE_WORKSHOP', 10);
define('PAGINATE_WORKSHOP_CLIENT', 12);
define('PAGINATE_JOB', 10);
define('PAGINATE_COLLAB', 10);
define('PAGINATE_LIST_COMPANY', 10);
define('PAGINATE_FIELD', 10);
define('PAGINATE_MAJOR', 10);
define('PAGINATE_LIST_COMPANY_CLIENT', 6);
define('PAGINATE_DETAIL_JOB_UNIVERSITY', 5);

define('STATUS_PENDING', 1);
define('STATUS_APPROVED', 2);
define('STATUS_REJECTED', 3);
define('STATUS_COMPLETE', 4);

define('GREATER_THAN', '>');
define('MAX_PROGRESS_STEPS', 100);

define('TYPE_COMPANY', 1);
define('TYPE_UNIVERSITY', 2);
define('TYPE_JOB', 3);
define('TYPE_COLLABORATION', 4);
define('TYPE_WORKSHOPS', 5);

define('GREATER_THAN_OR_EQUAL', '>=');
define('LESS_THAN_OR_EQUAL', '<=');

define('TYPE_IMAGE', 1);
define('TYPE_FILE', 2);

define('NAME_COMPANY', 'NTD');

define('REGEX_EMAIL', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
define('REGEX_PASSWORD', "/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/");

define('TYPE_CV_CREATE', 0);
define('TYPE_CV_UPLOAD', 1);

define('TYPE_SCHEDULE_OFF', 1);
define('TYPE_SCHEDULE_ON', 2);

define('SAVE', 0);
define('UN_SAVE', 1);

define('STATUS_W_EVAL', 1);
define('STATUS_FIT', 2);
define('STATUS_INTERV', 3);
define('STATUS_HIRED', 4);
define('STATUS_UNFIT', 5);

define('COMPANY', 'company');
define('USER', 'user');

define('STATUS_NOT_INVITE',0);
define('STATUS_WAIT', 1);
define('STATUS_JOIN', 2);
define('STATUS_UN_JOIN', 3);
