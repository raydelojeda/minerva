<?php
include("../adodb519/adodb.inc.php");
include("../coneccion/conn.php");

$insertar='';
$mensaje='';
$msg='';

$sql="SELECT id_estudiante, estudiante.id_persona FROM estudiante, persona where estudiante.id_persona=persona.id_persona";
$rs=$db->Execute($sql) or print $mensaje.'<br>'.$db->ErrorMsg();



//print $rs->RecordCount();
//die();

$rs->MoveFirst();
for($c=0;$c<$rs->RecordCount();$c++)
{ //print '# de persona_copy: '.$c.'<br>';
	$id_estudiante=$rs->fields["id_estudiante"];
	$id_persona=$rs->fields["id_persona"];
	
	$sql_p="SELECT concat(primer_nombre,' ',segundo_nombre) AS nombres, concat(primer_apellido,' ', segundo_apellido) AS apellidos, identificacion, direccion, telefono1 
	FROM familiar_estudiante, familiar, persona where representante_eco='1' AND familiar_estudiante.id_familiar=familiar.id_familiar AND familiar.id_persona=persona.id_persona AND id_estudiante='".$id_estudiante."'";
	//print $sql_p.'<br>';
	$rs_p=$db->Execute($sql_p) or print $mensaje.'<br>'.$db->ErrorMsg();
	
	if(isset($rs_p->fields["nombres"]))
	{	
		$sql_c="SELECT id_cliente FROM persona,cliente WHERE persona.id_persona=cliente.id_persona AND persona.id_persona='".$id_persona."'";//print $sql_c;
		$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
		
		if(!isset($rs_c->fields[0]))
		{
			$ins="INSERT INTO cliente (factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, permite_credito, id_persona) 
			VALUES ('".$rs_p->fields['nombres']."','".$rs_p->fields['apellidos']."','".$rs_p->fields['identificacion']."','".$rs_p->fields['direccion']."','".$rs_p->fields['telefono1']."','0','".$id_persona."')";//print $i_sql."<br>";
			$db->Execute($ins) or die($db->ErrorMsg());
		}
		else
		{
			$upd="UPDATE cliente SET factura_nombres='".$rs_p->fields['nombres']."',factura_apellidos='".$rs_p->fields['apellidos']."',factura_cedula='".$rs_p->fields['identificacion']."',
			factura_direccion='".$rs_p->fields['direccion']."',factura_telefono='".$rs_p->fields['telefono1']."',permite_credito='0' WHERE id_persona='".$id_persona."'";//print $upd;// die();
			$db->Execute($upd) or die($db->ErrorMsg());
		}
	}
	else
	$msg=$msg.'id_estudiante: '.$id_estudiante.'<br>';

$rs->MoveNext();
}
		




print 'Repetidos:<br>'.$mensaje;	
		
?>
