<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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

Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/users/search', [UserController::class, 'search'])->name('user.search');
Route::get('/user/{slug}', [UserController::class, 'show'])->name('user.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('/articles/search', [ArticleController::class, 'search'])->name('article.search');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
