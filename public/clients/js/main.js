// CKEditor Configuration
CKEDITOR.config.versionCheck = false;
CKEDITOR.config.allowedContent = true;

$(document).ready(function () {
    $(".tinymce_editor_init").each(function () {
        var textareaID = $(this).attr("id");
        CKEDITOR.replace(textareaID, {
            // Loại bỏ các plugin không cần thiết để giao diện gọn hơn
            removePlugins: 'elementspath,save',

            // Thêm các plugin bổ sung để tăng tính năng
            extraPlugins: 'image,justify,colorbutton',

            // Tùy chỉnh thanh công cụ (toolbar)
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
                { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'document', items: ['Source'] }
            ],

            // Cấu hình file upload
            filebrowserUploadUrl: '/upload-handler-url', // URL xử lý upload file
            filebrowserUploadMethod: 'form',

            // Tắt đường dẫn phần tử ở góc dưới
            removeButtons: 'Subscript,Superscript',

            // Chiều cao của trình chỉnh sửa
            height: 300
        });
    });


    function addImageCaption(img) {
        var altText = $(img).attr('alt');
        if (altText) {
            var caption = $('<div>', {
                'class': 'image-caption',
                'text': altText,
                'css': {
                    'text-align': 'center',
                    'font-style': 'italic'
                }
            });
            $(img).after(caption);
        }
    }

    CKEDITOR.on('instanceReady', function (evt) {
        var editor = evt.editor;
        $(document).on("click", ".cke_dialog_ui_button_ok", function () {
            setTimeout(function () {
                var images = $(editor.document.$).find('img');
                images.each(function () {
                    if (!$(this).next().hasClass('image-caption')) {
                        addImageCaption(this);
                    }
                });
            }, 100);
        });
    });
});


// avatar user
// Hàm tạo màu HEX ngẫu nhiên
function getRandomColor() {
    return '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
}
// Lấy chữ cái đầu tiên từ tên
const avatarElement = document.getElementById("avatar");
if (avatarElement) {
    const name = avatarElement.dataset.avatar
    const firstLetter = name.charAt(0);
    avatarElement.textContent = firstLetter;

    avatarElement.style.backgroundColor = getRandomColor();
}

// login with google
$('.btn_login_google').click(function (e) {
    e.preventDefault();
    $.ajax({
        url: e.target.href,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var width = 500;
            var height = 600;
            var left = (screen.width - width) / 2;
            var top = (screen.height - height) / 2;

            window.open(data.url, 'GoogleLoginPopup',
                `width=${width},height=${height},top=${top},left=${left},resizable=no,scrollbars=no,status=no`
            );
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
});

// Realtime notifycation
let notificationElement = $(".notification-list");
let idChanel = notificationElement.attr("data-id-chanel");
let countElement = $(".notification_count");
let role = notificationElement.attr("data-role");

Echo.private(`${role}.${idChanel}`).listen(
    "NotifyJobChangeStatusEvent",
    (e) => {
        if (e) {
            $(".no_notifycation").addClass("d-none");
            countElement.text(e.countNotificationUnSeen);
            countElement.removeClass("d-none");
            notificationElement.prepend(e.notification);
        }
    }
);

// Scroll the notification
let page = 1;
let noData = false;
notificationElement.on("scroll", function () {
    let scrollHeight = notificationElement.prop("scrollHeight");
    let clientHeight = notificationElement.prop("clientHeight");
    let scrollTop = notificationElement.prop("scrollTop");

    if (scrollTop + clientHeight >= scrollHeight && noData == false) {
        page++;
        loadMoreNotification(page);
    }
});

// Load data notifycationnotifycation
function loadMoreNotification(page) {
    $.ajax({
        url: `get-data-scroll-notifycation?` + 'page=' + page,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            if (data.length > 0) {
                let notifycation = data.map((item) => {
                    let isSeen = item.is_seen == 0 ? 'fw-bold' : 'fw-medium';
                    return `
                        <div key=${item.id}>
                            <div class="notification-item">
                                <div class="title ${isSeen}">${item.title}</div>
                                <div class="time">${item.created_at}</div>
                                <div class="is-seen ${item.is_seen == 1 ? '' : 'd-none'}">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                        </div>
                    `
                });
                notificationElement.append(notifycation);
            } else {
                noData = true;
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

// Seen notification
$(".notification-list").on("click", ".notification-item", function () {
    let id = $(this).attr("data-id");
    $.ajax({
        url: `${window.location.origin}/notifications/seen`,
        type: 'POST',
        data: {
            id: id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
});

