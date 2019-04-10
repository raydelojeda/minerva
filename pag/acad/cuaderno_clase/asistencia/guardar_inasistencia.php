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
	
	$sql_i="SELECT inasistencia FROM inasistencia_clase WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	if(isset($rs_i->fields['inasistencia']))
	{
		if($rs_i->fields['inasistencia']==0)//presente
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia='1', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		elseif($rs_i->fields['inasistencia']==1)//atraso
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia='2', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		elseif($rs_i->fields['inasistencia']==2)//justificado
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia='3', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		elseif($rs_i->fields['inasistencia']==3)//injustificado
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia='0', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
	}
	else
	{
		$ins_sql='INSERT INTO inasistencia_clase(id_clase_inasistencia, id_clase_estudiante, inasistencia, a_clase, inasistencia_inspector)
		VALUES("'.$id_clase_inasistencia.'","'.$id_clase_estudiante.'","1","1","99")';//print $ins_sql;die();
		$db->Execute($ins_sql) or die($db->ErrorMsg());
	}

}
?>