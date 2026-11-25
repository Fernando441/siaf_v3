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
use App\Models\Cliente\Municipio;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class MunicipiosImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
        // $this->licitacion = $licitacion;
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            
            $mun_id = Municipio::where('municipio_nombre', $row['municipio_nombre'])->first();
            if($mun_id == null){
                $data = [
                    'municipio_nombre' => $row['municipio_nombre'],
                    'id_estado' => $row['id_estado'],
                    'id_status_delete' => 1,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];

                Municipio::insert($data);                
            }
  
        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('cliente.catalogoMunicipio');
    }

}