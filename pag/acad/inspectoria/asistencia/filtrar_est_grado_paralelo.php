<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../inspectoria.php");
$obj_inspectoria = new inspectoria();

if(isset($_POST['campo0']))
{
	$id_estudiante=$_POST['campo0'];
	$id_grado=$_POST['campo1'];
	$id_paralelo=$_POST['campo2'];
	$fecha=$_POST['campo3'];
	$obj_inspectoria->contenido_asistencias($db, $id_estudiante, $id_grado, $id_paralelo, $fecha);
}
?>