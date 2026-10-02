<table width="100%" style="vertical-align: top; border: 1px;">
	<tr>
		<td rowspan="2" style="width: 220px;"><img id="img" align="left" style="" src="var:logo" /></td>
		<td align="right" style="text-align: center;font-weight: bold;">
			<p style="font-size: 10px;">&nbsp;</p><br>
			<p style="font-size: 13px;">JET VAN CAR RENTAL S.A. DE C.V.</p><br>
		</td>
	</tr>
	<tr>
		<td align="right">
			NAUCALPAN DE JUÁREZ, ESTADO DE MÉXICO A {{ \Illuminate\Support\Str::upper(\Carbon\Carbon::now()->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY')) }}
			<br>
			<span style="font-weight: bold;">Folio: {{ $folioDocumento }}</span><br>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">&nbsp;</td>
	</tr>
</table>
