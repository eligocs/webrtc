@extends('student.layouts.app')
@section('content')
    <style>
        .video-play-button.disabled:before {
            animation: none;
        }

        .video-play-button.disabled:after {
            background: #86799d !important;
        }
        i.fa.fa-eye {
    color: #644699;
}
    </style>
    <!-- Start Content-->
    <div class="container-fluid">
        {{ Breadcrumbs::render('enrollable_class', request()->category_id) }}
        <div class="row mx-0 card-box">
            <div class="col-md-12 mb-4">
                <h3 class="heading-title mt-0 mb-0 text-center heading">All Classes</h3>
                <form action="{{ route('student.inner_category') }}" style="float: right;">
                    <input type="text" class="form-control" id="class_input" name="class"
                        style="width: 200px;display: inline;" placeholder="Search for classes"
                        value="{{ $_GET['class'] ?? '' }}">
                    <input type="hidden" name="category_id" value="{{ request()->category_id }}">
                    <button class="text-right btn btn-theme">Search</button>
                    <button type="button" class="text-right btn btn-theme"
                        onclick="document.getElementById('class_input').value='';this.form.submit()">Reset</button>
                </form>
            </div>
            <p class=' '>
        <!--     @if(!empty($institute_d->description) && $institute_d->videoApproval == 1)
                {{ strlen($institute_d->description) > 120 ? substr($institute_d->description,0,120)."..." : $institute_d->description}}
                @if(strlen($institute_d->description) > 120)
                    <i class='fa fa-eye' data-toggle='tooltip' data-placement='top' title="{{$institute_d->description ?? ''}}"></i>
                @endif
            @endif</p>  --> 
            @if ($classes->count() > 0)
                @foreach ($classes as $institute_assigned_class)
                    <?php $institute_d = \App\Models\Institute::find($institute_assigned_class->institute_id); ?>
                    <div class="col-lg-4 col-6">
                        <div class="card box-shadow">
                            <div class="card-body">
                               <!--  @if (!empty($institute_assigned_class->institute->video) && @unserialize($institute_assigned_class->institute->video) == true && $institute_assigned_class->institute->videoApproval == 1)
                                    <h5 class="text-center theme-clr pl-1">Institute Demo</h5>
                                    <div class="view_demo">
                                        <?php $video = unserialize($institute_assigned_class->institute->video); ?>
                                        <a target='_blank' data-fan cybox
                                            class="video-play-button fa ncybox-gallery" rel="video-gallery"
                                            href="{{ $video[0] ?? '' }}">
                                            <span></span>
                                        </a>
                                        <div id="video-overlay" class="video-overlay">
                                            <a class="video-overlay-close">×</a>
                                        </div>
                                    </div> 
                                @endif  -->
                               <!--  <p class=' '>
                                @if(!empty($institute_d->description) && $institute_d->videoApproval == 1)
                                    {{ strlen($institute_d->description) > 120 ? substr($institute_d->description,0,120)."..." : $institute_d->description}}
                                    @if(strlen($institute_d->description) > 120)
                                        <i class='fa fa-eye' data-toggle='tooltip' data-placement='top' title="{{$institute_d->description ?? ''}}"></i>
                                    @endif
                                @endif</p>   -->
                                <div class="profile-statistics">
                                    <div class="text-center mt-2 border-bottom">
                                        <div class="my-4">
                                            <div class="btn-theme pl-2 pr-2 py-2 mr-0 mb-4">
                                                {{ $institute_assigned_class->name }}
                                                ({{ $institute_assigned_class->institute->name }})
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-blog pt-1 border-bottom pb-1 ">
                                    <h5 class="theme-clr justify-content-between  d-flex align-items-center">
                                        {{ $institute_assigned_class->language_table->name ?? '' }}<a
                                            href="javascript:void()"
                                            class="theme-clr pull-right f-s-16">{{ $institute_assigned_class->board ?? '' }}</a>
                                    </h5>
                                </div>
                                <div class="profile-blog pt-1 border-bottom pb-1 ">
                                    <h5
                                        class="theme-clr justify-content-between  d-flex align-items-center text-capitalize">
                                        {{ $institute_assigned_class->state ?? '' }}
                                        <span class="pull-right f-s-16">{{ $institute_assigned_class->city ?? '' }}</span>
                                    </h5>
                                </div>
                                <div class="profile-interest mt-2 pb-2 border-bottom">
                                    <div class="row mt-0">
                                        @if ($institute_assigned_class->institute_assigned_class_subject->count() > 0)
                                            @foreach ($institute_assigned_class->institute_assigned_class_subject as $subject)
                                                <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                                    <a href="{{ route('student.detail', [$subject->id]) }}"
                                                        class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">{{ $subject->subject->name ?? '' }}</a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="profile-videobox border-bottom position-relative">
                                    <div class="image-element1 border-bt-e6f3ff py-2">
                                        @if (!empty($institute_d->video) && @unserialize($institute_d->video) == true && $institute_d->videoApproval == 1)
                                            <h5 class="text-center theme-clr pl-1">Class Demo</h5>
                                            <div class="view_demo">
                                                <?php $video = unserialize($institute_d->video); ?>
                                                <a target='_blank' data-fan cybox
                                                    class="video-play-button fa ncybox-gallery" rel="video-gallery"
                                                    href="{{ $video[0] ?? '' }}">
                                                    <span></span>
                                                </a>
                                                <div id="video-overlay" class="video-overlay">
                                                    <a class="video-overlay-close">×</a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="view_demo">
                                                <a target='' data-fan cybox
                                                    class="video-play-button disabled fa ncybox-gallery" rel="video-gallery"
                                                    href="#">
                                                    <span></span>
                                                </a>
                                            </div>
                                        @endif

                                        {{-- <a data-fancybox class="video-play-button fancybox-gallery" rel="video-gallery" href="https://www.youtube.com/watch?v=iuimHfnP5aU&list=PLWx-A6wseQ6n-i692JSWuNvZcNTV-ULZu"> --}}
                                        <!-- @if (!empty($institute_assigned_class->video) && @unserialize($institute_assigned_class->video) == true)
    <?php $video = unserialize($institute_assigned_class->video); ?>
                                                                                        <a target='_blank' data-fan cybox
                                                                                            class="video-play-button fa ncybox-gallery" rel="video-gallery"
                                                                                            href="{{ $video[0] ?? '' }}">
                                                                                            <span></span>
                                                                                        </a>
    @endif -->

                                    </div>
                                   <!-- <p class='mb-2'> @if(!empty($institute_assigned_class->description) && $institute_assigned_class->videoApproval == 1)
                                        {{ strlen($institute_assigned_class->description) > 120 ? substr($institute_assigned_class->description,0,120)."..." : $institute_assigned_class->description}}
                                        @if(strlen($institute_assigned_class->description) > 120)
                                            <i class='fa fa-eye' data-toggle='tooltip' data-placement='top' title="{{$institute_assigned_class->description ?? ''}}"></i>
                                        @endif
                                    @endif</p> -->
                                </div>
                                <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                                    <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch
                                            Start</b>{{ date('d/m/Y', strtotime($institute_assigned_class->start_date)) }}
                                    </p>
                                    <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch
                                            End</b>{{ date('d/m/Y', strtotime($institute_assigned_class->end_date)) }}
                                    </p>
                                </div>
                                <div class="total text-center mt-lg-2 my-md-2 border-bottom">
                                    <p class="mt-0 mb-2">Enrollment Fee -
                                        {{ number_format($institute_assigned_class->price) }} INR
                                    </p>
                                </div>
                                <div class="total text-center mt-lg-3 my-md-3">
                                    @if (!\App\Models\InstituteAssignedClassStudent::where(['institute_assigned_class_id' => $institute_assigned_class->id, 'student_id' => auth()->user()->student_id])->exists())
                                        @csrf
                                        <button type="submit" id="enroll" class=" btn-theme btn-style enroll"
                                            data-id="{{ $institute_assigned_class->id }}">Enroll Now</button>
                                        @php
                                            $istried = \App\Models\StudentTrialPeriod::where('student_id', auth()->user()->student_id)
                                                ->where('class_id', $institute_assigned_class->id)
                                                ->first();
                                        @endphp
                                        @if (!empty($istried))
                                            <button class="btn-theme btn-style">Trial Used</button>
                                        @else
                                            @if ($institute_assigned_class->freetrial == 1)
                                                <button type="submit" id="freeTrial" class=" btn-theme btn-style freeTrial"
                                                    data-id="{{ $institute_assigned_class->id }}">Free Trial</button>
                                                <!-- <a href="{{ url('student/select_timingsfree' . '/' . $institute_assigned_class->id . '?free=true') }}" class="btn-theme btn-style freeTrial">Free Trial</a> -->
                                            @endif
                                        @endif
                                    @elseif(\App\Models\InstituteAssignedClassStudent::where(['institute_assigned_class_id' => $institute_assigned_class->id, 'student_id' => auth()->user()->student_id])->where('start_date', null)->exists())
                                        <h5 class="theme-clr justify-content-center  d-flex align-items-center">
                                            Enrolled</h5>
                                    @else
                                        <button type="submit" id="enroll" class=" btn-theme btn-style enroll"
                                            data-id="{{ $institute_assigned_class->id }}">Enroll Now</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- end row -->

    </div> <!-- container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.enroll').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // console.log(id);
                (async () => {

                    const {
                        value: Class
                    } = await Swal.fire({
                        title: 'Select Class Mode',
                        input: 'select',
                        inputOptions: {
                            // 'Mode of Class ': {
                            1: 'Live ',
                            2: 'Recorded',
                            // },
                        },
                        inputPlaceholder: 'Select Class Mode',
                        showCancelButton: true,
                    })
                    // console.log(Class);

                    if (Class) {
                        // Swal.fire(`You selected: ${Class}`)
                        window.location.href = "{{ url('student/select/timings') }}/" + id +
                            '/' +
                            Class;
                        // window.location = "{{ url('select-timings') }}/" + id;
                    }

                })()

            })

            $(".freeTrial").click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var free = 'true';
                // console.log(free);

                (async () => {

                    const {
                        value: Class
                    } = await Swal.fire({
                        title: 'Select Class Mode',
                        input: 'select',
                        inputOptions: {
                            // 'Mode of Class ': {
                            1: 'Live ',
                            2: 'Recorded',
                            // },
                        },
                        inputPlaceholder: 'Select Class Mode',
                        showCancelButton: true,
                    })
                    // console.log(Class);

                    if (Class) {
                        // Swal.fire(`You selected: ${Class}`)
                        // window.location.href = "{{ url('student/select/timingsfree') }}/" + id + '/' + Class + '/' + free ;
                        window.location.href = "{{ url('student/select/timingsfree') }}/" + id +
                            '/' +
                            Class + '/' + free;

                        // window.location = "{{ url('select-timings') }}/" + id;
                    }

                })()
                console.log("sdlajfk");
            })

        })
    </script>

@endsection
