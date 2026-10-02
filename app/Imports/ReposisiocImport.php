<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Unidad\TramiteGpsInfo;
use App\Models\Unidad\Unidad;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class ReposisiocImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
        // $this->licitacion = $licitacion;
    }


    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row){
            
            $no_serie = Unidad::where('no_serie', $row['no_serie'])->first();
            $upd_info_tenencia = TramiteGpsInfo::where('unidad_id', $no_serie->id)->where('op_estatus', 1)->get();
            // dd($upd_info_tenencia);
            foreach ($upd_info_tenencia as $key => $value) {
                $data = [
                    'op_estatus' => 2,
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,        
                ];
                TramiteGpsInfo::where('id', $value->id)->update($data);
            }

            $data = [
                'unidad_id' => $no_serie->id,
                'unidad_tramite_gestor_id' => $row['gestor'],
                'id_propietario' => $row['propietario'],
                'fecha_tramite' => $row['fecha_movimiento'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_movimiento'])->format('Y-m-d') : null,
                'importe' => $row['importe'],
                'op_estatus' => 1,
                'observaciones'=>$row['observaciones'],
                'id_status_delete'=>1,
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            TramiteGpsInfo::insert($data);
        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

}