<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'type' => 'required|string',
            'metadata' => 'nullable|array',
        ]);

        $analytics = Analytics::create([
            'event_id' => $validated['event_id'],
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'metadata' => $validated['metadata'] ?? [],
        ]);

        return response()->json([
            'message' => 'Analytics event recorded',
            'data' => $analytics
        ]);
    }

    
    public function index($event_id)
    {
        $analytics = Analytics::where('event_id', $event_id)
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($analytics);
    }
}
