<?php

namespace App\Http\Middleware;

use App\Models\Task;
use App\Models\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;
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


        $task =Task::findOrFail( $request->route('task'));
        if (($request->user() && User::isAdmin())|| Auth::id() == $task->creator_user_id) {
            return $next($request);
        }
        return response()->json([
            'message' => 'UNAUTHORIZED !'
        ],Response::HTTP_UNAUTHORIZED );

    }
}
