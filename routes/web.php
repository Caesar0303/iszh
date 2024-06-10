<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/animals', [\App\Http\Controllers\AnimalController::class,'index'])->name('animals');
Route::get('/animal/create', [\App\Http\Controllers\AnimalController::class,'create'])->name('animal.create');
Route::post('/animal/store', [\App\Http\Controllers\AnimalController::class,'store'])->name('animal.store');
Route::get('/animal/{id}/show', [\App\Http\Controllers\AnimalController::class,'show'])->name('animal.show');
Route::get('/animal/{id}/delete', [\App\Http\Controllers\AnimalController::class,'delete'])->name('animal.delete');
Route::get('/chat/open/', [\App\Http\Controllers\MessengerController::class,'list']);
Route::get('/send_message/{id}/', [\App\Http\Controllers\MessengerController::class,'sendMessage']);
Route::get('/get_messages_count', [\App\Http\Controllers\MessengerController::class,'getUncheckedMessagesCount']);
Route::get('/mypage', [\App\Http\Controllers\AnimalController::class,'mypage'])->name('profile.mypage');
Route::post('/send_message_to/{id}/', [\App\Http\Controllers\MessengerController::class,'sendMessageTo']);
Route::match(['get', 'post'], '/animals/filter', [\App\Http\Controllers\AnimalController::class,'filter'])->name('animal.filter');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AnimalController::class,'index'])
    ->name('dashboard');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
