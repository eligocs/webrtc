<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;
use Illuminate\Support\Facades\Config;
use Validator;

class ManageInstituteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $institutes = Institute::select('id','name','email','mobile_no','address')->orderBy('created_at', 'desc')->paginate(10);
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $institutes
            ],
            Config::get('constants.key.200')
        );
    } 

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:institutes',            
            'mobile_no' => 'required|min:10|max:10',
            'address' => 'required',
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

        $institute_application = new Institute(); 
        $institute_application->name = $request->name;
        $institute_application->email = $request->email;
        $institute_application->mobile_no = $request->mobile_no;
        $institute_application->address = $request->address; 
        $institute_application->save();
        
        return response()->json(
            [ 
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $institute_application
                
            ],
            Config::get('constants.key.200')
        );

    }

    public function view($id){  
        $institute = Institute::where('id',$id)->firstOrFail();

        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $institute
            ],
            Config::get('constants.key.200')
        );
    }
}
