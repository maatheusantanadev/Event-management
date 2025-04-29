<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DiscountCouponController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\AuthController;




# Rota de signup
Route::post('/signup', [AuthController::class, 'signup']);

# Rota de login
Route::post('/login', [AuthController::class, 'login']);


# Rotas para CRUD USERS
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'index']);           
    Route::post('/', [UserController::class, 'store']);         
    Route::get('/{user}', [UserController::class, 'show']);   
    Route::put('/{user}', [UserController::class, 'update']);    
    Route::delete('/{user}', [UserController::class, 'destroy']); 
});


# Rotas para CRUD PRODUCERS
Route::prefix('producers')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProducerController::class, 'index']); 
    Route::post('/', [ProducerController::class, 'store']); 
    Route::get('/{producer}', [ProducerController::class, 'show']); 
    Route::put('/{producer}', [ProducerController::class, 'update']);
    Route::delete('/{producer}', [ProducerController::class, 'destroy']); 
});


# Rotas para CRUD EVENTS 
Route::prefix('events')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::post('/', [EventController::class, 'store']); 
    Route::get('/{event}', [EventController::class, 'show']); 
    Route::put('/{event}', [EventController::class, 'update']); 
    Route::delete('/{event}', [EventController::class, 'destroy']); 
});


# Rotas para CRUD SECTORS
Route::prefix('sectors')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [SectorController::class, 'index']); 
    Route::post('/', [SectorController::class, 'store']); 
    Route::get('/{sector}', [SectorController::class, 'show']); 
    Route::put('/{sector}', [SectorController::class, 'update']); 
    Route::delete('/{sector}', [SectorController::class, 'destroy']); 
});


# Rotas para CRUD LOTS
Route::prefix('lots')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [LotController::class, 'index']); 
    Route::post('/', [LotController::class, 'store']); 
    Route::get('/{lot}', [LotController::class, 'show']); 
    Route::put('/{lot}', [LotController::class, 'update']); 
    Route::delete('/{lot}', [LotController::class, 'destroy']); 
});


# Rotas para CRUD TICKETS
Route::prefix('tickets')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TicketController::class, 'index']); 
    Route::post('/', [TicketController::class, 'store']); 
    Route::get('/{ticket}', [TicketController::class, 'show']); 
    Route::put('/{ticket}', [TicketController::class, 'update']); 
    Route::delete('/{ticket}', [TicketController::class, 'destroy']); 
});


#ROTAS para CRUD COUPONS
Route::prefix('coupons')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [DiscountCouponController::class, 'index']); 
    Route::post('/', [DiscountCouponController::class, 'store']); 
    Route::get('/{coupon}', [DiscountCouponController::class, 'show']); 
    Route::put('/{coupon}', [DiscountCouponController::class, 'update']); 
    Route::delete('/{coupon}', [DiscountCouponController::class, 'destroy']); 
});


# Rotas para CRUD PAYMENTS
Route::prefix('payments')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PaymentController::class, 'index']); 
    Route::post('/', [PaymentController::class, 'store']); 
    Route::get('/{payment}', [PaymentController::class, 'show']); 
    Route::put('/{payment}', [PaymentController::class, 'update']);
    Route::delete('/{payment}', [PaymentController::class, 'destroy']); 
});
















