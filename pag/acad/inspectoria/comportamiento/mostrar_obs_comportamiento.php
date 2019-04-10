<?php
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../inspectoria.php");
$inspectoria = new inspectoria();

if(isset($_POST['campo0']))
{	
	$campo0 = explode("_",$_POST['campo0']);
	
	$id_curso_grado_paralelo_est=$campo0[0];
	$id_subperiodo_evaluativo=$campo0[1];
	$id_grado=$_POST['campo1'];
	$id_paralelo=$_POST['campo2'];

	$id_gra_par=$id_grado.'_'.$id_paralelo;	
	
	$sql_obs="SELECT nota_comportamental_sub_insp.id_nota_comportamental_sub_insp FROM nota_comportamental_sub_insp 
	WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_i.'<br>';
	$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
	
	$sql_est="SELECT estudiante.id_estudiante, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
	FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est
	WHERE 1
	AND per_estudiante.id_persona=estudiante.id_persona
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
	AND curso_grado_paralelo_est.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_est;
	$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
	
	$sql_sub="SELECT subperiodo_evaluativo, abv_subperiodo FROM n_subperiodo_evaluativo	WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'";//print $sql_i.'<br>';
	$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());
	
	if($rs_est->fields['estudiante'])
	{
?>
		<input type="hidden" name="hdn_id_nota_comportamental_sub_insp_<?php print $id_gra_par;?>" value="<?php print $rs_obs->fields['id_nota_comportamental_sub_insp'];?>">
		<input type="hidden" name="hdn_id_curso_grado_paralelo_est_<?php print $id_gra_par;?>" value="<?php print $id_curso_grado_paralelo_est;?>">
		<input type="hidden" name="hdn_id_subperiodo_evaluativo_<?php print $id_gra_par;?>" value="<?php print $id_subperiodo_evaluativo;?>">
		<input type="hidden" name="hdn_id_obs_comportamental_sub_insp_<?php print $id_gra_par;?>" value="">
		<input type="hidden" name="hdn_modificar_<?php print $id_gra_par;?>" id="hdn_modificar_<?php print $id_gra_par;?>" value="0">
		
		<fieldset>
			<legend>Comportamental de <b><?php print $rs_est->fields['estudiante'].'</b> en el <b>'.$rs_sub->fields['subperiodo_evaluativo'].' ('.$rs_sub->fields['abv_subperiodo'].')';?></b></legend>
			<br>
			<fieldset>
				<legend>Insertar observaci&oacute;n de comportamiento del inspector</legend>
				
				<table id="toolbar" style='float:right;' width="1%">
					<tbody>
						<tr>
							<td class="botonera_encabezado">
								<div style='text-align:center;'>
									<a class="toolbar" onclick="
									ok=validar_sin_submit('txt_fecha_comp_<?php print $id_gra_par;?>','','Rfecha','txt_nota_<?php print $id_gra_par;?>','','Rentero','txt_obs_<?php print $id_gra_par;?>','','Rvarchar');
									if(ok==0)return false;									
									function haceAlgo(callbackPaso1)
									{callbackPaso1;}
									haceAlgo(ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_gra_<?php print $id_grado;?>, hdn_id_par_<?php print $id_gra_par;?>', 'contenido_grid_comportamiento_<?php print $id_gra_par;?>', ejecutar_ajax1('comportamiento/ins_obs_comportamiento.php','hdn_id_nota_comportamental_sub_insp_<?php print $id_gra_par;?>, txt_fecha_comp_<?php print $id_gra_par;?>, rbt_positiva_<?php print $id_gra_par;?>, rbt_destacada_<?php print $id_gra_par;?>, txt_nota_<?php print $id_gra_par;?>, txt_obs_<?php print $id_gra_par;?>, hdn_id_curso_grado_paralelo_est_<?php print $id_gra_par;?>, hdn_id_subperiodo_evaluativo_<?php print $id_gra_par;?>, hdn_modificar_<?php print $id_gra_par;?>, hdn_id_obs_comportamental_sub_insp_<?php print $id_gra_par;?>, hdn_id_gra_<?php print $id_grado;?>, hdn_id_par_<?php print $id_gra_par;?>','div_listado_obs_<?php print $id_gra_par;?>')));limpiar_campos(String('txt_fecha_comp_<?php print $id_gra_par;?>,txt_nota_<?php print $id_gra_par;?>,txt_obs_<?php print $id_gra_par;?>').split(','));document.frm.hdn_modificar_<?php print $id_gra_par;?> .value=0; " target="_self">
										
										<img id="guardar" border="0" width="16" height="16" name="guardar" alt="Guardar" src="../../../img/general/guardar_mini.png">
										<br>
										Guardar
									</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				
				<div style='display:table;'>
					<div style='display:table-row;'>
						<div style='display:table-cell;width:15%;text-align:right;padding:1%;'>				
							Fecha:
						</div>
						<div style='display:table-cell;width:85%;text-align:left;padding:1%;'>				
							<input id="txt_fecha_comp_<?php print $id_gra_par;?>" type="text" value="<?php print date("Y-m-d");?>" maxlength="10" size="10" onclick='displayCalendar(document.frm.txt_fecha_comp_<?php print $id_gra_par;?>,"yyyy-m-d",this);' title="Fecha" name="txt_fecha_comp_<?php print $id_gra_par;?>">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="rbt_positiva_<?php print $id_gra_par;?>" value="0" checked>&nbsp;Negativa&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="rbt_positiva_<?php print $id_gra_par;?>" value="1">&nbsp;Positiva
						</div>
					</div>
					<div style='display:table-row;'>
						<div style='display:table-cell;width:15%;text-align:right;padding:1%;'>				
							Destacada:
						</div>
						<div style='display:table-cell;width:85%;text-align:left;padding:1%;'>				
							<input type="radio" name="rbt_destacada_<?php print $id_gra_par;?>" value="0" checked>&nbsp;No&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="rbt_destacada_<?php print $id_gra_par;?>" value="1">&nbsp;Si
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Nota:
							<input type="number" step="0.1" title='Nota' maxlength="3" size='3' name="txt_nota_<?php print $id_gra_par;?>" value="0.5" min='0.1' max='3'>
						</div>
					</div>
					<div style='display:table-row;'>
						<div style='display:table-cell;width:15%;text-align:right;padding:1%;'>				
							Observaci&oacute;n:
						</div>
						<div style='display:table-cell;width:85%;text-align:left;padding:1%;'>				
							<textarea name='txt_obs_<?php print $id_gra_par;?>' title='Observaci&oacute;n' id='txt_obs_<?php print $id_gra_par;?>' rows='3' cols='40'></textarea>
						</div>
					</div>
				</div>
			</fieldset>
			
			<br>
			
			<fieldset>
				<legend>Listado de observaciones de comportamiento</legend>		
				<div id='div_listado_obs_<?php print $id_gra_par;?>'>					
					<?php $inspectoria->mostrar_obs_comportamiento($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo, $id_grado, $id_paralelo, '../../../', '1');?>
				</div>

				<?php //print $rs_obs->fields['observacion'];?>
			</fieldset>
		</fieldset>
<?php
	}
}
?>