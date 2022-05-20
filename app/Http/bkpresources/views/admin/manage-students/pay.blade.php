{{-- @extends('student.layouts.app')
@section('css')
<meta name="viewport" content="width=device-width">
<link href="{{URL::to('assets/student/libs/custombox/custombox.min.css')}}" rel="stylesheet">
<style>
  form {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
</style>
@endsection
@section('content')

@endsection
@section('js')
<script src="{{URL::to('assets/student/libs/custombox/custombox.min.js')}}"></script>
<script src="{{URL::to('assets/student/js/app.min.js')}}"></script>
@endsection --}}

<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    .clearfix:after {
      content: "";
      display: table;
      clear: both;
    }

    a {
      color: #0087C3;
      text-decoration: none;
    }

    body {
      position: relative;
      width: 100%;
      height: auto;
      margin: 0 auto;
      color: #555555;
      background: #FFFFFF;
      font-size: 14px;
      font-family: Verdana, Arial, Helvetica, sans-serif;
    }

    h2 {
      font-weight: normal;
    }

    header {
      padding: 10px 0;
      margin-bottom: 20px;
      border-bottom: 1px solid #AAAAAA;
    }

    #logo {
      float: left;
      margin-top: 11px;
    }

    #logo img {
      height: 55px;
      margin-bottom: 15px;
    }

    #company {}

    #details {
      margin-bottom: 50px;
    }

    #client {
      padding-left: 6px;
      float: left;
    }

    #client .to {
      color: #777777;
    }

    h2.name {
      font-size: 1.2em;
      font-weight: normal;
      margin: 0;
    }

    #invoice {}

    #invoice h1 {
      color: #0087C3;
      font-size: 2.4em;
      line-height: 1em;
      font-weight: normal;
      margin: 0 0 10px 0;
    }

    #invoice .date {
      font-size: 1.1em;
      color: #777777;
    }

    table {
      width: 100%;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table th,
    table td {
      border-bottom: 1px solid #dee2e6;
      font-size: 14px;
      padding: .9rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }

    table th {
      white-space: nowrap;
      vertical-align: bottom;
      border-bottom: 2px solid #dee2e6;
      background-color: #ffffff;
      font-size: 15px !important;
      font-weight: 700;
    }

    table td {
      text-align: right;
    }

    table .no {
      color: #555555;
      width: 10%;
    }

    table .desc {
      text-align: left;
    }


    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
      text-align: center;
    }

    table td.unit {
      width: 35%;
    }

    table td.desc {
      width: 45%;
    }

    table td.qty {
      width: 5%;
    }

    .status {
      margin-top: 15px;
      padding: 1px 8px 5px;
      font-size: 1.3em;
      width: 80px;
      color: #fff;
      float: right;
      text-align: center;
      display: inline-block;
    }

    .status.unpaid {
      background-color: #E7505A;
    }

    .status.paid {
      background-color: #26C281;
    }

    .status.cancelled {
      background-color: #95A5A6;
    }

    .status.error {
      background-color: #F4D03F;
    }

    table tr.tax .desc {
      text-align: right;
      color: #1BA39C;
    }

    table tr.discount .desc {
      text-align: right;
      color: #E43A45;
    }

    table tr.subtotal .desc {
      text-align: right;
      color: #1d0707;
    }

    table tbody tr:last-child td {
      border: none;
    }

    table tfoot td {
      padding: 10px 10px 20px 10px;
      background: #FFFFFF;
      border-bottom: none;
      font-size: 1.2em;
      white-space: nowrap;
      border-bottom: 1px solid #ededed;
    }

    table tfoot tr:first-child td {
      border-top: none;
    }

    table tfoot tr td:first-child {
      border: none;
    }

    #thanks {
      font-size: 2em;
      margin-bottom: 50px;
    }



    footer {
      color: #777777;
      width: 100%;
      height: 30px;
      position: absolute;
      bottom: 0;
      border-top: 1px solid #AAAAAA;
      padding: 8px 0;
      text-align: center;
    }

    table.billing td {
      background-color: #fff;
    }

    table td div#invoiced_to {
      text-align: left;
    }

    #notes {
      color: #767676;
      font-size: 11px;
    }

    h3 {
      margin: 10px 0;
      font-weight: 600;
      color: #343a40;
      font-size: 1.5rem;
    }

    hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid #ededed;
    }

    h4 {
      margin: 10px 0;
      font-weight: 600;
      color: #343a40;
      font-size: 1.125rem;
    }

    address,
    p {
      margin: 0;
      font-style: normal;
      line-height: 1.4;
      font-size: 15px;
    }

    h5 {
      font-size: 14px;
      margin: 10px 0 13px;
    }

    small {
      font-size: 14px;
    }

    .razorpay-payment-button {
      color: #ffffff;
      border: 2px solid #644699;
      border-radius: 3px;
      padding: 6px 16px;
      font-size: 14px;
      background-color: #644699;
      box-shadow: 1px 1px 4px 0px rgba(0, 0, 0, 0.6);
    }
  </style>
</head>

