<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstituteClass;
use App\Models\Student;
use App\Models\ClassNotification;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Assignments_unit;
use App\Models\student_attendance;
use App\Models\StudentTrialPeriod;
use App\Models\Theoryanswer;
use App\Models\InstituteAssignedClassStudent;
use Illuminate\Support\Arr;
use Razorpay\Api\Api;
use Carbon\Carbon;
use App\Models\Meeting;
use \Firebase\JWT\JWT;
use GuzzleHttp\Client;
use DateTime;
use App\Models\Topic;
use DB;
use App\Models\Theory_answer_marks;
use App\Models\Test_unit;
use Illuminate\Support\Facades\Validator;
// 2021-07-02 05:45 PM
class StudentController extends Controller
{


    public static function meetingList()
    {
        // dd(date('Y-m-d h:i A'));
        // $unit = Meeting::get('unit');
        $segment =  request()->segment(3);
        $data['live'] = Meeting::where('i_a_c_s_id', $segment)
            ->whereDate('date', date('Y-m-d'))
            ->first();
        return $data;
    }

    public function index()
    {
        // dd(auth()->user()->student_id);
        $student_details = \App\Models\Student::with('institute_assigned_class.institute_assigned_class_subject.subject', 'institute_assigned_class.institute_assigned_class_subject.subjects_infos.student_subjects_info.time_slot')->find(auth()->user()->student_id);
        //       foreach($student_details->institute_assigned_class as  $class){
        //           if( $class->institute_assigned_class_subject->count() ){
        //             foreach($class->institute_assigned_class_subject as $key => $institute_assigned_class_subject){
        //           $iacs = \App\Models\InstituteAssignedClassSubject::where(['institute_assigned_class_id' => $class->id,
        //           'subject_id' => $institute_assigned_class_subject->subject->id])->first();
        //           // dd($iacs->institute_assigned_class_id);
        //           if(!empty($iacs)){
        //               $iacs_id = $iacs->id;
        //             }
        //             // dd($iacs_id);
        //             $iacss = \App\Models\instituteAssignedClassSubject::findOrFail($iacs_id);
        //             $iac = $iacss->institute_assigned_class;

        //             try{
        //             $lecture = $iacs->lectures->where('lecture_date', date('Y-m-d 00:00:00'))->first();
        //             if(empty($lecture)){
        //                 $lecture = $iacs->lectures->where('lecture_date', '>' ,date('Y-m-d 00:00:00'))->first();

        //           }
        //           $lecture_url = $lecture->lecture_video;
        //           $lecture_id = $lecture->id;
        //           $lecture_date = date('Y-m-d', strtotime($lecture->lecture_date));
        //           $lecture_day = date('l', strtotime($lecture->lecture_date));
        //         $lecture_time_in_unix_timestamp = strtotime(date('Y-m-d', strtotime($lecture->lecture_date)));
        //         //   dd($lecture_time_in_unix_timestamp);

        //         }catch(\Throwable $th){
        //           $lecture_url = '';
        //           $lecture_id = '';
        //           $lecture_date = '';
        //           $time = '';
        //           $lecture_time_in_unix_timestamp = strtotime('23:59:59');

        //             }

        //         }
        //     }
        // }

        // $l_D_a_t_e = Lecture:: where('lecture_date',date('Y-m-d 00:00:00'))->first();
        // dd($lecruredate);
        // return view('student.home', ['classes' => $student_details->institute_assigned_class, 'lecture_date'=> $lecture_date, 'iac' => $iac, 'iacs' => $iacs, 'lectureget' => $lecture_url, "lecture_id" => $lecture_id, 'lecture_time_in_unix_timestamp' =>$lecture_time_in_unix_timestamp]);
        return view('student.home', ['classes' => $student_details->institute_assigned_class]);
    }

    public function download_receipt()
    {
        return view('student.download-receipt');
    }



    public function generate_receipt()
    {
        $class = \App\Models\InstituteAssignedClass::find(request()->class_id);
        if (empty($class->students->where('id', auth()->user()->student_id)->first())) {
            abort(404);
        }
        $student = $class->students->where('id', auth()->user()->student_id)->first();
        $enrolled_class = \App\Models\InstituteAssignedClassStudent::where('institute_assigned_class_id', $class->id)->where('student_id', $student->id)->first();
        // return view('student.receipt', ['class' => $class, 'student' => $student, 'enrolled_class' => $enrolled_class]);
        $pdf = app('dompdf.wrapper')->loadView('student.receipt', ['class' => $class, 'student' => $student, 'enrolled_class' => $enrolled_class]);
        return $pdf->stream('invoice.pdf');
    }

