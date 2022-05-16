<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Validator;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function name(){
        return view('front.student.signup.name');
    }

    public function phone_number(Request $request){  
        $data = array(); 
        $data['name'] =  $request->name ?? '';
        return view('front.student.signup.phone-number',$data);
    }

    public function reset_password(){
      $validator = Validator::make(request()->all(), [
        'password' => 'required|min:6',
        'confirm_password' => 'required|same:password',
      ]);
      
      if ($validator->passes()) {
        // var_dump(request()->phone);die;
        
        $user = \App\Models\User::where('phone', request()->phone)->first();
        $user->password = bcrypt(request()->password);
        $user->save();

        return response()->json(
          [
            Config::get('constants.key.status') => Config::get('constants.value.success'),
            Config::get('constants.key.message') => "Password Changed Successfully.",
            // Config::get('constants.front.key.otp') => $otp
          ]
        );
      }else{
        return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.failure'),
                    Config::get('constants.key.error') => $validator->errors()->all() 
                ]
            );
      }
    }


    public function reset_password_institute(){
      $validator = Validator::make(request()->all(), [
        'oldpassword'=>'required',
        'password' => 'required|min:6',
        'confirm_password' => 'required|same:password',
      ]);
    if ($validator->passes()) {  
      $phone = request()->phone;
      $email = request()->email;
      $oldpassword = request()->oldpassword;
      $user = \DB::table('users')->where('email', $email)->first();      
      if(\Hash::check($oldpassword, $user->password)){

      $update = \DB::table('users')
       ->where('phone', request()->phone) ->limit(1)
        ->update( [ 'password' => Hash::make(request()->password), 'reset_password_status'=> null]); 
          return response()->json(
          [
            Config::get('constants.key.status') => Config::get('constants.value.success'),
            Config::get('constants.key.message') => "Password Changed Successfully.Now Login",
          ]
        );
 
    }else{
 
         return response()->json(
          [
            Config::get('constants.key.status') => Config::get('constants.value.failure'),
            Config::get('constants.key.message') => "Old Password Are  Not Same",
          ]
        );
 
    }
    }else{
        return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.failure'),
                    Config::get('constants.key.error') => $validator->errors()->all() 
                ]
            );
      }
    }



    public function otp(Request $request){
        $otp = mt_rand(100000,999999); 
        $request->session()->put('otp', $otp);
        $otp_time = $request->otp_time ?? '';
        $request->session()->put('otp_time', $otp_time);
        $data = array();
        $data['name'] =  $request->name ?? '';
        $data['phone_number'] =  $request->phone_number ?? '';

        return view('front.student.signup.otp',$data);
    }

    public function password(Request $request){
        $data = array();
        $data['name'] =  $request->name ?? '';
        $data['phone_number'] =  $request->phone_number ?? '';

        $received_otp = $request->otp;
        $otp = $request->session()->get('otp'); 
        if($received_otp == $otp){
            return view('front.student.signup.password',$data);
        }
        else
        {            
            return redirect()->back()->with(
                Config::get('constants.key.error'),Config::get('constants.front.value.otp_mismatch')
            );
            
        }        
    } 

    public function register_student(Request $request){  
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users|min:10|max:12',
            'grade' => 'required',
            'state' => 'required',
            'city' => 'required',
            'password' => 'required|min:6', 
            'confirm_password' => 'required|same:password',             
        ]);              

        if ($validator->passes()) {
            $student = Student::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' =>  '',
                'grade' => $request->grade,
                'state' => $request->state,
                'city' => $request->city,
            ]);
            User::create([
                'student_id' => $student->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' =>  $request->phone.'@email.com',
                'grade' => $request->grade,
                'state' => $request->state,
                'city' => $request->city,
                'role' => 'student',
                'password' => bcrypt($request->password), 
            ]);

            $otp = mt_rand(100000,999999);

            $msg91_key = config('app.msg91_key');
            $msg91_template_id = config('app.msg91_template_id');

            $get_url = "https://api.msg91.com/api/v5/otp?authkey=$msg91_key&template_id=$msg91_template_id&mobile=91$request->phone&otp=$otp";

            $response = true;
            $count = 0;
            do {
              $response = $this->send_otp($get_url);
              $count += 1;
              if($count > 3){
                $response = true;
              }
            } while (!$response);

            $request->session()->forget('otp');
            $request->session()->put('otp', $otp);

            return response()->json(
                [ 
                    Config::get('constants.key.status') => Config::get('constants.value.success'),
                    Config::get('constants.key.message') => Config::get('constants.front.value.otp_sent'),
                    // Config::get('constants.front.key.otp') => $otp
                ]
            );
        }
        else
        {
            return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.failure'),
                    Config::get('constants.key.error') => $validator->errors()->all() 
                ]
            );
        }
    }

    public function send_otp($get_url){

      try {
        $response = json_decode(file_get_contents($get_url), true);
        
        if (!$response && $response['type'] != 'success') {
          return false;
        }
        // $response = json_decode(file_get_contents($get_url), true);
        return true;
      } catch (\Throwable $th) {
        return false;
      }
      return false;
    }

    public function resend_otp()
    {
      $msg91_key = config('app.msg91_key');
      $msg91_template_id = config('app.msg91_template_id');
      $phone = request()->phone;
      $otp = request()->session()->get('otp');

      $get_url = "https://api.msg91.com/api/v5/otp?authkey=$msg91_key&template_id=$msg91_template_id&mobile=91$phone&otp=$otp";

      $response = true;
      $count = 0;
      do {
        $response = $this->send_otp($get_url);
        $count += 1;
        if ($count > 3) {
          $response = true;
        }
      } while (!$response);

      return response()->json(
        [
          Config::get('constants.key.status') => Config::get('constants.value.success'),
          Config::get('constants.key.message') => Config::get('constants.front.value.otp_sent'),
          // Config::get('constants.front.key.otp') => $otp
        ]
      );
    }

    public function generate_otp(){
      $msg91_key = config('app.msg91_key');
      $msg91_template_id = config('app.msg91_template_id');
      $phone = request()->phone;
      $otp = mt_rand(100000,999999);
            
      $get_url = "https://api.msg91.com/api/v5/otp?authkey=$msg91_key&template_id=$msg91_template_id&mobile=91$phone&otp=$otp";
      
      $response = true;
      $count = 0;
      do {
        $response = $this->send_otp($get_url);
        $count += 1;
        if ($count > 3) {
          $response = true;
        }
      } while (!$response);
      
      request()->session()->forget('otp');
      request()->session()->put('otp', $otp);
      // dd($response);
      
      return response()->json(
        [
          Config::get('constants.key.status') => Config::get('constants.value.success'),
          Config::get('constants.key.message') => Config::get('constants.front.value.otp_sent'),
          // Config::get('constants.front.key.otp') => $otp
        ]
      );
    }

    public function verify_otp(Request $request){

        $digit1 = $request->digit1 ?? '';
        $digit2 = $request->digit2 ?? '';
        $digit3 = $request->digit3 ?? '';
        $digit4 = $request->digit4 ?? '';
        $digit5= $request->digit5 ?? '';
        $digit6 = $request->digit6 ?? '';

        $received_otp = $digit1.$digit2.$digit3.$digit4.$digit5.$digit6;
        // dd($received_otp);
        $otp = $request->session()->get('otp'); 

        if($received_otp == $otp){
            return response()->json(
                [ 
                    Config::get('constants.key.status') => Config::get('constants.value.success'),
                    Config::get('constants.key.message') => Config::get('constants.front.value.otp_match')                     
                ]
            );
        }
        else
        {
            return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.failure'),
                    // Config::get('constants.key.error') => Config::get('front.value.otp_mismatch')
                    Config::get('constants.key.error') => 'OTP does not match. Please try agian!!!'
                ]
            );
        }
        
    }

    
}

