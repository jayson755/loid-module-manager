<?php


Route::group(['prefix'=>'manage', 'middleware'=>['web', 'auth', \Loid\Frame\Middleware\MoudleInit::class]], function () {
    
    /*系统用户*/
    Route::get('user.html', Loid\Module\Manager\Controllers\UserController::class.'@index')->name('manage.user');
    
    Route::get('user/list/{param}.html', Loid\Module\Manager\Controllers\UserController::class.'@getjQGridList')->name('manage.user.list');
    
    Route::post('user/modify.html', Loid\Module\Manager\Controllers\UserController::class . '@modify')->name('manage.user.modify');
    
});