<?php
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	

	$sel_filtro_recom=$_POST['campo0'];
	$sel_filtro_est=$_POST['campo1'];
	$recomendaciones=$_POST['campo2'];
	$mejoras=$_POST['campo3'];
	
	$tipo=substr($sel_filtro_recom, 0, 2);
	$sel_filtro_recom=substr($sel_filtro_recom, 2, strlen($sel_filtro_recom));

	if($tipo=='l_' AND $sel_filtro_est!='')
	{
		$sql_i="SELECT recomendaciones, mejoras
		FROM recomendaciones_mejoras_lec_tut
		WHERE 1
		AND recomendaciones_mejoras_lec_tut.id_periodo_lectivo='".$sel_filtro_recom."'
		AND recomendaciones_mejoras_lec_tut.id_curso_grado_paralelo_est='".$sel_filtro_est."'";//print $sql_nota.'<br>';
		$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		if(isset($rs_i->fields['recomendaciones']))
		{
			$upd_nota="UPDATE recomendaciones_mejoras_lec_tut SET recomendaciones='".$recomendaciones."', mejoras='".$mejoras."' WHERE id_periodo_lectivo='".$sel_filtro_recom."' AND id_curso_grado_paralelo_est='".$sel_filtro_est."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		else
		{
			$ins_sql='INSERT INTO recomendaciones_mejoras_lec_tut(recomendaciones, mejoras, id_periodo_lectivo, id_curso_grado_paralelo_est)
			VALUES("'.$recomendaciones.'","'.$mejoras.'","'.$sel_filtro_recom.'","'.$sel_filtro_est.'")';//print $ins_sql;die();
			$db->Execute($ins_sql) or die($db->ErrorMsg());
		}
	}
	elseif($tipo=='p_' AND $sel_filtro_est!='')
	{
		$sql_i="SELECT recomendaciones, mejoras
		FROM recomendaciones_mejoras_per_tut
		WHERE 1
		AND recomendaciones_mejoras_per_tut.id_periodo_evaluativo='".$sel_filtro_recom."'
		AND recomendaciones_mejoras_per_tut.id_curso_grado_paralelo_est='".$sel_filtro_est."'";//print $sql_nota.'<br>';
		$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		if(isset($rs_i->fields['recomendaciones']))
		{
			$upd_nota="UPDATE recomendaciones_mejoras_per_tut SET recomendaciones='".$recomendaciones."', mejoras='".$mejoras."' WHERE id_periodo_evaluativo='".$sel_filtro_recom."' AND id_curso_grado_paralelo_est='".$sel_filtro_est."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		else
		{
			$ins_sql='INSERT INTO recomendaciones_mejoras_per_tut(recomendaciones, mejoras, id_periodo_evaluativo, id_curso_grado_paralelo_est)
			VALUES("'.$recomendaciones.'","'.$mejoras.'","'.$sel_filtro_recom.'","'.$sel_filtro_est.'")';//print $ins_sql;die();
			$db->Execute($ins_sql) or die($db->ErrorMsg());
		}
	}
	elseif($tipo=='s_' AND $sel_filtro_est!='')
	{
		$sql_i="SELECT recomendaciones, mejoras
		FROM recomendaciones_mejoras_sub_tut
		WHERE 1
		AND recomendaciones_mejoras_sub_tut.id_subperiodo_evaluativo='".$sel_filtro_recom."'
		AND recomendaciones_mejoras_sub_tut.id_curso_grado_paralelo_est='".$sel_filtro_est."'";//print $sql_nota.'<br>';
		$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		if(isset($rs_i->fields['recomendaciones']))
		{
			$upd_nota="UPDATE recomendaciones_mejoras_sub_tut SET recomendaciones='".$recomendaciones."', mejoras='".$mejoras."' WHERE id_subperiodo_evaluativo='".$sel_filtro_recom."' AND id_curso_grado_paralelo_est='".$sel_filtro_est."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		else
		{
			$ins_sql='INSERT INTO recomendaciones_mejoras_sub_tut(recomendaciones, mejoras, id_subperiodo_evaluativo, id_curso_grado_paralelo_est)
			VALUES("'.$recomendaciones.'","'.$mejoras.'","'.$sel_filtro_recom.'","'.$sel_filtro_est.'")';//print $ins_sql;die();
			$db->Execute($ins_sql) or die($db->ErrorMsg());
		}
	}
}
?>