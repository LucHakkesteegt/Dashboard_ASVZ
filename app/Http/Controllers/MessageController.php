<?php

namespace App\Http\Controllers;
use App\Models\Message;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
        {
            $messages = Message::all(); // Fetch all messages from the database
            return view('dashboard', compact('messages')); // Return the dashboard view with messages
        }
}
