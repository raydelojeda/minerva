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
	$clases_acad->contenido_recomendaciones($db, $x, $_POST['campo0'], $_POST['campo1'], $_POST['campo2']);//campo0 es el id_clase
}
?>