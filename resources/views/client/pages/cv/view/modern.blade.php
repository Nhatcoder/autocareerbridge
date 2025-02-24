<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $cv->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: {{ $cv->font }} !important;
            /* margin: 0;
            padding: 0;
            background-color: #eef1f5;
            color: #333; */
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

        .cv-container {
            width: 100%;
            background: white;
            overflow: hidden;
            position: relative;
            /* height: fit-content; */
            margin: 0 auto;
        }

        /* .cv-container {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        } */

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
            color: {{ $cv->color }};
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
            color: {{ $cv->color }};
            font-size: 18px;
            font-weight: 600;
        }

        .sidebar .skills {
            margin-top: 15px;
        }

        .sidebar .skills div {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar .skills span {
            background-color: #4b6584;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
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
            color: {{ $cv->color }};
        }

        .main h3 {
            font-size: 18px;
            margin-top: 20px;
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
    <div class="text-center my-3">
        <a href="{{ route('cv.download', $cv->id) }}" class="btn btn-success">Tải xuống</a>
    </div>
    <div class="cv-container" style="">
        <div class="main-container-modern">
            <div class="sidebar">
                <div class="section">
                    <div class="avatar-modern">
                        <img src="{{ $cv->avatar ?? asset('clients/images/content/base.png') }}" alt="Profile Picture">
                    </div>
                    <h1>{{ $cv->username }}</h1>
                    <p>{{ $cv->position }}</p>
                </div>
                <div class="section">
                    <h3>THÔNG TIN CÁ NHÂN</h3>
                    <p><i class="fas fa-phone"></i> {{ $cv->phone }}</p>
                    <p><i class="fas fa-envelope"></i> {{ $cv->email }}</p>
                    <p><i class="fas fa-birthday-cake"></i>
                        {{ \Carbon\Carbon::parse($cv->birthdate)->format('d/m/Y') }}
                    </p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $cv->address }}</p>
                </div>
                @if ($cv->educations->isNotEmpty())
                    <div class="section">
                        <h3>HỌC VẤN</h3>
                        @foreach ($cv->educations as $edu)
                            <strong style="font-size:16px;">{{ $edu->university_name }}</strong>
                            <p><span>{{ \Carbon\Carbon::parse($edu->start_date)->format('m/Y') }}</span> -
                                <span>{{ \Carbon\Carbon::parse($edu->end_date)->format('m/Y') }}</span>
                            </p>
                            <p>{{ $edu->major }}</p>
                            <p>Loại Tốt Nghiệp: <span>{{ $edu->type_graduate }}</span></p>
                        @endforeach
                    </div>
                @endif
                @if ($cv->cv_skill->isNotEmpty())
                    <div class="section">
                        <h3>KỸ NĂNG</h3>
                        @foreach ($cv->cv_skill as $skill)
                            <p style="white-space: pre-wrap;">{{ $skill->name }}</p>
                        @endforeach
                    </div>
                @endif
                @if ($cv->certificates->isNotEmpty())
                    <div class="section">
                        <h3>CHỨNG CHỈ</h3>
                        @foreach ($cv->certificates as $certificate)
                            <p id="certification-cv" style="white-space: pre-wrap;">{{ $certificate->description }}</p>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="main">
                @if (isset($cv->introduce))
                    <div class="section">
                        <h3>MỤC TIÊU NGHỀ NGHIỆP</h3>
                        <p id="cv-introduce" style="white-space: pre-wrap;">{{ $cv->introduce }}</p>
                    </div>
                @endif
                @if ($cv->experiences->isNotEmpty())
                    <div class="section">
                        <h3>KINH NGHIỆM LÀM VIỆC</h3>
                        @foreach ($cv->experiences as $experience)
                            <strong><span>{{ $experience->position }}</span> |
                                <span>{{ $experience->company_name }}</span></strong>
                            <p><span>{{ \Carbon\Carbon::parse($experience->start_date)->format('m/Y') }}</span> -
                                <span>{{ \Carbon\Carbon::parse($experience->end_date)->format('m/Y') }}</span>
                            </p>
                            <ul>
                                <li style="white-space: pre-wrap;">{{ $experience->description }}</li>
                            </ul>
                        @endforeach
                    </div>
                @endif
                @if ($cv->referrers->isNotEmpty())
                    <div class="section">
                        <h3>NGƯỜI GIỚI THIỆU</h3>
                        @foreach ($cv->referrers as $referrer)
                            <p>
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
        </div>
    </div>
</body>

</html>
