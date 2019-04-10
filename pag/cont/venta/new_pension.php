<?php
include("var_pension.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(!isset($_POST['sel_cliente']))
$_POST['sel_cliente']=0;
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<script type="text/javascript" class="js-code-basic">
$(document).ready(function() {
$(".js-example-basic-single_cliente").select2();
});
</script>

<?php
$hoy=date("Y-m-d");
$sql_p="SELECT n_punto_venta.id_punto_venta, punto_venta, descripcion FROM n_punto_venta,punto_venta_usuario, usuario, n_factura WHERE n_punto_venta.id_punto_venta=n_factura.id_punto_venta 
AND n_punto_venta.id_punto_venta=punto_venta_usuario.id_punto_venta AND n_factura.estado='1' AND fecha_vencimiento>='".$hoy."'
AND usuario.id_usuario=punto_venta_usuario.id_usuario AND usuario='".$_SESSION["user"]."' AND ORDER BY punto_venta DESC";//print $sql_p;
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
?>


&nbsp;
<tr><td>
<table class="tabla_venta" align="center">
<?php
if(isset($_GET['id_p']))
$_POST['sel_punto_venta']=$_GET['id_p'];
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
			Referencia:
		</td>
		
		<td  align="left" width='7%'>
			<section>
				<div class="checkbox-2">
					<input class="checkbox_oculto" name='cbx_referencia' value='1' onchange="javascript:document.frm.submit();" <?php if(isset($_POST['cbx_referencia'])){if(1==$_POST['cbx_referencia']){?> checked <?php }}?> type="checkbox" id="cbx_referencia" />
					<label for="cbx_referencia"></label>
				</div>
			</section>
		</td>
		
		
	
<?php
if(isset($_POST['sel_punto_venta']))
{	
	if($_POST['sel_punto_venta']!=0)
	{
		$sql_f="select * from n_factura where estado='1' and id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_f;
		$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
		
		$sql_n="select n_factura.id_factura, max(no_factura) as no_factura from venta, n_factura where venta.id_factura=n_factura.id_factura and estado='1' and id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_v;
		$rs_n=$db->Execute($sql_n) or die($db->ErrorMsg());
		
		if(isset($rs_n->fields["no_factura"]))
		{
			$no_factura=$rs_n->fields["no_factura"];
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
			
			$sql_gra="select DISTINCT n_grado.id_grado, grado from n_grado, n_grado_paralelo, grado_paralelo_periodo , curso_grado_paralelo_est, n_periodo_academico 
			where n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo AND n_grado_paralelo.id_grado=n_grado.id_grado
			AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo 
			AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' ORDER BY orden";
			$rs_gra=$db->Execute($sql_gra) or die($db->ErrorMsg());//print $sql_gru;
			
			if(isset($_POST['sel_paralelo']))
			{
				if($_POST['sel_paralelo']!=0)
				{
					$_POST['sel_cliente']=0;
				}
			}
			
			if(isset($_POST['sel_grado']))
			{
				$sql_par="select DISTINCT n_paralelo.id_paralelo, abreviatura from n_paralelo, n_grado_paralelo, grado_paralelo_periodo,curso_grado_paralelo_est, n_periodo_academico 
				where n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
				AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
				AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
				AND n_grado_paralelo.id_grado='".$_POST['sel_grado']."' ORDER BY orden";
				$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());//print $sql_gru;
			}

			if(isset($_POST['sel_cliente']))
			{
				if($_POST['sel_cliente']!=0)
				{
					$sql_cli="select persona.id_persona, factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, cliente.id_cliente,
					concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) AS cliente, camino_foto from persona, cliente, cliente_forma_pago
					where cliente.id_persona=persona.id_persona AND cliente.id_cliente =cliente_forma_pago.id_cliente 
					AND cliente_forma_pago.id_punto_venta='".$_POST['sel_punto_venta']."' AND cliente.id_cliente='".$_POST['sel_cliente']."' ORDER BY primer_apellido,segundo_apellido,primer_nombre";
					$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());//print $sql_cli;
					$id_persona=$rs_cli->Fields("id_persona");//print $id_persona;
					$permite_credito=$rs_cli->Fields("permite_credito");
				}
			}
			
			if(isset($_POST['sel_grado']) AND isset($_POST['sel_paralelo']))
			{
				if($_POST['sel_grado']!=0 AND $_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0)
				{
					$sql_cli="select DISTINCT cliente.id_cliente,persona.id_persona, factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, 
					concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) AS cliente, camino_foto 
					FROM  persona, cliente, grupos_clientes, n_grupo_cliente, estudiante, curso_grado_paralelo_est, n_grado_paralelo, grado_paralelo_periodo, cliente_forma_pago, n_periodo_academico
					where cliente.id_persona=persona.id_persona and cliente.id_cliente=grupos_clientes.id_cliente AND estudiante.id_persona=persona.id_persona AND curso_grado_paralelo_est.id_estudiante=estudiante.id_estudiante	
					AND cliente.id_cliente =cliente_forma_pago.id_cliente AND cliente_forma_pago.id_punto_venta='".$_POST['sel_punto_venta']."'
					AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
					and n_grupo_cliente.id_grupo_cliente=grupos_clientes.id_grupo_cliente AND n_grado_paralelo.id_paralelo='".$_POST['sel_paralelo']."' AND grupos_clientes.activo='1'
					AND n_grado_paralelo.id_grado='".$_POST['sel_grado']."' AND n_grupo_cliente.id_punto_venta='".$_POST['sel_punto_venta']."' 
					AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
					ORDER BY orden, primer_apellido,segundo_apellido,primer_nombre";//print $sql_cli;
					$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());//print $rs_cli;
				}
			}
			
			$rs_cli_combo="select DISTINCT persona.id_persona, cliente.id_cliente, identificacion,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre, grado, paralelo, n_grado_paralelo.abreviatura
			from persona, cliente, estudiante, n_grado, n_paralelo, curso_grado_paralelo_est , n_grado_paralelo, grado_paralelo_periodo, cliente_forma_pago, n_periodo_academico
			where cliente.id_persona=persona.id_persona AND estudiante.id_persona=persona.id_persona 
			AND curso_grado_paralelo_est.id_estudiante=estudiante.id_estudiante			
			AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
			AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo 
			AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
			AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo
			AND n_grado_paralelo.id_grado=n_grado.id_grado
			AND cliente.id_cliente =cliente_forma_pago.id_cliente AND cliente_forma_pago.id_punto_venta='".$_POST['sel_punto_venta']."'";
			
			if(isset($_POST['sel_grado']) AND $_POST['sel_grado']!=0)$rs_cli_combo=$rs_cli_combo." AND n_grado.id_grado = '".$_POST['sel_grado']."'";
			$rs_cli_combo=$rs_cli_combo."ORDER BY orden, primer_apellido,segundo_apellido,primer_nombre ";//print $rs_cli_combo;
			
			$rs_cli_combo=$db->Execute($rs_cli_combo) or die($db->ErrorMsg());
			
			if(isset($rs_cli_combo->fields["id_persona"]) AND isset($rs_cli_combo->fields["id_cliente"]))
			{
				$id_persona=$rs_cli_combo->Fields("id_persona");//print $id_persona;
				$id_cliente=$rs_cli_combo->Fields("id_cliente");
				$permite_credito=$rs_cli_combo->Fields("permite_credito");
			}
			
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
			
			
	
	
	
	
	
