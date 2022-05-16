<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;

class MainQuizController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
    $input = $request->all();
    // dd($input);
    $answer = Answer::firstOrNew([
      'question_id' => $input['question_id'],
      'user_id' => $input['user_id'],
      'topic_id' => $input['topic_id'],
    ]);

    $answer->fill($input);
    $answer->save();
    return response()->json([
      "status" => 200,
      "message" => 'Answer saved', 
  ]);
    // Answer::create($input);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    
    $topic = Topic::findOrFail($id);
    $auth = auth()->user();
    $auth->id = $auth->student_id;
    
   
    if ($auth) {
   
     $answe =  Answer::where('user_id', $auth->id)->get();
     // return response()->json(["ans" => !empty($answe)]);
      if (!empty($answe)) {
        $all_questions = collect();
        $q_filter = collect();
        foreach ($answe as $answer) {
          $q_id = $answer->question_id;
          $q_filter = $q_filter->push(Question::where('id', $q_id)->get());
        }
        $all_questions = $all_questions->push(Question::where('topic_id', $topic->id)->get());
        $all_questions = $all_questions->flatten();
        $q_filter = $q_filter->flatten();
        $questions = $all_questions->diff($q_filter);
        $questions = $questions->flatten();
        $questions = $questions->shuffle();
        $quest = [];  
        if(!empty($topic) ){
          foreach($questions as $qq){ 
              $quest[] = ([
                'id'=>$qq->id,
                'topic_id'=>$qq->topic_id,
                'question'=>$qq->question,
                'a'=>$qq->a,
                'b'=>$qq->b,
                'c'=>$qq->c,
                'd'=>$qq->d,
                'answer'=>$qq->answer,
                'code_snippet'=>$qq->code_snippet,
                'answer_exp'=>$qq->answer_exp,
                'question_img'=>!empty($qq->question_img) && @unserialize($qq->question_img)==true ? unserialize($qq->question_img)[0]:'' ,
                'question_video_link'=>$qq->question_video_link,
                'question_no'=>$qq->question_no,
                'testType'=>$qq->testType,
                'istest'=>1
              ]);
            } 
            return response()->json(["questions" => $quest, "auth" => $auth, "topic" => $topic->id]);
          }else{ 
            $questions = collect();
            $questions = Question::where('topic_id', $topic->id)->get();
            $questions = $questions->flatten();
            $questions = $questions->shuffle(); 
             
            return response()->json(["questions" => $questions, "auth" => $auth]); 
          }
        } 
      } 
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
    $answer = Answer::findOrFail($id);
    $answer->delete();
    return back()->with('deleted', 'Record has been deleted');
  }
}