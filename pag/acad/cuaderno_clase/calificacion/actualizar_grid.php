<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{	
	$x='../../../';
	$clases_acad->contenido_calificaciones($db, $x, $_POST['campo0'], $_POST['campo1'], $_POST['campo2'], $_POST['campo3']);//campo0 es el id_clase, campo1 es el id del filtro y el campo2 es id_asignatura
}
?>