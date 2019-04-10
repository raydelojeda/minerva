<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

$checked="";
$disable="";
$no_mas="";
$abrev="";

$sql_f="SELECT id_grupo_cliente, concat(punto_venta,' - ',grupo_cliente) AS grupo_cliente FROM n_grupo_cliente, n_punto_venta 
WHERE n_grupo_cliente.id_punto_venta=n_punto_venta.id_punto_venta";
$rs_g=$db->Execute($sql_f) or die($db->ErrorMsg());

$sql_par="select DISTINCT n_grado_paralelo.id_grado_paralelo, abreviatura from n_paralelo, n_grado_paralelo, grado_paralelo_periodo,curso_grado_paralelo_est 
where n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo ORDER BY orden";
$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());//print $sql_gru;

if(isset($_POST['sel_tipo']))
{
	if($_POST['sel_tipo']==1)
	{
		$sql_cli="SELECT cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente 
		FROM persona, cliente, empleado WHERE persona.id_persona=cliente.id_persona AND persona.id_persona=empleado.id_persona";
		if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']!=0){$sql_cli=$sql_cli." AND cliente.id_cliente='".$_POST['sel_cliente']."'";}} //print $sql_cli;
		$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());
		
		if(!isset($rs_cli->fields['id_cliente']))
		$_POST['sel_cliente']=0;
	}	
	elseif($_POST['sel_tipo']==2)
	{
		$sql_cli="SELECT cliente.id_cliente as id_cliente
		FROM persona, cliente, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo 
		WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND persona.id_persona=cliente.id_persona AND persona.id_persona=estudiante.id_persona ";
		if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']!=0){$sql_cli=$sql_cli." AND n_grado_paralelo.id_grado_paralelo='".$_POST['sel_paralelo']."'";}}
		if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']!=0){$sql_cli=$sql_cli." AND cliente.id_cliente='".$_POST['sel_cliente']."'";}}
		$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());

		if(!isset($rs_cli->fields['id_cliente']))
		$_POST['sel_cliente']=0;
	}
	elseif($_POST['sel_tipo']==3)
	{
		$sql_cli="SELECT cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente 
		FROM persona, cliente
		LEFT OUTER JOIN empleado ON empleado.id_persona=cliente.id_persona
		LEFT OUTER JOIN estudiante ON estudiante.id_persona=cliente.id_persona
		WHERE cliente.id_persona=persona.id_persona AND empleado.id_empleado IS NULL AND estudiante.id_estudiante IS NULL";
		if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']!=0){$sql_cli=$sql_cli." AND cliente.id_cliente='".$_POST['sel_cliente']."'";}}
		$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());
		
		if(!isset($rs_cli->fields['id_cliente']))
		$_POST['sel_cliente']=0;
	}

	if($_POST['sel_tipo']==1)
	{
		$sql_c="SELECT cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente 
		FROM persona, cliente, empleado WHERE persona.id_persona=cliente.id_persona AND persona.id_persona=empleado.id_persona";
		if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']!=0){$sql_c=$sql_c." AND cliente.id_cliente='".$_POST['sel_cliente']."'";}}
		$sql_c=$sql_c." ORDER BY primer_apellido, segundo_apellido, primer_nombre";
		
	}
	elseif($_POST['sel_tipo']==2)
	{
		$sql_c="SELECT cliente.id_cliente as id_cliente, abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente 
		FROM persona, cliente, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo 
		WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND persona.id_persona=cliente.id_persona AND persona.id_persona=estudiante.id_persona";
		if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']!=0){$sql_c=$sql_c." AND n_grado_paralelo.id_grado_paralelo='".$_POST['sel_paralelo']."'";}}
		if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']!=0){$sql_c=$sql_c." AND cliente.id_cliente='".$_POST['sel_cliente']."'";}}
		$sql_c=$sql_c." ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";
	}
	elseif($_POST['sel_tipo']==3)
	{
		$sql_c="SELECT cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente 
		FROM persona, cliente
		LEFT OUTER JOIN empleado ON empleado.id_persona=cliente.id_persona
		LEFT OUTER JOIN estudiante ON estudiante.id_persona=cliente.id_persona
		WHERE cliente.id_persona=persona.id_persona AND empleado.id_empleado IS NULL AND estudiante.id_estudiante IS NULL";
		if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']!=0){$sql_c=$sql_c." AND cliente.id_cliente='".$_POST['sel_cliente']."'";}}
		$sql_c=$sql_c." ORDER BY primer_apellido, segundo_apellido, primer_nombre";
	}
	if(isset($sql_c))
	$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
}
//if(isset($_POST['sel_punto']))
//$sql_c=$sql_c."AND punto_venta='".$_POST['sel_punto']."' ";

