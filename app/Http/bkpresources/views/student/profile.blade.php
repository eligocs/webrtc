@extends('student.layouts.app')
@section('css')
<link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card-box">
                <div class="text-right">
                    <a href="" class="btn-style btn-theme" data-toggle="modal" data-target="#editModal">Edit</a>
                </div>
                <div> 
                    <div class="client-img rounded-circle mx-auto avatar-xl overflow-hidden mb-2">
                        <img src="{{!empty(auth()->user()->student->avatar) ? auth()->user()->student->avatar : '/assets/front/images/cost.png'}}" class="img-thumbnail w-100" alt="profile-image">
                    </div>
                    <h4 class="text-center">{{auth()->user()->student->name}}</h4>
                    <div class="text-left">
                        <!-- <p class="text-muted font-13 mb-1"><strong>Email :</strong> <span class="ml-2">decorster@gmail.com</span></p> -->
                        <p class="text-muted font-14 mb-1"><strong>Board/University :</strong>
                            <span class="ml-2">{{auth()->user()->student->board}}</span>
                        </p>
                        <p class="text-muted font-14 mb-1"><strong>Date of Birth :</strong>
                            <span
                                class="ml-2">{{auth()->user()->student->date_of_birth ? date('Y-m-d', strtotime(auth()->user()->student->date_of_birth)) : ''}}</span>
                        </p>
                        <p class="text-muted font-14 mb-1"><strong>Gender :</strong>
                            <span class="ml-2">{{auth()->user()->student->gender}}</span>
                        </p>
                        <p class="text-muted font-14 mb-1"><strong>Phone Number :</strong>
                            <span class="ml-2">{{auth()->user()->student->phone}}</span>
                        </p>
                        <p class="text-muted font-14 mb-1"><strong>State :</strong><span
                                class="ml-2">{{auth()->user()->student->state}}</span></p>
                        <p class="text-muted font-14 mb-1"><strong>City :</strong><span
                                class="ml-2">{{auth()->user()->student->city}}</span></p>
                        <p class="mt-3 d-md-flex justify-content-center align-items-center">

                            {{-- <button type="button" class="font-14 py-2 mr-1 no-border btn btn-danger waves-effect waves-light">Delete
                Account</button> --}}
                            <a href="#password-modal" class="btn-style btn-theme" data-animation="fadein"
                                data-plugin="custommodal" data-overlaycolor="#36404a" data-toggle="modal"
                                data-target="#passwordModal">Change Password</a>
                            @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('confirm_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @if (session()->has('message'))
                        <div class="alert alert-success">{{ session()->get('message') }}</div>
                        @endif
                        </p>
                    </div>
                </div>
            </div>
            <!--card box end-->
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('student.change_profile')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title" id="editModalLabel">Modal title</h5> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{auth()->user()->student->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email"
                                value="{{auth()->user()->student->email}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Board/University</label>
                            <input type="text" class="form-control" name="board"
                                value="{{auth()->user()->student->board}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth"
                                value="{{auth()->user()->student->date_of_birth ? date('Y-m-d', strtotime(auth()->user()->student->date_of_birth)):''}}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="">Gender</label>
                            {{-- <input type="text" class="form-control" name="gender" value="{{auth()->user()->student->gender}}"
                            required> --}}
                            <select name="gender" id="" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male" {{auth()->user()->student->gender == 'Male' ? 'selected' : ''}}>
                                    Male</option>
                                <option value="Female"
                                    {{auth()->user()->student->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                <option value="Others"
                                    {{auth()->user()->student->gender == 'Others' ? 'selected' : ''}}>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Photo - JPG/PNG/JPEG</label>
                            <input type="file" class="form-control inputChange" name="avatar"
                                accept='image/x-png,image/jpg,image/jpeg'>
                            <img class="display_img " src="{{auth()->user()->student->avatar}}" alt="">
                        </div>
                        <div class="form-group">
                            <label for="">State</label>
                            <input type="text" class="form-control" name="state"
                                value="{{auth()->user()->student->state}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">City</label>
                            <input type="text" class="form-control" name="city"
                                value="{{auth()->user()->student->city}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Grade</label>
                            <input type="text" class="form-control" name="grade"
                                value="{{auth()->user()->student->grade}}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-theme submitbutton">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Password -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('student.change_password')}}" method="post">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title" id="editModalLabel">Modal title</h5> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-theme ">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{URL::to('assets/student/libs/custombox/custombox.min.js')}}"></script>
<script src="{{URL::to('assets/student/js/app.min.js')}}"></script>
<script>
$('.inputChange').change(function(e) {
    e.preventDefault();
    var fileExtension = ['jpeg', 'jpg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        alert("Only formats are allowed : " + fileExtension.join(', '));
        $('.submitbutton').prop('disabled', true);
    } else {
        $('.submitbutton').prop('disabled', false);
    }
});
</script>
@endsection