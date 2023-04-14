<?php

namespace App\Http\Middleware;

use App\Models\Vehiculo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehiculoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $vehiculo = Vehiculo::find($request->id);

        if(is_null($vehiculo)){
            return response()->json(['error'=>'Vehiculo not found'], 404);
        }

        $request->merge(['vehiculo'=>$vehiculo]);

        return $next($request);
    }
}
