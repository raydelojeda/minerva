<?php
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../inspectoria.php");
$inspectoria = new inspectoria();

if(isset($_POST['campo0']))
{	
	$id_nota_comportamental_sub_insp = $_POST['campo0'];
	$txt_fecha = $_POST['campo1'];
	$rbt_positiva = $_POST['campo2'];
	$rbt_destacada = $_POST['campo3'];
	$txt_nota = $_POST['campo4'];
	$txt_obs = $_POST['campo5'];
	$id_curso_grado_paralelo_est = $_POST['campo6'];
	$id_subperiodo_evaluativo = $_POST['campo7'];
	$hdn_modificar = $_POST['campo8'];
	$id_obs_comportamental_sub_insp = $_POST['campo9'];
	
	$id_grado = $_POST['campo10'];
	$id_paralelo = $_POST['campo11'];
	
	$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
	$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
	
	$nota_maxima=$rs_nota->fields['nota_maxima'];
	
	if($id_nota_comportamental_sub_insp=='')
	{
		$ins_nota="INSERT INTO nota_comportamental_sub_insp(nota, id_subperiodo_evaluativo, id_curso_grado_paralelo_est) VALUES('".$nota_maxima."','".$id_subperiodo_evaluativo."','".$id_curso_grado_paralelo_est."')";//print $ins_nota.'<br>';
		$db->Execute($ins_nota) or die($db->ErrorMsg());
		
		$i_sql="SELECT LAST_INSERT_ID() AS myid";
		$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
		
		$id_nota_comportamental_sub_insp = $rs->fields['myid'];
	}
	
	if($txt_nota!='' && $txt_obs!='' && $txt_fecha!='')
	{
		if($hdn_modificar=="0")
		{
			$ins_nota="INSERT INTO obs_comportamental_sub_insp(id_nota_comportamental_sub_insp, fecha, destacada, positiva, nota_perdida, observacion) 
			VALUES('".$id_nota_comportamental_sub_insp."','".$txt_fecha."','".$rbt_destacada."','".$rbt_positiva."','".$txt_nota."','".$txt_obs."')";//print $ins_nota.'<br>';
			$db->Execute($ins_nota) or die($db->ErrorMsg());
		}
		elseif($hdn_modificar=="1")
		{
			$upd_nota="UPDATE obs_comportamental_sub_insp SET fecha='".$txt_fecha."', destacada='".$rbt_destacada."', positiva='".$rbt_positiva."', nota_perdida='".$txt_nota."', observacion='".$txt_obs."'
			WHERE id_obs_comportamental_sub_insp='".$id_obs_comportamental_sub_insp."'";//print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
		
		$sql_obs="SELECT SUM(nota_perdida) AS nota_perdida FROM nota_comportamental_sub_insp, obs_comportamental_sub_insp 
		WHERE nota_comportamental_sub_insp.id_nota_comportamental_sub_insp=obs_comportamental_sub_insp.id_nota_comportamental_sub_insp
		AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' AND positiva='0'";//print $sql_obs.'<br>';
		$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
		
		$nota=$nota_maxima-$rs_obs->fields['nota_perdida'];//print $nota.' = '.$nota_maxima.' - '.$rs_obs->fields['nota_perdida'];
		
		$sql_obs="SELECT SUM(nota_perdida) AS nota_perdida FROM nota_comportamental_sub_insp, obs_comportamental_sub_insp 
		WHERE nota_comportamental_sub_insp.id_nota_comportamental_sub_insp=obs_comportamental_sub_insp.id_nota_comportamental_sub_insp
		AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' AND positiva='1'";//print $sql_obs.'<br>';
		$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
		
		$nota=$nota+$rs_obs->fields['nota_perdida'];//ganada
		
		if($nota>10)$nota=10;
		
		$upd_nota="UPDATE nota_comportamental_sub_insp SET nota='".$nota."' WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $upd_nota.'<br>';
		$db->Execute($upd_nota) or die($db->ErrorMsg());
	}
		
	$inspectoria->mostrar_obs_comportamiento($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo, $id_grado, $id_paralelo, '../../../', '1');
}
?>