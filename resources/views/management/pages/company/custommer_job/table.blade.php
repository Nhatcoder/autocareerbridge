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

            @foreach ($data as $key => $item)
                <tr>
                    <td><strong>{{ ($data->currentPage() - 1) * $data->perPage() + $key + 1 }}</strong></td>
                    <td>
                        <a href="http://127.0.0.1:8000/company/manage-job/detail/business-analyst---upto-2000-di-lam-sau-tet"
                            rel="noopener noreferrer"
                            title="{{ $item->job->name ?? '' }}">{{ $item->job->name ?? '' }}</a>
                    </td>
                    <td>
                        <a style="color: #007bff; text-decoration: none; display: flex; align-items: center;"
                            target="_blank" href="http://127.0.0.1:8000/truong-hoc/dai-hoc-kinh-te-quoc-dan"
                            title="Xem cv">
                            {{ $item->user->name ?? '' }}
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->created)->format('d/m/Y') }}</td>
                    <td>
                        <select class="default-select form-control wide change_status text-black"
                            data-status={{ STATUS_FIT }} data-id={{ $item->id }}
                            data-url="{{ route('company.changeStatusUserAplly') }}">
                            <option value="0">Chọn</option>
                            <option value="{{ STATUS_W_EVAL }}" @selected($item->status == STATUS_W_EVAL)
                                @if (request()->tab == 'fit') disabled @endif>
                                {{ __('label.company.applyJob.w_eval') }}</option>
                            <option value="{{ STATUS_FIT }}" @selected($item->status == STATUS_FIT)>
                                {{ __('label.company.applyJob.fit') }}</option>
                            <option value="{{ STATUS_UNFIT }}" @selected($item->status == STATUS_UNFIT)>
                                {{ __('label.company.applyJob.unfit') }}</option>
                            <option value="{{ STATUS_INTERV }}"
                                @if ($item->status == STATUS_INTERV) selected @else disabled @endif>
                                {{ __('label.company.applyJob.interv') }}</option>
                            <option value="{{ STATUS_HIRED }}" @selected($item->status == STATUS_HIRED)>
                                {{ __('label.company.applyJob.hired') }}</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
