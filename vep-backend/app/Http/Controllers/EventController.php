<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    // CREATE EVENT
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'venue' => 'nullable|string',
            'is_virtual' => 'nullable|boolean',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'capacity' => 'nullable|integer',
            'thumbnail' => 'nullable|string',
        ]);

        $event = Event::create([
            'organizer_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'venue' => $validated['venue'] ?? null,
            'is_virtual' => $validated['is_virtual'] ?? false,
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'capacity' => $validated['capacity'] ?? null,
            'thumbnail' => $validated['thumbnail'] ?? null,
            'slug' => Str::slug($validated['title']),
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event
        ]);
    }


    
    public function index()
    {
        return Event::where('organizer_id', Auth::id())->get();
    }


 
    public function show($id)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($id);
        return $event;
    }


    
    public function update(Request $request, $id)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'venue' => 'nullable|string',
            'is_virtual' => 'nullable|boolean',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'capacity' => 'nullable|integer',
            'thumbnail' => 'nullable|string',
            'status' => 'nullable|in:draft,published,archived'
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $event->update($validated);

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    }


    
    public function destroy($id)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($id);
        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ]);
    }
}
