<?php
$x='../../../../';
//include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$campo1 = explode("_",$_POST['campo1']);
	
	$obs=$_POST['campo0'];
	$id_clase_estudiante=$campo1[0];
	$id_actividad=$campo1[1];
	
	$sql_i="SELECT id_nota_actividad_examen FROM nota_actividad_examen WHERE id_actividad='".$id_actividad."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_i.'<br>';
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	if(isset($rs_i->fields['id_nota_actividad_examen']))
	{
		$upd_nota="UPDATE nota_actividad_examen SET observacion='".$obs."' WHERE id_actividad='".$id_actividad."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
		$db->Execute($upd_nota) or die($db->ErrorMsg());
	}
	else
	{
		$ins_sql='INSERT INTO nota_actividad_examen(id_actividad, id_clase_estudiante, observacion)
		VALUES("'.$id_actividad.'","'.$id_clase_estudiante.'","'.$obs.'")';//print $ins_sql;die();
		$db->Execute($ins_sql) or die($db->ErrorMsg());
	}
}
?>