<?php

namespace App\Http\Controllers;
use App\Models\Session;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    
    public function store(Request $request, $eventId)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($eventId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'speaker' => 'nullable|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'video_url' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $validated['event_id'] = $event->id;

        $session = Session::create($validated);

        return response()->json([
            'message' => 'Session created successfully',
            'session' => $session
        ]);
    }


   
    public function index($eventId)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($eventId);

        return $event->sessions;
    }


    
    public function show($eventId, $sessionId)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($eventId);

        return Session::where('event_id', $event->id)->findOrFail($sessionId);
    }


    
    public function update(Request $request, $eventId, $sessionId)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($eventId);

        $session = Session::where('event_id', $event->id)->findOrFail($sessionId);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'speaker' => 'nullable|string|max:255',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'video_url' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $session->update($validated);

        return response()->json([
            'message' => 'Session updated successfully',
            'session' => $session
        ]);
    }


    
    public function destroy($eventId, $sessionId)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($eventId);

        $session = Session::where('event_id', $event->id)->findOrFail($sessionId);

        $session->delete();

        return response()->json([
            'message' => 'Session deleted successfully'
        ]);
    }
}
