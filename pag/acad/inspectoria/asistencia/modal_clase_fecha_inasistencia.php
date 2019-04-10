<script type="text/javascript">
function cambiar_asistencia_insp(id_imagen)
{
	if (document.getElementById)
	{	
		imagen0=new Image
		imagen0.src="../../../img/acad/asistencia/recargar.png";
		imagen1=new Image
		imagen1.src="../../../img/acad/asistencia/ok.png";
		imagen2=new Image
		imagen2.src="../../../img/acad/asistencia/atraso.png";
		imagen3=new Image
		imagen3.src="../../../img/acad/asistencia/tarjeta_amarilla.png";
		imagen4=new Image
		imagen4.src="../../../img/acad/asistencia/tarjeta_roja.png";

		if(document.images[id_imagen].src == imagen0.src)
		{
			document.images[id_imagen].src = imagen1.src;
			obj = document.getElementById('obs_insp_'+id_imagen);
			obj.style.display ='block';
		}
		else if(document.images[id_imagen].src == imagen1.src)
		{
			document.images[id_imagen].src = imagen2.src;			
		}
		else if(document.images[id_imagen].src == imagen2.src)
		{
			document.images[id_imagen].src = imagen3.src;
		}
		else if(document.images[id_imagen].src == imagen3.src)
		{
			document.images[id_imagen].src = imagen4.src;
		}
		else 
		{
			document.images[id_imagen].src = imagen1.src;
		}
		ejecutar_ajax('asistencia/guardar_inasistencia.php','hdn_celda_'+id_imagen,'')
	}
}

