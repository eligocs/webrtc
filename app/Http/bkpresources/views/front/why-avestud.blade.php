@extends('front.layouts.app')
@section('title', '')
<div id="theme-main-banner" class="banner-two  camera_wrap" style="display: block; height: 895px;">

  <div data-src="{{ URL::to('assets/front/images/home/slide-4.jpg') }}">
    <div class="camera_caption banner_txt">
      <div class="container">
        <h1 class="wow fadeInUp animated">Why AVESTUD is perfect for<br> your Career.</h1>
        <h6 class="wow fadeInUp animated text-white mb-3">There are no secrets to success but AVESTUD can make studies
          easier for a student by<br> providing him/her with the best study material.</h6>
        <a href="javascript:void(0)" class=" mt-2 tran3s hvr-trim wow fadeInUp animated p-bg-color button-one"
          data-wow-delay="0.3s" onclick="$('.registerModal').modal('show')">JOIN A STUDYROOM <i
            class="fa fa-long-arrow-right ryt-arw" aria-hidden="true"></i></a>
      </div> <!-- /.container -->
    </div> <!-- /.camera_caption -->
  </div>
  <div class="camera_loader" style="display: block;"></div>
</div>
<div class="what-we-do-styletwo pt-52" id="about-AVESTUD">
  <div class="container">
    <h4 class="text-center">Why should you <span style="color: #644699;">choose AVESTUD</span></h4>
    <p class="pt-52 text-justify lh-4rem">AVESTUD is founded by engineers and doctors who understand the struggle of
      every
      child sitting in every corner of the country. Quality education is a need and AVESTUD full-fills it with its
      cutting
      edge technology and pocket friendly fee structure.</p>
  </div> <!-- /.container -->
</div>
<div class="company-seo-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="theme-title-two">
          <h4 class="text-center"><span>Our Apps <strong>make</strong> learning more</span> <span>interesting and
              fun</span></h4>
        </div>
      </div>
      <div class="col-md-4 pt-52">

        <img src="{{ URL::to('assets/front/images/screen1.jpg') }}" alt="" class="p-3rem">
        <h6 class="fnt-22px my-0">100+ Online Classes </h6>
        <p class="text-center mt-20">For classes 1-12,and all types of competitive exams.</p>

      </div>
      <div class="col-md-4 pt-52">

        <img src="{{ URL::to('assets/front/images/screen3.jpg') }}" alt="" class="p-3rem">
        <h6 class="fnt-22px my-0">The Perfect Study Room</h6>
        <p class="text-center mt-20">Learn from the comfort of your home through the best teachers of India.</p>

      </div>
      <div class="col-md-4 pt-52">

        <img src="{{ URL::to('assets/front/images/screen2.jpg') }}" alt="" class="p-3rem">
        <h6 class="fnt-22px my-0">Performance reporting</h6>
        <p class="text-center mt-20">Check your performance over time through data analytics and spot the areas to work
          upon.</p>

      </div>
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div>
<div class="short-banner">
  <div class="opacity">
    <div class="container">
      <h2>We are making quality education accessible <br>in the entire India.</h2>
    </div> <!-- /.container -->
  </div> <!-- /.opacity -->
