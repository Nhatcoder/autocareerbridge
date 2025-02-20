<html>

<head>
    <style>
        .cv-container p,
        li {
            font-size: 14px;
            color: #000;
        }

        .header {
            background-color: #d3d3d3;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header h1 {
            margin: 0;
            margin-top: 20px;
            font-size: 30px;
            font-family: {{ $cv->font }};
            color: {{ $cv->color }};
        }

        .header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .content {
            display: flex;
            padding: 20px;
        }

        .left-section {
            width: 35%;
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }

        .right-section {
            width: 65%;
            padding-left: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .input-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section h3 {
            font-size: 18px;
            color: {{ $cv->color }};
            margin-bottom: 10px;
            font-weight: 600;
            font-family: {{ $cv->font }};
        }

        .referrer-cv {
            display: flex;
            flex-direction: column;
        }

        .referrer-cv p {
            padding-left: 15px;
            position: relative;
            line-height: 1.1;
        }

        .referrer-cv p:first-child::before {
            content: "•";
            position: absolute;
            left: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h1 class="text-uppercase" class="mb-2" id="cv-name"></h1>
            <p id="cv-position"></p>
        </div>
        <img src="https://placehold.co/400" alt="Profile Picture" id="cvAvatarPreview">
    </div>
    <div class="content">
        <div class="left-section">
            <div class="section">
                <h3>LIÊN HỆ</h3>
                <p><i class="fas fa-phone"></i> <span id="cv-phone"></span></p>
                <p><i class="fas fa-envelope"></i> <span id="cv-email"></span></p>
                <p><i class="fas fa-birthday-cake"></i> <span id="cv-birthdate"></span></p>
                <p><i class="fas fa-map-marker-alt"></i> <span id="cv-address"></span></p>
            </div>
            <div class="section" style="display: none;">
                <h3>HỌC VẤN</h3>
                <div id="education-cv">
                </div>
            </div>
            <div class="section" style="display: none;">
                <h3>KỸ NĂNG</h3>
                <p id="cv-skill" style="white-space: pre-wrap;"></p>
            </div>
            <div class="section" style="display: none;">
                <h3>NGƯỜI GIỚI THIỆU</h3>
                <p id="cv-personal-introduce"></p>
            </div>
        </div>

        <div class="right-section">
            <div class="section" style="display: none;">
                <h3>MỤC TIÊU NGHỀ NGHIỆP</h3>
                <p id="cv-introduce" style="white-space: pre-wrap;"></p>
            </div>
            <div class="section" style="display: none;">
                <h3>KINH NGHIỆM LÀM VIỆC</h3>
                <div id="work-experience-cv"></div>
            </div>
            <div class="section" style="display: none;">
                <h3>CHỨNG CHỈ</h3>
                <p id="certification-cv" style="white-space: pre-wrap;"></p>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('cv-color').addEventListener('input', function() {
            let color = this.value;
            document.querySelectorAll('.section h3').forEach(el => el.style.color = color);
            document.querySelector('.header h1').style.color = color;
        });
        document.getElementById('cv-font').addEventListener('change', function() {
            let font = this.value;
            document.querySelector('.cv-container').style.fontFamily = font;
            document.querySelectorAll('.section h3').forEach(el => el.style.fontFamily = font);
            document.querySelector('.header h1').style.fontFamily = font;
        });
    });



    const avatarPreview = document.getElementById('avatarPreview');
    const cvAvatarPreview = document.getElementById('cvAvatarPreview');

    if (avatarPreview.src) {
        cvAvatarPreview.src = avatarPreview.src;
    }

    document.getElementById('avatar').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
                cvAvatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const path = window.location.pathname;
        const segments = path.split("/");
        const cvId = segments[2];

        if (!cvId || isNaN(cvId)) {
            console.error("Không tìm thấy CV hợp lệ");
            return;
        }

        fetchCvData(cvId);
    });

    function fetchCvData(cvId) {
        fetch(`/api/cv/${cvId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data.cv);
                if (data.cv) {
                    if (data.cv.experiences && data.cv.experiences.length > 0) {
                        data.cv.experiences.forEach(exp => createWorkExperienceSection(exp, true));
                    } else {
                        document.getElementById("work-experience-container").style.display = "none";
                    }

                    if (data.cv.educations && data.cv.educations.length > 0) {
                        data.cv.educations.forEach(edu => createEducationSection(edu, true));
                    } else {
                        document.getElementById("education-container").style.display = "none";
                    }

                    if (data.cv.referrers && data.cv.referrers.length > 0) {
                        data.cv.referrers.forEach(edu => createReferrerSection(edu, true));
                    } else {
                        document.getElementById("personal-introduce").style.display = "none";
                    }


                }
            })
            .catch(error => console.error("Lỗi khi fetch dữ liệu CV:", error));
    }

    // experience

    const workExperienceContainer = document.getElementById("work-experience-container");
    const workExperienceCV = document.getElementById("work-experience-cv");
    const addButton = document.getElementById("add-work-experience-button");

    function createWorkExperienceSection(data = {}, isInitialLoad = false) {
        console.log(data);
        const sectionId = `exp-${Date.now()}`;

        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');
        newSection.innerHTML = /*html*/ `
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger delete-work-experience-button">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <input type="hidden" name="experience_id[]" value="${data.id || ''}">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên Công Ty</label>
                        <input type="text" class="form-control company-input" name="company_name[]" value="${data.company_name || ''}" data-target="#${sectionId}-company">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Vị Trí</label>
                        <input type="text" class="form-control position-input" name="position[]" value="${data.position || ''}" data-target="#${sectionId}-position">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thời Gian Bắt Đầu</label>
                        <input type="month" class="form-control start-date-input" name="start_date_exp[]" value="${data.start_date || ''}" data-target="#${sectionId}-start-date">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thời Gian Kết Thúc</label>
                        <input type="month" class="form-control end-date-input" name="end_date_exp[]" value="${data.end_date || ''}" data-target="#${sectionId}-end-date">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô Tả Công Việc</label>
                <textarea class="form-control description-input" rows="4" name="description[]" data-target="#${sectionId}-description">${data.description || ''}</textarea>
                <small class="text-danger error-message"></small>
            </div>
        `;

        workExperienceContainer.appendChild(newSection);
        workExperienceContainer.style.display = "block";

        const cvEntry = document.createElement('div');
        cvEntry.id = sectionId;
        cvEntry.innerHTML = /*html*/ `
            <p><strong id="${sectionId}-position">${data.position || 'Chức vụ'}</strong></p>
            <p>
                <span id="${sectionId}-company">${data.company_name || 'Tên Công Ty'}</span> |
                <span id="${sectionId}-start-date">${data.start_date ? formatDate(data.start_date) : 'Bắt đầu'}</span> -
                <span id="${sectionId}-end-date">${data.end_date ? formatDate(data.end_date) : 'Kết thúc'}</span>
            </p>
            <ul>
                <li id="${sectionId}-description" style="white-space: pre-wrap;">${data.description || 'Mô Tả Công Việc'}</li>
            </ul>
        `;
        workExperienceCV.appendChild(cvEntry);
        const section = workExperienceCV.closest('.section');
        section.style.display = "block";

        newSection.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target) {
                    target.textContent = this.type === "month" ? formatDate(this.value) :
                        this.value || this.placeholder;
                }
            });
        });

        newSection.querySelector('.delete-work-experience-button').addEventListener('click', function() {
            newSection.remove();
            cvEntry.remove();
            if (workExperienceCV.children.length === 0) {
                workExperienceContainer.style.display = "none";
                section.style.display = "none";
            }
        });

        if (isInitialLoad) {
            updateCVDisplay(newSection);
        }
    }

    function formatDate(dateString) {
        if (!dateString) return "Tháng/Năm";
        const [year, month] = dateString.split("-");
        return `${month}/${year}`;
    }

    function updateCVDisplay(section) {
        section.querySelectorAll('input, textarea').forEach(input => {
            const target = document.querySelector(input.getAttribute('data-target'));
            if (target) {
                target.textContent = input.type === "month" ? formatDate(input.value) : input
                    .value || input.placeholder;
            }
        });
    }

    addButton.addEventListener("click", function() {
        createWorkExperienceSection({});
    });







    // education

    const educationContainer = document.getElementById("education-container");
    const educationCV = document.getElementById("education-cv");
    const addEducationButton = document.getElementById("show-education-form-button");

    function createEducationSection(data = {}, isInitialLoad = false) {
        const sectionId = `edu-${Date.now()}`;

        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');
        newSection.innerHTML = /*html*/ `
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-danger delete-education-button">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <input type="hidden" name="education_id[]" value="${data.id || ''}">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên Trường</label>
                    <input type="text" class="form-control school-input" name="school[]" value="${data.university_name || ''}" data-target="#${sectionId}-school">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Chuyên Ngành</label>
                    <input type="text" class="form-control major-input" name="major[]" value="${data.major || ''}" data-target="#${sectionId}-major">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Loại Tốt Nghiệp</label>
                    <input type="text" class="form-control degree-input" name="degree[]" value="${data.type_graduate || ''}" data-target="#${sectionId}-degree">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Thời Gian Bắt Đầu</label>
                    <input type="month" class="form-control start-date-input" name="start_date_education[]" value="${data.start_date || ''}" data-target="#${sectionId}-start-date">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Thời Gian Kết Thúc</label>
                    <input type="month" class="form-control end-date-input" name="end_date_education[]" value="${data.end_date || ''}" data-target="#${sectionId}-end-date">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
        </div>
        `;

        educationContainer.appendChild(newSection);
        educationContainer.style.display = "block";

        const cvEntry = document.createElement('div');
        cvEntry.id = sectionId;
        cvEntry.innerHTML = /*html*/ `
            <p><strong id="${sectionId}-school">${data.university_name || 'Tên Trường'}</strong></p>
            <p><span id="${sectionId}-major">${data.major || 'Chuyên Ngành'}</span></p>
            <p>
                <span id="${sectionId}-start-date">${data.start_date ? formatDate(data.start_date) : 'Bắt đầu'}</span> -
                <span id="${sectionId}-end-date">${data.end_date ? formatDate(data.end_date) : 'Kết thúc'}</span>
            </p>
            <p>Loại tốt nghiệp: <span id="${sectionId}-degree">${data.type_graduate || 'Loại Tốt Nghiệp'}</span></p>
        `;
        educationCV.appendChild(cvEntry);
        const section = educationCV.closest('.section');
        section.style.display = "block";

        // Xử lý cập nhật CV khi nhập liệu
        newSection.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target) {
                    target.textContent = this.type === "month" ? formatDate(this.value) : this.value ||
                        this.placeholder;
                }
            });
        });

        // Xử lý xóa form + xóa phần CV tương ứng
        newSection.querySelector('.delete-education-button').addEventListener('click', function() {
            newSection.remove();
            cvEntry.remove();
            if (educationCV.children.length === 0) {
                educationContainer.style.display = "none";
                section.style.display = "none";
            }
        });

        // Tự động cập nhật CV khi load từ API
        if (isInitialLoad) {
            updateEducationCVDisplay(newSection);
        }
    }

    function updateEducationCVDisplay(section) {
        section.querySelectorAll('input').forEach(input => {
            const target = document.querySelector(input.getAttribute('data-target'));
            if (target) {
                target.textContent = input.type === "month" ? formatDate(input.value) : input.value || input
                    .placeholder;
            }
        });
    }

    function formatDate(dateString) {
        if (!dateString) return "Tháng/Năm";
        const [year, month] = dateString.split("-");
        return `${month}/${year}`;
    }

    // Thêm mới học vấn khi nhấn nút
    addEducationButton.addEventListener("click", function() {
        createEducationSection({});
    });




    document.querySelectorAll('#name, #email, #birthdate, #position, #phone, #address, #introduce').forEach(
        input => {
            const targetId = `cv-${input.id}`;
            const target = document.getElementById(targetId);
            const section = target?.closest('.section');

            if (target) {
                target.textContent = input.placeholder;
            }

            input.addEventListener('input', function() {
                if (target) {
                    if (this.type === 'date' && this.value) {
                        const date = new Date(this.value);
                        const day = String(date.getDate()).padStart(2,
                            '0');
                        const month = String(date.getMonth() + 1).padStart(2,
                            '0');
                        const year = date.getFullYear();
                        const formattedDate = `${day}/${month}/${year}`;
                        target.textContent = formattedDate;
                    } else {
                        target.textContent = this.value || this.placeholder;
                    }
                }

                if (input.id === 'introduce' && section) {
                    if (this.value.trim()) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                }
            });

            input.dispatchEvent(new Event('input'));
        });


    document.addEventListener("DOMContentLoaded", function() {
        function updateSection(inputId, cvId) {
            const input = document.getElementById(inputId);
            const cvElement = document.getElementById(cvId);
            const section = cvElement.closest('.section');

            function updateContent() {
                if (input.value.trim() !== "") {
                    section.style.display = "block";
                    cvElement.textContent = input.value;
                } else {
                    section.style.display = "none";
                    cvElement.textContent = "";
                }
            }

            updateContent();

            input.addEventListener("input", updateContent);
        }

        updateSection("skills", "cv-skill");
        updateSection("certifications", "certification-cv");
    });



    // personal introduce

    const personalIntroduceContainer = document.getElementById("personal-introduce");
    const personalIntroduceCV = document.getElementById("cv-personal-introduce");
    const addPersonalIntroduceButton = document.getElementById("show-personal-introduce");

    function createReferrerSection(data = {}, isInitialLoad = false) {
        const sectionId = `personal-introduce-${Date.now()}`;

        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');
        newSection.innerHTML = /*html*/ `
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-danger delete-personal-introduce-button">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <input type="hidden" name="referrer_id[]" value="${data.id || ''}">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên người liên hệ</label>
                    <input type="text" class="form-control" name="contact_name[]" value="${data.name || ''}" data-target="#${sectionId}-name" placeholder="Khánh Nguyên">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên công ty</label>
                    <input type="text" class="form-control" name="contact_company_name[]" value="${data.company_name || ''}" data-target="#${sectionId}-company" placeholder="Công ty ABC">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Chức vụ</label>
                    <input type="text" class="form-control" name="contact_position[]" value="${data.position || ''}" data-target="#${sectionId}-position" placeholder="Chức vụ">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="contact_phone[]" value="${data.phone || ''}" data-target="#${sectionId}-phone" placeholder="0123456789" required>
                    <small class="text-danger error-message"></small>
                </div>
            </div>
        </div>
        `;

        personalIntroduceContainer.appendChild(newSection);
        personalIntroduceContainer.style.display = "block";

        const cvEntry = document.createElement('div');
        cvEntry.id = sectionId;
        cvEntry.classList.add('referrer-cv', 'mt-2');
        cvEntry.innerHTML = /*html*/ `
            <p id="${sectionId}-name">${data.name || 'Tên người liên hệ'}</p>
            <p id="${sectionId}-company">${data.company_name || 'Tên công ty'}</p>
            <p id="${sectionId}-position">${data.position || 'Chức vụ'}</p>
            <p id="${sectionId}-phone">${data.phone || 'Số điện thoại'}</p>
        `;
        personalIntroduceCV.appendChild(cvEntry);
        const section = personalIntroduceCV.closest('.section');
        section.style.display = "block";

        // Cập nhật CV khi nhập liệu
        newSection.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target) {
                    target.textContent = this.value || this.placeholder;
                }
            });
        });

        // Xử lý nút xóa
        newSection.querySelector('.delete-personal-introduce-button').addEventListener('click', function() {
            newSection.remove();
            cvEntry.remove();

            if (personalIntroduceCV.children.length === 0) {
                personalIntroduceContainer.style.display = "none";
                section.style.display = "none";
            }
        });

        // Khi load từ API, cập nhật hiển thị luôn
        if (isInitialLoad) {
            updateReferrerCVDisplay(newSection);
        }
    }

    function updateReferrerCVDisplay(section) {
        section.querySelectorAll('input').forEach(input => {
            const target = document.querySelector(input.getAttribute('data-target'));
            if (target) {
                target.textContent = input.value || input.placeholder;
            }
        });
    }

    addPersonalIntroduceButton.addEventListener("click", function() {
        createReferrerSection({});
    });
</script>
