<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Test_unit;
use Illuminate\Http\Request;

class TopicController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $unitName= [];
    $topics =[];
    $unitNames =Test_unit::all();
    if($unitNames){
        foreach($unitNames as $u_name){
        $topics_get = Topic::where('institute_assigned_class_subject_id', request()->iacsId)->where('type', 'test')
        ->where('unit', $u_name->id)
        // ->where('unit', null)
        ->orderBy('publish_date','desc')
        ->get();
        $unitName['unit'] = $u_name->id;
        $unitName['topics'] = $topics_get;
        $unitName['name'] = $u_name->unit;
        $topics[] = $unitName;
        }
    }
    // dd($topics);
    // $topics = $this->group_by($topics_get, $key);

    $topicsw_u = Topic::where('institute_assigned_class_subject_id', request()->iacsId)
    ->where('type', 'test')
    ->where('unit', null)
    ->where('testType',null)
    ->orderBy('publish_date','desc')->get();
    // dd($topicsw_u);
    $questions = Question::all();
    return view('institute.topics.index', compact('topics', 'questions', 'topicsw_u'));
  }


//   function group_by($topics_get, $key) {
//     $groupByunitByTest = array();
//     foreach($topics_get as $val) {
//         $groupByunitByTest[$val->$key][] = $val;
//     }
//     // dd($groupByunitByTest);
//     return $groupByunitByTest;

// }
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
  public function store(Request $request)
  {

    $input = $request->all();
    $input['institute_assigned_class_subject_id'] = request()->iacsId;
    $request->validate([
      'unit' =>  'required',
      'title' => 'required|string',
      'per_q_mark' => 'required',
      'testType' => 'required',
    ]);
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

     $quiz = Topic::create($input);

    return back()->with('add', 'Topic has been added');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function show(Topic $topic)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function edit(Topic $topic)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $iacsId, Topic $topic)
  {
    // dd($request->all());
    $request->validate([

      'title' => 'required|string',
      'per_q_mark' => 'required'

    ]);

    if (isset($request->pricechk)) {
      $request->validate([
        'amount' => 'required'
      ]);
    }

    // $topic = Topic::findOrFail($id);

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

    return back()->with('updated', 'Topic updated !');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function destroy($iacsId, Topic $topic)
  {
    // $topic = Topic::findOrFail($id);
    $topic->delete();
    return back()->with('deleted', 'Topic has been deleted');
  }

  public function deleteperquizsheet($iacsId, $id)
  {
    //   $findanswersheet = Answer::where('topic_id','=',$id)->get();

    //   if($findanswersheet->count()>0){
    //     foreach ($findanswersheet as $value) {
    //       $value->delete();
    //     }

    //     return back()->with('deleted','Answer Sheet Deleted For This Quiz !');

    //   }else{
    //     return back()->with('added','No Answer Sheet Found For This Quiz !');
    //   }


  }

  public function publish()
  {
// dd(request()->all());
    $topic = \App\Models\Topic::find(request()->id);
    $topic->status = 'publish';
    if(!empty(request()->lastId)){
      \DB::table('topics')->where('id',request()->lastId)->update([
        'publish_date' => request()->publishingDate ? request()->publishingDate:'',
        'publishing_startTime' => request()->publishing_startTime ? request()->publishing_startTime:'',
        // 'publishing_endTime' => request()->publishing_endTime ? request()->publishing_endTime:'',
        'status' =>$topic->status
        ]);
        $id = request()->lastId;
    }else{
      $topic->publish_date = request()->publishingDate ? request()->publishingDate:'';
      $topic->save();
      $id = $topic->id;
    }
    $query = \App\Models\ClassNotification::create([
      'i_a_c_s_id' => request()->iacsId,
      'type' => request()->type,
      'message' => 'New Assignment/Test',
      'assigment_id' => $id,
      'notify_date' => request()->publishingDate ? request()->publishingDate:'',
      'start_date' => request()->publishing_startTime ? request()->publishing_startTime:'',
    //   'end_date' => request()->publishing_endTime ? request()->publishing_endTime:'',

      ]);

    return redirect()->back()->with('updated', 'Published successfully.');
  }
}