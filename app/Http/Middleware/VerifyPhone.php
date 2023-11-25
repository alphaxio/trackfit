<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyPhone
{
    use ApiResponses;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->check() && $request->user()->phone_verified_at != null) {
            return $next($request);
        } else {
            if(request()->user() && $request->user()->phone_verified_at == null){
                return $this->errorApiResponse('phone number not yet verified', 422);
            }else {
                return $this->errorApiResponse('Unauthenticated', 401);
            }
        }
    }
}
