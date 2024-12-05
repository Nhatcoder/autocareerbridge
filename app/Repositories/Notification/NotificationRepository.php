<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\Base\BaseRepository;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function getModel()
    {
        return Notification::class;
    }

    public function getNotifications()
    {
        $user = auth()->guard('admin')->user();
        $filters = [];
        if ($user->role == ROLE_UNIVERSITY) {
            $filters['university'] = $user->university->id;
        } elseif ($user->role == ROLE_COMPANY) {
            $filters['company'] = $user->company->id;
        } else {
            return [];
        }

        $query = $this->model->select('*');
        if (isset($filters['company'])) {
            $query->where('company_id', $filters['company'])
            ->where('type', ROLE_COMPANY);
        }

        if (isset($filters['university'])) {
            $query->where('university_id', $filters['university'])
                ->where('type', ROLE_UNIVERSITY);
        }

        return $query->orderBy('created_at', 'desc')->paginate(LIMIT_10);
    }

    public function seen($args)
    {
        $query = $this->model;

        if (isset($args['company'])) {
            $query = $query->where('company_id', $args['company'])
                ->where('type', ROLE_COMPANY);
        }

        if (isset($args['university'])) {
            $query = $query->where('university_id', $args['university'])
                ->where('type', ROLE_UNIVERSITY);
        }

        if (isset($args['id'])) {
            $query = $query->where('id', $args['id']);
        }

        return $query->update(['is_seen' => 1]);
    }
}
