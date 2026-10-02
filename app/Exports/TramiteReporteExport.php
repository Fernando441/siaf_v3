<?php
namespace App\Exports;

use App\Models\Busqueda\Busqueda;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Services\Tramite\ReporteService;
use Maatwebsite\Excel\Concerns\FromArray;

class TramiteReporteExport implements FromArray, WithHeadings
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
        $busquedas = new ReporteService();
        $this->unidades = $busquedas->registrosTramites($parametros['fecha_inicio'], $parametros['fecha_final'] );
        $this->titulos =  array_values($this->unidades['titulos']);
    }

    public function array(): array
    {   
        $resgistrosFila = [];
        $registros = [];
        for ($i = 0; $i < $this->unidades['total_registros'] ; $i++) {
            foreach ($this->unidades['unidades'] as $unidad) {
                $resgistrosFila[] = $unidad[$i];
            }
            $registros[] = $resgistrosFila;
            unset($resgistrosFila);
        }
        return $registros;
    }

    public function headings(): array
    {
        return $this->titulos;
    }


}
