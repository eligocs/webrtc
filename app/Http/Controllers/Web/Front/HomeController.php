<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    return view('front.home');
  }

  public function available_classes()
  {
    return view('front.available-classes');
  }
  public function admission()
  {
    return view('front.admission');
  }
  public function why_avestud()
  {
    return view('front.why-avestud');
  }
  public function how_it_works()
  {
    return view('front.how-it-works');
  }
  public function inner_work()
  {
    return view('front.inner-work');
  }
  // public function how_it_works(){
  //   return view('front.how-it-works');
  // }
  public function contact_us()
  {
         return view('front.contact');
  }

  public function terms()
  {
    return view('front.terms');
  }

  public function privacy_policy()
  {
    return view('front.privacy-policy');
  }

  public function send_contact_mail()
  {
    request()->validate([
      'email' => 'required',
      'name' => 'required',
      'message' => 'required',
    ]);

    $html = 'Email ID: ' . request()->email . '<br>' .
      'Name: ' . request()->name . '<br>' .
      'Message: ' . request()->message;


    \Mail::send([], [], function ($message) use ($html) {
      $message->subject('Email from contact page')
        ->from(request()->email, request()->name)
        ->to('support@avestud.com', 'Site Support')
        ->setBody($html, 'text/html');
    });

    return redirect()->back();
  }
}