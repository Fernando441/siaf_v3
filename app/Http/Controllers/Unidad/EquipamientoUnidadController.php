<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadTipoDocumento;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\TipoAsignacion;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\UnidadEquipamiento;
use App\Models\Proyecto\Proyecto;
use App\Models\Proyecto\ProyectoClientes;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Imports\EquipamientounidadImport;

class EquipamientoUnidadController extends Controller
{

    public function cagamasivaequipamiento(Request $request)
    {
        Excel::import( new EquipamientounidadImport($request->unidad_id), $request->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('unidad.equipamientounidad',$request->unidad_id);
    }

    public function cargaevidencia(Request $request)
    {
        // dd($request);
        for($i = 0; $i <= count($request->id); $i++){
            if (isset($request->file('file_carga')[$i])) {

                Storage::putFileAs('unidad/' . $request->unidad,  $request->file('file_carga')[$i], $request->file('file_carga')[$i]->hashName());
                // $dato ="Existe";
                $data = [
                    'fotografia_equipamiento' => $request->file('file_carga')[$i]->hashName(),
                    'equipamiento_pendiente' => 1,
                    'iduserUpdated' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')

                ];

                UnidadEquipamiento::where('id', $request->id[$i])->update($data);

            }else{
                // $dato="No existe";
            }
        }
      
        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('unidad.equipamientounidad',$request->unidad);
    }

    public function eliminarevidencia(Request $request)
    {

        UnidadEquipamiento::where('id', $request->id)->delete();

        session()->flash('success', 'Se elimino correctamente el registro.');
        return redirect()->route('unidad.equipamientounidad',$request->unidad_id);

    }

}