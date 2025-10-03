<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DayController;
use App\Http\Controllers\ReadyController;

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

Route::get('login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::resource('day', DayController::class);
    Route::post('day/edit', [DayController::class, 'update'])->name('day.edit');
    Route::delete('day/delete', [DayController::class, 'destroy'])->name('day.delete');
    Route::post('day/finalize', [DayController::class, 'finalize'])->name('day.finalize');

    Route::get('day/{id}/ready', [DayController::class, 'getReady']);
    Route::post('day/board-update', [DayController::class, 'boardUpdate'])->name('day.board-update');
    Route::post('day/board-next', [DayController::class, 'boardNext'])->name('day.board-next');
    Route::get('day/board-nextmanual/{id}/{i}/{day}', [DayController::class, 'boardManual'])->name('day.manual');

    Route::get('day/tv-proyectar/{id}', [DayController::class, 'tv'])->name('day.tv');
    Route::get('day/prinf/{id}', [DayController::class, 'prinf'])->name('day.prinf');


    Route::resource('ready', ReadyController::class);
    Route::post('ready/update', [ReadyController::class, 'update'])->name('ready.update');
    Route::post('ready/update/total-weight', [ReadyController::class, 'update_total_weight'])->name('ready.update.total_weight');
    Route::delete('ready/delete', [ReadyController::class, 'destroy'])->name('ready.delete');
});
Route::get('board', [DayController::class, 'getBoard'])->name('board.board');

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');


