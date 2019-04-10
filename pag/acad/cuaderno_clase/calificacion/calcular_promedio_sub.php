<?php
$x='../../../../';
//include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{
$id_clase=$_POST['campo0'];
$sel_filtro_cal=$_POST['campo1'];
$id_asignatura=$_POST['campo2'];
$sel_filtro_tip=$_POST['campo3'];
$filas=$_POST['filas'];

$fila = explode(",",$filas);//print $filas;die();
$sel_filtro_cal=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));

$prom='';

$sql_est="SELECT clase_estudiante.id_clase_estudiante, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
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
AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."'";
$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
}

for($e=0;$e<$rs_est->RecordCount();$e++)
{
	$suma_peso='';
	$promedio_pond='';
	$promedio_arit='';
	
	for($c=0;$c<count($fila);$c++)
	{
		if($e==$fila[$c])
		{
			$c=count($fila);			
			$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];//print $id_clase_estudiante;			
			$prom=$clases_acad->calcular_prom_subperiodo($db, $id_clase_estudiante, $sel_filtro_cal, $sel_filtro_tip);			
		}
	}
$rs_est->MoveNext();
}
print $prom['promedio'];

?>