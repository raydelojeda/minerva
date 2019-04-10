<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{
	$id_obs_comportamental_sub=$_POST['campo0'];
	$id_clase_estudiante=$_POST['campo1'];
	$id_subperiodo_evaluativo=$_POST['campo2'];

	$del_sql='DELETE FROM obs_comportamental_sub WHERE id_obs_comportamental_sub="'.$id_obs_comportamental_sub.'"';//print $del_sql;
	$db->Execute($del_sql) or die($db->ErrorMsg());
	
	$sql_obs="SELECT SUM(nota_perdida) AS nota_perdida FROM nota_comportamental_sub, obs_comportamental_sub 
	WHERE nota_comportamental_sub.id_nota_comportamental_sub=obs_comportamental_sub.id_nota_comportamental_sub
	AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_i.'<br>';
	$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
	
	$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
	$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
	
	$nota_maxima=$rs_nota->fields['nota_maxima'];
	
	$nota=$nota_maxima-$rs_obs->fields['nota_perdida'];
	
	$upd_nota="UPDATE nota_comportamental_sub SET nota='".$nota."' WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
	$db->Execute($upd_nota) or die($db->ErrorMsg());

	$clases_acad->mostrar_obs_comportamiento($db, $id_clase_estudiante, $id_subperiodo_evaluativo, '../../../', '1');
}
?>