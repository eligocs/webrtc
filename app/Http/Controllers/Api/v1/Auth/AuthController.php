<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;


class AuthController extends Controller
{   

    public function register(Request $request) { 

        $validator = Validator::make($request->all(), 
        [ 
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8', 
            'confirm_password' => 'required|same:password', 
        ]);   
        if ($validator->fails()) {          
            return response()->json(
                [
                    Config::get('constants.key.error') => $validator->errors()
                ],
                Config::get('constants.key.401')
            );
        }    
        $input = $request->all();  
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input); 
        $success['token'] =  $user->createToken('AVESTUD')->accessToken;
        return response()->json(
            [
                Config::get('constants.key.success') => $success
            ],
            Config::get('constants.key.200')
        ); 
    }
  
   
    public function login(){     
        if(Auth::attempt(['email' => request('username'), 'password' => request('password')])){ 
            $user = Auth::user();  
            $success['token'] =  $user->createToken('AVESTUD')->accessToken; 
            $success['userData'] =  $user; 
            return response()->json(
                [   
                    Config::get('constants.key.status') => Config::get('constants.value.success'),
                    Config::get('constants.key.data') => $success
                ],
                Config::get('constants.key.200')
            ); 
        }
        else
        { 
    
            return response()->json(
                [
                    Config::get('constants.key.error') => Config::get('constants.value.unauthenticated')
                ],
                Config::get('constants.key.401')
            );
       
            
        }
    } 
    
    
         

     

    
    
}