<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // dd(\App\Models\Coupon::all());
    return view('admin.coupons.index', ['coupons' => \App\Models\Coupon::all()]);
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
    // dd(request()->all());
    request()->validate([
      'applicable_type' => 'required',
      // 'code' => 'required|unique:coupons,code',
      'code' => 'required',
      'discount_in_rs' => 'required',
      'date_interval' => 'required',
    ]);
    // old
    if (request()->applicable_type == 'institute') {
      $applicable_type = 'App\Models\Institute';
      $applicable_id = request()->institute_id;
    } else {
      $applicable_type = 'App\Models\InstituteAssignedClass';
      $applicable_id = request()->class_id;
    }
    // new - only for classes
    if (request()->applicable_type != 'institute') {
      $classes = \App\Models\InstituteAssignedClass::whereIn('id', request()->class_ids)->get();
      if (empty($classes)) {
        abort(400);
      }
    } else {
      $institutes = \App\Models\Institute::whereIn('id', request()->institute_ids)->get();
      // dd($institutes);
      if (empty($institutes)) abort(400);

      $classes = collect([]);
      foreach ($institutes as $key => $institute) {
        $classes = $classes->merge($institute->institute_assigned_classes);
      }
      if (empty($classes)) abort(400);
    }

    // start date
    $start_date = explode(' ', trim(explode(' - ', request()->date_interval)[0]))[0];
    $start_date_day = explode('/', $start_date)[0];
    $start_date_month = explode('/', $start_date)[1];
    $start_date_year = explode('/', $start_date)[2];
    $formated_start_date = $start_date_year . '-' . $start_date_month . '-' . $start_date_day;

    // end date
    $end_date = explode(' ', trim(explode(' - ', request()->date_interval)[1]))[0];
    $end_date_day = explode('/', $end_date)[0];
    $end_date_month = explode('/', $end_date)[1];
    $end_date_year = explode('/', $end_date)[2];
    $formated_end_date = $end_date_year . '-' . $end_date_month . '-' . $end_date_day;

    // old
    // \App\Models\Coupon::create([
    //   'applicable_type' => $applicable_type,
    //   'applicable_id' => $applicable_id,
    //   'code' => request()->code,
    //   'discount_in_rs' => request()->discount_in_rs,
    //   'start_date' => $formated_start_date . ' 00:00:00',
    //   'end_date' => $formated_end_date . ' 23:59:59',
    //   'status' => '1'
    // ]);
    // new

    foreach ($classes as $key => $class) {

      \App\Models\Coupon::create([
        'applicable_type' => 'App\Models\InstituteAssignedClass',
        'applicable_id' => $class->id,
        'code' => request()->code,
        'discount_in_rs' => request()->discount_in_rs,
        'start_date' => $formated_start_date . ' 00:00:00',
        'end_date' => $formated_end_date . ' 23:59:59',
        'status' => '1'
      ]);
    }

    session()->flash('message', 'Added Successfully');
    return redirect()->back();
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
    \App\Models\Coupon::where('id', $id)->delete();
    session()->flash('message', 'Delete Successfully');
    return redirect()->back();
  }

  public function update_coupon_status()
  {

    $coupon = \App\Models\Coupon::findOrFail(request()->id);
    $coupon->status = request()->status . '';
    $coupon->save();
    session()->flash('message', 'Status Updated');
    return redirect()->back();
  }
}