//$sql_e=$sql_e."ORDER BY punto_venta, elemento";//print $sql_e;
//

if(isset($_POST['sel_tipo']))
{
	if($_POST['sel_tipo']!=0)
	{
		if(isset($_POST['aux_submit']))
		{
			if($_POST['aux_submit']=='ok')
			{
				if(isset($_POST['sel_grupo'])) $sql_f=$sql_f." AND id_grupo_cliente='".$_POST['sel_grupo']."'";
				$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
				
				$rs_c->MoveFirst();
				for($c=0;$c<$rs_c->RecordCount();$c++)
				{
					$rs_f->MoveFirst();
					for($f=0;$f<$rs_f->RecordCount();$f++)
					{
						$cbx = (string) 'checkbox_'.$rs_c->fields['id_cliente'].$rs_f->fields['id_grupo_cliente'];
						
						$sql="SELECT id_grupos_clientes FROM grupos_clientes
						WHERE id_cliente='".$rs_c->fields['id_cliente']."' AND id_grupo_cliente='".$rs_f->fields['id_grupo_cliente']."'";//print $sql."<br>";//die();
						$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;
							
						if(isset($_POST[$cbx]))
						{
							if(!isset($rs->fields['id_grupos_clientes']))
							{
								$i_sql="INSERT INTO grupos_clientes (id_cliente, id_grupo_cliente, activo) VALUES ('".$rs_c->fields['id_cliente']."','".$rs_f->fields['id_grupo_cliente']."', '1')";//print $i_sql."<br>";
								$db->Execute($i_sql) or die($db->ErrorMsg());
							}
							/*else
							{
								$u_sql="UPDATE grupos_clientes SET id_forma_pago='".$rs_f->fields['id_forma_pago']."' WHERE id_cliente='".$rs_c->fields['id_cliente']."' AND id_punto_venta='".$_POST['sel_punto']."'";print $u_sql."<br>";
								$db->Execute($u_sql) or die($db->ErrorMsg());
							}*/
						}
						else
						{
							/*$sql_d="SELECT id_grupos_clientes FROM grupos_clientes
							WHERE id_cliente='".$rs_c->fields['id_cliente']."' AND id_forma_pago='".$rs_f->fields['id_forma_pago']."' AND id_punto_venta='".$_POST['sel_punto']."'";//print $sql."<br>";//die();
							$rs_d=$db->Execute($sql_d) or die($db->ErrorMsg());//print $rs;*/
							
							if(isset($rs->fields['id_grupos_clientes']))
							{
								$d_sql="DELETE FROM grupos_clientes WHERE id_grupos_clientes='".$rs->fields['id_grupos_clientes']."'";//print $d_sql."<br>";
								$db->Execute($d_sql) or die($db->ErrorMsg());
							}
						}
					$rs_f->MoveNext();
					}
				$rs_c->MoveNext();
				}
			}
		}
	}
}
 ?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<script type="text/javascript" class="js-code-basic">
