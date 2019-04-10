<?php
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{	
	$id_nota_comportamental_sub = $_POST['campo0'];
	$txt_fecha = $_POST['campo1'];
	$rbt_positiva = $_POST['campo2'];
	$rbt_destacada = $_POST['campo3'];
	$txt_nota = $_POST['campo4'];
	$txt_obs = $_POST['campo5'];
	$id_clase_estudiante = $_POST['campo6'];
	$id_subperiodo_evaluativo = $_POST['campo7'];
	$hdn_modificar = $_POST['campo8'];
	$id_obs_comportamental_sub = $_POST['campo9'];
	
	$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
	$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
	
	$nota_maxima=$rs_nota->fields['nota_maxima'];
	
	if($id_nota_comportamental_sub=='')
	{
		$ins_nota="INSERT INTO nota_comportamental_sub(nota, id_subperiodo_evaluativo, id_clase_estudiante) VALUES('".$nota_maxima."','".$id_subperiodo_evaluativo."','".$id_clase_estudiante."')";//print $ins_nota.'<br>';
		$db->Execute($ins_nota) or die($db->ErrorMsg());
		
		$i_sql="SELECT LAST_INSERT_ID() AS myid";
		$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
		
		$id_nota_comportamental_sub = $rs->fields['myid'];
	}
	
	if($txt_nota!='' && $txt_obs!='' && $txt_fecha!='')
	{
		if($hdn_modificar=="0")
		{
			$ins_nota="INSERT INTO obs_comportamental_sub(id_nota_comportamental_sub, fecha, destacada, positiva, nota_perdida, observacion) 
			VALUES('".$id_nota_comportamental_sub."','".$txt_fecha."','".$rbt_destacada."','".$rbt_positiva."','".$txt_nota."','".$txt_obs."')";//print $ins_nota.'<br>';
			$db->Execute($ins_nota) or die($db->ErrorMsg());
		}
		elseif($hdn_modificar=="1")
		{
			$upd_nota="UPDATE obs_comportamental_sub SET fecha='".$txt_fecha."', destacada='".$rbt_destacada."', positiva='".$rbt_positiva."', nota_perdida='".$txt_nota."', observacion='".$txt_obs."'
			WHERE id_obs_comportamental_sub='".$id_obs_comportamental_sub."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		
		$sql_obs="SELECT SUM(nota_perdida) AS nota_perdida FROM nota_comportamental_sub, obs_comportamental_sub 
		WHERE nota_comportamental_sub.id_nota_comportamental_sub=obs_comportamental_sub.id_nota_comportamental_sub
		AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_obs.'<br>';
		$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
		
		$nota=$nota_maxima-$rs_obs->fields['nota_perdida'];
		
		$upd_nota="UPDATE nota_comportamental_sub SET nota='".$nota."' WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $upd_nota.'<br>';
		$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		
	$clases_acad->mostrar_obs_comportamiento($db, $id_clase_estudiante, $id_subperiodo_evaluativo, '../../../', '1');
}
?>