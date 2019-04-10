<?php
include("var_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");
if(!isset($obj))$obj = new clases();// (NO TOCAR)

if(isset($_POST['campo0']))
{

	$mod=$_POST['campo1'];//este es el id_clase
	$sel_filtro_asis=$_POST['campo0'];//este es el id_clase
	include($x."pag/acad/clase_inasistencia/variables.php");
	$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
	$obj->Validar_permiso($rs_sesion,$elemento,"Insertar"); // (NO TOCAR)
	
	print '<br>';
	
	$combo_sql[$f] = "SELECT n_subperiodo_evaluativo.id_subperiodo_evaluativo AS id_ss, concat(subperiodo_evaluativo,' (',abv_subperiodo,')') as subp
	FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica 
	WHERE 1 
	AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo 
	AND n_periodo_lectivo.id_periodo_lectivo=n_periodo_evaluativo.id_periodo_lectivo 
	AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica 
	AND n_conf_academica.activa='1' AND n_subperiodo_evaluativo.id_subperiodo_evaluativo='".$sel_filtro_asis."'";//print $combo_sql[$f];die();

	$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
	
	print '<br>';
	$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)	
	$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
	
	if(isset($_GET['mensaje']))
	$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
	$mensaje=$return[0];
	$obj->Imprimir_mensaje($mensaje);
}
?>