?>
			
			
				<td colspan='6' align="left" >
					No de factura:<input size='8' name='txt_no_factura' value='<?php print $no_factura;?>' type='text'>
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
					Grado:
				</td>
				
				<td colspan='2' align="left">
					<select name="sel_grado" id="sel_grado" onchange="javascript:document.frm.submit();">
						<option value="0">---Seleccionar---</option>
						<?php for($g=0;$g<$rs_gra->RecordCount();$g++){?>
						
							<option value="<?php print $rs_gra->fields['id_grado'];?>" <?php if(isset($_POST['sel_grado'])){if($rs_gra->fields['id_grado']==$_POST['sel_grado']){?> selected="selected"<?php }}?> > <?php print $rs_gra->fields['grado'];?> </option>
							
						<?php $rs_gra->MoveNext();}$rs_gra->MoveFirst();?>
					</select>
				</td>
				
				<td align="right">
					Paralelo:
				</td>
				
				<td colspan='2' align="left">
					<select name="sel_paralelo" id="sel_paralelo" onchange="javascript:document.frm.submit();">
						<option value="0">---Seleccionar---</option>
						<?php if(isset($_POST['sel_grado'])){for($g=0;$g<$rs_par->RecordCount();$g++){?>
						
							<option value="<?php print $rs_par->fields['id_paralelo'];?>" <?php if(isset($_POST['sel_paralelo'])){if($rs_par->fields['id_paralelo']==$_POST['sel_paralelo']){?> selected="selected"<?php }}?> > <?php print $rs_par->fields['abreviatura'];?> </option>
							
						<?php $rs_par->MoveNext();}$rs_par->MoveFirst();}?>
					</select>
				</td>
				
				<td align="right">
					Estudiante:
				</td>
				
				<td colspan='2' align="left" width='40%'>
				<?php 
				if(isset($_POST['sel_paralelo']))
				{
					if($_POST['sel_paralelo']==0)
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
								?> 
											selected="selected"
								<?php 
										}
									}
								?><?php 
									if(isset($rs_cli->fields['cod_barra']))
									{
										if($rs_cli_combo->fields['id_cliente']==$id_persona)
										{
								?> 
											selected="selected"
								<?php 
										}
									}
								?>  
									> 
								<?php 
									print $rs_cli_combo->fields['abreviatura'].' - '.$rs_cli_combo->fields['primer_apellido'].' '.$rs_cli_combo->fields['segundo_apellido'].' '.$rs_cli_combo->fields['primer_nombre'].' '.$rs_cli_combo->fields['segundo_nombre'];
								?> 
							</option>
							
						<?php $rs_cli_combo->MoveNext();}$rs_cli_combo->MoveFirst();?>
					</select>
				<?php 
					}
					//else
					//$_POST['sel_cliente']=0;
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
								?> 
											selected="selected"
								<?php 
										}
									}
								?><?php 
									if(isset($rs_cli->fields['cod_barra']))
									{
										if($rs_cli_combo->fields['id_cliente']==$id_persona)
										{
								?> 
											selected="selected"
								<?php 
										}
									}
								?>  
									> 
								<?php 
									print $rs_cli_combo->fields['abreviatura'].' - '.$rs_cli_combo->fields['primer_apellido'].' '.$rs_cli_combo->fields['segundo_apellido'].' '.$rs_cli_combo->fields['primer_nombre'].' '.$rs_cli_combo->fields['segundo_nombre'];
								?> 
							</option>
							
						<?php $rs_cli_combo->MoveNext();}$rs_cli_combo->MoveFirst();?>
					</select>
				<?php
				}
				
				if(isset($_POST['sel_paralelo']))
				{
					if($_POST['sel_paralelo']!=0)
					{
				?>
					<input size='60' disabled name='cliente_seleccionado' value='<?php if(isset($rs_cli->fields['cliente']))print $rs_cli->fields['cliente'];?>' type='text' <?php if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']==0){?> style='display:none;'<?php }}?><?php if(!isset($_POST['sel_paralelo'])){?> style='display:none;'<?php }?>>
				<?php
					}
				}
				?>
				</td>
			</tr>
			</table>
			</td>
			</tr>
			
			<?php
			
			if(isset($_POST['sel_paralelo']))
			{
				if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente']))
				{
					$sql_pro="select precio, cantidad, producto_precio.id_producto_precio AS id_pro, concat(cod_producto,' - ',producto) AS pro 
					from producto_precio, n_producto, n_punto_venta, preventa, grupos_clientes, n_grupo_cliente
					WHERE producto_precio.id_producto=n_producto.id_producto 
					AND preventa.id_producto=n_producto.id_producto 
					AND n_grupo_cliente.id_punto_venta='".$_POST['sel_punto_venta']."' 
					AND n_grupo_cliente.id_grupo_cliente=grupos_clientes.id_grupo_cliente 
					AND n_grupo_cliente.id_grupo_cliente=preventa.id_grupo_cliente 
					AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta 
					AND grupos_clientes.activo='1' 
					AND producto_precio.activo='1' 
					and n_punto_venta.id_punto_venta='".$_POST['sel_punto_venta']."' 
					and grupos_clientes.id_cliente='".$rs_cli->fields['id_cliente']."'";//print $sql_pro;
					$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());
				}
				else
				{
					$sql_pro="select producto_precio.id_producto_precio AS id_pro, concat(cod_producto,' - ',producto) AS pro from producto_precio, n_producto, n_punto_venta WHERE producto_precio.id_producto=n_producto.id_producto 
					AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta AND activo='1' and n_punto_venta.id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_pro;
					$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());
				}
			}
			else
			{
				$sql_pro="select producto_precio.id_producto_precio AS id_pro, concat(cod_producto,' - ',producto) AS pro from producto_precio, n_producto, n_punto_venta WHERE producto_precio.id_producto=n_producto.id_producto 
				AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta AND activo='1' and n_punto_venta.id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_pro;
				$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());
			}
			//---------------------PRECIO, CANTIDAD, SUBTOTAL Y TOTAL---------------------
			$total=0;
