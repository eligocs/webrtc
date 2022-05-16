<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimeo;
use App\Models\Institute\ClassNotification;
use App\Models\Test_unit;
class LectureController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $lecturesGroupedByUnits = \App\Models\Unit::with('lectures')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->orderBy('created_at','desc')->get();
    return view('institute.lectures.index', compact('lecturesGroupedByUnits'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function addvideo(Request $request){
    $id = $request->id;
    $video_url = '';
    request()->validate([
      'lecture_video'  => 'nullable|mimes:mp4,mov,ogg,mpeg,avi'
    ]);
    $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->i_assigned_class_subject_id);
    $iac = $iacs->institute_assigned_class;
    $class_id = $iac->id; 
    if (request()->hasFile('lecture_video')) {
      /* $file = request()->file('lecture_video');
      $video_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      /* $video_path = $file->storeAs('public/lectures/videos', $video_name);
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/lectures/videos/' . $video_name));
      $video_directory = str_replace('/videos/', '', $vimeo_response); */
      $folderName = '/institutes/lectures/videos'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->i_assigned_class_subject_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('lecture_video');
      $file = createUrlsession($fileData, $folder);  
      if(!empty($file) && $file != 400){ 
        $video_name = serialize($file);  
          \App\Models\Lecture::where('id',$id)->update([
            'lecture_video' =>  $video_name ?? '',
          ]); 
          return response()->json([
            'status' => true,
            'data' => $video_name
            ]);
      }else{
        return response()->json([
          'status' => false,
          'msg' => 'File Exist'
          ]); 
      }
    }else{
      return response()->json([
        'status' => false,
        'data' => ''
        ]); 
    } 

  }


  public function delete(Request $request){
    $id = $request->id;
    $deletedFromonedrive = \App\Models\Lecture::where('id',$id)->first();
    $notes_id = !empty($deletedFromonedrive->notes) && @unserialize($deletedFromonedrive->notes) == true ? unserialize($deletedFromonedrive->notes) :''; 
    $video_id = !empty($deletedFromonedrive->lecture_video) && @unserialize($deletedFromonedrive->lecture_video) == true ? unserialize($deletedFromonedrive->lecture_video) :''; 
    if($notes_id){
      $dNote = deleteFiles($notes_id[1]); 
    }
    if($video_id){ 
      $dvideo = deleteFiles($video_id[1]);  
    }
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
      $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->i_assigned_class_subject_id);
      $iac = $iacs->institute_assigned_class;
      $class_id = $iac->id; 
    //continue
    $available_days = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->get()->pluck('day');

    $latest_lecture = \App\Models\Lecture::orderBy('lecture_date', 'desc')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->first();

    $latest_lecture_date = $latest_lecture ? date('Y-m-d', strtotime($latest_lecture->lecture_date)) : date('Y-m-d');
    $next_lecture_date = $this->getNextLectureDate($available_days, $latest_lecture_date);

    // manual pick lecture date
    $next_lecture_date = request()->lecture_date . ' 00:00:00';
    $video_url = '';


    if (request()->hasFile('lecture_video')) {

      //$file = request()->file('lecture_video');
      /* $video_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $video_path = $file->move(storage_path() . '/app/public/lectures/videos', $video_name);
      // $video_path = $file->storeAs('/lectures/videos', $video_name, 's3');
    /*   $video_path = $file->storeAs('public/lectures/videos/', $video_name);
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/lectures/videos/' . $video_name)); */
      // $exploded_path = explode('/', $video_path);
      // $lecture_video = url('/storage/lectures/videos').'/'.$exploded_path[count($exploded_path)-1];
      // $video_directory = '/lectures/videos/' . $video_name;
      // $video_directory = $video_path;
      /* $video_directory = str_replace('/videos/', '', $vimeo_response); */  
      $folderName = '/institutes/lectures/videos/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->i_assigned_class_subject_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('lecture_video');
      $file = createUrlsession($fileData, $folder);  
      if(!empty($file) && $file != 400){ 
        $video_name = serialize($file);
      }else{
        $video_name = '';
      }
    }else{
      $video_directory = '';
      $video_name = '';
    }
    if (request()->hasFile('notes')) {

      /* $file = request()->file('notes'); */
      /* $notes_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$notes_name =  strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $notes_path = $file->move(storage_path() . '/app/public/lectures/notes', $notes_name);
     /*  $notes_path = $file->storeAs('/lectures/notes/'.$unit->id, $notes_name, 's3'); */
      // $notes_directory = '/storage/lectures/notes/' . $notes_name;
      /* $notes_directory = $notes_path;
      $notes_val =  'lectures/notes/'.$unit->id.'/'.$notes_name; */
      $folderName = '/institutes/lectures/notes/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->i_assigned_class_subject_id;
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

      /* $query = \App\Models\ClassNotification::create([
        'i_a_c_s_id' => request()->i_assigned_class_subject_id,
        'type' => 'lecture',
        'message' => 'New Lecture Created',
        ]);  */

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

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
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


  public function addTestUnit()
  {
// dd(request()->all());
      request()->validate([
          'unit' => 'required|unique:test_units',
        ]);

        $test_unit = \App\Models\Test_unit::where(['institute_assigned_class_subject_id' => request()->iacsId, 'unit' => request()->unit]);
        // dd($test_unit->all);
    // dd

    if ($test_unit->count()) {
      return response()->json(['status' => true, 'data' => ['id' => $test_unit->first()->id, 'unit' => $test_unit->first()->unit]]);
    } else {
        $unit_1 = \App\Models\Test_unit::create([
        'institute_assigned_class_subject_id' => request()->iacsId,
        'unit' => request()->unit,
      ]);
      return response()->json(['status' => true, 'data' => ['id' => $unit_1->id, 'name' => $unit_1->name]]);
    }
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
}