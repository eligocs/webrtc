<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Assignments_unit;

class AssignmentController extends Controller
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
    $unitNames =Assignments_unit::all();
    if($unitNames){
        foreach($unitNames as $u_name){
          $topics_get = Topic::where('institute_assigned_class_subject_id', request()->iacsId)
          ->where('type', 'assignment')
          ->where('unit', $u_name->id)
          ->orderBy('publish_date','desc')
          ->get();       
        $unitName['unit'] = $u_name->id;
        $unitName['topics'] = $topics_get;
        $unitName['name'] = $u_name->unitName;
        $topics[] = $unitName;
        }
        // dd($topics);
    }
   
    $questions = Question::all();
    $assignmet_w_n_t = Topic::where('institute_assigned_class_subject_id', request()->iacsId)
    ->where('type', 'assignment')
    ->where('unit', null)
    ->where('testType',null)
    ->orderBy('publish_date','desc')
    ->get(); 
    return view('institute.assignments.index', compact('topics', 'questions','assignmet_w_n_t'));
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
  public function store(Request $request)
  {
    // dd($request->all());
    $input = $request->all();
    $input['institute_assigned_class_subject_id'] = request()->iacsId;
    // dd($input);
    $request->validate([
      'title' => 'required|string',
      'per_q_mark' => 'required',
           'unit' => 'required'
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
    $input['testType'] = $request->testType;
    $input['type'] = "assignment";
    // $input = $request->all();
    // dd($input);
    $quiz = Topic::create($input);
  


    // $input['show_ans'] = $request->show_ans;
    //return Topic::create($input);
    return back()->with('added', 'Topic has been added');
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
      'per_q_mark' => 'required',
      'unit' => 'required'

    ]);

    if (isset($request->pricechk)) {
      $request->validate([
        'amount' => 'required'
      ]);
    }
    $topic = Topic::findOrFail(request()->assignment);

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
    $topic->testType = $request->testType;
    $topic->type = "assignment";
    $topic->save();

    return back()->with('updated', 'Topic updated !');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Topic  $topic
   * @return \Illuminate\Http\Response
   */
  public function destroy($iacsId, $id)
  {
    $topic = Topic::findOrFail($id);
    $topic->delete();
    return back()->with('deleted', 'Topic has been deleted');
  }

   public function assignmentUnitAdd()
      {
      // dd(request()->all());
      request()->validate([
      'unitName' => 'required|unique:assignments_units',
      ]);

      $ass_unit = Assignments_unit::where(['institute_assigned_class_subject_id' => request()->iacsId, 'unitName' =>
      request()->unitName]);
      // dd($test_unit->all);
      // // dd

      if ($ass_unit->count()) {
      return response()->json(['status' => true, 'data' => ['id' => $ass_unit->first()->id, 'unitName' =>
      $ass_unit->first()->unitName]]);
      } else {
      $unit_1 = Assignments_unit::create([
      'institute_assigned_class_subject_id' => request()->iacsId,
      'unitName' => request()->unitName,
      ]);
      return response()->json(['status' => true, 'data' => ['id' => $unit_1->id, 'unitName' => $unit_1->unitName]]);
      }
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
}