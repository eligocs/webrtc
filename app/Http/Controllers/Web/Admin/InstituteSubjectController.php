<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstituteAssignedClassSubjectTeacher;
use Illuminate\Http\Request;
use App\Models\SubjectsInfo;
use Illuminate\Support\Facades\DB;
use Vimeo\Laravel\Facades\Vimeo;

class InstituteSubjectController extends Controller
{
  public function detail($institute_assigned_class_id, $subject_id)
  {

    $getSubjectsInfo = SubjectsInfo::where('institute_assigned_class_subject_id', $institute_assigned_class_id)
      ->get();
    $subject = \App\Models\Subject::findOrFail($subject_id);
    return view('admin.institute-subject.detail', compact('getSubjectsInfo', 'subject'));
  }

    
  public function delete(Request $request){  
    $id = $request->id; 
    $res = \App\Models\Lecture::where('id',$id)->delete();
    if($res){
      return response()->json([
        'status' => true,
        'data' => 'deleted'
        ]);
    }else{
      return response()->json([
        'status' => false,
        'data' => ''
        ]);
    }

  }
  
  public function addvideo(Request $request){  
    $id = $request->id;
    $video_url = '';
    request()->validate([  
      'lecture_video'  => 'nullable|mimes:mp4,mov,ogg,mpeg,avi' 
    ]); 
    if (request()->hasFile('lecture_video')) { 
      $folderName = '/institutes/lectures/videos'.'/'.request()->i_assigned_class_subject_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('lecture_video');
      $file = createUrlsession($fileData, $folder);  
      /* $file = request()->file('lecture_video');
      $video_name = uniqid() . '-' . $file->getClientOriginalName();  */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName()))); 
    /*   $video_path = $file->storeAs('public/lectures/videos', $video_name);
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/lectures/videos/' . $video_name)); 
      $video_directory = str_replace('/videos/', '', $vimeo_response); */
    
    if(!empty($file) && $file != 400){ 
      $video_directory = serialize($file); 
      \App\Models\Lecture::where('id',$id)->update([ 
        'lecture_video' =>  $video_directory ?? '', 
      ]); 
        return response()->json([
          'status' => true,
          'data' => $video_directory
          ]);
      }else{
        return response()->json([
          'status' => false,
          'data' => ''
          ]);
      }
    }else{
      return response()->json([
        'status' => false,
        'data' => ''
        ]); 
    } 
  }

  
  public function getLecture(Request $request){
    $id = $request->id ? $request->id:''; 
    if($id){
      $lecture = \App\Models\Lecture::where('id',$id)->first();
      $video = !empty($lecture->lecture_video) && @unserialize($lecture->lecture_video) == true ? unserialize($lecture->lecture_video):'';
      $notes = !empty($lecture->notes) && @unserialize($lecture->notes) == true ? unserialize($lecture->notes):'';
      if($lecture){
        return response()->json([
          'status' => true,
          'data' => $lecture,
          'video' => !empty($video) ? $video[0] :'',
          'notes' => !empty($notes) ? $notes[0] :'',
          'lecture_date'=>$lecture->lecture_date ? date('Y-m-d',strtotime($lecture->lecture_date)) : ''
          ]);
      }else{
        return response()->json([
          'status' => false,
          'data' => '',
          'add'=>''
          ]);
      }
    }

  }

  public function assignTeacher()
  {
    request()->validate([
      'institute_assigned_class_subject_id' => 'required',
      'teacher_id' => 'required'
    ]);

    // InstituteAssignedClassSubjectTeacher::where('institute_assigned_class_subject_id', '!=', request()->institute_assigned_class_subject_id)->delete();

    $institute_assigned_class_subject_teacher = InstituteAssignedClassSubjectTeacher::firstOrNew(['institute_assigned_class_subject_id' => request()->institute_assigned_class_subject_id]);

    $institute_assigned_class_subject_teacher->teacher_id = request()->teacher_id;

    $institute_assigned_class_subject_teacher->save();

    return redirect()->back()->with(['status' => 'success', 'message' => 'Teacher assigned successfully.']);
  }

  public function lectures()
  {
    $lecturesGroupedByUnits = \App\Models\Unit::with('lectures')->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
    return view('admin.institute-subject.lectures', compact('lecturesGroupedByUnits'));
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

 
  public function store(Request $request)
  {   
    request()->validate([
      'unit_name' => 'required',
      "notes" => "nullable|mimes:pdf|max:10000",
      'lecture_video'  => 'nullable|mimes:mp4,mov,ogg,mpeg,avi' 
      /* 'lecture_number' => 'required',
      'lecture_name' => 'required',  */
    ]); 
    $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => request()->unit_name])->first();
    //continue
    $available_days = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->get()->pluck('day');
    
    $latest_lecture = \App\Models\Lecture::orderBy('lecture_date', 'desc')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->first();
    
    $latest_lecture_date = $latest_lecture ? date('Y-m-d', strtotime($latest_lecture->lecture_date)) : date('Y-m-d');
    $next_lecture_date = $this->getNextLectureDate($available_days, $latest_lecture_date);
    
    // manual pick lecture date
    $next_lecture_date = request()->lecture_date . ' 00:00:00';
    $video_url = '';
    
   
    if (request()->hasFile('lecture_video')) {
      
      $file = request()->file('lecture_video');
      /* $video_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $video_path = $file->move(storage_path() . '/app/public/lectures/videos', $video_name);
      // $video_path = $file->storeAs('/lectures/videos', $video_name, 's3'); 
      /* $video_path = $file->storeAs('public/lectures/videos', $video_name);
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/lectures/videos/' . $video_name)); */
      // $exploded_path = explode('/', $video_path);
      // $lecture_video = url('/storage/lectures/videos').'/'.$exploded_path[count($exploded_path)-1];
      // $video_directory = '/lectures/videos/' . $video_name;
      // $video_directory = $video_path; 
      /* $video_directory = str_replace('/videos/', '', $vimeo_response); */
      $folderName = '/institutes/lectures/videos'.'/'.request()->i_assigned_class_subject_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('lecture_video');
      $file = createUrlsession($fileData, $folder);  
      if(!empty($file) && $file != 400){ 
        $video_name = serialize($file);
      }else{
        $video_name = '';
      }
      //$video_name = $video_directory;
    }else{
      $video_directory = '';
      $video_name = '';
    }
    if (request()->hasFile('notes')) {
      
      /* $file = request()->file('notes');
      $notes_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$notes_name =  strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $notes_path = $file->move(storage_path() . '/app/public/lectures/notes', $notes_name);
      /* $notes_path = $file->storeAs('/lectures/notes', $notes_name, 's3');  */
      // $notes_directory = '/storage/lectures/notes/' . $notes_name;
     /*  $notes_directory = $notes_path;
      $notes_val =  'lectures/notes/'.$notes_name;  */
      $folderName = '/institutes/lectures/notes'.'/'.request()->i_assigned_class_subject_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('notes');
      $file1 = createUrlsession($fileData, $folder);  
      if(!empty($file1) && $file1 != 400){ 
        $notes_val = serialize($file1);
      }else{
        $notes_val = '';
      }
    }else{
      $notes_val = ''; 
    } 
    // dd('hllo');

    if($request->last_id){
      $last_id = $request->last_id;
      $oldData = \DB::table('lectures')->where('id',$last_id)->first();  
      $query = \DB::table('lectures')->where('id',$last_id)->update([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'unit_id' => $unit->id,
        'lecture_number' => request()->lecture_number,
        'lecture_name' => request()->lecture_name,
        'lecture_video' =>  !empty($video_name) ? $video_name : $oldData->lecture_video,
        'notes' => !empty($notes_val) ? $notes_val : $oldData->notes,
        'lecture_date' => $next_lecture_date,
      ]);
    }else{
      $query = \App\Models\Lecture::create([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'unit_id' => $unit->id,
        'lecture_number' => request()->lecture_number,
        'lecture_name' => request()->lecture_name,
        'lecture_video' =>  $video_name ? $video_name : '',
        'notes' =>  $notes_val ? $notes_val : '',
        'lecture_date' => $next_lecture_date,
      ]);
    }
 

      if($unit){
        $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => request()->unit_name])->update([
          'updated_at'=>date('y-m-d h:i:s'),
        ]);
        echo "1";
      }else{
        echo "2"; 
      } 
      die; 

    //return redirect()->back()->with('message', 'Lecture created successfully');
  }

  public function getSubjectsByClassId()
  {

    request()->validate([
      'id' => 'required',
    ]);

    $subjects = \App\Models\Subject::whereHas('institute_class', function ($query) {
      $query->where('class_id', request()->id);
    })->get();

    return response()->json(['status' => true, 'data' => $subjects]);
  }

  public function getUnits()
  {
    request()->validate([
      'class_id' => 'required',
      'subject_id' => 'required',
    ]);

    $units = \App\Models\Unit::where(['class_id' => request()->class_id, 'subject_id' => request()->subject_id])->get();

    return response()->json(['status' => true, 'data' => $units]);
  }

  public function addUnit()
  {

    request()->validate([
      'name' => 'required',
    ]);

    $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'name' => request()->name]); 
    if ($unit->count()) {

      return response()->json(['status' => true, 'data' => ['id' => $unit->first()->id, 'name' => $unit->first()->name]]);
    } else {

      $unit_1 = \App\Models\Unit::create([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'name' => request()->name,
      ]);
      return response()->json(['status' => true, 'data' => ['id' => $unit_1->id, 'name' => $unit_1->name]]);
    }
  }

  
  public function lectureaddUnit()
  {

    request()->validate([
      'name' => 'required',
    ]);

    $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'name' => request()->name]);

    if ($unit->count()) {

      return response()->json(['status' => true, 'data' => ['id' => $unit->first()->id, 'name' => $unit->first()->name]]);
    } else {

      $unit_1 = \App\Models\Unit::create([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'name' => request()->name,
      ]);
      return response()->json(['status' => true, 'data' => ['id' => $unit_1->id, 'name' => $unit_1->name]]);
    }
  }

  

  
  public function store_extra_classes(Request $request)
  {
    request()->validate([
      'unit_name' => 'required',
      "notes" => "nullable|mimes:pdf|max:10000",
      'extra_class_video'  => 'nullable|mimes:mp4,mov,ogg,mpeg,avi'
      /* 'extra_class_number' => 'required',
      'extra_class_name' => 'required',  */
    ]); 

    $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => request()->unit_name])->first();
    //continue
    $available_days = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->get()->pluck('day');

    $latest_extra_class = \App\Models\ExtraClass::orderBy('extra_class_date', 'desc')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->first();

    $latest_extra_class_date = $latest_extra_class ? date('Y-m-d', strtotime($latest_extra_class->extra_class_date)) : date('Y-m-d');
    $next_extra_class_date = $this->getNextExtraClassDate($available_days, $latest_extra_class_date);
    $video_url = '';
    if (request()->hasFile('extra_class_video')) {

  /*     $file = request()->file('extra_class_video');
      $video_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $video_path = $file->move(storage_path() . '/app/public/extra_classes/videos', $video_name);
      // $video_path = $file->storeAs('/extra_classes/videos', $video_name, 's3');
      /* $video_path = $file->storeAs('public/extra_classes/videos', $video_name); */
      // $vimeo_response = Vimeo::upload(config('filesystems.disks.s3.url') . $video_path);
      // dd($video_path);
    /*   $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/extra_classes/videos/' . $video_name)); */
      // dd($vimeo_response);
      // $exploded_path = explode('/', $video_path);
      // $extra_class_video = url('/storage/extra_classes/videos').'/'.$exploded_path[count($exploded_path)-1];
      // $video_directory = '/storage/extra_classes/videos/' . $video_name;
      // $video_directory = $video_path;
    /*   $video_directory = str_replace('/videos/', '', $vimeo_response); */
    $folderName = '/institutes/extraclass/videos'.'/'.request()->i_assigned_class_subject_id;
    $folder = createFolder($folderName);
    $fileData = request()->file('extra_class_video');
    $file = createUrlsession($fileData, $folder);  
    if(!empty($file) && $file != 400){ 
      $video_name = serialize($file);
    }
    }else{
      $video_directory = '';
      $video_name = '';
    }
    if (request()->hasFile('notes')) {

      /* $file = request()->file('notes');
      $notes_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$notes_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $notes_path = $file->move(storage_path() . '/app/public/extra_classes/notes', $notes_name);
     /*  $notes_path = $file->storeAs('/extra_classes/notes', $notes_name, 's3'); */
      // $notes_directory = '/storage/extra_classes/notes/' . $notes_name;
     /*  $notes_directory = $notes_path;
      $notes_val =  'extra_classes/notes/'.$notes_name;  */
      $folderName = '/institutes/extraclass/notes'.'/'.request()->i_assigned_class_subject_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('notes');
      $file1 = createUrlsession($fileData, $folder);  
      if(!empty($file1) && $file1 != 400){ 
        $notes_val = serialize($file1);
      }
    }else{
      $notes_directory = '';
      $notes_val = ''; 
    }
    // dd('hllo');
    if($request->last_id){
      $last_id = $request->last_id; 
      $oldData = \DB::table('extra_classes')->where('id',$last_id)->first();  
      $query = \DB::table('extra_classes')->where('id',$last_id)->update([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'unit_id' => $unit->id,
        'extra_class_number' => request()->extra_class_number,
        'extra_class_name' => request()->extra_class_name,
        'extra_class_video' =>   !empty($video_name) ? $video_name : $oldData->extra_class_video ,
        'notes' =>   !empty($notes_val) ? $notes_val :  $oldData->notes,
        'extra_class_date' => $request->lecture_date ? $request->lecture_date : $oldData->extra_class_date, 
      ]);
    }else{
      \App\Models\ExtraClass::create([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'unit_id' => $unit->id,
        'extra_class_number' => request()->extra_class_number,
        'extra_class_name' => request()->extra_class_name,
        'extra_class_video' =>  !empty($video_name) ? $video_name :'',
        'notes' =>  !empty($notes_val) ? $notes_val : '',  
        'extra_class_date'=> $next_extra_class_date
      ]);
    }
    $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => request()->unit_name])->update([
      'updated_at'=>date('y-m-d h:i:s'),
    ]);

    return redirect()->back()->with('message', 'ExtraClass created successfully');
  }

  
  public function delete_extra_class(Request $request){  
    $id = $request->id; 
    $res = \App\Models\ExtraClass::where('id',$id)->delete();
    if($res){
      return response()->json([
        'status' => true,
        'data' => 'deleted'
        ]);
    }else{
      return response()->json([
        'status' => false,
        'data' => ''
        ]);
    }

  }

  
  public function updvideo(Request $request){  
    $id = $request->id;
    $video_url = '';
     request()->validate([  
      'extra_class_video'  => 'nullable|mimes:mp4,mov,ogg,mpeg,avi' 
    ]); 
    if (request()->hasFile('extra_class_video')) { 
      /* $file = request()->file('extra_class_video');
      $video_name = uniqid() . '-' . $file->getClientOriginalName();  */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName()))); 
      /* $video_path = $file->storeAs('public/extra_classes/videos', $video_name); 
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/extra_classes/videos/' . $video_name)); 
      $video_directory = str_replace('/videos/', '', $vimeo_response); */
      $folderName = '/institutes/extraclass/videos'.'/'.request()->i_assigned_class_subject_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('extra_class_video');
      $file = createUrlsession($fileData, $folder);  
      if(!empty($file) && $file != 400){ 
        $video_name = serialize($file);  
        \App\Models\ExtraClass::where('id',$id)->update([ 
          'extra_class_video' =>  $video_name ?? '', 
        ]); 
      return response()->json([
        'status' => true,
        'data' => $video_name
          ]);
      }else{
        return response()->json([
          'status' => false,
          'data' => ''
          ]);
      } 
    }else{
      return response()->json([
        'status' => false,
        'data' => ''
        ]); 
    } 
  }

  public function getExtraClass(Request $request){
    $id = $request->id ? $request->id:''; 
    if($id){
      $lecture = \App\Models\ExtraClass::where('id',$id)->first();
      
      if($lecture){
        return response()->json([
          'status' => true,
          'data' => $lecture,
          'lecture_date'=>$lecture->lecture_date ? date('Y-m-d',strtotime($lecture->lecture_date)) : ''
          ]);
      }else{
        return response()->json([
          'status' => false,
          'data' => '',
          'add'=>''
          ]);
      }
    }

  }

  public function getNextExtraClassDate($available_days, $latest_extra_class_date)
  {

    $next_extra_class_date = '';
    $dates = [];
    foreach ($available_days as $key => $ad) {
      date_default_timezone_set('ASIA/KOLKATA');
      $condition_1 = strtotime($latest_extra_class_date) < strtotime(date('Y-m-d', strtotime($latest_extra_class_date . ' this ' . $ad)));
      $condition_2 = strtotime(date($latest_extra_class_date . ' H:i:s')) < (strtotime(date('Y-m-d', strtotime($latest_extra_class_date . ' this ' . $ad))) - 7200);
      echo '<pre>';
      if ($condition_1 && $condition_2) {
        $dates[] = date('Y-m-d', strtotime($latest_extra_class_date . ' next ' . $ad));
      }
    }

    if (empty($dates)) {

      return $this->getNextExtraClassDate($available_days, date('Y-m-d', strtotime($latest_extra_class_date . ' +1 day')));
    }

    usort($dates, function ($a, $b) {
      return strtotime($a) - strtotime($b);
    });

    return $dates[0];
  }


  public function extra_classes()
  {
    $extra_classesGroupedByUnits = \App\Models\Unit::with('extra_classes')->where('institute_assigned_class_subject_id', request()->iacs_id)->get();
    return view('admin.institute-subject.extra_classes', compact('extra_classesGroupedByUnits'));
  }

  public function tests()
  {
    $topics = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)->where('type', 'test')->get();
    $questions = \App\Models\Question::all();
    return view('admin.institute-subject.tests', compact('topics', 'questions'));
  }

  public function assignments()
  {
    $topics = \App\Models\Topic::where('institute_assigned_class_subject_id', request()->iacs_id)->where('type', 'assignment')->get();
    $questions = \App\Models\Question::all();
    return view('admin.institute-subject.assignments', compact('topics', 'questions'));
  }

  public function reports()
  {
    $topic = \App\Models\Topic::where(['id' => request()->id, 'institute_assigned_class_subject_id' => request()->iacs_id])->firstOrFail();
    $answers = \App\Models\Answer::where('topic_id', $topic->id)->get();
    // $students = User::where('id', '!=', Auth::id())->get();
    $students = \App\Models\Student::all();
    $c_que = \App\Models\Question::where('topic_id', request()->id)->count();

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

    return view('admin.institute-subject.reports', compact('filtStudents', 'answers', 'c_que', 'topic'));
  }

  public function doubts()
  {
    return view('admin.institute-subject.doubts');
  }
  public function doubts_show()
  {
    \App\Models\Doubt::where(['id' => request()->id, 'institute_assigned_class_subject_id' => request()->iacs_id])->firstOrFail();
    return view('admin.institute-subject.doubts_show');
  }
}