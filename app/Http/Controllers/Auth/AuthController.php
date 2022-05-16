<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Config;
use App\Models\Student;
class AuthController extends Controller
{
    public function login(Request $request) {    
        $isstudent =  Student::where('phone',$request->email)->first(); 
        if(!empty($isstudent)){
            $email = $request->email;
            $password = $request->password; 
            $user = Student::where('email',$request->email.'@email.com')->first();
            
            if (auth()->guard('web')->attempt(['phone' => $email, 'password' => $password])) { 
                $user = $request->user(); 
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($request->remember_me)
                    $token->expires_at = Carbon::now()->addWeeks(1);
                    $token->save();
                    return response()->json([
                        'access_token' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'role' => $user->role,
                        'userdetails' => $user,
                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString()
                    ]);
            }else{
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401); 
            }
        } 
     
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            //'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
        $user = $request->user(); 
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'role' => $user->role,
                'userdetails' => $user,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
    }

    public function resendOtp()
    {
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
        return response()->json(
            [
            Config::get('constants.key.status') => Config::get('constants.value.success'),
            Config::get('constants.key.message') => Config::get('constants.front.value.otp_sent'),
            Config::get('constants.front.key.otp') => $otp
            ]
        );
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
  

    public function institute(Request $request){
        return Auth::user();
    }

    public function register(Request $request)
    {
        $request->validate([
            'fName' => 'required|string',
            'lName' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
        $user = new User;
        $user->first_name = $request->fName;
        $user->last_name = $request->lName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function forgotAction(Request $request){  
        $otp = mt_rand(100000,999999);

        $msg91_key = config('app.msg91_key');
        $msg91_template_id = config('app.msg91_template_id');

        $get_url = "https://api.msg91.com/api/v5/otp?authkey=$msg91_key&template_id=$msg91_template_id&mobile=91$request->phone&otp=$otp";
        $response = $this->send_otp($get_url);
        if($response){
            return response()->json([
                'status' => 200,
                'message' => 'OTP has been sent to your phone number',
                'otp' => $otp, 
                'phone' => $request->phone, 
                'res'=> $response, 
            ]); 
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'Fail to send otp, try again !!!', 
                'res'=> $response, 
            ]); 
        }
    }

    public function updatepassword(Request $request){
        if(!empty($request->phone) && !empty($request->password)){
            User::where('phone',$request->phone)->update([  
                'password' => bcrypt($request->password), 
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Password Updated Successfully', 
            ]); 
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Phone & Password Required !!!', 
            ]); 
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

            /* $request->session()->forget('otp');
            $request->session()->put('otp', $otp); */
            return response()->json([
                'status' => 200,
                'message' => 'OTP has been sent to your registered phone number',
                'otp' => $otp,
                'phone' => $request->phone,
                'pwd' => $request->password, 
            ]); 
        }
        else
        {
            return response()->json([
                'status' => Config::get('constants.value.failure'),
                'message' => $validator->errors()->all() ,
                'otp' => '',
                'phone' => '',
                'pwd' => '', 
            ]);
          /*   return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.failure'),
                    Config::get('constants.key.error') => $validator->errors()->all() ,
                    Config::get('constants.front.key.otp') => '',
                    Config::get('constants.front.key.phone') => ''
                ]
            ); */
        }
    }

    
  
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}