$(document).ready(function() {
$(".js-example-basic-single_cliente").select2();
});
</script>
&nbsp;
<br>
<tr>
<td>
<?php
if(isset($rs_c))
$rs_c->MoveFirst();
if(isset($rs_g))
$rs_g->MoveFirst();
?>
<div align="center">
<table width='100%' align="center">
	<tr >
		<td colspan="<?php print $rs_g->RecordCount()+1; ?>" align="left">
			Tipo de cliente:
			<select name="sel_tipo" id="sel_tipo" onchange="javascript:document.frm.submit();">
				<option value="0">---Seleccionar---</option>
				<option value="1" <?php if(isset($_POST['sel_tipo'])){if($_POST['sel_tipo']=='1'){; ?> selected="selected"<?php }} ?>>Trabajador</option>
				<option value="2" <?php if(isset($_POST['sel_tipo'])){if($_POST['sel_tipo']=='2'){; ?> selected="selected"<?php }} ?>>Estudiante</option>
				<option value="3" <?php if(isset($_POST['sel_tipo'])){if($_POST['sel_tipo']=='3'){; ?> selected="selected"<?php }} ?>>Externo</option>
			</select>
			&nbsp;
			
			Grupo de consumidores:
			<select name="sel_grupo" id="sel_grupo" onchange="javascript:document.frm.submit();">
				<option value="0">---Seleccionar---</option>
				<?php for($m=0;$m<$rs_g->RecordCount();$m++){ ?>
				
					<option value="<?php print $rs_g->fields['id_grupo_cliente']; ?>" <?php if(isset($_POST['sel_grupo'])){if($rs_g->fields['id_grupo_cliente']==$_POST['sel_grupo']){; ?> selected="selected"<?php }} ?> > <?php print $rs_g->fields['grupo_cliente']; ?> </option>
					
				<?php $rs_g->MoveNext();} ?>
			</select>
			
			&nbsp;
			<?php if(isset($_POST['sel_tipo'])){if($_POST['sel_tipo']==2){?>
			Paralelo:
			<select name="sel_paralelo" id="sel_paralelo" onchange="javascript:document.frm.submit();">
				<option value="0">---Seleccionar---</option>
				<?php for($g=0;$g<$rs_par->RecordCount();$g++){?>
				
					<option value="<?php print $rs_par->fields['id_grado_paralelo'];?>" <?php if(isset($_POST['sel_paralelo'])){if($rs_par->fields['id_grado_paralelo']==$_POST['sel_paralelo']){?> selected="selected"<?php }}?> > <?php print $rs_par->fields['abreviatura'];?> </option>
					
				<?php $rs_par->MoveNext();}$rs_par->MoveFirst();?>
			</select>
			<?php }}?>
		</td>
	</tr>
