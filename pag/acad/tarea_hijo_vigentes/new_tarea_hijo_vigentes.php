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
$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>

<br>
<script type="text/javascript">
aporta_promedios();
</script>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>