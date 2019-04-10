<script src="js.js"></script>
<?php
$x='../../../../';
include($x."pag/acad/actividad/variables_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
$id_clase=$_POST['campo0'];
$sel_filtro_cal=$_POST['campo1'];
$id_asignatura=$_POST['campo2'];
$id_actividad=$_POST['campo3'];
}
?>
<div class="modalbox movedown">
	<br>
	<div id='modal_modificar_actividad'>
		
		<?php
		if(!isset($obj))$obj = new clases();
		
		$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
		$obj->Validar_permiso($rs_sesion,$elemento,"Editar"); // (NO TOCAR)

		include($x."pag/acad/actividad/variables_mod.php");
		
		$sel_filtro_cal=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
		$id_actividad=substr($id_actividad, 2, strlen($id_actividad));
		
		$combo_sql[$g] = "select id_tipo_actividad as id_tipo_mod, concat(abv_tipo_actividad_examen,' - ',tipo_actividad_examen) as tipo 
		FROM n_tipo_actividad WHERE 1 AND id_asignatura='".$id_asignatura."' AND id_subperiodo_evaluativo='".$sel_filtro_cal."' ORDER BY n_tipo_actividad.orden";//print $combo_sql[$g];
		
		$s_rs=$obj->Consulta_llenar_cajas($id_actividad,$insert_field,$tabla,$db,$columna,$insert_alias);
		
		$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_editar,$mini_m_botones,$rs_sesion,$elemento);
		print '<br>';
		?>
		
		<div class="tab-pane" id="tabPane">
			<div class="tab-page">
				<h2 class="tab">Actividad o Examen</h2>

				<?php
				$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
				$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
				?>
				<input name="hdn_id_actividad_mod" id="hdn_id_actividad_mod" type="hidden" value="<?php print $id_actividad;?>"/>
			
			</div>
			<?php
			$sql_tar = "select id_tarea 
			FROM tarea WHERE 1 AND id_actividad='".$id_actividad."'";//print $sql_tar;
			$rs_tar=$db->Execute($sql_tar) or die($db->ErrorMsg());

			if(isset($rs_tar->fields['id_tarea']))
			{
				if($rs_tar->fields['id_tarea']!='')
				{
			?>
				<div class="tab-page" id='tarea_detalles_mod' style='display:none;'>
					<h2 class="tab">Tarea en casa</h2>
					<fieldset>
					<legend><?php print $s_rs->fields['act_mod'];?></legend>
						<div class="tab-pane" id="tabPane1" style='align:center;'>
							
							<div class="tab-page">
								<h2 class="tab">General</h2>						
								<?php
									include($x."pag/acad/tarea_vigentes/variables.php");
									
									$sql_t = "SELECT id_tarea as id_tarea, fecha_ini as ini, fecha_fin as fin, opcional as opc, descripcion FROM tarea WHERE id_tarea='".$rs_tar->fields['id_tarea']."'";
									$rs_t=$db->Execute($sql_t) or die($db->ErrorMsg());
									
									$obj->Generar_inputs($inputs,$rs_t,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
								?>
							</div>						
						
							<div class="tab-page">
								<h2 class="tab">Descripci&oacute;n</h2>
								<textarea name="txt_descrip" title="Descripci&oacute;n" id="txt_descrip" rows="5" cols="80"><?php print $rs_t->fields['descripcion'];?></textarea>
								<script>
									CKEDITOR.replace('txt_descrip');
								</script>
							</div>
						
							<div class="tab-page">
								<h2 class="tab">Adjuntos</h2>
								
								<form action="javascript:void(0);">
									<div style='display:table;width:100%;'>			
										
										<div style='display:table-row;'>
											<div style='display:table-cell;width:100%;text-align:center;'>
												<input type="hidden" name="nombre_archivo_mod" id="nombre_archivo_mod" />
												<div class="upload">
													<input type="file" name="archivo_mod" id="archivo_mod" onchange="poner_valor_mod();subirArchivos_mod('<?php print $rs_tar->fields['id_tarea'];?>');"/>
													<progress id="barra_de_progreso_mod" value="0" size="1000"></progress>
												</div>
											</div>									
										</div>	
										
										<br>
										
										<div style='display:none;' id='row_archivos_subidos_mod'>
											<div style='display:table-cell;height:30px;width:100%;text-align:left;'>
												<div id="archivos_subidos_mod" ></div>
											</div>									
										</div>								
										
									</div>	
								</form>
								
							</div>
							
							<?php /*
							<div class="tab-page">
								<h2 class="tab">Estudiantes</h2>
								
							</div>
							*/?>
							
						</div>
					</fieldset>
					<script type="text/javascript">mostrarArchivos_mod('<?php print $rs_tar->fields['id_tarea'];?>');setupAllTabs();</script>
				</div>
			
			<?php 
				}
				else
				{
					//print "&nbsp;<b>Este tipo de actividad o examen no tiene nada detallado para hacer en casa.</b>";
					?>	
					<input type="hidden" name="ini_mod" id="ini_mod"/>
					<input type="hidden" name="fin_mod" id="fin_mod"/>
					<input type="hidden" name="opc_mod" id="opc_mod"/>
					<?php
				}
			}
			else
			{
				//print "<br>&nbsp;<b>Este tipo de actividad o examen no tiene nada detallado para hacer en casa.</b>";
				?>	
				<input type="hidden" name="ini_mod" id="ini_mod"/>
				<input type="hidden" name="fin_mod" id="fin_mod"/>
				<input type="hidden" name="opc_mod" id="opc_mod"/>
				<?php
			}
			?>
		</div>
		<script type="text/javascript">setupAllTabs();</script>	
		<?php
		if(isset($return[0]))
		$mensaje=$return[0];
		$obj->Imprimir_mensaje($mensaje);
		?>
		<textarea name="hdn_txt_descrip" id="hdn_txt_descrip" rows="5" cols="80" style="display:none;"></textarea>
	</div>
</div>