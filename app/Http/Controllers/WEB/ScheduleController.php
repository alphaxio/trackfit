<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function userSchedule($id)
    {
        $schedule = Schedule::find($id);

        // $regular_days = ExerciseDay::where()

        // dd($schedule->id);

        // return view('schedules.index', [
        //     'schedule' => $schedule,
        // ]);

        return view('schedules.index');

    }
}
