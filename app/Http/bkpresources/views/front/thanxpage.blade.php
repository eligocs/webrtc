@extends('front.layouts.app')
@section('content')
    <style>
        .error {
            color: red;
        }

        .note {
            color: #ff5151;
            text-shadow: 2px 2px 2px black;
        }

        html {
            font-size: 16px;
            background-color: #fffffe;
        }

        #header {
            text-align: center;
        }

        .main-content {
            margin: 0 auto;
            max-width: 820px;
        }

        .main-content__checkmark {
            font-size: 4.0625rem;
            line-height: 1;
            color: #24b663;
        }

        .main-content__body {
            margin: 20px 0 0;
            font-size: 1rem;
            line-height: 1.4;
        }

    </style>
    <div class="inner-page-banner join_banner  mb-80">
        <div class="opacity">
            <h1>THANK YOU!</h1>
        </div> <!-- /.opacity -->
    </div> <!-- /inner-page-banner -->
    <header class="site-header" id="header">
        <h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
        <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
    </header>

    <div class="main-content">
        <p class="main-content__body" data-lead-id="main-content-body">Thanks a bunch for filling that out. It means a
            lot to us, just like you do! We really appreciate you giving us a moment of your time today. Thanks for
            being you.</p>
    </div>
@endsection