function guardar_inasistencia_obs(id, obs)
{
	ejecutar_ajax('asistencia/guardar_inasistencia_obs.php','hdn_celda_'+id+', obs_insp_'+id,'')
}
</script>
<?php
$x='../../../../';
include($x."pag/acad/clase_inasistencia/variables_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$campos=explode("_",$_POST['campo0']);
	$id_grado=$campos[0];
	$id_paralelo=$campos[1];
	$id_clase=$campos[2];
	$anno=$campos[3];
	$mes=$campos[4];
	$dia=$campos[5];
	$fecha=$anno.'-'.$mes.'-'.$dia;
	
	$id_curso_grado_paralelo_est=$_POST['campo1'];
	
	$id_grado=$_POST['campo2'];
	$id_paralelo=$_POST['campo3'];
	$id_gra_par=$id_grado.'_'.$id_paralelo;
	
	$sql_est="SELECT clase.nombre, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre) as estudiante, clase_estudiante.id_clase_estudiante
	FROM  curso_grado_paralelo_est, clase, n_periodo_academico, estudiante, persona, clase_estudiante
	WHERE 1	
	AND n_periodo_academico.id_periodo_academico=clase.id_periodo_academico
	AND clase_estudiante.id_clase=clase.id_clase
	AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
	AND estudiante.id_persona=persona.id_persona
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
	AND clase.id_clase='".$id_clase."' 
	AND curso_grado_paralelo_est.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' 
	AND n_periodo_academico.activo='1'";//print $sql_est;die();
	$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
	
	$estudiante=$rs_est->fields['estudiante'];
	$clase=$rs_est->fields['nombre'];
	
	$sql_horas_clase="SELECT clase_inasistencia.id_clase_inasistencia, fecha, tema_impartir
	FROM clase_inasistencia WHERE 1 
	AND clase_inasistencia.fecha='".$fecha."' 
	AND clase_inasistencia.id_clase='".$id_clase."' ORDER BY fecha";//print $sql_horas_clase;//die();
	$rs_horas_clase=$db->Execute($sql_horas_clase) or die($db->ErrorMsg());
	
	for($i=0;$i<$rs_horas_clase->RecordCount();$i++)
	{
		$id=$rs_est->fields['id_clase_estudiante'].'_'.$rs_horas_clase->fields['id_clase_inasistencia'];//print 'iddddddddd: '.$id;
		
		?>
			<input name="hdn_celda_<?php print $id;?>" id="hdn_celda_<?php print $id;?>" type="hidden" value="<?php print $id;?>"/>
		<?php
		$prof_fecha[$i]=$fecha;
		$prof_tema[$i]=$rs_horas_clase->fields['tema_impartir'];
		$prof_img[$i]='<img width=13px src="../../../img/acad/asistencia/ok.png">';
		$prof_obs[$i]='No hay observaci&oacute;n';		
		
		$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/recargar.png"></a>';
		$insp_obs[$i]='No hay observaci&oacute;n';
		
		$sql_ina="SELECT clase_inasistencia.id_clase_inasistencia, fecha, tema_impartir, inasistencia, observacion, inasistencia_inspector, 
		observacion_inspector
		FROM clase_inasistencia, inasistencia_clase, clase_estudiante, curso_grado_paralelo_est, clase, n_periodo_academico
		WHERE 1	
		AND n_periodo_academico.id_periodo_academico=clase.id_periodo_academico
		AND clase_estudiante.id_clase=clase.id_clase
		AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
		AND inasistencia_clase.id_clase_estudiante=clase_estudiante.id_clase_estudiante
		AND clase_inasistencia.id_clase_inasistencia=inasistencia_clase.id_clase_inasistencia
		AND clase_inasistencia.id_clase_inasistencia='".$rs_horas_clase->fields['id_clase_inasistencia']."'
		AND fecha='".$fecha."' 
		AND clase_inasistencia.id_clase='".$id_clase."' 
		AND curso_grado_paralelo_est.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' 
		AND n_periodo_academico.activo='1' ORDER BY fecha";//print "<br><br><br> ".$sql_ina;//die();
		$rs_ina=$db->Execute($sql_ina) or die($db->ErrorMsg());
		
		if(isset($rs_ina->fields['inasistencia']))
		{
			if($rs_ina->fields['inasistencia']==1){$prof_img[$i]='<img width=13px src="../../../img/acad/asistencia/atraso.png">';$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/recargar.png"></a>';}
			if($rs_ina->fields['inasistencia']==2){$prof_img[$i]='<img width=13px src="../../../img/acad/asistencia/tarjeta_amarilla.png">';$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/recargar.png"></a>';}
			if($rs_ina->fields['inasistencia']==3){$prof_img[$i]='<img width=13px src="../../../img/acad/asistencia/tarjeta_roja.png">';$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/recargar.png"></a>';}
		
			if($rs_ina->fields['observacion']!='')$prof_obs[$i]=$rs_ina->fields['observacion'];
			
			if($rs_ina->fields['inasistencia_inspector']==0)$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png"></a>';
			if($rs_ina->fields['inasistencia_inspector']==1)$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/atraso.png"></a>';
			if($rs_ina->fields['inasistencia_inspector']==2)$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_amarilla.png"></a>';
			if($rs_ina->fields['inasistencia_inspector']==3)$insp_img[$i]='<a onclick="cambiar_asistencia_insp(\''.$id.'\')"><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_roja.png"></a>';
		
			if($rs_ina->fields['observacion_inspector']!='')$insp_obs[$i]=$rs_ina->fields['observacion_inspector'];else $insp_obs[$i]='No hay observaci&oacute;n';
			if($rs_ina->fields['inasistencia_inspector']!='99')$existe_inasistencia[$i]=1;
		}	
	
	$rs_horas_clase->MoveNext();
	}	
?>
<div class="modalbox movedown">
		<br>
		<table class="encabezado" cellpadding="0">
			<tr>
				<td>
					<table class="menubar mini_menubar" id="toolbar">		
						<tr class='tabla_listar'>
							<td class="titulo_encabezado">Detalle de asistencia de <?php print $estudiante;?>, en la clase <?php print $clase;?> y fecha <?php print $fecha;?></td>
							
							<td class="botonera_encabezado" style='text-align:center;'>
								<div>
									<a class="toolbar" target="_self" href="#close" onClick="ejecutar_ajax('asistencia/filtrar_est_grado_paralelo.php','sel_estudiante_<?php print $id_gra_par;?>, hdn_id_gra_<?php print $id_grado;?>, hdn_id_par_<?php print $id_gra_par;?>, txt_fecha_<?php print $id_gra_par;?>', 'contenido_grid_asistencias_<?php print $id_gra_par;?>');">
										<img src="../../../img/general/cerrar_mini.png" alt="Salir" name="cancelar" width="16" height="16" border="0" id="cancelar"/><br/>Salir
									</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<br>
		
		<table class="" width='100%' border='0'>
			<tr>
				<td class="">
				
					<div class='tabla_listar' style='display:table;width:100%;'>
					
						<div class="encabezado_col" style='display:table-row;height:22px;'>
							<div style='display:table-cell;width:2%;text-align:left;padding-left:1%;vertical-align:middle;'>
								No
							</div>							
				
							<div style='display:table-cell;width:7%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Fecha
							</div>
							
							<div style='display:table-cell;width:15%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Tema impartido
							</div>
							
							<div style='display:table-cell;width:2%;text-align:center;padding-left:1%;vertical-align:middle;'>
								
							</div>
							
							<div style='display:table-cell;width:20%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Observaci&oacute;n del docente
							</div>
							
							<div style='display:table-cell;width:2%;text-align:center;padding-left:1%;vertical-align:middle;'>
								
							</div>
							
							<div style='display:table-cell;width:20%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Observaci&oacute;n del inspector
							</div>
						</div>
					
					<?php 
					$rs_horas_clase->MoveFirst();for($i=0;$i<$rs_horas_clase->RecordCount();$i++){
					$id=$rs_est->fields['id_clase_estudiante'].'_'.$rs_horas_clase->fields['id_clase_inasistencia'];
					?>
					
						<div <?php if($i % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;width:2%;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $i+1;?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $prof_fecha[$i];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $prof_tema[$i];?>
							</div>
							
							<div style='display:table-cell;text-align:center;padding-left:1%;vertical-align:middle;'>
								<?php print $prof_img[$i]?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<?php print $prof_obs[$i]?>
							</div>
							
							<div style='display:table-cell;text-align:center;padding-left:1%;vertical-align:middle;'>
								<?php print $insp_img[$i]?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;'>
								<input <?php if(!isset($existe_inasistencia[$i])){?>style='display:none;'<?php }?> onBlur="guardar_inasistencia_obs('<?php print $id;?>')" name="obs_insp_<?php print $id;?>" id="obs_insp_<?php print $id;?>" type="text" value="<?php print $insp_obs[$i];?>"/>
							</div>
						</div>

					<?php $rs_horas_clase->MoveNext();}?>
						
					</div>
				</td>
			</tr>
		</table>
	</div>
<?php 

}
?>