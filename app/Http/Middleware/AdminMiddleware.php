<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (($request->user() && User::isAdmin())) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Unauthorized access !'
        ],Response::HTTP_UNAUTHORIZED );
    }
}
