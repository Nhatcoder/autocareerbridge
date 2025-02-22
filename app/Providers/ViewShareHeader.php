<?php

namespace App\Providers;

use App\Repositories\ChatMessage\ChatMessageRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewShareHeader extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap services.
     */
    public function boot(NotificationRepositoryInterface $notificationRepository, ChatMessageRepositoryInterface $chatMessageRepository): void
    {
        $notificationRepository = app(NotificationRepositoryInterface::class);
        $chatMessageRepository = app(ChatMessageRepositoryInterface::class);

        View::composer(['management.partials.header'], function ($view) use ($notificationRepository) {
            $notificationsHeader = $notificationRepository->getNotifications();

            $user = auth()->guard('admin')->user();
            $valueId = [];
            if (in_array($user->role, [ROLE_UNIVERSITY, ROLE_SUB_UNIVERSITY])) {
                $valueId['university'] = $user->university->id ?? $user->academicAffair->university_id ?? null;
            } elseif (in_array($user->role, [ROLE_COMPANY, ROLE_HIRING])) {
                $valueId['company'] = $user->company->id ?? $user->hiring->company_id ?? null;
            } elseif ($user->role === ROLE_ADMIN) {
                $valueId['admin'] = $user->id ?? null;
            }

            $view->with([
                'valueId' => !empty($valueId) ? $valueId : 0,
                'user' => auth()->guard('admin')->user(),
                'notificationsHeader' => $notificationsHeader,
                'notificationCount' => $notificationRepository->getNotificationCount()
            ]);
        });

        View::composer(['client.partials.header'], function ($view) use ($chatMessageRepository, $notificationRepository) {
            if (auth()->guard('admin')->check() || auth()->guard('web')->check()) {
                $view->with([
                    'userChatHeader' => $chatMessageRepository->userChat(),
                    'notificationCount' => $notificationRepository->getNotificationCount(),
                    'notificationsHeader' => $notificationRepository->getNotifications()
                ]);
            }
        });
    }
}
