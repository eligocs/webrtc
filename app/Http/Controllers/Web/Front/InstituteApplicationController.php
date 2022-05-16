<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Http\Requests\Web\StoreInstituteApplicationRequest;
use App\Models\InstituteApplication;
use Illuminate\Support\Facades\Config;
use Validator;

class InstituteApplicationController extends Controller
{
    public function index()
    {
        
        return view('front.join-institute');
    } 

    public function thankyou(){
         return view('front.thanxpage');
    }

    public function create(Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:institute_applications',
            'address' => 'required',
            'address2' => 'required',
            'city'=> 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'phone_no' => 'required',   
            'mobile_no' => 'required',  
            'type_of_class' => 'required',
            'description' => 'required',
        ]);
        if ($validator->passes()) {

            $institute_application = new InstituteApplication(); 
            $institute_application->firstname = $request->firstname;
            $institute_application->lastname = $request->lastname;
            $institute_application->name = $request->name;
            $institute_application->email = $request->email;
            $institute_application->address = $request->address;
            $institute_application->address2 = $request->address2;
            $institute_application->city = $request->city;
            $institute_application->state = $request->state;
            $institute_application->zipcode = $request->zipcode;
            $institute_application->phone_no = $request->phone_no;
            $institute_application->mobile_no = $request->mobile_no;
            $institute_application->type_of_class = $request->type_of_class;
            $institute_application->description = $request->description;
            $institute_application->status = 0;
            $institute_application->save();
            
			return response()->json(
                [ 
                    Config::get('constants.key.status') => Config::get('constants.value.success')
                ]
            );
        }
    	return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.failure'),
                Config::get('constants.key.error') => $validator->errors()->all(),
                Config::get('constants.key.message') => Config::get('constants.value.failure_msg')
            ]
        );
    }
}
