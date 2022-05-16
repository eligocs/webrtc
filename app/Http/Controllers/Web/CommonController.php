<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectsCategory;

class CommonController extends Controller
{
    public function getSubjectsByCat(Request $request){
        $id = $request->id ?? '';
        $html = '';
        $data = array(); 
        $data['status'] = 'Failure';
        $data['html'] = '';
        $subjects = SubjectsCategory::select('subject_id')->where('category_id',$id)->get();
        if(count($subjects)>0){ 
            foreach($subjects as $subject){
                $html .= '<option value="'.$subject->subject_id.'">'.getSubjectById($subject->subject_id)->name.'</option>'; 
            }
            $data['status'] = 'Success';
            $data['html'] = $html;
        } 
        return $data;
    }
}
