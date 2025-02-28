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
        $user = auth()->guard('admin')->user() ?? auth()->guard('web')->user();
        $filters = [];
        if ($user->role == ROLE_UNIVERSITY || $user->role == ROLE_SUB_UNIVERSITY) {
            if (isset($user->university->id)) {
                $filters['university'] = $user->university->id;
            } else if (isset($user->academicAffair->university_id)) {
                $filters['university'] = $user->academicAffair->university_id;
            } else {
                return [];
            }
        } elseif ($user->role == ROLE_COMPANY || $user->role == ROLE_SUB_ADMIN) {
            if (isset($user->company->id)) {
                $filters['company'] = $user->company->id;
            } else if (isset($user->hiring->company_id)) {
                $filters['company'] = $user->hiring->company_id;
            } else {
                return [];
            }
        } elseif (isset($user->id) && $user->role == ROLE_ADMIN) {
            $filters['admin'] = $user->id;
        } elseif (isset($user->id) && $user->role == ROLE_USER) {
            $filters['user'] = $user->id;
        } else {
            return [];
        }

        $query = $this->model->select('*');
        if (isset($filters['company'])) {
            $query->where('company_id', $filters['company']);
        }

        if (isset($filters['university'])) {
            $query->where('university_id', $filters['university']);
        }

        if (isset($filters['admin'])) {
            $query->where('admin_id', $filters['admin']);
        }

        if (isset($filters['user'])) {
            $query->where('user_id', $filters['user']);
        }
        return $query->orderBy('created_at', 'desc')->paginate(LIMIT_10);
    }

    public function getNotificationCount()
    {
        $user = auth()->guard('admin')->user() ?? auth()->guard('web')->user();
        $filters = [];
        if ($user->role == ROLE_UNIVERSITY || $user->role == ROLE_SUB_UNIVERSITY) {
            if (isset($user->university->id)) {
                $filters['university'] = $user->university->id;
            } else if (isset($user->academicAffair->university_id)) {
                $filters['university'] = $user->academicAffair->university_id;
            } else {
                return [];
            }
        } elseif ($user->role == ROLE_COMPANY || $user->role == ROLE_HIRING) {
            if (isset($user->company->id)) {
                $filters['company'] = $user->company->id;
            } else if (isset($user->hiring->company_id)) {
                $filters['company'] = $user->hiring->company_id;
            } else {
                return [];
            }
        } elseif (isset($user->id) && $user->role == ROLE_ADMIN) {
            $filters['admin'] = $user->id;
        } elseif (isset($user->id) && $user->role == ROLE_USER) {
            $filters['user'] = $user->id;
        } else {
            return [];
        }

        $query = $this->model->select('*');
        if (isset($filters['company'])) {
            $query->where('company_id', $filters['company']);
        }

        if (isset($filters['university'])) {
            $query->where('university_id', $filters['university']);
        }

        if (isset($filters['admin'])) {
            $query->where('admin_id', $filters['admin']);
        }

        if (isset($filters['user'])) {
            $query->where('user_id', $filters['user']);
        }

        $query->where('is_seen', UNSEEN);

        return $query->count();
    }

    public function getCountNotificationRealtime($companyId = null, $universityId = null, $adminId = null)
    {
        $query = $this->model->select('*');
        if ($companyId) {
            $query->where('company_id', $companyId);
        }
        if ($universityId) {
            $query->where('university_id', $universityId);
        }

        if ($adminId) {
            $query->where('admin_id', $adminId);
        }

        $query->where('is_seen', UNSEEN);

        return $query->count();
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

        if (isset($args['admin'])) {
            $query = $query->where('admin_id', $args['admin']);
        }

        if (isset($args['user'])) {
            $query = $query->where('user_id', $args['user']);
        }

        if (isset($args['id'])) {
            $query = $query->where('id', $args['id']);
        }

        return $query->update(['is_seen' => 1]);
    }

    /**
     * Count notifycation user.
     * @author TranVanNhat
     * @param int $userId
     * @return int
     */
    public function countNotifycationUser($userId)
    {
        return $this->model->where('user_id', $userId)->where('is_seen', UNSEEN)->count();
    }

    public function markSeenAll()
    {
        $id = auth()->guard('web')->user()->id ?? (auth()->guard('admin')->user()->role == ROLE_ADMIN ?
            auth()->guard('admin')->user()->id : ((auth()->guard('admin')->user()->company->id ?? auth()->guard('admin')->user()->hiring->company_id) ?? (auth()->guard('admin')->user()->university->id ?? auth()->guard('admin')->user()->academicAffair->university_id)));
        $query = $this->model;
        if ($id) {
            $query = $query->where('is_seen', UNSEEN)
                ->where(function ($q) use ($id) {
                    $q->where('user_id', $id)
                        ->orWhere('company_id', $id)
                        ->orWhere('university_id', $id)
                        ->orWhere('admin_id', $id);
                });
        }
        return $query->update(['is_seen' => SEEN]);
    }
}
