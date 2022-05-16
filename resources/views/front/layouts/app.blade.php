<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- For IE -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- For Resposive Device -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- For Window Tab Color -->
  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#2c2c2c">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#2c2c2c">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-status-bar-style" content="#2c2c2c">
  <title>AVESTUD - The Perfect Studyroom </title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="56x56" href="{{URL::to('assets/front/images/fav-icon/fevicon.png')}}">
  <!-- Main style sheet -->
  <link rel="stylesheet" type="text/css" href="{{URL::to('assets/front/css/style.css')}}">
  <!-- responsive style sheet -->
  <link rel="stylesheet" type="text/css" href="{{URL::to('assets/front/css/responsive.css')}}">
  <!-- Google Tag Manager -->
  <script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-NHTZVWT');
  </script>
  <!-- End Google Tag Manager -->
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NHTZVWT" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div class="main-page-wrapper">

    <!-- ===================================================
				Loading Transition
			==================================================== -->
    <div id="loader-wrapper">
      <div id="loader">
        <ul>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
    </div>


    @include('front.layouts.header')

    @yield('content')

    @include('front.layouts.footer')
    @stack('js')
</body>

</html>