</div>
<div class="business-statics">
  
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-push-6">
        <div class="main-content">
          <div class="theme-title-two">
            <h6>AVESTUD Statics</h6>
            <h4><span>AVESTUD provides <strong>you with </strong> </span> <br> <span> your performance analytics.</span>
            </h4>
          </div>
          <div class="main-wrapper">
            <p class="text-justify lh-4rem">AVESTUD calculates your performance in each tests and provide you with a
              graphical view of your performace, so you can easily compare and work on the topics and subjects where you
              are weak.</p>

          </div> <!-- /.main-wrapper -->
        </div> <!-- /.main-content -->
      </div> <!-- /.col- -->

      <div class="col-md-6 col-md-pull-6">
        <img src="{{ URL::to('assets/front/images/home/chart2.png') }}" alt="" id="chart">
      </div>
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div>
<div class="container">
  <div class="row">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs w-100 pl-15px d-flex justify-space-between" role="tablist">
      <li role="presentation" class="active presentation onlne"><a href="#home" aria-controls="home" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/Online_Classes.png') }}"
            style="width: 70px; height:62px;" class="mx-auto"><br>
          AVESTUD Online Classes</a></li>
      <li role="presentation " class="presentation quality"><a href="#profile" aria-controls="profile" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/classes1.png') }}"
            style="width: 70px; height:62px; transform: rotate(34deg);" class="mx-auto"><br> 100+ Quality Classes</a>
      </li>
      <li role="presentation" class="presentation revise"><a href="#messages" aria-controls="messages" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/Revise-when-you-want.png') }}"
            style="width: 70px; height:62px; transform: rotate(-13deg);" class="mx-auto"><br>Revise when you want</a>
      </li>
      <li role="presentation" class="presentation cost"><a href="#settings" aria-controls="settings" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/Quality-and-Cost-Effect.png') }}"
            style="width: 70px; height:62px;transform: rotate(17deg);" class="mx-auto"><br> Quality and Cost Effect</a>
      </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content"
      style="box-shadow: 6px 18px 50px 13px rgba(157,172,193,0.25);background: #fff; padding: 53px 0 0 50px; margin-bottom: 150px;">
      <div role="tabpanel" class="tab-pane in fade active" style="padding: 0px 0 0 50px; padding-bottom: 16rem;"
        id="home">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/online-classes.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">AVESTUD Online Classes</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">Online classes help you to attend the class at rest room
              without wasting of time. The class you can put in your pocket that is far from you.</p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="profile">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/classes2.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">100+ Quality Classes</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">Hundred plus classes from different cities. Student can
              choose any class just like pickup best book from library.</p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="messages">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/revise-whn-u-wnt.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">Revise when you want</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">All the lectures/classes available on student’s finger
              tip. Student can revise any lecture/classes at any time. It’s available on throughout the semester.</p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="settings">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/cost.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">Quality and Cost Effect</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">The classes choose by AVESTUD that is excellent and
              Teachers
              are expert in their work. Parents spends more than 50% earning to child education. The motive of AVESTUD
              to
              educate every Indian student at very low cost.</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs w-100 pl-15px d-flex justify-space-between" style=";" role="tablist">
      <li role="presentation" class="active presentation onlne"><a href="#home2" aria-controls="home2" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/4.png') }}" style=" height:62px;"
            class="mx-auto"><br> Multiple best
          classes</a></li>
      <li role="presentation " class="presentation quality"><a href="#profile2" aria-controls="profile2" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/3.png') }}"
            style="height:62px; transform: rotate(34deg);" class="mx-auto"><br> Academic and performance chart</a></li>
      <li role="presentation" class="presentation revise"><a href="#messages2" aria-controls="messages2" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/5.png') }}"
            style=" height:62px; transform: rotate(-13deg);" class="mx-auto"><br>Far from me</a></li>
      <li role="presentation" class="presentation cost"><a href="#settings2" aria-controls="settings2" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/2.png') }}"
            style=" height:62px;transform: rotate(17deg);" class="mx-auto"><br> All in one</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content"
      style="box-shadow: 6px 18px 50px 13px rgba(157,172,193,0.25);background: #fff; padding: 53px 0 0 50px; margin-bottom: 150px;">
      <div role="tabpanel" class="tab-pane in fade active" style="padding: 0px 0 0 50px; padding-bottom: 16rem;"
        id="home2">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/multiple-classes.png') }}" style="float: right;">
          </li>
          <li class="presentation">
            <h4><a href="#">Multiple best classes</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">With immersive video lessons, student can study and
              visualize each concept in an easier to understand way, a complete understanding of scores leads to higher
              marks. The whole curriculum is mapped to the syllabus for different boards.</p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="profile2">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/performance-chart.png') }}" style="float: right;">
          </li>
          <li class="presentation">
            <h4><a href="#">Academic and performance chart</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">With his/her own academic and education chart, the
              students work on their strengths and areas for improvement. </p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="messages2">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/far-from-me.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">Far from me</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">Parents leave their native place for educating their
              children, AVESTUD brings the classes to their doorstep. The motive of AVESTUD is to educate every Indian
              student
              at very low cost.</p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="settings2">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/all-in-one.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">All in one</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">Easy to understand and accessible classes. Personalized
              feedback for every student with the power of analytics. Fast quick loading modules and easily accessible
              syllabus.</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs w-100 pl-15px d-flex justify-space-between" style=";" role="tablist">
      <li role="presentation" class="active presentation onlne"><a href="#home3" aria-controls="home3" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/8.png') }}" style="height:62px;"
            class="mx-auto"><br> Online objective
          test</a></li>
      <li role="presentation " class="presentation quality"><a href="#profile3" aria-controls="profile3" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/1.png') }}"
            style="height:62px; transform: rotate(34deg);" class="mx-auto"><br>Expert instructors</a></li>
      <li role="presentation" class="presentation revise"><a href="#messages3" aria-controls="messages3" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/7.png') }}"
            style="height:62px; transform: rotate(-13deg);" class="mx-auto"><br>PDF notes</a></li>
      <li role="presentation" class="presentation cost"><a href="#settings3" aria-controls="settings3" role="tab"
          data-toggle="tab"><img src="{{ URL::to('assets/front/images/icons/6.png') }}"
            style=" height:62px;transform: rotate(17deg);" class="mx-auto"><br> Ask doubts</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content"
      style="box-shadow: 6px 18px 50px 13px rgba(157,172,193,0.25);background: #fff; padding: 53px 0 0 50px; margin-bottom: 150px;">
      <div role="tabpanel" class="tab-pane in fade active" style="padding: 0px 0 0 50px; padding-bottom: 16rem;"
        id="home3">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/online-objective-test.png') }}"
              style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">Online objective test</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">MCQs are a great way to learn and practice. With ample of
              MCQ tests, AVESTUD helps students to retain whatever they have learnt in their course.</p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="profile3">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/expert-instructors.png') }}"
              style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">Expert instructors</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">The teachers at AVESTUD are screened and selected based
              on
              extensive evolution, these teachers have easy and understanding ways of imparting concepts.</p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="messages3">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/pdf-notes.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">PDF notes</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">PDF notes are a great way to revise on the go, you can
              print all that you’ve studied and have accessible knowledge with detailed explanation in the form of
              videos. </p>
          </li>
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane fade " style="padding: 0px 0 0 50px; padding-bottom: 16rem;" id="settings3">
        <ul class="media-res">
          <li><img src="{{ URL::to('assets/front/images/illustrations/ask-doubts.png') }}" style="float: right;"></li>
          <li class="presentation">
            <h4><a href="#">Ask doubts</a></h4>
            <p class="text w-70per" style="padding-top: 20px;">Education has always been two-way communication and we
              intend to keep it that way, with our professors available to answer doubts that the students usually have.
            </p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="pricing-plan-one pt-125px">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12 wow fadeInRight" style="visibility: hidden; animation-name: none;">
        <div class="tab-content">
          <div id="monthly" class="tab-pane fade in active">
            <div class="clearfix">
              <div class="float-left  coming_sctn">
                <span class="cmng-soon">Coming Soon</span>
                <h6 class="fnt-18px">Download Mobile Application</h6>
              </div> <!-- /.left-side -->
              <div class="float-left dwnld_sctn">
                <div class="d-flex mb-res">
                  <img src="{{ URL::to('assets/front/images/appstore.png') }}" class="mr-10">
                  <img src="{{ URL::to('assets/front/images/google_play.png') }}" class="w-100m">
                </div>
              </div> <!-- /.right-side -->
            </div>
          </div> <!-- /#monthly -->
          <div id="yearly" class="tab-pane fade">
            <div class="clearfix">
              <div class="float-left left-side">
                <span><sub>$</sub>296.<sup>99</sup></span>
                <h6>Business</h6>
              </div> <!-- /.left-side -->
              <div class="right-side float-left">

              </div> <!-- /.right-side -->
            </div>
          </div> <!-- /#yearly -->
        </div>
      </div>
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div>
@section('content')
@endsection
@push('js')
@endpush