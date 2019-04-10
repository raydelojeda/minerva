<?php
include("../adodb519/adodb.inc.php");
include("../coneccion/conn.php");

$insertar='';
$mensaje='';
$msg='';

$sql_e="SELECT cliente.id_cliente,primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, grado, paralelo
FROM estudiante, persona, cliente, n_grado, n_paralelo, n_grado_paralelo, grado_paralelo_periodo, curso_grado_paralelo_est 
where estudiante.id_persona=persona.id_persona AND persona.id_persona=cliente.id_persona AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
AND n_grado_paralelo.id_grado=n_grado.id_grado AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo
AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo";
$rs_e=$db->Execute($sql_e) or print $mensaje.'<br>'.$db->ErrorMsg();



for($c=0;$c<$rs_e->RecordCount();$c++)
{ 
	
	$lin2='Estudiante: '.$rs_e->fields['primer_apellido'].' '.$rs_e->fields['segundo_apellido'].' '.$rs_e->fields['primer_nombre'].' '.$rs_e->fields['segundo_nombre'];
	$lin3='Curso: '.$rs_e->fields['grado'];
	$lin4='Paralelo: '.$rs_e->fields['paralelo'];
	
	$ref='PENSION\n'.$lin2.'\n'.$lin3.'\n'.$lin4;

	$ins="INSERT INTO referencia (id_cliente, id_punto_venta, referencia) 
	VALUES ('".$rs_e->fields['id_cliente']."','3','".$ref."')";//print $i_sql."<br>";
	$db->Execute($ins) or die($db->ErrorMsg());
	
$rs_e->MoveNext();
}
	
		
?>
