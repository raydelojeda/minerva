<?php
include("variables.php");
include($x."plantillas/mod_header.php");
if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}

$sql="SELECT id_libro FROM prestamo WHERE id_prestamo='".$mod."'";//print $sql; die();
$rs=$db->Execute($sql) or die($db->ErrorMsg());

$id_libro=$rs->fields['id_libro'];

$combo_sql[4] = "select id_libro as ID_L, concat(no_ficha,' - ',titulo) as LIB FROM libro WHERE 1 AND (prestado='0' OR id_libro='".$id_libro."') AND baja='0'";



if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

$s_rs=$obj->Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias);

if(!$s_rs)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");

//print $s_rs;
if(isset($_POST[$inputs[0]['name_input']]))
{
	if(strtotime($_POST['F_PRES'])<=strtotime($_POST['F_DEV']))
	{	
		$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
		
		if($s_rs->fields['ID_L']!=$_POST['LIB'])
		{
			$upd="UPDATE libro SET prestado='". 0 ."' WHERE id_libro='".$s_rs->fields['ID_L']."'";//print $upd; die();
			$db->Execute($upd) or die($db->ErrorMsg());
		
			$upd="UPDATE libro SET prestado='". 1 ."' WHERE id_libro='".$_POST['LIB']."'";//print $upd; die();
			$db->Execute($upd) or die($db->ErrorMsg());
		}
		if(!$mensaje)
		echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");
	}
	else
	$mensaje='La fecha de devoluci&oacute;n debe ser mayor que fecha de pr&eacute;stamo.';
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
&nbsp;
<br>
<?php 
$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);//$input son las cajas de texto y $s_rs es el recordset para mostrar los datos en las cajas de texto
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>