<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../tutoria.php");
$tutoria = new tutoria();

if(isset($_POST['campo0']))
{	
	$x='../../../';
	$tutoria->contenido_recomendaciones($db, $x, $_POST['campo0'], $_POST['campo1'], $_POST['campo2'], $_POST['campo3']);//campo0 es el id_clase
}
?>