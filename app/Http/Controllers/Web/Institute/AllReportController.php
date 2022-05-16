<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Student;
use App\Models\Topic;
use App\Models\User;
use App\Models\Theoryanswer;
use App\Models\Theory_answer_marks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
 use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
    
class AllReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::where('institute_assigned_class_subject_id', request()->iacsId)->get();
        $questions = Question::all();
        return view('institute.all_reports.index', compact('topics', 'questions'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($iacsId, $id)
    {
        $topic = Topic::where(['id' => $id, 'institute_assigned_class_subject_id' => $iacsId])->firstOrFail();
        $answers = Answer::where('topic_id', $topic->id)->get();
        // $students = User::where('id', '!=', Auth::id())->get();
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
        return view('institute.all_reports.show', compact('filtStudents', 'answers', 'c_que', 'topic'));
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
    public function destroy($iacsId, $all_report, $topicid=null, $userid=null)
    {
        $answer = Answer::where('user_id', request()->userid)->where('topic_id', request()->topicid)->delete();

        return back()->with('deleted', 'Response Reset Successfully !');
    }

    public function gettheoryReport($iacsId, $id)
    {

        $topic = Topic::where(['id' => $id, 'institute_assigned_class_subject_id' => $iacsId])->firstOrFail();
        $c_quee = Question::where('topic_id', $id)->get();
        $getanswers = Theoryanswer::where('topicId', $id)
        ->groupBy('userid')
        ->get();
        $students = Student::all();
        $c_que = Question::where('topic_id', $id)->count();
    

          
        $filtStudents = collect();
        foreach ($students as $student) {
             foreach ($getanswers as $getanswer) {
                if ($getanswer->userid == $student->id) {
                    $filtStudents->push($student);
                    
                   
                }
            }
        }
            
        
        $filtStudents = $filtStudents->unique();
        $filtStudents = $filtStudents->flatten(); 
        
        $gotMarks = Theory_answer_marks::where('iacsId', $iacsId)
        ->where('topicId', $id) 
        ->get();

        return view('institute.all_reports.showtheory', compact('filtStudents', 'getanswers',  'topic', 'c_quee', 'gotMarks'));
    }

    public function givemaks($iacsId, $tid)
    {       
            if (request()->hasFile('croppedImage')) {
                if ($file = request()->file('croppedImage')) {
                    $file = request()->file('croppedImage')->store('/answer_checked', 's3img');
                    $file_name = $file; 
                    $input['croppedImage'] = $file_name;
                }
                Theoryanswer::where(['questionId'=>Crypt::decrypt(request()->question_id),'userid'=> Crypt::decrypt(request()->user_id)])
                ->where('id', Crypt::decrypt(request()->answer_id))
                ->update(['answer'=>$file_name]);
                    $topic = Topic::where(['id' => Crypt::decrypt($tid), 'institute_assigned_class_subject_id' => $iacsId])->firstOrFail();
                    // dd($topic);
                    $getanswers = Theoryanswer::where('topicId', $topic->id)
                    ->where('userid', Crypt::decrypt(request()->user_id))
                    ->where('id', '>', Crypt::decrypt(request()->answer_id))
                    ->orderBy('anser_no', 'asc')->first();
                    // dd($getanswers->id);
                    $students = Student::all();
                    $c_que = Question::where('topic_id', $tid)->count();

                    
                    $filtStudents = collect();
                    foreach ($students as $student) {
                        if (!empty($getanswers->userid)) {
                            if ($getanswers->userid == $student->id) {
                                $filtStudents->push($student);
                            }
                        }
                    }      
                    
                    $filtStudents = $filtStudents->unique();
                    $filtStudents = $filtStudents->flatten();

                    if(!empty($getanswers->id)){
                    $id =$getanswers->id;
                    return response()->json([
                        'status'=>200,
                        'url'=> url('institute/get_new_quest/'.$iacsId.'/'.$tid.'/'.request()->user_id.'/'.$id),
                    ]);
                 } else{
                         DB::table('answer_status')->where('userid', Crypt::decrypt(request()->user_id))
                         ->where('userid', Crypt::decrypt(request()->user_id))
                            ->where('topicId', Crypt::decrypt($tid))
                            ->update(['answer_checked' => request()->status]);                          
                    return response()->json([
                        'status'=>201,
                    ]);
                }
            }

            else if(request()->prev){
                // dd(Crypt::decrypt($tid));
                $topic = Topic::where(['id' => Crypt::decrypt($tid), 'institute_assigned_class_subject_id' => $iacsId])->firstOrFail();
                $getanswers = Theoryanswer::where('topicId', $topic->id)
                ->where('userid', Crypt::decrypt(request()->user_id))
                ->where('id', '<', Crypt::decrypt(request()->answer_id))
                ->orderBy('anser_no', 'desc')->first();
                $students = Student::all();
                $c_que = Question::where('topic_id', Crypt::decrypt($tid))->count();
                
                
                $filtStudents = collect();
                foreach ($students as $student) {
                    if (!empty($getanswers->userid)) {
                        if ($getanswers->userid == $student->id) {
                            $filtStudents->push($student);
                        }
                    }
                }      
                
                $filtStudents = $filtStudents->unique();
                $filtStudents = $filtStudents->flatten();
                
                if(!empty($getanswers->id)){
                $id =$getanswers->id;
                    return response()->json([
                        'status'=>200,
                        'url'=> url('institute/get_new_quest/'.$iacsId.'/'.$tid.'/'.request()->user_id.'/'.$id),
                    ]);
                }
                else{

                    return response()->json([
                        'status'=>201,
                    ]);
                }

            }
            $ans_id = request()->answer_id;
            $studentId = request()->student_id;
            // var_dump(Crypt::decrypt( $ans_id));die;
            return response()->json([
                'status'=>200,
                'url'=> url('institute/get_new_quest/'.$iacsId.'/'.$tid.'/'.$studentId),
            ]);
                
    
    }


    public function get_new_quest_id($iacsId=null, $tid=null, $studentId=null, $answer_id=null){      
// dd($studentId);
        try {
            $decrypted = Crypt::decrypt($tid, $studentId);
        } catch (DecryptException $e) {
            return abort(404);  
        }

        $topic = Topic::where(['id' => Crypt::decrypt($tid), 'institute_assigned_class_subject_id' => $iacsId])->firstOrFail();
        $GetNS = Theoryanswer::where('topicId', $topic->id)
        ->where('userid', Crypt::decrypt($studentId))
        ->orderBy('anser_no', 'asc');
        if(!empty($answer_id)){
            $GetNS->where('id', $answer_id);      
        } 
        $getanswers = $GetNS->first();
        // dd($getanswers);
        $students = Student::all();
        $c_que = Question::where('topic_id', Crypt::decrypt($tid))->count();
        
        
        $filtStudents = collect();
        foreach ($students as $student) {
            if (!empty($getanswers->userid)) {
                if ($getanswers->userid == $student->id) {
                    $filtStudents->push($student);
                }
            }
        }      
    
        $filtStudents = $filtStudents->unique();
        $filtStudents = $filtStudents->flatten();
        return view('institute.all_reports.editor', compact('filtStudents', 'getanswers', 'c_que', 'topic')); 

    }


    public function marks(Request $request, $iacsId, $id){
        // $gotMarks = Theory_answer_marks::where('iacsId', $iacsId)
        // ->where('topicId', $id) 
        // ->get();


        $input = $request->all();
        $quiz = Theory_answer_marks::create($input);
    }
}