<body style="background-color: #ebeff2;font-family: Karla,sans-serif;">
  {{-- <div style="padding:50px;background-color: #fff;width:70%; margin:25px auto"> --}}
  <div class="container" style="padding:50px;background-color: #fff;margin:auto;">
    <table cellpadding="0" cellspacing="0" class="billing">
      <tr>
        <td style="padding-top:0;">
          <div id="invoiced_to" class="text-center">
            <!-- <small>Twitter, Inc.</small> -->
            <h3 class="name text-center" style="margin-top: 0;"><img
                src="http://aaradhanaonlineclasses.net/assets/student/images/logo-dark.png" alt="AVESTUD" width="182.8"
                height="37" style="margin:0 auto; display:block;"></h3>
          </div>
        </td>
        <td>
          <div id="company">
            {{-- <h4>Invoice #</br>2016-04-23654789</h3> --}}
          </div>
        </td>
      </tr>
    </table>
    <hr>
    <table cellpadding="0" cellspacing="0" class="billing">
      <tr>
        <td>
          <div id="invoiced_to">
            <address>
              <p><strong>{{$student->name}}</strong>
                <p>
                  <p>{{$student->address_1}}</p>
                  <p>{{$student->address_2}}</p>
                  <p>{{$student->city ? $student->city. ', ': ''}}
                    {{$student->state}}{{ $student->pincode ? ' ,'.$student->pincode : ''}}</p>
                  {{$student->phone}}
            </address>
          </div>
        </td>
        <td>
          <div id="deate">
            <p><strong>Order Date: </strong> {{date('M d, Y', strtotime($enrolled_class->created_at))}}</p>
            {{-- <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-pink">Confirmed</span></p> --}}
            {{-- <p class="m-t-10"><strong>Order ID: </strong> #{{$enrolled_class->id}}</p> --}}
          </div>
        </td>
      </tr>
    </table>
    <main>
      @php
      if ($enrolled_class->coupon_applied) {
      $discount_in_rs = \App\Models\Coupon::withTrashed()->where('id',
      $enrolled_class->coupon_id)->first()->discount_in_rs;
      $total_amount = $class->price - $discount_in_rs;
      } else {
      $discount_in_rs = 0;
      $total_amount = $class->price;
      }
      @endphp
      <table style="width: 100%;">
        <tr>
          <td style="text-align: left;"><strong>Email: </strong> {{$student->email}}</td>
        </tr>
        <tr>
          <td style="text-align: left;width: 100%;">
            We acknowledge with thanks from Mr/Mrs.........{{$student->name}}........ Payment of
            Rs......{{$total_amount}}....... (In figures) via ONLINE by towards payment of class enrolled.
          </td>
        </tr>
      </table>
      <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
        <thead>
          <tr>
            <th style="text-align: left;width: 5%;">#</th>
            <th style="text-align: left;width: 85%;">Particulars</th>
            <th></th>
            <th></th>
            {{-- <th style="text-align: left;">Description</th> --}}
            {{-- <th style="text-align: left;">Quantity</th> --}}
            {{-- <th style="text-align: left;">Unit Cost</th> --}}
            <th style="text-align: left;width: 10%;">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr style="page-break-inside: avoid;">
            <td style="width: 5%;text-align: left;">1</td>
            <td style="width: 85%;text-align: left;">{{$class->name}} by {{$class->institute->name}}</td>
            <td></td>
            <td></td>
            {{-- <td  >Lorem ipsum dolor sit amet.</td>
                <td  >1</td>
                <td  >&#8377; 380</td> --}}
            <td style="text-align: left;">Rs. {{$total_amount}}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            {{-- <td  >Lorem ipsum dolor sit amet.</td>
                <td  >1</td>
                <td  >&#8377; 380</td> --}}
            <td></td>
          </tr>
        </tbody>
        <tfoot>
          <tr dontbreak="true">
            <td colspan="1">
              <div class="clearfix mt-4" style="text-align: left; width:90%">
                {{-- <h5 class="small text-dark">PAYMENT TERMS AND POLICIES</h5> --}}
              </div>
            </td>
            <td></td>
            <td></td>
            <td colspan="2">
              <p class="text-right"><b>Sub-total:</b> Rs. {{$class->price}}</p>
              @if ($enrolled_class->coupon_applied)
              <p class="text-right"><b>Discout:</b>
                {{$discount_in_rs}}
              </p>
              @endif
              {{-- <p class="text-right">VAT: 12.9%</p> --}}
              <hr>
              <h3 class="text-right">Rs. {{$total_amount}}</h3>
              <form class="mt-2" action="{{route('admin.enrollment_in_class')}}" method="POST">
                @csrf
                {{-- <script id="checkoutScript" src="https://checkout.razorpay.com/v1/checkout.js"
                  data-key="{{config('app.razorpay_api_key')}}" data-amount="{{$total_amount.'00'}}"
                data-currency="INR"
                data-buttontext="Pay Now" data-name="Acme Corp" data-description="Enrollment Class Payment"
                data-image="https://example.com/your_logo.jpg" data-prefill.name="{{$student->name}}"
                data-prefill.email="{{$student->email ?? auth()->user()->email}}"
                data-prefill.contact="{{$student->phone}}" data-theme.color="#F37254">
                </script> --}}
                <input type="submit" class="razorpay-payment-button" value="Pay Now">
                <input type="hidden" custom="Hidden Element" name="hidden" value="{{encrypt($enrolled_class->id)}}">
              </form>
            </td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="3">
              For More Help <br>
              AVESTUD <br>
              BULDHANA, Maharashtra, India, 443001 <br>
              Hot Line: 08421784125 <br>
              Email Id: support@avestud.com <br>
              www.avestud.com <br>
            </td>
          </tr>
        </tfoot>
      </table>
      <table>
        <tr>
          <td style="text-align: left;">
            <b>This is an electronically generated invoice and no signature is required.</b><br><br>
            For Payment Terms and Policies Please visit our website www.avestud.com.
          </td>
        </tr>
      </table>
      <p>&nbsp;</p>

    </main>
  </div>
</body>

</html>