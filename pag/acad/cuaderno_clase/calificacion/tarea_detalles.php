<?php
$x='../../../../';
include($x."pag/acad/actividad/variables_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(!isset($obj))$obj = new clases();
		
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
$obj->Validar_permiso($rs_sesion,$elemento,"Insertar"); // (NO TOCAR)

if(isset($_POST['campo0']))
{
	$id_clase=$_POST['campo0'];

	$sql_tip = "select id_tipo_actividad as id_tipo_mod, concat(abv_tipo_actividad_examen,' - ',tipo_actividad_examen) as tipo 
	FROM n_tipo_actividad WHERE 1 AND visualizan_ppff='1' AND id_tipo_actividad='".$_POST['campo0']."' ORDER BY n_tipo_actividad.orden";
	$rs_tip=$db->Execute($sql_tip) or die($db->ErrorMsg());

	if(isset($rs_tip->fields['tipo']))
	{
		if($rs_tip->fields['tipo']!='')
		{
?>		
			<fieldset>
			<legend><?php print $rs_tip->fields['tipo'];?></legend>
				<div class="tab-pane" id="tabPane1" style='align:center;'>
					
					<div class="tab-page">
						<h2 class="tab">General</h2>						
						<?php
							include($x."pag/acad/tarea_vigentes/variables.php");
							$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
						?>
					</div>						
				
					<div class="tab-page">
						<h2 class="tab">Descripci&oacute;n</h2>
						<textarea name="txt_descrip" title="Descripci&oacute;n"  id="txt_descrip" rows="5" cols="80"></textarea>
						<script>
							CKEDITOR.replace('txt_descrip');
						</script>
					</div>
				
					<div class="tab-page">
						<h2 class="tab">Adjuntos</h2>
						
						<div id="respuesta" class="alert"></div>
						<form action="javascript:void(0);">
							<div style='display:table;width:100%;'>			
								
								<div style='display:table-row;'>
									<div style='display:table-cell;width:100%;text-align:center;'>
										<input type="hidden" name="nombre_archivo" id="nombre_archivo" />
										<div class="upload">
											<input type="file" name="archivo" id="archivo" onchange="subirArchivos();poner_valor();"/>
											<progress id="barra_de_progreso" value="0" size="1000"></progress>
										</div>
									</div>									
								</div>	
								
								<br>
								
								<div style='display:none;' id='row_archivos_subidos'>
									<div style='display:table-cell;height:30px;width:100%;text-align:left;'>
										<div id="archivos_subidos" ></div>
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
			<script type="text/javascript">setupAllTabs();</script>
<?php
		}
		else
		{
			print "&nbsp;<b>Este tipo de actividad o examen no tiene nada detallado para hacer en casa.</b>";
			?>	
			<input type="hidden" name="ini" id="ini"/>
			<input type="hidden" name="fin" id="fin"/>
			<input type="hidden" name="opc" id="opc"/>
			<?php
		}
	}
	else
	{
		print "&nbsp;<b>Este tipo de actividad o examen no tiene nada detallado para hacer en casa.</b>";
		?>	
		<input type="hidden" name="ini" id="ini"/>
		<input type="hidden" name="fin" id="fin"/>
		<input type="hidden" name="opc" id="opc"/>
		<?php
	}
}
?>
<textarea name="hdn_txt_descrip" id="hdn_txt_descrip" rows="5" cols="80" style="display:none;"></textarea>
