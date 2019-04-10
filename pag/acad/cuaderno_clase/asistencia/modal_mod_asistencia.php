<?php
$x='../../../../';
include($x."pag/acad/clase_inasistencia/variables_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
$mod=$_POST['campo0'];
$sel_filtro_asis=$_POST['campo1'];
$id_clase_inasistencia=$_POST['campo2'];
}
?>
<div class="modalbox movedown">
	<br>
	<div id='modal_modificar_actividad'>
		<?php

		if(!isset($obj))$obj = new clases();
		
		$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
		$obj->Validar_permiso($rs_sesion,$elemento,"Insertar"); // (NO TOCAR)

		$combo_sql[$f] = "SELECT n_subperiodo_evaluativo.id_subperiodo_evaluativo AS id_ss_mod, concat(subperiodo_evaluativo,' (',abv_subperiodo,')') as subp_mod
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica 
		WHERE 1 
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo 
		AND n_periodo_lectivo.id_periodo_lectivo=n_periodo_evaluativo.id_periodo_lectivo 
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica 
		AND n_conf_academica.activa='1' AND n_subperiodo_evaluativo.id_subperiodo_evaluativo='".$sel_filtro_asis."'";//print $combo_sql[$g];//
		
		$s_rs=$obj->Consulta_llenar_cajas($id_clase_inasistencia,$insert_field,$tabla,$db,$columna,$insert_alias);		
		$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_editar,$mini_m_botones,$rs_sesion,$elemento);
		print '<br>';
		$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)	
		$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
		
		if(isset($return[0]))
		$mensaje=$return[0];
		$obj->Imprimir_mensaje($mensaje);
		?>
		<input name="hdn_id_clase_inasistencia_mod" id="hdn_id_clase_inasistencia_mod" type="hidden" value="<?php print $id_clase_inasistencia;?>"/>
	</div>
</div>