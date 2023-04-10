<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehiculoResource;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehiculo = Vehiculo::latest()->paginate(10);
        return VehiculoResource::collection($vehiculo);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|numeric',
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
            'placa' => 'required|numeric',
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->status = 0;
        $vehiculo->save();
        sleep(1);
    }
}
