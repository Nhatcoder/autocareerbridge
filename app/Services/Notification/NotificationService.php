<?php

namespace App\Services\Notification;

use App\Events\NotifyJobChangeStatusEvent;
use App\Repositories\Notification\NotificationRepositoryInterface;

class NotificationService
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function create(array $args)
    {
        return $this->notificationRepository->create($args);
    }

    public function renderNotificationRealtime($notification, $companyId = null, $universityId = null, $adminId = null)
    {
        $idChanel = $notification->admin_id ?? $notification->company_id ?? $notification->university_id;
        $role = $notification->admin_id ? 'admin' : ($notification->company_id ? 'company' : 'university');

        $viewNotifycation = view('management.components.notifycation', compact('notification'))->render();
        $countNotificationUnSeen = $this->notificationRepository->getCountNotificationRealtime($companyId, $universityId, $adminId);

        broadcast(new NotifyJobChangeStatusEvent($viewNotifycation, $idChanel, $countNotificationUnSeen, $role));
    }


    public function getNotifications()
    {
        return $this->notificationRepository->getNotifications();
    }

    public function delete($id)
    {
        return $this->notificationRepository->delete($id);
    }

    public function seen(array $args)
    {
        return $this->notificationRepository->seen($args);
    }
}