//print $sql_pro;
			if(isset($_POST['sel_paralelo']))
			{
				if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente']))
				{					
					for($y=0;$y<$rs_pro->RecordCount();$y++)
					{
						$subtotal=bcmul($rs_pro->Fields("cantidad"), $rs_pro->Fields("precio"),14);//print " prec ".${'prec_'.$f}." cant ".${'cant_'.$f}." sub ".$subtotal.'<br>';
						$total=bcadd($total,$subtotal,14);
						
					$rs_pro->MoveNext();
					}
				}
				else
				{
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
				}
			}		
			//---------------------PRECIO, CANTIDAD, SUBTOTAL Y TOTAL---------------------
			if(isset($rs_cli->fields['id_cliente']))
			{
				//---------------------SALDO DISPONIBLE------------------------	
				$sql_s="select ROUND(SUM(saldo),2) AS suma_saldo from saldo WHERE 1 AND id_punto_venta='".$_POST['sel_punto_venta']."'
				AND saldo.id_cliente='".$rs_cli->fields['id_cliente']."'";//print "<br><br>".$sql_s;
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
				<td colspan='10' align="left">					
					<br>					
					<table class='tabla_listar' align='center' id='id_<?php if((isset($rs_cli->fields['id_persona'])))print $rs_cli->fields['id_persona'];?>' style='display:inline-block,width="100%";' >
					<tr>	
					<td>
					<fieldset>
					<legend>Registro 1</legend>
					<table width='100%'>
					
						
						<tr>
							<td colspan='2' width='15%' align="right">
								Nombres:
							</td>
							
							<td width='15%' align="left">
								<input name='txt_nombres1' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_nombres'])))print $rs_cli->fields['factura_nombres'];elseif(isset($_POST['txt_nombres1'])) print $_POST['txt_nombres1'];?>' type='text'>
							</td>
							
							<td width='20%'align="right">
								Apellidos:
							</td>
							
							<td width='15%' align="left">
								<input name='txt_apellidos1' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_apellidos'])))print $rs_cli->fields['factura_apellidos'];elseif(isset($_POST['txt_apellidos1'])) print $_POST['txt_apellidos1'];?>' type='text'>
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
							<td align="left" width="20px">
								<?php if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente'])){?><a  onclick='siguiente_anterior("prev");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_izq.png"></a><?php }else print '&nbsp;';}else print '&nbsp;';?>
							</td>
							
							<td align="right">
								Identificaci&oacute;n:
							</td>
							
							<td align="left">
								<input name='txt_identificacion1' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_cedula'])))print $rs_cli->fields['factura_cedula'];elseif(isset($_POST['txt_identificacion1'])) print $_POST['txt_identificacion1'];?>' type='text'>
							</td>
							
							<td align="right">
								Tel&eacute;fono:
							</td>
							
							<td align="left">
								<input name='txt_telefono1' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_telefono'])))print $rs_cli->fields['factura_telefono'];elseif(isset($_POST['txt_telefono1'])) print $_POST['txt_telefono1'];?>' type='text'>
							</td>
							
							<td align="right">
								Saldo disponible:
							</td>
							
							<td align="left">
								<b><?php if(isset($saldo_disponible)){print number_format($saldo_disponible, 2, ',', '');}?></b>
							</td>
							
							<td width='20px' align="center">
								<?php if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente'])){?><a  onclick='siguiente_anterior("next");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_der.png"></a><?php }}?>
							</td>
						</tr>
						
						<tr>
							<td colspan='2' align="right">
								Direcci&oacute;n:
							</td>
							
							<td colspan='4'align="left">
								<input name='txt_direccion1' size='80' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_direccion'])))print $rs_cli->fields['factura_direccion'];elseif(isset($_POST['txt_direccion1'])) print $_POST['txt_direccion1'];?>' type='text'>
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
								<textarea name='txt_referencia1' rows="4" cols="90"><?php if(isset($rs_r->fields['referencia'])){print $rs_r->fields['referencia'];}elseif(isset($_POST['txt_referencia1']) AND isset($rs_cli->fields['id_cliente'])) print $_POST['txt_referencia1'];?></textarea>
							</td>
						</tr>
						<?php }
						
					if(isset($_POST['sel_paralelo']))
					{
						if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente']))
						{
						?>
						<?php //------------------PRODUCTO PRECONFIGURADO------------------?><tr>	
			
						
						<tr>
						<td align="right" colspan='9'>
						<br>
						
						<fieldset>
						<legend>Productos preconfigurados 1</legend>
						<table width='100%'>	
							<tr>
								<td align="right" width='5%'>
								&nbsp;
								</td>
								
								<td colspan='2' width='30%' align="left">
									&nbsp;
								</td>
								
								<td align="center" width='25%'>
									Forma de pago
								</td>
								
								<td align="left" width='10%'>
									Cantidad
								</td>
								
								<td align="left" width='15%'>
									Precio ($)
								</td>
								
								<td align="right">
									&nbsp;
								</td>
								
								<td align="right">
									&nbsp;
								</td>
								
								<td align="left" width='15%'>
									Subtotal
								</td>
							</tr>
							
							<?php
							$sql_forma="SELECT * FROM n_forma_pago, cliente, cliente_forma_pago WHERE n_forma_pago.id_forma_pago=cliente_forma_pago.id_forma_pago AND cliente.id_cliente=cliente_forma_pago.id_cliente AND cliente.id_cliente='".$rs_cli->fields['id_cliente']."' AND cliente_forma_pago.id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_forma;
							$rs_forma=$db->Execute($sql_forma) or die($db->ErrorMsg());
							
							$rs_pro->MoveFirst();
							for($y=0;$y<$rs_pro->RecordCount();$y++)
							{
							?>
							
								<tr>
								<td align="right">
									Producto:
								</td>
								
								<td colspan='2' align="left">
									<input disabled type="text" name="txt_precio<?php echo $y;?>" id="txt_precio<?php echo $y;?>"  title="Precio <?php echo $y;?>"  value="<?php if(isset($rs_pro->fields['pro']))print $rs_pro->fields['pro'];?>" size="50"/>
								</td>
								
								<td align="center">
								<?php if(isset($rs_pro->fields['cantidad'])){?>
									<select style="width:200px" name="sel_forma_pago<?php echo $y;?>" id="sel_forma_pago<?php echo $y;?>" onchange='forma_pago(<?php echo $y;?>)'>
										<?php for($k=0;$k<$rs_forma->RecordCount();$k++){?>
											<option value="<?php print $rs_forma->fields['id_forma_pago'];?>" <?php if(isset($_POST['sel_forma_pago'.$y])){if($rs_forma->fields['id_forma_pago']==$_POST['sel_forma_pago'.$y]){?> selected="selected"<?php }}?> > <?php print $rs_forma->fields['forma_pago'];?> </option>
										<?php $rs_forma->MoveNext();}$rs_forma->MoveFirst();?>
									</select>
								<?php }?>
								</td>
								
								<td align="left">
								<?php if(isset($rs_pro->fields['cantidad'])){?>
									<input disabled type="text" name="txt_cantidad<?php echo $y;?>" id="txt_cantidad<?php echo $y;?>"  title="Cantidad <?php echo $y;?>"  value="<?php print $rs_pro->fields['cantidad'];?>" size="5" />
								<?php }?>
								</td>
																
								<?php
								$subtotal=bcmul($rs_pro->Fields("cantidad"), $rs_pro->Fields("precio"),14);//print " prec ".${'prec_'.$f}." cant ".${'cant_'.$f}." sub ".$subtotal.'<br>';
								$total=bcadd($total,$subtotal,14);
								
								?>
								
								<td align="left"><b>
									<?php if(isset($rs_pro->fields['precio'])){print number_format($rs_pro->fields['precio'], 2, ',', '');}?>
								</b></td>
								
								<td align="right">
									&nbsp;
								</td>
								
								<td align="right">
									&nbsp;
								</td>
								
								<td align="left"><b>
									<?php if(isset($rs_pro->fields['precio'])){ print number_format($subtotal, 2, ',', '');}?>
									<input type="hidden" name="txt_subtotal<?php echo $f;?>" id="txt_subtotal<?php echo $f;?>" value="<?php if(isset($subtotal))print number_format($subtotal, 2, ',', '');$subtotal=0;?>"/>
								</b></td>
								
							</tr>
							<?php 
							$rs_pro->MoveNext();
							}
							?>
							</table>
							</fieldset>	
							</td>
							</tr>
							
							
					<?php 
						}
					}
					?>
						
						<?php //------------------PRODUCTO PRECONFIGURADO------------------?>
						
									
					</table>
					</fieldset>	
					</td>
					</tr>
					</table>
					
		
					<input name='cliente_seleccionado_<?php if((isset($rs_cli))){$rs_cli->MoveFirst();print $rs_cli->fields['id_persona'];}?>' id='cliente_seleccionado_<?php if((isset($rs_cli)))print $rs_cli->fields['id_persona'];?>' value='<?php if((isset($rs_cli)))print $rs_cli->fields['cliente'];?>' type='hidden'>
					
					
					
			<?php
			
			if(isset($_POST['sel_paralelo']))
			{
				if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente']))
				{
					$rs_cli->MoveFirst();
					
					if(!isset($clientes))
					$clientes=$rs_cli->fields['id_persona'];

					$rs_cli->MoveNext();
					
					for($g=2;$g<=$rs_cli->RecordCount();$g++)
					{
						$clientes=$clientes.','.$rs_cli->fields['id_persona'];
						
						$sql_pro="select grupos_clientes.id_cliente, precio, cantidad, producto_precio.id_producto_precio AS id_pro, concat(cod_producto,' - ',producto) AS pro from producto_precio, n_producto, n_punto_venta, preventa, grupos_clientes, n_grupo_cliente
						WHERE producto_precio.id_producto=n_producto.id_producto AND preventa.id_producto=n_producto.id_producto AND n_grupo_cliente.id_grupo_cliente=grupos_clientes.id_grupo_cliente 
						AND n_grupo_cliente.id_grupo_cliente=preventa.id_grupo_cliente AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta AND grupos_clientes.activo='1' AND producto_precio.activo='1' 
						and n_punto_venta.id_punto_venta='".$_POST['sel_punto_venta']."' and grupos_clientes.id_cliente='".$rs_cli->fields['id_cliente']."'";//print $sql_pro;
						$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());
					
						//---------------------PRECIO, CANTIDAD, SUBTOTAL Y TOTAL---------------------
						$total=0;
						if(isset($_POST['sel_paralelo']))
						{
							if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente']))
							{					
								for($y=0;$y<$rs_pro->RecordCount();$y++)
								{
									$subtotal=bcmul($rs_pro->Fields("cantidad"), $rs_pro->Fields("precio"),14);//print " prec ".${'prec_'.$f}." cant ".${'cant_'.$f}." sub ".$subtotal.'<br>';
									$total=bcadd($total,$subtotal,14);
									
								$rs_pro->MoveNext();
								}					
							}
							else
							{
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
							}
						}					
						//---------------------PRECIO, CANTIDAD, SUBTOTAL Y TOTAL---------------------
						
						//---------------------SALDO DISPONIBLE------------------------
						$sql_s="select ROUND(SUM(saldo),2) AS suma_saldo from saldo WHERE 1 AND id_punto_venta='".$_POST['sel_punto_venta']."'
						AND saldo.id_cliente='".$rs_cli->fields['id_cliente']."'";//print "<br><br>".$sql_s;
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
							if($_POST['cbx_referencia']!=0)
							{
								$sql_r="select * from referencia where id_punto_venta='".$_POST['sel_punto_venta']."' AND id_cliente='".$rs_cli->fields['id_cliente']."'";//print $sql_r;
								$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
							}
						}

			?>
					
					<table align='center' id='id_<?php print $rs_cli->fields['id_persona'];?>' style='display:none;' class='tabla_listar'>
					<tr>	
					<td>
					<fieldset>
					<legend>Registro <?php print $g;?></legend>
					<table width='100%'>
						<tbody><tr>
							<td colspan='2' width='15%' align="right">
								Nombres1:
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
								<?php if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente'])){?><a  onclick='siguiente_anterior("prev");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_izq.png"></a><?php }else print '&nbsp;';}else print '&nbsp;';?>
							</td>
							
							<td align="right">
								Identificaci&oacute;n:
							</td>
							
							<td align="left">
								<input name='txt_identificacion<?php print $g;?>' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_cedula'])))print $rs_cli->fields['factura_cedula'];elseif(isset($_POST['txt_identificacion'.$g])) print $_POST['txt_identificacion'.$g];?>' type='text'>
							</td>
							<td align="right">
								Tel&eacute;fono:
							</td>
							
							<td align="left">
								<input name='txt_telefono<?php print $g;?>' size='15' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_telefono'])))print $rs_cli->fields['factura_telefono'];elseif(isset($_POST['txt_telefono'.$g])) print $_POST['txt_telefono'.$g];?>' type='text'>
							</td>
							
							<td align="right">
								Saldo disponible:
							</td>
							
							<td align="left">
								<b><?php if(isset($saldo_disponible)){print number_format($saldo_disponible, 2, ',', '');}?></b>
							</td>
							
							<td width='20px' align="center">
								<?php if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']!=0 AND $_POST['sel_cliente']==0 AND isset($rs_cli->fields['id_cliente'])){?><a  onclick='siguiente_anterior("next");'><img height="20px" width="20px" border="0" src="../../../img/general/flecha_der.png"></a><?php }}?>
							</td>
						</tr>
						<tr>
							<td colspan='2' align="right">
								Direcci&oacute;n:
							</td>
							
							<td colspan='4'align="left">
								<input name='txt_direccion<?php print $g;?>' size='80' value='<?php if((isset($_POST['sel_cliente']) AND $_POST['sel_cliente']!=0) OR (isset($rs_cli->fields['factura_direccion'])))print $rs_cli->fields['factura_direccion'];elseif(isset($_POST['txt_direccion'.$g])) print $_POST['txt_direccion'.$g];?>' type='text'>
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
						
						<?php //------------------PRODUCTO PRECONFIGURADO------------------?>
						
						<tr>
						<td align="right" colspan='9'>
						<br>
						
						<fieldset>
						<legend>Productos preconfigurados <?php print $g;?></legend>
						<table width='100%'>	
						<tr>
							<td align="right" width='5%'>
								&nbsp;
							</td>
							
							<td colspan='2' width='30%' align="left">
								&nbsp;
							</td>
							
							<td align="center" width='25%'>
								Forma de pago
							</td>
							
							<td align="left" width='10%'>
								Cantidad
							</td>
							
							<td align="left" width='15%'>
								Precio ($)
							</td>
							
							<td align="right">
								&nbsp;
							</td>
							
							<td align="right">
								&nbsp;
							</td>
							
							<td align="left" width='15%'>
								Subtotal
							</td>
							
						</tr>
						
						<?php
						$sql_forma="SELECT * FROM n_forma_pago, cliente, cliente_forma_pago WHERE n_forma_pago.id_forma_pago=cliente_forma_pago.id_forma_pago AND cliente.id_cliente=cliente_forma_pago.id_cliente AND cliente.id_cliente='".$rs_cli->fields['id_cliente']."' AND cliente_forma_pago.id_punto_venta='".$_POST['sel_punto_venta']."'";//print $sql_forma;
						$rs_forma=$db->Execute($sql_forma) or die($db->ErrorMsg());
						
						$rs_pro->MoveFirst();
						for($y=0;$y<$rs_pro->RecordCount();$y++)
						{
						?>
						
						<tr>
							<td align="right">
								Producto:
							</td>
							
							<td colspan='2' align="left">
								<input disabled type="text" name="txt_precio<?php echo $y;?>" id="txt_precio<?php echo $y;?>"  title="Precio <?php echo $y;?>"  value="<?php if(isset($rs_pro->fields['pro']))print $rs_pro->fields['pro'];?>" size="50"/>
							</td>
							
							<td align="center">
							<?php if(isset($rs_pro->fields['cantidad'])){?>
								<select style="width:200px" name="sel_forma_pago<?php echo $y;?>" id="sel_forma_pago<?php echo $y;?>" onchange='forma_pago(<?php echo $y;?>)'>
									<?php for($k=0;$k<$rs_forma->RecordCount();$k++){?>
										<option value="<?php print $rs_forma->fields['id_forma_pago'];?>" <?php if(isset($_POST['sel_forma_pago'.$y])){if($rs_forma->fields['id_forma_pago']==$_POST['sel_forma_pago'.$y]){?> selected="selected"<?php }}?> > <?php print $rs_forma->fields['forma_pago'];?> </option>
									<?php $rs_forma->MoveNext();}$rs_forma->MoveFirst();?>
								</select>
							<?php }?>
							</td>
							
							<td align="left">
							<?php if(isset($rs_pro->fields['cantidad'])){?>
								<input disabled type="text" name="txt_cantidad<?php echo $y;?>" id="txt_cantidad<?php echo $y;?>"  title="Cantidad <?php echo $y;?>"  value="<?php print $rs_pro->fields['cantidad'];?>" size="5" />
							<?php }?>
							</td>
							
							<?php
							$subtotal=bcmul($rs_pro->Fields("cantidad"), $rs_pro->Fields("precio"),14);//print " prec ".${'prec_'.$f}." cant ".${'cant_'.$f}." sub ".$subtotal.'<br>';
							$total=bcadd($total,$subtotal,14);
							?>
							
							<td align="left"><b>
								<?php if(isset($rs_pro->fields['precio'])){print number_format($rs_pro->fields['precio'], 2, ',', '');}?>
							</b></td>
							
							<td align="right">
								&nbsp;
							</td>
							
							<td align="right">
								&nbsp;
							</td>
							
							<td align="left"><b>
								<?php if(isset($rs_pro->fields['precio'])){ print number_format($subtotal, 2, ',', '');}?>
								<input type="hidden" name="txt_subtotal<?php echo $f;?>" id="txt_subtotal<?php echo $f;?>" value="<?php if(isset($subtotal))print number_format($subtotal, 2, ',', '');$subtotal=0;?>"/>
							</b></td>
							
						</tr>
						<?php 
						$rs_pro->MoveNext();
						}
						?>
						</table>
						</fieldset>	
						</td>
						</tr>
					<?php //------------------PRODUCTO PRECONFIGURADO------------------?>
						
						</tbody>
					</table>
					</fieldset>	
					</td>
					</tr>
					
					
					<input name='cliente_seleccionado_<?php print $rs_cli->fields['id_persona'];?>' id='cliente_seleccionado_<?php print $rs_cli->fields['id_persona'];?>' value='<?php print $rs_cli->fields['cliente'];?>' type='hidden'>
					
					<?php 
					$rs_cli->MoveNext();
					}
					?>
					
					<input name='clientes' value='<?php print $clientes;?>' type='hidden'>
					<input name='cliente' value='<?php $rs_cli->MoveFirst();print $rs_cli->fields['id_persona'];?>' type='hidden'>
			
			<?php
				}
			}

//----------------------------------------------------------------------------------------------------------------------------------------------------

			//print "ddddddddddd".$_POST['sel_paralelo'];
			?>
			
	
					</td>
				</tr>
			
			
			<tr>
				<td colspan='10' align="left">
				&nbsp;
				</td>	
			</tr>
			<?php
			
			if(isset($_POST['sel_paralelo']))
			{
				if($_POST['sel_paralelo']==0)
				{
					include("pension/prod_forma_pago_cant.php");
				}//if del paralelo
			}//if del paralelo
			else
			include("pension/prod_forma_pago_cant.php");
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
		<td colspan='10' align="left">
		&nbsp;
		</td>	
	</tr>
</table>
</td>
</tr>

<input name="id_factura" type="hidden" value="<?php if(isset($id_factura))echo $id_factura;?>"/>



<?php 

//$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>