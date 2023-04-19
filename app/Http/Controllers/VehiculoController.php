<?php

namespace App\Http\Controllers;

use App\Exports\VehiculosExport;
use App\Http\Resources\VehiculoResource;
use App\Models\Vehiculo;
use Illuminate\Http\Request;/*
use Maatwebsite\Excel\Excel; */
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehiculos = Vehiculo::latest()->paginate(10);
        return VehiculoResource::collection($vehiculos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function export()
    {
        $vehiculos = Vehiculo::all();
        return Excel::download(new VehiculosExport($vehiculos), 'vehiculos.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'color' => 'required|string|max:255',
            'estado' => 'required|numeric',
        ]);

        $vehiculo = Vehiculo::create([
            'placa' => $request->placa,
            'telefono' => $request->telefono,
            'color' => $request->color,
            'estado' => $request->estado,
        ]);
        return response()->json(['status'=>'Vehicle successfully created.',201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehiculo $vehiculo)
    {
        return new VehiculoResource($vehiculo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrfail($id);
        $request->validate([
            'placa' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'color' => 'required|string|max:255',
            'estado' => 'required|numeric',
        ]);

        $vehiculo->placa = $request->placa;
        $vehiculo->telefono = $request->telefono;
        $vehiculo->color = $request->color;
        $vehiculo->estado = $request->estado;

        $vehiculo->save();
        sleep(1);
        return response()->json(['status'=>'Vehicle successfully edited.',201]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->estado = 0;
        $vehiculo->save();
        sleep(1);
        return response()->json(['status'=>'Vehicle successfully delete.',201]);
    }
}
