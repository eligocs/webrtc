<?php

namespace App\Http\Controllers\Web\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class DoubtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('institute.doubts.index');
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
    public function show($iacs_id, $id)
    {
        \App\Models\Doubt::where(['id' => $id, 'institute_assigned_class_subject_id' => $iacs_id])->firstOrFail();
        $dontread = false;
        return view('institute.doubts.show', compact('dontread'));
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
    public function update(Request $request, $iacs_id, $id)
    {
        request()->validate([
            'message' => 'required|mimes:pdf,image:jpg,jpeg,png',
        ]);
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacs_id);
        $iac = $iacs->institute_assigned_class;
        $class_id = $iac->id; 
        if (request()->hasFile('message')) {
            /*  $file = request()->file('message')->store('/doubts/' . request()->doubt, 's3');
            $file_name = $file; */
            // $file_name = str_replace('public/', '', $file);
            $file_name = ''; 
            $folderName = 'institutes/doubts'.'/'.request()->institute_id.'/'.$iac->id.'/'.$iacs_id.'/'.request()->doubt;  
            $folder = createFolder($folderName);
            $fileData = request()->file('message');
            $file = createUrlsession($fileData, $folder);   
            if(!empty($file) && $file != 400){ 
                $file_name = serialize($file);  
            
            \App\Models\DoubtMessage::create([
                'sendable_type' => '\App\Models\Institute',
                'sendable_id' => auth()->user()->institute_id,
                'message' => $file_name,
                'doubt_id' => request()->doubt,
            ]);
            $student_id = request()->itemstudent ? request()->itemstudent : '';

            $query = \App\Models\ClassNotification::create([
                'i_a_c_s_id' => request()->iacs_id,
                'type' => 'doubts',
                'message' => 'New doubt',
                'institute_id' => auth()->user()->institute_id,
                'student_id' => $student_id,
                'doubt_id' => request()->doubt,
                'isread' => 2,
            ]);
        }

            \App\Models\Doubt::where(['id' => $id, 'institute_assigned_class_subject_id' => $iacs_id])->firstOrFail();
            $dontread = true;
            return view('institute.doubts.show', compact('dontread'));
            abort(400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}