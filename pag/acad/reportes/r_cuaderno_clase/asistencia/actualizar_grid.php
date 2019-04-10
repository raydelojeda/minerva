<?php
$x='../../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../cuaderno_clase_asistencia.php");
$cuaderno_clase_asistencia = new cuaderno_clase_asistencia();

if(isset($_POST['campo0']))
{	
	$id_estudiante=$_POST['campo0'];
	//if(isset($_POST['campo1']))$id_subperiodo_evaluativo=$_POST['campo1'];else $id_subperiodo_evaluativo='';
	if($id_estudiante!=0)$cuaderno_clase_asistencia->contenido_asistencias($db, $id_estudiante);
}
?>