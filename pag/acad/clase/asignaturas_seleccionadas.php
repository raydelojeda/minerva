<?php
include("variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");
include("clase.php");
if(!isset($obj_clase))$obj_clase = new clase();// (NO TOCAR)

if(isset($_POST['campo0']))
{
	$sql="SELECT id_asignatura as id_asignatura, abreviatura, asignatura FROM n_asignatura WHERE 1 AND id_asignatura='".$_POST['campo0']."'";//print $sql;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());
//print $_POST['campo2'];
	$obj_clase->tabla_seleccionadas($rs, $_POST['campo1'], $_POST['campo2'], $db, $x);
	
}
?>