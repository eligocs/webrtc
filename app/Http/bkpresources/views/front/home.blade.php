@extends('front.layouts.app')
@section('content')
<style>
  .error {
    color: red;
  }

  .profile-interest {
    min-height: 92px
  }
</style>
<!-- 
=============================================
    Theme Main Banner
============================================== 
-->

<div id="theme-main-banner" class="banner-two">
  <div data-src="{{ URL::to('assets/front/images/home/slide.jpg')}}">
    <div class="camera_caption banner_txt">
      <div class="container">
        <h1 class="wow fadeInUp animated">India’s First Online Tuition<br> Classes Platform</h1>
        <h5 class="wow fadeInUp animated mb-0" data-wow-delay="0.2s">The Perfect Study Room</h5>
        <h6 class="wow fadeInUp animated text-white">Class 1-10 / 11-12 / Enginnering / Medical /
          Commerce/ Arts /<br> Competitive Exam/ Enterance Exam</h6>
        <h6 class="font-13 text-white wow fadeInUp animated">Multiple Tuition Classes Available From
          India's Different Cities</h6>
        <a href="#" class=" mt-2 tran3s hvr-trim wow fadeInUp animated p-bg-color button-one" data-wow-delay="0.3s"
          onclick="$('.registerModal').modal('show')">JOIN A STUDYROOM<i class="fa fa-long-arrow-right ryt-arw"
            aria-hidden="true"></i></a>
      </div> <!-- /.container -->
    </div> <!-- /.camera_caption -->
  </div>
</div>
<!-- /#theme-main-banner -->



<!-- 
                =============================================
                    What We Do
                ============================================== 
                -->
<div class="what-we-do">
  <div class="container">
    <h4>About AVESTUD</h4>
    <p class="about-text text-center mt-4">The objective of AVESTUD is to provide
      excellent quality of online education to every Indian student at an affordable cost at their native
      place. AVESTUD is basically team of engineers and doctors who have worked hard and dedicatedly towards
      providing excellent online education. AVESTUD conducts multiple classes from different cities so that
      the student can choose as per his/her choice. The classes have excellent and knowledgeable teachers.
    </p>

    <div class="quote container ">
      <div class="text row d-flex text-center">
        <div class=" col-md-offset-2 col-md-7 col-md-offset-2 mx-auto">
          <div class="quote_para position-relative">
            <div class="left-quote">
              <img src="{{ URL::to('assets/front/images/quote.png')}}">
            </div>
            <h3 class=" text-center mb-0">Stay At Home Learn At Home</h3>
            <div class="about_logo"><img src="{{ URL::to('assets/front/images/logo-dark.png')}}" class="img-fluid">
            </div>
            <div class="right-quote">
              <img src="{{ URL::to('assets/front/images/quotation-mark.png')}}">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="company-seo-text remove-bar">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- <div class="theme-title-two">
                                            <h4 class="text-center"><span>Our Apps <strong>make</strong> learning more</span> <span>interesting and fun</span></h4>
                                        </div> -->
          </div>
          <div class="col-md-4">

            <img src="{{ URL::to('assets/front/images/online-classes.png')}}" alt="" class="p-3rem illustrtr">
            <h6 class="fnt-22px my-0 text-center">Multiple Tuition Classes</h6>

          </div>
          <div class="col-md-4">

            <img src="{{ URL::to('assets/front/images/illustrations/pdf-notes.png')}}" alt="" class="p-3rem illustrtr">
            <h6 class="fnt-22px my-0 text-center">Easily Available PDF notes</h6>

          </div>
          <div class="col-md-4 ">

            <img src="{{ URL::to('assets/front/images/illustrations/ask-doubts.png')}}" alt="" class="p-3rem illustrtr">
            <h6 class="fnt-22px my-0 text-center">Ask Doubts Easily</h6>

          </div>
        </div> <!-- /.row -->
      </div> <!-- /.container -->
    </div> <!-- /.company-seo-text -->
  </div> <!-- /.container -->
