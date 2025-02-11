<?php

namespace App\Http\Controllers\Clients;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Services\ChatMessage\ChatMessageService;
use App\Services\Company\CompanyService;
use App\Services\User\UserService;
use App\Services\UserJob\UserJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

/**
 * Class ConversationsController
 * Handles realtime operations such as retrieving conversations, storing messages, and searching for users.
 *
 * @author Trần Văn Nhật
 * @access public
 * @package Clients
 */
class ConversationsController extends Controller
{
    public $chatMessageService;
    public $companyService;
    public $userService;
    public $userJobService;

    /**
     * ConversationsController constructor.
     *
     * @param ChatMessageService $chatMessageService
     * @param CompanyService $companyService
     * @param UserService $userService
     * @param UserJobService $userJobService
     */
    public function __construct(
        ChatMessageService $chatMessageService,
        CompanyService $companyService,
        UserService $userService,
        UserJobService $userJobService
    ) {
        $this->chatMessageService = $chatMessageService;
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->userJobService = $userJobService;
    }

    /**
     * Fetches and displays chat conversations.
     *
     * @param Request $request
     * @param int|null $id Receiver ID (user or company)
     */
    public function conversations(Request $request, $id = null)
    {
        try {
            $userCurrent = auth('admin')->user()->company ?? auth('web')->user();
            $company = $this->companyService->getCompanyById($id);

            $user = null;
            if ($id) {
                $user = $this->userService->getUserById($id);
                $this->chatMessageService->updateSeenMessage($id);
            }

            $getUserApplyJob = $this->userJobService->getJobUserApply();
            $userChats = $this->chatMessageService->userChats();
            if ($company || $user) {
                $chats = $this->chatMessageService->chats($id);
            }

            $data = [
                'user' => $userCurrent,
                'receiver' => $company ?? $user,
                'userChats' => $userChats,
                'getUserApplyJob' => $getUserApplyJob,
                'chats' => $chats ?? [],
            ];

            if ($request->wantsJson()) {
                return response()->json($chats);
            }

            return Inertia::render('chats/Index', [
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error($e->getFile() . ':' . $e->getLine() . ' - ' . $e->getMessage());
        }
    }

    /**
     * Stores a new chat message and broadcasts it.
     *
     * @param Request $request
     * @return void
     */
    public function chatStore(Request $request)
    {
        try {
            $newMessage = json_decode($request->newMessage, true);
            $data = [
                'message' => $newMessage,
                'images' => $request->file('images'),
                'files' => $request->file('files')
            ];
            $message = $this->chatMessageService->chatStore($data);
            broadcast(new SendMessage(message: $message));
        } catch (\Exception $e) {
            Log::error($e->getFile() . ':' . $e->getLine() . ' - ' . $e->getMessage());
        }
    }

    /**
     * Fetches the images history of a chat conversation.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function historyImage($id)
    {
        if (empty($id)) {
            return response()->json([
                'data' => []
            ]);
        }

        $data = $this->chatMessageService->historyImage($id);
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Fetches the file history of a chat conversation.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function historyFile($id)
    {
        if (empty($id)) {
            return response()->json([
                'data' => []
            ]);
        }

        $data = $this->chatMessageService->getHistoryFile($id);
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Fetches the user's chat history.
     */
    public function getUserChat()
    {
        $userChats = $this->chatMessageService->userChats();
        return response()->json([
            'success' => true,
            'data' => $userChats
        ]);
    }
}
