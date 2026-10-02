<?php

namespace App\Console\Commands;

use App\Models\Unidad\SeminuevosApartado;
use Illuminate\Console\Command;

class DiasApartado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dias-apartado:actualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'disminuir en 1 el numero de dias apartado de las unidades apartadas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SeminuevosApartado::where('dias_apartado', '>', 0)->decrement('dias_apartado', 1);
        return Command::SUCCESS;
    }
}
