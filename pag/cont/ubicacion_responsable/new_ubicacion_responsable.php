<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	$sql_a="SELECT MAX(fecha_mov) AS fecha, empleado.id_empleado FROM ubicacion_responsable, persona, empleado 
	WHERE 1 AND empleado.id_persona=persona.id_persona AND ubicacion_responsable.id_responsable=empleado.id_empleado AND id_inventario='".$_POST['no_inv']."' AND empleado.id_empleado='".$_POST['responsable']."'";//print $sql_a;
	$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());
	
	if(!isset($rs_a->fields['fecha']))
	{
		$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	}
	//echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../".$elemento."/new_".$elemento.".php?mensaje=Datos guardados correctamente'</script>");
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

<?php
print "<div id='div_responsable' class='div_exp'></div>";

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