<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API is working successfully',
        'time' => now()
    ]);
});
use App\Models\Customer;

 

Route::get('/customers', function () {
    return response()->json([
        'status' => true,
        'data' => Customer::all()
    ]);
});

Route::get('/customers/{id}', function ($id) {
    $customer = Customer::find($id);

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $customer
    ]);
    
});
use Illuminate\Support\Facades\Hash;

Route::post('/customers', function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:customers,email',
        'password' => 'required|min:6',
        'phone' => 'nullable'
    ]);

    $customer = \App\Models\Customer::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Customer created successfully',
        'data' => $customer
    ], 201);
});
