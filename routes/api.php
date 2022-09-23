<?php

use App\Api\V1\Http\Controllers\BuildingController;
use App\Api\V1\Http\Controllers\RecipeController;
use App\Api\V1\Http\Controllers\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    // Resources
    $api->get('resources', [ResourceController::class, 'index']);
    $api->get('resources/{resource}', [ResourceController::class, 'show']);
    // Recipes
    $api->get('resources/{resource}/recipes', [RecipeController::class, 'index']);
    $api->get('resources/{resource}/recipes/{recipe}', [RecipeController::class, 'show']);
    // Buildings
    $api->get('buildings', [BuildingController::class, 'index']);
    $api->get('buildings/{building}', [BuildingController::class, 'show']);
}); // end version group
