<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find($request->id);

        if(is_null($user)){
            return response()->json(['error'=>'User not found'], 404);
        }

        $request->merge(['user'=>$user]);

        return $next($request);
    }
}
