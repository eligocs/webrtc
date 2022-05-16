<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Support\Facades\Config;
// use Validator;
use DateTime;
use App\Models\SubjectsCategory;
use App\Models\Category;
use App\Models\InstituteAssignedClass;
use App\Models\InstituteAssignedClassSubject;
use App\Models\SubjectsInfo;
use Carbon\Carbon;
use App\Models\Instituter_user;
use Illuminate\Support\Facades\Hash;
use Vimeo\Laravel\Facades\Vimeo;
use Illuminate\Support\Facades\Validator;


class ManageInstituteController extends Controller
{
  public function index()
  {
    $data = array();
    $institutes = Institute::orderBy('created_at', 'desc')->get();
    if (count($institutes) > 0) {
      $data['institutes'] = $institutes;
    }
    return view('admin.manage-institutes.index', $data);
  }

  public function create()
  {
    return view('admin.manage-institutes.add-institute');
  }

  public function approveVideo($id, $val)
  {
    if ($id) {
      $videoApproval = $val;
    }  
    $res = \App\Models\Institute::where('id', $id)->update([
      'videoApproval'=>$videoApproval
    ]); 
    if ($res) {
      if($val == 1){
        return redirect()->back()->with(['message' => 'Content Approved Successfully']);
      }else{
        return redirect()->back()->with(['message' => 'Content Dis-Approved Successfully']);
      }
    } else {
      return redirect()->back()->with(['errors' => 'Fail to approve demo content !!!']);
    }
    return view('admin.manage-institutes.add-institute');
  }

  public function approveSubjectVideo($id, $val)
  {
    if ($id) {
      $videoApproval = $val;
    }  
    $res = \App\Models\InstituteAssignedClassSubject::where('id', $id)->update([
      'videoApproval'=>$videoApproval
    ]); 
    if ($res) {
      if($val == 1){
        return redirect()->back()->with(['message' => 'Content Approved Successfully']);
      }else{
        return redirect()->back()->with(['message' => 'Content Dis-Approved Successfully']);
      }
    } else {
      return redirect()->back()->with(['errors' => 'Fail to approve demo Content !!!']);
    }
    return view('admin.manage-institutes.add-institute');
  }

  public function approveClassVideo($id, $val)
  {
    if ($id) {
      $videoApproval = $val;
    }  
    $res = \App\Models\InstituteAssignedClass::where('id', $id)->update([
      'videoApproval'=>$videoApproval
    ]); 
    if ($res) {
      if($val == 1){
        return redirect()->back()->with(['message' => 'Class Video Approved Successfully']);
      }else{
        return redirect()->back()->with(['message' => 'Class Video Dis-Approved Successfully']);
      }
    } else {
      return redirect()->back()->with(['errors' => 'Fail to approve demo video !!!']);
    }
    return view('admin.manage-institutes.add-institute');
  }

