<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\ArtikelController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**API Route for M3
 * */
Route::get('/articles',[\App\Http\Controllers\ArtikelController::class ,'search_api']);
Route::Post('/articles',[\App\Http\Controllers\ArtikelController::class ,'store_api']);

Route::delete('/articles/{id}', [App\Http\Controllers\ArtikelController::class, '_apiDeleteArticle',]);

Route::post('/shoppingcart', [\App\Http\Controllers\APIShoppingCartController::class, 'store']);
Route::get('/shoppingcart', [\App\Http\Controllers\APIShoppingCartController::class, 'init']);
Route::delete('/shoppingcart/{shoppingcartid}/articles/{articleId}', [\App\Http\Controllers\APIShoppingCartController::class, 'removeItem']);
//Route::post('/articles/{id}/sold',[ArtikelController::class,'soldArticle_api']);


Route::post('/articles/{id}/sold',[ArtikelController::class,'soldArticle_api']);
Route::post('/articles/{id}/offer/{receiver}',[ArtikelController::class,'offer_api']);


Broadcast::routes();
