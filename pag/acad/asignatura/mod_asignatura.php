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
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php?mensaje=Datos guardados satisfactoriamente.'</script>");

if(isset($_POST[$inputs[0]['name_input']]))
{
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
	if(!$mensaje)
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php?mensaje=Datos guardados satisfactoriamente.'</script>");
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<script type="text/javascript">
function aporta_promedios()
{

	if(document.frm.aporta_promedio.value==1)
	{
		var combo = document.forms["frm"].cuantitativa;
		var cantidad = combo.length;
		for (i = 0; i < cantidad; i++)
		{
			if(combo[i].value == 1)
			{
				combo[i].selected = true;
				$("#cuantitativa").prop("disabled", true);

				var field = document.getElementById("cuantitativa");
				field.id = "cuantitativa1";  // using element properties
				field.setAttribute("name", "cuantitativa1");
				
				$("#cuantitativa1").select2();
			}
		}
		
		combo = document.forms["frm"].mostrar_reportes_ofic;
		cantidad = combo.length;
		for (i = 0; i < cantidad; i++)
		{
			if(combo[i].value == 1)
			{
				combo[i].selected = true;
				$("#mostrar_reportes_ofic").prop("disabled", true);
				
				var field = document.getElementById("mostrar_reportes_ofic");
				field.id = "mostrar_reportes_ofic1";  // using element properties
				field.setAttribute("name", "mostrar_reportes_ofic1");
				
				$("#mostrar_reportes_ofic1").select2();
				
				var micapa = document.getElementById('div_contenedor');
				micapa.innerHTML='<input type="hidden" value="1" name="cuantitativa" /><input type="hidden" value="1" name="mostrar_reportes_ofic" />';
			}
		}	
	}
	else
	{
		var micapa = document.getElementById('div_contenedor');
		micapa.innerHTML='';
		
		var field = document.getElementById("cuantitativa1");
		if(field)
		{
			field.id = "cuantitativa";  // using element properties
			field.setAttribute("name", "cuantitativa");
		}
		
		$("#cuantitativa").prop("disabled", false);
		$("#cuantitativa").select2();
		
		var field = document.getElementById("mostrar_reportes_ofic1");
		if(field)
		{
			field.id = "mostrar_reportes_ofic";  // using element properties
			field.setAttribute("name", "mostrar_reportes_ofic");
		}
		
		$("#mostrar_reportes_ofic").prop("disabled", false);
		$("#mostrar_reportes_ofic").select2();
		
		
	}
}
</script>
&nbsp;
<br>
<div id='div_contenedor'></div>
<?php 
$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);//$input son las cajas de texto y $s_rs es el recordset para mostrar los datos en las cajas de texto
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>
<script type="text/javascript">
aporta_promedios();
</script>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>