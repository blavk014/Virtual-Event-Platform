<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AnalyticsController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::post('/events/{eventId}/sessions', [SessionController::class, 'store']);
    Route::get('/events/{eventId}/sessions', [SessionController::class, 'index']);
    Route::get('/events/{eventId}/sessions/{sessionId}', [SessionController::class, 'show']);
    Route::put('/events/{eventId}/sessions/{sessionId}', [SessionController::class, 'update']);
    Route::delete('/events/{eventId}/sessions/{sessionId}', [SessionController::class, 'destroy']);
    Route::post('/chat', [ChatController::class, 'store']);
    Route::get('/chat{event_id}', [ChatController::class, 'index']);
    Route::get('/chat{event_id}/questions', [ChatController::class, 'questions']);
    Route::delete('/chat/{id}', [ChatController::class, 'destroy']);
    Route::post('/analytics', [AnalyticsController::class, 'store']);
    Route::get('/analytics/{event_id}', [AnalyticsController::class, 'index']);
    Route::get('/dashboard/analytics', [AnalyticsController::class, 'summary']);

});

/*Route::get('/test', function () {
    return 'API is working!';
});*/
/*Route::match(['get', 'post'], '/test', function () {
    return response()->json(['message' => 'API working for GET & POST']);
});*/


?>