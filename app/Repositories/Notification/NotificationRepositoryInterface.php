<?php

namespace App\Repositories\Notification;

use App\Repositories\Base\BaseRepositoryInterface;

interface NotificationRepositoryInterface extends BaseRepositoryInterface
{
    public function getModel();
    public function getNotifications(array $filters);

    public function seen(array $args);
}
