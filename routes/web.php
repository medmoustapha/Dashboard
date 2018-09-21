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
    return view('back.layout',['title'=>""]);
})->middleware('auth');

Route::get('/articlesparsation', 'StockController@index')->name('index');
Route::get('/articleStation', 'StockController@articlesParStation');
Route::get('/valeurStock', 'StockController@valeurStockIndex');
Route::get('/valeurStockAjax', 'StockController@valeurStock');
Route::get('/articleenrupture', 'StockController@articleEnRupture');
Route::get('/inventaireIndex', 'StockController@inventaireIndex');
Route::get('/filterrupture', 'StockController@filterArticleRupture');
Route::get('/articleEnRupturechart', 'StockController@articleEnRupturechart');
Route::get('/filterarticleEnRupturechart/{famille}/{marque}', 'StockController@filterArticleRuptureChart');

Route::get('/inventaireChart/{station}/{date1}/{date2}', 'StockController@inventaireChart');
Route::get('/inventaireFilter', 'StockController@inventaireFilter');

Route::get('/stock', 'StockController@stockIndex');
Route::get('/stockFilter', 'StockController@stockFilter');

Route::get('logout','StockController@logout');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
