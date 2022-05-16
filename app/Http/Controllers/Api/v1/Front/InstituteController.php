<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Config;
use App\Models\InstituteApplication;
use App\Models\ClassNotification;
use App\Models\Subject;
use App\Models\Assignments_unit;
use App\Models\Topic;
use App\Models\User;
use App\Models\ExtraClass;
use App\Models\Question;
use App\Models\SubjectsInfo;
use App\Models\Test_unit;
use App\Models\Language;
use Validator;
use Auth;
use DatePeriod;
use DateTime;
use DateInterval;
use Vimeo\Laravel\Facades\Vimeo;
use DB;

class InstituteController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::guard('api')->user();

        if (empty($user)) {
            return response()->json(
                [
                    Config::get('constants.key.status') => 'session_expired',
                    Config::get('constants.key.data') => false
                ],
                Config::get('constants.key.200')
            );
        }

        $classes = [];
        $allclasses = [];
        $langArr = [];
        $total2 = 0;
        if ($user) {
            if ($user->institute->institute_assigned_classes->count() > 0) {
                foreach ($user->institute->institute_assigned_classes as $institute_assigned_class) {
                    $classes['class'] = $institute_assigned_class;
                    $allarr = [];
                    $subjectArr = [];
                    $subjectMainId = [];
                    if ($institute_assigned_class->institute_assigned_class_subject->count() > 0) {
                        foreach ($institute_assigned_class->institute_assigned_class_subject as $subject) {
                            $doubtsnotify = ClassNotification::where('i_a_c_s_id', $subject->id)->where('isread', 3)->where('type', 'doubts')->get();
                            if (!empty($doubtsnotify)) {
                                foreach ($doubtsnotify as $noti) {
                                    if ($noti->readUsers) {
                                        $hiddenProducts = explode(',', $noti->readUsers);
                                        if (in_array(request()->i_a_c_s_id, $hiddenProducts)) {
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

                            $subjectArr['subject'] =  Subject::where('id', $subject->subject_id)->first();
                            $subjectArr['id'] =  $subject->id;
                            $allarr[] = $subjectArr;
                            $doubtsnotifytotal = $total2;
                            $classes['doubt_notify'] = $doubtsnotifytotal;
                        }
                        $classes['language'] =  Language::where('id', $institute_assigned_class->language)->first();
                        $classes['subjects'] = $allarr;
                        $classes['students'] = $institute_assigned_class->students->count();
                        $classes['institute'] = !empty($user->institute) ? $user->institute : '';
                        $allclasses[] = $classes;
                    }
                }
            }
        }
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $allclasses
            ],
            Config::get('constants.key.200')
        );
    }

    public function inst_detail(Request $request)
    {
        $i_a_c_s_id = !empty($request->iacs) ? $request->iacs  : '';
        $subject_id = !empty($request->subject) ? $request->subject  : '';
        if ($i_a_c_s_id && $subject_id) {
            $getSubjectsInfo = SubjectsInfo::where('institute_assigned_class_subject_id', $i_a_c_s_id)
                ->get();
            $subject = \App\Models\Subject::findOrFail($subject_id);
            $total2 = 0;
            $items2 = [];
            $segmentid = request()->segment(4);
            $doubtsnotify =  ClassNotification::where('i_a_c_s_id', $i_a_c_s_id)->where('isread', 3)->where('type', 'doubts')->get();
            if (!empty($doubtsnotify)) {
                foreach ($doubtsnotify as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array(request()->i_a_c_s_id, $hiddenProducts)) {
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
            $doubtsnotify = $total2;
            $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($i_a_c_s_id);
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
            $iac = $iacs->institute_assigned_class;
            $studentcount = $iacs->institute_assigned_class->students;
            $syllabus = $iacs->syllabus ?? '';
            $videoClass = $iacs->video ?? '';
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
            $class_days = [];
            if ($getSubjectsInfo->count() > 0) {
                foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                    if (in_array($day, $getSubjectsInfo->pluck('day')->toArray())) {
                        $class_days[] = $day;
                    }
                }
            }
            $class_time = [];
            foreach ($iacs->subjects_infos as $key => $item) {
                foreach ($studentcount as $k => $studen) {
                    if ($item->student_subjects_infos->first() != null) {
                        if ($item->student_subjects_infos->where('student_id', $studen->id)->first() != null) {
                            $name = User::where('student_id', $studen->id)->first();
                            $slots['time'] = date('h:i A', strtotime($item->student_subjects_infos->where('student_id', $studen->id)->first()->time_slot->slot));
                            $slots['name'] = $studen->name;
                            $slots['day'] = $item->day;
                            $class_time[] = $slots;
                        }
                    }
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
            $dataArr = [
                'getSubjectsInfo' => $getSubjectsInfo,
                'lecture_dates' => $lecture_dates,
                'iac' => $iac,
                'class_days' => $class_days,
                'subject' => $subject,
                'doubtsnotify' => $doubtsnotify,
                'i_a_c_s_id' => $i_a_c_s_id,
                'syllabus' => $syl,
                'video' => $vid,
                'videoapproval' => $iacs->videoApproval ?? '0',
                'next_class' => $next_class ?? '',
                'class_time' => $class_time,
                'studentcount' => $studentcount,
            ];
            return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.success'),
                    Config::get('constants.key.data') => $dataArr,
                    'status' => 200
                ],
                Config::get('constants.key.200')
            );
        } else {
            return response()->json(
                [
                    Config::get('constants.key.status') => Config::get('constants.value.error'),
                    Config::get('constants.key.data') => ''
                ],
                Config::get('constants.key.200')
            );
        }
    }

    function _group_by($array, $key)
    {
        $return = array();
        foreach ($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    public function extraclass(Request $request)
    {
        $iacs = $request->iacs ? $request->iacs  : '';
        $lecturesGroupedByUnits = \App\Models\Unit::with('extra_classes')->where('institute_assigned_class_subject_id', $iacs)->orderBy('created_at', 'desc')->get();
        $lectureAll = [];
        $lectureArr = [];
        if (!empty($lecturesGroupedByUnits)) {
            foreach ($lecturesGroupedByUnits as $key => $unit) {
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
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $lectureAll
            ],
            Config::get('constants.key.200')
        );
    }



    public function lectures(Request $request)
    {
        $iacs = $request->iacs ? $request->iacs  : '';
        $lecturesGroupedByUnits = \App\Models\Unit::with('lectures')->where('institute_assigned_class_subject_id', $iacs)->orderBy('created_at', 'desc')->get();
        $lectureAll = [];
        $lectureArr = [];
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
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $lectureAll
            ],
            Config::get('constants.key.200')
        );
    }
    public function getClassunits(Request $request)
    {
        $iacs = $request->iacs ? $request->iacs  : '';
        $units = \App\Models\Unit::where('institute_assigned_class_subject_id', $iacs)->get();
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $units
            ],
            Config::get('constants.key.200')
        );
    }
    public function getAssignmentunits(Request $request)
    {
        $iacs = $request->iacs ? $request->iacs  : '';
        $units = Assignments_unit::where('institute_assigned_class_subject_id', $iacs)->get();
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $units
            ],
            Config::get('constants.key.200')
        );
    }
    public function getTestunits(Request $request)
    {
        $iacs = $request->iacs ? $request->iacs  : '';
        $units = Test_unit::where('institute_assigned_class_subject_id', $iacs)->get();
        return response()->json(
            [
                Config::get('constants.key.status') => Config::get('constants.value.success'),
                Config::get('constants.key.data') => $units
            ],
            Config::get('constants.key.200')
        );
    }
    public function createLecture(Request $request)
    {
        $unit_name = !empty($request->unit) ? $request->unit : '';
        $number = !empty($request->number) ? $request->number : '';
        $lecturename = !empty($request->lecturename) ? $request->lecturename : '';
        $date = !empty($request->date) ? $request->date : '';
        $notes = !empty($_FILES['notes']) ? $_FILES['notes'] : '';
        $video = !empty($_FILES['video']) ? $_FILES['video'] : '';
        $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => $unit_name])->first();
        //continue
        if (empty($unit)) {
            return response()->json([
                'status' => 205,
                'msg' => 'Fill up erquired fileds !!!'
            ]);
        }
        $available_days = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->get()->pluck('day');
        $latest_lecture = \App\Models\Lecture::orderBy('lecture_date', 'desc')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->first();
        $latest_lecture_date = $latest_lecture ? date('Y-m-d', strtotime($latest_lecture->lecture_date)) : date('Y-m-d');

        $next_lecture_date = date('Y-m-d', strtotime($date));
        $video_url = '';
        if (request()->hasFile('video')) {
            $folderName = '/institutes/lectures/videos/' . auth()->user()->institute_id . '/' . request()->i_assigned_class_subject_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('video');
            $file = createUrlsession($fileData, $folder);
            if (!empty($file) && $file != 400) {
                $video_name = serialize($file);
            } else {
                $video_name = '';
            }
        } else {
            $video_directory = '';
            $video_name = '';
        }
        if (request()->hasFile('notes')) {
            $folderName = '/institutes/lectures/notes/' . auth()->user()->institute_id . '/' . request()->i_assigned_class_subject_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('notes');
            $file1 = createUrlsession($fileData, $folder);
            if (!empty($file1) && $file1 != 400) {
                $notes_val = serialize($file1);
            } else {
                $notes_val = '';
            }
        } else {
            $notes_val = '';
        }
        $result = [];
        if (!empty($request->last_id)) {
            $last_id = $request->last_id;
            $oldData = \DB::table('lectures')->where('id', $last_id)->first();
            $query = \DB::table('lectures')->where('id', $last_id)->update([
                'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
                'unit_id' => $unit->id,
                'lecture_number' => $number,
                'lecture_name' => $lecturename,
                'lecture_video' =>  !empty($video_name) ? $video_name : $oldData->lecture_video,
                'notes' => !empty($notes_val) ? $notes_val : $oldData->notes,
                'lecture_date' => $next_lecture_date,
            ]);

            return response()->json([
                'status' => 200,
                'msg' => 'Lecture details updated'
            ]);
        } else {
            $query = \App\Models\Lecture::create([
                'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
                'unit_id' => $unit->id,
                'lecture_number' => $number,
                'lecture_name' => $lecturename,
                'lecture_video' =>  $video_name ? $video_name : '',
                'notes' =>  $notes_val ? $notes_val : '',
                'lecture_date' => $next_lecture_date,
            ]);
            return response()->json([
                'status' => 200,
                'msg' => 'Lecture details added'
            ]);
        }
    }

    public function createExtraclass(Request $request)
    {
        $unit_name = !empty($request->unit) ? $request->unit : '';
        $number = !empty($request->number) ? $request->number : '';
        $lecturename = !empty($request->lecturename) ? $request->lecturename : '';
        $date = !empty($request->date) ? $request->date : '';
        $notes = !empty($_FILES['notes']) ? $_FILES['notes'] : '';
        $video = !empty($_FILES['video']) ? $_FILES['video'] : '';



        $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => $unit_name])->first();
        $available_days = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->get()->pluck('day');
        $latest_extra_class = \App\Models\ExtraClass::orderBy('extra_class_date', 'desc')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->first();
        $latest_extra_class_date = $latest_extra_class ? date('Y-m-d', strtotime($latest_extra_class->extra_class_date)) : date('Y-m-d');
        $video_url = '';

        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->i_assigned_class_subject_id);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id;

        if (request()->hasFile('video')) {
            $folderName = '/institutes/extraclass/videos/' . auth()->user()->institute_id . '/' . $class_id . '/' . request()->i_assigned_class_subject_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('video');
            $file = createUrlsession($fileData, $folder);
            if (!empty($file) && $file != 400) {
                $video_name = serialize($file);
            }
        } else {
            $video_directory = '';
            $video_name = '';
        }
        if (request()->hasFile('notes')) {
            $folderName = '/institutes/extraclass/notes/' . auth()->user()->institute_id . '/' . $class_id . '/' . request()->i_assigned_class_subject_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('notes');
            $file1 = createUrlsession($fileData, $folder);
            if (!empty($file1) && $file1 != 400) {
                $notes_val = serialize($file1);
            }
        } else {
            $notes_directory = '';
            $notes_val = '';
        }


        $result = [];
        if (!empty($request->last_id)) {
            $last_id = $request->last_id;
            $oldData = \DB::table('extra_classes')->where('id', $last_id)->first();
            $query = \DB::table('extra_classes')->where('id', $last_id)->update([
                'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
                'unit_id' => $unit->id,
                'extra_class_number' => $number,
                'extra_class_name' => $lecturename,
                'extra_class_video' =>  !empty($video_name) ? $video_name : $oldData->extra_class_video,
                'notes' => !empty($notes_val) ? $notes_val : $oldData->notes,
                'extra_class_date' => $latest_extra_class_date,
            ]);
            return response()->json([
                'status' => 200,
                'msg' => 'Extra Class updated successfully'
            ]);
        } else {
            $query = \App\Models\ExtraClass::create([
                'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
                'unit_id' => $unit->id,
                'extra_class_number' => $number,
                'extra_class_name' => $lecturename,
                'extra_class_video' =>  $video_name ? $video_name : '',
                'notes' =>  $notes_val ? $notes_val : '',
                'extra_class_date' => $latest_extra_class_date,
            ]);

            $isexist = \App\Models\ClassNotification::where('i_a_c_s_id', request()->i_assigned_class_subject_id)->where('class_id', $query)->where('notify_date', $latest_extra_class_date)->first();
            if (empty($isexist)) {
                $not = \App\Models\ClassNotification::create([
                    'i_a_c_s_id' => request()->i_assigned_class_subject_id,
                    'type' => 'extraClass',
                    'message' => 'New extra class',
                    'class_id' => $query,
                    'notify_date' => $date
                ]);
            }
            return response()->json([
                'status' => 200,
                'msg' => 'Extra Class added successfully'
            ]);
        }
    }


    public function getNextLectureDate($available_days, $latest_lecture_date)
    {

        $next_lecture_date = '';
        $dates = [];
        foreach ($available_days as $key => $ad) {
            date_default_timezone_set('ASIA/KOLKATA');
            $condition_1 = strtotime($latest_lecture_date) < strtotime(date('Y-m-d', strtotime($latest_lecture_date . ' this ' . $ad)));
            $condition_2 = strtotime(date($latest_lecture_date . ' H:i:s')) < (strtotime(date('Y-m-d', strtotime($latest_lecture_date . ' this ' . $ad))) - 7200);
            echo '<pre>';
            if ($condition_1 && $condition_2) {
                $dates[] = date('Y-m-d', strtotime($latest_lecture_date . ' next ' . $ad));
            }
        }

        if (empty($dates)) {

            return $this->getNextLectureDate($available_days, date('Y-m-d', strtotime($latest_lecture_date . ' +1 day')));
        }

        usort($dates, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });

        return $dates[0];
    }

    public function enrollments(Request $request)
    {
        $id = $request->iacs ? $request->iacs :  '';
        $class_id = $request->subject ? $request->subject :  '';
        if ($id && $class_id) {
            $instituteClass = \DB::table('institute_assigned_class')->where('institute_id', $id)->where('id', $class_id)->get();
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
            return response()->json(
                [
                    'status' => 200,
                    'students' => $allData
                ]
            );
        }
    }



    public function delLecture(Request $request)
    {
        $id = $request->id;
        $deletedFromonedrive = \App\Models\Lecture::where('id', $id)->first();
        $notes_id = !empty($deletedFromonedrive->notes) ? unserialize($deletedFromonedrive->notes) : '';
        $video_id = !empty($deletedFromonedrive->lecture_video) ? unserialize($deletedFromonedrive->lecture_video) : '';

        if ($notes_id) {
            $dNote = deleteFiles($notes_id[1]);
        }
        if ($video_id) {
            $dvideo = deleteFiles($video_id[1]);
        }
        $res = \App\Models\Lecture::where('id', $id)->delete();
        if ($res) {
            return response()->json([
                'status' => 200,
                'msg' => 'Deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Something went wrong'
            ]);
        }
    }

    public function delExtraClass(Request $request)
    {
        $id = $request->id;
        $deletedFromonedrive = \App\Models\ExtraClass::where('id', $id)->first();
        $notes_id = !empty($deletedFromonedrive->notes) && @unserialize($deletedFromonedrive->notes) == true ? unserialize($deletedFromonedrive->notes) : '';
        $video_id = !empty($deletedFromonedrive->extra_lecture_video) && @unserialize($deletedFromonedrive->extra_lecture_video) == true ? unserialize($deletedFromonedrive->extra_lecture_video) : '';
        if ($notes_id) {
            $dNote = deleteFiles($notes_id[1]);
        }
        if ($video_id) {
            $dvideo = deleteFiles($video_id[1]);
        }
        $res = \App\Models\ExtraClass::where('id', $id)->delete();
        if ($res) {
            return response()->json([
                'status' => 200,
                'msg' => 'Deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Something went wrong'
            ]);
        }
    }

    public function getLecture(Request $request)
    {
        $id = $request->id;
        $lecture = \App\Models\Lecture::where('id', $id)->first();
        if (!empty($lecture)) {
            $lecture = ([
                'id' => $lecture->id,
                'institute_assigned_class_subject_id' => $lecture->institute_assigned_class_subject_id,
                'unit_id' => $lecture->unit_id,
                'lecture_number' => $lecture->lecture_number,
                'lecture_name' => $lecture->lecture_name,
                'lecture_video' => !empty($lecture->lecture_video) && @unserialize($lecture->lecture_video) ? unserialize($lecture->lecture_video)[0] : '',
                'lecture_date' => $lecture->lecture_date,
                'notes' => !empty($lecture->notes) && @unserialize($lecture->notes) ? unserialize($lecture->notes)[0] : "",
            ]);
        }
        if ($lecture) {
            return response()->json([
                'status' => 200,
                'data' => $lecture
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'data' => ''
            ]);
        }
    }
    public function getExtraClass(Request $request)
    {
        $id = $request->id;
        $lecture = \App\Models\ExtraClass::where('id', $id)->first();
        if (!empty($lecture)) {
            $lect = ([
                'id' => $lecture->id,
                'institute_assigned_class_subject_id' => $lecture->institute_assigned_class_subject_id,
                'unit_id' => $lecture->unit_id,
                'extra_class_number' => $lecture->extra_class_number,
                'extra_class_name' => $lecture->extra_class_name,
                'extra_class_video' => !empty($lecture->extra_class_video) && @unserialize($lecture->extra_class_video) == true ? unserialize($lecture->extra_class_video)[0] : '',
                'extra_class_date' => $lecture->extra_class_date,
                'notes' => !empty($lecture->notes) && @unserialize($lecture->notes) == true ? unserialize($lecture->notes)[0] : "",
            ]);
        }

        if ($lect) {
            return response()->json([
                'status' => 200,
                'data' => $lect
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'data' => ''
            ]);
        }
    }


    public function creatnotify(Request $request)
    {
        request()->validate([
            'notifytext' => 'required',
        ]);
        $query = \App\Models\ClassNotification::create([
            'i_a_c_s_id' => $request->iacs,
            'type' => $request->type,
            'message' => $request->notifytext,
        ]);
        if ($query) {
            return response()->json([
                'status' => 200,
                'msg' => 'Notification created successfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Error, try again later'
            ]);
        }
    }

    public function getAssignments()
    {

        $unitName = [];
        $topics = [];
        $unitNames = Assignments_unit::all();
        $questions = Question::all();
        if ($unitNames) {
            foreach ($unitNames as $u_name) {
                $topics_get = Topic::where('institute_assigned_class_subject_id', request()->iacs)
                    ->where('type', 'assignment')
                    ->where('unit', $u_name->id)
                    ->orderBy('publish_date', 'desc')
                    ->get();
                if (!empty($topics_get) && count($topics_get) > 0) {
                    $unitName['unit'] = $u_name->id;
                    $unitName['topics'] = $topics_get;
                    if (!empty($topics_get)) {
                        foreach ($topics_get as $tpic) {
                            $qu_count = 0;
                            foreach ($questions as $question) {
                                if ($question->topic_id == $tpic->id) {
                                    $qu_count++;
                                }
                            }
                            $tpic->totalQuestions = $qu_count;
                        }
                    }
                    $unitName['name'] = $u_name->unitName;
                    $topics[] = $unitName;
                }
            }
        }
        $assignmet_w_n_t = Topic::where('institute_assigned_class_subject_id', request()->iacsId)
            ->where('type', 'assignment')
            ->where('unit', null)
            ->where('testType', null)
            ->orderBy('publish_date', 'desc')
            ->get();
        if ($topics) {
            return response()->json([
                'status' => 200,
                'topics' => $topics,
                'assignmet_w_n_t' => $assignmet_w_n_t,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'topics' => [],
                'assignmet_w_n_t' => [],
            ]);
        }
    }

    public function createAssignments(Request $request)
    {

        $id = $request->iacs ? $request->iacs :  '';
        $input = $request->all();
        $input['institute_assigned_class_subject_id'] = $id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'per_q_mark' => 'required',
            'unit' => 'required'
        ]);
        if (empty($request->unit)) {
            return response()->json([
                'status' => 200,
                'msg'  => 'Add unit before adding assignment !!!'
            ]);
        }
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            if (isset($request->quiz_price)) {
                $request->validate([
                    'amount' => 'required'
                ]);
            }

            if (isset($request->quiz_price)) {
                $input['amount'] = $request->amount;
            } else {
                $input['amount'] = null;
            }

            if (isset($request->show_ans)) {
                $input['show_ans'] = "1";
            } else {
                $input['show_ans'] = "0";
            }
            $input['type'] = "assignment";

            if (!empty($request->last_id)) {

                $last_id = $request->last_id;
                $topic = Topic::findOrFail($last_id);
                $topic->title = $request->title;
                $topic->description = $request->description;
                $topic->per_q_mark = $request->per_q_mark;
                $topic->timer = $request->timer;
                $topic->unit = $request->unit;

                if (isset($request->show_ans)) {
                    $topic->show_ans = 1;
                } else {
                    $topic->show_ans = 0;
                }

                if (isset($request->pricechk)) {
                    $topic->amount = $request->amount;
                } else {
                    $topic->amount = NULL;
                }

                $topic->type = "assignment";
                $topic->testType = $request->testType;
                $topic->save();
                return response()->json([
                    'status' => 200,
                    'msg' => 'Assignment has been updated successfully'
                ]);
            } else {
                $quiz = Topic::create($input);
                return response()->json([
                    'status' => 200,
                    'msg'  => 'Assignment has been added successfully'
                ]);
            }
        }
    }

    public function createAssigmentUnit()
    {
        if (!empty(request()->unitName)) {
            $uniqueUnits = Assignments_unit::where('unitName', request()->unitName)->first();
            if ($uniqueUnits == null) {
                $iacsId = request()->iacsId ? request()->iacsId :  '';
                $ass_unit = Assignments_unit::where(['institute_assigned_class_subject_id' => $iacsId, 'unitName' =>
                request()->unitName]);
                if ($ass_unit->count()) {
                    return response()->json(['status' => true, 'data' => ['id' => $ass_unit->first()->id, 'unitName' =>
                    $ass_unit->first()->unitName]]);
                } else {
                    $unit_hs = Assignments_unit::create([
                        'institute_assigned_class_subject_id' => $iacsId,
                        'unitName' => request()->unitName,
                    ]);
                    if ($unit_hs) {
                        return response()->json([
                            'status' => 200,
                            'msg' => 'Unit added successfully'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'msg' => 'Failed to add unit!!!'
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'msg' => 'This unit name is already exist!'
                ]);
            }
        } else {

            return response()->json([
                'status' => 401,
                'msg' => 'Unit name cannot be empty!!'
            ]);
        }
    }

    public function createTestUnit()
    {
        if (!empty(request()->unitName)) {
            $uniqueUnits = Test_unit::where('unit', request()->unitName)->first();
            if ($uniqueUnits == null) {
                $iacsId = request()->iacsId ? request()->iacsId :  '';
                $ass_unit = Test_unit::where(['institute_assigned_class_subject_id' => $iacsId, 'unit' =>
                request()->unitName]);
                if ($ass_unit->count()) {
                    return response()->json(['status' => true, 'data' => ['id' => $ass_unit->first()->id, 'unit' =>
                    $ass_unit->first()->unitName]]);
                } else {
                    $unit_hs = Test_unit::create([
                        'institute_assigned_class_subject_id' => $iacsId,
                        'unit' => request()->unitName,
                    ]);
                    if ($unit_hs) {
                        return response()->json([
                            'status' => 200,
                            'msg' => 'Unit added successfully'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'msg' => 'Failed to add unit!!!'
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'msg' => 'This unit name is already exist!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'msg' => 'Unit name cannot be empty!!'
            ]);
        }
    }


    public function getSAssigment(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $singleAssignment = Topic::findOrFail($id);
            $singleAssignment->first();
            if (!empty($singleAssignment)) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Assignment data',
                    'data' => $singleAssignment
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Something went wrong',
                    'data' => ''
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'msg' => 'Assignment id not given!'
            ]);
        }
    }

    public function getSQuestion(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $question = Question::findOrFail($id);
            $question->first();
            $quest = [];
            if (!empty($question)) {
                $quest = ([
                    'id' => $question->id,
                    'question' => $question->question,
                    'a' => $question->a,
                    'b' => $question->b,
                    'c' => $question->c,
                    'd' => $question->d,
                    'answer' => $question->answer,
                    'answer_exp' => $question->answer_exp,
                    'question_img' => !empty($question->question_img) && @unserialize($question->question_img) == true ? unserialize($question->question_img)[0] : '',
                    'questions_no' => $question->questions_no,
                    'testType' => $question->testType,
                ]);
            }
            if (!empty($question)) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Question data',
                    'data' => $quest
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Something went wrong',
                    'data' => ''
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'msg' => 'Assignment id not given!'
            ]);
        }
    }

    public function delAssignments(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $delAssignment = Topic::findOrFail($id);
            $delAssignment->delete();
            if ($delAssignment) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Assignment  has been deleted'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'msg' => 'Assignment id not given!'
            ]);
        }
    }
    public function delQuestion(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $question = Question::findOrFail($id);
            if ($question->question_img != null) {
                if (file_exists(public_path() . '/images/questions/' . $question->question_img)) {
                    unlink(public_path() . '/images/questions/' . $question->question_img);
                }
            }
            $deleted = $question->delete();
            if ($deleted) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Question has been deleted'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'msg' => 'Question id not given!'
            ]);
        }
    }

    public function deltest(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $delTest = Topic::findOrFail($id);
            $delTest->delete();
            if ($delTest) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Test has been deleted'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'msg' => 'Test id not given!'
            ]);
        }
    }


    public function createTest(Request $request)
    {

        $input = $request->all();
        $input['institute_assigned_class_subject_id'] = request()->iacsId;
        $validator = Validator::make($request->all(), [
            'unit' =>  'required',
            'title' => 'required|string',
            'per_q_mark' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {

            if (isset($request->quiz_price)) {
                $request->validate([
                    'amount' => 'required'
                ]);
            }

            if (isset($request->quiz_price)) {
                $input['amount'] = $request->amount;
            } else {
                $input['amount'] = null;
            }

            if (isset($request->show_ans)) {
                $input['show_ans'] = "1";
            } else {
                $input['show_ans'] = "0";
            }
            $input['type'] = "test";
            if (!empty(request()->last_id)) {

                $last_id = $request->last_id;
                $topic = Topic::findOrFail($last_id);
                $topic->title = $request->title;
                $topic->description = $request->description;
                $topic->per_q_mark = $request->per_q_mark;
                $topic->timer = $request->timer;
                $topic->unit = $request->unit;
                $topic->testType = $request->testType;

                if (isset($request->show_ans)) {
                    $topic->show_ans = 1;
                } else {
                    $topic->show_ans = 0;
                }

                if (isset($request->pricechk)) {
                    $topic->amount = $request->amount;
                } else {
                    $topic->amount = NULL;
                }
                $topic->save();
                return response()->json([
                    'status' => 200,
                    'msg' => 'Test has been Updated'
                ]);
            } else {
                $quiz = Topic::create($input);
                return response()->json([
                    'status' => 200,
                    'msg' => 'Test has been added'
                ]);
            }
        }
    }




    public function addtestUnit()
    {
        if (!empty(request()->unit)) {
            $uniqueUnits = Test_unit::where('unit', request()->unit)->first();
            if ($uniqueUnits == null) {
                $test_unit = \App\Models\Test_unit::where(['institute_assigned_class_subject_id' => request()->iacsId, 'unit' => request()->unit]);

                if ($test_unit->count()) {
                    return response()->json(['status' => true, 'data' => ['id' => $test_unit->first()->id, 'unit' => $test_unit->first()->unit]]);
                } else {
                    $unit_store = \App\Models\Test_unit::create([
                        'institute_assigned_class_subject_id' => request()->iacsId,
                        'unit' => request()->unit,
                    ]);
                    if ($unit_store) {
                        return response()->json([
                            'status' => 200
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400
                        ]);
                    }
                }
            } else {

                return response()->json([
                    'status' => 401,
                    'msg' => 'This unit name is already exist!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'msg' => 'Pless select Unit name!'
            ]);
        }
    }

    public function getTests()
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

    public function addAssignmentQuestion(Request $request)
    {

        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($request->i_assigned_class_subject_id);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id;
        if (empty($request->question)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Question is required !!!'
            ]);
        }
        if ($request->testType == 1) {
            $request->validate([
                'topic_id' => 'required',
                'question' => 'required',
                'a' => 'required',
                'b' => 'required',
                'c' => 'required',
                'd' => 'required',
                'answer' => 'required',
                'question_img' => 'nullable|mimes:image:jpg,jpeg,png'
            ]);
            $input = $request->all();
            $Qtype = '';
            if (!empty($request->topic_id)) {
                $topic = \App\Models\Topic::findOrFail($request->topic_id);
                if (!empty($topic)) {
                    $Qtype = $topic->type;
                };
            }
            if ($file = $request->file('question_img')) {
                /* $file = request()->file('question_img')->store('/assignment' . '/' . request()->topic_id, 's3');
                $file_name = $file;
                $input['question_img'] = $file_name; */
                $file_name = '';
                $folderName = 'institutes/' . $Qtype . '/' . auth()->user()->institute_id . '/' . $class_id . '/' . $request->i_assigned_class_subject_id . '/' . $request->topic_id;
                $folder = createFolder($folderName);
                $fileData = request()->file('question_img');
                $file = createUrlsession($fileData, $folder);
                if (!empty($file) && $file != 400) {
                    $file_name = serialize($file);
                }
                $input['question_img'] = $file_name;
            }
            if (!empty($request->id)) {
                $quest = Question::findOrFail($request->id);
                $quest->update($input);
                return response()->json([
                    'status' => 200,
                    'msg' => 'Question has been updated successfully'
                ]);
            } else {
                Question::create($input);
                return response()->json([
                    'status' => 200,
                    'msg' => 'Question has been added successfully'
                ]);
            }
        } else {
            $request->validate([
                'topic_id' => 'required',
                'question' => 'required',
                'answer_exp' => 'required',
                'question_img' => 'nullable|mimes:image:jpg,jpeg,png'
            ]);
            $Qtype = '';
            if (!empty($request->topic_id)) {
                $topic = \App\Models\Topic::findOrFail($request->topic_id);
                if (!empty($topic)) {
                    $Qtype = $topic->type;
                };
            }
            $input = $request->all();
            if ($file = $request->file('question_img')) {
                $file = request()->file('question_img')->store('institutes/' . $Qtype . '/' . auth()->user()->institute_id . '/' . $class_id . '/' . $request->i_assigned_class_subject_id . '/' . $request->topic_id, 's3');
                $file_name = $file;

                $input['question_img'] = $file_name;
            }
            Question::create($input);

            return response()->json([
                'status' => 200,
                'topics' => 'Question has been added successfully',
            ]);
        }
    }
    public function getQuestions(Request $request)
    {
        if ($request->iacs && $request->assignment_id) {
            $assignment =  $request->assignment_id;
            $iacs =  $request->iacs;
            $topic = Topic::where(['id' => $assignment, 'institute_assigned_class_subject_id' => $iacs])->firstOrFail();
            $questions = Question::where('topic_id', $topic->id)->get();
            $quest = [];
            if (!empty($questions)) {
                foreach ($questions as $qq) {
                    /*  if($topic->testType == 1){ */
                    $q_img = !empty($qq->question_img) && @unserialize($qq->question_img) == true ? unserialize($qq->question_img)[0] : '';
                    /*    }else{
                        $q_img = !empty($qq->question_img) ? 'https://aaradhanaclasses.s3.ap-south-1.amazonaws.com/'.$qq->question_img : '';
                    } */
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
            if (count($quest) > 0) {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Question list',
                    'questions' => $quest,
                    'topic' => $topic,
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'No question found !!!',
                    'questions' => [],
                    'topic' => [],
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Id missing in the given request',
                'questions' => '',
                'topic' => '',
            ]);
        }
    }

    public function publishAssigment()
    {

        $topic = \App\Models\Topic::find(request()->id);
        $topic->status = 'publish';
        $type  = request()->type;
        if (!empty(request()->lastId)) {
            \DB::table('topics')->where('id', request()->lastId)->update([
                'publish_date' => request()->publishingDate ? request()->publishingDate : '',
                'publishing_startTime' => request()->publishing_startTime ? request()->publishing_startTime : '',
                'status' => $topic->status
            ]);
            $id = request()->lastId;
        } else {
            $topic->publish_date = request()->publishingDate ? request()->publishingDate : '';
            $topic->save();
            $id = $topic->id;
        }
        if (!empty($id)) {
            $query = \App\Models\ClassNotification::create([
                'i_a_c_s_id' => request()->iacs,
                'type' => $type,
                'message' => 'New Assignment/Test',
                'assigment_id' => $id,
                'notify_date' => request()->publishingDate ? request()->publishingDate : '',
                'start_date' => request()->publishing_startTime ? request()->publishing_startTime : '',
            ]);
            return response()->json([
                'status' => 200,
                'query' => $query,
                'msg' => ucfirst($topic->type) . ' published successfully',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'msg' => 'Fail to update ' . ucfirst($topic->type),
            ]);
        }
    }


    public function loadDoubts(Request $request)
    {
        $grouped_doubts_messages = \App\Models\DoubtMessage::with('doubt')->whereHas('doubt', function ($query) {
            $query->where('institute_assigned_class_subject_id', request()->iacs);
        })->orderBy('created_at', 'DESC')->get()->unique('doubt_id');
        $alldata = [];
        if (!empty($grouped_doubts_messages)) {
            foreach ($grouped_doubts_messages as $singledoubt) {
                $total2 = 0;
                $items2 = [];
                $stid = $singledoubt->doubt->student_id;
                $assignmentnotifications =  DB::table('class_notifications')->where('i_a_c_s_id', request()->iacs)->where('isread', 3)->where('doubt_id', $singledoubt->doubt->id)->where('type', 'doubts')->get();
                $singledoubt->student = DB::table('users')->where('student_id', $stid)->first();
                $singledoubt->senderdetail = DB::table('students')->where('id', $stid)->select('avatar')->first();
                if (!empty($assignmentnotifications)) {
                    foreach ($assignmentnotifications as $noti) {
                        if ($noti->readUsers) {
                            $hiddenProducts = explode(',', $noti->readUsers);
                            if (in_array(request()->iacs, $hiddenProducts)) {
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
                $singledoubt->assignmentnotifications = $total2;
                $singledoubt->assignNotificationData = $items2;
                $alldata[] = $singledoubt;
            }
            return response()->json([
                'status' => 200,
                'data' => $alldata,
            ]);
        }
    }


    public function senddoubt()
    {
        $msg = '';
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id;
        if (request()->type == 'file' && request()->hasFile('message')) {
            $file_name = '';
            $folderName = 'institutes/doubts' . '/' . $iac->institute_id . '/' . $iac->id . '/' . request()->iacs . '/' . request()->doubt;
            $folder = createFolder($folderName);
            $fileData = request()->file('message');
            $file = createUrlsession($fileData, $folder);
            if (!empty($file) && $file != 400) {
                $file_name = serialize($file);
            }
            $msg = $file_name;
        }
        if (request()->type == 'text') {
            $msg = request()->message;
        }
        \App\Models\DoubtMessage::create([
            'sendable_type' => '\App\Models\Institute',
            'sendable_id' => auth()->user()->institute_id,
            'message' => $msg,
            'doubt_id' => request()->doubt,
            'type' => request()->type,
        ]);
        $student_id = request()->student_id ? request()->student_id : '';
        $query = \App\Models\ClassNotification::create([
            'i_a_c_s_id' => request()->iacs,
            'type' => 'doubts',
            'message' => 'New doubt',
            'institute_id' => auth()->user()->institute_id,
            'student_id' => $student_id,
            'doubt_id' => request()->doubt,
            'isread' => 2,
        ]);
        \App\Models\Doubt::where(['id' => request()->doubt, 'institute_assigned_class_subject_id' => request()->iacs])->firstOrFail();
        $dontread = true;
        if ($query) {
            return response()->json([
                'status' => 200,
                'msg' => 'Sent successfully',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Fail to send message',
            ]);
        }
    }

    public function loadsingleDoubt(Request $request)
    {
        $iacs_id =  $request->iacs;
        $id =  $request->doubt;
        $doubt = \App\Models\Doubt::where(['id' => $id, 'institute_assigned_class_subject_id' => $iacs_id])->firstOrFail();
        if (!empty($doubt)) {
            $doubt_messages = DB::table('doubt_messages')->where('doubt_id', $doubt->id)->orderBy('created_at', 'desc')->get();
            $itemmsg = [];


            $total2 = 0;
            $items2 = [];
            $segmentid = $doubt->id;
            $assignmentnotifications = DB::table('class_notifications')->where(
                'i_a_c_s_id',
                $iacs_id
            )->where('isread', 3)->where('doubt_id', $segmentid)->where('type', 'doubts')->get();
            if (!empty($assignmentnotifications)) {
                foreach ($assignmentnotifications as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array($iacs_id, $hiddenProducts)) {
                            $total2 = $total2 + 0;
                        } else {
                            $total2 = $total2 + 1;
                            $items2[] = $noti->id;
                        }
                    } else {
                        $total2 = $total2 + 1;
                        $items2[] = $noti->id;
                    }
                }
            }

            $assignNotificationData = $items2;
            if (!empty($assignNotificationData)) {
                foreach ($assignNotificationData as $noti) {

                    $old_data = DB::table('class_notifications')->where(
                        'i_a_c_s_id',
                        $iacs_id
                    )->where('isread', 3)->where('doubt_id', $segmentid)->where('type', 'doubts')->get();

                    if ($old_data) {
                        foreach ($old_data as $notes) {
                            $old_data_arr = !empty($notes->readUsers) ? explode(',', $notes->readUsers) : [];
                            if (!in_array($iacs_id, $old_data_arr)) {
                                $old_data_arr[] = $iacs_id;
                                $query = DB::table('class_notifications')->where(
                                    'i_a_c_s_id',
                                    $iacs_id
                                )->where('isread', 3)->where('type', 'doubts')->update([
                                    'readUsers' => implode(',', $old_data_arr),
                                    'isread' => 4,
                                ]);
                            }
                        }
                    }
                }
            }



            foreach ($doubt_messages as $item) {
                $msg = \App\Models\DoubtMessage::where('id', $item->id)->orderBy('created_at', 'desc')->first();
                $avatar =  !empty($msg->doubt->student->avatar) ? $msg->doubt->student->avatar : url('/assets/front/images/cost.png');
                if (!empty($msg->type) && $msg->type == 'file' && @unserialize($msg->message)) {
                    $m_SG = unserialize($msg->message)[0];
                } elseif (!empty($msg->type) && $msg->type == 'text') {
                    $m_SG = $msg->message;
                }
                if (!empty($msg)) {
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
        }
        return response()->json([
            'status' => 200,
            'messages' => $itemmsg,
            'doubt' => $doubt,
        ]);
    }

    public function createLectureUnit()
    {
        request()->validate([
            'name' => 'required',
        ]);

        $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'name' => request()->name]);

        if ($unit->count()) {

            return response()->json(['status' => true, 'msg' => 'Unit name exist !!!', 'data' => ['id' => $unit->first()->id, 'name' => $unit->first()->name]]);
        } else {

            $unit_1 = \App\Models\Unit::create([
                'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
                'name' => request()->name,
            ]);
            return response()->json(['status' => 200, 'msg' => 'Unit added successfully', 'data' => ['id' => $unit_1->id, 'name' => $unit_1->name]]);
        }
    }

    public function getStudentSubjects(Request $request)
    {
        $student_id = !empty($request->student) ? $request->student : '';
        $class_id = !empty($request->iacs) ? $request->iacs : '';
        $alloptions = [];
        $options = [];
        if ($class_id && $student_id) {
            if (auth()->user()->institute->institute_assigned_classes->count() > 0) {
                foreach (auth()->user()->institute->institute_assigned_classes as $institute_assigned_class) {
                    if ($institute_assigned_class->institute_assigned_class_subject->count() > 0) {
                        if ($institute_assigned_class->id == $class_id) {
                            foreach ($institute_assigned_class->institute_assigned_class_subject as $subject) {
                                $options['subject'] = $subject->subject;
                                $options['id'] = $subject->id;
                                $alloptions[] = $options;
                            }
                        }
                    }
                }
                return response()->json(['status' => 200, 'msg' => 'Student Class', 'options' => $alloptions]);
            }
        }
    }


    public function getstudentAttendance(Request $request)
    {

        $iacs_data = !empty($request->iacs) ? $request->iacs : '';
        $subject_id = !empty($request->subject_id) ? $request->subject_id : '';
        $student = !empty($request->student) ? $request->student : '';
        $iacs = DB::table('institute_assigned_class_subject')->where('id', $iacs_data)->first();
        if (!empty($iacs)) {
            $iac = \App\Models\InstituteAssignedClass::where('id', $iacs_data)->first();
            $date_ = date('Y-m-d', strtotime($iac->start_date));
            $lectures = \App\Models\Lecture::where(
                'institute_assigned_class_subject_id',
                $subject_id
            )->where('lecture_date', '>=', $date_ . ' 00:00:00')->get();
            if ($lectures->count() > 0) {
                $total_past_lectures = $lectures->count();
                $attended_lectures = \App\Models\StudentLecture::whereIn(
                    'lecture_id',
                    $lectures->pluck('id')->toArray()
                )->where(
                    'student_id',
                    $student
                )->where(
                    'attendence_in_percentage',
                    '>=',
                    '90'
                )->get();
                $absent_lectures = $lectures->whereNotIn(
                    'id',
                    $attended_lectures->load('lecture')->pluck('lecture.id')->toArray()
                );
                $total_attended_lectures = $attended_lectures->count();
                $total_absents_in_lectures = $total_past_lectures - $total_attended_lectures;
                $percentage = ($total_attended_lectures / $total_past_lectures) * 100;
            } else {
                $total_past_lectures = 0;
                $attended_lectures = 0;
                $total_attended_lectures = 0;
                $total_absents_in_lectures = 0;
                $percentage = 0;
            }
            $period = new DatePeriod(
                new DateTime($iac->start_date->format('Y-m-d')),
                new DateInterval('P1D'),
                new DateTime($iac->end_date->modify('+1 day')->format('Y-m-d'))
            );
            $lecture_dates = [];
            foreach ($period as $key => $value) {
                if (!empty($iacs->subjects_infos)) {
                    foreach ($iacs->subjects_infos->pluck('day')->toArray() as $key1 => $day) {
                        if ($day === strtolower($value->format('l'))) {
                            $lecture_dates[] = $value->format('m/d/Y');
                        }
                    }
                }
            }
        } else {
            $total_past_lectures = 0;
            $attended_lectures = 0;
            $total_attended_lectures = 0;
            $total_absents_in_lectures = 0;
            $percentage = 0;
        }
        $attended_lectures_dates = '';
        if (!empty($attended_lectures)) {
            foreach ($attended_lectures->load('lecture')->pluck('lecture.lecture_date') as $attended_lecture_date) {
                $attended_lectures_dates .= "'" . date('m/d/Y', strtotime($attended_lecture_date)) . "',";
            }
            $attended_lectures_dates = trim($attended_lectures_dates, ',');
        } else {
            $attended_lectures_dates = '';
        }

        $absent_lectures_dates = '';
        if (!empty($absent_lectures)) {
            foreach ($absent_lectures->pluck('lecture_date') as $absent_lecture_date) {
                if (date('m/d/Y', strtotime($absent_lecture_date)) != date('m/d/Y')) {
                    $absent_lectures_dates .= "'" . date('m/d/Y', strtotime($absent_lecture_date)) . "',";
                }
            }
            $absent_lectures_dates = trim($absent_lectures_dates, ',');
        } else {
            $absent_lectures_dates = '';
        }
        $not_available = [];
        if (!empty($lecture_dates)) {
            foreach ($lecture_dates as $date) {
                if (!in_array($date, array_merge(
                    explode(',', str_replace("'", '', $attended_lectures_dates)),
                    explode(',', str_replace("'", '', $absent_lectures_dates))
                )) && $date != date('m/d/Y'))
                    $not_available[] = $date;
            }
        }

        //$returnHTML = view('institute.calendar', compact('subject_id', 'student', 'iacs_data'))->render();
        return response()->json(array(
            'status' => 200,
            'attended_lectures_dates' => $attended_lectures_dates,
            'absent_lectures_dates' => $absent_lectures_dates,
            'not_available' => $not_available,
            'total_past_lectures' => $total_past_lectures,
            'attended_lectures' => $attended_lectures,
            'total_attended_lectures' => $total_attended_lectures,
            'total_absents_in_lectures' => $total_absents_in_lectures,
            'percentage' => $percentage,
        ));
    }


    public function generate_receipt(Request $request)
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

    public function profile()
    {
        if (!empty(auth()->user()->institute_id)) {
            $data = \App\Models\Institute::find(auth()->user()->institute_id);
            $data->video = @unserialize($data->video) ? unserialize($data->video)[0] : '';
            return response()->json([
                'status' => 200,
                'institute' => $data,
            ]);
        } elseif (!empty(auth()->user()->student_id)) {
            $data = \App\Models\Student::find(auth()->user()->student_id);
            $data = ([
                'name' => $data->name,
                'phone' => $data->phone,
                'board' => $data->board,
                'date_of_birth' => $data->date_of_birth,
                'gender' => $data->gender,
                'state' => $data->state,
                'city' => $data->city,
                'grade' => $data->grade,
                'avatar' => $data->avatar,
            ]);
            return response()->json([
                'status' => 200,
                'student' => $data,
            ]);
        }
    }

    public function updateDemoVideo(Request $request)
    {
        $description = $request->description ?? '';
        $institute = \App\Models\Institute::find(auth()->user()->institute_id);
        if (request()->hasFile('video')) {
            $folderName = 'institutes/demoInsvideo/' . auth()->user()->institute_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('video');
            $file = createUrlsession($fileData, $folder);
            $file_name = '';
            if (!empty($file) && $file != 400) {
                $file_name = serialize($file);
            }
            $data['video'] = $file_name ?? '';
        }
        $data['videoApproval'] = 0;
        $data['description'] = $description;
        $res = \App\Models\Institute::where('id', auth()->user()->institute_id)->update($data);
        if ($res) {
            return response()->json([
                'status' => 200,
                'msg' => 'Video updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'msg' => 'Fail to add video !!!',
            ]);
        }
    }

    public function saveSyllabus()
    {
        request()->validate([
            "syllabus" => "required|mimes:pdf|max:10000",
        ]);
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs_id);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id;
        if (request()->hasFile('syllabus')) {
            $syllabus_val = '';
            $folderName = '/institutes/syllabus' . '/' . auth()->user()->institute_id . '/' . $class_id . '/' . request()->iacs_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('syllabus');
            $file = createUrlsession($fileData, $folder);
            if (!empty($file) && $file != 400) {
                $syllabus_val = serialize($file);
                $res = \App\Models\InstituteAssignedClassSubject::where('id', request()->iacs_id)->update(['syllabus' => $syllabus_val]);
                return response()->json([
                    'status' => 200,
                    'msg' => 'Syllabus updated successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'msg' => 'File already exist',
                ]);
            }
        }
        return response()->json([
            'status' => 400,
            'msg' => 'Please select only pdf file !!!',
        ]);
    }

    public function updateVideo()
    {


        $i_assigned_class = request()->i_assigned_class;
        $institute_class_subject = request()->i_assigned_class_subject_id;
        if (request()->hasFile('syllabus')) {
            $folderName = 'institutes/subjectvideo'. '/'.auth()->user()->institute_id . '/' . $i_assigned_class . '/' .$institute_class_subject; 
            $folder = createFolder($folderName);
            $fileData = request()->file('syllabus');
            $file = createUrlsession($fileData, $folder);
            $file_name = '';
            if (!empty($file) && $file != 400) {
                $file_name = serialize($file);
            } 
            $s = \App\Models\InstituteAssignedClassSubject::where('id', $institute_class_subject)->update([
                'video' => $file_name, 
                'videoApproval' => 0,
            ]);
            return response()->json([
                'status' => 200,
                'msg' => 'Video updated successfully',
            ]);
        }

        return response()->json([
            'status' => 400,
            'msg' => 'Please select proper video format file !!!',
        ]);
    }
}