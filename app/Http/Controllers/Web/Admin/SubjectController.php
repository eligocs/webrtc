<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Config;
use Validator;

class SubjectController extends Controller
{
    public function index(){
        $data = array();
        $subjects = Subject::select('id','name','created_at')->paginate(10);
        if(count($subjects)>0){
            $data['subjects'] = $subjects;
        }
        return view('admin.subjects.index',$data);
    }
    public function getSubjects(){

      $term = trim(request()->q);

      if (empty($term)) {
          $subjects = Subject::select('id', 'name as text')->get()->toArray();
          return response()->json($subjects);
      }

      $tags = Subject::where('name', 'like', '%'.$term.'%')->limit(10)->get();
      $formatted_tags = [];
      foreach ($tags as $tag) {
        $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->name];
      }

      return response()->json($formatted_tags);
    }
    
    public function store(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:subjects',
        ]);

        if ($validator->passes()) {

            $subject = new Subject(); 
            $subject->name = $request->name; 
            $subject->save();
            
			return response()->json([ 
                    Config::get('constants.key.status') => Config::get('constants.value.success')
                ]);
        }
    	return response()->json(
            [ 
                Config::get('constants.key.status') => Config::get('constants.value.failure'),
                Config::get('constants.key.error') => $validator->errors()->all()
            ]
        );
    }

    public function view($id){
        $subject = Subject::where('id',$id)->firstOrFail();
        return view('admin.subjects.view',compact('subject'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:subjects',
        ]);

        if ($validator->passes()) {

            $subject = Subject::where('id',$id)->firstOrFail();
            $subject->name = $request->name; 
            $subject->save();
            
			return response()->json([ 
                    Config::get('constants.key.status') => Config::get('constants.value.success')
                ]);
        }
    	return response()->json(
            [ 
                Config::get('constants.key.status') => Config::get('constants.value.failure'),
                Config::get('constants.key.error') => $validator->errors()->all()
            ]
        );
    }
}
