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
	$clases_acad->contenido_comportamientos($db, $_POST['campo0']);//campo0 es el id_clase
}
?>