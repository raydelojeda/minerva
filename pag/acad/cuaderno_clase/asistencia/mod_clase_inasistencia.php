<?php
$x='../../../../';
include($x."pag/acad/clase_inasistencia/variables_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();
//print $_POST['campo0'].' - '.$_POST['campo3'];die();
if(isset($_POST['campo0']))
{
	$upd_sql='UPDATE '.$tabla.' SET id_subperiodo_evaluativo="'.$_POST['campo1'].'",fecha="'.$_POST['campo2'].'", tema_impartir="'.$_POST['campo3'].'" WHERE id_clase_inasistencia="'.$_POST['campo5'].'"';//print $upd_sql;
	$db->Execute($upd_sql) or die($db->ErrorMsg());

	$x='../../../';
	$clases_acad->contenido_asistencias($db, $x, $_POST['campo0'], $_POST['campo4']);
}
?>