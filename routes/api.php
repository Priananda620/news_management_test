<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::middleware('auth:api')->group(function () {
    
// });

Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    // Routes that require authentication
    Route::get('/getUser', [UserController::class, 'getUser']);
    Route::get('/getUserRole', [UserController::class, 'getUserRole']);

    Route::prefix('/comment')->middleware('checkUserRole:2')->group(function () {
        Route::post('/post', [CommentController::class, 'store']);
    });

    Route::prefix('/news')->group(function(){
        Route::get('/', [NewsController::class, 'index']);
        Route::get('/get-news/{id}', [NewsController::class, 'getNews']);
        //with comment
        Route::get('/get-news-details/{news_id}', [NewsController::class, 'getNewsDetails']);
    });

    Route::prefix('/news')->middleware('checkUserRole:1')->group(function () {
        Route::post('/post', [NewsController::class, 'store']);
        //form data cannot use PUT method so I use POST. And because we have image and to make things simple, 
        // we send the image as a binary in formdata. If using json, we must encode the image to base64
        Route::post('/update/{id}', [NewsController::class, 'update']);
        Route::delete('/delete/{id}', [NewsController::class, 'destroy']);
    });
    
    
});
