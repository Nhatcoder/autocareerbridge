<?php

namespace App\Services\GoogleCalendar;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Helpers\LogHelper;

class GoogleCalendarService
{
    use LogHelper;

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setAccessType('offline');
        $this->client->setScopes(config('services.google.scopes'));
    }


    /**
     * Set the access token for the authenticated user.
     *
     * @throws \Exception If the user's Google account is not connected or if refreshing the token fails.
     */
    public function setAccessTokenForAuthenticatedUser()
    {
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->access_token || !$user->refresh_token) {
            throw new \Exception('Tài khoản chưa kết nối Google Calendar.');
        }

        $this->client->setAccessToken([
            'access_token' => $user->access_token,
            'refresh_token' => $user->refresh_token,
            'expires_in' => $user->token_expires_at ? now()->diffInSeconds($user->token_expires_at) : 0,
        ]);

        // Nếu token hết hạn thì refresh
        if ($this->client->isAccessTokenExpired()) {
            $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken($user->refresh_token);

            if (isset($newAccessToken['error'])) {
                throw new \Exception('Lỗi khi refresh token: ' . $newAccessToken['error']);
            }

            $user->update([
                'access_token' => $newAccessToken['access_token'],
                'token_expires_at' => now()->addSeconds($newAccessToken['expires_in']),
            ]);

            $this->client->setAccessToken($newAccessToken);
        }
    }


    /**
     * Create an event on Google Calendar.
     *
     * @param array $data The event details.
     * @return string|null The created event ID, or null on failure.
     */
    public function createCalendarEvent($data)
    {
        try {
            $this->setAccessTokenForAuthenticatedUser();

            $calendarService = new Calendar($this->client);

            $event = new Event([
                'summary' => $data['title'] ?? '',
                'description' => $data['description'] ?? '',
                'start' => new EventDateTime([
                    'dateTime' => Carbon::parse($data['start_date'])->toRfc3339String(),
                    'timeZone' => $data['time_zone'] ?? 'Asia/Ho_Chi_Minh',
                ]),
                'end' => new EventDateTime([
                    'dateTime' => Carbon::parse($data['end_date'])->toRfc3339String(),
                    'timeZone' => $data['time_zone'] ?? 'Asia/Ho_Chi_Minh',
                ]),
            ]);

            $calendarId = 'primary';

            $createdEvent = $calendarService->events->insert($calendarId, $event);

            return $createdEvent->getId();
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return null;
        }
    }



    /**
     * Update an existing event on Google Calendar.
     *
     * @param string $eventId The ID of the event to update.
     * @param array $data The updated event details.
     * @return bool True if the event was updated successfully, false otherwise.
     */
    public function updateCalendarEvent($eventId, $data)
    {
        try {

            $this->setAccessTokenForAuthenticatedUser();

            $calendarService = new Calendar($this->client);

            $calendarId = 'primary';

            $event = $calendarService->events->get($calendarId, $eventId);

            if (!$event) {
                throw new \Exception('Sự kiện không tồn tại trên Google Calendar');
            }

            $event->setSummary($data['title'] ?? $event->getSummary());
            $event->setDescription($data['description'] ?? $event->getDescription());

            $event->setStart(new EventDateTime([
                'dateTime' => Carbon::parse($data['start_date'])->toRfc3339String(),
                'timeZone' => $data['time_zone'] ?? 'Asia/Ho_Chi_Minh',
            ]));
            $event->setEnd(new EventDateTime([
                'dateTime' => Carbon::parse($data['end_date'])->toRfc3339String(),
                'timeZone' => $data['time_zone'] ?? 'Asia/Ho_Chi_Minh',
            ]));

            $calendarService->events->update($calendarId, $eventId, $event);

            return true;
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);

            return false;
        }
    }
}
