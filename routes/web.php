<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UfController;
use App\Http\Controllers\RodoviaController;
use App\Http\Controllers\TrechoController;

Route::get('/trechos', [TrechoController::class, 'index']);
Route::get('/trechos/{id}', [TrechoController::class, 'show']);
Route::post('/trechos', [TrechoController::class, 'store']);
Route::put('/trechos/{id}', [TrechoController::class, 'update']);
Route::delete('/trechos/{id}', [TrechoController::class, 'destroy']);


Route::get('/geojson', [TrechoController::class, 'getGeojson']);

Route::get('/ufs', [UfController::class, 'index']);
Route::get('/rodovias', [RodoviaController::class, 'index']);

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/create', function () {
    return Inertia::render('Create');
});

Route::get('/detalhes/{id}', function ($id) {
    $trecho = \App\Models\Trecho::with(['uf', 'rodovia'])->findOrFail($id);
    return Inertia::render('Show', ['trecho' => $trecho]);
});

Route::get('/editar/{id}', function ($id) {
    $trecho = \App\Models\Trecho::with(['uf', 'rodovia'])->findOrFail($id);
    return Inertia::render('Edit', ['trecho' => $trecho]);
});
