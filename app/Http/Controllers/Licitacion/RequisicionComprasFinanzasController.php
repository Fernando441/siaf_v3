<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Services\Money;
use App\Services\Folio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Requisicion\AreaPersonal;
use App\Models\Licitacion\Licitacion;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Licitacion\ComprasRequisicion;
use App\Models\Licitacion\ComprasRequisicionDetalle;
use App\Models\Licitacion\ComprasRequisicionPago;
use LDAP\Result;
use Mpdf\Mpdf;

class RequisicionComprasFinanzasController extends Controller
{
    protected $folio;

    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;
    }

    public function listadorequisiciones()
    {
        $solicitante = auth()->user()->id;
        $info_user = User::where('id', $solicitante)->first();
        $data = ComprasRequisicion::where('id_status_delete', 1)->where('op_estatus', 2)->get();

        return view('licitaciones.requisicion-compras.finanzas.listado-requisiciones-finanzas-compras', compact('data'));
    }

    public function solicitudcompras($id_requisicion)
    {
        $solicitante = auth()->user()->id;
        $info_user = User::where('id', $solicitante)->first();
        $area = AreaPersonal::where('id_status_delete', 1)->get();
        $requisicion = ComprasRequisicion::where('id', $id_requisicion)->first();
        $detalle = ComprasRequisicionDetalle::where('requisicion_compras_id', $id_requisicion)->get();

        return view('licitaciones.requisicion-compras.finanzas.pagar-requisiciones-compras', compact('info_user', 'area', 'requisicion', 'detalle'));    
    }

    public function infopago($id_requisicion)
    {
        $solicitante = auth()->user()->id;
        $info_user = User::where('id', $solicitante)->first();
        $area = AreaPersonal::where('id_status_delete', 1)->get();
        $requisicion = ComprasRequisicion::where('id', $id_requisicion)->first();
        $detalle = ComprasRequisicionDetalle::where('requisicion_compras_id', $id_requisicion)->get();
        $pago = ComprasRequisicionPago::where('requisicion_compras_id', $id_requisicion)->get();

        return view('licitaciones.requisicion-compras.finanzas.info-pago-requisiciones-compras', compact('info_user', 'area', 'requisicion', 'detalle', 'id_requisicion', 'pago'));         
    }

    public function addpago(Request $request)
    {

        $colIdDocumento = $request->id_documento;
        $colIdImporte = $request->importe;

        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Requisiciocompras/'.$request->id_requisicion, $archivo, $archivoNombre);
                $data = [
                    'requisicion_compras_id' =>$request->id_requisicion,
                    'documento' => $archivoNombre,
                    'importe' => $colIdImporte[$indice],
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                ComprasRequisicionPago::insert($data);
            }
        }



        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('finreqcompras.infopago', $request->id_requisicion);

    }

    public function eliminardocumentorequisicion(Request $request)
    {
        $doc = ComprasRequisicionPago::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('Requisiciocompras/'.$doc->requisicion_compras_id.'/'.$doc->documento);
            ComprasRequisicionPago::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }


    public function verlicitacionPDF($id_requisicion)
    {

        $solicitante = auth()->user()->id;
        $info_user = User::where('id', $solicitante)->first();
        $area = AreaPersonal::where('id_status_delete', 1)->get();
        $requisicion = ComprasRequisicion::where('id', $id_requisicion)->first();
        $detalle = ComprasRequisicionDetalle::where('requisicion_compras_id', $id_requisicion)->get();
        $pago = ComprasRequisicionPago::where('requisicion_compras_id', $id_requisicion)->get();

// dd($requisicion);
        $header = view('licitaciones.requisicion-compras.finanzas.ver-requisicion-pdf-header', compact('requisicion'))->render();
        $footer = view('licitaciones.requisicion-compras.finanzas.ver-requisicion-pdf-footer')->render();
        $body = view('licitaciones.requisicion-compras.finanzas.ver-requisicion-pdf-body', compact('info_user','area', 'requisicion', 'detalle','pago'))->render();

        $path = public_path() . '/theme/assets/media/logos/logojetvan-pdf.jpg';
        
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