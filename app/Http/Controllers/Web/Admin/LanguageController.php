<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Validator;

class LanguageController extends Controller
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

  


  public function getLanguages()
  {

    $term = trim(request()->q);

    if (empty($term)) {
      $languages = Language::select('id', 'name as text')->get()->toArray();
      return response()->json($languages);
    }

    $tags = Language::where('name', 'like', '%' . $term . '%')->limit(10)->get();
    $formatted_tags = [];
    foreach ($tags as $tag) {
      $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->name];
    }

    return response()->json($formatted_tags);
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
    $validator = Validator::make($request->all(), [
      'name' => 'required|unique:languages',
    ]);

    if ($validator->passes()) {

      $language = new Language();
      $language->name = $request->name;
      $language->save();

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
