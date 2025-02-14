<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef1f5;
            color: #333;
        }

        .main-container-modern {
            display: flex;
            background-color: #fff;
            align-items: stretch;
            min-height: 1123px;
        }

        .sidebar {
            background-color: #2b3f6c;
            color: #fff;
            padding: 30px 20px;
            width: 35%;
            box-sizing: border-box;
        }

        .sidebar h1 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .sidebar p {
            margin: 10px 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .sidebar .section {
            margin-top: 30px;
            font-size: 18px;
            font-weight: 500;
            border-bottom: 2px solid #ccd4e3;
            padding-bottom: 5px;
        }

        .sidebar .section h3 {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
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
            width: 65%;
            box-sizing: border-box;
        }

        .main h3 {
            font-size: 18px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .main ul {
            padding-left: 20px;
            list-style-type: disc;
        }

        .main p,
        li {
            font-size: 14px;
            color: #000;
        }

        .main ul li {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .avatar-modern {
            text-align: center;
            margin-bottom: 30px;
        }

        .avatar-modern img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="main-container-modern">
        <div class="sidebar">
            <div class="section header">
                <div class="avatar-modern">
                    <img src="https://placehold.co/400" alt="Profile Picture" id="cvAvatarPreview">
                </div>
                <h1 id="cv-name"></h1>
                <p id="cv-position"></p>
            </div>
            <div class="section">
                <h3>THÔNG TIN CÁ NHÂN</h3>
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

            <div class="section"style="display: none;">
                <h3>KỸ NĂNG</h3>
                <p id="cv-skill" style="white-space: pre-wrap;"></p>
            </div>
            <div class="section" style="display: none;">
                <h3>CHỨNG CHỈ</h3>
                <p id="certification-cv" style="white-space: pre-wrap;"></p>
            </div>
        </div>

        <div class="main">
            <div class="section">
                <h3>MỤC TIÊU NGHỀ NGHIỆP</h3>
                <p id="cv-introduce" style="white-space: pre-wrap;"></p>
            </div>

            <div class="section" style="display: none;">
                <h3>KINH NGHIỆM LÀM VIỆC</h3>
                <div id="work-experience-cv"></div>
            </div>
            <div class="section" style="display: none;">
                <h3>NGƯỜI GIỚI THIỆU</h3>
                <p id="cv-personal-introduce"></p>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    // change style
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

    function previewAvatar(event) {
        const avatarPreview = document.getElementById('avatarPreview');
        const cvAvatarPreview = document.getElementById('cvAvatarPreview');
        const file = event.target.files[0];

        if (file) {
            const imageUrl = URL.createObjectURL(file);
            avatarPreview.src = imageUrl;
            cvAvatarPreview.src = imageUrl;
        }
    }

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


    // experience
    document.getElementById("add-work-experience-button").addEventListener("click", function() {
        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');

        const sectionId = `exp-${Date.now()}`;
        newSection.innerHTML = /*html*/ `
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger cursor-pointer delete-work-experience-button">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên Công Ty</label>
                        <input type="text" class="form-control company-input" name="company_name[]" placeholder="Công ty JVB" data-target="#${sectionId}-company">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Vị Trí</label>
                        <input type="text" class="form-control position-input" name="position[]" placeholder="Chức vụ" data-target="#${sectionId}-position">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thời Gian Bắt Đầu</label>
                        <input type="month" class="form-control start-date-input" name="start_date_exp[]" data-target="#${sectionId}-start-date">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thời Gian Kết Thúc</label>
                        <input type="month" class="form-control end-date-input" name="end_date_exp[]" data-target="#${sectionId}-end-date">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô Tả Công Việc</label>
                <textarea class="form-control description-input" rows="4" name="description[]" placeholder="Mô tả công việc" data-target="#${sectionId}-description"></textarea>
            </div>
        `;

        document.getElementById("work-experience-container").appendChild(newSection);

        const workExperienceCV = document.getElementById("work-experience-cv");
        const cvEntry = document.createElement('div');
        cvEntry.id = sectionId;
        cvEntry.innerHTML = /*html*/ `
            <strong><span id="${sectionId}-position">Chức vụ</span> | <span id="${sectionId}-company">Tên công ty</span></strong>
            <p><span id="${sectionId}-start-date">Bắt đầu</span> - <span id="${sectionId}-end-date">Kết thúc</span></p>
            <ul>
                <li id="${sectionId}-description">
                    Mô tả công việc
                </li>
            </ul>
        `;

        workExperienceCV.appendChild(cvEntry);

        const section = workExperienceCV.closest('.section');
        section.style.display = "block";


        newSection.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target) {
                    if (this.type === "month") {
                        const [year, month] = this.value.split("-");
                        const monthYear = year && month ? `${month}/${year}` : "Tháng/Năm";
                        target.textContent = monthYear;
                    } else {
                        target.textContent = this.value || this.placeholder;
                    }
                }
            });
        });

        newSection.querySelector('.delete-work-experience-button').addEventListener('click', function() {
            newSection.remove();
            cvEntry.remove();

            if (workExperienceCV.children.length === 0) {
                section.style.display = "none";
            }
        });


    });

    // education
    document.getElementById("show-education-form-button").addEventListener("click", function() {
        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');

        const sectionId = `education-section-${Date.now()}`;
        newSection.innerHTML = /*html*/ `
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-danger cursor-pointer delete-education-button">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên Trường</label>
                    <input type="text" class="form-control school-input" placeholder="Đại học FPT" name="school[]" data-target="#${sectionId}-school">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Chuyên Ngành</label>
                    <input type="text" class="form-control major-input" placeholder="Chuyên ngành" name="major[]" data-target="#${sectionId}-major">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Loại Tốt Nghiệp</label>
                    <input type="text" class="form-control degree-input" placeholder="Tốt, khá" name="degree[]" data-target="#${sectionId}-degree">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Thời Gian Bắt Đầu</label>
                    <input type="month" class="form-control start-date-input" data-target="#${sectionId}-start-date" name="start_date_education[]">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Thời Gian Kết Thúc</label>
                    <input type="month" class="form-control end-date-input" data-target="#${sectionId}-end-date" name="end_date_education[]">
                    <small class="text-danger error-message"></small>
                </div>
            </div>
        </div>
        `;

        document.getElementById("education-container").appendChild(newSection);

        const educationCV = document.getElementById("education-cv");
        const cvEntry = document.createElement('div');
        cvEntry.id = sectionId;
        cvEntry.innerHTML = /*html*/ `
            <p><strong id="${sectionId}-school">Tên trường</strong></p>
            <p><span id="${sectionId}-start-date">Bắt đầu</span> - <span id="${sectionId}-end-date">Kết thúc</span></p>
            <p id="${sectionId}-major">Chuyên ngành</p>
            <p>Loại Tốt Nghiệp: <span id="${sectionId}-degree">Tốt</span></p>
        `;

        educationCV.appendChild(cvEntry);

        const section = educationCV.closest('.section');
        section.style.display = "block";

        // Lắng nghe sự kiện thay đổi giá trị của các input
        newSection.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target) {
                    if (this.type === "month") {
                        const [year, month] = this.value.split("-");
                        const monthYear = month && year ? `${month}/${year}` : "Tháng/Năm";
                        target.textContent = monthYear;
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
                section.style.display = "none";
            }
        });
    });

    // skill
    document.getElementById("skills").addEventListener("input", function() {
        const cvSkill = document.getElementById("cv-skill");
        const sectionHeader = cvSkill.closest('.section');

        if (this.value.trim() !== "") {
            sectionHeader.style.display = "block";
            cvSkill.textContent = this.value;
        } else {
            sectionHeader.style.display = "none";
            cvSkill.textContent = "";
        }
    });

    // certificate
    document.getElementById("certifications").addEventListener("input", function() {
        const certificationCV = document.getElementById("certification-cv");
        const section = certificationCV.closest('.section');

        if (this.value.trim() !== "") {
            section.style.display = "block";
            certificationCV.textContent = this.value;
        } else {
            section.style.display = "none";
            certificationCV.textContent = "";
        }
    });

    // personal introduce
    document.getElementById("show-personal-introduce").addEventListener("click", function() {
        const sectionId = `personal-introduce-${Date.now()}`;
        const newSection = document.createElement('div');
        newSection.classList.add('input-section', 'd-flex', 'flex-column', 'mb-3');

        newSection.innerHTML = /*html*/ `
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger cursor-pointer delete-personal-introduce-button">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên người liên hệ</label>
                        <input type="text" class="form-control" placeholder="Khánh Nguyên" name="contact_name[]" data-target="#${sectionId}-name">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên công ty</label>
                        <input type="text" class="form-control" placeholder="Công ty ABC" name="contact_company_name[]" data-target="#${sectionId}-company">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Chức vụ</label>
                        <input type="text" class="form-control" placeholder="Chức vụ" name="contact_position[]" data-target="#${sectionId}-position">
                        <small class="text-danger error-message"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" placeholder="0123456789" name="contact_phone[]" data-target="#${sectionId}-phone">
                        <small class="text-danger error-message"></small>
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
                <p id="${sectionId}-name">Tên người liên hệ</p>
                <p id="${sectionId}-company">Tên công ty</p>
                <p id="${sectionId}-position">Chức vụ</p>
                <p id="${sectionId}-phone">Số điện thoại</p>
            </div>
        `;
        cvContainer.appendChild(cvEntry);

        const section = cvContainer.closest('.section');
        section.style.display = "block";

        // Lắng nghe sự kiện nhập liệu
        newSection.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target) {
                    target.textContent = this.value || this.placeholder;
                }
            });
        });

        newSection.querySelector('.delete-personal-introduce-button').addEventListener('click', function() {
            newSection.remove();
            cvEntry.remove();

            if (cvContainer.children.length === 0) {
                section.style.display = "none";
            }
        });
    });
</script>
