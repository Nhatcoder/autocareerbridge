<html>

<head>
    <style>
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
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Vị Trí</label>
                        <input type="text" class="form-control position-input" name="position[]" value="${data.position || ''}" data-target="#${sectionId}-position">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thời Gian Bắt Đầu</label>
                        <input type="month" class="form-control start-date-input" name="start_date_exp[]" value="${data.start_date || ''}" data-target="#${sectionId}-start-date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thời Gian Kết Thúc</label>
                        <input type="month" class="form-control end-date-input" name="end_date_exp[]" value="${data.end_date || ''}" data-target="#${sectionId}-end-date">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô Tả Công Việc</label>
                <textarea class="form-control description-input" rows="4" name="description[]" data-target="#${sectionId}-description">${data.description || ''}</textarea>
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

    function createEducationSection(data = {}, isFromAPI = false) {
        console.log(data);
        const sectionId = `education-section-${Date.now()}`;
        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');

        newSection.innerHTML = /*html*/ `
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-danger cursor-pointer delete-education-button">
                <i class="fas fa-trash"></i>
            </button>
        </div>
            <input type="hidden" name="education_id[]" value="${data.id || ''}">

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên Trường</label>
                    <input type="text" class="form-control school-input" value="${data.university_name || ''}" name="school[]" data-target="#${sectionId}-school">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Chuyên Ngành</label>
                    <input type="text" class="form-control major-input" value="${data.major || ''}" name="major[]" data-target="#${sectionId}-major">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Loại Tốt Nghiệp</label>
                    <input type="text" class="form-control degree-input" placeholder="Tốt, khá..." value="${data.type_graduate || ''}" name="degree[]" data-target="#${sectionId}-degree">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Thời Gian Bắt Đầu</label>
                    <input type="month" class="form-control start-date-input" value="${data.start_date || ''}" name="start_date_education[]" data-target="#${sectionId}-start-date">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Thời Gian Kết Thúc</label>
                    <input type="month" class="form-control end-date-input" value="${data.end_date || ''}" name="end_date_education[]" data-target="#${sectionId}-end-date">
                </div>
            </div>
        </div>
         `;

        document.getElementById("education-container").appendChild(newSection);

        const educationCV = document.getElementById("education-cv");
        const cvEntry = document.createElement('div');
        cvEntry.id = sectionId;
        cvEntry.innerHTML = /*html*/ `
        <p class="text-uppercase"><strong id="${sectionId}-school">${data.university_name || 'Tên Trường'}</strong></p>
        <li id="${sectionId}-major">${data.major || 'Chuyên Ngành'}</li>
        <li>
            <span id="${sectionId}-start-date">${data.start_date ? formatDate(data.start_date) : 'Bắt đầu'}</span> -
            <span id="${sectionId}-end-date">${data.end_date ? formatDate(data.end_date) : 'Kết thúc'}</span>
        </li>
        <li>Loại tốt nghiệp: <span id="${sectionId}-degree">${data.type_graduate || 'Loại Tốt Nghiệp'}</span></li>

         `;
        educationCV.appendChild(cvEntry);

        if (educationCV.children.length > 0) {
            educationCV.closest('.section').style.display = "block";
        }

        newSection.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target) {
                    if (this.type === "month") {
                        const [year, month] = this.value.split("-");
                        target.textContent = month && year ? `${month}/${year}` : "Tháng/Năm";
                    } else {
                        target.textContent = this.value || this.placeholder;
                    }
                }
            });
        });

        newSection.querySelector('.delete-education-button').addEventListener('click', function() {
            newSection.remove();
            cvEntry.remove();
            if (educationCV.children.length === 0) {
                educationCV.closest('.section').style.display = "none";
            }
        });

        if (isFromAPI) {
            newSection.querySelectorAll('input').forEach(input => input.dispatchEvent(new Event('input')));
        }
    }

    function formatDate(dateString) {
        if (!dateString) return "Tháng/Năm";
        const [year, month] = dateString.split("-");
        return `${month}/${year}`;
    }

    document.getElementById("show-education-form-button").addEventListener("click", function() {
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
                        const formattedDate =
                            `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
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

    function createReferrerSection(data = {}, isFromAPI = false) {
        const sectionId = `personal-introduce-${Date.now()}`;
        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');

        newSection.innerHTML = /*html*/ `
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger cursor-pointer delete-personal-introduce-button">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <input type="hidden" name="referrer_id[]" value="${data.id || ''}">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên người liên hệ</label>
                        <input type="text" class="form-control" placeholder="Khánh Nguyên" name="contact_name[]" value="${data.name || ''}" data-target="#${sectionId}-name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên công ty</label>
                        <input type="text" class="form-control" placeholder="Công ty ABC" name="contact_company_name[]" value="${data.company_name || ''}" data-target="#${sectionId}-company">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Chức vụ</label>
                        <input type="text" class="form-control" placeholder="Chức vụ" name="contact_position[]" value="${data.position || ''}" data-target="#${sectionId}-position">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" placeholder="0123456789" name="contact_phone[]" value="${data.phone || ''}" required data-target="#${sectionId}-phone">
                    </div>
                </div>
            </div>
            `;

        const parentContainer = document.getElementById("personal-introduce");
        parentContainer.appendChild(newSection);

        const cvContainer = document.getElementById("cv-personal-introduce");
        const cvEntry = document.createElement('div');
        cvEntry.id = sectionId;
        cvEntry.innerHTML = /*html*/ `
            <div class="referrer-cv mt-2">
                <p id="${sectionId}-name">${data.name || 'Tên người liên hệ'}</p>
                <p id="${sectionId}-company">${data.company_name || 'Tên công ty'}</p>
                <p id="${sectionId}-position">${data.position || 'Chức vụ'}</p>
                <p id="${sectionId}-phone">${data.phone || 'Số điện thoại'}</p>
            </div>
        `;
        cvContainer.appendChild(cvEntry);

        const section = cvContainer.closest('.section');
        section.style.display = "block";

        // Lắng nghe sự kiện nhập liệu
        newSection.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute(
                    'data-target'));
                if (target) {
                    target.textContent = this.value || this.placeholder;
                }
            });
        });

        newSection.querySelector('.delete-personal-introduce-button').addEventListener('click',
            function() {
                newSection.remove();
                cvEntry.remove();

                if (cvContainer.children.length === 0) {
                    section.style.display = "none";
                }
            });
    }

    document.getElementById("show-personal-introduce").addEventListener("click", function() {
        createReferrerSection({});
    });
</script>
