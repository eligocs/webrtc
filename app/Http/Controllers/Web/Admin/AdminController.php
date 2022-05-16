<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Auth;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
  public function index()
  {
    return view('admin.home');
  }

  public function logout(Request $request)
  {
    \Session::flush();
    return redirect('/admin/login')->with(
      Config::get('constants.key.success'),
      Config::get('constants.value.logged_out')
    );
  }

  public function search_classes()
  {
    return view('admin.manage-students.search-classes');
  }

  public function inner_category()
  {
    if (request()->class) {
      $classes = \App\Models\InstituteAssignedClass::where('category_id', request()->category_id)->where('name', 'like', '%' . request()->class . '%')->orderBy('updated_at','desc')->get();
    } else {

      $classes = \App\Models\InstituteAssignedClass::where('category_id', request()->category_id)->orderBy('updated_at','desc')->get();
    }

    return view('admin.manage-students.classes', compact('classes'));
  }

  public function select_timings($class_id, $mode_of_class)
  {

    $m_o_c = $mode_of_class;
    $data['request_data'] = request()->all();
    $data['iacss'] = \App\Models\InstituteAssignedClassSubject::with('subject', 'subjects_infos')->where('institute_assigned_class_id', request()->class_id)->get();

    return view('admin.manage-students.select-timings', ['data' => $data, 'm_o_c' => $mode_of_class]);
  }

  public function checkout()
  {
   $mode_of_class = !empty(request()->mode_of_class) ? request()->mode_of_class : '' ;

 if($mode_of_class == 2){
    request()->validate([
      'row' => 'required|array',
      'row.*.slot' => 'required',
    ]);

    $newArray = [];
    foreach (request()->row as $key => $value) {
      $newArray[] = [
        'day_id' => $key,
        'day' => $value['day'],
        'time_slot_id' => $value['slot']
      ];
    }

    foreach ($newArray as $arr) {

      $found = array_filter($newArray, function ($v) use ($arr) {
        if ($arr['day_id'] != $v['day_id']) {
          return $arr['day'] === $v['day'] &&  $arr['time_slot_id'] === $v['time_slot_id'];
        }
      });

      if (!empty($found)) {

        return redirect()->route('student.select_timings', ['class_id' => request()->class_id])->withInput(['row' => request()->row, "class_id" => request()->class_id])->withErrors(['same_day_same_time_error' => 'You cannot set same time for ' . ucfirst(array_values($found)[0]['day'])]);
      }
    }

    $colors = [
      'orange-gradient',
      'pink-gradient',
      'blue-gradient',
      'green-gradient',
      'sea-gradient',
      'purple-gradient',
    ];

    $class = \App\Models\InstituteAssignedClass::with('institute_assigned_class_subject.subjects_infos.student_subjects_info.time_slot')->find(request()->class_id);

    $session_key = 'student_' . request()->student_id . '_class_' . request()->class_id;
    if (!empty($_SESSION[$session_key])) unset($_SESSION[$session_key]);

    $_SESSION[$session_key] = json_encode([
      'amount' => (request()->amount ?? $class->price) . '00',
      'code' => request()->code,
      'student_id' => request()->student_id,
      'class_id' => request()->class_id,
      'row' => request()->row,
      'mode_of_class' => request()->mode_of_class
    ]);


    return view('admin.manage-students.checkout', ['classes' => Arr::wrap($class), 'colors' => $colors, 'data' => request()->all()]);
    }else{

        $colors = [
        'orange-gradient',
        'pink-gradient',
        'blue-gradient',
        'green-gradient',
        'sea-gradient',
        'purple-gradient',
        ];

        $class =
        \App\Models\InstituteAssignedClass::with('institute_assigned_class_subject.subjects_infos.student_subjects_info.time_slot')->find(request()->class_id);

        $session_key = 'student_' . request()->student_id . '_class_' . request()->class_id;
        if (!empty($_SESSION[$session_key])) unset($_SESSION[$session_key]);

        $_SESSION[$session_key] = json_encode([
        'amount' => (request()->amount ?? $class->price) . '00',
        'code' => request()->code,
        'student_id' => request()->student_id,
        'class_id' => request()->class_id,
        'row' => request()->row,
        'mode_of_class' => request()->mode_of_class
        ]);


        return view('admin.manage-students.checkout', ['classes' => Arr::wrap($class), 'colors' => $colors, 'data' =>
        request()->all()]);


    }
  }

  public function pay()
  {
    //   dd(request()->all());
    request()->validate([
      'form_data' => 'required',
    ]);

    $form_data = json_decode(request()->form_data);
    $m_o_c = !empty($form_data->mode_of_class) ? $form_data->mode_of_class : '';

    // !empty(request()->mode_of_class) ? request()->mode_of_class : '' ;
    // dd();
    $cart = \App\Models\Cart::firstOrNew(['institute_assigned_class_id' => $form_data->class_id, 'student_id' => $form_data->student_id]);
    $cart->form_data = request()->form_data;
    $cart->save();

    $class = \App\Models\InstituteAssignedClass::findOrFail($form_data->class_id);

    if ($cart->coupon_applied) {
      $amount = $class->price - $cart->coupon->discount_in_rs;
    } else {
      $amount = $class->price;
    }
    $student = \App\Models\Student::findOrFail($form_data->student_id);
    return view('admin.manage-students.pay', ['data' => request()->form_data, 'amount' => $amount, 'class' => $class, 'student' => $student, 'enrolled_class' => $cart]);
  }

  public function apply_coupon()
  {
    if (!request()->class_id || !request()->coupon) {
      return response()->json(['status' => 'failed', 'message' => 'Something went wrong.']);
    }

    if ($coupon = \App\Models\Coupon::where('code', request()->coupon)->where(['applicable_type' => 'App\Models\InstituteAssignedClass', 'applicable_id' => request()->class_id, 'deleted_at' => NULL])->first()) {

      $current_time = time();

      $start_time = strtotime($coupon->start_date);
      $end_time = strtotime($coupon->end_date);

      if ($current_time > $start_time && $current_time < $end_time && $coupon->status == 1) {

        if (get_class($coupon->applicable) == "App\Models\InstituteAssignedClass") {

          if ($coupon->applicable->id == request()->class_id) {

            $form_data = json_decode(request()->form_data);
            $cart = \App\Models\Cart::firstOrNew(['institute_assigned_class_id' => $form_data->class_id, 'student_id' => json_decode(request()->form_data)->student_id]);
            $cart->coupon_applied = '1';
            $cart->coupon_id = $coupon->id;
            $cart->form_data = request()->form_data;
            $cart->save();

            return response()->json(['status' => 'success', 'message' => 'Coupon Applied!!!', 'data' => ['amount' => $coupon->applicable->price - $coupon->discount_in_rs, 'code' => $coupon->code]]);
          } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid Coupon!!!']);
          }
        } else {
          // institute
          if ($class = $coupon->applicable->institute_assigned_classes->where('id', request()->class_id)->first()) {
            if ($class->id == request()->class_id) {
              return response()->json(['status' => 'success', 'message' => 'Coupon Applied!!!', 'data' => ['amount' => $class->price - $coupon->discount_in_rs, 'code' => $coupon->code]]);
            } else {
              return response()->json(['status' => 'failed', 'message' => 'Invalid Coupon!!!']);
            }
          } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid Coupon!!!']);
          }
        }
      } else {
        return response()->json(['status' => 'failed', 'message' => 'Invalid Coupon!!!']);
      }
    } else {
      return response()->json(['status' => 'failed', 'message' => 'Invalid Coupon!!!']);
    }
    return response()->json(['status' => 'success', 'message' => 'This is demo response']);
  }

  public function enrollment_in_class()
  {
    //   dd(request()->all());
    $row = [];
    if (request()->hidden) {
      $cart = \App\Models\Cart::findOrFail(decrypt(request()->hidden));
      $requested_data = json_decode($cart->form_data, true);
      $m_o_c = !empty($requested_data['mode_of_class']) ? $requested_data['mode_of_class'] : '';
      // $requested_data = json_decode(request()->hidden, true);
      // $student_id = $cart->student_id;
      // $student_id = $requested_data['student_id'];
      $class_id = $cart->institute_assigned_class_id;

      // $class_id = (int)$requested_data['class_id'];
      $row = $requested_data['row'];
      // $session_key = 'student_' . $student_id . '_class_' . $class_id;
      $class = \App\Models\InstituteAssignedClass::find($class_id);
      // $api = new Api(config('app.razorpay_api_key'), config('app.razorpay_api_secret'));

      // if (isset($requested_data['code']) && $requested_data['code'] != null) {
      if ($cart->coupon_applied) {
        $coupon = \App\Models\Coupon::findOrFail($cart->coupon_id);
        // $coupon = \App\Models\Coupon::where('code', $requested_data['code'])->where(['applicable_type' => 'App\Models\InstituteAssignedClass', 'applicable_id' => $class_id, 'deleted_at' => NULL])->firstOrFail();
        $amount = $class->price - $coupon->discount_in_rs;
        $coupon_id = $coupon->id;
        $coupon_applied = '1';
      } else {
        // dd("hem");
        $amount = $class->price;
        $coupon_id = null;
        $coupon_applied = '0';
      }
      // $payment = $api->payment->fetch(request()->razorpay_payment_id);
      $error = false;
      try {
        // $payment->capture(array('amount' => (float)($amount) * 100, 'currency' => 'INR'));
      } catch (\Throwable $th) {
        $error = true;
        // abort(400, 'Something Went Wrong');
        die('Something Went Wrong');
      }
      if ($error) {
        abort(400, 'Something Went Wrong');
      }
if($m_o_c == 2){
      foreach ($row as $key => $value) {

        \App\Models\StudentSubjectsInfo::create([
          'student_id' => $requested_data['student_id'],
          'subjects_info_id' => $key,
          'time_slot_id' => $value['slot'],
        ]);
      }
    }else{
        foreach ($row as $key => $value) {

        \App\Models\StudentSubjectsInfo::create([
        'student_id' => $requested_data['student_id'],
        'subjects_info_id' => $key,
        ]);
        }

    }
      \App\Models\InstituteAssignedClassStudent::create([
        'institute_assigned_class_id' => $class_id,
        'student_id' => $requested_data['student_id'],
        'razorpay_payment_id' => 'manual_enrollment',
        'coupon_id' => $coupon_id,
        'coupon_applied' => $coupon_applied,
        'mode_of_class' => $requested_data['mode_of_class']
      ]);

      $cart->delete();
    } else {
      abort(400);
    }

    $students = \App\Models\User::orderBy('created_at', 'desc')->where('role', 'student')->get();
    session()->flash('message', 'Student Enrolled Successfully.');
    return view('admin.manage-students.index', compact('students'));
  }
}
