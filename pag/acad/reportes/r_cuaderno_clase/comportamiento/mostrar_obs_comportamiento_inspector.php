<?php
$x='../../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../../inspectoria/inspectoria.php");
$inspectoria = new inspectoria();

if(isset($_POST['campo0']))
{	
	$id_clase=$_POST['campo0'];
	$id_subperiodo_evaluativo=$_POST['campo1'];
	$id_estudiante=$_POST['campo2'];
	
	$sql_est="SELECT curso_grado_paralelo_est.id_curso_grado_paralelo_est, clase.nombre, clase_estudiante.id_clase_estudiante, estudiante.id_estudiante, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
	FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, clase_estudiante, clase
	WHERE 1
	AND clase_estudiante.id_clase=clase.id_clase
	AND per_estudiante.id_persona=estudiante.id_persona
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
	AND curso_grado_paralelo_est.id_curso_grado_paralelo_est=clase_estudiante.id_curso_grado_paralelo_est
	AND curso_grado_paralelo_est.id_estudiante='".$id_estudiante."'
	AND clase_estudiante.id_clase='".$id_clase."'";//print $sql_est;
	$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
	
	$sql_sub="SELECT subperiodo_evaluativo, abv_subperiodo FROM n_subperiodo_evaluativo	WHERE id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'";//print $sql_i.'<br>';
	$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());
	
	if($rs_est->fields['estudiante'])
	{
		$id_curso_grado_paralelo_est=$rs_est->fields['id_curso_grado_paralelo_est'];
?>

		<fieldset>
			<legend>Comportamental del <b>inspector</b> para el <b><?php print $rs_est->fields['estudiante'].'</b> en el <b>'.$rs_sub->fields['subperiodo_evaluativo'].' ('.$rs_sub->fields['abv_subperiodo'].')';?></b></legend>

			<fieldset>
				<legend>Listado de observaciones de comportamiento</legend>		
				<div id='div_listado_obs'>					
					<?php $inspectoria->mostrar_obs_comportamiento($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo, '1', '1', '../../../../', '0');?>
				</div>

				<?php //print $rs_obs->fields['observacion'];?>
			</fieldset>
		</fieldset>
<?php
	}
}
?>