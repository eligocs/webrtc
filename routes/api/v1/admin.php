<?php
Route::get('/logout', 'Api\v1\Admin\AdminController@logout')->name('admin.api.logout');
Route::group(['prefix' => 'institute-applications', 'as'=>'institute-applications.'], function(){

    Route::get('/','Api\v1\Admin\InstituteApplicationController@index')->name('index');   
    Route::post('/store','Api\v1\Admin\InstituteApplicationController@store')->name('store'); 
    Route::post('make_resolve/{id}', 'Api\v1\Admin\InstituteApplicationController@make_resolve');
    Route::get('/resolved','Api\v1\Admin\InstituteApplicationController@resolved')->name('resolved'); 
});

Route::group(['prefix' => 'manage-institutes', 'as'=>'manage-institutes.'], function(){  
    Route::get('/','Api\v1\Admin\ManageInstituteController@index')->name('index'); 
    Route::post('/store','Api\v1\Admin\ManageInstituteController@store')->name('store');  
    Route::get('/view/{id}','Api\v1\Admin\ManageInstituteController@view')->name('view');  
});


?>