<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\DynamicContent;
use Illuminate\Http\Request;

class TermOfUseController extends Controller
{
    public function index(){
        $data = DynamicContent::where('type', 'TERMS')->first();

        return view('term-of-use', [
            'data' => $data
        ]);
    }
}
