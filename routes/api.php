<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::apiResource('authors', AuthorController::class);
Route::apiResource('books', BookController::class);

Route::get('loans', [LoanController::class, 'index']);
Route::patch('loans/{loan}/return', [LoanController::class, 'returnBook']);
