<?php
if(isset($_POST['campo0']))
{
	$sel_filtro_asis=$_POST['campo5'];
	$x='../../../../';
	//include($x."pag/acad/clase_inasistencia/variables.php");

	include($x."config/variables.php");
	include($x."config/clases.inc.php");

	include("../../clases_acad.php");
	$clases_acad = new clases_acad();

	$ins_sql='INSERT INTO clase_inasistencia(id_clase, id_subperiodo_evaluativo, fecha, tema_impartir)
	VALUES("'.$_POST['campo0'].'","'.$_POST['campo1'].'","'.$_POST['campo2'].'","'.$_POST['campo3'].'")';//print $ins_sql;die();
	$db->Execute($ins_sql) or die($db->ErrorMsg());
	
	$i_sql="SELECT LAST_INSERT_ID() AS myid";
	$rs_i=$db->Execute($i_sql) or die($db->ErrorMsg());
	
	$x='../../../';
	$clases_acad->contenido_asistencias($db, $x, $_POST['campo0'], $_POST['campo1']);
}
?>