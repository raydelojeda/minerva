<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

<?php 
$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);

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