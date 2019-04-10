<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("avances.php");
$avances = new avances();

if(isset($_POST['campo0']))
{	
	$id_seccion_academica=$_POST['campo1'];
	$id_grado=$_POST['campo0'];	
	
	$parametros_extras="onChange=\"ejecutar_ajax('filtrar_grado_paralelo.php','hdn_id_seccion_academica_".$id_seccion_academica.", sel_filtro_gra_".$id_seccion_academica.", sel_filtro_par_".$id_grado."', 'grid_".$id_seccion_academica."');\"";
	$avances->select_filtro_paralelos($db, $id_grado, $parametros_extras);
}
?>