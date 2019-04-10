<?php 


include("variables.php");
include($x."plantillas/new_header.php");

$combo_sql[2] = "SELECT DISTINCT empleado.id_empleado as id_empleado, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado 
FROM persona,empleado,ingreso_salida WHERE empleado.id_persona=persona.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' 
AND NOT EXISTS (SELECT 1 FROM empleado_academico where empleado_academico.id_empleado=empleado.id_empleado) ORDER BY primer_apellido,segundo_apellido";

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	//echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../cargo_empleado/new_cargo_empleado.php'</script>");
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