<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GymController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VerifyEmailController;
use App\Models\Equipment;
use Illuminate\Container\Attributes\Auth;

// public routes
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

// email verification
// Route::post('/email/verify/{id}/{hash}',[VerifyEmailController::class, 'verify'])
//         ->name('verification.verify')
//         ->middleware('signed', 'throtle5,1');
        

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout',[AuthController::class, 'logout']);


Route::post('/createRole', [RoleController::class, 'createRole']);
Route::get('/getAllRoles', [RoleController::class, 'readAllRoles']);
Route::get('/getRoles/{id}', [RoleController::class, 'readRoles']);
Route::post('/updateRoles/{id}', [RoleController::class, 'updateRoles']);
Route::delete('/deleteRoles/{id}', [RoleController::class, 'deleteRoles']);


Route::post('/createCategory', [CategoryController::class, 'createCategory']);
Route::get('/getAllCategories', [CategoryController::class, 'readAllCategories']);
Route::get('/getCategory/{id}', [CategoryController::class, 'readCategory']);
Route::post('/updateCategory/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('/deleteCategory/{id}', [CategoryController::class, 'deleteCategory']);

Route::post('/createGym', [GymController::class, 'createGym']);
Route::get('/getAllGyms', [GymController::class, 'readAllGyms']);
Route::get('/getGym/{id}', [GymController::class, 'readGym']);
Route::post('/updateGym/{id}', [GymController::class, 'updateGym']);
Route::delete('/deleteGym/{id}', [GymController::class, 'deleteGym']);

Route::post('/createBundle', [BundleController::class, 'createBundle']);
Route::get('/getAllBundles', [BundleController::class, 'readAllBundles']);
Route::get('/getBundle/{id}', [BundleController::class, 'readBundle']);
Route::post('/updateBundle/{id}', [BundleController::class, 'updateBundle']);
Route::delete('/deleteBundle/{id}', [BundleController::class, 'deleteBundle']);


Route::post('/createEquipment', [EquipmentController::class, 'createEquipment']);
Route::get('/getAllEquipments', [EquipmentController::class, 'readAllEquipments']);
Route::get('/getEquipment/{id}', [EquipmentController::class, 'readEquipment']);
Route::post('/updateEquipment/{id}', [EquipmentController::class, 'updateEquipment']);
Route::delete('/deleteEquipment/{id}', [EquipmentController::class, 'deleteEquipment']);

Route::post('/createSubscription', [SubscriptionController::class, 'createSubscription']);
Route::get('/getAllSubscriptions', [SubscriptionController::class, 'readAllSubscriptions']);
Route::get('/getSubscription/{id}', [SubscriptionController::class, 'readSubscription']);
Route::post('/updateSubscription/{id}', [SubscriptionController::class, 'updateSubscription']);
Route::delete('/deleteSubscription/{id}', [SubscriptionController::class, 'deleteSubscription']);

});