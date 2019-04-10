<?php
include("var_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");
if(!isset($obj))$obj = new clases();// (NO TOCAR)

if(isset($_POST['campo0']))
{
	$sel_filtro_cal=substr($_POST['campo0'], 2, strlen($_POST['campo0']));
	$mod=$_POST['campo2'];//este es el id_clase
	$id_asignatura=$_POST['campo1'];
	$id_subperiodo_evaluativo=$sel_filtro_cal;
	
	include($x."pag/acad/actividad/variables.php");
	$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
	$obj->Validar_permiso($rs_sesion,$elemento,"Insertar"); // (NO TOCAR)
	
	if(substr($_POST['campo0'], 0, 2)=='s_')
	{
		print '<br>';
		$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
		print '<br>';			
		?>
			
			<div class="tab-pane" id="tabPane">
				<div class="tab-page">
					<h2 class="tab">Actividad o Examen</h2>
					<?php
						$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
					?>					
				</div>
		
				<div class="tab-page" id='tarea_detalles_ins' style='display:none;'>
					<h2 class="tab">Tarea en casa</h2>
					&nbsp;<b>No hay nada detallado para hacer en casa.</b>
				</div>
			</div>
		
			<script type="text/javascript">setupAllTabs();</script>		
		<?php
		if(isset($return[0]))
		$mensaje=$return[0];
		$obj->Imprimir_mensaje($mensaje);
	}
}
?>