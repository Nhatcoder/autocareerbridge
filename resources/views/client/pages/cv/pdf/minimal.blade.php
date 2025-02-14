<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $cv->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <style>
        @page {
            margin: 0;
            padding: 0;
        }


        @media screen {
            .cv-container {
                max-width: 794px;
                height: 1123px;
                margin: 0 auto;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }
        }

        @media print {
            .cv-container {
                width: 100%;
                box-shadow: none;
            }
        }


        body {
            font-family: {{ $cv->font }} !important;
        }

        .cv-container {
            width: 100%;
            background: white;
            overflow: hidden;
            position: relative;
            /* height: fit-content; */
            margin: 0 auto;
        }

        .cv-container p,
        li {
            font-size: 14px;
            color: #000;
        }

        /* header cv */
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
            color: #e74c3c;
            margin-bottom: 10px;
            font-weight: 600;
            color: {{ $cv->color }};
        }

        /* referrer */

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
    <div class="cv-container" style="">
        <div class="header">
            <div>
                <h1 class="text-uppercase mb-2" id="cv-name" style="text-transform: uppercase">{{ $cv->username }}
                </h1>
                <p id="cv-position">{{ $cv->position }}</p>
            </div>
            <img src="{{ $cv->avatar ?? asset('clients/images/content/base.png') }}" alt="Profile Picture">

        </div>
        <div class="content">
            <div class="left-section">
                <div class="section">
                    <h3>LIÊN HỆ</h3>
                    <p><i class="fas fa-phone"></i> <span id="cv-phone">{{ $cv->phone }}</span></p>
                    <p><i class="fas fa-envelope"></i> <span id="cv-email"></span>{{ $cv->email }}</p>
                    <p><i class="fas fa-birthday-cake"></i>
                        <span id="cv-birthdate">{{ \Carbon\Carbon::parse($cv->birthdate)->format('d/m/Y') }}</span>
                    </p>
                    <p><i class="fas fa-map-marker-alt"></i> <span id="cv-address">{{ $cv->address }}</span></p>
                </div>
                @if (empty($cv->educations))
                    <div class="section">
                        <h3>HỌC VẤN</h3>
                        @foreach ($cv->educations as $edu)
                            <div id="education-cv">
                                <p class="text-uppercase"><strong>{{ $edu->university_name }}</strong></p>
                                <li>{{ $edu->major }}</li>
                                <li>
                                    <span>{{ \Carbon\Carbon::parse($edu->start_date)->format('m/Y') }}</span> -
                                    <span>{{ \Carbon\Carbon::parse($edu->end_date)->format('m/Y') }}</span>
                                </li>
                                <li>Loại tốt nghiệp: {{ $edu->type_graduate }}</li>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if (empty($cv->cv_skill))
                    <div class="section">
                        <h3>KỸ NĂNG</h3>
                        @foreach ($cv->cv_skill as $skill)
                            <p id="cv-skill" style="white-space: pre-wrap;">{{ $skill->name }}</p>
                        @endforeach
                    </div>
                @endif
                @if (empty($cv->referrers))
                    <div class="section">
                        <h3>NGƯỜI GIỚI THIỆU</h3>
                        @foreach ($cv->referrers as $referrer)
                            <p id="cv-personal-introduce">
                            <div class="referrer-cv mt-2">
                                <p>{{ $referrer->name }}</p>
                                <p>{{ $referrer->company_name }}</p>
                                <p>{{ $referrer->position }}</p>
                                <p>{{ $referrer->phone }}</p>
                            </div>
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="right-section">
                @if (isset($cv->introduce))
                    <div class="section">
                        <h3>MỤC TIÊU NGHỀ NGHIỆP</h3>
                        <p id="cv-introduce" style="white-space: pre-wrap;">{{ $cv->introduce }}</p>
                    </div>
                @endif
                @if (empty($cv->experiences))
                    <div class="section">
                        <h3>KINH NGHIỆM LÀM VIỆC</h3>
                        @foreach ($cv->experiences as $experience)
                            <div id="work-experience-cv">
                                <p><strong>{{ $experience->position }}</strong></p>
                                <p>
                                    <span>{{ $experience->company_name }}</span> |
                                    <span>{{ \Carbon\Carbon::parse($experience->start_date)->format('m/Y') }}</span> -
                                    <span>{{ \Carbon\Carbon::parse($experience->end_date)->format('m/Y') }}</span>
                                </p>
                                <ul style="list-style: none; padding-left: 0;">
                                    <li style="white-space: pre-wrap;">{{ $experience->description }}</li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if (empty($cv->certificates))
                    <div class="section">
                        <h3 style="text-transform: uppercase">Chứng chỉ</h3>
                        @foreach ($cv->certificates as $certificate)
                            <p id="certification-cv" style="white-space: pre-wrap;">{{ $certificate->description }}
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
