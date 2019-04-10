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

//--------------LLENAR CAJAS PARA PERSONA--------------
$sql_p="SELECT id_persona FROM empleado WHERE id_empleado='".$mod."'";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$id_persona=$rs_p->fields['id_persona'];
include($x."pag/rrhh/persona/variables.php");

$s_rs2=$obj->Consulta_llenar_cajas($id_persona,$insert_field,$tabla,$db,$columna,$insert_alias);
//--------------LLENAR CAJAS PARA PERSONA--------------

if(!$s_rs OR !$s_rs2)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_empleado.php'</script>");


if(isset($_POST[$inputs[0]['name_input']]))
{
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$id_persona,$tipo_input,$value_input,$x);
	$obj->Imprimir_mensaje($mensaje);
	
	$sql_c="SELECT id_cliente FROM persona,cliente WHERE persona.id_persona=cliente.id_persona AND persona.id_persona='".$id_persona."'";
	$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
	
	$sql_p="SELECT concat(primer_nombre,' ',segundo_nombre) AS nombres, concat(primer_apellido,' ', segundo_apellido) AS apellidos, identificacion, direccion, telefono1 
	FROM persona WHERE persona.id_persona='".$id_persona."'";//print $sql_p;
	$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());//print $rs_p;
	
	if(!isset($rs_c->fields[0]))
	{
		$ins="INSERT INTO cliente (factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, permite_credito, id_persona) 
		VALUES ('".$rs_p->fields['nombres']."','".$rs_p->fields['apellidos']."','".$rs_p->fields['identificacion']."','".$rs_p->fields['direccion']."','".$rs_p->fields['telefono1']."','1','".$id_persona."')";//print $i_sql."<br>";
		$db->Execute($ins) or die($db->ErrorMsg());
	}
	else
	{
		$upd="UPDATE cliente SET factura_nombres='".$rs_p->fields['nombres']."',factura_apellidos='".$rs_p->fields['apellidos']."',factura_cedula='".$rs_p->fields['identificacion']."',
		factura_direccion='".$rs_p->fields['direccion']."',factura_telefono='".$rs_p->fields['telefono1']."',permite_credito='1' WHERE id_persona='".$id_persona."'";//print $upd;// die();
		$db->Execute($upd) or die($db->ErrorMsg());
	}
	
	$return[1]=$id_persona;//print $return[1];
	include("variables.php");
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
	$obj->Imprimir_mensaje($mensaje);
	
	if(!$mensaje)
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php?mensaje=Datos guardados satisfactoriamente.'</script>");
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
			print "<div style='position:absolute;right:10%;z-index:5;valign:top;'><input name='cedula' type='text' size='42' style='border: 0px; background-color:ffffff; text-decoration:italic;' onfocus='blur();'></div>";
			?>
			
			<div style='position:absolute;right:1%;z-index:5;'>			
				<?php
				include($x."pag/rrhh/persona/variables.php");
				
				$camp=$s_rs2->fields[$field_col[20]];			
				if(base64_encode($camp))
				echo '<img style="margin:3px;border-radius:8px;" width="100px" src="data:image/jpeg;base64,'. base64_encode($camp). '"/>';
				else
				echo '<img style="margin:3px;border-radius:8px;" width="100px" src="'.$x.'img/general/no_disponible.png"/>';
				?>			
			</div>
			
			<?php
			include($x."pag/rrhh/persona/variables.php");
			$obj->Generar_inputs($inputs,$s_rs2,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
			
		</div>
		
		<script language="JavaScript" type="text/javascript">
			valida_cedula();
		</script>

		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Datos institucionales</h2>			
			
			
			<?php
			include("variables.php");
			$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
			
		</div>
	</div>
</div>

<div class="center">
	
	<div id="modal_tit" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
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
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>