<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailVerificationNotificationController;
use App\Http\Controllers\EmailVerificationPromptController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:basic')->group(function () {

    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/article/{post:slug}', [PostController::class, 'show'])->name('posts.single');
    Route::get('/article/{post}/loadMore', [CommentController::class, 'loadMore'])->name('comments.loadmore');
    Route::post('/article/{post_id}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.single');
    Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tags.single');
    Route::get('/search', [SearchController::class, '__invoke'])->name('search');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact/store', [ContactController::class, 'store'])->middleware('verified')->name('contact.store');
    Route::post('/newsletter', [NewsletterController::class, '__invoke'])->name('newsletter');
    Route::post('/rating/change', [RatingController::class, '__invoke'])->name('rating.change')->middleware('throttle:rating');

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [RegisterController::class, 'index'])->name('register.create');
        Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
        Route::get('/login', [LoginController::class, 'index'])->name('login.create');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.form');
        Route::post('/store-password', [ForgotPasswordController::class, 'store'])->name('password.store');
        Route::get('/reset-password', [ResetPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware('auth')->name('verification.verify');
        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, '__invoke'])->name('verification.send');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'throttle:admin']], function () {
    Route::get('/categories/refresh', [AdminCategoryController::class, 'refresh'])->name('categories.refresh');
    Route::get('/posts/refresh', [AdminPostController::class, 'refresh'])->name('posts.refresh');
    Route::get('/tags/refresh', [AdminTagController::class, 'refresh'])->name('tags.refresh');
    Route::get('/users/refresh', [AdminUserController::class, 'refresh'])->name('users.refresh');

    Route::get('/', [MainController::class, 'index'])->name('admin.index');

    Route::resources([
        '/categories' => AdminCategoryController::class,
        '/tags' => AdminTagController::class,
        '/posts' => AdminPostController::class,
        '/users' => AdminUserController::class,
    ]);

    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    Route::put('/messages/markAllAsRead', [AdminMessageController::class, 'markAllAsRead'])->name('messages.markAllAsRead');
    Route::put('/messages/markAllAsUnread', [AdminMessageController::class, 'markAllAsUnread'])->name('messages.markAllAsUnread');
    Route::put('message/{id}/markAsRead', [AdminMessageController::class, 'markAsRead'])->name('messages.markAsRead');
    Route::put('message/{id}/markAsUnread', [AdminMessageController::class, 'markAsUnread'])->name('messages.markAsUnread');
});
