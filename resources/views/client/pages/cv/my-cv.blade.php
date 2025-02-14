@extends('client.layout.main')
@section('content')
    <style>
        .cv-container-my-cv {
            max-width: 1000px;
            margin-top: 140px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
    </style>
    <div class="container">
        <div class="cv-container-my-cv">
            <h2 class="mb-4">Danh sách CV của bạn</h2>
            <a href="{{ route('listCv') }}" class="btn btn-primary mb-3">Tạo CV mới</a>
            <div class="row">
                @foreach ($cvs as $cv)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="{{ asset('clients/images/cv/' . $cv->template . '.png') }}" class="card-img-top"
                                alt="Mẫu CV {{ $cv->title }}" height="300px">
                            <div class="card-body">
                                <h5 class="card-title">{{ $cv->title }}</h5>
                                <p class="card-text"><small class="text-muted">Ngày tạo:
                                        {{ \Carbon\Carbon::parse($cv->created_at)->format('d/m/Y') }}
                                    </small></p>
                                <a href="{{ route('cv.edit', ['id' => $cv->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="{{ route('cv.view', ['id' => $cv->id]) }}" class="btn btn-primary btn-sm">Xem</a>
                                <a href="{{ route('cv.download', ['id' => $cv->id]) }}" class="btn btn-success btn-sm">Tải
                                    xuống</a>
                                <form action="" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
