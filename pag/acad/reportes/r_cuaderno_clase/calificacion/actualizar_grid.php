<?php
$x='../../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../cuaderno_clase_calificacion.php");
$cuaderno_clase_calificacion = new cuaderno_clase_calificacion();

if(isset($_POST['campo0']))
{	
	$id_estudiante=$_POST['campo0'];
	//if(isset($_POST['campo1']))$id_subperiodo_evaluativo=$_POST['campo1'];else $id_subperiodo_evaluativo='';
	if($id_estudiante!=0)$html =$cuaderno_clase_calificacion->contenido_calificaciones($db, $id_estudiante);

 

}
?>