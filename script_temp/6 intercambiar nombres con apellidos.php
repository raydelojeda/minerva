<?php
include("../adodb519/adodb.inc.php");
include("../coneccion/conn.php");

$insertar='';
$mensaje='';
$msg='';

$sql="SELECT id_estudiante, estudiante.id_persona, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
FROM estudiante, persona where estudiante.id_persona=persona.id_persona";
$rs=$db->Execute($sql) or print $mensaje.'<br>'.$db->ErrorMsg();



//print $rs->RecordCount();
//die();

$rs->MoveFirst();
for($c=0;$c<$rs->RecordCount();$c++)
{
	$id_estudiante=$rs->fields["id_estudiante"];
	$id_persona=$rs->fields["id_persona"];
	
	$primer_nombre=$rs->fields["primer_nombre"];
	$segundo_nombre=$rs->fields["segundo_nombre"];
	$primer_apellido=$rs->fields["primer_apellido"];
	$segundo_apellido=$rs->fields["segundo_apellido"];
	
	
	$upd="UPDATE persona SET primer_nombre='".$rs->fields['primer_apellido']."',segundo_nombre='".$rs->fields['segundo_apellido']."',primer_apellido='".$rs->fields['primer_nombre']."',
	segundo_apellido='".$rs->fields['segundo_nombre']."' WHERE id_persona='".$id_persona."'";//print $upd;// die();
	$db->Execute($upd) or die($db->ErrorMsg());
		

$rs->MoveNext();
}
		


		
?>
