<?php 

Route::group(['prefix' => 'institute-applications', 'as'=>'institute-applications.'], function(){ 

    Route::post('/','Api\v1\Front\InstituteApplicationController@index')->name('index');
    Route::post('/store','Api\v1\Front\InstituteApplicationController@store')->name('store'); 
     
});

?>