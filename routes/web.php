<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\StaticContentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SponsorController;



Route::get('/menu', [ArticleController::class, 'showMenu']);





Route::get('/', [ArticleController::class, 'index'])->name('home');;
Route::get('/article/{id}', [ArticleController::class, 'show']);
Route::post('/article/{id}/favorite', [ArticleController::class, 'addFavorite']);
Route::get('/favorites', [ArticleController::class, 'showFavorites']);
Route::post('/article/{id}/remove_favorite', [ArticleController::class, 'removeFavorite']);  
Route::post('/customize', [ArticleController::class, 'customize']);


Route::get('/about', [StaticContentController::class, 'about'])->name('about');
// Page de connexion
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Action pour se connecter
Route::post('/login', [LoginController::class, 'loginAction'])->name('login.action');

// Action pour se déconnecter
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/sponsor', [SponsorController::class, 'showBanner']);


