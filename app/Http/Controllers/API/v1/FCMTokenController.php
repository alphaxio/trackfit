<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FCMTokenController extends Controller
{
    use ApiResponses;

    public function store(Request $request) {
        $this->validate($request, [
            'device_id' => 'nullable',
            'device_name' => 'nullable',
            'fcm_token' => 'required',
        ]);

        $data = Auth::user()->fcm_tokens()->updateOrCreate([
            'device_id' => $request->device_id,
            'device_name' => $request->device_name,
        ],[
            'token' => $request->fcm_token
        ]);

        return $this->okayApiResponse([
            'message' => 'Success update fcm token',
            'data' => $data
        ]);

    }
}
