<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\SupervisorController;


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

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('volunteers', VolunteerController::class);
    //Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::controller(BorrowingController::class)->group(function () {
        Route::get('/borrowings', 'index')->name('borrowings.index');
        Route::get('/borrowings/create', 'create')->name('borrowings.create');
        Route::post('/borrowings', 'store')->name('borrowings.store');
        Route::get('/borrowings/{borrowing}/edit', 'edit')->name('borrowings.edit');
        Route::put('/borrowings/{borrowing}', 'update')->name('borrowings.update');
        Route::delete('/borrowings/{borrowing}', 'destroy')->name('borrowings.destroy');
        Route::get('/borrowings/search', 'search')->name('borrowings.search');
    });
    Route::controller(VolunteerController::class)->group(function () {
        Route::get('/volunteers', 'index')->name('volunteers.index');
        Route::get('/volunteers/create', 'create')->name('volunteers.create');
        Route::post('/volunteers', 'store')->name('volunteers.store');
        Route::get('/volunteers/{volunteer}/edit', 'edit')->name('volunteers.edit');
        Route::put('/volunteers/{volunteer}', 'update')->name('volunteers.update');
        Route::delete('/volunteers/{volunteer}', 'destroy')->name('volunteers.destroy');
    });
    
    Route::controller(BookController::class)->group(function () {
        Route::get('/books', 'index')->name('books.index');
        Route::get('/books/create', 'create')->name('books.create');
        Route::post('/books', 'store')->name('books.store');
        Route::get('/books/{book}/edit', 'edit')->name('books.edit');
        Route::put('/books/{book}', 'update')->name('books.update');
        Route::delete('/books/{book}', 'destroy')->name('books.destroy');
    });
    
    /*Route::controller(MemberController::class)->group(function () {
        Route::get('/members', 'index')->name('members.index');
        Route::get('/members/create', 'create')->name('members.create');
        Route::post('/members', 'store')->name('members.store');
        Route::get('/members/{member}/edit', 'edit')->name('members.edit');
        Route::put('/members/{member}', 'update')->name('members.update');
        Route::delete('/members/{member}', 'destroy')->name('members.destroy');
    });*/
});
