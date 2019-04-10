<?php
$x='../../../';
//include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{//print $_POST['campo0'];die();
	$tipo_secc_per_clase = explode(",",$_POST['campo0']);
	
	for($c=0;$c<count($tipo_secc_per_clase);$c++)
	{
		$campo0 = explode("_",$tipo_secc_per_clase[$c]);
		
		$tipo=$campo0[0];
		$id_clase=$campo0[3];
		$id_periodo=$campo0[2];
		
		if($tipo=='s')
		{
			$sql_i="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";print $sql_i.'<br>';
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			if(isset($rs_i->fields['cerrado']))
			{
				if($rs_i->fields['cerrado']==0)
				{
					$upd_nota="UPDATE cierre_subperiodo_evaluativo SET cerrado='1' WHERE id_subperiodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";print $upd_nota.'<br>';
					$db->Execute($upd_nota) or die($db->ErrorMsg());
				}
				elseif($rs_i->fields['cerrado']==1)
				{
					$upd_nota="UPDATE cierre_subperiodo_evaluativo SET cerrado='0' WHERE id_subperiodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";print $upd_nota.'<br>';
					$db->Execute($upd_nota) or die($db->ErrorMsg());
				}
			}
			else
			{
				$ins_sql='INSERT INTO cierre_subperiodo_evaluativo(id_subperiodo_evaluativo, id_clase, cerrado)
				VALUES("'.$id_periodo.'","'.$id_clase.'","1")';print $ins_sql;die();
				$db->Execute($ins_sql) or die($db->ErrorMsg());
			}
		}
		elseif($tipo=='p')
		{
			$sql_i="SELECT cerrado FROM cierre_periodo_evaluativo WHERE 1 AND id_periodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $sql_nota.'<br>';
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			if(isset($rs_i->fields['cerrado']))
			{
				if($rs_i->fields['cerrado']==0)
				{
					$upd_nota="UPDATE cierre_periodo_evaluativo SET cerrado='1' WHERE id_periodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $upd_nota.'<br>';
					$db->Execute($upd_nota) or die($db->ErrorMsg());
				}
				elseif($rs_i->fields['cerrado']==1)
				{
					$upd_nota="UPDATE cierre_periodo_evaluativo SET cerrado='0' WHERE id_periodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $upd_nota.'<br>';
					$db->Execute($upd_nota) or die($db->ErrorMsg());
				}
			}
			else
			{
				$ins_sql='INSERT INTO cierre_periodo_evaluativo(id_periodo_evaluativo, id_clase, cerrado)
				VALUES("'.$id_periodo.'","'.$id_clase.'","1")';//print $ins_sql;die();
				$db->Execute($ins_sql) or die($db->ErrorMsg());
			}
		}
		elseif($tipo=='l')
		{
			$sql_i="SELECT cerrado FROM cierre_periodo_lectivo WHERE 1 AND id_periodo_lectivo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $sql_nota.'<br>';
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			if(isset($rs_i->fields['cerrado']))
			{
				if($rs_i->fields['cerrado']==0)
				{
					$upd_nota="UPDATE cierre_periodo_lectivo SET cerrado='1' WHERE id_periodo_lectivo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $upd_nota.'<br>';
					$db->Execute($upd_nota) or die($db->ErrorMsg());
				}
				elseif($rs_i->fields['cerrado']==1)
				{
					$upd_nota="UPDATE cierre_periodo_lectivo SET cerrado='0' WHERE id_periodo_lectivo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $upd_nota.'<br>';
					$db->Execute($upd_nota) or die($db->ErrorMsg());
				}
			}
			else
			{
				$ins_sql='INSERT INTO cierre_periodo_lectivo(id_periodo_lectivo, id_clase, cerrado)
				VALUES("'.$id_periodo.'","'.$id_clase.'","1")';//print $ins_sql;//die();
				$db->Execute($ins_sql) or die($db->ErrorMsg());
			}
		}
	}
}
?>