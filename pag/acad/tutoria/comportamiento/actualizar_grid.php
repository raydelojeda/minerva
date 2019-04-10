<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../tutoria.php");
$tutoria = new tutoria();

if(isset($_POST['campo0']))
{	
	$x='../../';
	$id_grado=$_POST['campo0'];
	$id_paralelo=$_POST['campo1'];
	$tutoria->contenido_comportamientos($db, $x, $id_grado, $id_paralelo);//campo0 es el id_clase
}
?>