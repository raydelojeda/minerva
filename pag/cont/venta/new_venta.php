<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<script type="text/javascript" class="js-code-basic">
$(document).ready(function() {
$(".js-example-basic-single_cliente").select2();
$(".js-example-basic-single_prod1").select2();
$(".js-example-basic-single_prod2").select2();
$(".js-example-basic-single_prod3").select2();
$(".js-example-basic-single_prod4").select2();
$(".js-example-basic-single_prod5").select2();
$(".js-example-basic-single_prod6").select2();
$(".js-example-basic-single_prod7").select2();
});

function forma_pago(f)
{
	select=eval('document.frm.sel_forma_pago'+f+'.value');
	for(i=f;i<=7;i++)
	{
		document.getElementById('sel_forma_pago'+i).value=select;
	}
}
</script>

<?php
$hoy=date("Y-m-d");
$sql_p="SELECT n_punto_venta.id_punto_venta, punto_venta, descripcion 
FROM n_punto_venta,punto_venta_usuario, usuario, n_factura 
WHERE n_punto_venta.id_punto_venta=n_factura.id_punto_venta 
AND n_punto_venta.id_punto_venta=punto_venta_usuario.id_punto_venta 
AND n_factura.estado='1' AND fecha_vencimiento>='".$hoy."'
AND usuario.id_usuario=punto_venta_usuario.id_usuario 
AND usuario='".$_SESSION["user"]."' AND punto_venta_usuario.activo='1'
ORDER BY punto_venta DESC";//print $sql_p;
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
?>


&nbsp;
<tr><td>
<table class="tabla_venta" align="center">
	<tr>
		<td colspan='10' align="left">
		&nbsp;
		</td>	
	</tr>
<?php
if(isset($_GET['id_p']))
$_POST['sel_punto_venta']=$_GET['id_p'];

if(isset($_GET['id_f']))
$_POST['sel_forma_pago']=$_GET['id_f'];

/*
if(isset($_POST['sel_punto_venta']))
{
	$sql_r="select DISTINCT id_referencia from referencia where id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_f;
	$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
}
else
$_POST['cbx_nat_jur']=1;

if(isset($rs_r))
$id_referencia=$rs_r->fields['id_referencia'];
*/

$_POST['cbx_nat_jur']=1;
?>
	
	<tr>
		<td align="right" width='12%'>
			Punto de venta:
		</td>
		<td align="left" width='12%'>
			<select name="sel_punto_venta" id="sel_punto_venta" onchange="javascript:document.frm.submit();">
				<option value="0">-------Seleccionar-------</option>
				<?php for($p=0;$p<$rs_p->RecordCount();$p++){?>
				
					<option value="<?php print $rs_p->fields['id_punto_venta'];?>" <?php if(isset($_POST['sel_punto_venta'])){if($rs_p->fields['id_punto_venta']==$_POST['sel_punto_venta']){?> selected="selected"<?php }}?> > <?php print $rs_p->fields['punto_venta'].' - '.$rs_p->fields['descripcion'];?> </option>
					
				<?php $rs_p->MoveNext();}?>
			</select>
		</td>

		<td align="right" width='12%'>
			&nbsp;
		</td>
		
		<td  align="right" width='7%'>
			&nbsp;<a onMouseOver="return overlib('<?php print $msg_ven;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
		</td>
	<?php /*
	
		<td align="right" width='12%'>
			Persona natural:
		</td>
		
		<td  align="left" width='7%'>
			<section>
				<div class="checkbox-2">
					<input class="checkbox_oculto" name='cbx_nat_jur' value='1' <?php if(isset($_POST['cbx_nat_jur'])){if(1==$_POST['cbx_nat_jur']){?> checked <?php }}?> type="checkbox" id="cbx_nat_jur" />
					<label for="cbx_nat_jur"></label>
				</div>
			</section>
		</td>
		<?php }*/?>
		<td colspan='8' align="right" >
			&nbsp;
		</td>
		
	</tr>
	
