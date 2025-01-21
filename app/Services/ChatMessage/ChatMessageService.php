<?php

namespace App\Services\ChatMessage;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\ChatMessage\ChatMessageRepositoryInterface;

class ChatMessageService
{
    protected $chatMessageRepository;

    public function __construct(ChatMessageRepositoryInterface $chatMessageRepository)
    {
        $this->chatMessageRepository = $chatMessageRepository;
    }

    public function userChats()
    {
        return $this->chatMessageRepository->userChats();
    }

    public function chats($id)
    {
        return $this->chatMessageRepository->chats($id);
    }

    public function chatStore($data)
    {
        DB::beginTransaction();
        try {
            $newMessage = $data['message'];
            $images = $data['images'];
            $files = $data['files'];

            $message = $this->chatMessageRepository->create($newMessage);
            if ($images) {
                foreach ($images as $image) {
                    $imageName = $image->getClientOriginalName();
                    $imagePath = $image->storeAs('chats/images', Str::uuid() . '-' . $imageName, 'public');
                    $imagePath = '/storage/' . $imagePath;
                    $message->attachments()->create([
                        'name' => $imageName,
                        'type' => TYPE_IMAGE,
                        'file_path' => $imagePath
                    ]);
                }
            }

            if ($files) {
                foreach ($files as $file) {
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->storeAs('chats/files', Str::uuid() . '-' . $fileName, 'public');
                    $filePath = '/storage/' . $filePath;
                    $message->attachments()->create([
                        'name' => $fileName,
                        'type' => TYPE_FILE,
                        'file_path' => $filePath,
                    ]);
                }
            }
            DB::commit();
            $data = [
                'from_id' => $message->from_id,
                'to_id' => $message->to_id,
                'message' => $message->message,
                'sent_time' => $message->created_at,
                'attachments' => $message->attachments
            ];
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getHistoryFile($id){
        return $this->chatMessageRepository->getHistoryFile($id);
    }
}
