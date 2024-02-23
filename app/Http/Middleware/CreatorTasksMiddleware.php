<?php

namespace App\Http\Middleware;

use App\Models\Task;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CreatorTasksMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $task =Task::find($request->taskId);

        if (! $task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        if (!User::find($request->userId)) {
            return response()->json(['error' => 'User not found'], 404);
        }
        if (($request->user() && $request->user()->isAdmin())|| Auth::id() == $task->creator_user_id) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Unauthorized access');

    }
}