</div> <!-- /.what-we-do -->



<!-- 
                =============================================
                    More About Us
                ============================================== 
                -->
<div class="container-2">
  <div class="more-about-us">
    <!-- <div class="image-box left-0">
                        <svg  version="1.1" class="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="854" height="632">
                            <clipPath class="clip1">
                                <use xlink:href="#shape-one" />
                            </clipPath>
                            <g clip-path="url(#shape-one)">
                                <image width="854" height="632" href="images/sec-1.jpg')}}" class="image-shape">
                                </image>
                            </g>
                        </svg>
                    </div>
                    <div class="theme-shape-three left-0"></div> -->
    <div class="row d-flex">
      <div class="col-md-7">
        <div class="left-img">
          <img src="{{ URL::to('assets/front/images/img1.png')}}" class="img-fluid">
        </div>
      </div>
      <div class="col-md-5 ">
        <div class="main-content ">
          <h4>Attend The Classes Online, Track Your Academic Performance</h4>
          <div class="main-wrapper pl-0 pt-3">
            <p class="about-text mt-2 mb-0 pb-0">AVESTUD has incorporated classes from all over India on
              its platform. The accessibility has been further enhanced by personalized feedback
              to each and every student. With his/her own academic and education chart, the
              students work on their strengths and areas for improvement.</p>
            <p class="mt-0 mb-0">Online classes help you to attend the class at rest without any
              wastage of time.</p>
            <!-- <p>We provide marketing services to startups and small businesses to looking for a partner of their digital media, design &amp; dev, lead generation, and communications requirents. We work with you, not for you. Although we have great resources.</p> -->
            <ul class="abt-ul mt-4 ml-4m">
              <li>Parents can keep up with their children’s performance.</li>
              <li>Parents can know that how many classes the student has attended and how well is
                he doing.</li>
              <li>The performance chart helps the student to identify their strength and the areas
                for improvement.</li>
            </ul>
            <div class="button-wrapper">
              <!-- <span>Learn More</span> -->
              <a href="javascript:void(0)"
                class="mt-2 tran3s hvr-trim wow fadeInUp  p-bg-color button-one animated button-theme"
                data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"
                onclick="$('.registerModal').modal('show')">Join
                a Studyroom<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </div> <!-- /.button-wrapper -->
          </div> <!-- /.main-wrapper -->
        </div> <!-- /.main-content -->
      </div> <!-- /.col- -->
    </div> <!-- /.row -->
  </div> <!-- /.more-about-us -->


  <!-- 
                =============================================
                    More About Us 2
                ============================================== 
                -->
  <div class="more-about-us mt-6m ">
    <!-- <div class="image-box1   mt-4m right-73">
                        <svg  version="1.1" class="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="854" height="632">
                            <clipPath class="clip1">
                                <use xlink:href="#shape-one" />
                            </clipPath>
                            <g clip-path="url(#shape-one)">
                                <image width="854" height="632" href="images/home/2.jpg')}}" class="image-shape">
                                </image>
                            </g>
                        </svg>
                    </div>
                    <div class="theme-shape-three1 right-73"></div> -->
    <div class="row  d-flex flex-reverse">
      <div class="col-md-7">
        <div class="left-img">
          <img src="{{ URL::to('assets/front/images/img2.png')}}" class="img-fluid">
        </div>
      </div>
      <div class="col-md-5 col-lg-6">
        <div class="main-content  pt-4m pl-0">
          <h4>Revise Whenever You Want</h4>
          <div class="main-wrapper pt-3 pl-0">
            <p class="about-text mt-2 mb-0 pb-0">With immersive video lessons, student can study and
              visualize each concept in an easier to understand way, a complete understanding of
              scores leads to higher marks. The whole curriculum is mapped to the syllabus for
              different boards.</p>
            <!-- <p>We provide marketing services to startups and small businesses to looking for a partner of their digital media, design &amp; dev, lead generation, and communications requirents. We work with you, not for you. Although we have great resources.</p> -->
            <ul class="abt-ul mt-4 ml-4m">
              <!-- <li>Hundred plus classes from different cities.</li>
                                            <li>Students can choose any class with a plethora of choices available.</li> -->
              <li>All the lectures/classes are available on student’s fingertip.</li>
              <li>Students can revise any lecture/classes at any time throughout the semester.
              </li>
              <li>Students can review their old tests.</li>
              <li>Students can review their old assignments.</li>
            </ul>
            <div class="button-wrapper1">
              <!-- <span>Learn More</span> -->
              <a href="javascript:void(0)"
                class="mt-2 tran3s hvr-trim wow fadeInUp  p-bg-color button-one animated button-theme"
                data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"
                onclick="$('.registerModal').modal('show')">Join
                a Studyroom <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </div> <!-- /.button-wrapper -->
          </div> <!-- /.main-wrapper -->
        </div> <!-- /.main-content -->
      </div> <!-- /.col- -->
    </div> <!-- /.row -->
  </div> <!-- /.more-about-us -->
