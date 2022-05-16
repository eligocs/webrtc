<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageStudentController extends Controller
{
  public function index()
  {
    // $students = \App\Models\Student::orderBy('created_at', 'desc')->get();
    $students = \App\Models\User::orderBy('created_at', 'desc')->where('role', 'student')->get();
    return view('admin.manage-students.index', compact('students'));
  }

  public function enrolled_classes()
  {
    $student = \App\Models\Student::findOrFail(request()->id);
    return view('admin.manage-students.enrolled-classes', compact('student'));
  }

  public function delete_classes(Request $request)
  {
    $student = \App\Models\Student::findOrFail(request()->class_id);
    $delete_query = \App\Models\InstituteAssignedClassStudent::where('institute_assigned_class_id', request()->class_id)->where('student_id', request()->student_id)->delete();
    if($delete_query){
      return response()->json(['status' => 'success', 'message' => 'Deleted Successfully']);
    }else{
      return response()->json(['status' => 'error', 'message' => 'Fail to delete']);
    }
    //return view('admin.manage-students.enrolled-classes', compact('student'));
  }

  public function generate_receipt()
  {
    $class = \App\Models\InstituteAssignedClass::find(request()->class_id);
    $student = $class->students->where('id', request()->student_id)->first();
    $enrolled_class = \App\Models\InstituteAssignedClassStudent::where('institute_assigned_class_id', $class->id)->where('student_id', $student->id)->first();
    // return view('student.receipt', ['class' => $class, 'student' => $student, 'enrolled_class' => $enrolled_class]);
    $pdf = app('dompdf.wrapper')->loadView('student.receipt', ['class' => $class, 'student' => $student, 'enrolled_class' => $enrolled_class]);
    return $pdf->stream('invoice.pdf');
  }
}
