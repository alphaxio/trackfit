<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users() {
        $users = User::all();

        return view('users.index', [
            'users' => $users,
        ]);
    }


    public function user($id) {
        $user = User::find($id);

        // $schedule_count = $user->scehdule->count();
        $schedules = Schedule::where('user_id', $id)->orderBy('id', 'desc')->get();
        // dd($schedules);

        return view('users.view', [
            'user' => $user,
            // 'schedule_count' => $schedule_count,
            'schedules' => $schedules


        ]);
    }
}
