<?php
$x='../../../../';
//include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../inspectoria.php");
$obj_inspectoria = new inspectoria();

if(isset($_POST['campo0']))
{
	$campo0 = explode("_",$_POST['campo0']);
	
	$id_clase_estudiante=$campo0[0];
	$id_clase_inasistencia=$campo0[1];
	
	$id_estudiante=$_POST['campo5'];
	$id_grado=$_POST['campo6'];
	$id_paralelo=$_POST['campo7'];
	$fecha=$_POST['campo8'];
	
	$sql_i="SELECT inasistencia_inspector FROM inasistencia_clase WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_i.'<br>';
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	if(isset($rs_i->fields['inasistencia_inspector']))
	{
		if($rs_i->fields['inasistencia_inspector']==0 OR $rs_i->fields['inasistencia_inspector']=='')//presente o NULL
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia_inspector='1', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		elseif($rs_i->fields['inasistencia_inspector']==1)//atraso
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia_inspector='2', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		elseif($rs_i->fields['inasistencia_inspector']==2)//justificado
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia_inspector='3', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		elseif($rs_i->fields['inasistencia_inspector']==3 OR $rs_i->fields['inasistencia_inspector']==99)//injustificado
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia_inspector='0', a_clase='1' WHERE id_clase_inasistencia='".$id_clase_inasistencia."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
	}
	else
	{
		$ins_sql='INSERT INTO inasistencia_clase(id_clase_inasistencia, id_clase_estudiante, inasistencia, a_clase, inasistencia_inspector, observacion_inspector)
		VALUES("'.$id_clase_inasistencia.'","'.$id_clase_estudiante.'","0","1","0","")';//print $ins_sql;//die();
		$db->Execute($ins_sql) or die($db->ErrorMsg());
	}
	
	$obj_inspectoria->contenido_asistencias($db, $id_estudiante, $id_grado, $id_paralelo, $fecha);

}
?>