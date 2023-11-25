<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\DynamicContent;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index(){
        $data = DynamicContent::where('type', 'POLICY')->first();

        return view('privacy-policy', [
            'data' => $data
        ]);
    }
}
