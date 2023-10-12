<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    LoginController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(LoginController::class)->group(function () {
    Route::post('v1/login', 'login')->name('login.submit');
    Route::get('/', 'index')->name('login');
});

Route::middleware(['auth:sanctum'])->group(function ($route) {
    $route->controller(TestController::class)->group(function ($app) {
        $app->get("v1/test/get", "index")->name("tester");
    });
});
