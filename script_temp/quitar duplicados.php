<?php
include("../adodb519/adodb.inc.php");
include("../coneccion/conn.php");

$insertar='';
$mensaje='';

$sql="SELECT * FROM persona_copy";
$rs=$db->Execute($sql) or print $mensaje.'<br>'.$db->ErrorMsg();

$rs->MoveFirst();
for($c=0;$c<$rs->RecordCount();$c++)
{
	$identificacion=$rs->fields["identificacion"];

	$sql_p="SELECT * FROM persona_copy where identificacion='".$identificacion."'";
	$rs_p=$db->Execute($sql_p) or print $db->ErrorMsg();
	
	if(isset($rs_p->fields["identificacion"]));
	{
		$rs_p->MoveFirst();
		$rs_p->MoveNext();
		
		for($p=1;$p<$rs_p->RecordCount();$p++)
		{
			$id_persona=$rs_p->fields["id_persona"];
			$sql_del="delete from persona_copy where id_persona='".$id_persona."'";print $sql_del.'<br>';
			$rs_del=$db->Execute($sql_del) or print $db->ErrorMsg();
		
		$rs_p->MoveNext();
		}
	}
$rs->MoveNext();
}
		




print 'Repetidos:<br>'.$mensaje;	
		
?>
