<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'redirect']);

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

Route::resource('rooms', RoomController::class)->except('show');
Route::resource('floors', FloorController::class)->only('index', 'create', 'store');
Route::get('floors/{floor}/edit', [FloorController::class, 'edit'])->name('floors.edit');
Route::put('floors/{floor}', [FloorController::class, 'update'])->name('floors.update');
Route::delete('floors/{floor}', [FloorController::class, 'destroy'])->name('floors.destroy');

Route::get('reservations/success', [ReservationController::class, 'confirm'])->name('reservations.confirm')->middleware(['auth:client', 'verified']);
Route::get('reservations/{room}', [ReservationController::class, 'create'])->name('reservations.create')->middleware(['auth:client', 'verified']);
Route::post('reservations/{room}', [ReservationController::class, 'store'])->name('reservations.store')->middleware(['auth:client', 'verified']);

Route::resource('managers', ManagerController::class)->except(['index', 'create', 'store', 'show']);
Route::resource('receptionists', ReceptionistController::class)->except(['create', 'store', 'show']);
Route::resource('clients', ClientController::class)->except(['index', 'create', 'store', 'show']);
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
    Route::get('receptionists/{receptionist}', [ReceptionistController::class, 'ban'])->name('receptionists.ban');
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
