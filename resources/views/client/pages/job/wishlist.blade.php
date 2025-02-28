@extends('client.layout.main')
@section('title', 'Việc làm đã lưu')

@section('content')
    <div class="container" style="margin-top:120px">
        <div class="row">
            <h3 class="py-2">Việc làm đã lưu</h3>
            <p>Xem lại danh sách những việc làm mà bạn đã lưu trước đó. Ứng tuyển ngay để không bỏ lỡ cơ
                hội nghề nghiệp dành cho bạn.</p>
        </div>
    </div>
    <div class="jp_listing_sidebar_main_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="tab-content">
                                <div id="list" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            @if ($getJobs->count() > 0)
                                                @foreach ($getJobs as $getJob)
                                                    <div
                                                        class="jp_job_post_main_wrapper_cont jp_job_post_grid_main_wrapper_cont">
                                                        <div class="item">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div
                                                                        class="jp_job_post_main_wrapper_cont jp_job_post_grid_main_wrapper_cont">
                                                                        <div class="jp_job_post_main_wrapper">
                                                                            <div class="row">
                                                                                <div
                                                                                    class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                                    <a
                                                                                        href="{{ route('detailJob', ['slug' => $getJob->slug]) }}">
                                                                                        <div class="jp_job_post_side_img">
                                                                                            <img data-bs-toggle="tooltip"
                                                                                                title="{{ $getJob->company->name }}"
                                                                                                src="{{ isset($getJob->company->avatar_path) ? asset($getJob->company->avatar_path) : asset('management-assets/images/no-img-avatar.png') }}"
                                                                                                alt="post_img" />
                                                                                        </div>

                                                                                        <div
                                                                                            class="jp_job_post_right_cont jp_cl_job_cont">
                                                                                            <h4 data-bs-toggle="tooltip"
                                                                                                title="{{ ucwords($getJob->name) }}">
                                                                                                {{ Str::limit(ucwords($getJob->name), 45) }}
                                                                                            </h4>
                                                                                            <p style="color:#e69920;"
                                                                                                data-bs-toggle="tooltip"
                                                                                                title="{{ strtoupper($getJob->company->name) }}">
                                                                                                {{ strtoupper($getJob->company->name) }}
                                                                                            </p>
                                                                                        </div>
                                                                                        <div
                                                                                            class="jp_job_post_right_content d-flex align-items-center justify-content-between">
                                                                                            <ul>
                                                                                                <li data-bs-toggle="tooltip"
                                                                                                    title="{{ ucwords($getJob->company->addresses->first()->province->name) }}, {{ ucwords($getJob->company->addresses->first()->district->name) }}">
                                                                                                    <i class="fa-solid fa-location-dot"
                                                                                                        style="color: #ff5353;"></i>
                                                                                                    {{ ucwords($getJob->company->addresses->first()->province->name) }}
                                                                                                </li>
                                                                                            </ul>
                                                                                            <ul>
                                                                                                <li>
                                                                                                    Còn
                                                                                                    <strong>{{ Carbon\Carbon::parse($getJob->end_date)->startOfDay()->diffInDays(now()->startOfDay()) }}</strong>
                                                                                                    ngày để ứng
                                                                                                    tuyển
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </a>
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                                    <div class="jp_job_post_right_btn_wrapper"
                                                                                        style="align-items: center">
                                                                                        <ul>
                                                                                            @php
                                                                                                $wishlist = auth()->check()
                                                                                                    ? $getJob->wishlistByUsers
                                                                                                        ->where(
                                                                                                            'user_id',
                                                                                                            auth()->id(),
                                                                                                        )
                                                                                                        ->first()
                                                                                                    : null;
                                                                                            @endphp
                                                                                            <li><a data-job-id="{{ $getJob->id }}"
                                                                                                    class="btn btn-secondary text-white remove-wishlist"
                                                                                                    href="javascript:void(0)"><i
                                                                                                        class="fa-solid fa-trash me-2"></i>Bỏ
                                                                                                    lưu</a></li>
                                                                                            @php
                                                                                                $university =
                                                                                                    auth()
                                                                                                        ->guard('admin')
                                                                                                        ->user()
                                                                                                        ->university ??
                                                                                                    (auth()
                                                                                                        ->guard('admin')
                                                                                                        ->user()
                                                                                                        ->academicAffair
                                                                                                        ->university ??
                                                                                                        null);
                                                                                                $jobUniversityStatus = null;
                                                                                                $custommer =
                                                                                                    auth()
                                                                                                        ->guard('web')
                                                                                                        ->check() &&
                                                                                                    auth()
                                                                                                        ->guard('web')
                                                                                                        ->user()
                                                                                                        ->role ==
                                                                                                        ROLE_USER;
                                                                                                $jobUserStatus = null;
                                                                                                if ($custommer) {
                                                                                                    $jobUserStatus = in_array(
                                                                                                        auth()
                                                                                                            ->guard(
                                                                                                                'web',
                                                                                                            )
                                                                                                            ->user()
                                                                                                            ->id,
                                                                                                        $getJob
                                                                                                            ->userJob()
                                                                                                            ->pluck(
                                                                                                                'user_id',
                                                                                                            )
                                                                                                            ->toArray(),
                                                                                                    );
                                                                                                }
                                                                                            @endphp
                                                                                            <li>
                                                                                                @if (($university && !$jobUniversityStatus) || ($custommer && $jobUserStatus))
                                                                                                    <button
                                                                                                        class="btn btn-secondary"
                                                                                                        disabled>Đã
                                                                                                        ứng tuyển</button>
                                                                                                @else
                                                                                                    <a class="btn btn-primary"
                                                                                                        href="{{ route('detailJob', ['slug' => $getJob->slug]) }}">Ứng
                                                                                                        tuyển</a>
                                                                                                @endif
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="jp_job_post_keyword_wrapper">
                                                                            <ul>
                                                                                <li>
                                                                                    <i
                                                                                        class="fa-solid fa-graduation-cap"></i>
                                                                                </li>
                                                                                @if ($getJob->skills)
                                                                                    @foreach ($getJob->skills as $skill)
                                                                                        <li><a style="text-decoration: none;"
                                                                                                href="#">{{ $skill->name }}</a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                                <li class="float-end">
                                                                                    <p>Đã
                                                                                        đăng
                                                                                        {{ Carbon\Carbon::parse($getJob->updated_at)->diffForHumans() }}
                                                                                    </p>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-center" style="margin-top: 100px;">
                                                    <img class="lazy entered loaded"
                                                        data-src="https://cdn-new.topcv.vn/unsafe/https://static.topcv.vn/v4/image/job-list/foppy-far-far-away.svg"
                                                        alt="None suitable job" data-ll-status="loaded"
                                                        src="https://cdn-new.topcv.vn/unsafe/https://static.topcv.vn/v4/image/job-list/foppy-far-far-away.svg">
                                                    <p class="text-center">
                                                        Chưa tìm thấy việc làm phù hợp với yêu cầu của bạn</p>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($getJobs->lastPage() > 1)
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden-sm hidden-xs">
                                                <div class="pager_wrapper gc_blog_pagination">
                                                    <ul class="pagination">
                                                        <li class="{{ $getJobs->onFirstPage() ? 'disabled' : '' }}">
                                                            <a href="{{ $getJobs->previousPageUrl() }}">
                                                                <i class="fa fa-chevron-left"></i>
                                                            </a>
                                                        </li>

                                                        @foreach ($getJobs->getUrlRange(1, $getJobs->lastPage()) as $page => $url)
                                                            <li
                                                                class="{{ $page == $getJobs->currentPage() ? 'active' : '' }}">
                                                                <a href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endforeach

                                                        <li class="{{ $getJobs->hasMorePages() ? '' : 'disabled' }}">
                                                            <a href="{{ $getJobs->nextPageUrl() }}">
                                                                <i class="fa fa-chevron-right"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.closest('.remove-wishlist')) {
                let btn = event.target.closest('.remove-wishlist');
                let jobId = btn.dataset.jobId;

                fetch('{{ route('job.wishlist') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            job_id: jobId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'removed') {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            }
        });
    </script>

@endsection
