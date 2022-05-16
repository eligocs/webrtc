<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\InstituteApplication;
use Validator;

class InstituteApplicationController extends Controller
{ 
    public function index(Request $request)
    {
        echo 'dsdssd';exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {  
        
        $validator = Validator::make($request->all(), 
        [ 
            'name' => 'required',
            'email' => 'required|email|unique:institute_applications',
            'address' => 'required',
            'mobile_no' => 'required|min:10|max:10',  
            'type_of_class' => 'required',
            'description' => 'required',
        ]); 

        if ($validator->fails()) {          
            return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.failure'),
                    Config::get('constants.key.error') => $validator->errors()
                ],
                Config::get('constants.key.401')
            );
        } 
        
        $data = $request->all(); 
        $data['status'] = 0;
        $institute_application = InstituteApplication::create($data); 
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $institute_application
            ],
            Config::get('constants.key.200')            
        ); 
    }
}
