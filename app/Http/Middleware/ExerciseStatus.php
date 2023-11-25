<?php

namespace App\Http\Middleware;

use App\Models\DailySchedule;
use App\Models\Schedule;
use App\Traits\ApiResponses;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExerciseStatus
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

        $params = request()->route()->parameters;

        $id = intval($params['id']);
        $date = Carbon::parse($params['date']);

        $check_schedule = Schedule::query()->where("id", $id)->where("user_id", auth()->user()->id)->exists();
        if(! $check_schedule)
        {
            return $this->errorApiResponse('Schedule not found', 404);
        }

        $daily_schedule = DailySchedule::where('date', Carbon::parse($date))->where('schedule_id', $id)->first();
                                                                                                                                );

        if($daily_schedule) {
            if (Auth::guard('api')->check() &&  $daily_schedule->exercise_status == null) {
                return $this->errorApiResponse('How should we treat this schedule ? Personal Exercise or Official PT ?', 400);
            }
        }
        return $next($request);
    }
}
