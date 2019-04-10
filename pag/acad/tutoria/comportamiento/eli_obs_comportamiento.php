<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../tutoria.php");
$tutoria = new tutoria();

if(isset($_POST['campo0']))
{
	$id_obs_comportamental_sub_tut=$_POST['campo0'];
	$id_curso_grado_paralelo_est=$_POST['campo1'];
	$id_subperiodo_evaluativo=$_POST['campo2'];
	
	$id_grado = $_POST['campo3'];
	$id_paralelo = $_POST['campo4'];
	
	$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
	$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
	
	$nota_maxima=$rs_nota->fields['nota_maxima'];

	$del_sql='DELETE FROM obs_comportamental_sub_tut WHERE id_obs_comportamental_sub_tut="'.$id_obs_comportamental_sub_tut.'"';//print $del_sql;
	$db->Execute($del_sql) or die($db->ErrorMsg());
	
	$sql_obs="SELECT SUM(nota_perdida) AS nota_perdida FROM nota_comportamental_sub_tut, obs_comportamental_sub_tut 
	WHERE nota_comportamental_sub_tut.id_nota_comportamental_sub_tut=obs_comportamental_sub_tut.id_nota_comportamental_sub_tut
	AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' AND positiva='0'";//print $sql_obs.'<br>';
	$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
	
	$nota=$nota_maxima-$rs_obs->fields['nota_perdida'];//print $nota.' = '.$nota_maxima.' - '.$rs_obs->fields['nota_perdida'];
	
	$sql_obs="SELECT SUM(nota_perdida) AS nota_perdida FROM nota_comportamental_sub_tut, obs_comportamental_sub_tut 
	WHERE nota_comportamental_sub_tut.id_nota_comportamental_sub_tut=obs_comportamental_sub_tut.id_nota_comportamental_sub_tut
	AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' AND positiva='1'";//print $sql_obs.'<br>';
	$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
	
	$nota=$nota+$rs_obs->fields['nota_perdida'];//ganada
	
	if($nota>10)$nota=10;
	
	$upd_nota="UPDATE nota_comportamental_sub_tut SET nota='".$nota."' WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $upd_nota.'<br>';
	$db->Execute($upd_nota) or die($db->ErrorMsg());

	$tutoria->mostrar_obs_comportamiento($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo, $id_grado, $id_paralelo, '../../../', '1');
}
?>