    public function my_classes()
    {

        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];
        // $enrolled_classes = auth()->user()->student->institute_assigned_classes->pluck('');
        $enrolled_classes = auth()->user()->student->institute_assigned_classes;
        // dd($enrolled_classes);
        $classes = $enrolled_classes->load(['institute_assigned_class_subject.subjects_infos.student_subjects_info.time_slot']);
        $all_subjects = collect([]);
        foreach ($classes as $class) {
            $all_subjects = $all_subjects->merge($class->institute_assigned_class_subject);
        }
        return view('student.my-classes', ['all_subjects' => $all_subjects, 'colors' => $colors]);
    }

    public function profile()
    {
        return view('student.profile');
    }

    public function change_profile()
    {

        request()->validate([
            'name' => 'required',
            'state' => 'required',
            'city' => 'required',
            'grade' => 'required',
        ]);

        $student = Student::findOrFail(auth()->user()->student_id);
        $student->name = request()->name;
        $student->email = request()->email ?? '';
        $student->board = request()->board ?? '';
        $student->date_of_birth = request()->date_of_birth ?? '';
        $student->gender = request()->gender ?? '';
        if (request()->hasFile('avatar')) {
            $file = request()->file('avatar');
            $file_name = $file->store('/students/profile', 's3');
            // $array = explode('/', $file_name);
            // array_shift($array);
            // $student->avatar = '/storage/' . implode('/', $array);
            $student->avatar = $file_name;
        }

        $student->state = request()->state ?? '';
        $student->city = request()->city ?? '';
        $student->grade = request()->grade ?? '';

        $student->save();

        $user = User::findOrFail(auth()->user()->id);
        $user->name = request()->name;
        $user->state = request()->state ?? '';
        $user->city = request()->city ?? '';
        $user->grade = request()->grade ?? '';

        $user->save();
        session()->flash('message', 'Profile Updated.');
        return redirect()->back()->with(['success' => 'Updated Successfully']);
    }

    public function change_password()
    {

        request()->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->password = bcrypt(request()->password);
        $user->save();
        session()->flash('message', 'Password Changed Successfully.');
        return redirect()->back()->with(['success' => 'Password changed']);
    }

    public function search_classes()
    {
        return view('student.search-classes');
    }

    public function inner_category()
    {
        if (request()->class) {
            $classes = \App\Models\InstituteAssignedClass::where('category_id', request()->category_id)->where('name', 'like', '%' . request()->class . '%')->orderBy('updated_at', 'desc')->get();
        } else {
            $classes = \App\Models\InstituteAssignedClass::where('category_id', request()->category_id)->orderBy('updated_at', 'desc')->get();
        }

        return view('student.classes', compact('classes'));
    }

    public function detail()
    {
        return view('student.detail');
    }

    public function select_timings($class_id, $mode_of_class)
    {
        // dd(request()->all());
        $m_o_c = $mode_of_class;
        $data['request_data'] = request()->all();
        $data['iacss'] = \App\Models\InstituteAssignedClassSubject::with('subject', 'subjects_infos')->where('institute_assigned_class_id', request()->class_id)->get();
        return view('student.select-timings', ['data' => $data, 'm_o_c' => $m_o_c]);
    }



    public function select_timingsfree($class_id, $mode_of_class)
    {
        $m_o_c = $mode_of_class;
        $data['request_data'] = request()->all();
        $data['iacss'] = \App\Models\InstituteAssignedClassSubject::with('subject', 'subjects_infos')->where('institute_assigned_class_id', request()->class_id)->get();
        return view('student.select-timings', ['data' => $data, 'm_o_c' => $m_o_c]);
        // dd($data);
    }

    public function checkout()
    {

        if (request()->mode_of_class == 2) {


            request()->validate([
                'row' => 'required|array',
                'row.*.slot' => 'required',
            ]);
            $isfreetrial = false;
            if (!empty(request()->freetrial) && request()->freetrial == 1) {
                // dd("dsagjk");
                $isfreetrial = true;
            }

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

            $session_key = 'student_' . auth()->user()->student_id . '_class_' . request()->class_id;
            if (!empty($_SESSION[$session_key])) unset($_SESSION[$session_key]);

            $_SESSION[$session_key] = json_encode([
                'amount' => (request()->amount ?? $class->price) . '00',
                'code' => request()->code,
                'student_id' => auth()->user()->student_id,
                'class_id' => request()->class_id,
                'row' => request()->row,
                'mode_of_class' => request()->mode_of_class
            ]);
            // dd($_SESSION[$session_key]);
            return view('student.checkout', ['classes' => Arr::wrap($class), 'colors' => $colors, 'data' => request()->all(), 'isfreetrial' => $isfreetrial]);
        } else {
            // dd("fhklg");
            $isfreetrial = false;
            if (!empty(request()->freetrial) && request()->freetrial == 1) {
                // dd("dsagjk");
                $isfreetrial = true;
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

            $session_key = 'student_' . auth()->user()->student_id . '_class_' . request()->class_id;
            if (!empty($_SESSION[$session_key])) unset($_SESSION[$session_key]);

            $_SESSION[$session_key] = json_encode([
                'amount' => (request()->amount ?? $class->price) . '00',
                'code' => request()->code,
                'student_id' => auth()->user()->student_id,
                'class_id' => request()->class_id,
                'row' => request()->row,
                'mode_of_class' => request()->mode_of_class
            ]);
            // dd($_SESSION[$session_key]);
            return view('student.checkout', ['classes' => Arr::wrap($class), 'colors' => $colors, 'data' => request()->all(), 'isfreetrial' => $isfreetrial]);
        }
    }

    public function pay()
    {
        // dd(request()->all());
        request()->validate([
            'form_data' => 'required',
        ]);
        $form_data = json_decode(request()->form_data);
        if ($form_data->mode_of_class == 2) {
            $cart = \App\Models\Cart::firstOrNew(['institute_assigned_class_id' => $form_data->class_id, 'student_id' => auth()->user()->student_id]);
            $cart->form_data = request()->form_data;
            $cart->save();
            $class = \App\Models\InstituteAssignedClass::findOrFail($form_data->class_id);
            if (!empty($class)) {
                $today = date("Y-m-d");
                $start = $class->start_date;
                if ($start <= $today) {
                    $date = strtotime($today);
                    $start_date = date('Y-m-d', strtotime("+1day", $date));
                    $end_date = date('Y-m-d', strtotime("+7 day", $date));
                } elseif ($start > $today) {
                    $date = strtotime($start);
                    $start_date = date('Y-m-d', strtotime("+1day", $date));
                    $end_date = date('Y-m-d', strtotime("+7 day", $date));
                }

                if (!empty(request()->free_trial) && request()->free_trial == 'yes') {
                    // dd("dh gjdfhj");
                    $cart = \App\Models\Cart::findOrFail($cart->id);
                    $requested_data = json_decode($cart->form_data, true);
                    $row = $requested_data['row'];
                    foreach ($row as $key => $value) {

                        \App\Models\StudentSubjectsInfo::create([
                            'student_id' => auth()->user()->student_id,
                            'subjects_info_id' => $key,
                            'time_slot_id' => $value['slot'],
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                        ]);
                    }
                    // dd($form_data->mode_of_class);
                    \App\Models\StudentTrialPeriod::create([
                        'student_id' => auth()->user()->student_id,
                        'class_id' => $class->id,
                    ]);
                    \App\Models\InstituteAssignedClassStudent::create([
                        'price' => '0',
                        'institute_assigned_class_id' => $class->id,
                        'student_id' => auth()->user()->student_id,
                        'razorpay_payment_id' => '-',
                        'coupon_id' => null,
                        'coupon_applied' => '0',
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'mode_of_class' => $form_data->mode_of_class
                    ]);

                    $cart->delete();
                    return redirect()->route('student.home')->with(['success' => 'Your 7 days free trial will start from ' . $start_date . ' to ' . $end_date . '.']);;
                }
            }


            if ($cart->coupon_applied) {
                $amount = $class->price - $cart->coupon->discount_in_rs;
            } else {
                $amount = $class->price;
            }
            $student = \App\Models\Student::findOrFail(auth()->user()->student_id);
            return view('student.pay', ['data' => request()->form_data, 'amount' => $amount, 'class' => $class, 'student' => $student, 'enrolled_class' => $cart]);
        } else {

            $cart = \App\Models\Cart::firstOrNew(['institute_assigned_class_id' => $form_data->class_id, 'student_id' => auth()->user()->student_id]);
            $cart->form_data = request()->form_data;
            $cart->save();
            $class = \App\Models\InstituteAssignedClass::findOrFail($form_data->class_id);
            if (!empty($class)) {
                $today = date("Y-m-d");
                $start = $class->start_date;
                if ($start <= $today) {
                    $date = strtotime($today);
                    $start_date = date('Y-m-d', strtotime("+1day", $date));
                    $end_date = date('Y-m-d', strtotime("+7 day", $date));
                } elseif ($start > $today) {
                    $date = strtotime($start);
                    $start_date = date('Y-m-d', strtotime("+1day", $date));
                    $end_date = date('Y-m-d', strtotime("+7 day", $date));
                }

                if (!empty(request()->free_trial) && request()->free_trial == 'yes') {
                    // dd("dh gjdfhj");
                    $cart = \App\Models\Cart::findOrFail($cart->id);
                    $requested_data = json_decode($cart->form_data, true);
                    $row = $requested_data['row'];
                    // dd($row);
                    foreach ($row as $key => $value) {

                        \App\Models\StudentSubjectsInfo::create([
                            'student_id' => auth()->user()->student_id,
                            'subjects_info_id' => $key,
                            // 'time_slot_id' => $value['slot'],
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                        ]);
                    }
                    // dd($form_data->mode_of_class);
                    \App\Models\StudentTrialPeriod::create([
                        'student_id' => auth()->user()->student_id,
                        'class_id' => $class->id,
                    ]);
                    \App\Models\InstituteAssignedClassStudent::create([
                        'price' => '0',
                        'institute_assigned_class_id' => $class->id,
                        'student_id' => auth()->user()->student_id,
                        'razorpay_payment_id' => '-',
                        'coupon_id' => null,
                        'coupon_applied' => '0',
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'mode_of_class' => $form_data->mode_of_class
                    ]);

                    $cart->delete();
                    return redirect()->route('student.home')->with(['success' => 'Your 7 days free trial will start from ' . $start_date . ' to ' . $end_date . '.']);;
                }
            }


            if ($cart->coupon_applied) {
                $amount = $class->price - $cart->coupon->discount_in_rs;
            } else {
                $amount = $class->price;
            }
            $student = \App\Models\Student::findOrFail(auth()->user()->student_id);
            return view('student.pay', ['data' => request()->form_data, 'amount' => $amount, 'class' => $class, 'student' => $student, 'enrolled_class' => $cart]);
        }
    }


    public function enrollment_in_class(Request $request)
    {

        if ($request->mode_of_class == 2) {
            $row = [];
            if (request()->hidden && request()->razorpay_payment_id) {
                $cart = \App\Models\Cart::findOrFail(decrypt(request()->hidden));
                $requested_data = json_decode($cart->form_data, true);
                // dd($requested_data);
                // $requested_data = json_decode(request()->hidden, true);
                // $student_id = $cart->student_id;
                // $student_id = $requested_data['student_id'];
                $class_id = $cart->institute_assigned_class_id;
                // $class_id = (int)$requested_data['class_id'];
                $row = $requested_data['row'];
                // $session_key = 'student_' . $student_id . '_class_' . $class_id;
                $class = \App\Models\InstituteAssignedClass::find($class_id);
                $api = new Api(config('app.razorpay_api_key'), config('app.razorpay_api_secret'));


                // if (isset($requested_data['code']) && $requested_data['code'] != null) {
                if ($cart->coupon_applied) {
                    $coupon = \App\Models\Coupon::findOrFail($cart->coupon_id);
                    // $coupon = \App\Models\Coupon::where('code', $requested_data['code'])->where(['applicable_type' => 'App\Models\InstituteAssignedClass', 'applicable_id' => $class_id, 'deleted_at' => NULL])->firstOrFail();
                    $amount = $class->price - $coupon->discount_in_rs;
                    $coupon_id = $coupon->id;
                    $coupon_applied = '1';
                } else {
                    $amount = $class->price;
                    $coupon_id = null;
                    $coupon_applied = '0';
                }
                $payment = $api->payment->fetch(request()->razorpay_payment_id);
                $error = false;
                try {
                    $payment->capture(array('amount' => (float)($amount) * 100, 'currency' => 'INR'));
                } catch (\Throwable $th) {
                    $error = true;
                    // abort(400, 'Something Went Wrong');
                    die('Something Went Wrong');
                }
                if ($error) {
                    abort(400, 'Something Went Wrong');
                }

                foreach ($row as $key => $value) {

                    \App\Models\StudentSubjectsInfo::create([
                        'student_id' => auth()->user()->student_id,
                        'subjects_info_id' => $key,
                        'time_slot_id' => $value['slot'],
                    ]);
                }

                \App\Models\InstituteAssignedClassStudent::create([
                    'price' => $amount,
                    'institute_assigned_class_id' => $class_id,
                    'student_id' => auth()->user()->student_id,
                    'razorpay_payment_id' => request()->razorpay_payment_id,
                    'coupon_id' => $coupon_id,
                    'coupon_applied' => $coupon_applied,
                    'mode_of_class' =>  $request->mode_of_class,
                ]);

                $cart->delete();
            } else {
                abort(400);
            }

            return redirect()->route('student.home');
        } else {

            $row = [];
            if (request()->hidden && request()->razorpay_payment_id) {
                $cart = \App\Models\Cart::findOrFail(decrypt(request()->hidden));
                $requested_data = json_decode($cart->form_data, true);

                $class_id = $cart->institute_assigned_class_id;
                // $class_id = (int)$requested_data['class_id'];
                $row = $requested_data['row'];
                // $session_key = 'student_' . $student_id . '_class_' . $class_id;
                $class = \App\Models\InstituteAssignedClass::find($class_id);
                $api = new Api(config('app.razorpay_api_key'), config('app.razorpay_api_secret'));

                // if (isset($requested_data['code']) && $requested_data['code'] != null) {
                if ($cart->coupon_applied) {
                    $coupon = \App\Models\Coupon::findOrFail($cart->coupon_id);
                    // $coupon = \App\Models\Coupon::where('code', $requested_data['code'])->where(['applicable_type' => 'App\Models\InstituteAssignedClass', 'applicable_id' => $class_id, 'deleted_at' => NULL])->firstOrFail();
                    $amount = $class->price - $coupon->discount_in_rs;
                    $coupon_id = $coupon->id;
                    $coupon_applied = '1';
                } else {
                    $amount = $class->price;
                    $coupon_id = null;
                    $coupon_applied = '0';
                }
                $payment = $api->payment->fetch(request()->razorpay_payment_id);
                $error = false;
                try {
                    $payment->capture(array('amount' => (float)($amount) * 100, 'currency' => 'INR'));
                } catch (\Throwable $th) {
                    $error = true;
                    // abort(400, 'Something Went Wrong');
                    die('Something Went Wrong');
                }
                if ($error) {
                    abort(400, 'Something Went Wrong');
                }

                foreach ($row as $key => $value) {

                    \App\Models\StudentSubjectsInfo::create([
                        'student_id' => auth()->user()->student_id,
                        'subjects_info_id' => $key,
                        // 'time_slot_id' => $value['slot'],
                    ]);
                }

                \App\Models\InstituteAssignedClassStudent::create([
                    'price' => $amount,
                    'institute_assigned_class_id' => $class_id,
                    'student_id' => auth()->user()->student_id,
                    'razorpay_payment_id' => request()->razorpay_payment_id,
                    'coupon_id' => $coupon_id,
                    'coupon_applied' => $coupon_applied,
                    'mode_of_class' =>  $request->mode_of_class,
                ]);

                $cart->delete();
            } else {
                abort(400);
            }

            return redirect()->route('student.home');
        }
    }

    public function enter_class()
    {
        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];
        $class = \App\Models\InstituteAssignedClass::with('institute_assigned_class_subject.subjects_infos.student_subjects_info.time_slot')->find(request()->class_id);
        return view('student.enter-class', ['classes' => Arr::wrap($class), 'colors' => $colors]);
    }

    public function extra_classes()
    {
        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];

        if (!request()->lecture && request()->unit) {
            $extra_classesGroupedByUnits = \App\Models\Unit::with('extra_classes')->where('institute_assigned_class_subject_id', request()->iacs_id)->where('name', 'like', '%' . request()->unit . '%')->get();
        } else if (request()->lecture && !request()->unit) {
            $extra_classesGroupedByUnits = \App\Models\Unit::with(['extra_classes' => function ($query) {
                $query->where('extra_class_name', 'like', '%' . request()->lecture . '%');
            }])->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
        } else if (request()->lecture && request()->unit) {
            $extra_classesGroupedByUnits = \App\Models\Unit::with(['extra_classes' => function ($query) {
                $query->where('extra_class_name', 'like', '%' . request()->lecture . '%');
            }])->where('institute_assigned_class_subject_id', request()->iacs_id)->where('name', 'like', '%' . request()->unit . '%')->get();
        } else {
            if (!empty(request()->iacs_id)) {
                $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')->where('id', request()->iacs_id)->first();
                if (!empty($institute_assigned_class_subject)) {
                    $institute_assigned_class_student = DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)->where('student_id', auth()->user()->student_id)->first();
                    if (!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)) {
                        $start_date = $institute_assigned_class_student->start_date;
                    } else {
                        $institute_assigned_class = DB::table('institute_assigned_class')->where('id', $institute_assigned_class_subject->institute_assigned_class_id)->first();
                        $start_date = $institute_assigned_class->start_date;
                        // dd($start_date);
                    }
                }
            }
            $extra_classesGroupedByUnits = \App\Models\Unit::with('extra_classes')->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
        }

        // $extra_classesGroupedByUnits = \App\Models\Unit::with('extra_classes')->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
        return view('student.extra-classes', compact('extra_classesGroupedByUnits', 'colors'));
    }

    public function getnotification()
    {

        $id = request()->iacs_id ? request()->iacs_id : '';
        if ($id) {
            $notifications = ClassNotification::where('i_a_c_s_id', $id)->where('isread', 1)->where('type', 'text')->orwhere('type', 'pdf')->get();
            $total = 0;
            $items = [];
            if (!empty($notifications)) {
                foreach ($notifications as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                            $total = $total + 0;
                        } else {
                            $total = $total + 1;
                            $items[] = $noti;
                        }
                    } else {
                        $total = $total + 1;
                        $items[] = $noti;
                    }
                }
            }
            $notifications = $items;
            $count = $total;
            $today = Carbon::now()->format('Y-m-d') . '%';

            $total2 = 0;
            $items2 = [];
            $assignmentnotifications =  ClassNotification::where('i_a_c_s_id', $id)->where('isread', 1)->whereDate('notify_date', '<=', date('Y-m-d'))->where('type', 'assignment')->get();
            if (!empty($assignmentnotifications)) {
                foreach ($assignmentnotifications as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                            $total2 = $total2 + 0;
                        } else {
                            $total2 = $total2 + 1;
                            $items2[] = $noti;
                        }
                    } else {
                        $total2 = $total2 + 1;
                        $items2[] = $noti;
                    }
                }
            }
            $assignmentnotifications = $total2;

            $total4 = 0;
            $items4 = [];
            $test =  ClassNotification::where('i_a_c_s_id', request()->iacs_id)->whereDate('notify_date', '<=', date('Y-m-d'))->where('isread', 1)->where('type', 'test')->get();
            if (!empty($test)) {
                foreach ($test as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                            $total4 = $total4 + 0;
                        } else {
                            $total4 = $total4 + 1;
                            $items4[] = $noti;
                        }
                    } else {
                        $total4 = $total4 + 1;
                        $items4[] = $noti;
                    }
                }
            }
            $testsnotification = $total4;
            // dd($testsnotification);

            $total3 = 0;
            $items3 = [];
            $dnotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs_id)->where('student_id', auth()->user()->student_id)->whereNotNull('institute_id')->where('isread', 2)->where('type', 'doubts')->get();

            if (!empty($dnotifications)) {
                foreach ($dnotifications as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                            $total3 = $total3 + 0;
                        } else {
                            $total3 = $total3 + 1;
                            $items3[] = $noti;
                        }
                    } else {
                        $total3 = $total3 + 1;
                        $items3[] = $noti;
                    }
                }
            }
            $dnotifications = $total3;

            $total4 = 0;
            $items4 = [];
            $extranotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs_id)->whereDate('notify_date', '=', date('Y-m-d'))->where('type', 'extraClass')->get();
            if (!empty($extranotifications)) {
                foreach ($extranotifications as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                            $total4 = $total4 + 0;
                        } else {
                            $total4 = $total4 + 1;
                            $items3[] = $noti;
                        }
                    } else {
                        $total4 = $total4 + 1;
                        $items4[] = $noti;
                    }
                }
            }
            $extranotifications = $total4;



            $view = view('student.notifies', compact('notifications'))->render();
            return response()->json(['view' => $view, 'msg' => 'Notifications list', 'count' => $count, 'assignmentnotifications' => $assignmentnotifications, 'testsnotification' => $testsnotification, 'dnotifications' => $dnotifications, 'extranotifications' => $extranotifications]);
        }
    }

    public function markasread()
    {
        $id = request()->iacs ? request()->iacs : '';
        $nid = request()->id ? request()->id : '';
        $old_data = ClassNotification::where('id', $nid)->first();
        if ($old_data) {
            $old_data_arr = !empty($old_data->readUsers) ? explode(',', $old_data->readUsers) : [];
            $old_data_arr[] = auth()->user()->student_id;
            $query = ClassNotification::where('id', $nid)->update([
                'readUsers' => implode(',', $old_data_arr)
            ]);
            if ($old_data) {
                /*  $notifications = ClassNotification::where('i_a_c_s_id',$old_data->i_a_c_s_id)->where('isread',1)->whereRaw('FIND_IN_SET('.auth()->user()->student_id.',readUsers) = 0')->get(); */
                $notifications = ClassNotification::where('i_a_c_s_id', $id)->where('isread', 1)->where('type', 'text')->orwhere('type', 'pdf')->get();
                $total = 0;
                $items = [];
                if (!empty($notifications)) {
                    foreach ($notifications as $noti) {
                        if ($noti->readUsers) {
                            $hiddenProducts = explode(',', $noti->readUsers);
                            if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                                $total = $total + 0;
                            } else {
                                $total = $total + 1;
                                $items[] = $noti;
                            }
                        } else {
                            $total = $total + 1;
                            $items[] = $noti;
                        }
                    }
                }

                $notifications = $items;
                $count =  !empty($notifications) ? count($notifications) : '';
                $view = view('student.notifies', compact('notifications'))->render();
                return response()->json(['view' => $view, 'msg' => 'Notifications list', 'count' => $count]);
            }
        }
    }




    public function subject_detail()
    {
        $notifications = ClassNotification::where('i_a_c_s_id', request()->iacs_id)->where('isread', 1)->where('type', 'text')->orwhere('type', 'pdf')->get();
        $total = 0;
        if (!empty($notifications)) {
            foreach ($notifications as $noti) {
                if ($noti->readUsers) {
                    $hiddenProducts = explode(',', $noti->readUsers);
                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                        $total = $total + 0;
                    } else {
                        $total = $total + 1;
                    }
                } else {
                    $total = $total + 1;
                }
            }
        }
        $notifications = $total;
        $today = Carbon::now()->format('Y-m-d') . '%';
        $total2 = 0;
        $items2 = [];
        $assignmentnotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs_id)->whereDate('notify_date', '<=', date('Y-m-d'))->where('isread', 1)->where('type', 'assignment')->get();
        if (!empty($assignmentnotifications)) {
            foreach ($assignmentnotifications as $noti) {
                if ($noti->readUsers) {
                    $hiddenProducts = explode(',', $noti->readUsers);
                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                        $total2 = $total2 + 0;
                    } else {
                        $total2 = $total2 + 1;
                        $items2[] = $noti;
                    }
                } else {
                    $total2 = $total2 + 1;
                    $items2[] = $noti;
                }
            }
        }
        $assignmentnotifications = $total2;

        $total4 = 0;
        $items4 = [];
        $test =  ClassNotification::where('i_a_c_s_id', request()->iacs_id)->whereDate('notify_date', '<=', date('Y-m-d'))->where('isread', 1)->where('type', 'test')->get();
        if (!empty($test)) {
            foreach ($test as $noti) {
                if ($noti->readUsers) {
                    $hiddenProducts = explode(',', $noti->readUsers);
                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                        $total4 = $total4 + 0;
                    } else {
                        $total4 = $total4 + 1;
                        $items4[] = $noti;
                    }
                } else {
                    $total4 = $total4 + 1;
                    $items4[] = $noti;
                }
            }
        }
        $testsnotification = $total4;

        $total3 = 0;
        $items3 = [];
        $dnotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs_id)->where('student_id', auth()->user()->student_id)->whereNotNull('institute_id')->where('isread', 2)->where('type', 'doubts')->get();
        if (!empty($dnotifications)) {
            foreach ($dnotifications as $noti) {
                if ($noti->readUsers) {
                    $hiddenProducts = explode(',', $noti->readUsers);
                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                        $total3 = $total3 + 0;
                    } else {
                        $total3 = $total3 + 1;
                        $items3[] = $noti;
                    }
                } else {
                    $total3 = $total3 + 1;
                    $items3[] = $noti;
                }
            }
        }
        $dnotifications = $total3;

        $total4 = 0;
        $items4 = [];
        $extranotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs_id)->whereDate('notify_date', '<=', date('Y-m-d'))->where('type', 'extraClass')->get();
        if (!empty($extranotifications)) {
            foreach ($extranotifications as $noti) {
                if ($noti->readUsers) {
                    $hiddenProducts = explode(',', $noti->readUsers);
                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                        $total4 = $total4 + 0;
                    } else {
                        $total4 = $total4 + 1;
                        $items3[] = $noti;
                    }
                } else {
                    $total4 = $total4 + 1;
                    $items4[] = $noti;
                }
            }
        }
        $extranotifications = $total4;


        return view('student.subject-detail', compact('notifications', 'assignmentnotifications', 'testsnotification', 'items2', 'dnotifications', 'extranotifications'));
    }
    public function editClassTime()
    {

        $subjects_arr = request()->student_subjects_info_id ? explode(',', request()->student_subjects_info_id) : [];
        if ($subjects_arr && request()->student_id) {
            foreach ($subjects_arr as $subjs) {
                \DB::table('student_subjects_info')->where('subjects_info_id', $subjs)->where('student_id', request()->student_id)->update([
                    'new_time_slot_id' => request()->newTime
                ]);
            }
            return redirect()->back()->with(['success' => 'Class Time Updated Successfully, Timings will be effected from tommorrow onwards.']);
        } else {
            return redirect()->back()->with(['error' => 'Faile to update time, try again later']);
        }
    }

    public function mark_an_attendence()
    {

        $student_lecture = \App\Models\StudentLecture::where(['student_id' => auth()->user()->student_id, 'lecture_id' => request()->id])->first();
        if (!empty($student_lecture)) {
            if ($student_lecture->attendence_in_percentage < 100) {
                $student_lecture->attendence_in_percentage += 10;
                $student_lecture->save();
                return response()->json(['status' => 'success', 'lecture_status' => 'ongoing']);
            } else {
                return response()->json(['status' => 'success', 'lecture_status' => 'completed']);
            }
        }

        \App\Models\StudentLecture::create([
            'student_id' => auth()->user()->student_id,
            'lecture_id' => request()->id,
            'attendence_in_percentage' => 0
        ]);

        return response()->json(['status' => 'success', 'lecture_status' => 'started']);
    }

    public function doubts()
    {
        $dontread = false;
        return view('student.doubts', compact('dontread'));
    }

    public function add_doubt()
    {

        request()->validate([
            'message' => 'required|mimes:pdf,image:jpg,jpeg,png',
        ]);

        $doubt = \App\Models\Doubt::firstOrNew([
            'institute_assigned_class_subject_id' => request()->iacs_id,
            'student_id' => auth()->user()->student_id,
        ]);

        $doubt->institute_assigned_class_subject_id = request()->iacs_id;
        $doubt->student_id = auth()->user()->student_id;
        if (!$doubt->doubt_id) {
            $doubt->doubt_id = uniqid();
        }
        $doubt->save();
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs_id);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id;
        if (request()->hasFile('message')) {
            //$file = request()->file('message')->store('/doubts/' . $doubt->id, 's3');
            $folderName = 'institutes/doubts' . '/' . $iac->institute_id . '/' . $iac->id . '/' . request()->iacs_id . '/' . $doubt->id;
            $folder = createFolder($folderName);
            $fileData = request()->file('message');
            $file = createUrlsession($fileData, $folder);
            $file_name = '';
            if (!empty($file) && $file != 400) {
                $file_name = serialize($file);
            }
            // $file_name = str_replace('public/', '', $file);

            \App\Models\DoubtMessage::create([
                'sendable_type' => '\App\Models\Student',
                'sendable_id' => auth()->user()->student_id,
                'message' => $file_name,
                'doubt_id' => $doubt->id,
            ]);
            $query = \App\Models\ClassNotification::create([
                'i_a_c_s_id' => request()->iacs_id,
                'type' => 'doubts',
                'message' => 'New doubt',
                'student_id' => auth()->user()->student_id,
                'doubt_id' => $doubt->id,
                'isread' => 3,
            ]);



            $dontread = true;
            return view('student.doubts', compact('dontread'));
        } else {
            abort(400);
        }
    }

    public function tests($iacsId)
    {
        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];
        $allTopics = Topic::all();
        $gotMarks = Theory_answer_marks::where('userid', auth()->user()->student_id)
            ->where('iacsId', $iacsId)
            ->get();
        $getmarks = collect();
        foreach ($allTopics as $allTopic) {
            if (!empty($allTopic)) {
                foreach ($gotMarks as $gotMark) {
                    if ($gotMark->topicId == $allTopic->id) {
                        $getmarks->push($gotMark);
                    }
                }
            }
        }
        $allUnits = Test_unit::all();
        return view('student.tests', compact('colors', 'allUnits', 'getmarks'));
    }

    public function assignments()
    {
        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];
        $assig_all_Units = Assignments_unit::all();
        return view('student.assignments', compact('colors', 'assig_all_Units'));
    }



    public function start_test()
    {

        return view('student.test');
    }

    public function start_testTheory($iacs_id, $id)
    {
        // $show_uplode_img = Theoryanswer::
        // where('userid', auth()->user()->student_id)
        // ->where('topicId', $id)
        // ->get();
        // dd($show_uplode_img);
        return view('student.theorytest');
    }
    public function start_assignment()
    {

        return view('student.test');
    }

    public function finish_test()
    {

        $auth = auth()->user();
        $topic = \App\Models\Topic::findOrFail(request()->id);
        $questions = \App\Models\Question::where('topic_id', request()->id)->get();
        $count_questions = $questions->count();
        $answers = \App\Models\Answer::where('user_id', $auth->student_id)
            ->where('topic_id', request()->id)->get();

        if ($count_questions != $answers->count()) {
            foreach ($questions as $que) {
                $a = false;
                foreach ($answers as $ans) {
                    if ($que->id == $ans->question_id) {
                        $a = true;
                    }
                }
                if ($a == false) {
                    \App\Models\Answer::create([
                        'topic_id' => request()->id,
                        'user_id' => $auth->student_id,
                        'question_id' => $que->id,
                        'user_answer' => 0,
                        'answer' => $que->answer,
                    ]);
                }
            }
        }

        $ans = \App\Models\Answer::all();
        $q = \App\Models\Question::all();

        return view('student.finish_test', compact('ans', 'q', 'topic', 'answers', 'count_questions'));
    }

    public function revisedLectures()
    {


        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];




        if (!request()->lecture && request()->unit) {
            $lecturesGroupedByUnits = \App\Models\Unit::with(['lectures' => function ($query) {
                if (!empty(request()->iacs_id)) {
                    $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')->where('id', request()->iacs_id)->first();
                    if (!empty($institute_assigned_class_subject)) {
                        $institute_assigned_class_student = DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)->where('student_id', auth()->user()->student_id)->first();
                        if (!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)) {
                            $start_date = $institute_assigned_class_student->start_date;
                        } else {
                            $institute_assigned_class = DB::table('institute_assigned_class')->where('id', $institute_assigned_class_subject->institute_assigned_class_id)->first();
                            $start_date = $institute_assigned_class->start_date;
                        }
                    }
                }
                // dd($institute_assigned_class_student);
                if (!empty($start_date)) {
                    $query->Where('lecture_date', '>=', $start_date . ' 00:00:00');
                }
                $query->where('lecture_date', '<=', date('Y-m-d 00:00:00'));
            }])->where('institute_assigned_class_subject_id', request()->iacs_id)->where('name', 'like', '%' . request()->unit . '%')->get();
        } else if (request()->lecture && !request()->unit) {
            if (!empty(request()->iacs_id)) {
                $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')->where('id', request()->iacs_id)->first();
                if (!empty($institute_assigned_class_subject)) {
                    $institute_assigned_class_student = DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)->where('student_id', auth()->user()->student_id)->first();
                    if (!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)) {
                        $start_date = $institute_assigned_class_student->start_date;
                    } else {
                        $institute_assigned_class = DB::table('institute_assigned_class')->where('id', $institute_assigned_class_subject->institute_assigned_class_id)->first();
                        $start_date = $institute_assigned_class->start_date;
                    }
                }
            }
            $lecturesGroupedByUnits = \App\Models\Unit::with(['lectures' => function ($query) {
                $query->where('lecture_date', '<=', date('Y-m-d 00:00:00'))
                    ->where('lecture_name', 'like', '%' . request()->lecture . '%');
                if (!empty($start_date)) {
                    $query->Where('lecture_date', '>=', $start_date . ' 00:00:00');
                }
            }])->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
        } else if (request()->lecture && request()->unit) {
            $lecturesGroupedByUnits = \App\Models\Unit::with(['lectures' => function ($query) {
                if (!empty(request()->iacs_id)) {
                    $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')->where('id', request()->iacs_id)->first();
                    if (!empty($institute_assigned_class_subject)) {
                        $institute_assigned_class_student = DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)->where('student_id', auth()->user()->student_id)->first();
                        if (!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)) {
                            $start_date = $institute_assigned_class_student->start_date;
                        } else {
                            $institute_assigned_class = DB::table('institute_assigned_class')->where('id', $institute_assigned_class_subject->institute_assigned_class_id)->first();
                            $start_date = $institute_assigned_class->start_date;
                        }
                    }
                }
                $query->where('lecture_date', '<=', date('Y-m-d 00:00:00'))
                    ->where('lecture_name', 'like', '%' . request()->lecture . '%');
                if (!empty($start_date)) {
                    $query->Where('lecture_date', '>=', $start_date . ' 00:00:00');
                }
            }])->where('institute_assigned_class_subject_id', request()->iacs_id)->where('name', 'like', '%' . request()->unit . '%')->get();
        } else {
            $lecturesGroupedByUnits = \App\Models\Unit::with(['lectures' => function ($query) {
                if (!empty(request()->iacs_id)) {
                    $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')->where('id', request()->iacs_id)->first();
                    if (!empty($institute_assigned_class_subject)) {
                        $institute_assigned_class_student = DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)->where('student_id', auth()->user()->student_id)->first();
                        if (!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)) {
                            $start_date = $institute_assigned_class_student->start_date;
                        } else {
                            $institute_assigned_class = DB::table('institute_assigned_class')->where('id', $institute_assigned_class_subject->institute_assigned_class_id)->first();
                            $start_date = $institute_assigned_class->start_date;
                        }
                    }
                }

                $trial_student_id = DB::table('student_trial_period')->where('student_id', auth()->user()->student_id)->first();
                $trial_student_class = DB::table('institute_assigned_class')->where('id', $institute_assigned_class_subject->institute_assigned_class_id)->first();
                if (!empty($trial_student_id)  && !empty($trial_student_class)   && $trial_student_id->student_id == auth()->user()->student_id && $trial_student_id->class_id == $trial_student_class->id) {
                    $query->where('lecture_date', '<', date('Y-m-d 00:00:00'));
                } else {
                    $query->where('lecture_date', '<', date('Y-m-d 00:00:00'));
                    if (!empty($start_date)) {
                        $query->Where('lecture_date', '>=', $start_date . ' 00:00:00');
                    }
                }


                // $trial_student_id = DB::table('student_trial_period')->where('student_id', auth()->user()->student_id)->first();
                // $trial_student_class = DB::table('institute_assigned_class')->where('id', $institute_assigned_class_subject->institute_assigned_class_id)->first();
                // if (!empty($trial_student_id->student_id == auth()->user()->student_id && $trial_student_id->class_id == $trial_student_class->id)) {
                //     $query->where('lecture_date', '<=', date('Y-m-d 00:00:00'));
                //     // dd($query);
                // } else {
                //     $query->where('lecture_date', '<=', date('Y-m-d 00:00:00'));
                //     if (!empty($start_date)) {
                //         $query->Where('lecture_date', '>=', $start_date . ' 00:00:00');
                //     }
                // }
            }])->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
        }
        $iacs_id = request()->iacs_id;
        return view('student.revised-lectures', compact('lecturesGroupedByUnits', 'colors', 'iacs_id'));
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
                        $cart = \App\Models\Cart::firstOrNew(['institute_assigned_class_id' => $form_data->class_id, 'student_id' => auth()->user()->student_id]);
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



    public function revisedliveLectures($meetingId)
    {

        $meetingId = $this->lecturesName();
        if ($meetingId != '') {
            foreach ($meetingId as $data) {
                $meetingId = $data->meeting_id;
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

        $keys = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $url = "https://api.zoom.us/v2/meetings/" . $meetingId . "/recordings";

        $token = array(
            "iss" => $keys,
            "exp" => time() + 3600 //60 seconds as suggested

        );
        $getJWTKey = JWT::encode($token, $secret);
        $headers = array(
            "authorization: Bearer " . $getJWTKey,
            "content-type: application/json",
            "Accept: application/json",
        );

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers,
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!$result) {
            return $err;
        }
        $meeting_url = json_decode($result);
        return view('student.revised-live_lectures', ['meeting_url' => $meeting_url, 'colors' => $colors]);
    }



    public static function lecturesName()
    {
        $meeting_data = DB::table('meetings')->where('i_a_c_s_id', request()->iacs_id)
            ->where('date', '<', date('Y-m-d'))->get();
        // dd($meeting_data);
        return $meeting_data;
    }

    public static function getmeetingid()
    {
        $meetingdata = DB::table('meetings')->where('i_a_c_s_id', request()->iacs_id)->get();
        return $meetingdata;
    }




    // public static function liveClassAttendance()
    // {
    //     // dd(auth()->user());
    //     // $meetingId = $this->lecturesName();
    //     // if ($meetingId != '') {
    //     //     foreach ($meetingId as $data) {
    //     //         $meetingId = $data->meeting_id;
    //     //     }
    //     // }
    //     $url = "https://api.zoom.us/v2/report/meetings/99556224017/participants";
    //     // $url = "https://api.zoom.us/v2/report/meetings/96279079559";
    //     $keys = env('ZOOM_API_KEY', '');
    //     $secret = env('ZOOM_API_SECRET', '');
    //     // $url = "https://api.zoom.us/v2/meetings/" . $meetingId . "/recordings";

    //     $token = array(
    //         "iss" => $keys,
    //         "exp" => time() + 3600 //60 seconds as suggested

    //     );
    //     $getJWTKey = JWT::encode($token, $secret);
    //     $headers = array(
    //         "authorization: Bearer " . $getJWTKey,
    //         "content-type: application/json",
    //         "Accept: application/json",
    //     );

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => $headers,
    //     ));

    //     $resultData = curl_exec($curl);
    //     $err = curl_error($curl);
    //     curl_close($curl);
    //     if (!$resultData) {
    //         return $err;
    //     }

    //    return json_decode($resultData);

    // }

    // public static function liveclasshost()
    // {


    //     // $meetingId = $this->lecturesName();
    //     // if ($meetingId != '') {
    //     //     foreach ($meetingId as $data) {
    //     //         $meetingId = $data->meeting_id;
    //     //     }
    //     // }
    //     // $url = "https://api.zoom.us/v2/report/meetings/96279079559/participants";
    //     $url = "https://api.zoom.us/v2/report/meetings/99556224017";
    //     $keys = env('ZOOM_API_KEY', '');
    //     $secret = env('ZOOM_API_SECRET', '');
    //     // $url = "https://api.zoom.us/v2/meetings/" . $meetingId . "/recordings";

    //     $token = array(
    //         "iss" => $keys,
    //         "exp" => time() + 3600 //60 seconds as suggested

    //     );
    //     $getJWTKey = JWT::encode($token, $secret);
    //     $headers = array(
    //         "authorization: Bearer " . $getJWTKey,
    //         "content-type: application/json",
    //         "Accept: application/json",
    //     );

    //     $curlid = curl_init();
    //     curl_setopt_array($curlid, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => $headers,
    //     ));

    //     $resultDataid = curl_exec($curlid);
    //     $err = curl_error($curlid);
    //     curl_close($curlid);
    //     if (!$resultDataid) {
    //         return $err;
    //     }

    //    return json_decode($resultDataid);



    // }


    // public static function percentage(){
    //     $studentData = self::liveClassAttendance();
    //     // calculation duration in sec
    //     $total_duration = 0;
    //     if(!empty($studentData) && $studentData->participants ){
    //         foreach($studentData->participants as $resultUser){
    //             if(!empty($resultUser)){
    //                 // if($resultUser->name == auth()->user()->email){

    //                     $total_duration += !empty($resultUser->duration) ? $resultUser->duration : 0;

    //                 }

    //             }
    //         }

    //         //host data
    //             $hostData = self::liveclasshost();
    //             // dd($hostData);
    //         if(!empty($hostData)){
    //             $hostDateTime = $hostData->duration;
    //             $sec = ($hostDateTime * 60);   //convert host duration minutes to sec
    //             $percentage = ($total_duration / $sec) * 100;
    //             $percentageRound =  round($percentage, 2);
    //             //insert data in databas
    //             $studentCrearte = new student_attendance;
    //             $studentCrearte->meeting_id = $hostData->id;
    //             $studentCrearte->topic = $hostData->topic;
    //             $studentCrearte->name = $resultUser->name;
    //             $studentCrearte->join_time = $resultUser->join_time;
    //             $studentCrearte->leave_time = $resultUser->leave_time;
    //             $studentCrearte->leave_time = $resultUser->leave_time;
    //             $studentCrearte->attendence_in_percentage = $percentageRound;
    //             $studentCrearte->save();
    //         }
    //     // }
    // }



    public static function getmodeofClass()
    {

        $class_Sublect = DB::table('institute_assigned_class_subject')->where('id', request()->iacs_id)->first();
        $mode = InstituteAssignedClassStudent::where('student_id',  auth()->user()->student_id)
            ->where('institute_assigned_class_id', $class_Sublect->institute_assigned_class_id)->first();
        return $mode;
    }

    public function saveimage(Request $request)
    {
        if ($file = $request->file('file')) {
            $file = request()->file('file')->store('/answer', 's3img');
            $file_name = $file;
            return $file_name;
        }
    }

    public function savetestTheory(Request $request)
    {
        // if($request->getrequest !=2 ){
        $getno =  Theoryanswer::where('userid', $request->userid)
            ->where('topicId', $request->topicId)
            ->orderBy('id', 'desc')
            ->select('anser_no')
            ->first();
        if (!empty($getno)) {
            $q_no = $getno->anser_no + 1;
            $input = $request->all();
            $input['anser_no'] = $q_no;
            Theoryanswer::create($input);
        } else {
            $input = $request->all();
            Theoryanswer::create($input);
        }
        // }
        // else{

        //     // var_dump($request->topicId);die;
        //     $show_uplode_img = Theoryanswer::where('questionId', $request->questionId)
        //     ->where('userid', $request->userid)
        //     ->where('topicId', $request->topicId)
        //     ->get('answer');
        //    return response()->json([
        //             'status'=>200,
        //             'data'=> $show_uplode_img,
        //         ]);

        // }

    }

    public function finish_test_theory()
    {
        DB::table('answer_status')->insert(
            array(
                'userid' => request()->userid,
                'topicId' => request()->topicId,
                'answer_checked' => request()->answer_status
            )
        );
    }
    public function reviewAnswer()
    {

        return view('student.reviewAnswer');
    }


    public function gettheoryReport($iacs_id, $id)
    {
        $reportGet = Theoryanswer::where('topicId', $id)
            ->where('userid', auth()->user()->student_id)
            ->orderBy('anser_no', 'asc')
            ->get();
        // dd($reportGet);
        return view('student.theoryreport', compact('reportGet'));
    }

    public function deleteImage(Request $request)
    {
        // dd($request->all());
        $deleteimg = Theoryanswer::where('questionId', $request->questionId)
            ->where('userid', $request->userid)
            ->where('topicId', $request->topicId)
            ->where('anser_no', $request->anser_no)
            ->delete();
    }

    public function verifyPayment()
    {

        if (!empty(request()->razorpay_payment_id) && !empty(request()->class_id)) {
            $cart = \App\Models\Cart::where('institute_assigned_class_id', request()->class_id)->where('student_id', auth()->user()->student_id)->first();
            $requested_data = ($cart->form_data);
            $class_id = $cart->institute_assigned_class_id;
            $row = $requested_data;

            $class = \App\Models\InstituteAssignedClass::find($class_id);

            $api = new Api(config('app.razorpay_api_key'), config('app.razorpay_api_secret'));
            if ($cart->coupon_applied) {
                $coupon = \App\Models\Coupon::findOrFail($cart->coupon_id);
                $amount = $class->price - $coupon->discount_in_rs;
                $coupon_id = $coupon->id;
                $coupon_applied = '1';
            } else {
                $amount = $class->price;
                $coupon_id = null;
                $coupon_applied = '0';
            }
            $payment = $api->payment->fetch(request()->razorpay_payment_id);
            $error = false;
            return response()->json([
                'status' => 402,
                'msg' => request()->razorpay_payment_id,
            ]);
            try {
                $payment->capture(array('amount' => (float)($amount) * 100, 'currency' => 'INR'));
            } catch (\Throwable $th) {
                $error = true;
                return response()->json([
                    'status' => 402,
                    'msg' => 'Payment capture error',
                ]);
            }
            if ($error) {
                return response()->json([
                    'status' => 403,
                    'msg' => 'Something Went Wrong !!!',
                ]);
            }
            foreach ($row as $key => $value) {

                \App\Models\StudentSubjectsInfo::create([
                    'student_id' => auth()->user()->student_id,
                    'subjects_info_id' => $key,
                    'time_slot_id' => $value['slot'],
                ]);
            }

            \App\Models\InstituteAssignedClassStudent::create([
                'price' => $amount,
                'institute_assigned_class_id' => $class_id,
                'student_id' => auth()->user()->student_id,
                'razorpay_payment_id' => request()->razorpay_payment_id,
                'coupon_id' => $coupon_id,
                'coupon_applied' => $coupon_applied,
                'mode_of_class' =>  $request->mode_of_class,
            ]);

            $cart->delete();
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Payment not found !!!',
            ]);
        }
    }
}