<?php
if(isset($_POST['sel_punto_venta']))
{	
	if($_POST['sel_punto_venta']!=0)
	{
		$sql_f="select * from n_factura where estado='1' and id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_f;
		$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
		
		$sql_n="select n_factura.id_factura, no_factura as no_factura from venta, n_factura where venta.id_factura=n_factura.id_factura and estado='1' and id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_n;
		$rs_n=$db->Execute($sql_n) or die($db->ErrorMsg());
		
		if(isset($rs_n->fields["no_factura"]))
		{
			$mayor=$rs_n->fields["no_factura"];
			$rs_n->MoveNext();
			
			for($n=0;$n<$rs_n->RecordCount();$n++)
			{			
			//print $rs_n->fields["no_factura"].'    '.$mayor.'<br>';
				if($rs_n->fields["no_factura"]>$mayor)
				$mayor=$rs_n->fields["no_factura"];
			$rs_n->MoveNext();
			}

			$no_factura=$mayor;
			$no_factura=$no_factura+1;
		}
		else
		$no_factura=$rs_f->fields["inicio"];
		
		$id_factura=$rs_f->fields["id_factura"];
		
		if($no_factura<=$rs_f->fields["fin"])
		{
			$fecha = date('Y-m-j');
			$nuevafecha = strtotime ( '+30 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			
			$sql_cli="select DISTINCT persona.id_persona, cliente.id_cliente, identificacion,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre, camino_foto 
			from persona, cliente, cliente_forma_pago where cliente.id_persona=persona.id_persona AND cliente.id_cliente =cliente_forma_pago.id_cliente AND cliente_forma_pago.id_punto_venta='".$_POST['sel_punto_venta']."' ORDER BY primer_apellido,segundo_apellido";
			$rs_cli_combo=$db->Execute($sql_cli) or die($db->ErrorMsg());//print $sql_cli;
						
			if(isset($_POST['sel_cliente']))
			{
				if($_POST['sel_cliente']!=0)
				{
					$sql_cli="select persona.id_persona, factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, cliente.id_cliente,
					concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) AS cliente, camino_foto from persona, cliente
					where cliente.id_persona=persona.id_persona and cliente.id_cliente='".$_POST['sel_cliente']."'";
					$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());//print $sql_cli;
					$id_persona=$rs_cli->Fields("id_persona");//print $id_persona;
					$id_cliente=$rs_cli_combo->Fields("id_cliente");
					$permite_credito=$rs_cli->Fields("permite_credito");
					
					$sql_tar="select cod_barra from persona, n_tarjeta, cliente
					where cliente.id_persona=persona.id_persona and n_tarjeta.id_cliente=cliente.id_cliente and cliente.id_cliente='".$id_cliente."'";
					$rs_tar=$db->Execute($sql_tar) or die($db->ErrorMsg());//print $sql_tar;
				}
			}//print $sql_cli;
			

			
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
			
			$sql_pro="select producto_precio.id_producto_precio AS id_pro, concat(cod_producto,' - ',producto) AS pro from producto_precio, n_producto, n_punto_venta WHERE producto_precio.id_producto=n_producto.id_producto 
			AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta AND activo='1' and n_punto_venta.id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_pro;
			$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());
	
	
	
	
	
?>
			<tr>
				<td align="right">
					No de factura:
				</td>
				<td colspan='9' align="left">
					<input size='8' name='txt_no_factura' value='<?php print $no_factura;?>' type='text'>
				</td>
			</tr>
			
			<tr>
				<td colspan='10' align="left">
					<hr>
				</td>	
			</tr>
			
			<tr>
			<td colspan='10'>
			<table width='100%'>
			<tr>
				<td align="right" width='10%'>
					No autorizo:
				</td>
				<td align="left" width='7%'>
					<input size='12' value='<?php print $rs_f->fields['no_autorizo'];?>' disabled type='text'>
				</td>
				<td align="right" width='10%'>
					Inicio:
				</td>
				<td align="left" width='9%'>
					<input size='8' value='<?php print $rs_f->fields['inicio'];?>' disabled type='text'>
				</td>
				<td align="right" width='9%'>
					Fin:
				</td>
				<td align="left" width='9%'>
					<input size='8' value='<?php print $rs_f->fields['fin'];?>' disabled type='text'>
				</td>
				<td align="right" width='9%'>
					Emisi&oacute;n:
				</td>
				<td align="left" width='10%'>
					<input size='10' value='<?php print $rs_f->fields['fecha_emision'];?>' disabled type='text'>
				</td>
				<td align="right" width='10%'>
					Vencimiento:
				</td>
				<td align="left">
					<input size='10' <?php if($nuevafecha>=$rs_f->fields["fecha_vencimiento"]) print "class='input_rojo'";?> value='<?php print $rs_f->fields['fecha_vencimiento'];?>' disabled type='text'>
				</td>
			</tr>
			</table>
			</td>
			</tr>
			
			<tr>
				<td colspan='10' align="left">
					<hr>
				</td>	
			</tr>
			
			
			<tr>
			<td colspan='10'>
			<table>
			<tr>
				<td align="right">
					Cliente:
				</td>
				
				<td colspan='9' align="left" width='70%'>
				<?php 
				if(isset($_POST['sel_grupo']))
				{
					if($_POST['sel_grupo']==0)
					{
				?>
						<select class="js-example-basic-single_cliente" name="sel_cliente" id="sel_cliente" <?php if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']==0)print "autofocus='autofocus'";}else print "autofocus='autofocus'";?> onchange="javascript:document.frm.submit();">
							<option value="0">----------------------------Seleccionar----------------------------</option>
							<?php for($c=0;$c<$rs_cli_combo->RecordCount();$c++){?>
							
								<option value="<?php print $rs_cli_combo->fields['id_cliente'];?>" 
									<?php 
										if(isset($_POST['sel_cliente']))
										{
											if($rs_cli_combo->fields['id_cliente']==$_POST['sel_cliente'])
											{							 
												print 'selected="selected"';								 
											}
										}
										?>><?php
										print $rs_cli_combo->fields['identificacion'].' - '.$rs_cli_combo->fields['primer_apellido'].' '.$rs_cli_combo->fields['segundo_apellido'].' '.$rs_cli_combo->fields['primer_nombre'].' '.$rs_cli_combo->fields['segundo_nombre'];
									?> 
								</option>
								
							<?php $rs_cli_combo->MoveNext();}$rs_cli_combo->MoveFirst();?>
						</select>
				<?php 
					}
				}
				else
				{
				?>
					<select class="js-example-basic-single_cliente" name="sel_cliente" id="sel_cliente" <?php if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']==0)print "autofocus='autofocus'";}else print "autofocus='autofocus'";?> onchange="javascript:document.frm.submit();">
						<option value="0">----------------------------Seleccionar----------------------------</option>
						<?php for($c=0;$c<$rs_cli_combo->RecordCount();$c++){?>
						
							<option value="<?php print $rs_cli_combo->fields['id_cliente'];?>" 
								<?php 
									if(isset($_POST['sel_cliente']))
									{
										if($rs_cli_combo->fields['id_cliente']==$_POST['sel_cliente'])
										{							 
											print 'selected="selected"';								 
										}
									}
									?>><?php
									print $rs_cli_combo->fields['identificacion'].' - '.$rs_cli_combo->fields['primer_apellido'].' '.$rs_cli_combo->fields['segundo_apellido'].' '.$rs_cli_combo->fields['primer_nombre'].' '.$rs_cli_combo->fields['segundo_nombre'];
								?> 
							</option>
							
						<?php $rs_cli_combo->MoveNext();}$rs_cli_combo->MoveFirst();?>
					</select>
				<?php
				}
				
				if(isset($_POST['sel_grupo']))
				{
					if($_POST['sel_grupo']!=0)
					{
				?>
					<input size='42' name='sel_cliente' value='<?php if(isset($rs_cli->fields['cliente']))print $rs_cli->fields['cliente'];?>' type='text'>
				<?php
					}
				}
				?>
				</td>
				
				
				<?php
					/*
				<td align="right">
				&nbsp;
					Grupo:
				</td>
				
				<td colspan='2' align="left">&nbsp;
				
					<select name="sel_grupo" id="sel_grupo" onchange="javascript:document.frm.submit();">
						<option value="0">--------------Seleccionar--------------</option>
						<?php for($g=0;$g<$rs_gru->RecordCount();$g++){?>
						
							<option value="<?php print $rs_gru->fields['id_grupo_cliente'];?>" <?php if(isset($_POST['sel_grupo'])){if($rs_gru->fields['id_grupo_cliente']==$_POST['sel_grupo']){?> selected="selected"<?php }}?> > <?php print $rs_gru->fields['grupo_cliente'];?> </option>
							
						<?php $rs_gru->MoveNext();}$rs_gru->MoveFirst();?>
					</select>
					
				</td>
				*/
				?>
			</tr>
			</table>
			</td>
			</tr>
			
			<?php
			
			//---------------------PRECIO, CANTIDAD, SUBTOTAL Y TOTAL---------------------
			$total=0;
			$filas=1;
			
			if(isset($_POST['filas']))
			$filas=$_POST['filas'];
				
			for($f=1;$f<=$filas;$f++)
			{
				$variable_variable_cant='cant_'.$f;
				$variable_variable_prec='prec_'.$f;
				
				if(isset($_POST['txt_cantidad'.$f]))
				$$variable_variable_cant=$_POST['txt_cantidad'.$f];
				else
				$$variable_variable_cant=1;
				
				if(isset($_POST['sel_pro'.$f]))
				{
					if($_POST['sel_pro'.$f]!=0)
					{
						$sql_pre="select precio from producto_precio where
						activo='1' AND id_producto_precio='".$_POST['sel_pro'.$f]."'";//print $sql_pre;
						$rs_pre=$db->Execute($sql_pre) or die($db->ErrorMsg());
						$$variable_variable_prec=$rs_pre->Fields("precio");
						
						$subtotal=bcmul(${'prec_'.$f}, ${'cant_'.$f},14);//print " prec ".${'prec_'.$f}." cant ".${'cant_'.$f}." sub ".$subtotal.'<br>';
						$total=bcadd($total,$subtotal,14);		
					}
				}				
			}
			//---------------------PRECIO, CANTIDAD, SUBTOTAL Y TOTAL---------------------
			if(isset($rs_cli))
			{
				//---------------------SALDO DISPONIBLE------------------------	
				$sql_s="select ROUND(SUM(saldo),2) AS suma_saldo from saldo 
				where saldo.id_cliente='".$rs_cli->fields['id_cliente']."'";//print "<br><br>".$sql_s;
				$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
					
				$suma_saldo=$rs_s->fields["suma_saldo"];//print "saldo final".$suma_saldo;	
				
				$sql_v="select id_venta, ROUND(SUM(precio*cantidad),2) AS suma_venta from venta, cliente, producto_precio 
				where venta.id_cliente=cliente.id_cliente AND venta.id_producto_precio=producto_precio.id_producto_precio
				and anulada='0'	and cliente.id_cliente=".$rs_cli->fields['id_cliente'];//print "<br><br>".$sql_v; 
				$rs_v=$db->Execute($sql_v) or die($db->ErrorMsg());
									
				$suma_venta=$rs_v->fields["suma_venta"];//print "suma_venta: ".$suma_venta;	
				
				$saldo_disponible=bcsub($suma_saldo, $suma_venta, 14);
				$saldo_final=bcsub($saldo_disponible,$total,14);
				//---------------------SALDO DISPONIBLE------------------------
			
				if(isset($_POST['sel_punto_venta']) AND isset($_POST['cbx_referencia']))
				{
					if($_POST['cbx_referencia']==1)
					{
						$sql_r="select * from referencia where id_punto_venta='".$_POST['sel_punto_venta']."' AND id_cliente='".$rs_cli->fields['id_cliente']."'";//print $sql_r;
						$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
					}
				}
			}
			?>
			
			<tr>
				<td colspan='10' align="center">
					
					<table class='tabla_listar' width="100%">
						<tr>
							<td width="65%">	
								<fieldset>
								<legend>Datos en factura</legend>
								
								<table align='center' id='id_<?php if((isset($rs_cli->fields['id_persona'])))print $rs_cli->fields['id_persona'];?>' style='display:inline-block,width="100%";' >
									<tr>						
										<td colspan='2' width='15%' align="right">
											Nombres:
										</td>
										
										<td width='15%' align="left">
											<input name='txt_nombres1' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_nombres'])))print $rs_cli->fields['factura_nombres'];elseif(isset($_POST['txt_nombres1'])) print $_POST['txt_nombres1'];?>' type='text'>
										</td>
										
										<td width='20%'align="right">
											Apellidos:
										</td>
										
										<td width='15%' align="left">
											<input name='txt_apellidos1' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_apellidos'])))print $rs_cli->fields['factura_apellidos'];elseif(isset($_POST['txt_apellidos1'])) print $_POST['txt_apellidos1'];?>' type='text'>
										</td>
									</tr>
									<tr>
										<td align="left" width="20px">
											<?php if(isset($_POST['sel_grupo'])){if($_POST['sel_grupo']!=0){?><a  onclick='siguiente_anterior("prev");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_izq.png"></a><?php }else print '&nbsp;';}else print '&nbsp;';?>
										</td>
										
										<td align="right">
											Identificaci&oacute;n:
										</td>
										
										<td align="left">
											<input name='txt_identificacion1' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_cedula'])))print $rs_cli->fields['factura_cedula'];elseif(isset($_POST['txt_identificacion1'])) print $_POST['txt_identificacion1'];?>' type='text'>
										</td>
										
										<td align="right">
											Tel&eacute;fono:
										</td>
										
										<td align="left">
											<input name='txt_telefono1' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_telefono'])))print $rs_cli->fields['factura_telefono'];elseif(isset($_POST['txt_telefono1'])) print $_POST['txt_telefono1'];?>' type='text'>
										</td>
									</tr>
									<tr>
										<td colspan='2' align="right">
											Direcci&oacute;n:
										</td>
										
										<td colspan='3'align="left">
											<input name='txt_direccion1' size='80' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_direccion'])))print $rs_cli->fields['factura_direccion'];elseif(isset($_POST['txt_direccion1'])) print $_POST['txt_direccion1'];?>' type='text'>
										</td>
									</tr>
								</table>
								</fieldset>	
							</td>
	
							<td>
								<table align='center' id='id_<?php if((isset($rs_cli->fields['id_persona'])))print $rs_cli->fields['id_persona'];?>' style='display:inline-block,width="100%";' >
									<tr>					
										<td rowspan="3" width='30%' align="right">
										
										<?php
										if(isset($rs_cli->fields['camino_foto']))
										{
											$foto=$rs_cli->fields['camino_foto'];			
											if(base64_encode($foto))
											echo '<img style="margin:3px;border-radius:8px;" height="120px" src="data:image/jpeg;base64,'. base64_encode($foto). '"/>';
										}
										else
										echo '<img style="margin:3px;border-radius:8px;" height="120px" src="'.$x.'img/general/no_disponible.png"/>';
										?>
										</td>
										
										<td width='40%' align="right">
											Total:
										</td>
										
										<td colspan='2' align="left">
											<b><?php if(isset($total)){print number_format($total, 2, ',', '');}?></b>
										</td>
										
									</tr>
									<tr>
										
										<td align="right">
											Saldo disponible:
										</td>
										
										<td align="left">
											<b><?php if(isset($saldo_disponible)){print number_format($saldo_disponible, 2, ',', '');}?></b>
										</td>
										
										<td width='20px' align="center">
											<?php if(isset($_POST['sel_grupo'])){if($_POST['sel_grupo']!=0){?><a  onclick='siguiente_anterior("next");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_der.png"></a><?php }}?>
										</td>
									</tr>
									<tr>	
										<td align="right">
											Saldo final:<?php ?>
										</td>
										
										<td colspan='2' align="left">
											<b><?php if(isset($saldo_final)){print number_format($saldo_final, 2, ',', '');}?></b>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					
					
				
		
					<input name='cliente_seleccionado_<?php if((isset($rs_cli))){$rs_cli->MoveFirst();print $rs_cli->fields['id_persona'];}?>' id='cliente_seleccionado_<?php if((isset($rs_cli)))print $rs_cli->fields['id_persona'];?>' value='<?php if((isset($rs_cli)))print $rs_cli->fields['cliente'];?>' type='hidden'>
					
					
					
			<?php
			
			if(isset($_POST['sel_grupo']))
			{
				if($_POST['sel_grupo']!=0)
				{
					$rs_cli->MoveFirst();
					
					if(!isset($clientes))
					$clientes=$rs_cli->fields['id_persona'];

					$rs_cli->MoveNext();
					
					for($g=2;$g<=$rs_cli->RecordCount();$g++)
					{
						$clientes=$clientes.','.$rs_cli->fields['id_persona'];
						
						//---------------------SALDO DISPONIBLE------------------------	
						$sql_s="select ROUND(SUM(saldo),2) AS suma_saldo from saldo 
						where saldo.id_cliente='".$rs_cli->fields['id_cliente']."'";//print "<br><br>".$sql_s;
						$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
							
						$suma_saldo=$rs_s->fields["suma_saldo"];//print "saldo final".$suma_saldo;	
						
						$sql_v="select id_venta, ROUND(SUM(precio*cantidad),2) AS suma_venta from venta, cliente, producto_precio 
						where venta.id_cliente=cliente.id_cliente AND venta.id_producto_precio=producto_precio.id_producto_precio
						and anulada='0'	and cliente.id_persona=".$rs_cli->fields['id_persona'];//print "<br><br>".$sql_v; 
						$rs_v=$db->Execute($sql_v) or die($db->ErrorMsg());
											
						$suma_venta=$rs_v->fields["suma_venta"];//print "suma_venta: ".$suma_venta;	
						
						$saldo_disponible=bcsub($suma_saldo, $suma_venta, 14);
						$saldo_final=bcsub($saldo_disponible,$total,14);
						//---------------------SALDO DISPONIBLE------------------------
						
						if(isset($_POST['sel_punto_venta']) AND isset($_POST['cbx_referencia']))
						{
							if($_POST['cbx_referencia']!=0)
							{
								$sql_r="select * from referencia where id_punto_venta='".$_POST['sel_punto_venta']."' AND id_cliente='".$rs_cli->fields['id_cliente']."'";//print $sql_r;
								$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
							}
						}

			?>
					
					<table align='center' id='id_<?php print $rs_cli->fields['id_persona'];?>' style='display:none;' class='tabla_listar'>
						<tbody><tr>
							<td colspan='2' width='15%' align="right">
								Nombres:
							</td>
							<td width='15%' align="left">
								<input name='txt_nombres<?php print $g;?>' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_nombres'])))print $rs_cli->fields['factura_nombres'];elseif(isset($_POST['txt_nombres'.$g])) print $_POST['txt_nombres'.$g];?>' type='text'>
							</td>
							<td width='20%'align="right">
								Apellidos:
							</td>
							<td width='15%' align="left">
								<input name='txt_apellidos<?php print $g;?>' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_apellidos'])))print $rs_cli->fields['factura_apellidos'];elseif(isset($_POST['txt_apellidos'.$g])) print $_POST['txt_apellidos'.$g];?>' type='text'>
							</td>
							
							<td rowspan="3" width='1%' align="center">
							<?php
								if(isset($rs_cli->fields['camino_foto']))
								{
									$foto=$rs_cli->fields['camino_foto'];			
									if(base64_encode($foto))
									echo '<img style="margin:3px;border-radius:8px;" height="120px" src="data:image/jpeg;base64,'. base64_encode($foto). '"/>';
								}
								else
								echo '<img style="margin:3px;border-radius:8px;" height="120px" src="'.$x.'img/general/no_disponible.png"/>';
							?>
							</td>
							
							<td width='15%' align="right">
								Total:
							</td>
							
							<td colspan='2' width='18%' align="left">
								<b><?php if(isset($total)){print number_format($total, 2, ',', '');}?></b>
							</td>
						</tr>
						<tr>
							<td align="left" width='20px'>
								<?php if(isset($_POST['sel_grupo'])){if($_POST['sel_grupo']!=0){?><a  onclick='siguiente_anterior("prev");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_izq.png"></a><?php }else print '&nbsp;';}else print '&nbsp;';?>
							</td>
							
							<td align="right">
								Identificaci&oacute;n:
							</td>
							
							<td align="left">
								<input name='txt_identificacion<?php print $g;?>' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_cedula'])))print $rs_cli->fields['factura_cedula'];elseif(isset($_POST['txt_identificacion'.$g])) print $_POST['txt_identificacion'.$g];?>' type='text'>
							</td>
							<td align="right">
								Tel&eacute;fono:
							</td>
							
							<td align="left">
								<input name='txt_telefono<?php print $g;?>' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_telefono'])))print $rs_cli->fields['factura_telefono'];elseif(isset($_POST['txt_telefono'.$g])) print $_POST['txt_telefono'.$g];?>' type='text'>
							</td>
							
							<td align="right">
								Saldo disponible:
							</td>
							
							<td align="left">
								<b><?php if(isset($saldo_disponible)){print number_format($saldo_disponible, 2, ',', '');}?></b>
							</td>
							
							<td width='20px' align="center">
								<?php if(isset($_POST['sel_grupo'])){if($_POST['sel_grupo']!=0){?><a  onclick='siguiente_anterior("next");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_der.png"></a><?php }}?>
							</td>
						</tr>
						<tr>
							<td colspan='2' align="right">
								Direcci&oacute;n:
							</td>
							
							<td colspan='4'align="left">
								<input name='txt_direccion<?php print $g;?>' size='80' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0)  OR (isset($rs_cli->fields['factura_direccion'])))print $rs_cli->fields['factura_direccion'];elseif(isset($_POST['txt_direccion'.$g])) print $_POST['txt_direccion'.$g];?>' type='text'>
							</td>
							
							<td align="right">
								Saldo final:<?php ?>
							</td>
							
							<td colspan='2' align="left">
								<b><?php if(isset($saldo_final)){print number_format($saldo_final, 2, ',', '');}?></b>
							</td>
						</tr>
						
						<?php
						if(isset($_POST['cbx_referencia']))$cbx_referencia= $_POST['cbx_referencia'];else $cbx_referencia=0;//print $cbx_referencia;
						if(isset($rs_r->fields['referencia']) OR ($cbx_referencia==1)){?>
						
						<tr height='30'>
							<td colspan='2' align="right">
								Referencia:
							</td>
							
							<td colspan='7'align="left">
								<textarea name='txt_referencia<?php print $g;?>' rows="4" cols="90"><?php if(isset($rs_r->fields['referencia'])){print $rs_r->fields['referencia'];}elseif(isset($_POST['txt_referencia'.$g])) print $_POST['txt_referencia'.$g];?></textarea>
							</td>
						</tr>
						<?php }?>
						
						</tbody>
					</table>
					
					<input name='cliente_seleccionado_<?php print $rs_cli->fields['id_persona'];?>' id='cliente_seleccionado_<?php print $rs_cli->fields['id_persona'];?>' value='<?php print $rs_cli->fields['cliente'];?>' type='hidden'>
					
					<?php 
					$rs_cli->MoveNext();}
					?>
					
					<input name='clientes' value='<?php print $clientes;?>' type='hidden'>
					<input name='cliente' value='<?php $rs_cli->MoveFirst();print $rs_cli->fields['id_persona'];?>' type='hidden'>
			
			<?php
				}
			}

//----------------------------------------------------------------------------------------------------------------------------------------------------
			//if($saldo_disponible)
			//{
				
			
			
			
			?>
			
				</td>
			</tr>
			
			<tr>
				<td colspan='10' align="left">
				&nbsp;
				</td>	
			</tr>
			<?php
			//if(isset($_POST['sel_cliente']))
			//{
			?>
				<tr>
					<td align="right" width='10%'>
						&nbsp;
					</td>
					
					<td colspan='2'  align="left">
						&nbsp;
					</td>
					
					<td align="center" width='10%'>
						Forma de pago
					</td>
					
					<td align="center" width='10%'>
						Cantidad
					</td>
					
					<td align="center" width='10%'>
						Precio ($)
					</td>
				
					<td align="center" width='10%'>
						Subtotal
					</td>
					
				</tr>
				
				<?php
				$total=0;
				$subtotal=0;
				
				$filas=1;
				if(isset($_POST['filas']))
				$filas=$_POST['filas'];
				
				if(isset($_POST['sel_cliente']))
				{
					$sql_forma="SELECT * FROM n_forma_pago, cliente, cliente_forma_pago WHERE n_forma_pago.id_forma_pago=cliente_forma_pago.id_forma_pago AND cliente.id_cliente=cliente_forma_pago.id_cliente AND cliente.id_cliente='".$_POST['sel_cliente']."' AND cliente_forma_pago.id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_forma;
					$rs_forma=$db->Execute($sql_forma) or die($db->ErrorMsg());
				}
				
				if(!isset($rs_forma->fields['id_forma_pago']))
				{
					$sql_forma="SELECT * FROM n_forma_pago WHERE predeterminada='1'";//print $sql_forma;
					$rs_forma=$db->Execute($sql_forma) or die($db->ErrorMsg());
				}
					
				for($f=1;$f<=$filas;$f++)
				{
				?>
				
				<tr>
					<td align="right">
						Producto:
					</td>
					
					<td colspan='2' align="left">
						<select style="width:200px" class="js-example-basic-single_prod<?php echo $f;?>" name="sel_pro<?php echo $f;?>" id="sel_pro<?php echo $f;?>" <?php if(isset($_POST['sel_cliente']) AND $f==$filas) print "autofocus='autofocus'"; ?> onchange="javascript:document.frm.submit();">
							<option value="0">--------------Seleccionar--------------</option>
							<?php for($g=0;$g<$rs_pro->RecordCount();$g++){?>
							
								<option value="<?php print $rs_pro->fields['id_pro'];?>" <?php if(isset($_POST['sel_pro'.$f])){if($rs_pro->fields['id_pro']==$_POST['sel_pro'.$f]){?> selected="selected"<?php }}?> > <?php print $rs_pro->fields['pro'];?> </option>
								
							<?php $rs_pro->MoveNext();}$rs_pro->MoveFirst();if(isset($_POST['sel_pro'.$f])) if($_POST['sel_pro'.$f]==0)$filas=$f;?>
						</select>
					</td>
					
					<td align="center">
					<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){?>
						<select style="width:200px" name="sel_forma_pago<?php echo $f;?>" id="sel_forma_pago<?php echo $f;?>" onchange='forma_pago(<?php echo $f;?>)'>
							<?php for($k=0;$k<$rs_forma->RecordCount();$k++){?>
								<option value="<?php print $rs_forma->fields['id_forma_pago'];?>" <?php if(isset($_POST['sel_forma_pago'.$f])){if($rs_forma->fields['id_forma_pago']==$_POST['sel_forma_pago'.$f]){?> selected="selected"<?php }}?> > <?php print $rs_forma->fields['forma_pago'];?> </option>
							<?php $rs_forma->MoveNext();}$rs_forma->MoveFirst();?>
						</select>
					<?php }}?>
					</td>
					
					<td align="center">
					<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){?>
						<input type="text" name="txt_cantidad<?php echo $f;?>" onblur="javascript:document.frm.submit();" id="txt_cantidad<?php echo $f;?>"  title="Cantidad <?php echo $f;?>"  value="<?php print ${'cant_'.$f};?>" size="5" />
					<?php }}?>
					</td>
					
					
					
					<?php
					if(isset($_POST['sel_pro'.$f]))
					{
						if($_POST['sel_pro'.$f]!=0)
						{
							$subtotal=bcmul(${'prec_'.$f}, ${'cant_'.$f},14);//print " prec ".${'prec_'.$f}." cant ".${'cant_'.$f}." sub ".$subtotal;
							$total=bcadd($total,$subtotal,14);	
						}
					}
					
					
					//$saldo_final=bcsub($saldo_disponible,$total,14);
					?>
					
					<td align="center"><b>
						<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){ print number_format(${'prec_'.$f}, 2, ',', '');}}?>
					</b></td>
					
					<td align="center"><b>
						<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){ print number_format($subtotal, 2, ',', '');}}?>
						<input type="hidden" name="txt_subtotal<?php echo $f;?>" id="txt_subtotal<?php echo $f;?>" value="<?php print number_format($subtotal, 2, ',', '');$subtotal=0;?>"/>
					</b></td>
					
				</tr>
				
				<?php 
				}
				?>
				<input name="filas" type="hidden" value="<?php if($filas<7 AND isset($_POST['sel_cliente']))echo $filas+1;else echo $filas;?>"/>
				
	<?php
			//}
	
		}
	?>
	<tr>
		<td colspan='10' align="left">
		&nbsp;
		</td>	
	</tr>
	
<?php
	}
}
?>

	<tr>
		<td align="left">
		&nbsp;
		</td>	
	</tr>
</table>
	</td>
</tr>

<input name="id_factura" type="hidden" value="<?php if(isset($id_factura))echo $id_factura;?>"/>



<?php
if(isset($_GET['mensaje']))
{
	$mensaje=$_GET['mensaje'];
	$obj->Imprimir_mensaje($mensaje);	
	$_GET['mensaje']='';
}

?>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>