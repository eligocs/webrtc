<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Theoryanswer;

class QuestionController extends Controller
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
        return view('institute.questions.index', compact('questions', 'topics'));
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
    // public function store(Request $request)
    // {
    //   $request->validate([
    //     'topic_id' => 'required',
    //     'question' => 'required',
    //     'a' => 'required',
    //     'b' => 'required',
    //     'c' => 'required',
    //     'd' => 'required',
    //     'answer' => 'required',
    //     'question_img' => 'nullable|mimes:image:jpg,jpeg,png'
    //   ]);

    //   $input = $request->all();

    //   if ($file = $request->file('question_img')) {
    //       $file = request()->file('question_img')->store('/assignment'.'/'.request()->topic_id , 's3');
    //       $file_name = $file;
    //       $input['question_img'] = $file_name;
    //     /* $name = 'question_' . time() . '_' . $file->getClientOriginalName();
    //     $file->storeAs('public/questions/', $name);
    //     $input['question_img'] = 'questions/' . $name; */
    //   }

    //   Question::create($input);

    //   return back()->with('added', 'Question has been added');
    // }
    public function getimag(Request $request)
    {
        dd($request);
    }

    public function store(Request $request)
    {   
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacsId);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id; 
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
            if(!empty($request->topic_id)){
                $topic = \App\Models\Topic::findOrFail($request->topic_id);
                if(!empty($topic)){
                    $Qtype = $topic->type;
                };
            } 
            if ($file = $request->file('question_img')) {
              /*   $file = request()->file('question_img')->store('/assignment'.'/'.request()->topic_id, 's3');
                $file_name = $file; */
                $file_name = ''; 
                $folderName = 'institutes/'.$Qtype.'/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->iacsId.'/'.$request->topic_id;
                $folder = createFolder($folderName);
                $fileData = request()->file('question_img');
                $file = createUrlsession($fileData, $folder); 
                if(!empty($file) && $file != 400){ 
                    $file_name = serialize($file);  
                }
                $input['question_img'] = $file_name;
                /* $name = 'question_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/questions/', $name);
                $input['question_img'] = 'questions/' . $name; */
            }

            Question::create($input);

            return back()->with('added', 'Question has been added');
        } else {
            $Qtype = '';
            if(!empty($request->topic_id)){
                $topic = \App\Models\Topic::findOrFail($request->topic_id);
                if(!empty($topic)){
                    $Qtype = $topic->type;
                };
            } 
            //  dd($request->all());
            $request->validate([
         'topic_id' => 'required',
          'question' => 'required',
          'answer_exp' => 'required',
          'question_img' => 'nullable|mimes:image:jpg,jpeg,png'

       ]);

            $input = $request->all();
            // dd($input);
            if ($file = $request->file('question_img')) {
                $file = request()->file('question_img')->store('institutes/'.$Qtype.'/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->iacsId.'/'.$request->topic_id, 's3');
                // $file = request()->file('question_img')->store('/questionimg/assignment/'.auth()->user()->institute_id.'/'.request()->iacsId.'/'.$request->topic_id, 's3');
                $file_name = $file;
             /*    $file_name = ''; 
                $folderName = 'institutes/assignment/'.auth()->user()->institute_id.'/'.request()->iacsId.'/'.$request->topic_id;
                $folder = createFolder($folderName);
                $fileData = request()->file('question_img');
                $file = createUrlsession($fileData, $folder);  
                if(!empty($file) && $file != 400){ 
                    $file_name = serialize($file);  
                } */
                $input['question_img'] = $file_name;
            }
            Question::create($input);

            return back()->with('added', 'Question has been added');
        }
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
        $questions = Question::where('topic_id', $topic->id)->get();
        return view('institute.questions.show', compact('topic', 'questions'));
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
    public function update(Request $request, $iacsId, $id)
    { 
        $question = Question::findOrFail($id);
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacsId);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id; 
        if ($request->testType == 1) {
            $request->validate([
                'topic_id' => 'required',
                'question' => 'required',
                'a' => 'required',
                'b' => 'required',
                'c' => 'required',
                'd' => 'required',
                'answer' => 'required',
            ]);
         

        $input = $request->all();
        
        $Qtype = '';
        if(!empty($request->topic_id)){
            $topic = \App\Models\Topic::findOrFail($request->topic_id);
            if(!empty($topic)){
                $Qtype = $topic->type;
            };
        } 
        if ($file = $request->file('question_img')) {
               /*  $file = request()->file('question_img')->store('/questionimg', 's3');
                $file_name = $file; */
                $file_name = ''; 
                //$folderName = 'institutes/assignment/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->iacsId.'/'.$request->topic_id; 
                $folderName = 'institutes/'.$Qtype.'/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->iacsId.'/'.$request->topic_id;
                $folder = createFolder($folderName);
                $fileData = request()->file('question_img');
                $file = createUrlsession($fileData, $folder);  
                if(!empty($file) && $file != 400){ 
                    $file_name = serialize($file);  
                }
                $input['question_img'] = $file_name;
            }
        // if ($file = $request->file('question_img')) {
        //     if ($question->question_img != null) {
        //         unlink(storage_path() . '/app/public/questions' . $question->question_img);
        //     }
        //     $name = 'question_' . time() . '_' . $file->getClientOriginalName();
        //     $file->storeAs('public/questions/', $name);
        //     $input['question_img'] = 'questions/' . $name;
        // }
    }else{
        $request->validate([
            'topic_id' => 'required',
            'question' => 'required',
            'answer_exp' => 'required',
            'question_img' => 'nullable|mimes:image:jpg,jpeg,png'

        ]);
        
    }
    $Qtype = '';
    if(!empty($request->topic_id)){
        $topic = \App\Models\Topic::findOrFail($request->topic_id);
        if(!empty($topic)){
            $Qtype = $topic->type;
        };
    } 
    //  dd($request->all());
    $request->validate([
    'topic_id' => 'required',
    'question' => 'required',
    'answer_exp' => 'required',
    'question_img' => 'nullable|mimes:image:jpg,jpeg,png'

    ]);

    $input = $request->all(); 
    if ($file = $request->file('question_img')) {
        $file = request()->file('question_img')->store('institutes/'.$Qtype.'/'.auth()->user()->institute_id.'/'.$class_id.'/'.request()->iacsId.'/'.$request->topic_id, 's3'); 
        $file_name = $file; 
        $input['question_img'] = $file_name;
    }
        $question->update($input);
        return back()->with('updated', 'Question has been updated');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($iacsId, $id)
    {
        $question = Question::findOrFail($id);

        if ($question->question_img != null) {
            if (file_exists(public_path() . '/images/questions/' . $question->question_img)) {
                unlink(public_path() . '/images/questions/' . $question->question_img);
            }
        }

        $question->delete();
        return back()->with('deleted', 'Question has been deleted');
    }

    public function importExcelToDB(Request $request)
    {
        // $request->validate([
    //     'question_file' => 'required|mimes:xlsx'
    // ]);
    // if ($request->hasFile('question_file')) {
    //     $path = $request->file('question_file')->getRealPath();
    //     $data = \Excel::load($path)->get();
    //     if ($data->count()) {
    //         foreach ($data as $key => $value) {
    //             $arr[] = ['topic_id' => $request->topic_id, 'question' => $value->question, 'a' => $value->a, 'b' => $value->b, 'c' => $value->c, 'd' => $value->d, 'answer' => $value->answer, 'code_snippet' => $value->code_snippet != '' ? $value->code_snippet : '-', 'answer_exp' => $value->answer_exp != '' ? $value->answer_exp : '-'];
    //         }
    //         if (!empty($arr)) {
    //             \DB::table('questions')->insert($arr);
    //             return back()->with('added', 'Question Imported Successfully');
    //         }
    //         return back()->with('deleted', 'Your excel file is empty or its headers are not matched to question table fields');
    //     }
    // }
    // return back()->with('deleted', 'Request data does not have any files to import');
    }

    public function theoryshow(Request $request, $iacsId, $id)
    {
        $topic = Topic::where(['id' => $id, 'institute_assigned_class_subject_id' => $iacsId])
    ->where('testType', '2')->firstOrFail();
        $questions = Question::where('topic_id', $topic->id)
    ->where('testType', '2')
    ->get();
        return view('institute.questions.theoryshow', compact('topic', 'questions'));
    }



    // public function getimagAns(Request $request)
    // {
    //     if (request()->hasFile('croppedImage')) {
    //         if ($file = $request->file('croppedImage')) {
    //             $file = request()->file('croppedImage')->store('/answer_checked', 's3');
    //             $file_name = $file;
  
    //             $input['croppedImage'] = $file_name;
    //         }
    //         Theoryanswer::where(['questionId'=>$request->question_id,'userid'=>$request->user_id])->update(['answer_checked'=>$file_name]);
    //     }
    // }

    // public function downloadAsset($id)
    // {
    //     $asset = Asset::find($id);
    //     $assetPath = Storage::disk('s3')->url($asset->filename);

    //     header("Cache-Control: public");
    //     header("Content-Description: File Transfer");
    //     header("Content-Disposition: attachment; filename=" . basename($assetPath));
    //     header("Content-Type: " . $asset->mime);

    //     return readfile($assetPath);
    // }
}