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

    public function getNotifications(array $filters)
    {
        $query = $this->model->select('*');
        if (isset($filters['company'])) {
            $query->where('company_id', $filters['company']);
        }

        if (isset($filters['university'])) {
            $query->where('university_id', $filters['university']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(LIMIT_10);
    }

    public function seen($args)
    {
        $query = $this->model;

        if (isset($args['company'])) {
            $query = $query->where('company_id', $args['company']);
        }

        if (isset($args['university'])) {
            $query = $query->where('university_id', $args['university']);
        }

        if (isset($args['id'])) {
            $query = $query->where('id', $args['id']);
        }

        return $query->update(['is_seen' => 1]);
    }
}
