<?php
include("variables_planilla_matricula.php");

include($x."adodb519/adodb-pager.inc.php"); //paginationprint "yes";
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['var_aux']))
{//print $_POST['var_aux'];die();
	$id_estudiante=$_POST['var_aux'];
	
	$pos = strpos($id_estudiante, ',');
	if($pos)
	$id_estudiantes = explode(",",$id_estudiante);
	else
	$id_estudiantes[0]=$id_estudiante;
}
elseif(isset($_GET['id']))
{
	$id_estudiante=$_GET['id'];//die();

	$pos = strpos($id_estudiante, '-');
	if($pos)
	$id_estudiantes = explode("-",$id_estudiante);
	else
	$id_estudiantes[0]=$id_estudiante;
}

$obj = new clases(); // (NO TOCAR)
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
$obj->Validar_permiso($rs_sesion,$elemento,"Imprimir"); // (NO TOCAR)

if(!isset($tabla_anidada2))$tabla_anidada2='';if(!isset($campo_anidado2))$campo_anidado2='';if(!isset($where))$where='';

ob_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_sitio_imprimir;?>"/>
</head>

<body>
	<div align="center">
		<table class="tabla_contenido">
			<tr>
				<td class="contenido">

				<!--Inicio Contenido-->

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<?php
for($fila=0;$fila<count($id_estudiantes);$fila++)//para los estudiantes
{
	if($fila > 0){?><div style="page-break-before: always;"></div><?php }
	
	$sql="SELECT DISTINCT estudiante.id_estudiante, direccion_estudiante.nombre AS nombre_dir, calle_ppal, numero, calles_secundarias, sector, parroquia, canton, ciudad,
	concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as per, 
	identificacion, fecha_nacimiento, email, telefono1, telefono2, pais, tipo_sangre, residencia, lugar_nacimiento, colegio_proviene, n_periodo_academico.nombre, razones_cambio, tipo_vivienda,
	grado as grado, n_paralelo.id_paralelo as id_paralelo, paralelo as paralelo, fecha_admision as fecha_admision, fecha_retiro as fecha_retiro, 
	cumplido as cumplido, codigo_matricula, fecha_matricula, n_responsable_acta.nombre AS responsable_acta
	FROM estudiante,persona,curso_grado_paralelo_est,n_pais,n_genero,n_tipo_sangre,n_tipo_identificacion,
	n_periodo_academico,n_grado,n_paralelo,n_seccion_academica,n_tipo_grado,grado_paralelo_periodo,n_grado_paralelo, n_responsable_acta, direccion_estudiante
	WHERE 1 AND estudiante.id_estudiante=direccion_estudiante.id_estudiante
	AND estudiante.id_persona=persona.id_persona AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND n_pais.id_pais=persona.id_pais 
	AND n_genero.id_genero=persona.id_genero AND n_tipo_sangre.id_tipo_sangre=persona.id_tipo_sangre AND n_tipo_identificacion.id_tipo_identificacion=persona.id_tipo_identificacion 
	AND grado_paralelo_periodo.id_grado_paralelo_periodo=curso_grado_paralelo_est.id_grado_paralelo_periodo
	AND n_grado_paralelo.id_tipo_grado=n_tipo_grado.id_tipo_grado AND n_grado_paralelo.id_grado=n_grado.id_grado AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica 
	AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo 
	AND n_periodo_academico.id_periodo_academico=grado_paralelo_periodo.id_periodo_academico AND n_responsable_acta.id_responsable_acta=n_grado_paralelo.id_responsable_acta
	AND estudiante.id_estudiante='".$id_estudiantes[$fila]."' order by per DESC";//print $sql;die();
	$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;

	$sql_f="SELECT parentesco, primer_apellido, segundo_apellido, primer_nombre, segundo_nombre, identificacion, fecha_nacimiento, direccion, email, telefono1, telefono2,
	profesion, ocupacion, empresa_oficina, dir_trabajo, tel_trabajo, representante_legal, representante_aca, representante_eco, convive, puede_retirar, contacto_emergencia
	FROM familiar_estudiante, familiar, n_parentesco, persona WHERE 1 AND familiar.id_persona=persona.id_persona AND familiar_estudiante.id_parentesco=n_parentesco.id_parentesco 
	AND familiar_estudiante.id_familiar=familiar.id_familiar AND familiar_estudiante.id_estudiante='".$id_estudiantes[$fila]."'";
	$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
?>

	<div style='padding-left:7%;padding-top:10%;' align="center">
		<div style='display:table;width:98%;'>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:center;padding-left:3%;font-size:14px;font-weight:bold;'>ACTA DE MATR&Iacute;CULA</div>
			</div>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:center;padding-left:3%;FONT-SIZE: 10px'>PER&Iacute;ODO ACAD&Eacute;MICO: <?php echo $rs->fields['nombre'];?></div>
			</div>
		</div>
		
		<div style='display:table;width:98%;'>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;width:25%;text-align:right;font-size:12px;font-weight:bold;'>No. Matr&iacute;cula:</div>
				<div style='display:table-cell;height:18px;width:10%;text-align:left;padding-left:5px;FONT-SIZE: 12px'><?php echo $rs->fields['codigo_matricula'];?></div>
				<div style='display:table-cell;height:18px;width:10%;text-align:right;font-size:12px;font-weight:bold;'>Folio:</div>
				<div style='display:table-cell;height:18px;width:10%;text-align:left;padding-left:5px;FONT-SIZE: 12px'><?php echo $rs->fields['codigo_matricula'];?></div>
				<div style='display:table-cell;height:18px;width:25%;text-align:right;font-size:12px;font-weight:bold;'>Fecha de matr&iacute;cula:</div>
				<div style='display:table-cell;height:18px;width:20%;text-align:left;padding-left:5px;FONT-SIZE: 12px'><?php echo $rs->fields['fecha_matricula'];?></div>
			</div>
		</div>
		<br>
		<div style='display:table;width:100%;'>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:left;padding-left:3%;font-size:14px;font-weight:bold;'>Estudiante: <?php echo strtoupper($rs->fields['per']);?></div>
			</div>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:left;padding-left:3%;font-size:14px;font-weight:bold;'>Grado/curso: <?php echo strtoupper($rs->fields['grado'].' '.$rs->fields['paralelo']);?></div>
			</div>
		</div>
		<br>
		<div style='display:table;width:100%;'>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Nacimiento:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs->fields['fecha_nacimiento'];?></div>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Lugar:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs->fields['lugar_nacimiento'];?></div>
			</div>
			
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;width:25%;text-align:right;font-size:10px;font-weight:bold;'>Pa&iacute;s de nacimiento:&nbsp;</div>
				<div style='display:table-cell;height:18px;width:48%;text-align:left;font-size:10px;'><?php echo $rs->fields['pais'];?></div>
				<div style='display:table-cell;height:18px;width:13%;text-align:right;font-size:10px;font-weight:bold;'>Tel&eacute;fono:&nbsp;</div>
				<div style='display:table-cell;height:18px;width:14%;text-align:left;font-size:10px;'><?php echo $rs->fields['telefono1'];?></div>			
			</div>
			
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Domicilio:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php $domicilio='('.$rs->fields['nombre_dir'].') '.$rs->fields['calle_ppal'].', '.$rs->fields['numero'];if($rs->fields['calles_secundarias']!='')$domicilio.=', '.$rs->fields['calles_secundarias'];if($rs->fields['sector']!='')$domicilio.=', '.$rs->fields['sector'];if($rs->fields['parroquia']!='')$domicilio.=', '.$rs->fields['parroquia'];if($rs->fields['canton']!='')$domicilio.=', '.$rs->fields['canton'];if($rs->fields['ciudad']!='')$domicilio.=', '.$rs->fields['ciudad'];print $domicilio;?></div>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Celular:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs->fields['telefono2'];?></div>
			</div>
		
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Residencia:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if($rs->fields['residencia']==1)print 'Si';else print 'No';?></div>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Correo:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs->fields['email'];?></div>
			</div>
			
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Plantel de procedencia:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs->fields['colegio_proviene'];?></div>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Tipo sangre:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs->fields['tipo_sangre'];?></div>
			</div>
		<?php /*
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Razones del cambio:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs->fields['razones_cambio'];?></div>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'>Arrendada:&nbsp;</div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if($rs->fields['tipo_vivienda']==1)print 'Si';else print 'No';?></div>
			</div>
			*/?>
		</div>
		
		<br>
		
		<div style='display:table;width:100%;'>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php echo strtoupper($rs_f->fields['parentesco']);?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php echo strtoupper($rs_f->fields['parentesco']);?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'></div>			
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['primer_apellido']))print 'Nombre:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['primer_apellido'].' '.$rs_f->fields['segundo_apellido'].' '.$rs_f->fields['primer_nombre'].' '.$rs_f->fields['segundo_nombre'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['primer_apellido']))print 'Nombre:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['primer_apellido'].' '.$rs_f->fields['segundo_apellido'].' '.$rs_f->fields['primer_nombre'].' '.$rs_f->fields['segundo_nombre'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;width:15%;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['fecha_nacimiento']))print 'Fecha Nac.:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;width:35%;text-align:left;font-size:10px;'><?php echo $rs_f->fields['fecha_nacimiento'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;width:15%;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['fecha_nacimiento']))print 'Fecha Nac.:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;width:35%;text-align:left;font-size:10px;'><?php echo $rs_f->fields['fecha_nacimiento'];?></div>			
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['profesion']))print 'Profesi&oacute;n:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['profesion'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['profesion']))print 'Profesi&oacute;n:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['profesion'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['direccion']))print 'Domicilio:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['direccion'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['direccion']))print 'Domicilio:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['direccion'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['telefono1']))print 'Tel&eacute;fono:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['telefono1'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['telefono1']))print 'Tel&eacute;fono:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['telefono1'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['telefono2']))print 'Celular:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['telefono2'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['telefono2']))print 'Celular:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['telefono2'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['empresa_oficina']))print 'Trabajo:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['empresa_oficina'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['empresa_oficina']))print 'Trabajo:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['empresa_oficina'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['dir_trabajo']))print 'Dir. trabajo:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['dir_trabajo'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['dir_trabajo']))print 'Dir. trabajo:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['dir_trabajo'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['tel_trabajo']))print 'Tel. trabajo:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['tel_trabajo'];?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['tel_trabajo']))print 'Tel. trabajo:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php echo $rs_f->fields['tel_trabajo'];?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['representante_legal']))print 'R. Legal:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['representante_legal'])){if($rs_f->fields['representante_legal']==1)print 'Si';elseif($rs_f->fields['representante_legal']==0) print 'No';}?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['representante_legal']))print 'R. Legal:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['representante_legal'])){if($rs_f->fields['representante_legal']==1)print 'Si';elseif($rs_f->fields['representante_legal']==0) print 'No';}?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['representante_aca']))print 'R. Acad.:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['representante_aca'])){if($rs_f->fields['representante_aca']==1)print 'Si';elseif($rs_f->fields['representante_aca']==0) print 'No';}?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['representante_aca']))print 'R. Acad.:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['representante_aca'])){if($rs_f->fields['representante_aca']==1)print 'Si';elseif($rs_f->fields['representante_aca']==0) print 'No';}?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['representante_eco']))print 'R. Econ.:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['representante_eco'])){if($rs_f->fields['representante_eco']==1)print 'Si';elseif($rs_f->fields['representante_eco']==0) print 'No';}?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['representante_eco']))print 'R. Econ.:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['representante_eco'])){if($rs_f->fields['representante_eco']==1)print 'Si';elseif($rs_f->fields['representante_eco']==0) print 'No';}?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['convive']))print 'Convive:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['convive'])){if($rs_f->fields['convive']==1)print 'Si';elseif($rs_f->fields['convive']==0) print 'No';}?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['convive']))print 'Convive:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['convive'])){if($rs_f->fields['convive']==1)print 'Si';elseif($rs_f->fields['convive']==0) print 'No';}?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['puede_retirar']))print 'Puede retirar?:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['puede_retirar'])){if($rs_f->fields['puede_retirar']==1)print 'Si';elseif($rs_f->fields['puede_retirar']==0) print 'No';}?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['puede_retirar']))print 'Puede retirar?:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['puede_retirar'])){if($rs_f->fields['puede_retirar']==1)print 'Si';elseif($rs_f->fields['puede_retirar']==0) print 'No';}?></div>
			</div>
			<?php $rs_f->MoveFirst();?>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['contacto_emergencia']))print 'Emergencia:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['contacto_emergencia'])){if($rs_f->fields['contacto_emergencia']==1)print 'Si';elseif($rs_f->fields['contacto_emergencia']==0) print 'No';}?></div>
				<?php $rs_f->MoveNext();?>
				<div style='display:table-cell;height:18px;text-align:right;font-size:10px;font-weight:bold;'><?php if(isset($rs_f->fields['contacto_emergencia']))print 'Emergencia:&nbsp;';?></div>
				<div style='display:table-cell;height:18px;text-align:left;font-size:10px;'><?php if(isset($rs_f->fields['contacto_emergencia'])){if($rs_f->fields['contacto_emergencia']==1)print 'Si';elseif($rs_f->fields['contacto_emergencia']==0) print 'No';}?></div>
			</div>
		</div>
		<br><br><br>
		
		<?php
		$repres='';
		$rs_f->MoveFirst();
		for($f=1;$f<=2;$f++) 
		{
			if(isset($rs_f->fields['representante_aca']))
			{
				if($rs_f->fields['representante_aca']==1)
				{
					$repres=$rs_f->fields['primer_apellido'].' '.$rs_f->fields['segundo_apellido'].' '.$rs_f->fields['primer_nombre'].' '.$rs_f->fields['segundo_nombre'];
					$f=2;
				}
			}
		$rs_f->MoveNext();
		}
		?>
		
		<div style='display:table;width:100%;'>
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;width:50%;text-align:center;font-size:10px;font-weight:bold;'><?php print strtoupper($repres);?></div>
				<div style='display:table-cell;height:18px;width:50%;text-align:center;font-size:10px;font-weight:bold;'><?php print strtoupper($rs->fields['responsable_acta']);?></div>
			</div>
			
			<div style='display:table-row;'>
				<div style='display:table-cell;height:18px;text-align:center;font-size:10px;font-weight:bold;'><?php print 'REPRESENTANTE';?></div>
				<div style='display:table-cell;height:18px;text-align:center;font-size:10px;font-weight:bold;'><?php echo 'SECRETAR&Iacute;A'?></div>
			</div>
		</div>
		
	</div>

	<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
}

include($x."plantillas/imp_footer.php");

require_once($x."include/dompdf/vendor/autoload.php");
require_once($x."include/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml(ob_get_clean());
ini_set("memory_limit","1024M");  
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('Libreta de '.strtoupper($rs->fields['per']).' - '.$rs->fields['nombre']);
?>
<script language="javascript"  type="text/javascript">
/*window.print();
location.href='lis_estudiante.php?mensaje=Datos guardados satisfactoriamente.';*/
</script>