<?php

use App\Controllers\AdminController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\MovieController;
use App\Controllers\RegisterController;
use App\Controllers\ReviewController;
use App\Kernel\Router\Route;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

return [
    Route::get('/register', [RegisterController::class, 'index'],[GuestMiddleware::class]),
    Route::post('/register', [RegisterController::class, 'register'], [GuestMiddleware::class]),
    Route::get('/login', [LoginController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/login', [LoginController::class, 'login'], [GuestMiddleware::class]),

    Route::post('/logout', [LoginController::class, 'logout'], [AuthMiddleware::class]),

    Route::get('/admin', [AdminController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::get('/admin/categories/add', [CategoryController::class, 'create'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/categories/add', [CategoryController::class, 'store'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/categories/destroy', [CategoryController::class, 'destroy'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::get('/admin/categories/update', [CategoryController::class, 'edit'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/categories/update', [CategoryController::class, 'update'], [AuthMiddleware::class, AdminMiddleware::class]),

    Route::get('/admin/movies/add', [MovieController::class, 'create'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/movies/add', [MovieController::class, 'store'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/movies/destroy', [MovieController::class, 'destroy'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::get('/admin/movies/update', [MovieController::class, 'edit'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/movies/update', [MovieController::class, 'update'], [AuthMiddleware::class, AdminMiddleware::class]),

    Route::get('/', [MovieController::class, 'home']),
    Route::get('/movie', [MovieController::class, 'show']),
    Route::post('/reviews/add', [ReviewController::class, 'store']),
    Route::get('/categories', [CategoryController::class, 'index']),
    Route::get('/categories/category', [CategoryController::class, 'show']),
    Route::get('/best', [MovieController::class, 'best']),
];
