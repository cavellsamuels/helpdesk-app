<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AllTicketsController;
use App\Http\Controllers\AssignedTicketContrroller;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UnassignedTicketContrroller;

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

Route::get('/', AllTicketsController::class)->name('show.global.dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/search', [SearchController::class, 'show'])->name('search.ticket');
    Route::get('/assigneddashboard', AssignedTicketContrroller::class)->name('show.assigned.dashboard');
    Route::get('/unassigneddashboard', UnassignedTicketContrroller::class)->name('show.unassigned.dashboard');
});

Route::group(['prefix' => 'tickets'], function () {
    Route::get('/create', [TicketController::class, 'create'])->name('create.ticket');
    Route::post('/store', [TicketController::class, 'store'])->name('store.ticket');
    Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('edit.ticket');
    Route::put('/{ticket}/update', [TicketController::class, 'update'])->name('update.ticket');
    Route::get('/{ticket}/show', [TicketController::class, 'show', CommentController::class, 'show'])->name('show.ticket');
});

Route::group(['prefix' => 'tickets', 'middleware' => 'auth'], function () {
    Route::delete('/{ticket}/delete', [TicketController::class, 'delete'])->name('delete.ticket');
    Route::get('{ticket}/download/{file}', [FileController::class, 'download'])->name('file.download');
    Route::get('/linked', [TicketController::class, 'linked'])->name('show.linked');
    Route::get('/{tickets}/editlinked', [TicketController::class, 'updatelinked'])->name('edit.linked');
    Route::put('/{tickets}/updatelinked', [TicketController::class, 'updatelinked'])->name('update.linked');
});

Route::group(['prefix' => 'comments'], function () {
    Route::post('{ticket}/store', [CommentController::class, 'store'])->name('create.comment');
    Route::get('{ticket}/edit/{comment}', [CommentController::class, 'edit'])->name('edit.comment');
    Route::put('{ticket}/update/{comment}', [CommentController::class, 'update'])->name('update.comment');
    Route::delete('{ticket}/delete/{comment}', [CommentController::class, 'delete'])->name('delete.comment');
});
