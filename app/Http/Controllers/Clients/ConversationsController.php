<?php

namespace App\Http\Controllers\Clients;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\UserJob;
use App\Services\ChatMessage\ChatMessageService;
use App\Services\Company\CompanyService;
use App\Services\User\UserService;
use App\Services\UserJob\UserJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;


/**
 * ConversationsController Processes returned data,
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
    public function __construct(ChatMessageService $chatMessageService, CompanyService $companyService, UserService $userService, UserJobService $userJobService)
    {
        $this->chatMessageService = $chatMessageService;
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->userJobService = $userJobService;
    }

    public function conversations(Request $request, $id = null)
    {
        // $userCurrent = auth('admin')->user() ?? (auth('admin')->user()->company ? auth('admin')->user()->company : null) ?? auth('web')->user();
        $userCurrent = auth('admin')->user();
        $company = $this->companyService->getCompanyById($id);

        $user = null;
        if ($id) {
            $user = $this->userService->getUserById($id);
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
    }

    public function chatStore(Request $request)
    {
        $newMessage = json_decode($request->newMessage, true);
        $data = [
            'message' => $newMessage,
            'images' => $request->file('images'),
            'files' => $request->file('files')
        ];
        $message = $this->chatMessageService->chatStore($data);
        broadcast(new SendMessage(message: $message));
    }

    public function searchUserChat(Request $request)
    {
        $userCurrent = auth('admin')->user();
        $keyword = $request->keyword;

        $listToUser = User::where('name', 'like', "%{$keyword}%")->where('id', '!=', $userCurrent->id)->get();

        return response()->json([
            'listToUser' => $listToUser
        ], 200);
    }
    public function historyFile(Request $request)
    {
        $id = $request->id;
        if (empty($id)) return response()->json([
            'data' => []
        ]);
        $data = $this->chatMessageService->getHistoryFile($id);
        return response()->json([
            'data' => $data
        ], 200);
    }
}
