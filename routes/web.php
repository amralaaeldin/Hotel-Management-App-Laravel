<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\User;

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

// Route::get('/stuff/dashboard', function () {
//     return view('dashboard');
// })->name('stuff.dashboard');
// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// })->name('admin.dashboard');

Route::prefix('stuff')->group(function () {
require __DIR__.'/auth.php';
});


Route::prefix('admin')->group(function () {
    require __DIR__.'/admin-auth.php';
});


Route::get('/redirect', [HomeController::class, 'redirect']);


Route::get('/test', function () {
    return User::where('id',1)->first()->getRoleNames();
}
)
;


Route::resource('rooms', RoomController::class);
Route::resource('floors', FloorController::class);
Route::resource('reservations', ReservationController::class);

Route::resource('managers', ManagerController::class);
Route::resource('admins', AdminController::class);
Route::resource('reciptionists', ReciptionistController::class);
Route::resource('clients', ClientController::class);
