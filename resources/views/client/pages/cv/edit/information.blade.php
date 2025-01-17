@extends('client.layout.main')

@section('title', 'edit')

@section('content')
    <form action="{{ route('updateCv', $slug) }}" method="post" style="margin-top: 130px" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h1 class="mb-3">Thông tin cá nhân</h1>

        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input type="text" class="form-control" name="name" value="{{ $cv->name }}">
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Chức vụ</label>
            <input type="text" class="form-control" name="position" value="{{ $cv->position }}">
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" name="avatar">

            @if ($cv->avatar)
                @if (!\Str::contains($cv->avatar, 'http'))
                    <img src="{{ \Storage::url($cv->avatar) }}" width="100px">
                @else
                    <img src="{{ $cv->avatar }}" width="100px">
                @endif
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $cv->email }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="number" class="form-control" name="phone" value="{{ $cv->phone }}">
        </div>

        <div class="mb-3">
            <input type="radio" id="male" name="sex" value="male" @checked($cv->sex == 'male')>
            <label for="male">Nam</label><br>
            <input type="radio" id="female" name="sex" value="female" @checked($cv->sex == 'female')>
            <label for="female">Nữ</label><br>
        </div>

        <div class="mb-3">
            <label for="date_birth" class="form-label">Ngày sinh</label>
            <input type="text" class="form-control" name="date_birth" value="{{ $cv->date_birth }}">
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">Link</label>
            <input type="text" class="form-control" name="url" value="{{ $cv->url }}">
        </div>

        <div class="mb-3">
            <button class="btn btn-info">Lưu</button>
        </div>
    </form>
@endsection

@section('css')

@endsection

@section('js')

@endsection
