<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'customer/createPage', 302)->name("post#home");
// Route::get("/", [PostController::class, "create"])->name("post#home");
Route::get("customer/createPage/", [PostController::class, "create"])->name("post#createPage");
Route::post("post/create", [PostController::class, "postCreate"])->name("post#create");

Route::post("post/delete/{id}", [PostController::class, "postDelete"])->name("post#delete");
// Route::get("post/delete/{id}", [PostController::class, "postDelete"])->name("post#delete");

Route::get("post/updatePage/{id}", [PostController::class, "postUpdatePage"])->name("post#updatePage");
Route::get("post/editPage/{id}", [PostController::class, "postEditPage"])->name("post#editPage");
Route::post("post/update", [PostController::class, "postUpdate"])->name("post#update");


