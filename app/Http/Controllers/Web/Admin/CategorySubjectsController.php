<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectsCategory;
use App\Models\Category;
use App\Models\Subject;
use Illuminate\Support\Facades\Config;
use Validator;

class CategorySubjectsController extends Controller
{
    public function index(){
        $data = array();
        $category_subjects = SubjectsCategory::select('id','category_id','subject_id','created_at')->paginate(10);
        if(count($category_subjects)>0){
            $data['category_subjects'] = $category_subjects;
        }

        $subjects = Subject::select('id','id','name','created_at')->paginate(10);
        if(count($subjects)>0){
            $data['subjects'] = $subjects;
        }

        $categories = Category::select('id','id','name','created_at')->paginate(10);
        if(count($categories)>0){
            $data['categories'] = $categories;
        }

        return view('admin.category-subjects.index',$data);
    }


    public function store(Request $request){
       
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'subjects' => 'required',
        ]);
             
        if ($validator->passes()) { 
            $sendData = array();
            $category = $request->category ?? '';
            $sendData['category_id'] = $category;
            $subjects = $request->subjects ?? array();
            $delete_category_subjects = SubjectsCategory::where('category_id',$category)->get();
             
            if(count($delete_category_subjects)>0){
                foreach($delete_category_subjects as $delete_category_subject){ 
                    SubjectsCategory::destroy($delete_category_subject->id);
                }
            } 
            if(count($subjects)>0)
            {
                foreach($subjects as $key => $value)
                {
                    $sendData['subject_id'] = $value;
                    $category_subjects = SubjectsCategory::updateOrCreate($sendData); 
                }
            }  
            
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

    public function edit($id){
        $category_subjects = SubjectsCategory::where('id',$id)->firstOrFail();

        $subjects = Subject::select('id','id','name','created_at')->paginate(10);
        if(count($subjects)>0){
            $data['subjects'] = $subjects;
        }

        $categories = Category::select('id','id','name','created_at')->paginate(10);
        if(count($categories)>0){
            $data['categories'] = $categories;
        }
        return view('admin.category-subjects.edit',compact('category_subjects'),$data);
    }

    public function delete(Request $request){
        $id = $request->id ?? '';
        if($id != null){
            $category_subjects = SubjectsCategory::where('id',$id)->firstOrFail();
            $category_subjects->delete();
            return response()->json([ 
                Config::get('constants.key.status') => Config::get('constants.value.success')
            ]);
        }
        return response()->json(
            [ 
                Config::get('constants.key.status') => Config::get('constants.value.failure') 
            ]
        );
        
    }
}
