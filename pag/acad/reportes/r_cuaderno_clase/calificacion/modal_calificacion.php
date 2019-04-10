<link type="text/css" rel="stylesheet" href='<?php print "../../../../css/claro.css";?>'>
<?php
$x='../../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']) && isset($_POST['campo1']) && isset($_POST['campo2']))
{	
	$promedio_abv=array();$abv_ant='';$suma_nota=0;$cant_nota=0;$h=0;
	$id_estudiante=$_POST['campo0'];
	$id_clase=$_POST['campo1'];
	$id_subperiodo_evaluativo=$_POST['campo2'];
	
	$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
	$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
	
	$nota_minima=$rs_nota->fields['nota_minima'];
	$nota_aprobado=$rs_nota->fields['nota_aprobado'];
	$nota_maxima=$rs_nota->fields['nota_maxima'];
	
	$sql_abv="SELECT DISTINCT abv_tipo_actividad_examen, tipo_actividad_examen, n_tipo_actividad.peso
	FROM n_tipo_actividad, n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
	WHERE 1
	AND n_tipo_actividad.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
	AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
	AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
	AND n_conf_academica.id_conf_academica=n_periodo_lectivo.id_conf_academica
	AND n_conf_academica.id_conf_academica='1'
	AND n_tipo_actividad.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'
	ORDER BY n_tipo_actividad.orden";//print $sql_abv;
	$rs_abv=$db->Execute($sql_abv) or die($db->ErrorMsg());
	
	$sql_act="SELECT actividad.id_actividad, actividad.actividad_examen, actividad.fecha, abv_tipo_actividad_examen, tipo_actividad_examen, abv_subperiodo, subperiodo_evaluativo, nota, observacion
	FROM clase, actividad, n_periodo_academico , n_tipo_actividad, n_subperiodo_evaluativo, clase_estudiante, curso_grado_paralelo_est, nota_actividad_examen
	WHERE 1
	AND n_tipo_actividad.id_tipo_actividad=actividad.id_tipo_actividad
	AND actividad.id_clase=clase.id_clase
	AND clase_estudiante.id_clase=clase.id_clase
	AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
	AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
	AND nota_actividad_examen.id_actividad=actividad.id_actividad
	AND nota_actividad_examen.id_clase_estudiante=clase_estudiante.id_clase_estudiante
	AND n_tipo_actividad.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
	AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."' 
	AND id_estudiante='".$id_estudiante."'
	AND n_tipo_actividad.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' 
	ORDER BY n_tipo_actividad.orden, actividad.fecha, actividad.id_actividad";//print $sql_act;//die();
	$rs_act=$db->Execute($sql_act) or die($db->ErrorMsg());
	
	$sql_tipo_act="SELECT abv_tipo_actividad_examen, tipo_actividad_examen, AVG(nota) AS nota
	FROM clase, actividad, n_periodo_academico , n_tipo_actividad, n_subperiodo_evaluativo, clase_estudiante, curso_grado_paralelo_est, nota_actividad_examen
	WHERE 1
	AND n_tipo_actividad.id_tipo_actividad=actividad.id_tipo_actividad
	AND actividad.id_clase=clase.id_clase
	AND clase_estudiante.id_clase=clase.id_clase
	AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
	AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
	AND nota_actividad_examen.id_actividad=actividad.id_actividad
	AND nota_actividad_examen.id_clase_estudiante=clase_estudiante.id_clase_estudiante
	AND n_tipo_actividad.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
	AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."' 
	AND id_estudiante='".$id_estudiante."'
	AND n_tipo_actividad.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'
	GROUP BY abv_tipo_actividad_examen
	ORDER BY n_tipo_actividad.orden, actividad.fecha, actividad.id_actividad";//die();
	$rs_tipo_act=$db->Execute($sql_tipo_act) or die($db->ErrorMsg());
?>						
	
	<div class="modalbox movedown_mas_arriba">
		<br><?php //print $sql_act;?>
		<table class="encabezado" cellpadding="0">
			<tr>
				<td>
					<table class="menubar mini_menubar" id="toolbar">		
						<tr class='tabla_listar'>
							<td class="titulo_encabezado">Detalle de calificaciones del <?php print $rs_act->fields['subperiodo_evaluativo'].' ('.$rs_act->fields['abv_subperiodo'].')';?></td>
							
							<td class="botonera_encabezado" style='text-align:center;'>
								<div>
									<a class="toolbar" target="_self" href="#close">
										<img src="../../../../img/general/cerrar_mini.png" alt="Salir" name="cancelar" width="16" height="16" border="0" id="cancelar"/><br/>Salir
									</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<br>
		
		<fieldset>
			<legend>Tipos de actividades y sus pesos</legend>
			
			<div style='display:table;width:100%;' >
				<div style='display:table-row;'>
					<div style='display:table-cell;width:100%;height:14px;text-align:left;'>
						<?php
						//print $sql_tipo_act;
							$rs_abv->MoveFirst();
							for($e=0;$e<$rs_abv->RecordCount();$e++)
							{
								print '<b>'.$rs_abv->fields['abv_tipo_actividad_examen'].': </b>'.$rs_abv->fields['tipo_actividad_examen'].' ('.$rs_abv->fields['peso'].'%)'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';			
							$rs_abv->MoveNext();
							}
						?>
					</div>	
				</div>
			</div>
		</fieldset>
		
		<br>
		
		<fieldset>
			<legend>Promedio por tipos de actividades</legend>
			
			<div style='display:table;width:100%;' >
				<div style='display:table-row;vertical-align:middle;'>
					<div style='display:table-cell;width:100%;height:12px;text-align:left;'>
						<?php
						//print $sql_tipo_act;
							$rs_tipo_act->MoveFirst();
							for($e=0;$e<$rs_tipo_act->RecordCount();$e++)
							{
								print '<b>'.$rs_tipo_act->fields['tipo_actividad_examen'].' </b>'.': ';
								
								if($rs_tipo_act->fields['nota']<$nota_aprobado)
								print '<a style="color:red;">';
								
								print number_format(round($rs_tipo_act->fields['nota'], 2), 2, ".", "").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
								
								if($rs_tipo_act->fields['nota']<$nota_aprobado)
								print '</a>';
								
							$rs_tipo_act->MoveNext();
							}
						?>
					</div>	
				</div>
			</div>
		</fieldset>
		
		<br>
		
		<table class="" width='100%' border='0'>
			<tr>
				<td class="">
				
					<div class='tabla_listar' style='display:table;width:100%;'>
					
						<div class="encabezado_col" style='display:table-row;height:22px;'>
							<div style='display:table-cell;width:2%;text-align:left;padding-left:1%;vertical-align:middle;'>
								No
							</div>
							
							<div style='display:table-cell;width:3%;text-align:center;padding-left:1%;vertical-align:middle;'>
								
							</div>
							
							<div style='display:table-cell;width:40%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Actividad o ex&aacute;men
							</div>
							
							<div style='display:table-cell;width:12%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Fecha
							</div>
							
							<div style='display:table-cell;width:5%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Nota
							</div>
							
							<div style='display:table-cell;width:40%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Observaci&oacute;n
							</div>
						</div>
					
					<?php $rs_act->MoveFirst();for($i=0;$i<$rs_act->RecordCount();$i++){?>
					
						<div <?php if($i % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $i+1;?>
							</div>
							
							<div style='display:table-cell;text-align:center;padding-left:1%;vertical-align:middle;'>
								<?php print $rs_act->fields['abv_tipo_actividad_examen'];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $rs_act->fields['actividad_examen'];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $rs_act->fields['fecha'];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;<?php if($rs_act->fields['nota']<$nota_aprobado) print "color:red;";?>'>
								<?php print number_format(round($rs_act->fields['nota'], 2), 2, ".", "");?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php if($rs_act->fields['observacion']!='')print $rs_act->fields['observacion'];else print 'No hay observaci&oacute;n';?>
							</div>
						</div>

					<?php $rs_act->MoveNext();}?>
						
					</div>
				</td>
			</tr>
		</table>
		
	</div>
<?php	
}
?>