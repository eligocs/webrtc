<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    public function logout (Request $request) {
         
        $token = $request->user()->token();
        $token->revoke();
    
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.key.success')
            ], 
            Config::get('constants.key.200')); 
    
    }
    public function getUser() {  
        $user = Auth::user();
        return response()->json([Config::get('constants.key.success') => $user], Config::get('constants.key.200')); 
    }
}