</div>
<!-- saas -->
<div class="container mb-6m">
  <h4 class="text-center pb-4rem">Explore Our Few Classes</h4>
  <div class="row overflow-scroll">
    <div class="col-md-4">
      <div class="card box-shadow">
        <div class="card-body">
          <div class="profile-statistics">
            <div class="text-center mt-2 border-bottom">
              <div class="my-4">
                <div class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">12th Standard</div>
              </div>
            </div>
          </div>
          <div class="profile-blog pt-1 border-bottom pb-1 ">
            <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
              Teaching Language <span>Board/University</span></h6>
            <h5 class="theme-clr justify-content-between mt-0  d-flex align-items-center" style="margin: 10px 0px;">
              Marathi + English<a href="javascript:void()" class="theme-clr pull-right f-s-16">CBSE</a> </h5>
          </div>
          <div class="profile-interest mt-2 pb-2 border-bottom">
            <div class="row mt-2">
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">English</a>
              </div>
              {{-- <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
              </div>
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
              </div>
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
              </div> --}}
            </div>
          </div>
          <div class="profile-videobox border-bottom position-relative">
            <div class="image-element1 border-bt-e6f3ff py-2">
              <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
              <div class="view_demo">
                <a id="play-video" class="video-play-button" href="#"
                  data-video-src="https://player.vimeo.com/video/460818528">
                  <span></span>
                </a>

                <div id="video-overlay" class="video-overlay">
                  <a class="video-overlay-close">×</a>
                </div>
              </div>
            </div>
          </div>
          <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
            <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>21/09/2021</p>
            <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>30/09/2021</p>
          </div>
          <div class="total text-center mt-lg-2 my-md-2 border-bottom">
            <p class="mt-0 mb-2">Enrollment Fee - 4,999 INR</p>
          </div>
          <div class="total text-center mt-lg-3 my-md-3">
            {{-- <a href="" class="btn-theme btn-style">View Details</a> --}}
            <a href="#" class="btn-theme btn-style" data-toggle="modal" data-target=".signUpModal">Enroll Now</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card box-shadow">
        <div class="card-body">
          <div class="profile-statistics">
            <div class="text-center mt-2 border-bottom">
              <div class="my-4">
                <div class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">12th Standard Science</div>
              </div>
            </div>
          </div>
          <div class="profile-blog pt-1 border-bottom pb-1 ">
            <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
              Teaching Language <span>Board/University</span></h6>
            <h5 class="theme-clr justify-content-between  d-flex align-items-center" style="margin: 10px 0px;">Marathi +
              English<a href="javascript:void()" class="theme-clr pull-right f-s-16">State Board</a> </h5>
          </div>

          <div class="profile-interest mt-2 pb-2 border-bottom">
            <div class="row mt-2">
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
              </div>
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
              </div>
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
              </div>
              {{-- <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white"></a>
              </div> --}}
            </div>
          </div>
          <div class="profile-videobox border-bottom position-relative">
            <div class="image-element1 border-bt-e6f3ff py-2">
              <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
              <div class="view_demo">

                <a id="play-video" class="video-play-button" href="#"
                  data-video-src="https://player.vimeo.com/video/460818609">
                  <span></span>
                </a>

                <div id="video-overlay" class="video-overlay">
                  <a class="video-overlay-close">×</a>
                </div>
              </div>
            </div>
          </div>
          <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
            <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>21/09/2021</p>
            <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>30/09/2021</p>
          </div>
          <div class="total text-center mt-lg-2 my-md-2 border-bottom">
            <p class="mt-0 mb-2">Enrollment Fee - 13,000 INR</p>
          </div>
          <div class="total text-center mt-lg-3 my-md-3">
            {{-- <a href="" class="btn-theme btn-style">View Details</a> --}}
            <a href="#" class="btn-theme btn-style" data-toggle="modal" data-target=".signUpModal">Enroll Now</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card box-shadow">
        <div class="card-body">
          <div class="profile-statistics">
            <div class="text-center mt-2 border-bottom">
              <div class="my-4">
                <div class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">11th Standard Science</div>
              </div>
            </div>
          </div>
          <div class="profile-blog pt-1 border-bottom pb-1 ">
            <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
              Teaching Language <span>Board/University</span></h6>
            <h5 class="theme-clr justify-content-between  d-flex align-items-center" style="margin: 10px 0px;">Hindi +
              English<a href="javascript:void()" class="theme-clr pull-right f-s-16">State Board</a> </h5>
          </div>

          <div class="profile-interest mt-2 pb-2 border-bottom">
            <div class="row mt-2">
              {{-- <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Math</a>
              </div>
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
              </div>
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
              </div> --}}
              <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                <a href="javascript:void(0)"
                  class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
              </div>
            </div>
          </div>
          <div class="profile-videobox border-bottom position-relative">
            <div class="image-element1 border-bt-e6f3ff py-2">
              <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
              <div class="view_demo">
                <a id="play-video" class="video-play-button" href="#"
                  data-video-src="https://player.vimeo.com/video/460818809">
                  <span></span>
                </a>

                <div id="video-overlay" class="video-overlay">
                  <a class="video-overlay-close">×</a>
                </div>
              </div>
            </div>
          </div>
          <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
            <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>21/09/2021</p>
            <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>30/11/2021</p>
          </div>
          <div class="total text-center mt-lg-2 my-md-2 border-bottom">
            <p class="mt-0 mb-2">Enrollment Fee - 4,999 INR</p>
          </div>
          <div class="total text-center mt-lg-3 my-md-3">
            {{-- <a href="" class="btn-theme btn-style">View Details</a> --}}
            <a href="#" class="btn-theme btn-style" data-toggle="modal" data-target=".signUpModal">Enroll Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="row overflow-scroll">
        <div class="col-md-4">
            <div class="card box-shadow">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom">
                            <div class="my-4">
                                <span class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">6th Grade</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
                            Teaching Language <span>Board/University</span></h6>
                        <h5 class="theme-clr justify-content-between  d-flex align-items-center"
                            style="margin: 10px 0px;">Hindi<a href="javascript:void()"
                                class="theme-clr pull-right f-s-16">CBSE</a> </h5>
                    </div>

                    <div class="profile-interest mt-2 pb-2 border-bottom">
                        <div class="row mt-2">
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Math</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-videobox border-bottom position-relative">
                        <div class="image-element1 border-bt-e6f3ff py-2">
                            <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
                            <div class="view_demo">
                                <a id="play-video" class="video-play-button" href="#">
                                    <span></span>
                                </a>

                                <div id="video-overlay" class="video-overlay">
                                    <a class="video-overlay-close">×</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                        <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>25/01/2020</p>
                        <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>25/01/2020</p>
                    </div>
                    <div class="total text-center mt-lg-2 my-md-2 border-bottom">
                        <p class="mt-0 mb-2">Enrollment Fee - 4,500 INR</p>
                    </div>
                    <div class="total text-center mt-lg-3 my-md-3">
                        <a href="" class="btn-theme btn-style">View Details</a>
                        <a href="" class="btn-theme btn-style">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card box-shadow">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom">
                            <div class="my-4">
                                <span class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">6th Grade</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
                            Teaching Language <span>Board/University</span></h6>
                        <h5 class="theme-clr justify-content-between  d-flex align-items-center"
                            style="margin: 10px 0px;">Hindi<a href="javascript:void()"
                                class="theme-clr pull-right f-s-16">CBSE</a> </h5>
                    </div>

                    <div class="profile-interest mt-2 pb-2 border-bottom">
                        <div class="row mt-2">
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Math</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-videobox border-bottom position-relative">
                        <div class="image-element1 border-bt-e6f3ff py-2">
                            <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
                            <div class="view_demo">
                                <a id="play-video" class="video-play-button" href="#">
                                    <span></span>
                                </a>

                                <div id="video-overlay" class="video-overlay">
                                    <a class="video-overlay-close">×</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                        <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>25/01/2020</p>
                        <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>25/01/2020</p>
                    </div>
                    <div class="total text-center mt-lg-2 my-md-2 border-bottom">
                        <p class="mt-0 mb-2">Enrollment Fee - 4,500 INR</p>
                    </div>
                    <div class="total text-center mt-lg-3 my-md-3">
                        <a href="" class="btn-theme btn-style">View Details</a>
                        <a href="" class="btn-theme btn-style">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card box-shadow">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom"> 
                            <div class="my-4">
                                <span class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">6th Grade</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
                            Teaching Language <span>Board/University</span></h6>
                        <h5 class="theme-clr justify-content-between  d-flex align-items-center"
                            style="margin: 10px 0px;">Hindi<a href="javascript:void()"
                                class="theme-clr pull-right f-s-16">CBSE</a> </h5>
                    </div>

                    <div class="profile-interest mt-2 pb-2 border-bottom">
                        <div class="row mt-2">
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Math</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-videobox border-bottom position-relative">
                        <div class="image-element1 border-bt-e6f3ff py-2">
                            <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
                            <div class="view_demo">
                                <a id="play-video" class="video-play-button" href="#">
                                    <span></span>
                                </a>

                                <div id="video-overlay" class="video-overlay">
                                    <a class="video-overlay-close">×</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                        <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>25/01/2020</p>
                        <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>25/01/2020</p>
                    </div>
                    <div class="total text-center mt-lg-2 my-md-2 border-bottom">
                        <p class="mt-0 mb-2">Enrollment Fee - 4,500 INR</p>
                    </div>
                    <div class="total text-center mt-lg-3 my-md-3">
                        <a href="" class="btn-theme btn-style">View Details</a>
                        <a href="" class="btn-theme btn-style">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row overflow-scroll">
        <div class="col-md-4">
            <div class="card box-shadow">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom">
                            <div class="my-4">
                                <span class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">6th Grade</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
                            Teaching Language <span>Board/University</span></h6>
                        <h5 class="theme-clr justify-content-between  d-flex align-items-center"
                            style="margin: 10px 0px;">Hindi<a href="javascript:void()"
                                class="theme-clr pull-right f-s-16">CBSE</a> </h5>
                    </div>

                    <div class="profile-interest mt-2 pb-2 border-bottom">
                        <div class="row mt-2">
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Math</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-videobox border-bottom position-relative">
                        <div class="image-element1 border-bt-e6f3ff py-2">
                            <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
                            <div class="view_demo">
                                <a id="play-video" class="video-play-button" href="#">
                                    <span></span>
                                </a>

                                <div id="video-overlay" class="video-overlay">
                                    <a class="video-overlay-close">×</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                        <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>25/01/2020</p>
                        <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>25/01/2020</p>
                    </div>
                    <div class="total text-center mt-lg-2 my-md-2 border-bottom">
                        <p class="mt-0 mb-2">Enrollment Fee - 4,500 INR</p>
                    </div>
                    <div class="total text-center mt-lg-3 my-md-3">
                        <a href="" class="btn-theme btn-style">View Details</a>
                        <a href="" class="btn-theme btn-style">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card box-shadow">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom">
                            <div class="my-4">
                                <span class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">6th Grade</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
                            Teaching Language <span>Board/University</span></h6>
                        <h5 class="theme-clr justify-content-between  d-flex align-items-center"
                            style="margin: 10px 0px;">Hindi<a href="javascript:void()"
                                class="theme-clr pull-right f-s-16">CBSE</a> </h5>
                    </div>

                    <div class="profile-interest mt-2 pb-2 border-bottom">
                        <div class="row mt-2">
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Math</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-videobox border-bottom position-relative">
                        <div class="image-element1 border-bt-e6f3ff py-2">
                            <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
                            <div class="view_demo">
                                <a id="play-video" class="video-play-button" href="#">
                                    <span></span>
                                </a>

                                <div id="video-overlay" class="video-overlay">
                                    <a class="video-overlay-close">×</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                        <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>25/01/2020</p>
                        <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>25/01/2020</p>
                    </div>
                    <div class="total text-center mt-lg-2 my-md-2 border-bottom">
                        <p class="mt-0 mb-2">Enrollment Fee - 4,500 INR</p>
                    </div>
                    <div class="total text-center mt-lg-3 my-md-3">
                        <a href="" class="btn-theme btn-style">View Details</a>
                        <a href="" class="btn-theme btn-style">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card box-shadow">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-2 border-bottom">
                            <div class="my-4">
                                <span class="btn-theme pl-5 pr-5 py-2 mr-0 mb-4">6th Grade</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-blog pt-1 border-bottom pb-1 ">
                        <h6 class="Language theme-clr justify-content-between  d-flex align-items-center">
                            Teaching Language <span>Board/University</span></h6>
                        <h5 class="theme-clr justify-content-between  d-flex align-items-center"
                            style="margin: 10px 0px;">Hindi<a href="javascript:void()"
                                class="theme-clr pull-right f-s-16">CBSE</a> </h5>
                    </div>

                    <div class="profile-interest mt-2 pb-2 border-bottom">
                        <div class="row mt-2">
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Math</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Physics</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Chemistry</a>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-sm-6 col-6 int-col">
                                <a href="javascript:void(0)"
                                    class="btn btn-theme my-1 w-100 waves-effect waves-light cursor-default text-white">Biology</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-videobox border-bottom position-relative">
                        <div class="image-element1 border-bt-e6f3ff py-2">
                            <h5 class="text-center theme-clr pl-1">View Class Demo</h5>
                            <div class="view_demo">
                                <a id="play-video" class="video-play-button" href="#">
                                    <span></span>
                                </a>

                                <div id="video-overlay" class="video-overlay">
                                    <a class="video-overlay-close">×</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="batch_date d-flex justify-content-between my-2 pb-2 border-bottom">
                        <p class="font-small text-dark mb-0 d-flex flex-column"><b>Batch Start</b>25/01/2020</p>
                        <p class="font-small text-dark  d-flex flex-column mb-0"><b>Batch End</b>25/01/2020</p>
                    </div>
                    <div class="total text-center mt-lg-2 my-md-2 border-bottom">
                        <p class="mt-0 mb-2">Enrollment Fee - 4,500 INR</p>
                    </div>
                    <div class="total text-center mt-lg-3 my-md-3">
                        <a href="" class="btn-theme btn-style">View Details</a>
                        <a href="" class="btn-theme btn-style">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
