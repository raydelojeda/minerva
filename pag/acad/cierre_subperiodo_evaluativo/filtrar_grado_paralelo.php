<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("avances.php");
$avances = new avances();

if(isset($_POST['campo0']))
{
	$id_seccion_academica=$_POST['campo0'];
	$id_grado=$_POST['campo1'];
	if(!isset($_POST['campo2']))
	$avances->contenido_avance($db, $id_seccion_academica, $id_grado, '');
	else
	$avances->contenido_avance($db, $id_seccion_academica, $id_grado, $_POST['campo2']);
}
?>