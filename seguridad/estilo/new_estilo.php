<?php 


include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	
	$sql_u="SELECT MAX(id_usuario) AS id_usuario, clave FROM usuario";
	$rs_u=$db->Execute($sql_u) or die($db->ErrorMsg());
	
	$id_usuario=$rs_u->fields['id_usuario'];
	$clave=$rs_u->fields['clave'];
	
	$sql_u="UPDATE usuario SET clave='".md5($clave)."' WHERE id_usuario='".$id_usuario."'";//print $sql_u;
	$db->Execute($sql_u) or die($db->ErrorMsg());
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

<?php 
$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>