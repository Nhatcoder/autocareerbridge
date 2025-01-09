<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConversationsController extends Controller
{
    public function conversations()
    {
        $data = User::all();
        return Inertia::render('chats/index', [
            'users' => $data
        ]);
    }
}
