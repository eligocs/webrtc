<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use App\Models\SubjectsInfo;
use App\Models\Institute;
use App\Models\ClassNotification;
use Illuminate\Http\Request;

class InstituteController extends Controller
{


    public function index()
    {
        return view('institute.home');
    }


    public function uploadClassVideo(Request $request)
    {  
        request()->validate([
            'institute_assigned_class_id' => 'required', 
        ]); 
        $institute_assigned_class = \App\Models\InstituteAssignedClass::findOrFail(request()->institute_assigned_class_id);
        if (request()->hasFile('class_video')) { 
            $folderName = 'institutes/classvideo/' . request()->institute_assigned_class_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('class_video');
            $file = createUrlsession($fileData, $folder);
            $file_name = '';
            if (!empty($file) && $file != 400) {
            $file_name = serialize($file);
            }
            $institute_assigned_class->video = $file_name;
            $institute_assigned_class->videoApproval = '0'; 
        }
        if(!empty($request->description)){
            $institute_assigned_class->description = $request->description;
        }
        $institute_assigned_class->save();
    
  
      return redirect()->back()->with('message', 'Class Content has been uploaded and sent for approval successfully');
    }

    public function detail($i_a_c_s_id, $subject_id)
    {

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
        return view('institute.subject.detail', compact('getSubjectsInfo', 'subject', 'doubtsnotify'));
    }


