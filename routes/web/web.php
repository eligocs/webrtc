<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web"  middleware group. Now create something great!
|
*/


Route::get('/clearCache', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    return "Cache is cleared";
});
// Authentication Routes...

Route::get('/admin/login', 'Web\Auth\LoginController@admin_login_form')->name('admin.login');
Route::get('/institute/login', 'Web\Auth\LoginController@institute_login_form')->name('admin.institute');
Route::get('/student/login', 'Web\Auth\LoginController@student_login_form')->name('student.login');
Route::any('login', 'Web\Auth\LoginController@login')->name('login');
Route::get('/institute/forget', 'Web\Auth\LoginController@institute_forget_form')->name('admin.institute.forget');
Route::get('/institute/otpverificatio', 'Web\Auth\LoginController@institute_otp_verification')->name('admin.institute.otp');
Route::any('logout', 'Web\Auth\LoginController@logout');

// Password Reset Routes...

Route::post('password/email', [
    'as' => 'password.email',
    'uses' => 'Web\Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
    'as' => 'password.request',
    'uses' => 'Web\Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
    'as' => 'password.update',
    'uses' => 'Web\Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
    'as' => 'password.reset',
    'uses' => 'Web\Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...

Route::get('register', [
    'as' => 'register',
    'uses' => 'Web\Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
    'as' => '',
    'uses' => 'Web\Auth\RegisterController@register'
]);

// Route::get('register', 'Web\Auth\AuthController@showRegistrationForm');
// Route::post('register', 'Web\Auth\AuthController@register');

// Route::get('password/reset/{token?}', 'Web\Auth\PasswordController@showResetForm');
// Route::post('password/email', 'Web\Auth\PasswordController@sendResetLinkEmail');
// Route::post('password/reset', 'Web\Auth\PasswordController@reset');

// Route::get('/home', 'HomeController@index')->name('home');



/**
 * 
 * COMMON ROUTES START HERE  
 * 
 */

Route::post('/getSubjectsByCat', 'Web\CommonController@getSubjectsByCat')->name('getSubjectsByCat');
