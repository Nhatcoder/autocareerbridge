@extends('management.layout.main')

@section('title', __('label.admin.user.edit_account'))

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-titles">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.users.index') }}">{{ __('label.admin.user.account') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('label.admin.user.edit_account') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="clearfix">
                        <div class="card card-bx profile-card author-profile m-b30">
                            <div class="card-header">
                                <h6 class="card-title">{{ __('label.admin.user.information_account') }}</h6>
                            </div>
                            <div class="card-footer">
                                <div class="row text-start">
                                    <div class="col-sm-12 m-b30">
                                        <label class="form-label">{{ __('label.admin.user.user_name') }} <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                            placeholder="{{ __('label.admin.user.user_name') }}" name="user_name"
                                            value="{{ $user->user_name }}">
                                        @error('user_name')
                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 m-b30">
                                        <label class="form-label">{{ __('label.admin.user.current_password') }}<span
                                                class="text-danger">(*)</span></label>
                                        <input type="password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            placeholder="{{ __('label.admin.user.current_password') }}"
                                            name="old_password">
                                        @error('old_password')
                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 m-b30">
                                        <label class="form-label">{{ __('label.admin.user.new_password') }}<span
                                                class="text-danger">(*)</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            placeholder="{{ __('label.admin.user.new_password') }}" name="password">
                                        @error('password')
                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 m-b30">
                                        <label class="form-label"
                                            for="password-confirm">{{ __('label.admin.user.confirm_password') }}<span
                                                class="text-danger">(*)</span></label>
                                        <input type="password" id="password-confirm"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="{{ __('label.admin.user.confirm_password') }}"
                                            autocomplete="new-password" name="password_confirmation">
                                        @error('password_confirmation')
                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="card profile-card card-bx m-b30">
                        <div class="card-header">
                            <h6 class="card-title">{{ __('label.admin.user.detailed_information') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 m-b30">
                                    <div class="form-check form-switch form-switch" dir="ltr">
                                        <input type="checkbox" class="form-check-input" id="customSwitch"
                                            {{ $user->active == ACTIVE ? 'checked' : '' }} width="48px" height="24px"
                                            name="active">
                                        <label class="form-check-label"
                                            for="customSwitchsizelg">{{ __('label.admin.user.active') }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 m-b30">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="admin@gmail.com" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="col-sm-12 m-b30 cm-content-body form excerpt">
                                    <label class="form-label">{{ __('label.admin.user.role') }}</label><br>
                                    @if ($user->role == ROLE_SUB_ADMIN)
                                        <span class="badge bg-info">{{ __('label.admin.user.sub_admin') }}</span>
                                    @elseif($user->role == ROLE_UNIVERSITY)
                                        <span class="badge bg-secondary">{{ __('label.admin.user.university') }}</span>
                                    @elseif($user->role == ROLE_COMPANY)
                                        <span class="badge bg-warning">{{ __('label.admin.user.company') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.users.index') }}"
                                class="btn btn-light">{{ __('label.admin.back') }}</a>
                            <button class="btn btn-primary" type="submit">{{ __('label.admin.update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection
