<?php
Route::group(['as' => 'admin.'], function () {

  Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/', 'Web\Admin\AdminController@index')->name('home');
    Route::get('/logout', 'Web\Admin\AdminController@logout')->name('logout');
    Route::post('/lectures/store', 'Web\Admin\InstituteSubjectController@store')->name('lectures');
    Route::post('/lectures/getLecture', 'Web\Admin\InstituteSubjectController@getLecture')->name('getLecture');
    Route::post('/lectures/addvideo', 'Web\Admin\InstituteSubjectController@addvideo')->name('addvideo');
    Route::post('/lectures/delete', 'Web\Admin\InstituteSubjectController@delete')->name('delete');
    Route::post('/lectures/addUnit', 'Web\Admin\InstituteSubjectController@lectureaddUnit')->name('addUnit');
    Route::post('/extra_classes/getSubjectsByClassId', 'Web\Admin\InstituteSubjectController@getSubjectsByClassId')->name('getSubjectsByClassId');
    Route::post('/extra_classes/getUnits', 'Web\Admin\InstituteSubjectController@getUnits')->name('getUnits');
    Route::post('/extra_classes/addUnit', 'Web\Admin\InstituteSubjectController@addUnit')->name('addUnit');
    Route::post('/extra_classes/store', 'Web\Admin\InstituteSubjectController@store_extra_classes')->name('store');
    Route::post('/extra_classes/getLecture', 'Web\Admin\InstituteSubjectController@getExtraClass')->name('getLecture');
    Route::post('/extra_classes/updvideo', 'Web\Admin\InstituteSubjectController@updvideo')->name('updvideo');
    Route::post('/extra_classes/delete', 'Web\Admin\InstituteSubjectController@delete_extra_class')->name('delete');

    Route::get('/approveVideo/{ins?}/{val?}', 'Web\Admin\ManageInstituteController@approveVideo')->name('approveVideo');
    Route::get('/approveSubjectVideo/{ins?}/{val?}', 'Web\Admin\ManageInstituteController@approveSubjectVideo')->name('approveSubjectVideo');
    Route::get('/approveClassVideo/{ins?}/{val?}', 'Web\Admin\ManageInstituteController@approveClassVideo')->name('approveClassVideo');

    Route::group(['prefix' => 'institute-applications', 'as' => 'institute-applications.'], function () {
      Route::get('/', 'Web\Admin\InstituteApplicationController@index')->name('index');
      Route::get('/resolved', 'Web\Admin\InstituteApplicationController@resolved')->name('resolved');
      Route::get('/view/{id}', 'Web\Admin\InstituteApplicationController@view')->name('view');
      Route::post('/make_resolve', 'Web\Admin\InstituteApplicationController@make_resolve')->name('make_resolve');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
      Route::get('/', 'Web\Admin\CategoryController@index')->name('index');
      Route::post('/store', 'Web\Admin\CategoryController@store')->name('store');
      Route::get('/view/{id}', 'Web\Admin\CategoryController@view')->name('view');
      Route::post('/update/{id}', 'Web\Admin\CategoryController@update')->name('update');
    });

    Route::group(['prefix' => 'languages', 'as' => 'languages.'], function () {
      Route::get('/', 'Web\Admin\LanguageController@index')->name('index');
      Route::post('/store', 'Web\Admin\LanguageController@store')->name('store');
      Route::get('/view/{id}', 'Web\Admin\LanguageController@view')->name('view');
      Route::post('/update/{id}', 'Web\Admin\LanguageController@update')->name('update');
      Route::post('/addLanguage', 'Web\Admin\LanguageController@store')->name('addLanguage');
      Route::get('/getLanguages', 'Web\Admin\LanguageController@getLanguages')->name('getLanguages');
    });

    Route::group(['prefix' => 'subjects', 'as' => 'subjects.'], function () {
      Route::get('/', 'Web\Admin\SubjectController@index')->name('index');
      Route::post('/store', 'Web\Admin\SubjectController@store')->name('store');
      Route::get('/view/{id}', 'Web\Admin\SubjectController@view')->name('view');
      Route::post('/update/{id}', 'Web\Admin\SubjectController@update')->name('update');
      Route::post('/addSubject', 'Web\Admin\SubjectController@store')->name('addSubject');
      Route::get('/getSubjects', 'Web\Admin\SubjectController@getSubjects')->name('getSubjects');
    });

    Route::group(['prefix' => 'category-subjects', 'as' => 'category-subjects.'], function () {
      Route::get('/', 'Web\Admin\CategorySubjectsController@index')->name('index');
      Route::post('/store', 'Web\Admin\CategorySubjectsController@store')->name('store');
      Route::get('/edit/{id}', 'Web\Admin\CategorySubjectsController@edit')->name('edit');
      Route::post('/update/{id}', 'Web\Admin\CategorySubjectsController@update')->name('update');
      Route::post('/delete', 'Web\Admin\CategorySubjectsController@delete')->name('delete');
    });

    Route::group(['prefix' => 'manage-institutes', 'as' => 'manage-institutes.'], function () {

      Route::get('/create_user', 'Web\Institute\meettingController@create_user')->name('create_user');
      Route::post('/create_user_ajax', 'Web\Institute\meettingController@create_user_ajax')->name('create_user_ajax');
      Route::get('/list/user', 'Web\Institute\meettingController@listuser')->name('list/user');
      Route::post('/get/user/{email}', 'Web\Institute\meettingController@geteditUser')->name('get/user');
      Route::post('/delete-user/{userId}/{emailId}', 'Web\Institute\meettingController@deleteUser')->name('delete-user');
      Route::get('/edit-class/{id?}/{institute?}', 'Web\Admin\ManageInstituteController@editclass')->name('edit-class');
      Route::post('getClass', 'Web\Admin\ManageInstituteController@getClass')->name('getClass');
      Route::get('/', 'Web\Admin\ManageInstituteController@index')->name('index');
      Route::get('/enrollments/{id?}/{classid?}', 'Web\Admin\ManageInstituteController@enrollments')->name('enrollments');
      Route::get('/create', 'Web\Admin\ManageInstituteController@create')->name('create');
      Route::post('/store', 'Web\Admin\ManageInstituteController@store')->name('store');
      Route::get('/edit/{id}', 'Web\Admin\ManageInstituteController@edit')->name('edit');
      Route::post('/update-institute/{id?}', 'Web\Admin\ManageInstituteController@updateInstitute')->name('updateInstitute');
      Route::get('/view-institute/{id?}', 'Web\Admin\ManageInstituteController@view_institute')->name('view-institute');
      Route::get('/create-institute-user/{id?}', 'Web\Admin\ManageInstituteController@createInstituteUser')->name('create-institute-user');
      Route::post('/store-user-institute', 'Web\Admin\ManageInstituteController@storeInstituteUser')->name('store-institute-user');
      Route::post('/delete-user-institute', 'Web\Admin\ManageInstituteController@deleteInstituteuser')->name('store-institute-delete-user');
      Route::post('/get-user-institute/{id}', 'Web\Admin\ManageInstituteController@getInstituteuser')->name('store-institute-get-user');
      Route::post('/update-user-institute/{id}', 'Web\Admin\ManageInstituteController@updateInstituteuser')->name('store-institute-update-user');
      Route::post('/delete-class', 'Web\Admin\ManageInstituteController@delete_class')->name('delete-class');
      Route::post('/enable-trial', 'Web\Admin\ManageInstituteController@enable_trial')->name('enable_trial');
      Route::get('/view-institute-detail/{id}', 'Web\Admin\ManageInstituteController@view_institute_detail')->name('view-institute-detail');
      Route::post('/update', 'Web\Admin\ManageInstituteController@update')->name('update');

      Route::get('/search_institute_name', 'Web\Admin\ManageInstituteController@search_by_institute_name')->name('search.institute_name');
      Route::get('/search_institute_id', 'Web\Admin\ManageInstituteController@search_by_institute_id')->name('search.institute_id');

      Route::get('/add-new-class/{id?}', 'Web\Admin\ManageInstituteController@add_new_class')->name('add-new-class');
      Route::post('/get-new-class-data', 'Web\Admin\ManageInstituteController@get_new_class_data')->name('get-new-class-data');

      Route::post('/create_class', 'Web\Admin\ManageInstituteController@create_class')->name('create-class');

      Route::post('upload-class-video', 'Web\Admin\ManageInstituteController@uploadClassVideo')->name('uploadClassVideo');
      Route::post('upload-subject-video', 'Web\Admin\ManageInstituteController@uploadSubjectVideo')->name('uploadSubjectVideo');
    });

    Route::group(['prefix' => 'manage-students', 'as' => 'manage-students.'], function () {
      Route::get('/', 'Web\Admin\ManageStudentController@index')->name('index');
      Route::get('/enrolled-classes/{id?}', 'Web\Admin\ManageStudentController@enrolled_classes')->name('enrolled_classes');
      Route::post('/delete-class', 'Web\Admin\ManageStudentController@delete_classes')->name('delete-class');
      Route::get('/{student_id}/generate-receipt/{class_id}', 'Web\Admin\ManageStudentController@generate_receipt')->name('generate-receipt');
    });


    // Subject Module Starts Here



    Route::group(['prefix' => 'institute-subject', 'as' => 'institute-subject.'], function () {
      Route::get('/detail/{iacs_id}/lectures', 'Web\Admin\InstituteSubjectController@lectures')->name('lectures');
      Route::get('/detail/{iacs_id}/extra-classes', 'Web\Admin\InstituteSubjectController@extra_classes')->name('extra-classes');
      Route::get('/detail/{iacs_id}/tests', 'Web\Admin\InstituteSubjectController@tests')->name('tests');
      Route::get('/detail/{iacs_id}/assignments', 'Web\Admin\InstituteSubjectController@assignments')->name('assignments');
      Route::get('/detail/{iacs_id}/reports/{id}', 'Web\Admin\InstituteSubjectController@reports')->name('reports');
      Route::get('/detail/{iacs_id}/doubts', 'Web\Admin\InstituteSubjectController@doubts')->name('doubts');
      Route::get('/detail/{iacs_id}/doubts_show/{id}', 'Web\Admin\InstituteSubjectController@doubts_show')->name('doubts_show');
      Route::get('/detail/{institute_assigned_class_id}/{subject_id}', 'Web\Admin\InstituteSubjectController@detail')->name('detail');
      Route::post('/assign-teacher', 'Web\Admin\InstituteSubjectController@assignTeacher')->name('assignTeacher');
    });

    // Subject Module Ends Here

    // Teacher Module Starts Here

    Route::resource('/{institute_id}/teachers', "Web\Admin\TeacherController");

    //Teacher Module Ends Here

    Route::post('/coupons/update-coupon-status/{id}', 'Web\Admin\CouponController@update_coupon_status')->name('coupons.update-coupon-status');
    Route::resource('/coupons', 'Web\Admin\CouponController');

    Route::get('/seach-classes', 'Web\Admin\AdminController@search_classes')->name('search-classes');
    Route::post('/inner-category', 'Web\Admin\AdminController@inner_category')->name('inner_category');
    Route::get('/inner-category', 'Web\Admin\AdminController@inner_category')->name('get_inner_category');
    Route::any('/select-timings/{class_id?}/{class?}/{student_id}', 'Web\Admin\AdminController@select_timings')->name('select_timings');
    Route::any('/checkout', 'Web\Admin\AdminController@checkout')->name('checkout');
    Route::post('/pay', 'Web\Admin\AdminController@pay')->name('pay');
    Route::post('/applyCoupon', 'Web\Admin\AdminController@apply_coupon')->name('applyCoupon');
    Route::post('/enrollment-in-class', 'Web\Admin\AdminController@enrollment_in_class')->name('enrollment_in_class');
  });
});