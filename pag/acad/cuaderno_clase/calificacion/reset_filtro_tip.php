<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{	
	$sel_filtro_cal=substr($_POST['campo0'], 2, strlen($_POST['campo0']));
	
	$sql_abv="SELECT DISTINCT n_tipo_actividad.id_tipo_actividad, abv_tipo_actividad_examen, tipo_actividad_examen, n_tipo_actividad.peso
	FROM n_tipo_actividad, n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
	WHERE 1
	AND n_tipo_actividad.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
	AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
	AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
	AND n_conf_academica.id_conf_academica=n_periodo_lectivo.id_conf_academica
	AND n_conf_academica.id_conf_academica='1'  
	AND n_tipo_actividad.id_asignatura='".$_POST['campo1']."'
	AND n_tipo_actividad.id_subperiodo_evaluativo='".$sel_filtro_cal."'
	ORDER BY n_tipo_actividad.orden";//print $sql_abv;die();
	$rs_abv=$db->Execute($sql_abv) or die($db->ErrorMsg());
	
	$parametros_extras="onChange=\"ejecutar_ajax('calificacion/actualizar_grid.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, sel_filtro_tip', 'contenido_grid_calificaciones');\"";
	$clases_acad->select_filtro_tip($rs_abv, $parametros_extras);
}
?>