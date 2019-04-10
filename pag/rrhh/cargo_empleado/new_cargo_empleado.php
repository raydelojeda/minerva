<?php 


include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	
	$sql_id="SELECT MAX(id_cargo_empleado) AS id_cargo_empleado FROM cargo_empleado";
	$rs_id=$db->Execute($sql_id) or die($db->ErrorMsg());
	
	$id_cargo_empleado=$rs_id->fields['id_cargo_empleado'];
	
	$sql_i="SELECT id_empleado, id_cargo FROM cargo_empleado WHERE id_cargo_empleado='".$id_cargo_empleado."'";
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	$id_empleado=$rs_i->fields['id_empleado'];
	$id_cargo=$rs_i->fields['id_cargo'];
	
	$upd="UPDATE cargo_empleado SET activo='". 0 ."' WHERE id_empleado='".$id_empleado."' AND id_cargo_empleado!='".$id_cargo_empleado."'";//print $upd; die();
	$db->Execute($upd) or die($db->ErrorMsg());
	
	//$upd="UPDATE cargo_empleado SET activo='". 0 ."' WHERE id_cargo='".$id_cargo."' AND id_cargo_empleado!='".$id_cargo_empleado."'";//print $upd; die();
	//$db->Execute($upd) or die($db->ErrorMsg());
	
	//echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../".$elemento."/new_".$elemento.".php?mensaje=Datos guardados correctamente'</script>");
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