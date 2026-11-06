<?php

namespace App\Http\Controllers\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Services\Folio;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Sistemas\InventarioComputo;
use App\Models\Sistemas\Resguardo;
use App\Models\Sistemas\ResguardoEquipo;
use App\Models\Sistemas\ResguardoEvidencia;
use App\Models\Sistemas\ResguardoTipoEvidencia;
use Mpdf\Mpdf;

class ResguardoController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogoresguardo()
    {
        $resguardo = Resguardo::where('id_status_delete', 1)->get();

        return view('sistemas.resguardo.catalogo-resguardos', compact('resguardo'));
    }

    public function agregarResguardo()
    {

        $usuarios = User::where('id_status_delete', 1)->get();
        $documentos = ResguardoTipoEvidencia::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $equipos = InventarioComputo::where('id_status_delete', 1)->where('estatus_asignado', 0)->get();
        //Equipos en formato json
        $cadenaEquipos = "";
        foreach($equipos as $documento){
            $cadenaEquipos .= '"'.$documento->id.'":"'.$documento->no_folio." Serie: ".$documento->no_serie.'",';
        }
        $cadenaEquipos = '{'.rtrim($cadenaEquipos, ',').'}';

        return view('sistemas.resguardo.agregar-resguardo', compact('cadenaTipoDocumento', 'usuarios', 'equipos', 'cadenaEquipos'));        
    }

    public function addresguardo(Request $request)
    {

        $data = [
            'no_folio' => $this->folio->getFolioResguardo(),
            'fecha_asignacion' => $request->fecha_asignacion,
            'user_resguardo' => $request->id_user,
            'descripcion' => $request->descripcion,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $id_resguardo = Resguardo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('resguardo/'.$id_resguardo, $archivo, $archivoNombre);
                $data = [
                    'resguardo_id' => $id_resguardo,
                    'tipo_evidencia_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                ResguardoEvidencia::insert($data);
            }
        }


        if($request->id_equipo){
            foreach($request->id_equipo as $indice)
            {
                $data = [
                    'resguardo_id' => $id_resguardo,
                    'computo_id' =>$indice,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];
                ResguardoEquipo::insert($data);

                // $data_inv = [
                //     'estatus_asignado' => 2,
                //     'user_asignado' => $request->id_user,
                //     'updated_at' =>date('Y-m-d H:i:s')
                // ];

                // InventarioComputo::where('id', $indice)->update($data_inv);                

            }
        }


        session()->flash('success', 'El resguardo se añadió correctamente');
        return redirect()->route('resguardo.catalogoresguardo');
    }

    public function editResguardo($id_resguardo)
    {

        $resguardo = Resguardo::where('id', $id_resguardo)->first();
        $usuarios = User::where('id_status_delete', 1)->get();
        $documentos = ResguardoTipoEvidencia::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $equipos = InventarioComputo::where('id_status_delete', 1)->where('estatus_asignado', 0)->get();
        //Equipos en formato json
        $cadenaEquipos = "";
        foreach($equipos as $documento){
            $cadenaEquipos .= '"'.$documento->id.'":"'.$documento->no_folio." Serie: ".$documento->no_serie.'",';
        }
        $cadenaEquipos = '{'.rtrim($cadenaEquipos, ',').'}';

        $equipos_asignados = ResguardoEquipo::where('resguardo_id', $id_resguardo)->get();
        $documentos_asignados = ResguardoEvidencia::where('resguardo_id', $id_resguardo)->get();

        return view('sistemas.resguardo.editar-resguardo', compact('cadenaTipoDocumento', 'usuarios', 'equipos', 'cadenaEquipos', 'id_resguardo', 'resguardo', 'equipos_asignados', 'documentos_asignados'));

    }

    public function edtresguardo(Request $request)
    {
        $data = [
            'fecha_asignacion' => $request->fecha_asignacion,
            'user_resguardo' => $request->id_user,
            'descripcion' => $request->descripcion,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];
        $id_resguardo = Resguardo::where('id', $request->id)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('resguardo/'.$request->id, $archivo, $archivoNombre);
                $data = [
                    'resguardo_id' => $request->id,
                    'tipo_evidencia_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                ResguardoEvidencia::insert($data);
            }
        }


        if($request->id_equipo){
            foreach($request->id_equipo as $indice)
            {
                $data = [
                    'resguardo_id' => $request->id,
                    'computo_id' =>$indice,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];
                ResguardoEquipo::insert($data);
            }
        }


        session()->flash('success', 'El resguardo se modifico correctamente');
        return redirect()->route('resguardo.catalogoresguardo');
    }

    public function deleteequipo(Request $request)
    {
        $doc = ResguardoEquipo::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            ResguardoEquipo::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function deletearchivo(Request $request)
    {
        $doc = ResguardoEvidencia::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('resguardo/'.$doc->id.'/'.$doc->documento);
            ResguardoEvidencia::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function verResguardo($id_resguardo)
    {

        $resguardo = Resguardo::where('id', $id_resguardo)->first();
        $usuarios = User::where('id_status_delete', 1)->get();
        $documentos = ResguardoTipoEvidencia::where('id_status_delete',1)->get();
        $equipos = InventarioComputo::where('id_status_delete', 1)->where('estatus_asignado', 0)->get();
        $equipos_asignados = ResguardoEquipo::where('resguardo_id', $id_resguardo)->get();
        // dd($equipos_asignados);
        $documentos_asignados = ResguardoEvidencia::where('resguardo_id', $id_resguardo)->get();

        return view('sistemas.resguardo.ver-resguardo', compact('usuarios', 'equipos', 'id_resguardo', 'resguardo', 'equipos_asignados', 'documentos_asignados'));       
    }

    public function verResguardoPDF($id_resguardo)
    {

        $resguardo = Resguardo::where('id', $id_resguardo)->first();
        $user_resguardo = User::where('id', $resguardo->user_resguardo)->first();
        // $equipos_asignados = ResguardoEquipo::where('resguardo_id', $id_resguardo)->get();

        $equipos_asignados = ResguardoEquipo::select(
            'resguardo_equipo.id', 'iec.no_serie', 'iec.no_folio as folio', 'iec.marca', 'iec.modelo', 'iec.descripcion', 'ite.tipo_equipo'
        )
        ->leftjoin("inventario_equipo_computo as iec", "iec.id", "resguardo_equipo.computo_id") 
        ->leftjoin("inventario_tipo_equipo as ite", "ite.id", "iec.tipo_equipo_id")
        ->where("resguardo_equipo.resguardo_id", $id_resguardo)
        ->get();


        $header = view('sistemas.resguardo.ver-resguardo-pdf-header')->render();
        $footer = view('sistemas.resguardo.ver-resguardo-pdf-footer')->render();
        $body = view('sistemas.resguardo.ver-resguardo-pdf-body', compact('resguardo', 'user_resguardo', 'equipos_asignados'))->render();

        $path = public_path() . '/theme/assets/media/logos/logojetvan-pdf.png';
        
        $mpdf = new Mpdf(['format' => [216, 340]]);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($body);
        if(File::exists($path)) {
            $mpdf->imageVars['logo'] = File::get($path);
        }
        $mpdf->Output();    

    }

}