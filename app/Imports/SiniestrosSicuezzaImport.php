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
use App\Models\Siniestros\SiniestroSicurezza;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class SiniestrosSicuezzaImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
        // $this->licitacion = $licitacion;
    }


    public function collection(Collection $rows)
    {
        dd($rows);
        foreach ($rows as $row){
            $data = [

                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            // User::insert($data);


        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('siniestro.catalogosicurezza');
    }

}