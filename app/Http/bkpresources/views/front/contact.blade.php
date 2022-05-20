@extends('front.layouts.static-pages-app')
@section('title', '')

@section('content')
<section class="contact-block admission_inner mt-3m">
  <div class="container">
    <header class="seperator-head text-center">
      <h2>Contact Details</h2>
      <p>Welcome to our Website. We are glad to have you around.</p>
    </header>
    <div class="row mt-4  what-we-do">
      <div class="col-xs-12 col-sm-4">
        <!-- detail column -->
        <div class="detail-column">
          <span class="icn-wrap no-shrink element-block">
            <i class="fa fa-mobile" aria-hidden="true"></i>
          </span>
          <div class="descr-wrap">
            <h5 class="text-uppercase">give us a call</h5>
            <p><a href="tel:+919011264797">+919011264797</a>, <a href="tel:+917507725600">+917507725600</a>,<a
                href="tel:+918600123122">+918600123122</a></p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <!-- detail column -->
        <div class="detail-column">
          <span class="icn-wrap no-shrink element-block">
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
          </span>
          <div class="descr-wrap">
            <h5 class="text-uppercase">send us a message</h5>
            <p><a href="mailto:support@avestud.com">support@avestud.com </a></p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <!-- detail column -->
        <div class="detail-column">
          <span class="icn-wrap no-shrink element-block">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
          </span>
          <div class="descr-wrap">
            <h5 class="text-uppercase">visit our location</h5>
            <p>BULDHANA, Maharashtra, India, 443001
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- contact form -->
    <form action="{{route('front.send-contact-mail')}}" class="contact-form what-we-do" method="POST">
      @csrf
      <h3 class="text-center">Drop Us a Message</h3>
      <div class="row mt-4">
        <div class="col-xs-12 col-sm-6">
          <div class="form-group">
            <input type="text" name="name" class="form-control element-block" placeholder=" Name" required>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="form-group mb-0">
            <input type="email" name="email" class="form-control element-block" placeholder="Email" required>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="form-group">
            <textarea class="form-control element-block" name="message" rows="5" placeholder="Message"
              required></textarea>
          </div>
        </div>
        <div class="text-center col-md-3 mx-auto mt-4">
          <button class="p-bg-color hvr-trim-two">SEND MESSAGE</button>
        </div>
      </div>

    </form>
  </div>
  <!-- mapHolder -->
  <div class="mapHolder">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d478544.854017597!2d75.93040651344548!3d20.43923310922234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sBULDHANA%2C%20Maharashtra%2C%20India%2C%20443001!5e0!3m2!1sen!2sin!4v1596787364962!5m2!1sen!2sin"
      width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
      tabindex="0"></iframe>
    <!-- <span class="mapMarker">
                <img src="images/map-marker.png" alt="marker">
               </span> -->
  </div>
</section>
@endsection
@push('js')
@endpush