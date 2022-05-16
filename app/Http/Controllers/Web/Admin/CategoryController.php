<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Config;
use Validator;

class CategoryController extends Controller
{
    public function index(){
        $data = array();
        $categories = Category::select('id','name','created_at')->paginate(10);
        if(count($categories)>0){
            $data['categories'] = $categories;
        }
        return view('admin.category.index',$data);
    }

    public function store(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);

        if ($validator->passes()) {

            $category = new Category(); 
            $category->name = $request->name; 
            $category->save();
            
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
        $category = Category::where('id',$id)->firstOrFail();
        return view('admin.category.view',compact('category'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);

        if ($validator->passes()) {

            $category = Category::where('id',$id)->firstOrFail();
            $category->name = $request->name; 
            $category->save();
            
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
