<?php
include("../adodb519/adodb.inc.php");
include("../coneccion/conn.php");

$insertar='';
$mensaje='';
$msg='';

$sql="SELECT * FROM familiar_estudiante_copy";
$rs=$db->Execute($sql) or print $mensaje.'<br>'.$db->ErrorMsg();

//print $rs->RecordCount();
//die();

$rs->MoveFirst();
for($c=0;$c<$rs->RecordCount();$c++)
{ //print '# de persona_copy: '.$c.'<br>';
	$ced_fam=$rs->fields["ced_fam"];
	$ced_est=$rs->fields["ced_est"];
	$id_parentesco=$rs->fields["id_parentesco"];
	$representante_legal=$rs->fields["representante_legal"];
	$representante_aca=$rs->fields["representante_aca"];
	$representante_eco=$rs->fields["representante_eco"];
	$convive=$rs->fields["convive"];
	$puede_retirar=$rs->fields["puede_retirar"];
	$contacto_emergencia=$rs->fields["contacto_emergencia"];
	

	$sql_f="SELECT id_familiar FROM familiar, persona where familiar.id_persona=persona.id_persona AND identificacion='".$ced_fam."'";
	$rs_f=$db->Execute($sql_f) or print $mensaje.'<br>'.$db->ErrorMsg();
	
	if(isset($rs_f->fields["id_familiar"]))
	{	
		$id_familiar=$rs_f->fields["id_familiar"];
		
		$sql_e="SELECT id_estudiante FROM estudiante, persona where estudiante.id_persona=persona.id_persona AND identificacion='".$ced_est."'";
		$rs_e=$db->Execute($sql_e) or print $mensaje.'<br>'.$db->ErrorMsg();

		if(isset($rs_e->fields["id_estudiante"]))
		{
			$id_estudiante=$rs_e->fields["id_estudiante"];
			
			$sql_fe="INSERT INTO familiar_estudiante (id_familiar, id_estudiante, id_parentesco, representante_legal, representante_aca, representante_eco, convive, puede_retirar, contacto_emergencia) 
			VALUES ('".$id_familiar."','".$id_estudiante."','".$id_parentesco."','".$representante_legal."','".$representante_aca."','".$representante_eco."','".$convive."','".$puede_retirar."','".$contacto_emergencia."')";
			$db->Execute($sql_fe) or print $mensaje.'<br>'.$db->ErrorMsg();
		}
		else
		$msg=$msg.'est: '.$ced_est.'<br>';
	}
	else
	$msg=$msg.'fam: '.$ced_fam.'<br>';

$rs->MoveNext();
}
		




print 'Repetidos:<br>'.$mensaje;	
		
?>
