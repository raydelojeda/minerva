<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}

$checked="";
$abrev="";
$hoy=date("Y-m-d");
$retirado='';

$sql_mod="select * from clase WHERE id_clase='".$mod."'";
$rs_mod=$db->Execute($sql_mod) or die($db->ErrorMsg());//print $rs_mod;

$sql_cli="SELECT estudiante.id_estudiante as id_estudiante, curso_grado_paralelo_est.id_curso_grado_paralelo_est, n_grado_paralelo.id_grado_paralelo, n_grado_paralelo.abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
FROM persona, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico 
WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
AND persona.id_persona=estudiante.id_persona 
AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' ";
if(isset($_POST['sel_paralelo'])){if($_POST['sel_paralelo']!=0){$sql_cli=$sql_cli." AND n_grado_paralelo.id_grado_paralelo='".$_POST['sel_paralelo']."'";}}
if(isset($_POST['sel_estudiante'])){if($_POST['sel_estudiante']!=0){$sql_cli=$sql_cli." AND estudiante.id_estudiante='".$_POST['sel_estudiante']."'";}}
$sql_cli=$sql_cli." ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";//print $sql_cli;
$rs_c=$db->Execute($sql_cli) or die($db->ErrorMsg());

$sql_p="select id_periodo_academico as id_periodo_academico, concat(n_periodo_academico.nombre,'  -  ',fecha_ini,'/',fecha_fin) as periodo_academico, activo from n_periodo_academico WHERE activo='1' ORDER BY fecha_ini";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$sql_a="SELECT id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) AS asignatura FROM n_asignatura";
$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());

$sql_pro="select id_empleado_academico, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as empleado_academico 
from empleado, persona, empleado_academico WHERE 1 AND persona.id_persona=empleado.id_persona AND empleado_academico.id_empleado=empleado.id_empleado ORDER BY primer_apellido, segundo_apellido, primer_nombre, segundo_nombre";
$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());

$sql_par="select DISTINCT n_grado_paralelo.id_grado_paralelo, abreviatura FROM n_paralelo, n_grado_paralelo, grado_paralelo_periodo, curso_grado_paralelo_est, n_periodo_academico 
where n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo 
AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' ORDER BY orden";
$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());

$sql="SELECT estudiante.id_estudiante as id_estudiante, n_grado_paralelo.id_grado_paralelo, clase_estudiante.retirado, clase_estudiante.fecha_salida, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
FROM persona, estudiante, curso_grado_paralelo_est, clase_estudiante, n_grado_paralelo, grado_paralelo_periodo, clase
WHERE persona.id_persona=estudiante.id_persona AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante 
AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
AND curso_grado_paralelo_est.id_curso_grado_paralelo_est=clase_estudiante.id_curso_grado_paralelo_est 
AND clase.id_clase=clase_estudiante.id_clase AND clase.id_clase='".$mod."'ORDER BY primer_apellido";
$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;

if(isset($_POST['aux_submit']))
{
	if($_POST['aux_submit']!='')
	{
		$u_sql="UPDATE clase SET nombre='".$_POST['txt_nombre']."', referencia='".$_POST['txt_referencia']."', codigo='".$_POST['txt_codigo']."', codigo_unico='".$_POST['txt_codigo_unico']."', 
		peso='".$_POST['txt_peso']."', id_asignatura='".$_POST['sel_asignatura']."', id_empleado_academico='".$_POST['sel_profesor']."', id_periodo_academico='".$_POST['sel_periodo']."' WHERE id_clase='".$mod."'";//print $u_sql."<br>";
		$db->Execute($u_sql) or die($db->ErrorMsg());
		
		for($c=0;$c<$rs_c->RecordCount();$c++)
		{
			$sql_est="select id_clase_estudiante, retirado from clase_estudiante WHERE id_curso_grado_paralelo_est='".$rs_c->fields['id_curso_grado_paralelo_est']."' AND id_clase='".$mod."'";
			$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());//print $rs_mod;
			
			if($abrev!=$rs_c->fields['abreviatura'])
			{
				$abrev=$rs_c->fields['abreviatura'];
				$cadena_sin_esp = $rs_c->fields['id_grado_paralelo'].$rs_c->fields['id_curso_grado_paralelo_est'];//print $cadena_sin_esp.'<br>';
			}
			
			if(isset($_POST["checkbox_".$rs_c->fields['id_estudiante'].$cadena_sin_esp]))
			{
			
			//print $_POST["checkbox_".$rs_c->fields['id_estudiante'].$cadena_sin_esp];
				if(!isset($rs_est->fields['id_clase_estudiante']))
				{
					$i_sql="INSERT INTO clase_estudiante(id_clase, id_curso_grado_paralelo_est, fecha_entrada, retirado) 
					VALUES ('".$mod."','".$rs_c->fields['id_curso_grado_paralelo_est']."', '".$hoy."', '0')";//print $i_sql.'<br>';
					$db->Execute($i_sql) or die($db->ErrorMsg());
				}
				elseif($rs_est->fields['retirado']=='1')
				{
					$u_sql="UPDATE clase_estudiante SET fecha_entrada='".$hoy."', fecha_salida='', retirado='0' WHERE id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $u_sql."<br>";
					$db->Execute($u_sql) or die($db->ErrorMsg());
				}
			}
			elseif(isset($rs_est->fields['id_clase_estudiante']))
			{
				$sql_nota="SELECT nota, observacion
				FROM nota_actividad_examen
				WHERE 1
				AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_act;//die();
				$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
				
				if(!isset($rs_nota->fields['nota']) AND !isset($rs_nota->fields['observacion']))
				{
					$d_sql="DELETE FROM clase_estudiante WHERE id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $d_sql.'<br>';
					$db->Execute($d_sql) or die($db->ErrorMsg());
				}
				else
				{
					$u_sql="UPDATE clase_estudiante SET fecha_salida='".$hoy."', retirado='1' WHERE id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $u_sql."<br>";
					$db->Execute($u_sql) or die($db->ErrorMsg());
				}
			}
		$rs_c->MoveNext();
		}
	$mensaje='Datos guardados correctamente';	
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../".$elemento."/lis_".$elemento.".php?mensaje=Datos guardados correctamente'</script>");
	}
}



