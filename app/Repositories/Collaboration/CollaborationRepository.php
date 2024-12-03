<?php

namespace App\Repositories\Collaboration;

use App\Models\Collaboration;
use App\Repositories\Base\BaseRepository;

class CollaborationRepository extends BaseRepository implements CollaborationRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return Collaboration::class;
    }

    public function getIndexRepository(int $status, int $page)
    {
        return $this->model->where('status', $status)->orderBy('created_at', 'desc')->paginate(PAGINATE_COLLAB);
    }

    public function searchAcrossStatuses(?string $search, ?string $dateRange, int $page)
    {
        $query = $this->model->with('university')
            ->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhereHas('university', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', "%{$search}%");
                        });
//                        ->orWhere('response_message', 'like', "%{$search}%");
                }
            });
        // Xử lý date range tương tự như trước
        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) == 2) {
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();

                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return $query->orderBy('created_at', 'desc')->paginate(PAGINATE_COLLAB);
    }
}
