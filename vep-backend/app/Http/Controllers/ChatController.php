<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // SEND MESSAGE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'message' => 'required|string',
            'is_question' => 'nullable|boolean',
        ]);

        $chat = Chat::create([
            'event_id' => $validated['event_id'],
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_question' => $validated['is_question'] ?? false,
        ]);

        return response()->json([
            'message' => 'Message sent',
            'data' => $chat
        ]);
    }


    // GET ALL MESSAGES FOR AN EVENT
    public function index($event_id)
    {
        $messages = Chat::where('event_id', $event_id)
            ->with('user:id,name,email')
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }


    // GET ONLY QUESTIONS (Q&A)
    public function questions($event_id)
    {
        $messages = Chat::where('event_id', $event_id)
            ->where('is_question', true)
            ->with('user:id,name,email')
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }


    // DELETE MESSAGE
    public function destroy($id)
    {
        $chat = Chat::where('user_id',Auth::id())->findOrFail($id);
        $chat->delete();

        return response()->json(['message' => 'Message deleted']);
    }
}
