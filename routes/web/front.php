<?php


Route::group(['as' => 'front.'], function () {

  Route::get('/', 'Web\Front\HomeController@index')->name('index');
  Route::get('/institute-application', 'Web\Front\InstituteApplicationController@index')->name('institute-application');
  Route::post('/institute-application', 'Web\Front\InstituteApplicationController@create')->name('institute-application-post');
    Route::get('/thank-you', 'Web\Front\InstituteApplicationController@thankyou')->name('thank-you');
  // static pages
  Route::get('/available-classes', 'Web\Front\HomeController@available_classes')->name('available-classes');
  Route::get('/admission', 'Web\Front\HomeController@admission')->name('admission');
  Route::get('/why-avestud', 'Web\Front\HomeController@why_avestud')->name('why-avestud');
  Route::get('/how-it-works', 'Web\Front\HomeController@how_it_works')->name('how-it-works');
  Route::get('/inner-work', 'Web\Front\HomeController@inner_work')->name('inner-work');
  Route::get('/contact-us', 'Web\Front\HomeController@contact_us')->name('contact-us');
  Route::post('/send-contact-mail', 'Web\Front\HomeController@send_contact_mail')->name('send-contact-mail');
  Route::get('/terms', 'Web\Front\HomeController@terms')->name('terms');
  Route::get('/privacy-policy', 'Web\Front\HomeController@privacy_policy')->name('privacy-policy');

  Route::group(['prefix' => 'student', 'as' => 'student.'], function () {

    Route::group(['prefix' => 'signup', 'as' => 'signup.'], function () {

      Route::get('/name', 'Web\Front\StudentController@name')->name('name');
      Route::any('/phone_number', 'Web\Front\StudentController@phone_number')->name('phone_number');
      Route::any('/otp', 'Web\Front\StudentController@otp')->name('otp');
      Route::any('/password', 'Web\Front\StudentController@password')->name('password');
      Route::post('/register_student', 'Web\Front\StudentController@register_student')->name('register_student');
      Route::post('/verify_otp', 'Web\Front\StudentController@verify_otp')->name('verify_otp');
      Route::post('/resend_otp', 'Web\Front\StudentController@resend_otp')->name('resend_otp');
      Route::post('/generate_otp', 'Web\Front\StudentController@generate_otp')->name('generate_otp');
      Route::post('/reset_password', 'Web\Front\StudentController@reset_password')->name('reset_password');
      Route::post('/reset_password_institute', 'Web\Front\StudentController@reset_password_institute')->name('reset_password_institute_url');
    });
  });
});
Route::get('/student/forgot-password', 'Web\Front\StudentController@forgot_password')->name('forgot-password');
