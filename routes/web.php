<?php
use Illuminate\Auth\Middleware\Authenticate;
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
Route::get('/', function () {
    return Redirect::to('login');
});
Route::get('/index', function () {
    return view('back.layout',['title'=>"Bien venu"]);
})->middleware('auth');
Route::get('/login2', function () {
    return view('layouts.adminltelogin');
});
Route::get('/articlesparsation', 'StockController@index')->name('index')->middleware('auth');
Route::get('/articleStation', 'StockController@articlesParStation')->middleware('auth');
Route::get('/valeurStock', 'StockController@valeurStockIndex')->middleware('auth');
Route::get('/valeurStockAjax', 'StockController@valeurStock')->middleware('auth');
Route::get('/articleenrupture', 'StockController@articleEnRupture')->middleware('auth');
Route::get('/inventaireIndex', 'StockController@inventaireIndex')->middleware('auth');
Route::get('/filterrupture', 'StockController@filterArticleRupture')->middleware('auth');
Route::get('/articleEnRupturechart', 'StockController@articleEnRupturechart')->middleware('auth');
Route::get('/filterarticleEnRupturechart/{famille}/{marque}', 'StockController@filterArticleRuptureChart')->middleware('auth');

Route::get('/inventaireChart/{station}/{date1}/{date2}', 'StockController@inventaireChart')->middleware('auth');
Route::get('/inventaireChart2/{station}/{date1}/{date2}', 'StockController@inventaireChart2')->middleware('auth');
Route::get('/inventaireFilter', 'StockController@inventaireFilter')->middleware('auth');
Route::get('/inventFilter', 'StockController@inventFilter')->middleware('auth');
Route::get('/stock', 'StockController@stockIndex')->middleware('auth');
Route::get('/stockFilter/{station}/{date1}/{date2}', 'StockController@stockFilter')->middleware('auth');

Route::get('logout','StockController@logout');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