<!-- 
                =============================================
                    More About Us 3
                ============================================== 
                -->
<div class="container-2">
  <div class="more-about-us mt-0">
    <!-- <div class="image-box left-0">
                        <svg  version="1.1" class="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="854" height="632">
                            <clipPath class="clip1">
                                <use xlink:href="#shape-one" />
                            </clipPath>
                            <g clip-path="url(#shape-one)">
                                <image width="854" height="632" href="images/sec-2.jpg')}}" class="image-shape">
                                </image>
                            </g>
                        </svg>
                    </div>
                    <div class="theme-shape-three left-0"></div> -->
    <div class="row d-flex">
      <div class="col-md-7">
        <div class="left-img">
          <img src="{{ URL::to('assets/front/images/img3.png')}}" class="img-fluid">
        </div>
      </div>
      <div class="col-md-5">
        <div class="main-content pt-3m ">
          <h4>Quality And Affordable Education</h4>
          <div class="main-wrapper pt-3 pl-0">
            <p class="about-text mt-2 mb-0 pb-0">With technology enabled classes to get the best
              learning practices, we have immensely cut down the costs that parents incur on their
              children education. We provide the education of premier quality at much lower cost.
            </p>
            <ul class="abt-ul mt-4 ml-4m">
              <li>The classes chosen by AVESTUD are of the highest standards with professional
                teachers.</li>
              <li>Parents spend more than 50% of their earning for their children’s education.
              </li>
              <li>The motive of AVESTUD is to educate every Indian student at very low cost.</li>
              <!-- <li>Parents leave their native place for educating their children, AVESTUD brings the
                classes to their doorstep.</li> -->
            </ul>
            <div class="button-wrapper">
              <!-- <span>Learn More</span> -->
              <a href="javascript:void(0)"
                class="mt-2 tran3s hvr-trim wow fadeInUp  p-bg-color button-one animated button-theme"
                data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"
                onclick="$('.registerModal').modal('show')">Join
                a Studyroom <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </div> <!-- /.button-wrapper -->
          </div> <!-- /.main-wrapper -->
        </div> <!-- /.main-content -->
      </div> <!-- /.col- -->
    </div> <!-- /.row -->
  </div> <!-- /.more-about-us -->

  <!-- 
                =============================================
                    More About Us 4
                ============================================== 
                -->
  <div class="more-about-us mt-0  ">
    <!-- <div class="image-box1 right-73 ">
                        <svg  version="1.1" class="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="854" height="632">
                            <clipPath class="clip1">
                                <use xlink:href="#shape-one" />
                            </clipPath>
                            <g clip-path="url(#shape-one)">
                                <image width="854" height="632" href="images/sec-3.jpg')}}" class="image-shape">
                                </image>
                            </g>
                        </svg>
                    </div>
                    <div class="theme-shape-three1 right-73"></div> -->

    <div class="d-flex flex-reverse">
      <div class="col-md-7">
        <div class="left-img">
          <img src="{{ URL::to('assets/front/images/img4.png')}}" class="img-fluid">
        </div>
      </div>
      <div class="col-md-5 ">
        <div class="main-content  pl-0">
          <h4>Best Teachers With State-Of-The-Art Technology</h4>
          <div class="main-wrapper pt-3 pl-0">
            <p class="about-text mt-2 mb-0 pb-0">We aim to provide an overall learning experience
              for our students. Students from all over India can have the access to the best
              teachers and understand concepts with a real-life application. We use best practices
              for students like videos and engaging content. We take care that every child in
              India understands his/her concepts very clearly.</p>
            <!-- <p>We provide marketing services to startups and small businesses to looking for a partner of their digital media, design &amp; dev, lead generation, and communications requirents. We work with you, not for you. Although we have great resources.</p> -->
            <ul class="abt-ul mt-4 ml-4m">
              <li>Easy to understand and accessible classes.</li>
              <li>Personalized feedback for every student with the power of analytics.</li>
              <li>Fast quick loading modules and easily accessible syllabus.</li>
              <li>Mobile optimized with quick optimizations.</li>
            </ul>
            <div class="button-wrapper1 ">
              <!-- <span>Learn More</span> -->
              <a href="javascript:void(0)"
                class="mt-2 tran3s hvr-trim wow fadeInUp  p-bg-color button-one animated button-theme"
                data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"
                onclick="$('.registerModal').modal('show')">Join
                a Studyroom <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </div> <!-- /.button-wrapper -->
          </div> <!-- /.main-wrapper -->
        </div> <!-- /.main-content -->
      </div> <!-- /.col- -->
    </div> <!-- /.row -->
  </div> <!-- /.more-about-us -->


  <!-- 
                =============================================
                    More About Us 5
                ============================================== 
                -->
  <div class="more-about-us">
    <!-- <div class="image-box mt-0 left-0">
                        <svg  version="1.1" class="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="854" height="632">
                            <clipPath class="clip1">
                                <use xlink:href="#shape-one" />
                            </clipPath>
                            <g clip-path="url(#shape-one)">
                                <image width="854" height="632" href="images/home/17.jpg')}}" class="image-shape">
                                </image>
                            </g>
                        </svg>
                    </div>
                    <div class="theme-shape-three left-0"></div> -->

    <div class="row d-flex">
      <div class="col-md-7">
        <div class="left-img">
          <img src="{{ URL::to('assets/front/images/img5.png')}}" class="img-fluid">
        </div>
      </div>
      <div class="col-md-5 ">
        <div class="main-content  pt-4m">
          <h4>Multiple Classes and Far From Me</h4>
          <div class="main-wrapper pt-3 pl-0">
            <p class="about-text mt-2 mb-0 pb-0">As quality education is not available in every
              state and city in India. AVESTUD is bridging that gap by providing you with quality
              education while sitting at home, staying with your parents. Students don't need to
              travel to cities far from their loved ones for quality education.</p>
            <!-- <p>We provide marketing services to startups and small businesses to looking for a partner of their digital media, design &amp; dev, lead generation, and communications requirents. We work with you, not for you. Although we have great resources.</p> -->
            <ul class="abt-ul mt-4 ml-4m">
              <li>Hundred plus classes from different cities.</li>
              <li>Students can choose any class with a plethora of choices available.</li>
              <li>Parents leave their native place for educating their children, AVESTUD brings the
                classes to their doorstep.</li>
              <li>The class you can put in your pocket that is far from you.</li>
            </ul>
            <div class="button-wrapper">
              <!-- <span>Learn More</span> -->
              <a href="javascript:void(0)"
                class="mt-2 tran3s hvr-trim wow fadeInUp  p-bg-color button-one animated button-theme"
                data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"
                onclick="$('.registerModal').modal('show')">Join
                a Studyroom <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </div> <!-- /.button-wrapper -->
          </div> <!-- /.main-wrapper -->
        </div> <!-- /.main-content -->
      </div> <!-- /.col- -->
    </div> <!-- /.row -->

  </div> <!-- /.more-about-us -->
  <!-- saas -->
</div>
<!---end container-->
<!-- 
                =============================================
                    Theme Counter
                ============================================== 
                -->
<!-- explore -->

<!-- 
                    =============================================
                        Pricing Plan Style One
                    ============================================== 
                    -->
<div class="pricing-plan-one pt-125px">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12 wow fadeInRight">
        <div class="tab-content">
          <div id="monthly" class="tab-pane fade in active">
            <div class="clearfix">
              <div class="float-left  coming_sctn">
                <span class="cmng-soon">Coming Soon</span>
                <h6 class="fnt-18px">Download Mobile Application</h6>
              </div> <!-- /.left-side -->
              <div class="float-left dwnld_sctn">
                <div class="d-flex mb-res">
                  <img src="{{ URL::to('assets/front/images/appstore.png')}}" class="mr-10">
                  <img src="{{ URL::to('assets/front/images/google_play.png')}}" class="w-100m">
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
</div> <!-- /.pricing-plan-one -->
</div> <!-- /.two-section-wrapper -->

<!-- 
=============================================
    Home Blog Section
============================================== 
-->
@endsection