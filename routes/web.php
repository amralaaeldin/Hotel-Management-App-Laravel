<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth:web', 'role:stuff'])->group(function () {
Route::get('/stuff/dashboard', function () {
    return view('stuff.dashboard');
})->name('stuff.dashboard');
});

Route::middleware(['auth:web', 'role:admin'])->group(function () {
Route::get('/admin/dashboard', function () {
        return view('admins.dashboard');
    })->name('admin.dashboard');
});

Route::prefix('stuff')->group(function () {
require __DIR__.'/auth.php';
});


Route::prefix('admin')->group(function () {
    require __DIR__.'/admin-auth.php';
});


Route::get('/redirect', [HomeController::class, 'redirect']);


Route::resource('rooms', RoomController::class);
Route::resource('floors', FloorController::class);
Route::resource('reservations', ReservationController::class);

Route::resource('managers', ManagerController::class);
Route::resource('admins', AdminController::class);
Route::resource('reciptionists', ReciptionistController::class);
Route::resource('clients', ClientController::class);
