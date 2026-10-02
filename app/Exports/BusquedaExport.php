<?php
namespace app\Exports;

use App\Models\Busqueda\Busqueda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Unidad\Unidad;
use App\Services\BusquedaService;
use Maatwebsite\Excel\Concerns\FromArray;

class BusquedaExport implements FromArray, WithHeadings
{
    use Exportable;
    protected $bid;
    protected $titulos = [];
    protected $unidades = [];

    public function  __construct($bid)
    {
        $this->bid = $bid;

        $busqueda = Busqueda::where('bid', $this->bid)->first();
        $parametros = json_decode($busqueda->parametros, true);
        $busquedas = new BusquedaService();
        $this->unidades = $busquedas->registros($parametros['campos'], $parametros['listado'], $parametros['tipo']);
        $this->titulos =  array_values($this->unidades['titulos']);
    }

    public function array(): array
    {
        return $this->unidades['unidades'];
    }

    public function headings(): array
    {
        return $this->titulos;
    }


}
