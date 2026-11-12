<table width="100%" style="vertical-align: top; border: 1px;">
    <tr>
        <td   rowspan="2" ><img id="img"  align="left" style="" src="var:logo"/></td>
        <td   align="right" style="text-align: center;font-weight: bold;">
            <p style="font-size: 10px;" >&nbsp;</p><br>
            <p  style="font-size: 13px;" >JET VAN CAR RENTAL S.A. DE C.V.</p><br>
        </td>
    </tr>
    <tr>
        <td align="right" >
             @php \Carbon\Carbon::setLocale('es');  echo Str::upper(\Carbon\Carbon::now()->isoFormat('dddd D [de] MMMM [de] YYYY')); @endphp
            <br>
{{--             <span style="font-weight: bold;" >No. Folio: {{ $resguardo->no_folio }}</span><br>
            <span style="font-weight: bold;" >Fecha resguardo: {{ $resguardo->fecha_asignacion }} </span><br> --}}
        </td>
    </tr>
    <tr>
        <td align="right" >
            &nbsp;
        </td>
    </tr>
</table>