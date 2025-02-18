@extends('client.layout.main')
@section('content')
    <style>
        .container {
            display: flex;
            justify-content: center;
            margin-top: 120px;
        }

        .cv-container-my-cv {
            width: 1000px;
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
            <a href="{{ route('listCv') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tạo CV mới
            </a>
            <div class="row">
                @forelse ($cvs as $cv)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100" style="height: 420px;">
                            <img src="{{ asset('clients/images/cv/' . $cv->template . '.png') }}" class="card-img-top"
                                alt="Mẫu CV {{ $cv->title }}" height="300px">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $cv->title }}</h5>
                                    <p class="card-text"><small class="text-muted">Ngày tạo:
                                            {{ \Carbon\Carbon::parse($cv->created_at)->format('d/m/Y') }}
                                        </small></p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('cv.edit', ['id' => $cv->id]) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="{{ route('cv.view', ['id' => $cv->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <a href="{{ route('cv.download', ['id' => $cv->id]) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Tải xuống
                                    </a>
                                    <form action="{{ route('cv.delete', ['id' => $cv->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Xác nhận xóa?')">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div
                            style="max-width: 600px; margin: 0 auto; height: 200px; display: inline-block; text-align: center;">
                            <p class="m-0">Bạn chưa tạo CV nào!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
