{{-- Equipamento --}}
@if ($partida->requisicionPartidaEquipamiento->where('id_status_delete', 1)->count() > 0)
<div class="symbol symbol-30 symbol-light-success mr-3" data-toggle="tooltip" data-placement="top" title="Equipamiento agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">EQ</span>
</div>
@else
<div class="symbol symbol-30 symbol-light-dark mr-3" data-toggle="tooltip" data-placement="top" title="Equipamiento no agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">EQ</span>
</div>
@endif

{{-- Aseguramiento --}}
@if ($partida->requisicionPartidaAseguramiento->where('id_status_delete', 1)->count() > 0)
<div class="symbol symbol-30 symbol-light-success mr-3" data-toggle="tooltip" data-placement="top" title="Aseguramiento agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">AS</span>
</div>
@else
<div class="symbol symbol-30 symbol-light-dark mr-3" data-toggle="tooltip" data-placement="top" title="Aseguramiento no agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">AS</span>
</div>
@endif

{{-- Emplacamiento --}}
@if ($partida->requisicionPartidaEmplacamiento->where('id_status_delete', 1)->count() > 0)
<div class="symbol symbol-30 symbol-light-success mr-3" data-toggle="tooltip" data-placement="top" title="Emplacamiento agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">EM</span>
</div>
@else
<div class="symbol symbol-30 symbol-light-dark mr-3" data-toggle="tooltip" data-placement="top" title="Emplacamiento no agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">EM</span>
</div>
@endif

{{-- Lugar de entrega --}}
@if ($partida->requisicionPartidaLugarEntrega->where('id_status_delete', 1)->count() > 0)
<div class="symbol symbol-30 symbol-light-success mr-3" data-toggle="tooltip" data-placement="top" title="Lugar de entrega agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">LE</span>
</div>
@else
<div class="symbol symbol-30 symbol-light-dark mr-3" data-toggle="tooltip" data-placement="top" title="Lugar de entrega no agregado" data-theme="dark">
    <span class="symbol-label" style="font-size: 11px;">LE</span>
</div>
@endif