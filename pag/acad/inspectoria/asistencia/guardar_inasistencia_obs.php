<?php
$x='../../../../';
//include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$campo0 = explode("_",$_POST['campo0']);
	
	$id_clase_estudiante=$campo0[0];
	$id_clase_inasistencia=$campo0[1];
	$obs=$_POST['campo1'];
	
	$sql_i="SELECT inasistencia FROM inasistencia_clase WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	if(isset($rs_i->fields['inasistencia']))
	{
		$upd_nota="UPDATE inasistencia_clase SET observacion_inspector='".$obs."' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
		$db->Execute($upd_nota) or die($db->ErrorMsg());
	}
	else
	{
		$ins_sql='INSERT INTO inasistencia_clase(id_clase_inasistencia, id_clase_estudiante, inasistencia, a_clase, observacion, inasistencia_inspector, observacion_inspector)
		VALUES("'.$id_clase_inasistencia.'","'.$id_clase_estudiante.'","0","1","", "","'.$obs.'")';//print $ins_sql;die();
		$db->Execute($ins_sql) or die($db->ErrorMsg());
	}
}
?>