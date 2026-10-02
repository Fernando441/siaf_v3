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
use App\Models\Unidad\Unidad;
use App\Models\User;
use App\Models\Translados\Translados;
use App\Models\Translados\TransladosUnidad;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class TransladosUnidadesImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
        // $this->licitacion = $licitacion;
    }


    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row){
            $id_unidad = Unidad::where('no_serie', $row['unidad'])->first();
            $id_transportista = User::where('id', $row['transladista'])->first();
            $translado_id = Translados::latest('id')->first();

            if($id_unidad == null){

            }else{
                $data = [
                    'translados_id' => $translado_id->id,
                    'unidad_id' => $id_unidad->id,
                    'id_transportista' => $id_transportista->id,
                    'fecha_translado'=>$row['fecha_translado'],
                    'tipo_asignacion'=>$row['tipo_unidad'],
                    'requerimiento'=>$row['requerimiento'],
                    'transladadora'=>$row['transladadora'],
                    'origen'=>$row['origen'],
                    'cto_origen'=>$row['cto_origen'],
                    'destino'=>$row['destino'],
                    'cto_destino'=>$row['cto_destino'],
                    'estatus'=>$row['estatus'],
                    'recoleccion'=>$row['recoleccion'],
                    'inv_prov_sistema'=>$row['inv_prov_sistema'],
                    'observaciones'=>$row['observaciones'],
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                TransladosUnidad::insert($data);               
            }

        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('user.catalogousuarios');
    }

}