  public function store(Request $request)
  {

    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6',
      'confirm_password' => 'required|same:password',
      'phone' => 'required|unique:users|numeric|min:10',
      'address' => 'required',
    ]);


    $institute_application = new Institute();
    $institute_application->name = $request->name;
    $institute_application->email = $request->email;
    $institute_application->phone = $request->phone;
    $institute_application->address = $request->address;
    $institute_application->save();

    // Saving Institute Role in Users Table 

    if (intval($institute_application->id) > 0) {

      $institute = new User();
      $institute->institute_id = $institute_application->id;
      $institute->name = $request->name;
      $institute->email = $request->email;
      $institute->password = Hash::make($request->password);
      $institute->phone = $request->phone;
      $institute->address = $request->address;
      $institute->role = 'institute';
      $institute->save();
    }

    return redirect()->route('admin.manage-institutes.index')->with('message', 'Institute has been created successfully');

    //return response()->json([ Config::get('constants.key.status') => Config::get('constants.value.success')]);

    // if ($validator->passes()) {

    //     // $institute_application = new Institute(); 
    //     // $institute_application->name = $request->name;
    //     // $institute_application->email = $request->email;
    //     // $institute_application->mobile_no = $request->mobile_no;
    //     // $institute_application->address = $request->address; 
    //     // $institute_application->save();



    // }
    // return response()->json(
    //     [ 
    //         Config::get('constants.key.status') => Config::get('constants.value.failure'),
    //         Config::get('constants.key.error') => $validator->errors()->all(),
    //         Config::get('constants.key.message') => Config::get('constants.value.failure_msg')
    //     ]
    // );
  }

  public function enrollments($id, $class_id)
  {
    if ($id) {
      $instituteClass = \DB::table('institute_assigned_class')->where('institute_id', $id)->where('id', $class_id)->get();
      if ($instituteClass) {
        $students = [];
        foreach ($instituteClass as $ins) {
          $students[] = \DB::table('institute_assigned_class_student')->where('institute_assigned_class_id', $ins->id)->get();
        }
      }
      return view('admin.manage-students.enrollments', compact('students'));
    }
  }

  public function view_institute($id)
  {
    $institute = Institute::where('id', $id)->firstOrFail();
    return view('admin.manage-institutes.view-institute', compact('institute'));
  }

  public function createInstituteUser($id)
  {
    $institute = Institute::where('id', $id)->firstOrFail();
    $users_institute =   User::where('institute_id', $id)
      ->where('username', 'instituteUser')
      ->get();
    return view('admin.manage-institutes.create_institute_user', compact('institute', 'users_institute'));
  }

  public function deleteInstituteuser()
  {

    $id = request()->user_id;
    User::where('id', $id)->delete();
    return json_encode(array(
      "statusCode" => 200
    ));
  }


  public function getInstituteuser(Request $request)
  {
    $id = $request->all();
    if ($id) {
      $userGet = User::where('id', $id)->first();

      if ($userGet) {
        return response()->json([
          'status' => true,
          'data' => $userGet,
        ]);
      } else {
        return response()->json([
          'status' => false,
          'data' => ''

        ]);
      }
      // dd($datameeting);
    }
  }

  public function updateInstituteuser(Request $request)
  {

    // $iduser = $request->id;
    // dd($iduser);
    $validator = Validator::make(
      $request->all(),
      [
        'name' => 'required|unique:users,name,' . $request->id,
        'phone' => 'required|numeric|min:10|unique:users,phone,' . $request->id,
        'email' => 'required|unique:users,email,' . $request->id,
        'subjects' => 'required'
      ],
      [
        'email.unique' => 'You have to choose the file!',

      ]
    );

    if ($validator->passes()) {
      $userUpdate = User::where('id', $request->id)
        ->where('institute_id', $request->institute_id)
        ->update([
          'name' => $request->name,
          'phone' => $request->phone,
          'email' => $request->email,
          'subjects' => $request->subjects,
        ]);
      return response()->json([Config::get('constants.key.status') => Config::get('constants.value.success')]);
    }
    return response()->json([
      Config::get('constants.key.status') => Config::get('constants.value.failure'),
      Config::get('constants.key.error') => $validator->errors()->all(),
      Config::get('constants.key.message') => Config::get('constants.value.failure_msg')
    ]);
  }

  public function storeInstituteUser(Request $request)
  {
    // dd($request->all());
    $validator = Validator::make(
      $request->all(),
      [
        'name' => 'required|unique:users',
        'phone' => 'required|unique:users|numeric|min:10',
        'email' => 'required|unique:users',
        'subjects' => 'required'
      ],
      [
        'email.unique' => 'This User Id Name is Already Exist!',

      ]
    );

    if ($validator->passes()) {
      $userCreate =  new User;
      $userCreate->name = $request->name;
      $userCreate->phone = $request->phone;
      $userCreate->email = $request->email;
      $userCreate->subjects = $request->subjects;
      $userCreate->role = 'institute';
      $userCreate->institute_id = $request->institute_id;
      $userCreate->password = Hash::make('123456');
      $userCreate->username = 'instituteUser';
      $userCreate->reset_password_status = '1';
      $userCreate->save();
      return response()->json([Config::get('constants.key.status') => Config::get('constants.value.success')]);
    }
    return response()->json([
      Config::get('constants.key.status') => Config::get('constants.value.failure'),
      Config::get('constants.key.error') => $validator->errors()->all(),
      Config::get('constants.key.message') => Config::get('constants.value.failure_msg')
    ]);
  }
  public function view_institute_detail($id)
  {
    $institute = Institute::where('id', $id)->firstOrFail();
    return view('admin.manage-institutes.view-institute-detail', compact('institute'));
  }

  public function edit($id)
  {
    $institute = Institute::find($id);
    return view('admin.manage-institutes.edit-institute', compact('institute'));
  }

  public function updateInstitute($id)
  {

    request()->validate([
      'name' => 'required',
      //'phone' => 'required|digits:10|integer',
      'address' => 'required',
      'password' => 'nullable|min:6',
      'confirm_password' => 'required_with:password|same:password'
    ]);

    $institute = Institute::findOrFail($id);

    // get institute in user table
    $userEx = User::where('institute_id', $institute->id)->firstOrFail();
    $institute->name = request()->name;
    $institute->phone = request()->phone;
    $institute->address = request()->address;
    $institute->save();


    // update institute in user table
    $user = new User();
    $user->name = request()->name;
    if (request()->phone) {
      $phoneexist = User::where('id', $id)->where('phone', request()->phone)->first();
      if (empty($phoneexist)) {
        $user->phone = request()->phone;
      }
    }
    $user->phone = request()->phone;
    $user->address = request()->address;

    if (request()->password) {
      $user->password = bcrypt(request()->password);
    }
    if (!empty($userEx)) {
      $user->update();
    } else {
      $user->save();
    }

    return redirect()->back()->with('message', 'Institute has been updated successfully');
  }

  public function enable_trial(Request $request)
  {
    $id = $request->class_id;
    if (!empty($id)) {
      $old = InstituteAssignedClass::where('id', $id)->first();
      if (!empty($old) && $old->freetrial == 1) {
        $edit = InstituteAssignedClass::where('id', $id)->update([
          'freetrial' => '2'
        ]);
      } else {
        $edit = InstituteAssignedClass::where('id', $id)->update([
          'freetrial' => '1'
        ]);
      }
      if ($edit) {
        return response()->json(['status' => 'success', 'message' => 'Enabled']);
      } else {
        return response()->json(['status' => 'failed', 'message' => 'Disabled']);
      }
    }
  }
  public function update(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email|unique:institutes',
      'mobile_no' => 'required',
      'address' => 'required',
    ]);

    if ($validator->passes()) {

      $id = $request->id ?? '';
      $institute = Institute::where('id', $id)->firstOrFail();
      $institute->name = $request->name;
      $institute->email = $request->email;
      $institute->address = $request->address;
      $institute->mobile_no = $request->mobile_no;
      $institute->save();

      return response()->json([Config::get('constants.key.status') => Config::get('constants.value.success')]);
    }
    return response()->json([
      Config::get('constants.key.status') => Config::get('constants.value.failure'),
      Config::get('constants.key.error') => $validator->errors()->all(),
      Config::get('constants.key.message') => Config::get('constants.value.failure_msg')
    ]);
  }

  public function search_by_institute_name(Request $request)
  {
    $data = array();
    $name = $request->name ?? '';
    $institutes = Institute::where('name', 'LIKE', "%{$name}%")->get();
    if (count($institutes) > 0) {
      $data['institutes'] = $institutes;
    }
    return view('admin.manage-institutes.search-institute-name', $data);
  }

  public function search_by_institute_id(Request $request)
  {
    $data = array();
    $id = $request->id ?? '';
    $institute = Institute::where('id', $id)->first();
    if ($institute != null) {
      $data['institute'] = $institute;
    }
    return view('admin.manage-institutes.search-institute-id', $data);
  }

  public function add_new_class(Request $request, $id)
  {
    $categories = Category::all();
    $edit = [];
    return view('admin.manage-institutes.add-new-class', compact('categories', 'edit', 'id'));
  }
  public function editclass()
  {
    $classid = request()->class_id;
    $institute = request()->institute_id;
    if ($classid && $institute) {
      $edit = InstituteAssignedClass::where('id', $classid)->first();
      $classid = $classid;
      $id = $institute;
      $categories = Category::all();
      return view('admin.manage-institutes.add-new-class', compact('edit', 'categories', 'classid', 'id'));
    } else {
      return redirect('admin/manage-institutes/view-institute' . '/' . $institute);
    }
  }
  public function getClass(Request $request)
  {
    $data_id = $request->data_id ? $request->data_id : '';
    if ($data_id) {
      $edit = InstituteAssignedClass::where('id', $data_id)->first();
      $Alloptions = [];
      $options = [];
      $Alloptions1 = [];
      $options1 = [];
      if ($edit->subjects) {
        foreach ($edit->subjects as $e) {
          $options['id'] = $e->id;
          $options['text'] = $e->name;
          $Alloptions[] = $options;
        }
        $lan_name = \DB::table('languages')->where('id', $edit->language)->first();
        $options1['id'] = $edit->language;
        $options1['text'] = $lan_name->name;
        $Alloptions1[] = $options1;

        return response()->json(['options' => $Alloptions, 'Alloptions1' => $Alloptions1, 'msg' => 'Selected data']);
      } else {
        return response()->json(['options' => '', 'Alloptions1' => '', 'msg' => 'No data']);
      }
    }
  }

  public function get_new_class_data(Request $request)
  {


    $validator = Validator::make($request->all(), [
      'id' => 'required',
      'category' => 'required',
      'name' => 'required',
      'start_date' => 'required',
      'end_date' => 'required',
      'price' => 'required',
      'state' => 'required',
      'city' => 'required',
      'board' => 'required',
      'language' => 'required',
    ]);
    if ($validator->passes()) {
      $id = $request->id ?? '';
      $category = $request->category ?? '';
      $name = $request->name ? $request->name : '';
      $start_date = $request->start_date ?? '';
      $end_date = $request->end_date ?? '';
      $price = $request->price ?? '';
      $state = $request->state ?? '';
      $city = $request->city ?? '';
      $board = $request->board ?? '';
      $language = !empty($request->language) ? $request->language : '';
      $subjects = $request->subjects ?? array();
      $lastId = !empty($request->lastId) ? $request->lastId : '';
      // Creating Class in Institute   

      if (!empty($lastId)) {
        $oldData  = InstituteAssignedClass::where('id', $lastId)->first();

        InstituteAssignedClass::where('id', $lastId)->update([
          'institute_id' => $id,
          'category_id' => $category,
          'name' => $name,
          'start_date' => Carbon::parse($start_date),
          'end_date' =>  Carbon::parse($end_date),
          'price' => $price,
          'state' => $state,
          'city' => $city,
          'board' => $board,
          'language' => !empty($language) ? $language : $oldData->language,
        ]);
        $institute_assigned_Id = $lastId;
      } else {
        $institute_assigned_class = new InstituteAssignedClass();
        $institute_assigned_class->institute_id = $id;
        $institute_assigned_class->category_id = $category;
        $institute_assigned_class->name = $name;
        $institute_assigned_class->start_date = Carbon::parse($start_date);
        $institute_assigned_class->end_date = Carbon::parse($end_date);
        $institute_assigned_class->price = $price;
        $institute_assigned_class->state = $state;
        $institute_assigned_class->city = $city;
        $institute_assigned_class->board = $board;
        $institute_assigned_class->language = $language;
        $institute_assigned_class->language = $language;
        $institute_assigned_class->save();
        $institute_assigned_Id = $institute_assigned_class->id;
      }


      if (intval($institute_assigned_Id) > 0) {

        $data = array();
        $days = array();

        $data['institute_assigned_class_id'] = $institute_assigned_Id;
        $data['request'] = $request->all();
        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';

        $from_date = date('d-m-Y', strtotime($start_date));
        $to_date = date('d-m-Y', strtotime($end_date));

        $from_date = new DateTime($from_date);
        $to_date = new DateTime($to_date);

        for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {
          $days[] = $date->format('l');
        }
        $data['days'] = $days;


        return view('admin.manage-institutes.select-days', $data);
      }
    }

    return response()->json([
      Config::get('constants.key.status') => Config::get('constants.value.failure'),
      Config::get('constants.key.error') => $validator->errors()->all(),
      Config::get('constants.key.message') => Config::get('constants.value.failure_msg')
    ]);
  }

  public function create_class(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'subject_id' => 'required',
      'day' => 'required',
    ]);

    if ($validator->passes()) {

      $institute_assigned_class_id = $request->institute_assigned_class_id ?? '';
      $subject_id = $request->subject_id ?? '';
      $days = $request->day ?? array();

      // Adding Subjects in just created class of Institute

      if (intval($institute_assigned_class_id) > 0) {


        $createInstituteAssignedClassSubjectData = array();
        $createInstituteAssignedClassSubjectData['institute_assigned_class_id'] = $institute_assigned_class_id;

        $createInstituteAssignedClassSubjectData['subject_id'] = $subject_id;

        //$createData['subject_id'] = $subject_id; 


        // 
        $institute_assigned_class_subject = InstituteAssignedClassSubject::updateOrCreate($createInstituteAssignedClassSubjectData);


        $createData = array();
        $createData['institute_assigned_class_subject_id'] = $institute_assigned_class_subject->id;

        // 


        // $institute_assigned_class_subject = new InstituteAssignedClassSubject();
        // $institute_assigned_class_subject->institute_assigned_class_id = $institute_assigned_class_id;
        // $institute_assigned_class_subject->subject_id = $subject_id;
        // $institute_assigned_class_subject->save();

        if (intval($institute_assigned_class_subject->id) > 0) {

          if (count($days) > 0) {
            foreach ($days as $day) {
              $createData['day'] = $day;
              $institute_assigned_class_subject = SubjectsInfo::updateOrCreate($createData);
            }
          }
        }
      }

      return response()->json([Config::get('constants.key.status') => Config::get('constants.value.success')]);
    }

    return response()->json([
      Config::get('constants.key.status') => Config::get('constants.value.failure'),
      Config::get('constants.key.error') => $validator->errors()->all(),
      Config::get('constants.key.message') => Config::get('constants.value.failure_msg')
    ]);
  }

  public function uploadClassVideo()
  {

    request()->validate([
      'institute_assigned_class_id' => 'required',
      'class_video' => 'required',
    ]);
    if (request()->hasFile('class_video')) {
      // $file_name = request()->file('class_video')->store('public/classes/videos');
      // $file_name = request()->file('class_video')->store('/classes/videos', 's3');
      /* $video_name = uniqid() . '-' . request()->file('class_video')->getClientOriginalName();
      $video_path = request()->file('class_video')->storeAs('public/classes/videos', $video_name);
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/classes/videos/' . $video_name));
      $video_directory = str_replace('/videos/', '', $vimeo_response); */
      $folderName = 'institutes/classvideo/' . request()->institute_assigned_class_id;
      $folder = createFolder($folderName);
      $fileData = request()->file('class_video');
      $file = createUrlsession($fileData, $folder);
      $file_name = '';
      if (!empty($file) && $file != 400) {
        $file_name = serialize($file);
      }
      $institute_assigned_class = \App\Models\InstituteAssignedClass::findOrFail(request()->institute_assigned_class_id);
      $institute_assigned_class->video = $file_name;
      $institute_assigned_class->videoApproval = '1';
      $institute_assigned_class->save();
    }

    return redirect()->back()->with('message', 'Class Video has been uploaded successfully');
  }

  public function uploadSubjectVideo()
  {
    request()->validate([
      'institute_assigned_class_subject_id' => 'required',
      'subject_video' => 'required',
    ]);

    if (request()->hasFile('subject_video')) {
      // $file_name = request()->file('subject_video')->store('public/subjects/videos');
      // $file_name = request()->file('subject_video')->store('/subjects/videos', 's3');
      // $file_name = str_replace('public/', '', $file_name);
      $video_name = uniqid() . '-' . request()->file('subject_video')->getClientOriginalName();
      $video_path = request()->file('subject_video')->storeAs('public/subjects/videos', $video_name);
      $vimeo_response = Vimeo::upload(storage_path('app/' . $video_path));
      unlink(storage_path('app/public/subjects/videos/' . $video_name));
      $video_directory = str_replace('/videos/', '', $vimeo_response);
      $institute_assigned_class_subject = \App\Models\InstituteAssignedClassSubject
        ::findOrFail(request()->institute_assigned_class_subject_id);

      // $institute_assigned_class_subject->video = url('storage/' . $file_name);
      $institute_assigned_class_subject->video = $video_directory;
      $institute_assigned_class_subject->save();
    }

    return redirect()->back()->with('message', 'Subject Video has been uploaded successfully');
  }

  public function delete_class()
  {
    $class = \App\Models\InstituteAssignedClass::findOrFail(request()->class_id);


    $institute_assigned_class_subjects = $class->institute_assigned_class_subject;
    // dd('sj');
    $class->carts()->delete();
    foreach ($institute_assigned_class_subjects as $key => $institute_assigned_class_subject) {

      $institute_assigned_class_subject->teacher()->detach();
      $institute_assigned_class_subject->lectures()->delete();
      $institute_assigned_class_subject->extra_classes()->delete();
      $institute_assigned_class_subject->units()->forcedelete();
      // \App\Models\Unit::withTrashed()->where('institute_assigned_class_subject_id', $institute_assigned_class_subject->id)->delete();
      // dd($institute_assigned_class_subject->units()->withTrashed()->all()->delete());
      $institute_assigned_class_subject->subjects_infos()->delete();
      foreach ($institute_assigned_class_subject->topics as $key => $topic) {
        $topic->questions()->delete();
      }
      $institute_assigned_class_subject->topics()->delete();
    }
    $class->applicable()->forcedelete();
    $class->institute_assigned_class_subject()->delete();
    $class->delete();
    return response()->json(['status' => 'success', 'message' => 'Deleted Successfully']);


    return response()->json(['status' => 'failed', 'message' => 'Unable to delete!!! Class has enrolled student, can not be deleted']);
  }
}