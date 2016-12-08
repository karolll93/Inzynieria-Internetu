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

Route::get('/leagues/{id}/matches', 'MatchController@league')->name('leagues.matches');
Route::get('/leagues/{id}/goals', 'GoalController@league')->name('leagues.goals');
Route::get('/leagues/{id}/table', 'TableController@league')->name('leagues.table');

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

    Route::get('/dashboard/leagues', 'DashboardLeagueController@index')->name('dashboard.leagues');
    Route::match(['get', 'post'], '/dashboard/leagues/add', 'DashboardLeagueController@add')->name('dashboard.leagues.add');
    Route::match(['get', 'post'], '/dashboard/leagues/edit/{id}', 'DashboardLeagueController@edit')->name('dashboard.leagues.edit');
    Route::get('/dashboard/leagues/delete/{id}', 'DashboardLeagueController@delete')->name('dashboard.leagues.delete');

    Route::get('/dashboard/leagues/{id}/clubs-players/{club_id}/delete/{player_id}', 'DashboardLeagueController@clubs_players_delete')->name('dashboard.leagues.clubs.players.delete');
    Route::match(['get', 'post'], '/dashboard/leagues/{id}/clubs-players/{club_id}', 'DashboardLeagueController@clubs_players')->name('dashboard.leagues.clubs.players');

    Route::get('/dashboard/leagues/{id}/clubs/delete/{league_id}', 'DashboardLeagueController@clubs_delete')->name('dashboard.leagues.clubs.delete');
    Route::match(['get', 'post'], '/dashboard/leagues/{id}/clubs', 'DashboardLeagueController@clubs')->name('dashboard.leagues.clubs');
    
    Route::get('/dashboard/leagues/{id}/promotions/delete/{club_id}', 'DashboardLeagueController@promotions_delete')->name('dashboard.leagues.promotions.delete');
    Route::match(['get', 'post'], '/dashboard/leagues/{id}/promotions', 'DashboardLeagueController@promotions')->name('dashboard.leagues.promotions');

    Route::get('/dashboard/matches/{id}/goals/delete/{goal_id}', 'DashboardMatchController@goals_delete')->name('dashboard.matches.goals.delete');
    Route::match(['get', 'post'], '/dashboard/matches/{id}/goals/add', 'DashboardMatchController@goals_add')->name('dashboard.matches.goals.add');
    Route::get('/dashboard/matches/{id}/goals', 'DashboardMatchController@goals')->name('dashboard.matches.goals');

    Route::get('/dashboard/matches', 'DashboardMatchController@index')->name('dashboard.matches');
    Route::match(['get', 'post'], '/dashboard/matches/add', 'DashboardMatchController@add')->name('dashboard.matches.add');
    Route::match(['get', 'post'], '/dashboard/matches/edit/{id}', 'DashboardMatchController@edit')->name('dashboard.matches.edit');
    Route::get('/dashboard/matches/delete/{id}', 'DashboardMatchController@delete')->name('dashboard.matches.delete');

});