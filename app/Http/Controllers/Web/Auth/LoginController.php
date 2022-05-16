<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use DB;
use Auth;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  // protected $redirectTo = '/admin';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function admin_login_form()
  {
    return view('auth.admin.login');
  }

  public function institute_login_form()
  {
    return view('auth.institute.login');
  }

  public function student_login_form()
  {
    return view('auth.student.login');
  }

  public function login(Request $request)
  {
    $type = $request->type ?? '';

    if ($type) {

      $this->validate($request, [
        'phone' => 'required|numeric|min:10',
        'password' => 'required',
      ]);
      
      $user = \DB::table('users')->where('phone', $request->input('phone'))->first();
      if (empty($user)) {
        \Session::flash(Config::get('constants.key.login_error'), Config::get('constants.value.student_login_error'));
        \Session::flash('message', 'Your account is not in the AVESTUD. Please register it.');
        return redirect()->back();
      }
      
      if (auth()->guard('web')->attempt(['phone' => $request->input('phone'), 'password' => $request->input('password')])) {
        
        $new_sessid   = \Session::getId();
        
        if ($user->session_id != '') {
          $last_session = \Session::getHandler()->read($user->session_id);
          
          if ($last_session) {
            if (\Session::getHandler()->destroy($user->session_id)) {
            }
          }
        }
        
        \DB::table('users')->where('id', $user->id)->update(['session_id' => $new_sessid]);
        
        $user = auth()->guard('web')->user();


        return redirect('/student');
      }
      \Session::flash(Config::get('constants.key.login_error'), Config::get('constants.value.student_login_error'));
      \Session::flash('message', 'Your password is incorrect!!!');
      return back();
    } else {
      $this->validate($request, [
        'email' => 'required',
        'password' => 'required',
      ]);

      $user = \DB::table('users')->where('email', $request->input('email'))->first();
      if(!empty($user->reset_password_status)){
        $rps = $user->reset_password_status;
        $o_l_p = $user->password;
        $email = $user->email;
        $phno =  $user->phone;
          return view('auth.institute.forget',compact('rps', 'o_l_p','email','phno'));
      }

      if (auth()->guard('web')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

        // if($user->email_verified_at == null) {
        //     //\Auth::logout();
        //     echo 'u r not verified';exit;
        //     return redirect()->intended('/admin/login');
        // }

        $new_sessid   = \Session::getId();

        if ($user->session_id != '') {
          $last_session = \Session::getHandler()->read($user->session_id);

          if ($last_session) {
            if (\Session::getHandler()->destroy($user->session_id)) {
            }
          }
        }

        \DB::table('users')->where('id', $user->id)->update(['session_id' => $new_sessid]);

        $user = auth()->guard('web')->user();

        // Check user role & redirect them according to role

        $role = Auth::user()->role;

        switch ($role) {

          case 'admin':
            return redirect('/admin/institute-applications');
            break;

          case 'institute':
            return redirect('/institute');
            break;

          case 'student':
            return redirect('/student');
            break;

          default:
            return redirect('/login');
            break;
        }
      }

      \Session::put(Config::get('constants.key.login_error'), Config::get('constants.value.login_error'));
      return back();
    }
  }

  public function logout(Request $request)
  {
    $role = Auth::user()->role;
    // dd(Auth::user()->role);
    \Session::flush();
    \Session::put(Config::get('constants.key.success'), '');
    try {
      switch ($role) {

        case 'admin':
          return redirect('/admin/login');
          break;

        case 'institute':
          return redirect('/institute/login');
          break;

        case 'student':
          return redirect('/');
          return redirect('/student/login');
          break;

        default:
          return redirect('/');
          break;
      }
    } catch (\Throwable $th) {
      return redirect('/');
    }
  }


  public function institute_forget_form()
  {
    return view('auth.institute.forget');
  }


  public function institute_otp_verification()
  {
    return view('auth.institute.instituteopt');
  }
}
