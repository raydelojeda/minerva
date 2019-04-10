<?php
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{	
	$campo0 = explode("_",$_POST['campo0']);
	
	$id_clase_estudiante=$campo0[0];
	$id_subperiodo_evaluativo=$campo0[1];
	
	/**/
	
	$sql_obs="SELECT nota_comportamental_sub.id_nota_comportamental_sub FROM nota_comportamental_sub 
	WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_i.'<br>';
	$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
	
	$sql_est="SELECT estudiante.id_estudiante, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
	FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, clase_estudiante
	WHERE 1
	AND per_estudiante.id_persona=estudiante.id_persona
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
	AND curso_grado_paralelo_est.id_curso_grado_paralelo_est=clase_estudiante.id_curso_grado_paralelo_est
	AND clase_estudiante.id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_est;
	$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
	
	$sql_sub="SELECT subperiodo_evaluativo, abv_subperiodo FROM n_subperiodo_evaluativo	WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'";//print $sql_i.'<br>';
	$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());
	
	if($rs_est->fields['estudiante'])
	{
?>
		<input type="hidden" name="hdn_id_nota_comportamental_sub" value="<?php print $rs_obs->fields['id_nota_comportamental_sub'];?>">
		<input type="hidden" name="hdn_id_clase_estudiante" value="<?php print $id_clase_estudiante;?>">
		<input type="hidden" name="hdn_id_subperiodo_evaluativo" value="<?php print $id_subperiodo_evaluativo;?>">
		<input type="hidden" name="hdn_id_obs_comportamental_sub" value="">
		<input type="hidden" name="hdn_modificar" value="0">
		
		<fieldset style='width:99%;text-align:left;'>
			<legend>Comportamental de <b><?php print $rs_est->fields['estudiante'].'</b> en el <b>'.$rs_sub->fields['subperiodo_evaluativo'].' ('.$rs_sub->fields['abv_subperiodo'].')';?></b></legend>
			<br>
			<fieldset>
				<legend>Insertar observaci&oacute;n de comportamiento</legend>
				
				<table id="toolbar" style='float:right;' width="1%">
					<tbody>
						<tr>
							<td class="botonera_encabezado">
								<div style='text-align:center;'>
									<a class="toolbar" onclick="
									ok=validar_sin_submit('txt_fecha','','Rfecha','txt_nota','','Rentero','txt_obs','','Rvarchar');
									if(ok==0)return false;	
									ejecutado=ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_clase', 'contenido_grid_comportamientos',ejecutar_ajax1('comportamiento/ins_obs_comportamiento.php','hdn_id_nota_comportamental_sub, txt_fecha, rbt_positiva, rbt_destacada, txt_nota, txt_obs, hdn_id_clase_estudiante, hdn_id_subperiodo_evaluativo, hdn_modificar, hdn_id_obs_comportamental_sub','div_listado_obs'));
									//alert(ejecutado);
									//ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_clase', 'contenido_grid_comportamientos');
									/*function haceAlgo(callbackPaso1)
									{callbackPaso1;}
									haceAlgo(ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_clase', 'contenido_grid_comportamientos',
										ejecutar_ajax('comportamiento/ins_obs_comportamiento.php','hdn_id_nota_comportamental_sub, txt_fecha, rbt_positiva, rbt_destacada, txt_nota, txt_obs, hdn_id_clase_estudiante, hdn_id_subperiodo_evaluativo, hdn_modificar, hdn_id_obs_comportamental_sub','div_listado_obs')
										));
									limpiar_campos(String('txt_obs').split(','));document.frm.hdn_modificar.value=0;*/
									" target="_self">
										
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
							<input id="txt_fecha" type="text" value="<?php print date("Y-m-d");?>" maxlength="10" size="10" onclick='displayCalendar(document.frm.txt_fecha,"yyyy-m-d",this);' title="Fecha" name="txt_fecha">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="rbt_positiva" value="0" checked>&nbsp;Negativa&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" disabled name="rbt_positiva" value="1">&nbsp;Positiva
						</div>
					</div>
					<div style='display:table-row;'>
						<div style='display:table-cell;width:15%;text-align:right;padding:1%;'>				
							Destacada:
						</div>
						<div style='display:table-cell;width:85%;text-align:left;padding:1%;'>				
							<input type="radio" name="rbt_destacada" value="0" checked>&nbsp;No&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="rbt_destacada" value="1">&nbsp;Si
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Nota bajada:
							<input type="number" step="0.1" title='Nota bajada' maxlength="3" size='3' name="txt_nota" value="0.5" min='0.5' max='3'>
						</div>
					</div>
					<div style='display:table-row;'>
						<div style='display:table-cell;width:15%;text-align:right;padding:1%;'>				
							Observaci&oacute;n:
						</div>
						<div style='display:table-cell;width:85%;text-align:left;padding:1%;'>				
							<textarea name='txt_obs' title='Observaci&oacute;n' id='txt_obs' rows='3' cols='40'></textarea>
						</div>
					</div>
				</div>
			</fieldset>
			
			<br>
			
			<fieldset>
				<legend>Listado de observaciones de comportamiento</legend>		
				<div id='div_listado_obs'>					
					<?php $clases_acad->mostrar_obs_comportamiento($db, $id_clase_estudiante, $id_subperiodo_evaluativo, '../../../', '1');?>
				</div>

				<?php //print $rs_obs->fields['observacion'];?>
			</fieldset>
		</fieldset>
<?php
	}
}
?>