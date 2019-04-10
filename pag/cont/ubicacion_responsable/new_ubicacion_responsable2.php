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

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

&nbsp;
<br>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Art&iacute;culo</h2>			
			
			
			<?php
			include($x."pag/cont/articulo/variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			?>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Atributos</h2>			
			
			<div style='display:table;width:98%;'>
			
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:50%;text-align:left;padding-left: 3%;'></div>
					<div style='display:table-cell;height:22px;width:50%;text-align:left;'></div>
				</div>
			
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:50%;text-align:left;padding-left: 3%;'>Atributo</div>
					<div style='display:table-cell;height:22px;width:50%;text-align:left;'>Valor</div>
				</div>
				
				<?php
				$sql_f="SELECT id_atributo, atributo FROM n_atributo";
				$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
				
				for($f=1;$f<=5;$f++) 
				{						
				?>
				<div id='fam_<?php print $f;?>' style='display:<?php if($f>2)print 'none';else print 'table-row';?>;'>
					
					<div style='display:table-cell;height:25px;text-align:left;padding-left: 3%;'>
						<select class="js-basic-single_atr_<?php echo $f;?>" name="sel_atr_<?php print $f;?>" id="sel_atr_<?php print $f;?>">
							<option>----------------------Seleccionar----------------------</option>
							<?php $rs_f->MoveFirst();for($e=0;$e<$rs_f->RecordCount();$e++){?>					
								<option value="<?php print $rs_f->fields['id_atributo'];?>"> <?php print $rs_f->fields['atributo'];?> </option>						
							<?php $rs_f->MoveNext();}?>
						</select>&nbsp;<a href="#modal_atr<?php print $f;?>"><img src="<?php print $x.'img/general/agregar.png';?>";></a>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<input type="text" size="60" name="txt_valor_<?php print $f;?>" id="txt_valor_<?php print $f;?>"/>
					</div>					
				</div>
				
				<?php 
				}					
				?>
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;padding-left: 3%;'><a onclick='javascript:agregar();'><div class='boton' style='display:height:22px;width:110px;text-align:center;'>+ Agregar</div></a></div>
				</div>
			</div>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Inventario</h2>			
			
			
			<?php
			print "<div id='div_responsable' class='div_exp'></div>";
			include($x."pag/cont/inventario/variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
			?>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Movimiento</h2>			
			
			
			<?php
			print "<div id='div_responsable' class='div_exp'></div>";
			include($x."pag/cont/ubicacion_responsable/variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
			?>
			
		</div>
	</div>
</div>





<div class="center">
	<div id="modal0" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
			include($x."pag/cont/subgrupo/variables.php");
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
	
	<div id="modal1" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
			include($x."pag/cont/marca/variables.php");
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
	
	<div id="modal2" class="modalmask">
		<div class="modalbox movedown">			
			<?php
			include($x."pag/cont/modelo/variables.php");
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
	<?php
	for($a=1;$a<=5;$a++) 
	{			
	?>
	<div id="modal_atr<?php print $a;?>" class="modalmask">
		<div class="modalbox movedown">			
			<?php
			include($x."pag/cont/atributo/variables_".$a.".php");
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
	<?php
	}						
	?>
	
	<div id="modal0" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<?php
			include($x."pag/cont/estado/variables.php");
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
	
	<div id="modal1" class="modalmask">
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
	
	<div id="modal2" class="modalmask">
		<div class="modalbox movedown">			
			<?php
			include($x."pag/cont/tipo_depreciacion/variables.php");
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