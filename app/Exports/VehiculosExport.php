<?php

namespace App\Exports;

use App\Models\Vehiculo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehiculosExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $vehiculos;


    public function __construct($vehiculos)
    {
        $this->vehiculos = $vehiculos;
    }

    public function collection()
    {

        return $this->vehiculos;
    }
    
    public function map($row): array
    {
        return [
            $row->id,
            $row->placa,
            $row->telefono,
            $row->estado,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
                \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s')
            ),
        ];
    }
    public function columnFormats(): array
    {
        return [
            'C' => 'yyyy-mm-dd h:mm:ss',
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'placa',
            'telefono',
            'color',
            'estado',
            'Hora de creación',
            'Hora de edición',
        ];
    }
    /* public function collection()
    {
        return Vehiculo::all();
    } */
}
