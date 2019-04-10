<?php
include("variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");
include("clase.php");
if(!isset($obj_clase))$obj_clase = new clase();// (NO TOCAR)

if(isset($_POST['campo0']))
{
	$sql="SELECT id_asignatura as id_asignatura, abreviatura, asignatura FROM n_asignatura WHERE 1 AND asignatura like '%".$_POST['campo0']."%'";//print $sql;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());

	$obj_clase->tabla($db, $x, $_POST['campo1'], $rs);
}
?>