<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
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

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/article/{slug}', [PostController::class, 'show'])->name('posts.single');
Route::get('/article/{id}/loadMore', [CommentController::class, 'loadMore'])->name('comments.loadmore');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.single');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tags.single');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/contact', [UserController::class, 'contactForm'])->name('contact');
Route::post('/contact/store', [UserController::class, 'contactStore'])->name('contact.store');
Route::post('/comment/{id}/store', [CommentController::class, 'store'])->name('comments.store');


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/categories/refresh', [AdminCategoryController::class, 'refresh']);
    Route::get('/posts/refresh', [AdminPostController::class, 'refresh']);
    Route::get('/tags/refresh', [AdminTagController::class, 'refresh']);
    Route::get('/users/refresh', [AdminUserController::class, 'refresh']);

    Route::get('/', [MainController::class, 'index'])->name('admin.index');

    Route::resources([
        '/categories' => AdminCategoryController::class,
        '/tags' => AdminTagController::class,
        '/posts' => AdminPostController::class,
        '/users' => AdminUserController::class,
    ]);
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [UserController::class, 'create'])->name('register.create');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');
    Route::get('/login', [UserController::class, 'loginForm'])->name('login.create');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
