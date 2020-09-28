<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');

    Route::post('settings/profile', 'Settings\ProfileController@update');
    Route::post('settings/profile/avatar/update', 'Settings\ProfileController@avatarUpdate');
    Route::post('settings/password', 'Settings\PasswordController@update');

    Route::post('oauth/{driver}/attach', 'Auth\OAuthController@redirectToProvider')->name('oauth.attach');
    Route::post('oauth/{driver}/detach', 'Auth\OAuthController@detach')->name('oauth.detach');

    Route::post('/{id}/{type}/subscribe', 'SubscriptionController@store')->name('sub.store');
    Route::post('/{id}/{type}/unsubscribe', 'SubscriptionController@destroy')->name('sub.destroy');

    Route::post('/notifications/subscribe/{type}/{id}', 'SubsNotifyController@store')->name('subsNotify.store');
    Route::post('/notifications/unsubscribe/{type}/{id}', 'SubsNotifyController@destroy')->name('subsNotify.destroy');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');
});

Route::get('u/{id}', 'Auth\UserController@show')->name('user.show');

Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');

Route::get('/subs', 'CategoryController@index')->name('subs.index');
