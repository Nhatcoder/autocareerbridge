<?php

namespace App\Repositories\ChatMessage;

use App\Repositories\Base\BaseRepositoryInterface;

interface ChatMessageRepositoryInterface extends BaseRepositoryInterface
{
    public function userChats();

    public function chats($id);

    public function historyImage($id);

    public function getHistoryFile($id);
}
