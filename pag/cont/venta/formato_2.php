<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php print $x.'css/formatos.css';?>" rel="stylesheet" type="text/css" />
</head>
<body>

	<div id="muestra" class='muestra'> 
		<table width="550" >
			<tr height="110">
				<td colspan="4">.</td>
			</tr>
			
			<tr>
				<td colspan="4">
					<?php print "AMBATO ".$hoy;?>
				</td>
			</tr>
			
			<tr height="1">
				<td colspan="4">
					<?php print $txt_nombres." ".$txt_apellidos;?>
				</td>
			</tr>
			
			<tr height="1">
				<td>
					<?php print $txt_identificacion;?>
				</td>
				<td colspan="3" align="left">No:<?php print $txt_no_factura;?></td>
			</tr>
			
			<tr height="1">
				<td colspan="4">
					<?php print $txt_direccion;?>
				</td>
			</tr>

			<tr height="40">
				<td colspan="2">&nbsp;</td>
				<td width="100px" align="right">&nbsp;</td>
				<td width="90px" align="right">&nbsp;</td>
			</tr>
			
			<tr height='73'>
				<td colspan='4' class='td_top'>
					<table width="100%">
						<?php print $cadena;?>
					</table>
				</td>
			</tr>
			
			
			<tr>
				<td align="left" height="111" class='td_bottom'><?php print nl2br($txt_referencia).'<br>'; ?></td>
				<td colspan="3" align="left">&nbsp;</td>
			</tr>
			
			<tr height="16">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;TARIFA 12%:?>
				<td align="right" class='td_bottom'><?php print $font_f;?><?php print number_format($t12, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;TARIFA 0%:?>
				<td align="right" class='td_bottom'><?php print $font_f;?><?php print number_format($t0, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;DESCUENTO:?>
				<td align="right" class='td_bottom'><?php print $font_f;?><?php ?><?php print $font_b;?>-</td>
			</tr>
			
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;SUBTOTAL:?>
				<td align="right" class='td_bottom'><?php print $font_f;?><?php print number_format($subtotal, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
						
			<tr height="5">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;IVA:?>
				<td align="right" class='td_bottom'><?php print $font_f;?><?php print number_format($iva, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;TOTAL:?>
				<td align="right" class='td_bottom'><b><?php print $font_f;?><?php print number_format($total, 2, '.', '');?><?php print $font_b;?></b></td>
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
			print $cadena_abajo;
			?>



		</table>
		
		
		
		<br><br>
		
		
		<table width="550" >
			<tr height="110">
				<td colspan="4">.</td>
			</tr>
			
			<tr>
				<td colspan="4">
					<?php print "AMBATO ".$hoy;?>
				</td>
			</tr>
			
			<tr height="1">
				<td colspan="4">
					<?php print $txt_nombres." ".$txt_apellidos;?>
				</td>
			</tr>
			
			<tr height="1">
				<td>
					<?php print $txt_identificacion;?>
				</td>
				<td colspan="3" align="left">No:<?php print $txt_no_factura;?></td>
			</tr>
			
			<tr height="1">
				<td colspan="4">
					<?php print $txt_direccion;?>
				</td>
			</tr>

			<tr height="40">
				<td colspan="2">&nbsp;</td>
				<td width="100px" align="right">&nbsp;</td>
				<td width="90px" align="right">&nbsp;</td>
			</tr>
			
			<tr height='70'>
				<td colspan='4' class='td_top'>
					<table width="100%">
						<?php print $cadena;?>
					</table>
				</td>
			</tr>
			
			<tr>
				<td align="left" height="112" class='td_bottom'><?php print nl2br($txt_referencia).'<br>'; ?></td>
				<td colspan="3" align="left">&nbsp;</td>
			</tr>
			
			<tr height="13">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;TARIFA 12%:?>
				<td align="right"><?php print $font_f;?><?php print number_format($t12, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;TARIFA 0%:?>
				<td align="right"><?php print $font_f;?><?php print number_format($t0, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;DESCUENTO:?>
				<td align="right"><?php print $font_f;?><?php ?><?php print $font_b;?>-</td>
			</tr>
			
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;SUBTOTAL:?>
				<td align="right"><?php print $font_f;?><?php print number_format($subtotal, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
						
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;IVA:?>
				<td align="right" ><?php print $font_f;?><?php print number_format($iva, 2, '.', '');?><?php print $font_b;?></td>
			</tr>
			<tr height="10">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td><?php //print $font_f;TOTAL:?>
				<td align="right"><b><?php print $font_f;?><?php print number_format($total, 2, '.', '');?><?php print $font_b;?></b></td>
			</tr>


		</table>
	</div>

</body>
</html>