<?php
if(isset($_POST['sel_tipo']) AND isset($_POST['sel_grupo']))
{//print $_POST['sel_tipo'];
	if($_POST['sel_tipo']!=0 AND $_POST['sel_grupo']!=0)
	{
		if($_POST['sel_tipo']==1)
		{
			$sql="SELECT cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente, id_grupo_cliente
			FROM persona, cliente, empleado, grupos_clientes WHERE persona.id_persona=cliente.id_persona AND persona.id_persona=empleado.id_persona AND cliente.id_cliente=grupos_clientes.id_cliente ORDER BY primer_apellido";
		}
		elseif($_POST['sel_tipo']==2)
		{
			$sql="SELECT cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente, id_grupo_cliente
			FROM persona, cliente, estudiante, grupos_clientes WHERE persona.id_persona=cliente.id_persona AND persona.id_persona=estudiante.id_persona AND cliente.id_cliente=grupos_clientes.id_cliente ORDER BY primer_apellido";
		}
		elseif($_POST['sel_tipo']==3)
		{
			$sql="SELECT cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente, id_grupo_cliente
			FROM persona, cliente
			LEFT OUTER JOIN empleado ON empleado.id_persona=cliente.id_persona
			LEFT OUTER JOIN estudiante ON estudiante.id_persona=cliente.id_persona
			JOIN grupos_clientes ON grupos_clientes.id_cliente=cliente.id_cliente
			WHERE cliente.id_persona=persona.id_persona AND empleado.id_empleado IS NULL AND estudiante.id_estudiante IS NULL ORDER BY primer_apellido";//print $sql;
		}
		
		if(isset($sql))
		$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;
	

	
 ?>	
	
	<tr class="encabezado">
		<td align="left" width='50%'>
		Cliente: 
		
			<select class="js-example-basic-single_cliente" name="sel_cliente" id="sel_cliente" <?php if(isset($_POST['sel_cliente'])){if($_POST['sel_cliente']==0)print "autofocus='autofocus'";}else print "autofocus='autofocus'";?> onchange="javascript:document.frm.submit();">
				<option value="0">----------------------------Seleccionar----------------------------</option>
				<?php for($c=0;$c<$rs_c->RecordCount();$c++){?>
				
					<option value="<?php print $rs_c->fields['id_cliente'];?>" 
						<?php 
							if(isset($_POST['sel_cliente']))
							{
								if($rs_c->fields['id_cliente']==$_POST['sel_cliente'])
								{							 
									print 'selected="selected"';								 
								}
							}
							?>><?php
							print $rs_c->fields['cliente'];
						?> 
					</option>
					
				<?php $rs_c->MoveNext();}$rs_c->MoveFirst();?>
			</select>
		</td>
		
		<?php
		$rs_g->MoveFirst();
		for($f=0;$f<$rs_g->RecordCount();$f++)
		{
			if($rs_g->fields['id_grupo_cliente']==$_POST['sel_grupo'])
			{
		?>
		<td height="25" width='50%' align="center">
			<?php print $rs_g->fields['grupo_cliente']; ?>&nbsp;<input name='checkbox_<?php print $rs_g->fields['id_grupo_cliente']; ?>' onclick='marcar_p(<?php print $rs_g->fields['id_grupo_cliente']; ?>);' type='checkbox'/>
		</td>
		<?php
			}
		$rs_g->MoveNext();
		} 
		?>
	</tr>
	
	<?php 
	for($c=0;$c<$rs_c->RecordCount();$c++)
	{
		$rs_g->MoveFirst();
		if(isset($rs_c->fields['abreviatura']))
		{
			if($abrev!=$rs_c->fields['abreviatura'])
			{
				$abrev=$rs_c->fields['abreviatura'];
				$p=1;
	?>	
	
	
	<tr class="encabezado"><td align="center" colspan="2"><b><?php print $rs_c->fields['abreviatura'];?></b></td></tr>
	
	<?php }}print "<tr ";if($c % 2) print "class='row1'";else print "class='row0'";print " >";?>	
		<td align="left" width='50%' height="25">
			<a class='hlink' onmouseover="return overlib('<?php //print $rs_c->fields['descripcion']; ?>', ABOVE, RIGHT)" onmouseout='return nd();'>
				<?php if(!isset($p))$p=1;print $p .' - '.$rs_c->fields['cliente'];$p=$p+1;?>
			</a>
		</td>
		<?php
		$rs_g->MoveFirst();
		for($f=0;$f<$rs_g->RecordCount();$f++)
		{
			if($rs_g->fields['id_grupo_cliente']==$_POST['sel_grupo'])
			{
		?>
		<td width='50%' align="center">
			<?php		
			
			$rs->MoveFirst();
			for($ca=0;$ca<$rs->RecordCount();$ca++)
			{
				//print $rs_c->fields['id_cliente'].' - '.$rs->fields['id_cliente'].' - '.$rs_g->fields['id_forma_pago'].' - '.$rs->fields['id_forma_pago'];
				if(isset($rs_c->fields['id_cliente']) AND isset($rs->fields['id_cliente']) AND isset($rs_g->fields['id_grupo_cliente']) AND isset($rs->fields['id_grupo_cliente']))
				{
					if($rs_c->fields['id_cliente']==$rs->fields['id_cliente'] AND $rs_g->fields['id_grupo_cliente']==$rs->fields['id_grupo_cliente'])
					{$checked="checked";break;}
				}
				
			$rs->MoveNext();
			}
			 ?>
			
			<section>
				<div class="checkbox-2">
					<input class="checkbox_oculto" name='checkbox_<?php print $rs_c->fields['id_cliente'].$rs_g->fields['id_grupo_cliente']; ?>' <?php print $disable; ?> <?php print $checked; ?> type='checkbox' value='checkbox_<?php print $rs_c->fields['id_cliente'].$rs_g->fields['id_grupo_cliente'] ?>'type="checkbox" id="<?php print $rs_c->fields['id_cliente'].$rs_g->fields['id_grupo_cliente']; ?>" />
					<label for="<?php print $rs_c->fields['id_cliente'].$rs_g->fields['id_grupo_cliente']; ?>"><?php if($disable)print "X"; ?></label>
				</div>
			</section>
		</td>
		<?php
			// $cadenacheckboxp contiene los id del elemento
			if($cadenacheckboxp == ""){$cadenacheckboxp = $rs_c->fields['id_cliente'].$rs_g->fields['id_grupo_cliente'];}
			else{$cadenacheckboxp .= ",".$rs_c->fields['id_cliente'].$rs_g->fields['id_grupo_cliente'];}
			// $cadenacheckboxp contiene los id del elemento
		
			$rs_g->MoveNext();
			$checked="";
		
			}
		$rs_g->MoveNext();
		} 
		?>
	</tr>
	
<?php $rs_c->MoveNext();}
	}
}
 ?>
	
</table>
<div>
</td>
</tr>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
 ?>