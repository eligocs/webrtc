<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimeo;

class ExtraClassController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $extra_classesGroupedByUnits = \App\Models\Unit::with('extra_classes')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->orderBy('created_at','desc')->get();

    return view('institute.extra_classes.index', compact('extra_classesGroupedByUnits'));
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

   
  public function updvideo(Request $request){  
    $id = $request->id;
    $video_url = '';
     request()->validate([  
      'extra_class_video'  => 'nullable|mimes:mp4,mov,ogg,mpeg,avi' 
    ]); 
    $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->i_assigned_class_subject_id);
    $iac = $iacs->institute_assigned_class;
    $class_id = $iac->id; 

    if (request()->hasFile('extra_class_video')) { 
      $file = request()->file('extra_class_video');
      /* $video_name = uniqid() . '-' . $file->getClientOriginalName();  */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName()))); 
     /*  $video_path = $file->storeAs('public/extra_classes/videos', $video_name); 
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/extra_classes/videos/' . $video_name)); 
      $video_directory = str_replace('/videos/', '', $vimeo_response); */
      $folderName = '/institutes/extraclass/videos/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->i_assigned_class_subject_id;
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

  
  public function getLecture(Request $request){
    $id = $request->id ? $request->id:''; 
    if($id){
      $lecture = \App\Models\ExtraClass::where('id',$id)->first();
      $video = !empty($lecture->extra_class_video) && @unserialize($lecture->extra_class_video)==true ? unserialize($lecture->extra_class_video):'';
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
      'extra_class_video'  => 'nullable|mimes:mp4,mov,ogg,mpeg,avi'
      /* 'extra_class_number' => 'required',
      'extra_class_name' => 'required',  */
    ]); 

    $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => request()->unit_name])->first(); 
    //continue
    $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->i_assigned_class_subject_id);
    $iac = $iacs->institute_assigned_class;
    $class_id = $iac->id; 

    $available_days = \App\Models\SubjectsInfo::where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->get()->pluck('day');

    $latest_extra_class = \App\Models\ExtraClass::orderBy('extra_class_date', 'desc')->where('institute_assigned_class_subject_id', request()->i_assigned_class_subject_id)->first();

    $latest_extra_class_date = $latest_extra_class ? date('Y-m-d', strtotime($latest_extra_class->extra_class_date)) : date('Y-m-d');
    $next_extra_class_date = $this->getNextExtraClassDate($available_days, $latest_extra_class_date);
    $video_url = '';
    if (request()->hasFile('extra_class_video')) {

     /*  $file = request()->file('extra_class_video');
      $video_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$video_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $video_path = $file->move(storage_path() . '/app/public/extra_classes/videos', $video_name);
      // $video_path = $file->storeAs('/extra_classes/videos', $video_name, 's3');
      /* $video_path = $file->storeAs('public/extra_classes/videos', $video_name); */
      // $vimeo_response = Vimeo::upload(config('filesystems.disks.s3.url') . $video_path);
      // dd($video_path);
      /* $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/extra_classes/videos/' . $video_name)); */
      // dd($vimeo_response);
      // $exploded_path = explode('/', $video_path);
      // $extra_class_video = url('/storage/extra_classes/videos').'/'.$exploded_path[count($exploded_path)-1];
      // $video_directory = '/storage/extra_classes/videos/' . $video_name;
      // $video_directory = $video_path;
     /*  $video_directory = str_replace('/videos/', '', $vimeo_response);
      $video_name = $video_directory; */
      $folderName = '/institutes/extraclass/videos/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->i_assigned_class_subject_id;
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

     /*  $file = request()->file('notes');
      $notes_name = uniqid() . '-' . $file->getClientOriginalName(); */
      //$notes_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file->getClientOriginalName())));
      // $notes_path = $file->move(storage_path() . '/app/public/extra_classes/notes', $notes_name);
     /*  $notes_path = $file->storeAs('/extra_classes/notes/'.$unit->id, $notes_name, 's3'); */
      // $notes_directory = '/storage/extra_classes/notes/' . $notes_name;
   /*    $notes_directory = $notes_path;
      $notes_val =  'extra_classes/notes/'.$unit->id.'/'.$notes_name;  */
      $folderName = '/institutes/extraclass/notes/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->i_assigned_class_subject_id;
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
 
    if(request()->last_id){
      $last_id = request()->last_id; 
      $oldData = \DB::table('extra_classes')->where('id',$last_id)->first();  
      $query = \DB::table('extra_classes')->where('id',$last_id)->update([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'unit_id' => $unit->id,
        'extra_class_number' => request()->extra_class_number,
        'extra_class_name' => request()->extra_class_name,
        'extra_class_video' =>   !empty($video_name) ? $video_name : $oldData->extra_class_video ,
        'notes' =>   !empty($notes_val) ? $notes_val :  $oldData->notes,
        'extra_class_date' => request()->lecture_date ? request()->lecture_date : $oldData->extra_class_date, 
      ]);
      $q = $last_id;
    }else{
      $q = \App\Models\ExtraClass::create([
        'institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id,
        'unit_id' => $unit->id,
        'extra_class_number' => request()->extra_class_number,
        'extra_class_name' => request()->extra_class_name,
        'extra_class_video' =>  !empty($video_name) ? $video_name :'',
        'notes' =>  !empty($notes_val) ? $notes_val : '',  
        'extra_class_date'=> request()->lecture_date ? request()->lecture_date : ''
      ])->id;  
      
    }

    $isexist = \App\Models\ClassNotification::where('i_a_c_s_id',request()->i_assigned_class_subject_id)->where('class_id',$q)->where('notify_date',request()->lecture_date)->first();  
      if(empty($isexist)){
        $query = \App\Models\ClassNotification::create([
          'i_a_c_s_id' => request()->i_assigned_class_subject_id,
          'type' => 'extraClass', 
          'message' => 'New extra class',  
          'class_id' => $q,  
          'notify_date'=> request()->lecture_date
          ]); 
      }   
      $unit = \App\Models\Unit::where(['institute_assigned_class_subject_id' => request()->i_assigned_class_subject_id, 'id' => request()->unit_name])->update([
        'updated_at'=>date('y-m-d h:i:s'),
        ]); 

    return redirect()->back()->with('message', 'ExtraClass created successfully');
  }


  public function delete(Request $request){  
    $id = $request->id; 
    $res = \App\Models\ExtraClass::where('id',$id)->first();
    $notes_id = !empty($res->notes) && @unserialize($res->notes)==true ? unserialize($res->notes):''; 
    $video_id = !empty($res->extra_class_video) && @unserialize($res->extra_class_video) ? unserialize($res->extra_class_video) :''; 
    $dNote = !empty($notes_id) ? deleteFiles($notes_id[1]):''; 
    $dvideo = !empty($video_id) ? deleteFiles($video_id[1]):'';  
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