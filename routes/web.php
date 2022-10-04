<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\RoomController;

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

Route::middleware(['auth:web', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard', ['user' => Auth::guard('web')->user()]);
    })->name('admin.dashboard');
});

Route::middleware(['auth:web', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('dashboard', ['user' => Auth::guard('web')->user()]);
    })->name('manager.dashboard');
});

Route::middleware(['auth:web', 'role:receptionist'])->group(function () {
    Route::get('/receptionist/dashboard', function () {
        return view('dashboard', ['user' => Auth::guard('web')->user()]);
    })->name('receptionist.dashboard');
});

Route::middleware(['auth:client'])->group(function () {
    Route::get('/client/dashboard', function () {
        return view('client.dashboard', ['user' => Auth::guard('client')->user()]);
    })->name('client.dashboard');
});


Route::prefix('staff')->group(function () {
    require __DIR__ . '/auth.php';
});


Route::prefix('admin')->group(function () {
    require __DIR__ . '/admin-auth.php';
});

Route::prefix('client')->group(function () {
    require __DIR__ . '/client-auth.php';
});


Route::get('/redirect', [HomeController::class, 'redirect'])->name('redirect');

Route::resource('rooms', RoomController::class);
Route::resource('floors', FloorController::class);
Route::resource('reservations', ReservationController::class)->only(['index', 'store']);
Route::get('reservations/success', [ReservationController::class, 'confirm'])->name('reservations.confirm');
Route::get('reservations/{room}', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('reservations/{room}', [ReservationController::class, 'store'])->name('reservations.store');


Route::resource('managers', ManagerController::class)->except(['create', 'store', 'show']);
Route::resource('receptionists', ReceptionistController::class)->except(['create', 'store', 'show']);
Route::resource('clients', ClientController::class)->except(['create', 'store', 'show']);
Route::put('clients/approve/{client}', [ClientController::class, 'approve'])->name('clients.approve');


Route::prefix('admin/')->middleware(['auth:web', 'role:admin'])->group(function () {
    Route::get('managers', [ManagerController::class, 'index']);
    Route::get('receptionists', [ReceptionistController::class, 'index']);
    Route::get('clients', [ClientController::class, 'index']);
    Route::get('floors', [FloorController::class, 'index']);
    Route::get('rooms', [RoomController::class, 'index']);
    Route::get('reservations', [ReservationController::class, 'index']);
});

Route::prefix('manager/')->middleware(['auth:web', 'role:manager'])->group(function () {
    Route::get('receptionists', [ReceptionistController::class, 'index']);
    Route::get('clients', [ClientController::class, 'index']);
    Route::get('floors', [FloorController::class, 'index']);
    Route::get('rooms', [RoomController::class, 'index']);
    Route::get('reservations', [ReservationController::class, 'index']);
});

Route::prefix('receptionist/')->middleware(['auth:web', 'role:receptionist'])->group(function () {
    Route::get('my-clients', [ClientController::class, 'getMyAccepted']);
    Route::get('clients', [ClientController::class, 'getNotAcceptedYet']);
    Route::get('reservations', [ReservationController::class, 'getAcceptedClientsReservations']);
});

Route::get('rooms', [RoomController::class, 'getUnreservedRooms']);
Route::prefix('client/')->group(function () {
    Route::get('reservations', [ReservationController::class, 'getClientReservations'])->middleware(['auth:client']);
});
