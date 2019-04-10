<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../../css/azul.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="muestra"> 
		<table width="350" >
			<tr height="35" >
				<td height="15"colspan="4">&nbsp;</td>
			</tr>
			
			<tr height="1">
				<td colspan="4">
					SR. (ES): <?php print $txt_nombres." ".$txt_apellidos;?>
				</td>
			</tr>
			
			<tr height="1">
				<td colspan="4">
					RUC/CI: <?php print $txt_identificacion;?>&nbsp;&nbsp;&nbsp;No Factura: <?php print $txt_no_factura;?>
				</td>
			</tr>
			
			<tr height="1">
				<td colspan="4">
					DIR: <?php print $txt_direccion;?>
				</td>
			</tr>
			
			<tr>
				<td colspan="4">
					TELF: <?php print $txt_telefono;?>
				</td>
			</tr>
			
			<tr>
				<td colspan="4">
					LUGAR/FECHA: <?php print "AMBATO ".$hoy;?>
				</td>
			</tr>
			
			<tr height="1">
				<td>&nbsp;</td>
				<td align="right">CANT</td>
				<td width="45" align="right">P/U</td>
				<td width="60" align="right">TOTAL</td>
			</tr>
			
			<tr>
				<td colspan="4">
					<?php print $cadena;?>
				</td>
			</tr>
			
			
			<tr>
				<td colspan="4" align="right"><?php print $font_f;?>===============<?php print $font_b;?></td>
			</tr>
			<tr>
				<td width="20">&nbsp;</td><td width="205" align="right"><?php print $font_f;?>SUBTOTAL:</td>
				<td colspan="2" align="right"><?php print $font_f;?>$ <?php print number_format($subtotal, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			<tr>
				<td width="20">&nbsp;</td><td width="205" align="right"><?php print $font_f;?>TARIFA 0%:</td>
				<td colspan="2" align="right"><?php print $font_f;?>$ <?php print number_format($t0, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			<tr>
				<td width="20">&nbsp;</td><td width="205" align="right"><?php print $font_f;?>TARIFA 14%:</td>
				<td colspan="2" align="right"><?php print $font_f;?>$ <?php print number_format($t12, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			<tr>
				<td width="20">&nbsp;</td><td width="205" align="right"><?php print $font_f;?>IVA:</td>
				<td colspan="2" align="right"><?php print $font_f;?>$ <?php print number_format($iva, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			<tr>
				<td width="20">&nbsp;</td><td width="205" align="right"><?php print $font_f;?>TOTAL:</td>
				<td colspan="2" align="right"><?php print $font_f;?>$ <?php print number_format($total, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			  
			  
			  
			  
			<?php /*?>  
			<tr>
				<td colspan="4" align="right"><?php print $font_f;?>===============</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><?php print $font_f;?>SALDO EN TARJETA:<?php print $font_b;?></td>
				<td colspan="2" align="right"><?php print $font_f;?>$ <?php print number_format($saldo_disponible, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			<?php */?>  

			<?php 
			if(isset($cadena_abajo))print $cadena_abajo;
			?>



		</table>
		
		<br class="pag">
	</div>

</body>
</html>