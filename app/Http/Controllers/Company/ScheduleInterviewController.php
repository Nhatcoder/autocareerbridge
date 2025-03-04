<?php

namespace App\Http\Controllers\Company;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Services\Managements\AuthService;
use Google\Service\Calendar;

/**
 *
 * create, update, and delete schedule interviews.
 *
 * @package App\Http\Controllers
 * @author Tran Van Nhat, KhanhNguyen (tranvannhat7624@gmail.com)
 * @access public
 * @see index()
 * @see refreshEvents()
 */
class ScheduleInterviewController extends Controller
{
    use LogHelper;
    protected $authService;

    public  function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Display a list of schedule interviews.
     * @author TranVanNhat, KhanhNguyen <tranvannhat7624@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $client = $this->authService->getGoogleClient();

            if (method_exists($client, 'getTargetUrl')) {
                return $client;
            }

            return view('management.pages.company.schedule_interview.index');
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->authService->redirectToGoogle();
        }
    }

    /**
     * Summary of refreshEvents
     * @return mixed|\Illuminate\Http\JsonResponse
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function refreshEvents()
    {
        try {
            $client = $this->authService->getGoogleClient();

            // If getGoogleClient returns a redirect response
            if (method_exists($client, 'getTargetUrl')) {
                return response()->json(['redirect_url' => $client->getTargetUrl()]);
            }

            $service = new Calendar($client);

            $optParams = array(
                'maxResults' => 2500,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c', strtotime('-1 month')),
            );

            $results = $service->events->listEvents('primary', $optParams);
            $events = [];

            foreach ($results->getItems() as $event) {
                $events[] = [
                    'id' => $event->id,
                    'title' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'start' => $event->start->dateTime ?? $event->start->date,
                    'end' => $event->end->dateTime ?? $event->end->date,
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch events: ' . $e->getMessage()
            ], 500);
        }
    }
}
