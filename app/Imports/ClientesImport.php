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
use App\Models\User;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class ClientesImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
       
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            // if($row['estado'] != null){ $estado = $this->obtenerestado($row['estado']); }else{  $estado = ""; }
            // if($row['municipio'] != null){ $municipio = $this->obtenermunicipio($row['municipio'], $estado); }else{  $municipio = ""; }
            $cliente = $this->insertcliente($row);
        }

        session()->flash('success', 'Las unidades se crearon correctamente');
        return redirect()->route('cliente.catalogoCliente');
    }

    public function obtenerestado($estado)
    {
        $data_estado = Estado::where('nombre_estado', $estado)->first();
        if($data_estado == null)
        {
            $data = [
                'nombre_estado' => $estado,
                'id_status_delete' => 1,
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            $data_id = Estado::insertGetId($data);

        }else{
            $data_id = $data_estado->id;
        }

        return $data_id;
    }

    public function obtenermunicipio($municipio, $estado)
    {
        $data_municipio = Municipio::where('nombre_estado', $municipio)->first();
        if($data_municipio == null)
        {
            $data = [
                'municipio_nombre' => $municipio,
                'id_estado' => $estado,
                'id_status_delete' => 1,
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            $data_id = Municipio::insertGetId($data);

        }else{
            $data_id = $data_municipio->id;
        }

        return $data_id;
    }

    public function insertcliente($row)
    {

        if(strlen($row['rfc']) == 13) {
            $tipo_cliente = 1;   
            // Personas físicas
        }else{
            $tipo_cliente =2;
            // Personas morales
        }

        $data = [
            'rfc' => $row['rfc'],
            'razon_social' => $row['razon_social'],
            'alias' => $row['alias'],
            // 'calle_numero' => $row['calle_y_numero'],
            // 'colonia' => $row['colonia_o_delegacion'],
            'codigo_postal' => $row['codigo_postal'],
            // 'id_estado' => $estado,
            // 'id_municipio' => $municipio,
            // 'cedula_fiscal' => $row['curp'],
            'tipo_cliente'  => $tipo_cliente,
            'id_status_delete'  => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $data_id = Cliente::insertGetId($data);

    }

}