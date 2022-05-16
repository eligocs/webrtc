<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.teachers.index', ['array' => \App\Models\Teacher::where('institute_id', request()->institute_id)->get()]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.teachers.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $institute_id)
  {
    request()->validate([
      'institute_id' => 'required',
      'name' => 'required',
      'qualifications' => 'required',
      'experience' => 'required',
      'avatar' => 'required'
    ]);

    if (request()->hasFile('avatar')) {

      $file = request()->file('avatar')->store('public/teachers');
      $file_name = str_replace('public/', '', $file);
    }

    $array = request()->all();

    $array['avatar'] = $file_name;

    if (request()->head_teacher) {
      \App\Models\Teacher::where('institute_id', request()->institute_id)->update(['head_teacher' => '0']);
      $array['head_teacher'] = '1';
    }

    \App\Models\Teacher::create($array);

    return redirect()->route('admin.teachers.index', [$institute_id])->with('success', 'Teacher created successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($institute_id, $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($institute_id, $id)
  {
    return view('admin.teachers.edit', ['element' => \App\Models\Teacher::find($id)]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $institute_id, $id)
  {
    request()->validate([
      'institute_id' => 'required',
      'name' => 'required',
      'qualifications' => 'required',
      'experience' => 'required',
    ]);

    $teacher = \App\Models\Teacher::find($id);
    $teacher->institute_id = request()->institute_id;
    $teacher->name = request()->name;
    $teacher->qualifications = request()->qualifications;
    $teacher->experience = request()->experience;
    // $teacher->avatar = request()->experience;

    if (request()->hasFile('avatar')) {

      $file = request()->file('avatar')->store('public/teachers'); 
      $file_name = str_replace('public/', '', $file);
      $teacher->avatar = $file_name;
    }

    if (request()->head_teacher) {
      \App\Models\Teacher::where('institute_id', request()->institute_id)->update(['head_teacher' => '0']);
      $teacher->head_teacher = '1';
    } else {
      \App\Models\Teacher::where('institute_id', request()->institute_id)->update(['head_teacher' => '0']);
    }

    $teacher->save();

    return redirect()->route('admin.teachers.index', [$institute_id])->with('success', 'Teacher updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($institute_id, $id)
  {
    //
  }
}