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

$s_rs=$obj->Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias);

if(!$s_rs)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");


if(isset($_POST[$inputs[0]['name_input']]))
{
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
	if(!$mensaje)
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
&nbsp;
<br>
<?php
print "<div id='div_atributos' class='div_exp'></div>";

$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);//$input son las cajas de texto y $s_rs es el recordset para mostrar los datos en las cajas de texto
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>

<script language="JavaScript" type="text/javascript"><?php print 'ejecutar_ajax("'.$x.$camino.'/sel_atributos.php","cod_articulo","div_atributos")';?></script>

<div class="center">
	
	<div id="modal0" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
			include($x."pag/cont/proveedor/variables.php");
			$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
			print '<br>';			
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
		</div>
	</div>
	
</div>


<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>