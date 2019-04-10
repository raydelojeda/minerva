<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)
//print $_POST['prin'];
if(isset($_POST['ide']))
{
//print 'si entra';
	include($x."pag/rrhh/persona/variables.php");
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	
	$sql_c="SELECT id_cliente FROM persona,cliente WHERE persona.id_persona=cliente.id_persona AND persona.id_persona='".$return[1]."'";//print $sql_c;
	$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
	
	$sql_p="SELECT concat(primer_nombre,' ',segundo_nombre) AS nombres, concat(primer_apellido,' ', segundo_apellido) AS apellidos, identificacion, direccion, telefono1 
	FROM persona WHERE persona.id_persona='".$return[1]."'";//print $sql_p;
	$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());//print $rs_p;
	
	if(!isset($rs_c->fields[0]))
	{
		$ins="INSERT INTO cliente (factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, permite_credito, id_persona) 
		VALUES ('".$rs_p->fields['nombres']."','".$rs_p->fields['apellidos']."','".$rs_p->fields['identificacion']."','".$rs_p->fields['direccion']."','".$rs_p->fields['telefono1']."','1','".$return[1]."')";//print $i_sql."<br>";
		$db->Execute($ins) or die($db->ErrorMsg());
	}
	else
	{
		$upd="UPDATE cliente SET factura_nombres='".$rs_p->fields['nombres']."',factura_apellidos='".$rs_p->fields['apellidos']."',factura_cedula='".$rs_p->fields['identificacion']."',
		factura_direccion='".$rs_p->fields['direccion']."',factura_telefono='".$rs_p->fields['telefono1']."',permite_credito='1' WHERE id_persona='".$return[1]."'";//print $upd;// die();
		$db->Execute($upd) or die($db->ErrorMsg());
	}
	
	include("variables.php");
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	//echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../ingreso_salida/new_ingreso_salida.php'</script>");
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script><script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

<div style='margin: 0 auto;width:95%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Datos personales</h2>			
			
			
			<?php
			print "<div style='float:right;'><input name='cedula' type='text' size='42' style='border: 0px; background-color:ffffff; text-decoration:italic;' onfocus='blur();'></div>";
			include($x."pag/rrhh/persona/variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
			
		</div>

		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Datos institucionales</h2>			
			
			
			<?php
			include("variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
			
		</div>
	</div>
</div>

<div class="center">
	
	<div id="modal_tit" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
			$evento[1]='';
			include($x."pag/rrhh/titulo/variables.php");
			$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
			print '<br>';			
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
		</div>
	</div>
	
	<div id="modal_inst" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
			include($x."pag/rrhh/inst_educativa/variables.php");
			$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
			print '<br>';			
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
		</div>
	</div>
	
	<div id="modal_dpto" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
			include($x."pag/rrhh/dpto/variables.php");
			$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
			print '<br>';			
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
		</div>
	</div>

</div>

<?php
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>

<script type="text/javascript">setupAllTabs();</script>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>