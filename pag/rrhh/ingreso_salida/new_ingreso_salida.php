<?php 


include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	
	$sql_i="SELECT COUNT(id_empleado) AS cant_empleado FROM ingreso_salida WHERE id_empleado=(SELECT id_empleado FROM ingreso_salida WHERE id_ingreso_salida=(SELECT MAX(id_ingreso_salida) AS id_ingreso_salida FROM ingreso_salida))";
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	$cant_empleado=$rs_i->fields['cant_empleado'];
	
	$sql_e="SELECT id_empleado FROM ingreso_salida WHERE id_ingreso_salida=(SELECT MAX(id_ingreso_salida) AS id_ingreso_salida FROM ingreso_salida)";
	$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());
	
	$id_empleado=$rs_e->fields['id_empleado'];
	
	if($cant_empleado % 2)
	$baja=0;
	else
	$baja=1;
	
	$upd="UPDATE empleado SET baja='".$baja."' WHERE id_empleado='".$id_empleado."'";//print $upd;// die();
	$db->Execute($upd) or die($db->ErrorMsg());
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