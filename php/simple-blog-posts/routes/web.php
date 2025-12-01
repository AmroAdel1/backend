<?php

use App\Http\Controllers\PostsController;      // include controller namespace
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

// 1) route that user can access through browser
Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');        // static route(should be above dynamic route)
Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');            // dynamic route                    // {post} -> url parameter
Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');                // store in db
Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostsController::class, 'destroy'])->name('posts.destroy');


/* name() -> shortcut for route
1) if you have long route name
2) reuse it in other files without renaming the same long route name

change route uri whatever you want
*/

/*
    1) structure change for database (create table, edit column, remove column)     -> migration
    2) operation on database (insert record, update record, delete record)          -> model
*/

// model name => singular
// table name => plural

// view() -> global helper function

// config folder => like .env file. used when want to create key var. to use in env
