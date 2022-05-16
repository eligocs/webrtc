<?php
Route::group(['as' => 'student.', 'namespace' => 'Web\Institute'], function () {

    Route::group(['middleware' => ['auth', 'student']], function () {
        Route::get('/joinmeeting', 'meettingController@joinMeetingstudent')->name('joinmeeting');
        Route::post('/meetingAuth', 'meettingController@meetingAuth')->name('meetingAuth');
        Route::get('/endMeeting', 'Web\Institute\meettingController@endMeeting')->name('endMeeting');
    });
});

Route::group(['as' => 'student.', 'namespace' => 'Web\Student'], function () {

    Route::group(['middleware' => ['auth', 'student']], function () {

        Route::get('/', 'StudentController@index')->name('my-classes');
        Route::post('/getnotification', 'StudentController@getnotification')->name('getnotification');
        Route::post('/markasread', 'StudentController@markasread')->name('markasread');
        Route::post('/markasreadAssignment', 'StudentController@markasreadAssignment')->name('markasreadAssignment');
        Route::post('/editClassTime', 'StudentController@editClassTime')->name('editClassTime');
        Route::get('/my-classes', 'StudentController@index')->name('home');
        Route::get('/logout', 'StudentController@logout')->name('logout');
        Route::get('/download-receipt', 'StudentController@download_receipt')->name('download-receipt');
        Route::get('/generate-receipt/{class_id}', 'StudentController@generate_receipt')->name('generate-receipt');
        Route::get('/profile', 'StudentController@profile')->name('profile');
        Route::post('/profile', 'StudentController@change_profile')->name('change_profile');
        Route::post('/change_password', 'StudentController@change_password')->name('change_password');
        Route::get('/search-classes', 'StudentController@search_classes')->name('search_classes');
        Route::post('/inner-category', 'StudentController@inner_category')->name('inner_category');
        Route::get('/inner-category', 'StudentController@inner_category')->name('get_inner_category');
        Route::get('/detail/{iacs_id}', 'StudentController@detail')->name('detail');
        Route::any('/select/timings/{class_id?}/{class?}', 'StudentController@select_timings')->name('select_timings');
        // Route::any('/select_timingsfree/{class_id}', 'StudentController@select_timingsfree')->name('select_timingsfree');
        Route::any('/select/timingsfree/{class_id}/{class}/{freemode_of_class}', 'StudentController@select_timingsfree')->name('select_timingsfree');
        Route::any('/checkout', 'StudentController@checkout')->name('checkout');
        Route::post('/applyCoupon', 'StudentController@apply_coupon')->name('applyCoupon');
        Route::post('/enrollment-in-class', 'StudentController@enrollment_in_class')->name('enrollment_in_class');
        Route::post('/pay', 'StudentController@pay')->name('pay');
        Route::get('/{iacs_id}/revised-live-lectures', 'StudentController@revisedliveLectures')->name('revised-live-lectures');

        Route::group(['middleware' => 'canStudentAccessSubject'], function () {
            Route::get('/enter-class/{class_id}', 'StudentController@enter_class')->name('enter_class');
            Route::get('/subject-detail/{iacs_id}', 'StudentController@subject_detail')->name('subject_detail');
            Route::get('/{iacs_id}/extra-classes', 'StudentController@extra_classes')->name('extra-classes');
            Route::get('/{iacs_id}/revised-lectures', 'StudentController@revisedLectures')->name('revised_lectures');
            Route::get('/doubts/{iacs_id}', 'StudentController@doubts')->name('doubts');
            Route::post('/doubts/{iacs_id}', 'StudentController@add_doubt')->name('add_doubt');
            Route::get('/{iacs_id}/tests/', 'StudentController@tests')->name('tests');
            Route::get('/{iacs_id}/assignments/', 'StudentController@assignments')->name('assignments');
            Route::post('/mark_an_attendence', 'StudentController@mark_an_attendence')->name('mark_an_attendence');
            Route::group(['middleware' => 'canStudentAccessQuiz'], function () {


                Route::get('/{iacs_id}/tests/{id}/start', 'StudentController@start_test')->name('tests.start_test');
                Route::get('/{iacs_id}/tests/{id}/allreport', 'StudentController@gettheoryReport')->name('theoryreport');
                Route::get('/{iacs_id}/tests/{id}/starttheory', 'StudentController@start_testTheory')->name('tests.start_testtheory');
                 Route::post('/{iacs_id}/tests/{id}/deleteimg', 'StudentController@deleteImage')->name('tests.deleteimg');
                Route::post('/{iacs_id}/tests/{id}/finishtheory', 'StudentController@finish_test_theory')->name('finish_test_theory');
                Route::post('/{iacs_id}/tests/{id}/storeimage', 'StudentController@saveimage')->name('tests.storeimage');
                Route::post('/{iacs_id}/tests/{id}/storetheory', 'StudentController@savetestTheory')->name('tests.storetheory');
                Route::get('/{iacs_id}/tests/{id}/review-answer', 'StudentController@reviewAnswer')->name('tests.review-answer');
                Route::get('/{iacs_id}/assignments/{id}/start', 'StudentController@start_assignment')->name('assignments.start_assignment');
                Route::get('/{iacs_id}/quiz/{id}/finish', 'StudentController@finish_test')->name('finish_test');
            });
        });
        Route::resource('start_quiz/{id}/quiz', 'MainQuizController');
    });
});
