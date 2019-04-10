<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

$visualizar=1;
$nombre_adjunto='';

if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>
<script src="<?php print $x."include/ckeditor/ckeditor.js";?>"></script>
<script src="<?php print $x."include/upload/js/upload.js";?>"></script>
<script src="<?php print $x."include/upload/js/bootstrap.min.js";?>"></script>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<?php
$x='../../../';
include($x."pag/acad/actividad/variables_mod.php");

$sql_act = "SELECT actividad.id_actividad, usuario FROM tarea, actividad, clase, empleado_academico, empleado, persona, usuario
WHERE 1
AND persona.id_persona=usuario.id_persona
AND persona.id_persona=empleado.id_persona
AND empleado_academico.id_empleado=empleado.id_empleado
AND empleado_academico.id_empleado_academico=clase.id_empleado_academico
AND actividad.id_clase=clase.id_clase
AND actividad.id_actividad=tarea.id_actividad
AND id_tarea='".$mod."'";//print $sql_act;
$rs_act=$db->Execute($sql_act) or die($db->ErrorMsg());
$id_actividad=$rs_act->fields['id_actividad'];
$usuario=$rs_act->fields['usuario'];
?>
<div>
	<br>
	<div id='modal_modificar_actividad'>
		
		<?php
		include($x."pag/acad/actividad/variables_mod.php");
		
		$combo_sql[$g] = "select n_tipo_actividad.id_tipo_actividad as id_tipo_mod, concat(abv_tipo_actividad_examen,' - ',tipo_actividad_examen) as tipo 
		FROM n_tipo_actividad, actividad WHERE 1 AND n_tipo_actividad.id_tipo_actividad=actividad.id_tipo_actividad AND id_actividad='".$id_actividad."' ORDER BY n_tipo_actividad.orden";//print $combo_sql[$g];
		
		$s_rs=$obj->Consulta_llenar_cajas($id_actividad,$insert_field,$tabla,$db,$columna,$insert_alias);
		?>
		
		<div class="tab-pane" id="tabPane">
			<div class="tab-page">
				<h2 class="tab">Actividad o Examen</h2>

				<?php
				$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
				$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','1');
				?>
				<input name="hdn_id_actividad_mod" id="hdn_id_actividad_mod" type="hidden" value="<?php print $id_actividad;?>"/>
			
			
			<?php

			if(isset($mod))
			{
				if($mod!='')
				{
			?>
				
					<fieldset style=' margin: 0 auto;width:95%;'>
					<legend><?php print $s_rs->fields['act_mod'];?></legend>
						<div class="tab-pane" id="tabPane1" style='align:center;'>
							
							<div class="tab-page">
								<h2 class="tab">General</h2>						
								<?php
									include($x."pag/acad/tarea_hijo_vigentes/variables.php");
									
									$sql_t = "SELECT id_tarea as id_tarea, fecha_ini as ini, fecha_fin as fin, opcional as opc, descripcion FROM tarea WHERE id_tarea='".$mod."'";
									$rs_t=$db->Execute($sql_t) or die($db->ErrorMsg());
									
									$obj->Generar_inputs($inputs,$rs_t,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','1');
								?>
							</div>						
						
							<div class="tab-page">
								<h2 class="tab">Descripci&oacute;n</h2>
								<textarea name="txt_descrip" disabled style="background-color:#ddd" title="Descripci&oacute;n" id="txt_descrip" cols="80"><?php print $rs_t->fields['descripcion'];?></textarea>
								<script>
									CKEDITOR.replace('txt_descrip');
								</script>
							</div>
						
							<div class="tab-page">
								<h2 class="tab">Adjuntos</h2>
								<?php
								$sql_adj="SELECT nombre_adjunto
								FROM tarea_adjunto
								WHERE 1	AND id_tarea='".$mod."'";//print $sql_adj;
								$rs_adj=$db->Execute($sql_adj) or die($db->ErrorMsg());

								if(isset($rs_adj))
								{
									if($rs_adj->fields['nombre_adjunto']!='')
									{
										for($a=0;$a<$rs_adj->RecordCount();$a++)
										{//print 'href="../../../archivos/tareas/'.$usuario.'/'.$mod.'/'.utf8_encode($rs_adj->fields['nombre_adjunto']).'"';
											$nombre_adjunto.='<br>'.'<a href="../../../archivos/tareas/'.$usuario.'/'.$mod.'/'.utf8_encode($rs_adj->fields['nombre_adjunto']).'"  download="'.utf8_encode($rs_adj->fields['nombre_adjunto']).'">'.'<img width="15px" src="../../../img/general/descargar.png"/>&nbsp;'.utf8_encode($rs_adj->fields['nombre_adjunto']).'</a>';
										$rs_adj->MoveNext();
										}
									}
								}
								if($nombre_adjunto=='')$nombre_adjunto='No hay adjuntos.';
								?>
								<br>
								<div style='display:table;width:100%;'>	
									<div style='display:table-row;'>					
										<div style='display:table-cell;width:100%;text-align:left;padding-left: 3%;'><?php print $nombre_adjunto;?></div>
									</div>
								</div>
							</div>

						</div>
					</fieldset>
					<script type="text/javascript">setupAllTabs();</script>
				
			
			<?php 
				}
				else
				{
					print "&nbsp;<b>Este tipo de actividad o examen no tiene nada detallado para hacer en casa.</b>";
					?>	
					<input type="hidden" name="ini_mod" id="ini_mod"/>
					<input type="hidden" name="fin_mod" id="fin_mod"/>
					<input type="hidden" name="opc_mod" id="opc_mod"/>
					<?php
				}
			}
			else
			{
				print "&nbsp;<b>Este tipo de actividad o examen no tiene nada detallado para hacer en casa.</b>";
				?>	
				<input type="hidden" name="ini_mod" id="ini_mod"/>
				<input type="hidden" name="fin_mod" id="fin_mod"/>
				<input type="hidden" name="opc_mod" id="opc_mod"/>
				<?php
			}
			?>
			</div>
		</div>
		
		<?php
		if(isset($return[0]))
		$mensaje=$return[0];
		$obj->Imprimir_mensaje($mensaje);
		?>
		<textarea name="hdn_txt_descrip" id="hdn_txt_descrip" rows="5" cols="80" style="display:none;"></textarea>
	</div>
</div>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>