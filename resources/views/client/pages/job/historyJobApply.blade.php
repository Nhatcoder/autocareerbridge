@extends('client.layout.main')
@section('title', 'Việc làm đã ứng tuyển')

@section('css')
@endsection
@section('content')
    {{--    breacrumb --}}
    <div class="jp_tittle_main_wrapper">
        <div class="jp_tittle_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="jp_tittle_heading_wrapper">
                        <div class="jp_tittle_heading">
                            <h2>Việc làm đã ứng tuyển</h2>
                        </div>
                        <div class="jp_tittle_breadcrumb_main_wrapper">
                            <div class="jp_tittle_breadcrumb_wrapper">
                                <ul>
                                    <li><a href="{{ route('home') }}">Trang chủ</a> <i class="fa fa-angle-right"></i></li>
                                    <li>Việc làm đã ứng tuyển</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="jp_listing_sidebar_main_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="jp_hiring_slider_main_wrapper">
                        <div class="jp_career_slider_heading_wrapper">
                            <h2>Bạn đã ứng tuyển <span><b>{{ $getUserApplyJobs->total() }}</b></span> công việc.</h2>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-5">
                                <div class="row">
                                    @if (isset($getUserApplyJobs) && $getUserApplyJobs->count() > 0)
                                        @foreach ($getUserApplyJobs as $item)
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div
                                                    class="jp_job_post_main_wrapper_cont jp_job_post_grid_main_wrapper_cont">
                                                    <div class="jp_job_post_main_wrapper jp_job_post_grid_main_wrapper">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <a href="{{ route('detailJob', ['slug' => $item->job->slug]) }}"
                                                                    target="_blank" rel="noopener noreferrer">
                                                                    <div class="jp_job_post_side_img">
                                                                        <img class="img_thumb_item"
                                                                            src="{{ isset($item->job->company->avatar_path) ? asset($item->job->company->avatar_path) : asset('clients/images/no-image.jpg') }}"
                                                                            alt="{{ $item->name }}">
                                                                    </div>
                                                                    <div
                                                                        class="jp_job_post_right_cont jp_job_post_grid_right_cont">
                                                                        <h4>{{ $item->job->name }}
                                                                        </h4>
                                                                        <p style="color:#e69920;">
                                                                            {{ $item->job->company->name ?? '' }}
                                                                        </p>
                                                                        <ul>
                                                                            <li><i class="fa fa-map-marker"></i>&nbsp;
                                                                                {{ ucwords($item->job->company->addresses->first()->province->name) }},
                                                                                {{ ucwords($item->job->company->addresses->first()->district->name) }}
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <span>Đã ứng tuyển ({{ $item->created_at }})</span>
                                                                    </div>
                                                                    <div>
                                                                        <a class="btn btn-primary" href="{{ route('conversations', ['id' => $item->user_id]) }}">
                                                                            Nhắn tin
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="jp_job_post_keyword_wrapper">
                                                        <ul>
                                                            <li><i class="fa-solid fa-graduation-cap"></i></li>
                                                            @if ($item->job->skills)
                                                                @foreach ($item->job->skills as $skill)
                                                                    <li><a style="text-decoration: none;"
                                                                            href="#">{{ $skill->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="text-center mt-3">Bạn chưa ứng tuyển việc làm nào l</h3>
                                        </div>
                                    @endif

                                    @if ($getUserApplyJobs->lastPage() > 1)
                                        <div class="pager_wrapper gc_blog_pagination">
                                            <ul class="pagination">
                                                <li class="{{ $getUserApplyJobs->onFirstPage() ? 'disabled' : '' }}">
                                                    <a href="{{ $getUserApplyJobs->previousPageUrl() }}"><i
                                                            class="fa fa-chevron-left"></i></a>
                                                </li>
                                                @for ($i = max(1, $getUserApplyJobs->currentPage() - 2); $i <= min($getUserApplyJobs->currentPage() + 2, $getUserApplyJobs->lastPage()); $i++)
                                                    <li
                                                        class="{{ $i == $getUserApplyJobs->currentPage() ? 'active' : '' }}">
                                                        <a href="{{ $getUserApplyJobs->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                <li class="{{ $getUserApplyJobs->hasMorePages() ? '' : 'disabled' }}">
                                                    <a href="{{ $getUserApplyJobs->nextPageUrl() }}"><i
                                                            class="fa fa-chevron-right"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
    @endsection
