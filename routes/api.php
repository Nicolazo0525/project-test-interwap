<?php

use App\Http\Controllers\VehiculoController;
use App\Exports\VehiculosExport;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


/* Route::middleware(['auth', 'second'])->group(function () {

}); */
Route::apiResource('vehiculos',VehiculoController::class)/* ->middleware('vehiculo.middleware:sanctum') */;
Route::get('/export',[VehiculoController::class, 'export'])->name('export');
Route::get('/exportar', function () {
    $vehiculos = Vehiculo::all();
    return Excel::download(new VehiculosExport($vehiculos), 'vehiculos.xlsx'); // Generar y devolver el archivo Excel
});
