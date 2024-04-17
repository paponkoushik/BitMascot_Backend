<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth/'], function (Router $router) {

    $router->post('login', [AuthController::class, 'login'])
        ->name('login');

    $router->post('signup', [AuthController::class, 'signup'])
        ->name('signup');

    $router->post('verify', [AuthController::class, 'verify'])
        ->name('verify');
//
//    $router->middleware('jwt.authenticate')
//        ->post('refresh', [AuthController::class, 'refresh'])
//        ->name('refresh');

    $router->middleware('auth:api')
        ->get('myself', [AuthController::class, 'mySelf'])
        ->name('myself');
});

Route::middleware('jwt.auth')->group(callback: function (Router $router) {
    $router->post('auth/logout', [AuthController::class, 'logout'])
        ->name('logout');

    $router->post('change-password', [ChangePasswordController::class, 'changePassword'])
        ->name('changePassword');

    $router->get('download-file/{filename}', [FileController::class, 'downloadFile'])
        ->name('downloadFile');

    $router->get('users', [UserController::class, 'index'])
        ->name('user.index');

});
