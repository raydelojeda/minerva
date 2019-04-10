<?php
include("../adodb519/adodb.inc.php");
include("../coneccion/conn.php");

$insertar='';
$mensaje='';

$sql="SELECT * FROM persona_copy_copy";
$rs=$db->Execute($sql) or print $mensaje.'<br>'.$db->ErrorMsg();

//print $rs->RecordCount();
//die();

$rs->MoveFirst();
for($c=0;$c<$rs->RecordCount();$c++)
{ //print '# de persona_copy: '.$c.'<br>';
	$primer_nombre=$rs->fields["primer_nombre"];
	$segundo_nombre=$rs->fields["segundo_nombre"];
	$primer_apellido=$rs->fields["primer_apellido"];
	$segundo_apellido=$rs->fields["segundo_apellido"];
	$identificacion=$rs->fields["identificacion"];
	$fecha_nacimiento=$rs->fields["fecha_nacimiento"];
	$direccion=$rs->fields["direccion"];
	$email=$rs->fields["email"];
	$telefono1=$rs->fields["telefono1"];
	$telefono2=$rs->fields["telefono2"];
	$id_genero=$rs->fields["id_genero"];
	$id_pais=$rs->fields["id_pais"];
	$id_tipo_sangre=$rs->fields["id_tipo_sangre"];
	$id_tipo_identificacion=$rs->fields["id_tipo_identificacion"];

	$sql_p="SELECT * FROM persona where identificacion='".$identificacion."'";
	$rs_p=$db->Execute($sql_p) or print $mensaje.'<br>'.$db->ErrorMsg();
	
	if(!isset($rs_p->fields["id_persona"]))
	{
		$sql_i="INSERT INTO persona (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, identificacion, fecha_nacimiento, direccion, email, telefono1, telefono2 , residencia, id_genero, id_pais, id_tipo_sangre, id_tipo_identificacion) 
		VALUES ('".$primer_nombre."', '".$segundo_nombre."', '".$primer_apellido."', '".$segundo_apellido."', '".$identificacion."', '".$fecha_nacimiento."', '".$direccion."', '".$email."', '".$telefono1."', '".$telefono2."', '1', '".$id_genero."', '".$id_pais."', '".$id_tipo_sangre."', '".$id_tipo_identificacion."')";
		//print $sql_i.'<br>';
		$db->Execute($sql_i) or print $mensaje.'<br>'.$db->ErrorMsg();
		
		$i_sql="SELECT LAST_INSERT_ID() AS myid";
		$rs_i=$db->Execute($i_sql) or print $mensaje.'<br>'.$db->ErrorMsg();
		
		$id_persona=$rs_i->fields["myid"];
		
		$usuario=strtolower(substr($primer_nombre, 0, 1).substr($segundo_nombre, 0, 1).$primer_apellido);//print $usuario.'<br>';
		$clave='827ccb0eea8a706c4c34a16891f84e7b';
		
		$sql_user="SELECT id_persona FROM usuario where usuario='".$usuario."'";
		$rs_user=$db->Execute($sql_user) or print $mensaje.'<br>'.$db->ErrorMsg();
		
		if(isset($rs_user->fields["id_persona"]))
		$usuario=strtolower(substr($primer_nombre, 0, 1).substr($segundo_nombre, 0, 1).substr($primer_apellido, 0, 1).$segundo_apellido);//print $usuario.'<br>';
		
		$sql_f="SELECT id_persona FROM estudiante where id_persona='".$id_persona."'";
		$rs_f=$db->Execute($sql_f) or print $mensaje.'<br>'.$db->ErrorMsg();
		
		
		if(!isset($rs_f->fields["id_persona"]))
		{
			$sql_f="INSERT INTO estudiante (id_persona, tipo_vivienda) VALUES ('".$id_persona."', '0')";
			$db->Execute($sql_f) or print $mensaje.'<br>'.$db->ErrorMsg();
			
			$sql_u="SELECT id_persona FROM usuario where id_persona='".$id_persona."'";
			$rs_u=$db->Execute($sql_u) or print $mensaje.'<br>'.$db->ErrorMsg();
			
			if(!isset($rs_u->fields["id_persona"]))
			{
				$sql_f="INSERT INTO usuario (usuario, clave, activo, id_persona) VALUES ('".$usuario."','".$clave."','1','".$id_persona."')";
				$db->Execute($sql_f) or print $mensaje.'<br>'.$db->ErrorMsg();
				
				$i_sqlu="SELECT LAST_INSERT_ID() AS myid";
				$rs_iu=$db->Execute($i_sqlu) or print $mensaje.'<br>'.$db->ErrorMsg();
				
				$id_usuario=$rs_iu->fields["myid"];
				
				$sql_f="INSERT INTO usuario_rol (id_usuario, id_rol) VALUES ('".$id_usuario."','13')";
				$db->Execute($sql_f) or print $mensaje.'<br>'.$db->ErrorMsg();
			}
		}
		
	}
	elseif($identificacion!='')//es empleado
	{
		$sql_pp="SELECT * FROM persona, empleado where persona.id_persona=empleado.id_persona AND identificacion='".$identificacion."'";//print $sql_pp.'<br>';
		$rs_pp=$db->Execute($sql_pp) or print $db->ErrorMsg();
		
		if(isset($rs_pp->fields["id_persona"]))
		{
			$id_persona=$rs_pp->fields["id_persona"];
			$primer_nombre=$rs_pp->fields["primer_nombre"];
			$segundo_nombre=$rs_pp->fields["segundo_nombre"];
			$primer_apellido=$rs_pp->fields["primer_apellido"];
			
			$usuario=strtolower(substr($primer_nombre, 0, 1).substr($segundo_nombre, 0, 1).$primer_apellido);//print $usuario.'<br>';
			$clave='827ccb0eea8a706c4c34a16891f84e7b';
			
			$sql_user="SELECT id_persona FROM usuario where usuario='".$usuario."'";
			$rs_user=$db->Execute($sql_user) or print $mensaje.'<br>'.$db->ErrorMsg();
			
			if(isset($rs_user->fields["id_persona"]))
			$usuario=strtolower(substr($primer_nombre, 0, 1).substr($segundo_nombre, 0, 1).substr($primer_apellido, 0, 1).$segundo_apellido);//print $usuario.'<br>';
			
			$sql_f="SELECT id_persona FROM estudiante where id_persona='".$id_persona."'";
			$rs_f=$db->Execute($sql_f) or print $db->ErrorMsg();
			
			if(!isset($rs_f->fields["id_persona"]))
			{
				$sql_f="INSERT INTO estudiante (id_persona, tipo_vivienda) VALUES ('".$id_persona."','0')";
				$db->Execute($sql_f) or print $db->ErrorMsg();//print $sql_f.'<br>';
				
				$sql_u="SELECT * FROM usuario where id_persona='".$id_persona."'";
				$rs_u=$db->Execute($sql_u) or print $db->ErrorMsg();
				
				if(isset($rs_u->fields["id_usuario"]))
				{
					$id_usuario=$rs_u->fields["id_usuario"];

					$sql_f="INSERT INTO usuario_rol (id_usuario, id_rol) VALUES ('".$id_usuario."','13')";
					$db->Execute($sql_f) or print $db->ErrorMsg();
				}
			}
			else
			print 'ya estaba en estudiante: '.$identificacion.'<br>'; 
		}
	}
	else
	print 'identificacion: '.$identificacion.'<br>';
$rs->MoveNext();
}
		




print 'Repetidos:<br>'.$mensaje;	
		
?>
