<?php
$x='../../../../';
//include($x."pag/acad/actividad/variables.php");

include($x."config/variables.php");
include($x."config/clases.inc.php");
if(!isset($obj))$obj = new clases();
include("../../clases_acad.php");
$clases_acad = new clases_acad();
$mensaje='';

if(isset($_POST['campo0']))
{
	$id_clase=$_POST['campo0'];
	$id_tipo_actividad=$_POST['campo1'];
	$actividad_examen=$_POST['campo2'];
	$descripcion=$_POST['campo3'];
	$fecha=$_POST['campo4'];
	$sel_filtro_cal=$_POST['campo5'];
	$id_asignatura=$_POST['campo6'];
	$sel_filtro_tip=$_POST['campo7'];
	$fecha_ini=$_POST['campo8'];
	$fecha_fin=$_POST['campo9'];
	$opcional=$_POST['campo10'];
	$long_desc=addslashes($_POST['campo11']);//print 'longgg '.$_POST['campo11'];
	
	$sql_tip = "select visualizan_ppff FROM n_tipo_actividad WHERE 1 AND id_tipo_actividad='".$id_tipo_actividad."'";
	$rs_tip=$db->Execute($sql_tip) or die($db->ErrorMsg());
	
	if(isset($rs_tip->fields['visualizan_ppff']))
	{
		if($rs_tip->fields['visualizan_ppff']=='1')
		{
			if($fecha_ini!='' AND $fecha_fin!='')
			{
				$sql_est="SELECT clase_estudiante.id_clase_estudiante
				FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, clase_estudiante, clase, n_periodo_academico,
				empleado_academico, empleado
				WHERE 1
				AND per_estudiante.id_persona=estudiante.id_persona
				AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
				AND curso_grado_paralelo_est.id_curso_grado_paralelo_est=clase_estudiante.id_curso_grado_paralelo_est
				AND clase_estudiante.id_clase=clase.id_clase
				AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
				AND clase.id_empleado_academico=empleado_academico.id_empleado_academico 
				AND empleado_academico.id_empleado=empleado.id_empleado 
				AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."'";//print $sql_est;
				$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
				
				$ins_sql='INSERT INTO actividad(id_clase, id_tipo_actividad, actividad_examen, descripcion, fecha) 
				VALUES("'.$id_clase.'","'.$id_tipo_actividad.'","'.$actividad_examen.'","'.$descripcion.'","'.$fecha.'")';//print $ins_sql;
				$db->Execute($ins_sql) or die($db->ErrorMsg());
				
				$i_sql="SELECT LAST_INSERT_ID() AS myid";
				$rs_i=$db->Execute($i_sql) or die($db->ErrorMsg());
				
				$id_actividad=$rs_i->fields['myid'];
				
				$ins_sql='INSERT INTO tarea(fecha_ini, fecha_fin, opcional, descripcion, id_actividad) 
				VALUES("'.$fecha_ini.'","'.$fecha_fin.'","'.$opcional.'","'.$long_desc.'","'.$id_actividad.'")';//print '<br>'.$ins_sql;
				$db->Execute($ins_sql) or die($db->ErrorMsg());
				
				$i_sql="SELECT LAST_INSERT_ID() AS myid";
				$rs_i=$db->Execute($i_sql) or die($db->ErrorMsg());
				
				$id_tarea=$rs_i->fields['myid'];
				
				$rs_est->MoveFirst();		
				for($e=0;$e<$rs_est->RecordCount();$e++)
				{
					$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];
					
					$ins_sql='INSERT INTO tarea_estudiante(id_tarea, id_clase_estudiante, cumplida) 
					VALUES("'.$id_tarea.'","'.$id_clase_estudiante.'","0")';//print $ins_sql;
					$db->Execute($ins_sql) or die($db->ErrorMsg());
					
				$rs_est->MoveNext();
				}

				$origen="../../../../archivos/tareas/".$_SESSION['user']."/tmp/";
				$destino="../../../../archivos/tareas/".$_SESSION['user']."/".$id_tarea."/";					
				
				$directorio=opendir($origen);
				while ($archivo = readdir($directorio))
				{
					if (($archivo != '.') AND ($archivo != '..')) 
					{
						if(!file_exists($origen)) 
						mkdir($origen, 0777, true);
						
						if(!file_exists($destino)) 
						mkdir($destino, 0777, true);
						
						$archivo_origen = $origen.$archivo;
						$archivo_destino = $destino.$archivo;
						rename($archivo_origen, $archivo_destino);
						
						$ins_adj="INSERT INTO tarea_adjunto(id_tarea, nombre_adjunto) 
						VALUES ('".$id_tarea."','".utf8_decode($archivo)."')";
						$db->Execute($ins_adj) or die($db->ErrorMsg());
					}
				}
				closedir($directorio);
			}
			else
			$mensaje='Debe llenar las fechas de la Tarea en casa.';
		}
		else
		{
			$ins_sql='INSERT INTO actividad(id_clase, id_tipo_actividad, actividad_examen, descripcion, fecha) 
			VALUES("'.$id_clase.'","'.$id_tipo_actividad.'","'.$actividad_examen.'","'.$descripcion.'","'.$fecha.'")';//print $ins_sql;
			$db->Execute($ins_sql) or die($db->ErrorMsg());
		}
	}
	else
	{
		$ins_sql='INSERT INTO actividad(id_clase, id_tipo_actividad, actividad_examen, descripcion, fecha) 
		VALUES("'.$id_clase.'","'.$id_tipo_actividad.'","'.$actividad_examen.'","'.$descripcion.'","'.$fecha.'")';//print $ins_sql;
		$db->Execute($ins_sql) or die($db->ErrorMsg());
	}
}
$obj->Imprimir_mensaje($mensaje);

$x='../../../';
$clases_acad->contenido_calificaciones($db, $x, $id_clase, $sel_filtro_cal, $id_asignatura, $sel_filtro_tip);
?>