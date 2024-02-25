<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AssignedOrCreatorTaskMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
            $task =Task::findOrFail( $request->route('task'));
            if (($request->user() && User::isAdmin())|| Auth::id() == $task->assigned_user_id ||Auth::id() == $task->creator_user_id) {
                return $next($request);
            }
            return response()->json([
                'message' => 'UNAUTHORIZED !'
            ],Response::HTTP_UNAUTHORIZED );
        
    }
}
