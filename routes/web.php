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

Route::get('/', function () {
    return view('back.layout');
});
Route::get('/articlesparsation', 'StockController@index')->name('index');
Route::get('/articleStation', 'StockController@articlesParStation');
Route::get('/valeurStock', 'StockController@valeurStockIndex');
Route::get('/valeurStockAjax', 'StockController@valeurStock');
Route::get('/articleenrupture', 'StockController@articleEnRupture');
Route::get('/inventaireIndex', 'StockController@inventaireIndex');
Route::get('/filterrupture', 'StockController@filterArticleRupture');
Route::get('/articleEnRupturechart', 'StockController@articleEnRupturechart');
Route::get('/filterarticleEnRupturechart', 'StockController@filterArticleRuptureChart');

Route::get('/inventaireFilter', 'StockController@inventaireFilter');
Route::get('/stock', 'StockController@stockIndex');
Route::get('/stockFilter', 'StockController@stockFilter');



