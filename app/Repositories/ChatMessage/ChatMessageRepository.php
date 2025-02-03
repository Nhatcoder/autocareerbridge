<?php

namespace App\Repositories\ChatMessage;

use App\Models\ChatMessage;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ChatMessageRepository extends BaseRepository implements ChatMessageRepositoryInterface
{
    public $companyRepository;
    public $userRepository;
    public function __construct(CompanyRepositoryInterface $companyRepository, UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
    }

    public function getModel()
    {
        return ChatMessage::class;
    }

    public function latestMessages()
    {
        return $this->model
            ->selectRaw('GREATEST(from_id, to_id) as participant_a, LEAST(from_id, to_id) as participant_b, MAX(created_at) as latest_message_time')
            ->groupByRaw('GREATEST(from_id, to_id), LEAST(from_id, to_id)');
    }

    public function userChats()
    {
        $userCurrent = auth('admin')->user();
        $userChats = DB::table('chat_messages as cm')
            ->joinSub($this->latestMessages(), 'latest', function ($join) {
                $join->on(DB::raw('GREATEST(cm.from_id, cm.to_id)'), '=', 'latest.participant_a')
                    ->on(DB::raw('LEAST(cm.from_id, cm.to_id)'), '=', 'latest.participant_b')
                    ->on('cm.created_at', '=', 'latest.latest_message_time');
            })
            ->leftJoin('companies as sender_company', 'sender_company.id', '=', 'cm.from_id')
            ->leftJoin('users as sender_user', 'sender_user.id', '=', 'cm.from_id')
            ->leftJoin('companies as receiver_company', 'receiver_company.id', '=', 'cm.to_id')
            ->leftJoin('users as receiver_user', 'receiver_user.id', '=', 'cm.to_id')
            ->where(function ($query) use ($userCurrent) {
                $query->where('cm.from_id', $userCurrent->id)
                    ->orWhere('cm.to_id', $userCurrent->id);
            })
            ->select(
                'cm.from_id',
                'cm.to_id',
                'cm.message',
                'cm.created_at as sent_time',
                DB::raw('COALESCE(sender_company.avatar_path, sender_user.avatar_path) as sender_avatar'),
                DB::raw('COALESCE(sender_company.name, sender_user.user_name) as sender_name'),
                DB::raw('COALESCE(receiver_company.avatar_path, receiver_user.avatar_path) as receiver_avatar'),
                DB::raw('COALESCE(receiver_company.name, receiver_user.user_name) as receiver_name')
            )
            ->where('cm.deleted_at', null)
            ->orderBy('cm.created_at', 'desc')
            ->get();
        return $userChats;
    }

    public function chats($id)
    {
        $userCurrent = auth('admin')->user();
        $company = $this->companyRepository->find($id);
        $user = $this->userRepository->find($id);

        $partnerId = $company ? $company->id : $user->id;
        $userCurrentId = $userCurrent->id;
        $partnerName = $company ? $company->name : NAME_COMPANY;
        $chats = ChatMessage::query()
            ->selectRaw("
            CASE
                WHEN chat_messages.from_id = ? THEN ?
                ELSE ?
            END AS from_id", [$userCurrentId, $userCurrentId, $partnerId])
            ->selectRaw("
            CASE
                WHEN chat_messages.to_id = ? THEN ?
                ELSE ?
            END AS to_id", [$userCurrentId, $userCurrentId, $partnerId])
            ->selectRaw("
            CASE
                WHEN chat_messages.from_id = ? THEN 'Khách hàng'
                ELSE ?
            END AS sender_name", [$userCurrentId, $partnerName])
            ->selectRaw("
            CASE
                WHEN chat_messages.to_id = ? THEN 'Khách hàng'
                ELSE ?
            END AS receiver_name", [$userCurrentId, $partnerName])
            ->select('chat_messages.id', 'chat_messages.message AS message', 'chat_messages.created_at AS sent_time', 'chat_messages.from_id', 'chat_messages.to_id')
            ->leftJoin('users AS users_from', 'chat_messages.from_id', '=', 'users_from.id')
            ->leftJoin('users AS users_to', 'chat_messages.to_id', '=', 'users_to.id')
            ->leftJoin('companies', function ($join) {
                $join->on('chat_messages.from_id', '=', 'companies.user_id')
                    ->orOn('chat_messages.to_id', '=', 'companies.user_id');
            })
            ->where(function ($query) use ($partnerId, $userCurrentId) {
                $query->where(function ($q) use ($partnerId, $userCurrentId) {
                    $q->where('chat_messages.from_id', $userCurrentId)
                        ->where('chat_messages.to_id', $partnerId);
                })
                    ->orWhere(function ($q) use ($partnerId, $userCurrentId) {
                        $q->where('chat_messages.from_id', $partnerId)
                            ->where('chat_messages.to_id', $userCurrentId);
                    });
            })
            ->whereNull('chat_messages.deleted_at')
            ->with('attachments')
            ->orderBy('chat_messages.created_at', 'desc')
            ->paginate(PAGINATE_CHATMESSAGE);
        return $chats;
    }

    public function historyImage($id)
    {
        $images = $this->model->where(function ($query) use ($id) {
            $query->where('from_id', $id)
                ->orWhere('to_id', $id);
        })
            ->join('attachments', 'attachments.chat_id', '=', 'chat_messages.id')
            ->select('attachments.name', 'attachments.type', 'attachments.file_path', 'chat_messages.created_at')
            ->where("attachments.type", TYPE_IMAGE)
            ->orderByDesc('chat_messages.created_at')
            ->paginate(PAGINATE_CHATMESSAGE);
        return $images;
    }

    public function getHistoryFile($id)
    {
        $files = $this->model->where(function ($query) use ($id) {
            $query->where('from_id', $id)
                ->orWhere('to_id', $id);
        })
            ->join('attachments', 'attachments.chat_id', '=', 'chat_messages.id')
            ->where('attachments.type', TYPE_FILE)
            ->select('attachments.name', 'attachments.type', 'attachments.file_path', 'chat_messages.created_at')
            ->orderByDesc('chat_messages.created_at')
            ->paginate(PAGINATE_CHATMESSAGE);
        return $files;
    }
}
