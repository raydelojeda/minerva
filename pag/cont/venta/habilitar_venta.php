<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}

if(!$mod)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");



if(!empty($mod))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
{ 
	$var = explode(",",$mod);		
	
	if(count($var) != 0)
	{
		for ($i = 0; $i < count($var); next($var), $i++) 
		{
		
			$id = current($var);
			
			$sql_n="select no_factura from venta where id_venta='".$id."'";//print "<br>".$sql_tar;
			$rs_n=$db->Execute($sql_n) or die($db->ErrorMsg());
			$no_factura=$rs_n->Fields("no_factura");
			
			$upd="UPDATE venta SET anulada='0' WHERE no_factura='".$no_factura."'";//print $upd; die();
			$db->Execute($upd) or die($db->ErrorMsg());
		} 		
	} 
}


echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
&nbsp;
<br>
<?php 
//$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);//$input son las cajas de texto y $s_rs es el recordset para mostrar los datos en las cajas de texto
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