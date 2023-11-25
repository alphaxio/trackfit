<?php

namespace App\Http\Middleware;

use App\Models\Schedule;
use Closure;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSchedule
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

        $user  = auth()->user();

        $check_schedule = Schedule::query()->where('user_id', $user->id)->exists();


        if (Auth::guard('api')->check() && $check_schedule == false) {
            return $next($request);
        } else {
            return $this->errorApiResponse('Create a schedule to access other functions', 400);
        }
    }
}
