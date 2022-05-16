@extends('institute.layouts.app')
@section('page_heading', 'My Institute')
<style>
    span.text-orange {
        color: orange;
    }

    span.text-green {
        color: rgb(0, 255, 42);
    }

    .content-page {
        overflow: scroll !important;
        height: 100%;
        padding-bottom: 100px !important;
    }

</style>
@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-6">

                @if (Session::has('errors'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ Session::get('errors') }}</li>
                        </ul>
                    </div>
                @endif
                {{-- @if (Session::has('message'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @endif --}}
                <div class="card-box">
                    <form action="{{ url('institute/updateDemoVideo') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3>Demonstration Info</h3>
                        <div class="form-group">
                            <label for="description">Institute Description*</label>
                            <textarea rows='4' type="text" name="description" class="form-control"
                                id="description">{{ old('description') ?? $institute->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="demo_video">Institute Demo Video*</label>
                            <input type="file" name="demo_video" class="form-control dropzone demo_video" id="demo_video"
                                accept="video/*">
                            <small><strong>(Note : .mp4, .mov, .ogg, .mpeg, .avi File Types Only)</strong></small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-theme createClicked">Send For Approval</button>
                            @if (!empty($institute->video) && @unserialize($institute->video) == true)
                                <?php $videodata = $institute->video && @unserialize($institute->video) ? unserialize($institute->video) : ''; ?>
                                <a class="btn-theme text-white btn-style justify-content-center text-center "
                                    rel="video-gallery" href="{{ $videodata ? $videodata[0] : '' }}" target="_blank">
                                    <span class="text-video mr-1 text-capitalize text-white">Play</span>
                                    <i class="mdi mdi-play-circle"></i></a> &nbsp;
                                @if ($institute->videoApproval == 0)
                                    <span class='text-orange'>Content Under Approval</span>
                                @endif
                            @endif
                            &nbsp;&nbsp;
                        </div>
                    </form>
                </div>
                <br>

            </div>
            <div class="col-md-6">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-box">
                    <form role="form" action="" method="post">
                        @csrf
                        <h3>General Info</h3>
                        <div class="form-group">
                            <label for="institiute_name"> Institute Name*</label>
                            <input type="text" name="name" class="form-control" id="institiute_name"
                                value="{{ old('name') ?? $institute->name }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="email">Login ID</label>
                            <input type="text" name="email" class="form-control" id="email"
                                value="{{ old('email') ?? $institute->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email ID</label>
                            <input type="text" name="email" class="form-control" id="email"
                                value="{{ old('email') ?? $institute->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="text" name="phone" class="form-control" id="mobile"
                                value="{{ old('phone') ?? $institute->phone }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" id="address" rows="3" disabled>{{ old('address') ?? $institute->address }}</textarea>
                            {{-- <input type="text" name="address" class="form-control" id="address"
              value="{{ old('address') ?? $institute->address }}" disabled> --}}
                        </div>
                        <div class="form-group">
                            <label>Institute ID</label>
                            <input type="text" name="" class="form-control" id="id"
                                value="{{ old('id') ?? $institute->id }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Total Enrollments</label>
                            <input type="text" name="" class="form-control" id="enrollments"
                                value="{{ count($institute->students ? $institute->students->toArray() : []) }}"
                                disabled>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div> <!-- container -->
@endsection
