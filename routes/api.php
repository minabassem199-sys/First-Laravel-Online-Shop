<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| هنا بتتعامل مع Postman أو أي API Client
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



