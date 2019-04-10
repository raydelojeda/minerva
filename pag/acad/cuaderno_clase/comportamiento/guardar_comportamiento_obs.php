<?php
$x='../../../../';
include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$campo1 = explode("_",$_POST['campo1']);
	
	$obs=$_POST['campo0'];
	$id_clase_estudiante=$campo1[0];
	$id_subperiodo_evaluativo=$campo1[1];
	
	$sql_i="SELECT id_nota_comportamental_sub FROM nota_comportamental_sub WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_i.'<br>';
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	if(isset($rs_i->fields['id_nota_comportamental_sub']))
	{
		$upd_nota="UPDATE nota_comportamental_sub SET observacion='".$obs."' WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
		$db->Execute($upd_nota) or die($db->ErrorMsg());
	}
	else
	{
		$ins_sql='INSERT INTO nota_comportamental_sub(id_subperiodo_evaluativo, id_clase_estudiante, observacion)
		VALUES("'.$id_subperiodo_evaluativo.'","'.$id_clase_estudiante.'","'.$obs.'")';//print $ins_sql;die();
		$db->Execute($ins_sql) or die($db->ErrorMsg());
	}
}
?>