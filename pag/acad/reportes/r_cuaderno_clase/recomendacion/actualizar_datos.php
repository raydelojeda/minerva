<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../cuaderno_clase_recomendacion.php");
$cuaderno_clase_recomendacion = new cuaderno_clase_recomendacion();

if(isset($_POST['campo0']))
{	
	$x='../../../../';
	$cuaderno_clase_recomendacion->contenido_recomendaciones($db, $x, $_POST['campo0'], $_POST['campo1']);//campo0 es el id_clase
}
?>