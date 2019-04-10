<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");
if(!isset($obj))$obj = new clases();// (NO TOCAR)

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{
	$id_clase_inasistencia=$_POST['campo2'];
	
	$sql_act="SELECT inasistencia FROM inasistencia_clase
	WHERE 1
	AND id_clase_inasistencia='".$id_clase_inasistencia."'";//print $sql_act;die();
	$rs_act=$db->Execute($sql_act) or die($db->ErrorMsg());
	
	if(!isset($rs_act->fields['inasistencia']))
	{			
		$del_sql='DELETE FROM clase_inasistencia WHERE id_clase_inasistencia="'.$id_clase_inasistencia.'"';//print $del_sql;
		$db->Execute($del_sql) or die($db->ErrorMsg());
		
		$mensaje='Datos eliminados satisfactoriamente.';
		$obj->Imprimir_mensaje($mensaje);
	}
	else
	{
		$mensaje='No se puede eliminar la fecha de clase ya que contiene inasistencias.';
		$obj->Imprimir_mensaje($mensaje);
	}
	$x='../../../';
	$clases_acad->contenido_asistencias($db, $x, $_POST['campo0'], $_POST['campo1']);
}
?>