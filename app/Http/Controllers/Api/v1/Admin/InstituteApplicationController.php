<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\InstituteApplication;
use Validator;

class InstituteApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institute_applications = InstituteApplication::select('id','name','email','address','mobile_no','type_of_class','description','status')->paginate(10);
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $institute_applications
            ],
            Config::get('constants.key.200')
        );
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institute_applications = InstituteApplication::where('id',$id)->firstOrFail();

        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $institute_applications
            ],
            Config::get('constants.key.200')
        );
    }     

    public function make_resolve(Request $request, $id)
    { 
        $institute_application = InstituteApplication::where('id',$id)->firstOrFail();
        $institute_application->status = 1;
        $institute_application->save();

        return response()->json(
            [ 
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.message') => Config::get('constants.admin.institute.resolved')
            ]
        );
    } 


    public function resolved(){ 
        $institute_applications = InstituteApplication::select('id','name','email','address','mobile_no','type_of_class','description','status')->where('status',1)->paginate(10);
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $institute_applications
            ],
            Config::get('constants.key.200')
        );
    }
    
}
