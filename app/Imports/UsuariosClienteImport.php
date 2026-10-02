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
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class UsuariosClienteImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
        // $this->licitacion = $licitacion;
    }


    public function collection(Collection $rows)
    {

        foreach ($rows as $row){
            $data = [
                'name' => $row['nombre_usuario'],
                'area_personal_id' => $row['id_area_personal'],
                'email' => $row['correo_electronico'],
                'role' => $row['id_rol'],
                'password' => Hash::make($row['contrasena']),
                'rfc' => $row['rfc'],
                'telefono' => $row['telefono'],
                'ubicacion' => $row['ubicacion_jetvan'],
                'id_status_delete' =>1,
                'estatus_asignacion' => 1,
                'op_disponible' => 0,
                'tipo_usuario_id'=>$row['id_tipo_usuario'],
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            User::insert($data);


        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('user.catalogousuarios');
    }

}