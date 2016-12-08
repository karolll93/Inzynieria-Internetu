<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::get('/leagues', 'LeagueController@all')->name('leagues');

Route::match(['get', 'post'], '/login', 'UserController@login')->name('login')->middleware('guest');

Route::get('/logout', 'UserController@logout')->name('logout')->middleware('auth');

Route::group(['middleware' => ['dashboard']], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/dashboard/countries', 'DashboardCountryController@index')->name('dashboard.countries');
    Route::match(['get', 'post'], '/dashboard/countries/add', 'DashboardCountryController@add')->name('dashboard.countries.add');
    Route::match(['get', 'post'], '/dashboard/countries/edit/{id}', 'DashboardCountryController@edit')->name('dashboard.countries.edit');
    Route::get('/dashboard/countries/delete/{id}', 'DashboardCountryController@delete')->name('dashboard.countries.delete');

    Route::get('/dashboard/players', 'DashboardPlayerController@index')->name('dashboard.players');
    Route::match(['get', 'post'], '/dashboard/players/add', 'DashboardPlayerController@add')->name('dashboard.players.add');
    Route::match(['get', 'post'], '/dashboard/players/edit/{id}', 'DashboardPlayerController@edit')->name('dashboard.players.edit');
    Route::get('/dashboard/players/delete/{id}', 'DashboardPlayerController@delete')->name('dashboard.players.delete');

    Route::get('/dashboard/clubs', 'DashboardClubController@index')->name('dashboard.clubs');
    Route::match(['get', 'post'], '/dashboard/clubs/add', 'DashboardClubController@add')->name('dashboard.clubs.add');
    Route::match(['get', 'post'], '/dashboard/clubs/edit/{id}', 'DashboardClubController@edit')->name('dashboard.clubs.edit');
    Route::get('/dashboard/clubs/delete/{id}', 'DashboardClubController@delete')->name('dashboard.clubs.delete');


});