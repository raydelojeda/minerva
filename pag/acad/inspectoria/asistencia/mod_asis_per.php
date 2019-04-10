<?php
$x='../../../../';
include($x."pag/acad/clase_inasistencia/variables_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../inspectoria.php");
$obj_inspectoria = new inspectoria();

if(isset($_POST['campo0']))
{
	$id_curso_grado_paralelo_est=$_POST['campo0'];
	$fecha_ini=$_POST['campo1'];
	$fecha_fin=$_POST['campo2'];
	$inasis_insp=$_POST['campo3'];
	$obs_insp=$_POST['campo4'];
	
	$id_estudiante=$_POST['campo5'];
	$id_grado=$_POST['campo6'];
	$id_paralelo=$_POST['campo7'];
	$fecha=$_POST['campo8'];
	
/*	$sql_i="SELECT inasistencia, id_inasistencia_clase FROM clase_estudiante, inasistencia_clase, clase_inasistencia WHERE clase_estudiante.id_clase_estudiante=inasistencia_clase.id_clase_estudiante 
	AND inasistencia_clase.id_clase_inasistencia=clase_inasistencia.id_clase_inasistencia
	AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' AND clase_inasistencia.fecha>='".$fecha_ini."' AND clase_inasistencia.fecha<='".$fecha_fin."'";print $sql_i.'<br>';
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	for($e=0;$e<$rs_i->RecordCount();$e++)
	{	
		if(isset($rs_i->fields['inasistencia']))
		{
			$upd_nota="UPDATE inasistencia_clase SET inasistencia_inspector='".$inasis_insp."', observacion_inspector='".$obs_insp."' 
			WHERE id_inasistencia_clase='".$rs_i->fields['id_inasistencia_clase']."'";print $upd_nota.'<br>';
			$db->Execute($upd_nota) or die($db->ErrorMsg());
		}
	$rs_i->MoveNext();
	}*/

	$sql_c="SELECT id_clase, id_clase_estudiante FROM clase_estudiante WHERE retirado='0' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_c.'<br>';
	$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
	
	for($c=0;$c<$rs_c->RecordCount();$c++)
	{
		$sql_f="SELECT id_clase_inasistencia FROM clase_inasistencia WHERE id_clase='".$rs_c->fields['id_clase']."' 
		AND clase_inasistencia.fecha>='".$fecha_ini."' AND clase_inasistencia.fecha<='".$fecha_fin."'";//print $sql_f.'<br>';
		$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
		
		for($f=0;$f<$rs_f->RecordCount();$f++)
		{
			if(isset($rs_f->fields['id_clase_inasistencia']))
			{
				$sql_i="SELECT id_inasistencia_clase FROM inasistencia_clase WHERE id_clase_inasistencia='".$rs_f->fields['id_clase_inasistencia']."'
				AND id_clase_estudiante='".$rs_c->fields['id_clase_estudiante']."'";//print $sql_i.'<br>';
				$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
				
				if(isset($rs_i->fields['id_inasistencia_clase']))
				{
					$upd_nota="UPDATE inasistencia_clase SET inasistencia_inspector='".$inasis_insp."', observacion_inspector='".$obs_insp."' 
					WHERE id_inasistencia_clase='".$rs_i->fields['id_inasistencia_clase']."'";//print $upd_nota.'<br>';
					$db->Execute($upd_nota) or die($db->ErrorMsg());
				}
				else
				{
					$ins_sql='INSERT INTO inasistencia_clase(id_clase_inasistencia, id_clase_estudiante, inasistencia, a_clase, observacion, inasistencia_inspector, observacion_inspector)
					VALUES("'.$rs_f->fields['id_clase_inasistencia'].'","'.$rs_c->fields['id_clase_estudiante'].'","0","1","", "'.$inasis_insp.'","'.$obs_insp.'")';//print $ins_sql;//die();
					$db->Execute($ins_sql) or die($db->ErrorMsg());
				}
			}
		$rs_f->MoveNext();
		}
	
	$rs_c->MoveNext();
	}

	$obj_inspectoria->contenido_asistencias($db, $id_estudiante, $id_grado, $id_paralelo, $fecha);
}
?>