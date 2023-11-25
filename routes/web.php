<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LookController;
use Illuminate\Support\Facades\Broadcast;

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
Broadcast::routes(['middleware' => ['auth:admin']]);

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/', function() {
    return view('posts.index');
});
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/chat', [ChatController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/chat', [ChatController::class, 'sendMessage']);
Route::get('/chat/{admin}', [ChatController::class, 'openChat']);


/*
|--------------------------------------------------------------------------
| 管理者用ルーティング
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function () {
    // 登録
    Route::get('register', [AdminRegisterController::class, 'create'])
        ->name('admin.register');

    Route::post('register', [AdminRegisterController::class, 'store']);

    // ログイン
    Route::get('login', [AdminLoginController::class, 'showLoginPage'])
        ->name('admin.login');

    Route::post('login', [AdminLoginController::class, 'login']);

    // 以下の中は認証必須のエンドポイントとなる
    Route::middleware(['auth:admin'])->group(function () {
        // ダッシュボード
        Route::get('dashboard', fn() => view('admin.dashboard'))
            ->name('admin.dashboard');
            
    Route::get('/chat/{user}', [AdminChatController::class, 'openChat']);
    Route::get('/looks', [AdminChatController::class, 'index'])->name('admin.looks');   
    Route::post('/chat', [AdminChatController::class, 'sendMessage']);
    });
});


Route::controller(PostController::class)->prefix('posts')->name('posts')->group(function() {});

Route::post('/posts/like', [PostController::class, 'like'])->name('posts.like');


   
Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/posts/create', [PostController::class, 'create']);
Route::get("/posts/{post}", [PostController::class ,"show"]);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class,'delete']);

Route::get('/looks', [ChatController::class, 'index'])->name('looks');

