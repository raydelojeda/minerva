<?php
include("variables.php");
include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection
include($x."config/clases.inc.php");
include($x.$_POST['camino']."/variables.php");

if(!empty($_POST['var_aux']))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
{
	$mensaje='';
	$var = explode(",",$_POST['var_aux']);		
	
	if(count($var) != 0)
	{
		for ($i = 0; $i < count($var); next($var), $i++) 
		{		
			$id = current($var);//print $id;die();
			
			/*$p_sql= "SELECT id_persona FROM estudiante WHERE id_estudiante='".$id."'";//print $d_sql;
			$p_rs=$db->Execute($p_sql);
			
			$id_persona=$p_rs->fields['id_persona'];
			
			$c_sql= "SELECT id_persona FROM estudiante WHERE id_persona='".$id_persona."'";//print $d_sql;
			$c_rs=$db->Execute($c_sql);
			
			$d_sql= "DELETE FROM familiar_estudiante WHERE id_estudiante='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();*/
			$sql_est_ant="SELECT curso_grado_paralelo_est.id_curso_grado_paralelo_est
			FROM curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico
			WHERE 1
			AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
			AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
			AND n_periodo_academico.activo='1' AND id_estudiante='".$id."'";//print $sql_est;
			$rs_est_ant=$db->Execute($sql_est_ant) or die($db->ErrorMsg());
			
			$id_curso_grado_paralelo_est=$rs_est_ant->fields['id_curso_grado_paralelo_est'];
		
			$d_sql= "DELETE FROM curso_grado_paralelo_est WHERE id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje=" Existen datos que dependen de lo que se desea eliminar.<br><br>";//.$db->ErrorMsg()
						
			/*$d_sql= "DELETE FROM ".$tabla." WHERE ".$field[0]."='".$id."'";//print $d_sql;
			$d_rs = $db->Execute($d_sql) or $mensaje.=" Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();*/
		}
	}
}
if(!$mensaje)
$mensaje=utf8_encode('Estudiantes desadmitidos correctamente para el período académico vigente.');
echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_estudiante.php?mensaje=".$mensaje."'</script>");
?>