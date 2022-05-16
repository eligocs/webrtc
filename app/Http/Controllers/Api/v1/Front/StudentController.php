<?php

namespace App\Http\Controllers\Api\v1\Front;

use Razorpay\Api\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\InstituteApplication;
use App\Models\ClassNotification;
use App\Models\Subject;
use App\Models\Assignments_unit;
use App\Models\Topic;
use App\Models\ExtraClass;
use App\Models\Question;
use App\Models\SubjectsInfo;
use App\Models\Test_unit;
use App\Models\User;
use App\Models\Student;
use App\Models\Answer;
use App\Models\Language;
use Validator;
use Auth;
use DatePeriod;
use DateTime;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Meeting;
use \Firebase\JWT\JWT;
use GuzzleHttp\Client;
use DateInterval;
use Vimeo\Laravel\Facades\Vimeo;
use DB;
use App\Models\Theory_answer_marks;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (empty($user)) {
            return response()->json(
                [
                    'status' => 200,
                    'data' => ''
                ]
            );
        }
        $class = \App\Models\Student::with('institute_assigned_class.institute_assigned_class_subject.subject', 'institute_assigned_class.institute_assigned_class_subject.subjects_infos.student_subjects_info.time_slot')->find(auth()->user()->student_id);

        if (!empty($class)) {
            foreach ($class->institute_assigned_class as $institute_assigned_class) {
                foreach ($institute_assigned_class->institute_assigned_class_subject as $instClass) {

                    $institute_id = $institute_assigned_class->institute_id;
                    $getinstitute = \App\Models\Institute::where(['id' => $institute_id])->first();
                    $institute_assigned_class->institute = $getinstitute ?? '';
                    $instClass->iacs = \App\Models\InstituteAssignedClassSubject::where(['institute_assigned_class_id' => $class->id, 'subject_id' => $instClass->subject->id])->first();
                    $iacs_id = '';
                    if (!empty($instClass->id)) {
                        $iacs_id = $instClass->id;
                    }

                    if (!empty($iacs_id)) {
                        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacs_id);
                        $iac = $iacs->institute_assigned_class;

                        try {
                            $lecture = $iacs->lectures->where('lecture_date', date('Y-m-d 00:00:00'))->first();
                            if (empty($lecture)) {
                                $lecture = $iacs->lectures->where('lecture_date', '>', date('Y-m-d 00:00:00'))->first();
                            }
                            $lecture_url = $lecture->lecture_video;
                            $lecture_id = $lecture->id;
                            $lecture_date = date('Y-m-d', strtotime($lecture->lecture_date));
                            $lecture_day = date('l', strtotime($lecture->lecture_date));
                            $lecture_time_in_unix_timestamp = strtotime(date('Y-m-d', strtotime($lecture->lecture_date)));
                        } catch (\Throwable $th) {
                            $lecture_url = '';
                            $lecture_id = '';
                            $lecture_date = '';
                            $time = '';
                            $lecture_time_in_unix_timestamp = strtotime('23:59:59');
                        }

                        $period = new DatePeriod(new DateTime($iac->start_date->format('Y-m-d')), new DateInterval('P1D'), new DateTime($iac->end_date->modify('+1 day')->format('Y-m-d')));

                        $lecture_dates = [];
                        foreach ($period as $key => $value) {
                            foreach ($iacs->subjects_infos->pluck('day')->toArray() as $key1 => $day) {
                                if ($day === strtolower($value->format('l'))) {
                                    $lecture_dates[] = $value->format('m/d/Y');
                                }
                            }
                        }

                        if (time() > $lecture_time_in_unix_timestamp - 300 && time() < $lecture_time_in_unix_timestamp + 3000) {
                            $instClass->next_class =  date('m/d/Y');
                        } else {
                            if ($lecture_date && time() < $lecture_time_in_unix_timestamp + 3000) {
                                $next_class = date('m/d/Y', strtotime($lecture_date));
                                $instClass->next_class = $next_class ?? '';
                            } else {
                                foreach ($lecture_dates as $item) {
                                    if (strtotime($item) > strtotime(date('Y-m-d'))) {
                                        $instClass->next_class = $item ?? '';
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    $lectures = \App\Models\Lecture::where(
                        'institute_assigned_class_subject_id',
                        $instClass->id
                    )->whereDate('lecture_date', '<', date('Y-m-d 00:00:00'))->get();
                    if ($lectures->count() > 0) {
                        $total_past_lectures = $lectures->count();
                        $attended_lectures = \App\Models\StudentLecture::whereIn('lecture_id', $lectures->pluck('id')->toArray())->where('student_id', auth()->user()->student_id)->where('attendence_in_percentage', '>=', '90')->get();
                        $total_attended_lectures = $attended_lectures->count();
                        $total_absents_in_lectures = $total_past_lectures - $total_attended_lectures;
                        $percentage = ($total_attended_lectures / $total_past_lectures) * 100;
                    } else {
                        $total_past_lectures = 0;
                        $total_attended_lectures = 0;
                        $total_absents_in_lectures = 0;
                        $percentage = 0;
                    }
                    $instClass->total_attended_lectures = $total_attended_lectures;
                    $instClass->total_absents_in_lectures = $total_absents_in_lectures;
                    $instClass->percentage = round($percentage, 2);
                }
            }
        }
        return response()->json([
            'status' => 200,
            'data' => $class
        ]);
    }

    public function getSTests()
    {
        $unitName = [];
        $topics = [];
        $unitNames = Test_unit::all();
        $questions = Question::all();
        if ($unitNames) {
            foreach ($unitNames as $u_name) {
                $topics_get = Topic::where('institute_assigned_class_subject_id', request()->iacs)
                    ->where('type', 'test')
                    ->where('unit', $u_name->id)
                    ->orderBy('publish_date', 'desc')
                    ->get();
                if (!empty($topics_get) && count($topics_get) > 0) {
                    foreach ($topics_get as $topic) {
                        $qu_count = 0;
                        foreach ($questions as $question) {
                            if ($question->topic_id == $topic->id) {
                                $qu_count++;
                            }
                        }
                        $topic->questions = $qu_count;
                    }
                    $unitName['unit'] = $u_name->id;
                    $unitName['topics'] = $topics_get;
                    $unitName['name'] = $u_name->unit;
                    $topics[] = $unitName;
                }
            }
            $old_data = DB::table('class_notifications')
                ->where('type', 'test')
                ->where('i_a_c_s_id', request()->iacs)
                ->get();
            if ($old_data) {
                foreach ($old_data as $dat) {
                    $old_data_arr = !empty($dat->readUsers) ? explode(',', $dat->readUsers) : [];
                    if (!in_array(auth()->user()->student_id, $old_data_arr)) {
                        $old_data_arr[] = auth()->user()->student_id;
                        $query = DB::table('class_notifications')
                            ->where('id', $dat->id)
                            ->where('notify_date', '<=', date('Y-m-d'))
                            ->update([
                                'readUsers' => implode(',', $old_data_arr),
                            ]);
                    }
                }
            }
        }



        $topicsw_u = Topic::where('institute_assigned_class_subject_id', request()->iacs)
            ->where('type', 'test')
            ->where('unit', null)
            ->where('testType', null)
            ->orderBy('publish_date', 'desc')->get();

        if (request()->iacs) {
            return response()->json([
                'status' => 200,
                'topics' => $topics,
                'assignmet_w_n_t' => $topicsw_u,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'topics' => 'No data',
            ]);
        }
    }

    public function getcats(Request $request)
    {
        $categories = \App\Models\Category::all();
        return response()->json([
            'status' => 200,
            'categories' => $categories
        ]);
    }

    public function getstudentclass()
    {

        if (request()->class) {
            $classes = \App\Models\InstituteAssignedClass::where('name', 'like', '%' . request()->class . '%')->orderBy('updated_at', 'desc')->get();
        } elseif (request()->category_id) {
            $classes = \App\Models\InstituteAssignedClass::where('category_id', request()->category_id)->orderBy('updated_at', 'desc')->get();
        }
        if (!empty($classes)) {
            foreach ($classes as $class) {
                $class->institute_details = \App\Models\Institute::where('id', $class->institute_id)->first();
                $class->language = \App\Models\Language::where('id', $class->language)->first();
                $subjects = \App\Models\InstituteAssignedClassSubject::where('institute_assigned_class_id', $class->id)->get();
                if ($class->freetrial == 1) {
                    $classStatus = 'Free Trial';
                } elseif (\App\Models\InstituteAssignedClassStudent::where([
                    'institute_assigned_class_id' =>
                    $class->id,
                    'student_id' => auth()->user()->student_id
                ])
                    ->where('start_date', null)
                    ->exists()
                ) {
                    $classStatus = 'Enrolled';
                } else {
                    $classStatus = 'Enroll';
                }
                $class->classStatus = $classStatus;
                if ($subjects) {
                    foreach ($subjects as $subs) {
                        if (!empty($subs)) {
                            $subs->details = \App\Models\Subject::where('id', $subs->subject_id)->first();
                            $subs->syllabus = !empty($subs->syllabus) && @unserialize($subs->syllabus) ? unserialize($subs->syllabus)[0] : '';
                        }
                    }
                }
                $class->subjects = $subjects;
                $class->insvideo = !empty($class->institute_details->video) && @unserialize($class->institute_details->video) ? unserialize($class->institute_details->video)[0] : '';
            }
        }

        return response()->json([
            'status' => 200,
            'classes' => $classes,
        ]);
        if(!empty($classes)){
        }else{
            return response()->json([
                'status' => 200,
                'classes' => [],
            ]);
        }
    }

    public function getTimings()
    {
        $slots = DB::table('time_slots')->get();
        return response()->json([
            'status' => 200,
            'slots' => $slots,
        ]);
    }
    public function loadstudentdata(Request $request)
    {
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs);
        $iac = $iacs->institute_assigned_class;
        $syllabus = $iacs->syllabus ?? '';
        $videoClass = $iac->video ?? '';
        $getSubjectsInfo = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id', request()->iacs)->get();
        $class_days = [];
        $class_time = [];
        if ($getSubjectsInfo->count() > 0) {
            foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                if (in_array($day, $getSubjectsInfo->pluck('day')->toArray())) {
                    $class_days[] = $day;
                }
            }
        }

        $subj_ids = [];
        foreach ($iacs->subjects_infos as $subj) {
            $subj_ids[] =

                !empty($subj->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->subjects_info_id)

                ? $subj->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->subjects_info_id  : '';
        }

        $student_subjects_info_id = !empty($subj_ids) ? implode(',', $subj_ids) : '';

        $period = new DatePeriod(new DateTime($iac->start_date->format('Y-m-d')), new DateInterval('P1D'), new DateTime($iac->end_date->modify('+1 day')->format('Y-m-d')));
        $lecture_dates = [];
        foreach ($period as $key => $value) {
            foreach ($iacs->subjects_infos->pluck('day')->toArray() as $key1 => $day) {
                if ($day === strtolower($value->format('l'))) {
                    $lecture_dates[] = $value->format('Y-m-d');
                }
            }
        }
        $next_class = '';
        try {
            $lecture = $iacs->lectures->where('lecture_date', date('Y-m-d 00:00:00'))->first();
            if (empty($lecture)) {
                $lecture = $iacs->lectures->where('lecture_date', '>', date('Y-m-d 00:00:00'))->first();
            }
            $lecture_url = $lecture->lecture_video;
            $lecture_id = $lecture->id;
            $lecture_date = date('Y-m-d', strtotime($lecture->lecture_date));
            $lecture_day = date('l', strtotime($lecture->lecture_date));
            $lecture_time_in_unix_timestamp = strtotime(date('Y-m-d', strtotime($lecture->lecture_date)));
        } catch (\Throwable $th) {
            $lecture_url = '';
            $lecture_id = '';
            $lecture_date = '';
            $time = '';
            $lecture_time_in_unix_timestamp = strtotime('23:59:59');
        }
        if (time() > $lecture_time_in_unix_timestamp - 300 && time() < $lecture_time_in_unix_timestamp + 3000) {
            $next_class =  date('m/d/Y');
        } else {
            if ($lecture_date && time() < $lecture_time_in_unix_timestamp + 3000) {
                $class_nxt = date('m/d/Y', strtotime($lecture_date));
                $next_class = $class_nxt ?? '';
            } else {
                foreach ($lecture_dates as $item) {
                    if (strtotime($item) > strtotime(date('Y-m-d'))) {
                        $next_class = $item ?? '';
                        break;
                    }
                }
            }
        }
        $institute_assigned_class_subject_teacher = \App\Models\InstituteAssignedClassSubjectTeacher::where(['institute_assigned_class_subject_id' => request()->iacs])->first();
        $teacher_id = $institute_assigned_class_subject_teacher ? $institute_assigned_class_subject_teacher->teacher_id : '';
        if ($teacher_id) {
            $teacher = \App\Models\Teacher::find($teacher_id);
        }
        foreach ($iacs->subjects_infos as $key => $item) {
            if ($item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first() != null) {
                $class_time[] = date('h:i A', strtotime($item->student_subjects_infos->where('student_id', auth()->user()->student_id)->first()->time_slot->slot));
            }
        }
        $syl = '';
        if (!empty($syllabus) && @unserialize($syllabus) == true) {
            $syllabus = unserialize($syllabus);
            $syl = $syllabus[0];
        }
        $vid = '';
        if (!empty($videoClass) && @unserialize($videoClass) == true) {
            $videoClass = unserialize($videoClass);
            $vid = $videoClass[0];
        }
        $notifications = ClassNotification::where('i_a_c_s_id', request()->iacs)->where('isread', 1)->where('type', 'text')->get();
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
        $assignmentnotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs)->whereDate('notify_date', '<=', date('Y-m-d'))->where('isread', 1)->where('type', 'assignment')->get();
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
        $test =  ClassNotification::where('i_a_c_s_id', request()->iacs)->whereDate('notify_date', '<=', date('Y-m-d'))->where('isread', 1)->where('type', 'test')->get();
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
        $dnotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs)->where('student_id', auth()->user()->student_id)->whereNotNull('institute_id')->where('isread', 2)->where('type', 'doubts')->get();
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
        $extranotifications =  ClassNotification::where('i_a_c_s_id', request()->iacs)->whereDate('notify_date', '<=', date('Y-m-d'))->where('type', 'extraClass')->get();
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
        $total_attempted = 0;
        $total_unattempted = 0;
        $marks_in_last_test = 0;
        if (!empty($start_date)) {
            $tests = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs)->where(
                'type',
                'test'
            )->orderByDesc('id')->take(10)
                ->where('publish_date', '>=', $start_date)
                ->where('publish_date', '<=', date('Y-m-d'))
                ->where('status', 'publish')->get();
            $total_tests = $tests->count();
            if ($total_tests) {
                $latest_tests = $tests->sortByDesc('id')->take(10);
                $where_answers = \App\Models\Answer::where('user_id', auth()->user()->student_id)->whereIn(
                    'topic_id',
                    $tests->pluck('id')->toArray()
                );
                $attempted = $where_answers->get();
                $total_attempted = count(array_unique($attempted->pluck('topic_id')->toArray()));
                $total_unattempted = $total_tests - $total_attempted;
                $latest_given_test = $where_answers->orderByDesc('created_at')->first();

                if (!empty($latest_given_test)) {

                    $topic = $latest_given_test->topic;
                    $answers = \App\Models\Answer::where('topic_id', $topic->id)->where('user_id', Auth::user()->student_id)->get();
                    $mark = 0;
                    foreach ($answers as $answer) {
                        if ($answer->answer == $answer->user_answer) {
                            $mark++;
                        }
                    }
                    $correct = $mark * $topic->per_q_mark;
                    $count_questions = $topic->questions->count() ?? 0;
                    $total_marks = $topic->per_q_mark * $count_questions;
                } else {
                    $correct = 0;
                    $total_marks = 0;
                }
            }
            $toatalmarks = 0;
            if ($total_marks > 0) {
                $toatalmarks = $correct . '/' . $total_marks;
            }
        }
        return response()->json([
            'status' => 200,
            'total_attempted' => $total_attempted ?? 0,
            'total_unattempted' => $total_unattempted ?? 0,
            'toatalmarks' => $toatalmarks ?? 0,
            'teacher' => !empty($teacher) ? $teacher : '',
            'class_days' => $class_days,
            'class_time' => $class_time,
            'data' => $iacs,
            'getSubjectsInfo' => $getSubjectsInfo,
            'subject' => $iacs->subject->name,
            'video' => $vid,
            'syllabus' => $syl,
            'iac' => $iacs->institute_assigned_class->institute->name,
            'i_a_c_s_id' => request()->subject,
            'assignmentnotifications' => $assignmentnotifications,
            'testsnotification' => $testsnotification,
            'dnotifications' => $dnotifications,
            'notifications' => $notifications,
            'extranotifications' => $extranotifications,
            'next_class' => $next_class,
            'student_subjects_info_id' => $student_subjects_info_id,
        ]);
    }



    public function editClassTime()
    {

        $subjects_arr = request()->student_subjects_info_id ? explode(',', request()->student_subjects_info_id) : [];
        if ($subjects_arr && Auth::user()->student_id) {
            foreach ($subjects_arr as $subjs) {
                \DB::table('student_subjects_info')->where('subjects_info_id', $subjs)->where('student_id', Auth::user()->student_id)->update([
                    'new_time_slot_id' => request()->newTime
                ]);
            }
            return response()->json([
                'status' => 200,
                'msg' => 'Class Time Updated Successfully, Timings will be effected from tommorrow onwards.',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'msg' => 'Failed to update time, try again later !!!',
            ]);
        }
    }


    public function enrollclass(Request $request)
    {
        $iacsdetails = \App\Models\InstituteAssignedClassSubject::with('subject', 'subjects_infos')->where('institute_assigned_class_id', request()->class_id)->get();
        foreach ($iacsdetails as $iacs) {
            foreach ($iacs->subjects_infos as $day) {
            }
        }
        $timeslots = \App\Models\TimeSlot::all();
        return response()->json([
            'status' => 200,
            'iacsdetails' => $iacsdetails,
            'timeslots' => $timeslots,
        ]);
    }

    public function enrollthisclass(Request $request)
    {
        $isfreetrial = false;
        if (!empty(request()->freetrial) && request()->freetrial == 1) {
            $isfreetrial = true;
        }
        $newArray = [];
        foreach (request()->slotsarr as $key => $value) {
            $newArray[] = [
                'day_id' => $value['day_id'],
                'day' => $value['day'],
                'time_slot_id' => $value['time_slot_id']
            ];
        }
        foreach ($newArray as $arr) {
            $found = array_filter($newArray, function ($v) use ($arr) {
                if ($arr['day_id'] != $v['day_id']) {
                    return $arr['day'] === $v['day'] &&  $arr['time_slot_id'] === $v['time_slot_id'];
                }
            });
            if (!empty($found)) {
                /*  return redirect()->route('student.select_timings', ['class_id' => request()->class_id])->withInput(['row' => request()->row, "class_id" => request()->class_id])->withErrors(['same_day_same_time_error' => 'You cannot set same time for ' . ucfirst(array_values($found)[0]['day'])]); */
                return response()->json([
                    'status' => 400,
                    'msg' => 'You cannot set same time for ' . ucfirst(array_values($found)[0]['day']),
                ]);
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
        $subjects = [];
        $instdata = \App\Models\Institute::where('id', $class->institute_id)->first();
        if (!empty($class)) {
            foreach ($class->institute_assigned_class_subject as $cl) {
                $subjects[] = \App\Models\Subject::where('id', $cl->subject_id)->first();
            }
        }
        $session_key = 'student_' . auth()->user()->student_id . '_class_' . request()->class_id;
        if (!empty($_SESSION[$session_key])) unset($_SESSION[$session_key]);

        $sessiondata[$session_key] = ([
            'amount' => (request()->amount ?? $class->price) . '00',
            'code' => request()->code,
            'student_id' => auth()->user()->student_id,
            'class_id' => request()->class_id,
            'row' => request()->slotsarr,
            'mode_of_class' => '2'
        ]);
        //return view('student.checkout', ['classes' => Arr::wrap($class), 'colors' => $colors, 'data' => request()->all(), 'isfreetrial' => $isfreetrial]);
        return response()->json([
            'status' => 200,
            'sessiondata' => $sessiondata,
            'session_key' => $session_key,
            'classes' => Arr::wrap($class),
            'instdata' => $instdata,
            'data' => request()->all(),
            'isfreetrial' => $isfreetrial,
            'colors' => $colors,
            'subjects' => $subjects,
        ]);
    }

    public function paynow()
    {
        request()->validate([
            'form_data' => 'required',
        ]);
        $all_data = (request()->form_data);
        $session_key = (request()->session_key);
        $form_data = $all_data[$session_key];
        $coupenAppl = '';
        if (!empty(request()->coupencode)) {
            $coupenAppl = $this->apply_coupon($form_data['class_id'], request()->coupencode, $form_data);
        }
        $cart = \App\Models\Cart::firstOrNew(['institute_assigned_class_id' => $form_data['class_id'], 'student_id' => auth()->user()->student_id]);
        $cart->form_data = json_encode($form_data, true);
        $s = $cart->save();
        $class = \App\Models\InstituteAssignedClass::findOrFail($form_data['class_id']);
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
                    'mode_of_class' => $form_data->mode_of_class,
                    'coupenAppl' => $coupenAppl,
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
        //return view('student.pay', ['data' => request()->form_data, 'amount' => $amount, 'class' => $class, 'student' => $student, 'enrolled_class' => $cart]);
        return response()->json([
            'status' => 200,
            'form_data' => $form_data,
            'amount' => $amount,
            'class' => $class,
            'student' => $student,
            'enrolled_class' => $cart,
            'coupenAppl' => $coupenAppl,
        ]);
    }


    public function mark_an_attendence()
    {
        $lecture_id = request()->lecture;
        $student_lecture = \App\Models\StudentLecture::where(['student_id' => auth()->user()->student_id, 'lecture_id' => $lecture_id])->first();
        if (!empty($student_lecture)) {
            if ($student_lecture->attendence_in_percentage < 100) {
                $student_lecture->attendence_in_percentage += 10;
                $student_lecture->save();
                return response()->json(['status' => 200, 'lecture_status' => 'ongoing']);
            } else {
                return response()->json(['status' => 200, 'lecture_status' => 'completed']);
            }
        }

        \App\Models\StudentLecture::create([
            'student_id' => auth()->user()->student_id,
            'lecture_id' => $lecture_id,
            'attendence_in_percentage' => 0
        ]);

        return response()->json(['status' => 200, 'lecture_status' => 'started']);
    }
    public function verifyPayment()
    {

        if (!empty(request()->razorpay_payment_id) && !empty(request()->class_id)) {
            $cart = \App\Models\Cart::where('institute_assigned_class_id', request()->class_id)->where('student_id', auth()->user()->student_id)->first();
            $requested_data = json_decode($cart->form_data);
            $class_id = $cart->institute_assigned_class_id;
            $row = $requested_data;

            $class = \App\Models\InstituteAssignedClass::find($class_id);


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

            $api = new \Razorpay\Api\Api(config('app.razorpay_api_key'), config('app.razorpay_api_secret'));
            $payment = $api->payment->fetch(request()->razorpay_payment_id);

            /* return response()->json([
                'status' => 403,
                'razorpay_api_key' => config('app.razorpay_api_key'),
                'razorpay_api_secret'=> config('app.razorpay_api_secret'),   
            ]);   */
            $error = false;
            try {
                $payment->capture(array('amount' => (float)($amount) * 100, 'currency' => 'INR'));
            } catch (\Throwable $th) {
                $error = true;
            }
            if ($error) {
                return response()->json([
                    'status' => 403,
                    'msg' => 'Something Went Wrong !!!',
                ]);
            }
            foreach ($row->row as $key => $value) {
                \App\Models\StudentSubjectsInfo::create([
                    'student_id' => auth()->user()->student_id,
                    'subjects_info_id' => $value->day_id,
                    'time_slot_id' => $value->time_slot_id,
                ]);
            }

            \App\Models\InstituteAssignedClassStudent::create([
                'price' => $amount,
                'institute_assigned_class_id' => $class_id,
                'student_id' => auth()->user()->student_id,
                'razorpay_payment_id' => request()->razorpay_payment_id,
                'coupon_id' => $coupon_id,
                'coupon_applied' => $coupon_applied,
                'mode_of_class' =>  '2',
            ]);

            $cart->delete();
            return response()->json([
                'status' => 200,
                'msg' => 'Payment Done Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Payment not found !!!',
            ]);
        }
    }


    public function updateprofile(Request $request)
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

        $res = $user->save();
        if ($res) {
            return response()->json([
                'status' => 200,
                'msg' => 'Profile Details Updated',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Fail to update details !!!',
            ]);
        }
    }


    public function apply_coupon($class_id = null, $coupen = null, $form_data = null)
    {

        if (!$class_id || !$coupen) {
            return response()->json(['status' => 'failed', 'message' => 'Something went wrong.']);
        }
        if ($coupon = \App\Models\Coupon::where('code', $coupen)->where(['applicable_type' => 'App\Models\InstituteAssignedClass', 'applicable_id' => $class_id, 'deleted_at' => NULL])->first()) {


            $current_time = time();

            $start_time = strtotime($coupon->start_date);
            $end_time = strtotime($coupon->end_date);
            if ($current_time > $start_time && $current_time < $end_time && $coupon->status == 1) {

                if (get_class($coupon->applicable) == "App\Models\InstituteAssignedClass") {

                    if ($coupon->applicable->id == $class_id) {

                        //$form_data = json_decode(request()->form_data);
                        $cart = \App\Models\Cart::firstOrNew(['institute_assigned_class_id' => $class_id, 'student_id' => auth()->user()->student_id]);
                        $cart->coupon_applied = '1';
                        $cart->coupon_id = $coupon->id;
                        $cart->form_data = $form_data;
                        $cart->save();

                        return (['status' => 'success', 'message' => 'Coupon Applied!!!', 'data' => ['amount' => $coupon->applicable->price - $coupon->discount_in_rs, 'code' => $coupon->code]]);
                    } else {
                        return 0;
                    }
                } else {
                    // institute
                    return $coupon->applicable->institute_assigned_classes->where('id', $class_id)->first();
                    if ($class = $coupon->applicable->institute_assigned_classes->where('id', $class_id)->first()) {
                        if ($class->id == $class_id) {
                            return (['status' => 'success', 'message' => 'Coupon Applied!!!', 'data' => ['amount' => $class->price - $coupon->discount_in_rs, 'code' => $coupon->code]]);
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        return 0;
    }


    public function getstudentextraclass()
    {
        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];
        $lectureAll = [];
        $lectureArr = [];
        if (request()->iacs_id) {
            $extra_classesGroupedByUnits = \App\Models\Unit::with('extra_classes')->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
            foreach ($extra_classesGroupedByUnits as $key => $unit) {
                if ($unit->extra_classes->count() > 0) {
                    $lects = [];
                    if (!empty($unit->extra_classes)) {
                        foreach ($unit->extra_classes as $qq) {
                            $lects[] = ([
                                'id' => $qq->id,
                                'institute_assigned_class_subject_id' => $qq->institute_assigned_class_subject_id,
                                'unit_id' => $qq->unit_id,
                                'extra_class_number' => $qq->extra_class_number,
                                'extra_class_name' => $qq->extra_class_name,
                                'extra_class_video' => !empty($qq->extra_class_video) && @unserialize($qq->extra_class_video) == true ? unserialize($qq->extra_class_video)[0] : '',
                                'extra_class_date' => $qq->extra_class_date,
                                'notes' => !empty($qq->notes) && @unserialize($qq->notes) == true ? unserialize($qq->notes)[0] : "",
                            ]);
                        }
                    }
                    $lectureArr['unit'] = $unit->name;
                    $lectureArr['lectures'] = $lects;
                    $lectureAll[] = $lectureArr;
                }
            }
        }

        $old_data = DB::table('class_notifications')->where('type', 'extraClass')->where('i_a_c_s_id', request()->iacs_id)->whereDate('notify_date', '<=', date('Y-m-d'))->get();
        if ($old_data) {
            $items2 = [];
            foreach ($old_data as $dat) {
                $old_data_arr = !empty($dat->readUsers) ? explode(',', $dat->readUsers) : [];
                if (!in_array(auth()->user()->student_id, $old_data_arr)) {
                    $items2[] = $dat->class_id ? $dat->class_id : '';
                    $old_data_arr[] = auth()->user()->student_id;
                    $query =
                        DB::table('class_notifications')->where('type', 'extraClass')->where('i_a_c_s_id', request()->iacs_id)->whereDate('notify_date', '<=', date('Y-m-d'))->update([
                            'readUsers' => implode(',', $old_data_arr),
                        ]);
                }
            }
        }
        return response()->json([
            'status' => 200,
            'lecturesGroupedByUnits' => $lectureAll,
            'iacs_id' => request()->iacs_id,
        ]);
    }

    public function getstudentsubject()
    {
        $colors = [
            'orange-gradient',
            'pink-gradient',
            'blue-gradient',
            'green-gradient',
            'sea-gradient',
            'purple-gradient',
        ];

        $lectureAll = [];
        $lectureArr = [];

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
            }])->where('institute_assigned_class_subject_id', request()->iacs_id)->get();

            if (!empty($lecturesGroupedByUnits)) {
                foreach ($lecturesGroupedByUnits as $key => $unit) {
                    if ($unit->lectures->count() > 0) {
                        $lects = [];
                        if (!empty($unit->lectures)) {
                            foreach ($unit->lectures as $qq) {
                                $lects[] = ([
                                    'id' => $qq->id,
                                    'institute_assigned_class_subject_id' => $qq->institute_assigned_class_subject_id,
                                    'unit_id' => $qq->unit_id,
                                    'lecture_number' => $qq->lecture_number,
                                    'lecture_name' => $qq->lecture_name,
                                    'lecture_video' => !empty($qq->lecture_video) && @unserialize($qq->lecture_video) == true ? unserialize($qq->lecture_video)[0] : '',
                                    'lecture_date' => $qq->lecture_date,
                                    'notes' => !empty($qq->notes) && @unserialize($qq->notes) == true ? unserialize($qq->notes)[0] : "",
                                ]);
                            }
                        }
                        $lectureArr['unit'] = $unit->name;
                        $lectureArr['lectures'] = $lects;
                        $lectureAll[] = $lectureArr;
                    }
                }
            }
        }
        return response()->json([
            'status' => 200,
            'lecturesGroupedByUnits' => $lectureAll,
            'colors' => $colors,
            'iacs_id' => request()->iacs_id
        ]);
    }


    public function getstudentAssignment()
    {

        $total2 = 0;
        $items2 = [];
        $assignmentnotifications = DB::table('class_notifications')
            ->where('i_a_c_s_id', request()->iacs_id)
            ->where('isread', 1)
            ->where('type', 'assignment')
            ->get();
        if (!empty($assignmentnotifications)) {
            foreach ($assignmentnotifications as $noti) {
                if ($noti->readUsers) {
                    $hiddenProducts = explode(',', $noti->readUsers);
                    if (in_array(auth()->user()->student_id, $hiddenProducts)) {
                        $total2 = $total2 + 0;
                    } else {
                        $total2 = $total2 + 1;
                        $items2[] = $noti->assigment_id;
                    }
                } else {
                    $total2 = $total2 + 1;
                    $items2[] = $noti->assigment_id;
                }
            }
        }
        $assignmentnotifications = $total2;
        $assignNotificationData = $items2;

        if (!empty(request()->iacs_id)) {
            $institute_assigned_class_subject = DB::table('institute_assigned_class_subject')
                ->where('id', request()->iacs_id)
                ->first();

            if (!empty($institute_assigned_class_subject)) {
                $institute_assigned_class_student = DB::table('institute_assigned_class_student')
                    ->where('institute_assigned_class_id', $institute_assigned_class_subject->institute_assigned_class_id)
                    ->where('student_id', auth()->user()->student_id)
                    ->first();
                if (!empty($institute_assigned_class_student) && !empty($institute_assigned_class_student->end_date)) {
                    $start_date = $institute_assigned_class_student->start_date;
                } else {
                    $institute_assigned_class = DB::table('institute_assigned_class')
                        ->where('id', $institute_assigned_class_subject->institute_assigned_class_id)
                        ->first();
                    $start_date = $institute_assigned_class->start_date;
                }
            }
        }
        $unitName = [];
        $topics = [];
        $assig_all_Units = Assignments_unit::all();
        if (!empty($assig_all_Units)) {
            foreach ($assig_all_Units as $value) {

                $topicsGet = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)
                    ->where('type', 'assignment')
                    ->where('status', 'publish')
                    ->where('publish_date', '<=', date('Y-m-d'))
                    ->where('publish_date', '>=', $start_date)
                    ->orderBy('publish_date', 'desc')
                    ->where('unit', $value->id)
                    ->get();
                if (!empty($topicsGet) && count($topicsGet) > 0) {
                    $auth = auth()->user()->student_id;
                    foreach ($topicsGet as $topic) {
                        $qu_count = 0;
                        $isansred = false;
                        $answered_count = 0;
                        foreach ($topic->questions as $question) {
                            if ($question->topic_id == $topic->id) {
                                $qu_count++;
                                if ($auth) {
                                    if ($answers = \App\Models\Answer::where('user_id', $auth)->where('topic_id', $topic->id)->where('question_id', $question->id)->first()) {
                                        if (!empty($answers)) {
                                            $answered_count++;
                                        }
                                    }
                                }
                            }
                        }
                        if (!empty($qu_count) && $qu_count == $answered_count) {
                            $isansred = true;
                        }
                        $topic->anwered_question =  $isansred;
                        $topic->total_question =  $qu_count;
                        $topic->answered_count =  $answered_count;
                    }
                    $unitName['id'] = $value->id;
                    $unitName['topics'] = $topicsGet;
                    $unitName['name'] = $value->unitName;
                    $topics[] = $unitName;
                }
            }
        }

        $assignment_old_unit = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)
            ->where('type', 'assignment')
            ->where('status', 'publish')
            ->where('publish_date', '<=', date('Y-m-d'))
            ->where('publish_date', '>=', $start_date)
            ->orderBy('publish_date', 'desc')
            ->where('unit', null)
            ->where('testType', null)
            ->get();
        if (!empty($assignment_old_unit)) {
            foreach ($assignment_old_unit as $oldUnit) {
                $oldUnit->questions = \App\Models\Question::where('topic_id', $oldUnit->id)->get();
            }
        }
        $old_data = DB::table('class_notifications')
            ->where('type', 'assignment')
            ->where('i_a_c_s_id', request()->iacs_id)
            ->get();
        if ($old_data) {
            foreach ($old_data as $dat) {
                $old_data_arr = !empty($dat->readUsers) ? explode(',', $dat->readUsers) : [];
                if (!in_array(auth()->user()->student_id, $old_data_arr)) {
                    $old_data_arr[] = auth()->user()->student_id;
                    $query = DB::table('class_notifications')
                        ->where('id', $dat->id)
                        ->where('notify_date', '<=', date('Y-m-d'))
                        ->update([
                            'readUsers' => implode(',', $old_data_arr),
                        ]);
                }
            }
        }
        return response()->json([
            'status' => 200,
            'topics' => $topics,
            'assignment_old_unit' => $assignment_old_unit,
        ]);
    }

    public function saveAnswer(Request $request)
    {
        $input = $request->all();
        $answer = \App\Models\Answer::firstOrNew([
            'question_id' => $input['question_id'],
            'user_id' => auth()->user()->student_id,
            'topic_id' => $input['topic_id'],
        ]);
        $answer->fill($input);
        $answer->save();
        return response()->json([
            "status" => 200,
            "message" => 'Answer saved successfully',
        ]);
    }

    public function getReport(Request $request)
    {
        $iacsId = $request->iacsId;
        $id = $request->topic_id;
        $topic = Topic::where(['id' => $id, 'institute_assigned_class_subject_id' => $iacsId])->firstOrFail();
        $answers = Answer::where('topic_id', $topic->id)->get();
        $students = Student::all();
        $c_que = Question::where('topic_id', $id)->count();

        $filtStudents = collect();
        foreach ($students as $student) {
            foreach ($answers as $answer) {
                if ($answer->user_id == $student->id) {
                    $filtStudents->push($student);
                }
            }
        }

        $filtStudents = $filtStudents->unique();
        $filtStudents = $filtStudents->flatten();
        $students = [];
        $allstudents = [];
        if (!empty($filtStudents)) {
            foreach ($filtStudents as $key => $student) {

                $mark = 0;
                $correct = collect();
                foreach ($answers as $answer) {
                    if ($answer->user_id == $student->id && $answer->answer == $answer->user_answer) {
                        $mark++;
                    }
                }
                $students['marks'] = $mark * $topic->per_q_mark;
                $students['totalmarks'] = $c_que * $topic->per_q_mark;
                $students['name'] = $student->name ?? '';
                $students['phone'] = $student->phone ?? '';
                $students['title'] = $topic->title ?? '';
                $students['id'] = $student->id ?? '';
                $allstudents[] = $students;
            }
        }

        return response()->json([
            "status" => 200,
            "filtStudents" => $filtStudents,
            "answers" => $answers,
            "c_que" => $c_que,
            "topic" => $topic,
            "allstudents" => $allstudents,
        ]);
    }

    public function storeAnswer(Request $request)
    {
        $input = $request->all();
        $answer = Answer::firstOrNew([
            'question_id' => $input['question_id'],
            'user_id' => $input['user_id'],
            'topic_id' => $input['topic_id'],
        ]);

        $answer->fill($input);
        $answer->save();
        return response()->json([
            "status" => 200,
            "message" => 'Answer Saved'
        ]);
    }

    public function startassignment()
    {
        $id = request()->assignment;
        $topic = Topic::findOrFail($id);
        $auth = auth()->user();
        $auth->id = $auth->student_id;
        if ($auth) {
            if ($answers = \App\Models\Answer::where('user_id', $auth->id)->get()) {
                $all_questions = collect();
                $q_filter = collect();
                foreach ($answers as $answer) {
                    $q_id = $answer->question_id;
                    $q_filter = $q_filter->push(\App\Models\Question::where('id', $q_id)->get());
                }
                $all_questions = $all_questions->push(\App\Models\Question::where('topic_id', $topic->id)->get());
                $all_questions = $all_questions->flatten();
                $q_filter = $q_filter->flatten();
                $questions = $all_questions->diff($q_filter);
                $questions = $questions->flatten();
                $questions = $questions->shuffle();
                $quest = [];

                if (!empty($questions)) {
                    foreach ($questions as $qq) {
                        $q_img = !empty($qq->question_img) && @unserialize($qq->question_img) == true ? unserialize($qq->question_img)[0] : '';
                        $quest[] = ([
                            'id' => $qq->id,
                            'question' => $qq->question,
                            'a' => $qq->a,
                            'b' => $qq->b,
                            'c' => $qq->c,
                            'd' => $qq->d,
                            'answer' => $qq->answer,
                            'answer_exp' => $qq->answer_exp,
                            'question_img' => $q_img,
                            'questions_no' => $qq->questions_no,
                            'testType' => $qq->testType,
                        ]);
                    }
                }
                return response()->json([
                    "status" => 200,
                    "questions" => $quest,
                    "auth" => $auth,
                    "topic" => $topic
                ]);
            }
            $questions = collect();
            $questions = \App\Models\Question::where('topic_id', $topic->id)->get();
            $questions = $questions->flatten();
            $questions = $questions->shuffle();
            return response()->json([
                "status" => 200,
                "questions" => $questions,
                "tid" => $topic,
                "auth" => $auth
            ]);
        }
    }



    public function resettest(Request $request)
    {
        $student = $request->student ?? '';
        $topic_id = $request->topic_id ?? '';
        $answer = Answer::where('user_id', $student)->where('topic_id', $topic_id)->delete();
        if ($answer) {
            return response()->json([
                "status" => 200,
                "msg" => 'Answer"s cleared successfully',
            ]);
        } else {
            return response()->json([
                "status" => 200,
                "msg" => 'Fail to clear data !!!',
                're' => $request->all()
            ]);
        }
    }

    public function finishAssign(Request $request)
    {
        $auth = auth()->user();
        $topic = \App\Models\Topic::findOrFail($request->topic_id);
        $questions = \App\Models\Question::where('topic_id', $request->topic_id)->get();
        $count_questions = $questions->count();
        $answers = \App\Models\Answer::where('user_id', $auth->student_id)->where('topic_id', $request->topic_id)->get();
        $unmark = 0;
        $mark = 0;
        $correct = collect();
        foreach ($answers as $answer) {
            if ($answer->answer == $answer->user_answer) {
                $mark++;
            } else {
                $unmark++;
            }
        }
        $correct = $mark * $topic->per_q_mark;
        $totalMarks = $topic->per_q_mark * $count_questions;
        $percentage = round($correct / $totalMarks * 100, 2);
        $quest = [];
        if (!empty($questions)) {
            foreach ($questions as $qq) {
                $q_img = !empty($qq->question_img) && @unserialize($qq->question_img) == true ? unserialize($qq->question_img)[0] : '';
                $quest[] = ([
                    'id' => $qq->id,
                    'question' => $qq->question,
                    'a' => $qq->a,
                    'b' => $qq->b,
                    'c' => $qq->c,
                    'd' => $qq->d,
                    'answer' => $qq->answer,
                    'answer_exp' => $qq->answer_exp,
                    'question_img' => $q_img,
                    'questions_no' => $qq->questions_no,
                    'testType' => $qq->testType,
                ]);
            }
        }
        return response()->json([
            "status" => 200,
            "topic" => $topic,
            "answers" => $answers,
            "questions" => $quest,
            "totalMarks" => $totalMarks,
            "correct" => $correct,
            "totalcorrect" => $mark,
            "totalnotcorrect" => $unmark,
            "percentage" => $percentage,
            "count_questions" => $count_questions,
        ]);
    }

    public function send_btn(Request $request)
    {

        $doubt = \App\Models\Doubt::firstOrNew([
            'institute_assigned_class_subject_id' => request()->iacs,
            'student_id' => auth()->user()->student_id,
        ]);

        $doubt->institute_assigned_class_subject_id = request()->iacs;
        $doubt->student_id = auth()->user()->student_id;
        if (!$doubt->doubt_id) {
            $doubt->doubt_id = uniqid();
        }
        $doubt->save();
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id;
        if (request()->type == 'file' && request()->hasFile('message')) {
            /* $file = request()->file('message')->store('/doubts/' . request()->doubt, 's3');
            $file_name = $file;  */
            $folderName = 'institutes/doubts' . '/' . $iac->institute_id . '/' . $iac->id . '/' . request()->iacs . '/' . $doubt->id;
            $folder = createFolder($folderName);
            $fileData = request()->file('message');
            $file = createUrlsession($fileData, $folder);
            $file_name = '';
            if (!empty($file) && $file != 400) {
                $file_name = serialize($file);
                $msg = $file_name;
            }
        }
        if (request()->type == 'text' && !empty(request()->message)) {
            $msg = request()->message;
        }
        \App\Models\DoubtMessage::create([
            'sendable_type' => '\App\Models\Student',
            'sendable_id' => auth()->user()->student_id,
            'message' => $msg,
            'doubt_id' => $doubt->id,
            'type' => request()->type,
        ]);

        $query = \App\Models\ClassNotification::create([
            'i_a_c_s_id' => request()->iacs,
            'type' => 'doubts',
            'message' => 'New doubt',
            'student_id' => auth()->user()->student_id,
            'doubt_id' => $doubt->id,
            'isread' => 3,
        ]);
        if ($query) {
            return response()->json([
                "status" => 200,
                "msg" => 'Message sent successfully'
            ]);
        } else {
            return response()->json([
                "status" => 400,
                "msg" => 'Fail to send message !!!'
            ]);
        }
    }

    public function loadstudentDoubt()
    {
        if ($doubt = \App\Models\Doubt::where([
            'institute_assigned_class_subject_id' => request()->iacs,
            'student_id' => auth()->user()->student_id
        ])->first()) {
            $doubt_messages = DB::table('doubt_messages')->where('doubt_id', $doubt->id)->get();
            $itemmsg = [];
            foreach ($doubt_messages as $item) {
                $msg = DB::table('doubt_messages')->where('id', $item->id)->orderBy('created_at', 'desc')->first();

                if (!empty($msg->type) && $msg->type == 'file' && @unserialize($msg->message)) {
                    $m_SG = unserialize($msg->message)[0];
                } elseif (!empty($msg->type) && $msg->type == 'text') {
                    $m_SG = $msg->message;
                }
                if (!empty($msg)) {
                    $stud = Student::where('id', auth()->user()->student_id)->first();
                    $avatar =  !empty($stud->avatar) ? $stud->avatar : url('/assets/front/images/cost.png');
                    $itemmsg[] = ([
                        'id' => $msg->id,
                        'doubt_id' => $msg->doubt_id,
                        'sendable_type' => $msg->sendable_type,
                        'sendable_id' => $msg->sendable_id,
                        'avatar' => $avatar ?? '',
                        'created_at' => $msg->created_at ?? '',
                        'message' => $m_SG ?? '',
                        'type' => $msg->type,
                    ]);
                }
            }
            $old_data =
                DB::table('class_notifications')->where('student_id', auth()->user()->student_id)->where('isread', 2)->where('i_a_c_s_id', request()->iacs)->get();
            if ($old_data) {
                foreach ($old_data as $dat) {
                    $old_data_arr = !empty($dat->readUsers) ? explode(',', $dat->readUsers) : [];
                    if (!in_array(auth()->user()->student_id, $old_data_arr)) {
                        $old_data_arr[] = auth()->user()->student_id;
                        $query =
                            DB::table('class_notifications')->where('i_a_c_s_id', request()->iacs)->where('isread', 2)->where('student_id', auth()->user()->student_id)->update([
                                'readUsers' => implode(',', $old_data_arr),
                                'isread' => 4
                            ]);
                    }
                }
            }
            return response()->json([
                "status" => 200,
                "messages" => $itemmsg,
                'student' => auth()->user()->student_id
            ]);
        } else {
            return response()->json([
                "status" => 400,
                "messages" => '',
                'student' => auth()->user()->student_id
            ]);
        }
    }

    public function getnotification()
    {

        $id = request()->iacs;
        $notifications = ClassNotification::where('i_a_c_s_id', $id)->where('isread', 1)->where('type', 'text')->orderBy('created_at', 'desc')->get();
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
            $totalnot = $items;
        }
        return response()->json([
            "status" => 400,
            "messages" => $totalnot,
            'student' => auth()->user()->student_id
        ]);
    }

    public function readnotification()
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
        }
        return response()->json([
            "status" => 200,
            'message' => 'Notification removed'
        ]);
    }


    public function generate_student_receipt(Request $request)
    {

        $class_id = !empty($request->class_id) ? $request->class_id : '';
        $student_id = !empty($request->student_id) ? $request->student_id : '';
        if ($class_id && $student_id) {
            $class = \App\Models\InstituteAssignedClass::find($class_id);
            if (empty($class->students->where('id', $student_id)->first())) {
                abort(404);
            }
            $student = $class->students->where('id', $student_id)->first();
            $enrolled_class = \App\Models\InstituteAssignedClassStudent::where('institute_assigned_class_id', $class->id)->where('student_id', $student->id)->first();
            if ($enrolled_class->coupon_applied) {
                $discount_in_rs = \App\Models\Coupon::withTrashed()->where(
                    'id',
                    $enrolled_class->coupon_id
                )->first()->discount_in_rs;
                $total_amount = $class->price - $discount_in_rs;
            } else {
                $discount_in_rs = 0;
                $total_amount = $class->price;
            }
            if (!empty($enrolled_class)) {
                $free_trial = $enrolled_class->price;
                $pay_id = $enrolled_class->razorpay_payment_id;
            }
            if ($pay_id == "manual_enrollment") {
                $text = " We acknowledge with thanks from Mr/Mrs........." . $student->name . "........ Payment of
                Rs......Scholarship....... (In figures) via ONLINE by towards payment of class enrolled.";
            } else {
                if ($free_trial == 0) {
                    $text = " We acknowledge with thanks from Mr/Mrs........." . $student->name . "........ Payment of
                    Rs......Free Trial....... (In figures) via ONLINE by towards payment of class enrolled.";
                } else if ($free_trial != 0) {
                    $text = "We acknowledge with thanks from Mr/Mrs.........." . $student->name . "........ Payment of
                    Rs......" . $total_amount . "....... (In figures) via ONLINE by towards payment of class
                    enrolled.";
                }
            }

            return response()->json([
                'status' => 200,
                'pay_id' => $pay_id ?? '',
                'free_trial' => $free_trial ?? '',
                'class' => $class,
                'student' => $student,
                'enrolled_class' => $enrolled_class,
                'total_amount' => $total_amount,
                'text' => $text,
                'institute_name' => $class->institute->name ?? '',
                'discount_in_rs' => $discount_in_rs,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'data' => 'No data',
            ]);
        }
    }


    public function loadRecipts()
    {
        $allclass = auth()->user()->student->institute_assigned_classes;
        foreach ($allclass as $class) {
            $student = \App\Models\InstituteAssignedClassStudent::where('student_id', Auth::user()->student_id)
                ->where('institute_assigned_class_id', $class->id)
                ->first();
            $class->student = $student;
            if (!empty($student->razorpay_payment_id == 'manual_enrollment')) {

                $class->purchase_type = "Scholarship";
            } else {
                if (!empty($student->price == 0)) {
                    $class->purchase_type = "Free trial";
                } else {
                    if ($class->pivot->coupon_applied) {
                        $discount = \App\Models\Coupon::withTrashed()->where('id', $class->pivot->coupon_id)->first()->discount_in_rs;
                        $class->classprice = $class->price - $discount;
                    } else {
                        $class->classprice = $class->price;
                    }
                    $class->purchase_type = "Paid";
                }
            }
            $class->inst_name = $class->institute->name ?? '';
            $class->coupon_applied = $class->pivot->coupon_applied;
            $class->enrolledOn = $class->created_at->format('d/m/Y');
        }
        return response()->json([
            "status" => 200,
            'data' => $allclass
        ]);
    }
    public function getstudents(Request $request)
    {
        $id = $request->iacs ? $request->iacs :  '';
        $class_id = $request->subject ? $request->subject :  '';
        if ($id && $class_id) {
            $instituteClass = \DB::table('institute_assigned_class')->where('institute_id', $id)->where('id', $class_id)->get();
            return response()->json([
                "status" => 200,
                'instituteClass' => $instituteClass
            ]);
            if ($instituteClass) {
                $resData = [];
                $allData = [];
                $insideData = [];
                foreach ($instituteClass as $ins) {
                    $resData['student'] = \DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $ins->id)->orderBy('id', 'desc')->get();
                    foreach ($resData['student'] as $key => $single_student) {
                        $insideData[] = \App\Models\Student::with('lectures')->where('id', $single_student->student_id)->first();
                        $single_student->detail = $insideData;
                    }
                    $allData[] = $resData;
                }
            }
        }
        return response()->json([
            "status" => 200,
            'data' => $allData
        ]);
    }
}