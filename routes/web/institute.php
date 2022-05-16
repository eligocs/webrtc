<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'institute.'], function () {
    Route::group(['middleware' => ['auth', 'institute']], function () {
        Route::post('/getClass', 'Web\Institute\InstituteController@getClass')->name('getClass');
        Route::post('/getattendance', 'Web\Institute\InstituteController@getattendance')->name('getattendance');
        Route::post('/getSubAtt', 'Web\Institute\InstituteController@getSubAtt')->name('getSubAtt');
        Route::get('/enrollments/{id?}/{classid?}', 'Web\Institute\InstituteController@enrollments')->name('enrollments');
        Route::get('/generate-receipt/{class_id?}/{student}', 'Web\Institute\InstituteController@generate_receipt')->name('generate-receipt');
        //Notifications
        Route::post('/create_notification', 'Web\Institute\InstituteController@create_notification')->name('create_notification');
        Route::post('/create_notify', 'Web\Institute\InstituteController@create_notify')->name('create_notify');

        Route::get('/', 'Web\Institute\InstituteController@index')->name('home');
        Route::post('/getdoubts', 'Web\Institute\InstituteController@getdoubts')->name('getdoubts');
        Route::get('/', 'Web\Institute\InstituteController@index')->name('home');
        Route::get('/profile', 'Web\Institute\InstituteController@profile')->name('profile');
        Route::post('/updateDemoVideo', 'Web\Institute\InstituteController@updateDemoVideo')->name('updateDemoVideo');
        Route::post('/subjectvideo', 'Web\Institute\InstituteController@subjectvideo')->name('subjectvideo');
        Route::post('/uploadClassVideo', 'Web\Institute\InstituteController@uploadClassVideo')->name('uploadClassVideo');
        Route::get('/logout', 'Web\Institute\InstituteController@logout')->name('logout');
        Route::get('/detail/{i_a_c_s_id}/{subject_id}', 'Web\Institute\InstituteController@detail')->name('detail');
        Route::post('/store-answer', 'Web\Institute\QuestionController@getimagAns')->name('store-answer');

        Route::get('listMeeting/{segment1}/{segment2}', 'Web\Institute\meettingController@listMeeting')->name('listMeeting');
        Route::post('getMeeting/{id}', 'Web\Institute\meettingController@getdata')->name('getMeeting');
        // Route::get('create/{segment1}/{segment2}', 'Web\Institute\meettingController@zoomForm')->name('create/Meeting');
        Route::post('/meeting', 'Web\Institute\meettingController@createMeeting')->name('meeting');
        Route::post('/deleteMeeting/{id}', 'Web\Institute\meettingController@deletemeeting')->name('deletemeeting');
        Route::post('/editMeeting/{id}', 'Web\Institute\meettingController@update')->name('update');
        Route::get('/joinMeeting', 'Web\Institute\meettingController@joinMeeting')->name('joinMeeting');
        Route::post('/meetingAuth', 'Web\Institute\meettingController@meetingAuth')->name('meetingAuth');
        Route::get('/endMeeting', 'Web\Institute\meettingController@endMeeting')->name('endMeeting');
        Route::post('/sendmeetingid', 'Web\Institute\meettingController@meetingId')->name('sendmeetingid');


        Route::post('/extra_classes/delete', 'Web\Institute\ExtraClassController@delete')->name('extra_classes.delete');
        Route::post('/extra_classes/getLecture', 'Web\Institute\ExtraClassController@getLecture')->name('extra_classes.getLecture');
        Route::group(['namespace' => "Web\Institute"], function () {
            Route::group(['middleware' => ['lecture']], function () {
                Route::get('/{i_assigned_class_subject_id}/lectures/getUnits', 'LectureController@getUnits')->name('lectures.getUnits');
                Route::get('/{i_assigned_class_subject_id}/lectures/getSubjectsByClassId', 'LectureController@getSubjectsByClassId')->name('lectures.getSubjectsByClassId');
                Route::post('/{i_assigned_class_subject_id}/lectures/addUnit', 'LectureController@addUnit')->name('lectures.addUnit');
                Route::post('/{i_assigned_class_subject_id}/lectures/testUnit', 'LectureController@addTestUnit')->name('lectures.testUnit');
                Route::post('/{i_assigned_class_subject_id}/lectures/liveUnit', 'meettingController@liveUnit')->name('lectures.liveUnit');
                Route::post('/{i_assigned_class_subject_id}/lectures/assignmentUnit', 'AssignmentController@assignmentUnitAdd')->name('lectures.assignmentUnit');
                Route::resource('/{i_assigned_class_subject_id}/lectures', 'LectureController');
                Route::post('/{i_assigned_class_subject_id}/lectures/addvideo', 'LectureController@addvideo')->name('lectures.addvideo');
                Route::post('/{i_assigned_class_subject_id}/lectures/getLecture', 'LectureController@getLecture')->name('lectures.getLecture');
                Route::post('/{i_assigned_class_subject_id}/lectures/delete', 'LectureController@delete')->name('lectures.delete');




                //extra classes duplicate of lectures
                Route::get('/{i_assigned_class_subject_id}/extra_classes/getUnits', 'ExtraClassController@getUnits')->name('extra_classes.getUnits');
                Route::get('/{i_assigned_class_subject_id}/extra_classes/getSubjectsByClassId', 'ExtraClassController@getSubjectsByClassId')->name('extra_classes.getSubjectsByClassId');
                Route::post('/{i_assigned_class_subject_id}/extra_classes/addUnit', 'ExtraClassController@addUnit')->name('extra_classes.addUnit');
                Route::resource('/{i_assigned_class_subject_id}/extra_classes', 'ExtraClassController');
                Route::post('/{i_assigned_class_subject_id}/extra_classes/updvideo', 'ExtraClassController@updvideo')->name('extra_classes.updvideo');

                //Tests
                Route::delete('delete/sheet/quiz/{id}', 'TopicController@deleteperquizsheet')->name('del.per.quiz.sheet');
                Route::post('/{iacsId}/topics/{id}/publish', 'TopicController@publish')->name('topics.publish');
                Route::resource('/{iacsId}/topics', 'TopicController');

                //Assignments
                Route::delete('delete/sheet/assignment/{id}', 'AssignmentController@deleteperquizsheet')->name('del.per.quiz.sheet');
                Route::resource('/{iacsId}/assignments', 'AssignmentController');
                Route::post('/{i_assigned_class_subject_id}/assignment/addUnit', 'LectureController@addAssignmentUnit')->name('assignment.addUnit');

                Route::post('/institute/questions/import_questions', 'QuestionController@importExcelToDB')->name('import_questions');
                Route::resource('/{iacsId}/questions', 'QuestionController');
                Route::get('showtheory/{iacsId}/{tid}', 'QuestionController@theoryshow');


                Route::resource('/{iacsId}/all_reports', 'AllReportController');
                Route::get('get_reports/{iacsId}/{tid}', 'AllReportController@gettheoryReport');
                Route::post('get_quest/{iacsId}/{tid}', 'AllReportController@givemaks');
                Route::post('set_marks/{iacsId}/{tid}', 'AllReportController@marks');
                Route::get('get_new_quest/{iacsId}/{tid}/{userid?}/{answerid?}', 'AllReportController@get_new_quest_id');
                /* Route::get('get_reports/{iacsId}/{tid}', 'AllReportController@gettheoryReport');
                Route::any('get_reports/{iacsId}/{tid}/reports/{stuid}', 'AllReportController@givemaks');
                Route::any('get_reports/{iacsId}/{tid}/reports', 'AllReportController@givemaks'); */
                Route::delete('/{iacsId}/all_reports/{topicid}/{userid}', 'AllReportController@destroy');

                Route::resource('/{iacs_id}/doubts', 'DoubtController');
            });
            Route::post('/addSyllabus/{iacs_id}', 'InstituteController@addSyllabus')->name('addSyllabus');
        });
    });
});