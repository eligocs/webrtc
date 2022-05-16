<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstituteApplication;
use Illuminate\Support\Facades\Config;

class InstituteApplicationController extends Controller
{
  public function index()
  {

    $data = array();
    $unresolved_institute_applications = InstituteApplication::where('status', 0)->orderBy('created_at', 'desc')->paginate(10);
    // if (count($unresolved_institute_applications) > 0) {
    //   $data['unresolved_institute_applications'] = $unresolved_institute_applications;
    // } else {
    //   $data['unresolved_institute_applications'] = collect([]);
    // }
    return view('admin.institute-applications.index', compact('unresolved_institute_applications'));
  }

  public function resolved()
  {
    $data = array();
    $resolved_institute_applications = InstituteApplication::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
    // if (count($resolved_institute_applications) > 0) {
    //   $data['resolved_institute_applications'] = $resolved_institute_applications;
    // } else {
    //   $data['resolved_institute_applications'] = collect([]);
    // }
    return view('admin.institute-applications.resolved', compact('resolved_institute_applications'));
  }

  public function view($id)
  {
    $data = array();
    $institute_application = InstituteApplication::where('id', $id)->firstOrFail();

    return view('admin.institute-applications.view', compact('institute_application'));
  }

  public function make_resolve(Request $request)
  {
    $id = $request->id ?? '';
    $institute_application = InstituteApplication::where('id', $id)->first();
    if ($institute_application != null) {
      $institute_application->status = 1;
      $institute_application->save();
      return response()->json(
        [
          Config::get('constants.key.status') => Config::get('constants.value.success'),
          Config::get('constants.key.message') => Config::get('constants.admin.institute.resolved')
        ]
      );
    } else {
      return response()->json(
        [
          Config::get('constants.key.status') => Config::get('constants.value.failure'),
          Config::get('constants.key.message') => Config::get('constants.admin.institute.not_exists')
        ]
      );
    }
  }
}
