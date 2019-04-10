<link type="text/css" rel="stylesheet" href='<?php print "../../../../css/claro.css";?>'>
<?php
$x='../../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']) && isset($_POST['campo1']) && isset($_POST['campo2']))
{	
	$id_estudiante=$_POST['campo0'];
	$id_clase=$_POST['campo1'];
	$id_sub_eval=$_POST['campo2'];
	
	$sql_ina="SELECT clase.nombre, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre) as estudiante,
	clase_inasistencia.id_clase_inasistencia, fecha, tema_impartir, inasistencia, observacion, inasistencia_inspector, observacion_inspector
	FROM clase_inasistencia, inasistencia_clase, clase_estudiante, curso_grado_paralelo_est, clase, n_periodo_academico, estudiante, persona
	WHERE 1	
	AND n_periodo_academico.id_periodo_academico=clase.id_periodo_academico
	AND clase_estudiante.id_clase=clase.id_clase
	AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
	AND inasistencia_clase.id_clase_estudiante=clase_estudiante.id_clase_estudiante
	AND clase_inasistencia.id_clase_inasistencia=inasistencia_clase.id_clase_inasistencia
	AND estudiante.id_persona=persona.id_persona
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
	AND id_subperiodo_evaluativo='".$id_sub_eval."' 
	AND clase_inasistencia.id_clase='".$id_clase."' 
	AND estudiante.id_estudiante='".$id_estudiante."' 
	AND n_periodo_academico.activo='1' ORDER BY fecha";//print $sql_ina;//die();
	$rs_ina=$db->Execute($sql_ina) or die($db->ErrorMsg());
	
	$estudiante=$rs_ina->fields['estudiante'];
	$clase=$rs_ina->fields['nombre'];
	
	$inasistencia=$rs_ina->fields['inasistencia'];
	$inasistencia_inspector=$rs_ina->fields['inasistencia_inspector'];
	$observacion=$rs_ina->fields['observacion'];
	$observacion_inspector=$rs_ina->fields['observacion_inspector'];
?>						
	
	<div class="modalbox movedown">
		<br>
		<table class="encabezado" cellpadding="0">
			<tr>
				<td>
					<table class="menubar mini_menubar" id="toolbar">		
						<tr class='tabla_listar'>
							<td class="titulo_encabezado">Detalle de asistencia de <?php print $estudiante;?> en la clase <?php print $clase;?> </td>
							
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
			<legend>Estado de la asistencia</legend>
			
			<div style='display:table;width:100%;'>
				<div style='display:table-row;'>
					<div style='display:table-cell;width:100%;height:14px;text-align:left;padding-left:1%;'>
						<?php
							$leyenda='<img width=13px src="../../../../img/acad/asistencia/atraso.png">&nbsp;Atraso&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							$leyenda=$leyenda.'<img width=13px src="../../../../img/acad/asistencia/tarjeta_amarilla.png">&nbsp;Ausencia justificada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							$leyenda=$leyenda.'<img width=13px src="../../../../img/acad/asistencia/tarjeta_roja.png">&nbsp;Ausencia injustificada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							$leyenda=$leyenda.'(*)&nbsp;Ausencia modificada por el inspector.';						
							print $leyenda;	
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
							
							<div style='display:table-cell;width:10%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Fecha
							</div>
							
							<div style='display:table-cell;width:37%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Tema impartido
							</div>
							
							<div style='display:table-cell;width:48%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Observaci&oacute;n
							</div>
						</div>
					
					<?php $rs_ina->MoveFirst();
					for($i=0;$i<$rs_ina->RecordCount();$i++)
					{
						$inasistencia=$rs_ina->fields['inasistencia'];
						$inasistencia_inspector=$rs_ina->fields['inasistencia_inspector'];
						$observacion=$rs_ina->fields['observacion'];
						$observacion_inspector=$rs_ina->fields['observacion_inspector'];
							
						if($inasistencia==1 OR $inasistencia==2 OR $inasistencia==3 OR $inasistencia_inspector==1 OR $inasistencia_inspector==2 OR $inasistencia_inspector==3)
						{
											
					?>
					
						<div <?php if($i % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;width:2%;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $i+1;?>
							</div>
							
							<div style='display:table-cell;width:3%;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php 
									if($inasistencia==1 AND $inasistencia_inspector==99)$img='<img width=13px src="../../../../img/acad/asistencia/atraso.png">';
									if($inasistencia==2 AND $inasistencia_inspector==99)$img='<img width=13px src="../../../../img/acad/asistencia/tarjeta_amarilla.png">';
									if($inasistencia==3 AND $inasistencia_inspector==99)$img='<img width=13px src="../../../../img/acad/asistencia/tarjeta_roja.png">';
									
									if($inasistencia_inspector!=99)
									{
										if($inasistencia_inspector==1)$img='<img width=13px src="../../../../img/acad/asistencia/atraso.png">*';
										if($inasistencia_inspector==2)$img='<img width=13px src="../../../../img/acad/asistencia/tarjeta_amarilla.png">*';
										if($inasistencia_inspector==3)$img='<img width=13px src="../../../../img/acad/asistencia/tarjeta_roja.png">*';
									}
									
									print $img;
								?>
							</div>
							
							<div style='display:table-cell;width:10%;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $rs_ina->fields['fecha'];?>
							</div>
							
							<div style='display:table-cell;width:37%;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $rs_ina->fields['tema_impartir'];?>
							</div>
							
							<div style='display:table-cell;width:48%;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php 
									if($inasistencia_inspector==99)
									{if($observacion!='')print $observacion;else print 'No hay observaci&oacute;n';}
									else
									{if($observacion_inspector!='')print $observacion_inspector;else print 'No hay observaci&oacute;n';}
								?>
							</div>
						</div>

					<?php }$rs_ina->MoveNext();}?>
						
					</div>
				</td>
			</tr>
		</table>
	</div>
<?php	
}
?>