<div class="">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('label.company.applyJob.name') }}</th>
                <th>{{ __('label.company.applyJob.candicate') }}</th>
                <th>{{ __('label.company.applyJob.time_applied') }}</th>
                <th>{{ __('label.company.applyJob.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $key => $item)
                <tr>
                    <td><strong>{{ ($data->currentPage() - 1) * $data->perPage() + $key + 1 }}</strong></td>
                    <td>
                        <a target="_blank" href="{{ route('company.showJob', ['slug' => $item->job->slug]) }}"
                            title="{{ $item->job->name ?? '' }}">{{ $item->job->name ?? '' }}</a>
                    </td>
                    <td>
                        @if ($item->cv)
                            <a class="seen_cv__user" data-id="{{ $item->id }}" target="_blank"
                                style="color: #007bff; text-decoration: none; display: flex; align-items: center;"
                                href="{{ $item->cv->type == TYPE_CV_CREATE ? route('cv.view', ['id' => $item->cv->id]) : route('cv.upload.view', ['id' => $item->cv->id]) }}"
                                title="Xem cv">
                                {{ $item->user->name ?? '' }}
                            </a>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->created)->format('d/m/Y') }}</td>
                    <td>
                        <select class="default-select form-control wide change_status text-black"
                            data-status={{ STATUS_FIT }} data-id={{ $item->id }}
                            data-check="{{ route('company.checkUserJobSeen') }}"
                            data-url="{{ route('company.changeStatusUserAplly') }}">
                            @if ($item->status == STATUS_W_EVAL)
                                <option value="{{ STATUS_W_EVAL }}" @selected($item->status == STATUS_W_EVAL)
                                    @if (request()->tab == 'fit') disabled @endif>
                                    {{ __('label.company.applyJob.w_eval') }}</option>
                                <option value="{{ STATUS_FIT }}" @selected($item->status == STATUS_FIT)>
                                    {{ __('label.company.applyJob.fit') }}</option>
                                <option value="{{ STATUS_UNFIT }}" @selected($item->status == STATUS_UNFIT)>
                                    {{ __('label.company.applyJob.unfit') }}</option>
                            @elseif ($item->status == STATUS_FIT)
                                <option value="{{ STATUS_FIT }}" @selected($item->status == STATUS_FIT)>
                                    {{ __('label.company.applyJob.fit') }}</option>
                            @elseif ($item->status == STATUS_INTERV)
                                <option value="{{ STATUS_INTERV }}"
                                    @if ($item->status == STATUS_INTERV) selected @else disabled @endif>
                                    {{ __('label.company.applyJob.interv') }}</option>
                                <option value="{{ STATUS_UNFIT }}" @selected($item->status == STATUS_UNFIT)>
                                    {{ __('label.company.applyJob.unfit') }}</option>
                                <option value="{{ STATUS_HIRED }}" @selected($item->status == STATUS_HIRED)>
                                    {{ __('label.company.applyJob.hired') }}</option>
                            @elseif ($item->status == STATUS_HIRED)
                                <option value="{{ STATUS_HIRED }}" @selected($item->status == STATUS_HIRED)>
                                    {{ __('label.company.applyJob.hired') }}</option>
                            @elseif ($item->status == STATUS_UNFIT)
                                <option value="{{ STATUS_UNFIT }}" @selected($item->status == STATUS_UNFIT)>
                                    {{ __('label.company.applyJob.unfit') }}</option>
                            @endif
                        </select>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">{{ __('label.company.applyJob.no_data') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $data->appends(request()->query())->links() }}
    </div>
</div>
