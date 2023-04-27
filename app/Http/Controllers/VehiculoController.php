<?php

namespace App\Http\Controllers;

use App\Exports\VehiculosExport;
use App\Http\Resources\VehiculoResource;
use App\Models\User;
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

    }

    /**
     * Show the form for creating a new resource.
     */
    public function export($user_id)
    {
        $user = User::findOrfail($user_id);
        $vehiculos = Vehiculo::where('user_id', $user_id)
                                ->select('id', 'placa', 'telefono', 'color', 'estado','created_at', 'updated_at')
                                ->get();
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
            'userId' => 'required|numeric',
        ]);

        $vehiculo = Vehiculo::create([
            'placa' => $request->placa,
            'telefono' => $request->telefono,
            'color' => $request->color,
            'estado' => $request->estado,
            'user_id' => $request->userId,
        ]);

        return response()->json(['status'=>'Vehicle successfully created.']);
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
    public function search($user_id, Request $request)
    {
        $user = User::findOrfail($user_id);
        $query = $request->input('q');
        $perPage = $request->input('perPage', 10);

        if (!is_null($query)) {
            $vehiculos = Vehiculo::where('user_id', $user->id)
                                    ->where('color', 'LIKE', '%'.$query.'%')
                                    ->orWhere('placa', 'LIKE', '%'.$query.'%')
                                    ->orWhere('telefono', 'LIKE', '%'.$query.'%')
                                    ->latest()
                                    ->paginate($perPage);
            return VehiculoResource::collection($vehiculos);
        }
        elseif (is_null($query)) {
            $vehiculos = Vehiculo::where('user_id', $user->id)->latest()->paginate($perPage);
            return VehiculoResource::collection($vehiculos);


        }

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
            'userId' => 'required|numeric',
        ]);

        $vehiculo->placa = $request->placa;
        $vehiculo->telefono = $request->telefono;
        $vehiculo->color = $request->color;
        $vehiculo->estado = $request->estado;
        $vehiculo->user_id = $request->userId;

        $vehiculo->save();
        sleep(1);
        return response()->json(['status'=>'Vehicle successfully edited.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->estado = 0;
        $vehiculo->save();
        sleep(1);
        return response()->json(['status'=>'Vehicle successfully delete.']);
    }
}
