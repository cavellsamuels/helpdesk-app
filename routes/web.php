<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TicketController;
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

Route::middleware('guest')->group(function () {
    Route::get('/', [PageController::class, 'showIndex'])->name('show.index');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PageController::class, 'showGlobalDashboard'])->name('show.global.dashboard');
    Route::any('/search', [TicketController::class, 'search'])->name('search.ticket');
    Route::get('/assigneddashboard', [PageController::class, 'showAssignedDashboard'])->name('show.assigned.dashboard');
    Route::get('/unassigneddashboard', [PageController::class, 'showUnassignedDashboard'])->name('show.unassigned.dashboard');
});

Route::group(['prefix' => 'tickets'], function () {
    Route::get('/create', [TicketController::class, 'create'])->name('create.ticket');
    Route::post('/store', [TicketController::class, 'store'])->name('store.ticket');
    Route::get('/edit/{ticket}', [TicketController::class, 'edit'])->name('edit.ticket');
    Route::put('/update/{ticket}', [TicketController::class, 'update'])->name('update.ticket');
    Route::get('/show/{ticket}', [TicketController::class, 'show', CommentController::class, 'show'])->name('show.ticket');
});

Route::group(['prefix' => 'tickets'], function () {
    Route::middleware('auth')->group(function () {
        Route::delete('/delete/{ticket}', [TicketController::class, 'delete'])->name('delete.ticket');
        Route::get('/linked', [TicketController::class, 'linktickets'])->name('linked.ticket');
        Route::get('editlinked/{tickets}', [TicketController::class, 'updatelinked'])->name('edit.tickets');
        Route::put('updatelinked/{tickets}', [TicketController::class, 'updatelinked'])->name('update.tickets');
        Route::get('{ticket}/download{file}', [FileController::class, 'download'])->name('file.download');
    });
});

Route::group(['prefix' => 'comments'], function () {
    Route::post('{ticket}/store', [CommentController::class, 'store'])->name('create.comment');
    Route::get('{ticket}/edit/{comment}', [CommentController::class, 'edit'])->name('edit.comment');
    Route::put('{ticket}/update/{comment}', [CommentController::class, 'update'])->name('update.comment');
    Route::delete('{ticket}/delete/{comment}', [CommentController::class, 'delete'])->name('delete.comment');
});
