<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HouseController;
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
    return view('welcome');
});

/*Route::get('/', function() {
    return view('posts.index');
});*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'sendMessage']);

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


Route::middleware(['auth'])->group(function () {
    // 理想の家の一覧表示
    Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');

    // 新しい家を登録する画面表示
    Route::get('/houses/create', [HouseController::class, 'create'])->name('houses.create');

    // 新しい家のデータを保存
    Route::post('/houses', [HouseController::class, 'store'])->name('houses.store');

    // 家の編集画面表示
    Route::get('/houses/{house}/edit', [HouseController::class, 'edit'])->name('houses.edit');

    // 家のデータを更新
    Route::put('/houses/{house}', [HouseController::class, 'update'])->name('houses.update');

    // 家のデータを削除
    Route::delete('/houses/{house}', [HouseController::class, 'destroy'])->name('houses.destroy');
});