?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<script type="text/javascript" class="js-code-basic">
$(document).ready(function() {
$(".js-basic-single_asig").select2();
$(".js-basic-single_pro").select2();
$(".sel_paralelo").select2();
$(".sel_estudiante").select2();
});
</script>
&nbsp;
<br>
<tr>
<td>
<div align="center">
<table align="center" width='100%'>
	<tr>
		<td  align="center">
			
			<table align="center" width='100%'>
				<tr>
					<td align="right">
						Per&iacute;odo acad&eacute;mico:
					</td>
					<td align="left">
						<select name="sel_periodo" id="sel_periodo">
							<?php $rs_p->MoveFirst();for($p=0;$p<$rs_p->RecordCount();$p++){ ?>				
								<option value="<?php print $rs_p->fields['id_periodo_academico']; ?>" <?php if($rs_p->fields['id_periodo_academico']==$rs_mod->fields['id_periodo_academico']){; ?> selected="selected"<?php } ?> <?php if(isset($_POST['sel_periodo'])){if($rs_p->fields['id_periodo_academico']==$_POST['sel_periodo'] OR $rs_p->fields['activo']=='1'){; ?> selected="selected"<?php }} ?> > <?php print $rs_p->fields['periodo_academico']; ?> </option>
							<?php $rs_p->MoveNext();} ?>
						</select>&nbsp;*
					</td>
				</tr>
				
				<tr>
					<td align="right">	
						Asignatura:
					</td>
					<td align="left">
						<select name="sel_asignatura" class="js-basic-single_asig" title="Asignatura" id="sel_asignatura">
							<option value="">---Seleccionar---</option>
							<?php $rs_a->MoveFirst();for($a=0;$a<$rs_a->RecordCount();$a++){ ?>				
								<option value="<?php print $rs_a->fields['id_asignatura']; ?>" <?php if($rs_a->fields['id_asignatura']==$rs_mod->fields['id_asignatura']){; ?> selected="selected"<?php } ?> <?php if(isset($_POST['sel_asignatura'])){if($rs_a->fields['id_asignatura']==$_POST['sel_asignatura'] OR $rs_a->fields['id_asignatura']==$rs_mod->fields['id_asignatura']){; ?> selected="selected"<?php }} ?> > <?php print $rs_a->fields['asignatura']; ?> </option>
							<?php $rs_a->MoveNext();} ?>
						</select>&nbsp;*
					</td>
				</tr>
				
				<tr>
					<td align="right">	
						Profesor:
					</td>
					<td align="left">
						<select name="sel_profesor" class="js-basic-single_pro" title="Profesor" id="sel_profesor">
							<option value="">---Seleccionar---</option>
							<?php $rs_pro->MoveFirst();for($pro=0;$pro<$rs_pro->RecordCount();$pro++){ ?>
								<option value="<?php print $rs_pro->fields['id_empleado_academico']; ?>" <?php if($rs_pro->fields['id_empleado_academico']==$rs_mod->fields['id_empleado_academico']){; ?> selected="selected"<?php } ?> <?php if(isset($_POST['sel_profesor'])){if($rs_pro->fields['id_empleado_academico']==$_POST['sel_profesor']){; ?> selected="selected"<?php }} ?> > <?php print $rs_pro->fields['empleado_academico']; ?> </option>
							<?php $rs_pro->MoveNext();} ?>
						</select>&nbsp;*
					</td>
				</tr>
				
				<tr>
					<td align="right">
						Nombre:
					</td>
					<td align="left">
						<input id="txt_nombre" size="30" type="text" title="Nombre de la clase" name="txt_nombre" placeholder='ejem.: HISTORY 1RO BACH-C' value='<?php print $rs_mod->fields['nombre'];?>'>&nbsp;*
						<?php $msg='Ingrese el nombre de la clase.<br>(ejem.: HISTORY 1RO BACH-C)<br>(ejem.: MATEMATICA 3RO EGB-A)';?>
						<a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
					</td>
				</tr>
				
				<tr>
					<td align="right">	
						Referencia:
					</td>
					<td align="left">
						<input id="txt_referencia" size="70" type="text" title="Referencia de la clase" name="txt_referencia" placeholder='(ejem.: BACHILLERATO, PRIMER CURSO 1BGU-C, HISTORY)' value='<?php print $rs_mod->fields['referencia'];?>'>&nbsp;*
						<?php $msg='Ingrese un identificador para la clase, puede usar la uni&oacute;n de la secci&oacute;n acad&eacute;mica, el curso, paralelo y la clase. (ejem.: BACHILLERATO, PRIMER CURSO 1BGU-C, HISTORY)';?>
						<a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
					</td>
				</tr>
				
				<tr>
					<td align="right">
						C&oacute;digo:
					</td>
					<td align="left">
						<input id="txt_codigo" size="30" type="text" title="C&oacute;digo de la clase" name="txt_codigo" placeholder='(ejem.: BACH-1BGU-C-HIS)' value='<?php print $rs_mod->fields['codigo'];?>'>&nbsp;*
						<?php $msg='El C&oacute;digo es una representaci&oacute;n de la Referencia. Debe ser &uacute;nico.(ejem.: 1BGU-C-INGLES)';?>
						<a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
					</td>
				</tr>
				
				<tr>
					<td align="right">	
						C&oacute;digo agrupador:
					</td>
					<td align="left">
						<input id="txt_codigo_unico" size="30" type="text" title="C&oacute;digo &uacute;nico de la clase" name="txt_codigo_unico" placeholder='(ejem.: 1BGU-C-INGLES)' value='<?php print $rs_mod->fields['codigo_unico'];?>'>&nbsp;*
						<?php $msg='El C&oacute;digo agrupador se utiliza para agrupar a 2 o m&aacute;s clases que se reportan a una misma asignatura(Ingl&eacute;s con English, History y Natural Science).(ejem.: 1BGU-C-INGLES)';?>
						<a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
					</td>
				</tr>
				
				<tr>
					<td align="right">
						Peso:
					</td>
					<td align="left">
						<input id="txt_peso" size="10" type="text" title="Peso de la clase dentro de la asignatura" name="txt_peso" value='<?php print $rs_mod->fields['peso'];?>'>&nbsp;*
						<?php $msg='Ingrese el peso que esta clase tiene dentro de la asignatura. Si hay 2 o m&aacute;s clases que se reportan a una misma asignatura, se usar&aacute; este valor para hacer un promedio ponderado.(ejem.: Ingl&eacute;s con English, History y Natural Science)';?>
						<a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
					</td>
				</tr>
			</table>
			
			(*) Requerido
			
			<br><br>
			<fieldset>
			<legend>Estudiantes</legend>			
				<fieldset>
				<legend>Filtros</legend>
					<table align="center" width='100%'class="tabla_filtro">
						<tr>
							<td align="right" width='25%'>
								Paralelo:
							</td>
							<td align="left" width='25%'>
								<select name="sel_paralelo" class="sel_paralelo" id="sel_paralelo" onchange="javascript:document.frm.submit();">
									<option value="0">---Seleccionar---</option>
									<?php for($g=0;$g<$rs_par->RecordCount();$g++){?>
										<option value="<?php print $rs_par->fields['id_grado_paralelo'];?>" <?php if(isset($_POST['sel_paralelo'])){if($rs_par->fields['id_grado_paralelo']==$_POST['sel_paralelo']){?> selected="selected"<?php }}?> > <?php print $rs_par->fields['abreviatura'];?> </option>
									<?php $rs_par->MoveNext();}$rs_par->MoveFirst();?>
								</select>
							</td>
							<td align="right" width='10%'>
								Cliente:
							</td>
							<td align="left" width='40%'>
								<select class="sel_estudiante" name="sel_estudiante" id="sel_estudiante" <?php if(isset($_POST['sel_estudiante'])){if($_POST['sel_estudiante']==0)print "autofocus='autofocus'";}else print "autofocus='autofocus'";?> onchange="javascript:document.frm.submit();">
									<option value="0">----------------------------Seleccionar----------------------------</option>
									<?php for($c=0;$c<$rs_c->RecordCount();$c++){?>
									
										<option value="<?php print $rs_c->fields['id_estudiante'];?>" 
											<?php 
												if(isset($_POST['sel_estudiante']))
												{
													if($rs_c->fields['id_estudiante']==$_POST['sel_estudiante'])
													{							 
														print 'selected="selected"';								 
													}
												}
												?>><?php
												print $rs_c->fields['estudiante'];
											?> 
										</option>
										
									<?php $rs_c->MoveNext();}$rs_c->MoveFirst();?>
								</select>		
							</td>
						</tr>
					</table>
				</fieldset>
				
				<br>
				
				<table align="center" width='100%'class="tabla_filtro">
				
				<?php
				$rs_c->MoveFirst();
				for($c=0;$c<$rs_c->RecordCount();$c++)
				{

					if(isset($rs_c->fields['abreviatura']))
					{
						if($abrev!=$rs_c->fields['abreviatura'])
						{
							$abrev=$rs_c->fields['abreviatura'];
							$cadena_sin_esp = $rs_c->fields['id_grado_paralelo'].$rs_c->fields['id_curso_grado_paralelo_est'];
							$p=1;
				?>	
				
					<tr class="encabezado">
						<td align="center">
							<b><?php print $rs_c->fields['abreviatura'];?></b>
						</td>
						<td align="center">
							<input name='checkbox_<?php print $cadena_sin_esp; ?>' onclick='marcar_p(<?php print $cadena_sin_esp; ?>);' type='checkbox'/>  Insertar/Eliminar estudiante de la clase
						</td>
						<td align="center">
						<?php $msg='Al eliminar un estudiante de la clase, si este tiene notas en la misma no se eliminar&aacute;, se dar&aacute; de baja o mantendr&aacute; inactivo.';?>
							Dado baja de la clase  <a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
						</td>
					</tr>
				
					<?php }}
					//$cadena_sin_esp = $rs_c->fields['id_grado_paralelo'].$rs_c->fields['id_curso_grado_paralelo_est'];
					print "<tr ";if($c % 2) print "class='row1'";else print "class='row0'";print " >";?>		
						<td align="left" width='40%' height="25">
							<a class='hlink' onmouseover="return overlib('<?php //print $rs_c->fields['descripcion']; ?>', ABOVE, RIGHT)" onmouseout='return nd();'>
								<?php if(!isset($p))$p=1;print $p .' - '.$rs_c->fields['estudiante'];$p=$p+1;?>
							</a>
						</td>
						
						
						<td height="25" align="center">
							<?php		
							
							$rs->MoveFirst();
							for($ca=0;$ca<$rs->RecordCount();$ca++)
							{
							
								if(isset($rs_c->fields['id_estudiante']) AND isset($rs->fields['id_estudiante']))
								{
									if($rs_c->fields['id_estudiante']==$rs->fields['id_estudiante'])
									{$retirado=$rs->fields['retirado'];}
									
									if($rs_c->fields['id_estudiante']==$rs->fields['id_estudiante'] AND $rs->fields['retirado']=='0')
									{$checked="checked";break;}
								}
								
								if(isset($_POST["checkbox_".$rs_c->fields['id_estudiante'].$cadena_sin_esp]))
								{$checked="checked";break;}
								
							$rs->MoveNext();
							}
							 ?>
							
							<section>
								<div class="checkbox-2">
									<input class="checkbox_oculto" name='checkbox_<?php print $rs_c->fields['id_estudiante'].$cadena_sin_esp; ?>'<?php print $checked; ?> type='checkbox' value='1' id="<?php print $rs_c->fields['id_estudiante'].$cadena_sin_esp;?>" />
									<label for="<?php print $rs_c->fields['id_estudiante'].$cadena_sin_esp;?>"></label>
									<br><?php //print $rs_c->fields['id_estudiante'].$cadena_sin_esp;?>
								</div>
							</section>
						</td>
						<td align="center">
							<?php if($retirado=='1')print '<img width="15px" src="../../../img/general/ok.png">';$retirado='';?>
						</td>
						<?php
							// $cadenacheckboxp contiene los id del elemento
							if($cadenacheckboxp == ""){$cadenacheckboxp = $rs_c->fields['id_estudiante'].$cadena_sin_esp;}
							else{$cadenacheckboxp .= ",".$rs_c->fields['id_estudiante'].$cadena_sin_esp;}
							// $cadenacheckboxp contiene los id del elemento
						

							$checked="";

						 ?>
					</tr>
				
		
		
		
	<?php
		$rs_c->MoveNext();
		}
	?>
				</table>
			</fieldset>

		</td>
	</tr>
</table>
<div>
</td>
</tr>

<?php 



if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>
<input type="hidden" name="var_checkbox" value="<?php echo $cadenacheckboxp;?>">
<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>