    public function getdoubts(Request $request)
    {
        $total2 = 0;
        $items2 = [];
        $id = request()->iacs_id ? request()->iacs_id : '';
        if ($id) {
            $doubt =  ClassNotification::where('i_a_c_s_id', $id)->where('type', 'doubts')->where('isread', 3)->get();
            if (!empty($doubt)) {
                foreach ($doubt as $noti) {
                    if ($noti->readUsers) {
                        $hiddenProducts = explode(',', $noti->readUsers);
                        if (in_array($id, $hiddenProducts)) {
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
            $doubt = $total2;
            return response()->json(['msg' => 'Notifications list', 'count' => $doubt]);
        }
    }

    public function create_notification(Request $request)
    { 
        request()->validate([
            'message' => 'required',
        ]); 
        $query = \App\Models\ClassNotification::create([
            'i_a_c_s_id' => $request->i_a_c_s,
            'type' => $request->type,
            'message' => $request->message,
        ]);
        return redirect()->back()->with('message', 'Notification sent');  
    }

    public function subjectvideo(Request $request){
        $file = '';   
        if (request()->hasFile('video')) {   
            $syllabus_val = '';
            $folderName = '/institutes/subjectvideo' . '/' . auth()->user()->institute_id . '/' . request()->institute_assigned_class . '/' . request()->iacs_id;
            dd($folderName);
            $folder = createFolder($folderName);
            $fileData = request()->file('video');
            $file = createUrlsession($fileData, $folder);
        } 
        if (!empty($file) && $file != 400) {
            $syllabus_val = serialize($file);
            $s = \App\Models\InstituteAssignedClassSubject::where('id', request()->iacs_id)->update([
                'video' => $syllabus_val, 
                'videoApproval' => 0,
            ]); 
            return redirect()->back()->with('message', 'Content sent to admin for approval.');
        }  else {
            return redirect()->back()->with('message', 'File already exist.');
        } 
        return redirect()->back()->with('message', 'Something went wrong.');
         
    }
    
    public function create_notify(Request $request)
    { 
        if (request()->hasFile('message') && $request->type == 'pdf') { 
            $syllabus_val = '';
            $folderName = '/institutes/notification' . '/' . auth()->user()->institute_id . '/' . request()->class . '/' . request()->i_a_c_s; 
            $folder = createFolder($folderName);
            $fileData = request()->file('message');
            $file = createUrlsession($fileData, $folder); 
            if (!empty($file) && $file != 400) {
                $syllabus_val = serialize($file); 
                $query = \App\Models\ClassNotification::create([
                    'i_a_c_s_id' => $request->i_a_c_s,
                    'type' => $request->type,
                    'message' => $syllabus_val,
                ]);
                return response()->json([
                    'status'=> 200,
                    'message'=> 'Notification created successfully',
                ]); 
            } else {
                return response()->json([
                    'status'=> 200,
                    'message'=> 'File already exist.',
                ]); 
            }
        }else{
            $query = \App\Models\ClassNotification::create([
                'i_a_c_s_id' => $request->i_a_c_s,
                'type' => $request->type,
                'message' => $request->message,
            ]);
            return redirect()->back()->with('message', 'Notification sent');
        }
        return response()->json([
            'status'=> 200,
            'message'=> 'Notification created successfully',
        ]);
    }


    public function enrollments($id, $class_id)
    {
        // dd($id);
        if ($id) {
            $instituteClass = \DB::table('institute_assigned_class')->where('institute_id', $id)->where('id', $class_id)->get();
            if ($instituteClass) {
                $students = [];
                foreach ($instituteClass as $ins) {
                    $students[] = \DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $ins->id)->orderBy('id', 'desc')->get();
                }
            }
            return view('institute.enrollments', compact('students'));
        }
    }

    public function generate_receipt($class_id, $student_id)
    {

        if ($class_id && $student_id) {
            $class =
                $class = \App\Models\InstituteAssignedClass::find($class_id);
            // $class =  DB::
            // dd($class);
            if (empty($class->students->where('id', $student_id)->first())) {
                abort(404);
            }
            $student = $class->students->where('id', $student_id)->first();
            $enrolled_class = \App\Models\InstituteAssignedClassStudent::where('institute_assigned_class_id', $class->id)->where('student_id', $student->id)->first();
            // dd($enrolled_class);
            // return view('student.receipt', ['class' => $class, 'student' => $student, 'enrolled_class' => $enrolled_class]);
            $pdf = app('dompdf.wrapper')->loadView('student.receipt', ['class' => $class, 'student' => $student, 'enrolled_class' => $enrolled_class]);
            return $pdf->stream('invoice.pdf');
        }
    }


    public function getClass(Request $request)
    {
        $student_id = !empty($request->student_id) ? $request->student_id : '';
        $class_id = !empty($request->iacs) ? $request->iacs : '';
        $options = '<option value="">Select</option>';
        if ($class_id && $student_id) {
            if (auth()->user()->institute->institute_assigned_classes->count() > 0) {
                foreach (auth()->user()->institute->institute_assigned_classes as $institute_assigned_class) {
                    if ($institute_assigned_class->institute_assigned_class_subject->count() > 0) {
                        if ($institute_assigned_class->id == $class_id) {
                            foreach ($institute_assigned_class->institute_assigned_class_subject as $subject) {

                                $iacs = \App\Models\instituteAssignedClassSubject::where('id', $class_id)->first();
                                if (!empty($iacs)) {
                                    $iac = \App\Models\InstituteAssignedClass::where('id', $class_id)->first();
                                    $date_ = !empty($iac->start_date) ? date('Y-m-d', strtotime($iac->start_date)) : '';
                                    $lectures = \App\Models\Lecture::where(
                                        'institute_assigned_class_subject_id',
                                        $subject->id
                                    )->where('lecture_date', '>=', $date_ . ' 00:00:00')->get();
                                    $showPercent = false;
                                    if ($lectures->count() > 0) {
                                        $showPercent = true;
                                        $total_past_lectures = $lectures->count();
                                        $attended_lectures = \App\Models\StudentLecture::whereIn(
                                            'lecture_id',
                                            $lectures->pluck('id')->toArray()
                                        )->where(
                                            'student_id',
                                            $student_id
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
                                    } elseif ($lectures->count() == 0) {
                                        $showPercent = false;
                                        $total_past_lectures = 0;
                                        $attended_lectures = 0;
                                        $total_attended_lectures = 0;
                                        $total_absents_in_lectures = 0;
                                        $percentage = 0;
                                    } else {
                                        $total_past_lectures = 0;
                                        $attended_lectures = 0;
                                        $total_attended_lectures = 0;
                                        $total_absents_in_lectures = 0;
                                        $percentage = 0;
                                    }
                                }

                                if ($showPercent == false) {
                                    $options .=  "<option value='" . $subject->id . "'>" . $subject->subject->name . "</option>";
                                } else {
                                    $newpercent = !empty($percentage) ? round($percentage, 2) : 0;
                                    $options .=  "<option value='" . $subject->id . "'>" . $subject->subject->name . ' ' . $newpercent . ' %' . "</option>";
                                }
                            }
                        }
                    }
                }
                return response()->json(['status' => 1, 'msg' => 'Student Class', 'options' => $options]);
            }
        }
        /* $class = \App\Models\InstituteAssignedClass::find($class_id);
        if (empty($class->students->where('id', $student_id)->first())) {
          abort(404);
        }
        $student = $class->students->where('id', $student_id)->first();
        $enrolled_class = \App\Models\InstituteAssignedClassStudent::where('institute_assigned_class_id', $class->id)->where('student_id', $student->id)->first(); */

        /*  $enrolled_class = \App\Models\InstituteAssignedClassStudent::where('student_id', $student_id)->get();
      if(!empty($enrolled_class)){
        $options = '<option value="">--Select--</option>';
        foreach($enrolled_class as $class){
          $classn = \App\Models\InstituteAssignedClass::find($class['institute_assigned_class_id']);
          var_dump($classn);die;
          $options .= '<option value="'.$classn->id.'">'.$class->name.'</option>';
        }
        return response()->json(['status' => 1 ,'msg' => 'Student assigned Class','options'=> $options]);
      }else{
        $options .= '<option value="">No Class Found</option>';
        return response()->json(['status' => 0, 'msg' => 'No class found !!!','options'=> $options]);
      } */
    }


    public function getattendance(Request $request)
    {
        $iacs = !empty($request->iacs) ? $request->iacs : '';
        $enrolled_subject = \App\Models\InstituteAssignedClassSubject::where('institute_assigned_class_id', $iacs)->get();
        if (!empty($enrolled_subject)) {
            $arr = [];
            $arrPart = [];
            foreach ($enrolled_subject as $subject) {
                $arr['subject'] = $subject['id'];
                $arr['subject_name'] = $subject['subject_id'];
                $arrPart[] = $arr;
            }
            $options = '<option value="">--Select--</option>';
            foreach ($arrPart as $single) {
                $subject_d = \App\Models\Subject::where('id', $single['subject_name'])->first();
                $options .= '<option value="' . $single['subject'] . '">' . $subject_d->name . '</option>';
            }
            return response()->json(['status' => 1, 'msg' => 'Student assigned Class', 'options' => $options]);
        }
    }

    public function getSubAtt(Request $request)
    {

        $iacs_data = !empty($request->iacs) ? $request->iacs : '';
        $subject_id = !empty($request->subject_id) ? $request->subject_id : '';
        $student = !empty($request->student) ? $request->student : '';

        $returnHTML = view('institute.calendar', compact('subject_id', 'student', 'iacs_data'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function addSyllabus()
    {
        request()->validate([
            "syllabus" => "required|mimes:pdf|max:10000",
        ]);
        if (request()->hasFile('syllabus')) {
            /*  $file = request()->file('syllabus');
        $syllabus_name = uniqid() . '-' . $file->getClientOriginalName();
        $syllabus_path = $file->move(storage_path() . '/app/public/subjects/syllabus', $syllabus_name);
        $syllabus_directory = '/storage/subjects/syllabus/' . $syllabus_name; */
            /* $file = request()->file('syllabus');
            $syllabus_name = uniqid() . '-' . $file->getClientOriginalName();
            $_path = $file->storeAs('syllabus/lecture/' . request()->iacs_id, $syllabus_name, 's3');
            $syllabus_directory = $_path;
            $syllabus_val = 'syllabus/lecture/' . request()->iacs_id . '/' . $syllabus_name; */
            $syllabus_val = '';
            $folderName = '/institutes/syllabus' . '/' . auth()->user()->institute_id . '/' . request()->institute_assigned_class . '/' . request()->iacs_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('syllabus');
            $file = createUrlsession($fileData, $folder);
            if (!empty($file) && $file != 400) {
                $syllabus_val = serialize($file);
                \App\Models\InstituteAssignedClassSubject::where('id', request()->iacs_id)->update(['syllabus' => $syllabus_val]);
                return redirect()->back()->with('message', 'Syllabus updated successfully.');
            } else {
                return redirect()->back()->with('message', 'File already exist.');
            }
        }
        return redirect()->back()->with(['message' => 'Please select only pdf file !!!']);
    }

    public function profile()
    {
        $institute = \App\Models\Institute::find(auth()->user()->institute_id);
        return view('institute.profile', compact('institute'));
    }
    public function updateDemoVideo(Request $request)
    {
        $description = $request->description ?? '';
        $institute = \App\Models\Institute::find(auth()->user()->institute_id);
        if (request()->hasFile('demo_video')) {
            $folderName = 'institutes/demoInsvideo/' . auth()->user()->institute_id;
            $folder = createFolder($folderName);
            $fileData = request()->file('demo_video');
            $file = createUrlsession($fileData, $folder);
            $file_name = '';
            if (!empty($file) && $file != 400) {
                $file_name = serialize($file);
            }
            $data['video'] = $file_name ?? '';
        }
        $data['description'] = $description;
        $data['videoApproval'] = 0;
        $res = \App\Models\Institute::where('id', auth()->user()->institute_id)->update($data);
        if ($res) {
            return redirect()->back()->with(['message' => 'Demo Info Added Successfully']);
        } else {
            return redirect()->back()->with(['errors' => 'Fail to add demo video !!!']);
        }
    }
    // public function getimag(Request $request){
    //     dd($_FILES['croppedImage']);
    // }
}