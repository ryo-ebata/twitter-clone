<?php

use App\Http\Requests\PostRequest;
use App\Http\Controllers\FormController;
use App\Http\Controllers\TweetsController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


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


/* 初期表示されるページ */
Route::get('/', function () {
    return view('welcome');
});

/* jetsatreamのログインを抜けたら、usersにリダイレクト */
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('users');
})->name('dashboard');

/* ログインしているユーザー限定のルーティング */
Route::middleware('auth')->group( function(){
    /* リソース周り */
    Route::resource('users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update']]);
    Route::resource('tweets', TweetsController::class);

    /* フォロー、アンフォロー周り */
    Route::post('users/{user}/follow', [UsersController::class, 'follow'])->name('follow');
    Route::delete('users/{user}/unfollow', [UsersController::class, 'unfollow'])->name('unfollow');

    Route::get('/profile', function(){
        return redirect('users');
    });

    Route::post('post', [FormController::class, 'postValidates'])->name('tweet.validates');
    Route::put('update', [FormController::class, 'updateValidates'])->name('edit.validates');
    Route::put('profile', [FormController::class, 'updateProfile'])->name('edit.profile');
});

Route::get('sample/log', [SampleController::class, 'log']);