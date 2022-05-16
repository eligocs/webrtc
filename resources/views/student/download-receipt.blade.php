@extends('student.layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ URL::to('assets/student/libs/custombox/custombox.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card-box">
            <div class="table-responsive download_rct">
                <table class="table table-bordered mb-0 package-table">
                    <thead>
                        <tr>
                            <th>
                                <h4 class="header-title m-0 text-center heading">Class Name</h4>
                            </th>
                            <th>
                                <h4 class="header-title m-0 text-center heading">Institute Name</h4>
                            </th>
                            <th>
                                <h4 class="header-title m-0 text-center heading">Enrolled On</h4>
                            </th>
                            <th>
                                <h4 class="header-title m-0 text-center heading">Enrollment Fee</h4>
                            </th>
                            <th>
                                <h4 class="header-title m-0 text-center heading">Coupon Applied</h4>
                            </th>
                            <th>
                                <h4 class="header-title m-0 text-center heading">Total Paid</h4>
                            </th>
                            <th>
                                <h4 class="header-title m-0 text-center heading">Action</h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (auth()->user()->student->institute_assigned_classes as $class)
                            <tr>
                                <td scope="row">{{ $class->name }}</td>
                                <td scope="row">{{ $class->institute->name }}</td>
                                <td>{{ $class->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $enrolled_class = \App\Models\InstituteAssignedClassStudent::where('student_id', auth()->user()->student_id)
                                            ->where('institute_assigned_class_id', $class->id)
                                            ->first();
                                        
                                    @endphp
                                    @if (!empty($enrolled_class->razorpay_payment_id == 'manual_enrollment'))
                                        <h5 class="m-0">Scholarship</h5>
                                    @else
                                        @if (!empty($enrolled_class->price == 0))
                                            <h5 class="m-0">Free Trial</h5>
                                        @else
                                            {{ $class->price }} <i class="fa fa-inr" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $class->pivot->coupon_applied ? 'Yes' : 'No' }}</td>

                                <td>
                                    @if (!empty($enrolled_class->razorpay_payment_id == 'manual_enrollment'))
                                        <h5 class="m-0">Scholarship</h5>
                                    @else
                                        @if (!empty($enrolled_class->price == 0))
                                            <h5 class="m-0">Free Trial</h5>
                                        @else
                                            {{ $class->pivot->coupon_applied
                                                ? $class->price -
                                                    \App\Models\Coupon::withTrashed()->where('id', $class->pivot->coupon_id)->first()->discount_in_rs
                                                : $class->price }}
                                            <i class="fa fa-inr" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                </td>


                                <td style="width: 16%;"><a href="{{ route('student.generate-receipt', $class->id) }}"
                                        class="btn-theme btn-style" target="_blank">Download</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::to('assets/student/libs/custombox/custombox.min.js') }}"></script>
    <script src="{{ URL::to('assets/student/js/app.min.js') }}"></script>
@endsection
