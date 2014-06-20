<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::model('record', 'Record');
Route::model('user', 'User');


Route::group(array('before' => array('auth', 'update_user')), function()
{
    Route::get('/', 'UserController@actionIndex');

    Route::get('dashboard', 'RecordController@actionList');
    Route::get('dashboard/records', 'RecordController@actionList');
    Route::get('dashboard/record/search', 'RecordController@actionSearch');
    Route::get('dashboard/record/{id}', 'RecordController@actionViewRecord')->where('id', '[0-9]+');
    Route::get('record/types', function() {
        return App::make('HelperRecordType')->availableOptionsJson();
    });

    Route::get('record/{id}/json/', function($id) {

        $record = array();

        if (intval($id) > 0) {
            $record = Record::find($id);
        }

        $record->prepareForAngularData();

        $return = array($record->toArray());

        return json_encode($return);
    });

    Route::get('record/{type}/fields/', function($type) {
        return App::make('HelperRecordType')->availableFieldsJson($type);
    });
});


Route::group(array('before' =>  'auth_admin'), function() {

    Route::get('dashboard/record/{record}/delete', function(Record $record) {
        return View::make('record.delete')->with(array('record' =>  $record));
    });

    Route::post('dashboard/record/{id}/delete', 'RecordController@actionDeleteRecord');

    Route::get('dashboard/user/add', 'UserController@actionAdd');

    Route::post('dashboard/user/add', 'UserController@actionSave');

    Route::get('dashboard/users/search', 'UserController@actionSearch');
    Route::get('/dashboard/users', 'UserController@actionList');
    Route::get('/dashboard/user/{user}', function(User $user) {
        return View::make('user.view')->withUser($user);
    });
});

Route::group(array('before' => 'auth_privileged', 'before' =>  'update_user'), function() {

    Route::get('dashboard/record/add', 'RecordController@actionEditRecord');

    Route::get('dashboard/record/{id}/edit', 'RecordController@actionEditRecord');
    Route::post('dashboard/record/{id}/edit', 'RecordController@actionSaveRecord');

    Route::post('dashboard/record/new', 'RecordController@actionSaveRecord');

    Route::post('dashboard/record/new', 'RecordController@actionSaveRecord');
    Route::post('dashboard/record/new', 'RecordController@actionSaveRecord');



});



Route::get('logout', 'UserController@actionLogout');


Route::post('user/authenticate', array('before'=>'csrf', 'as' => 'user/authenticate', 'uses'=>'userController@authenticate'));


