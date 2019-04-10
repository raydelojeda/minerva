<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

if($visualizar==1)$disable='disabled style="background-color:#ddd"';else $disable='';

$repre_econ=0;

if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}

$s_rs=$obj->Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias);

//--------------LLENAR FAMILIARES--------------
$sql_fam="SELECT id_articulo_atributo, n_atributo.id_atributo, atributo, valor_atributo FROM n_atributo, articulo_atributo 
WHERE 1 AND n_atributo.id_atributo=articulo_atributo.id_atributo AND id_articulo='".$mod."'";//print $sql_fam;die();
$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());

//--------------LLENAR FAMILIARES--------------

if(!$s_rs OR !$rs_fam)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_articulo.php'</script>");

if(isset($_POST[$inputs[0]['name_input']]))
{
	include($x."pag/cont/articulo/variables.php");
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
	$obj->Imprimir_mensaje($mensaje);//print $mensaje;
	
	//----GUARDAR FAMILIARES----
	$rs_fam->MoveFirst();
	for($fam=1;$fam<=5;$fam++)
	{
		if(isset($_POST['sel_atr_'.$fam]))
		{
			if($_POST['sel_atr_'.$fam]!=0)
			{
				if(isset($_POST['txt_valor_'.$fam]))
				{
					if($_POST['txt_valor_'.$fam]!='')
					{
						$sel_atr_=$_POST['sel_atr_'.$fam];
						$txt_valor_=$_POST['txt_valor_'.$fam];
						
						if(isset($rs_fam->fields['id_articulo_atributo']))
						{
							$upd="UPDATE articulo_atributo SET id_atributo='".$sel_atr_."',valor_atributo='".$txt_valor_."' WHERE id_articulo_atributo='".$rs_fam->fields['id_articulo_atributo']."'";//print $upd.'<br>';// die();
							$db->Execute($upd) or die($db->ErrorMsg());				
						}
						else
						{
							$ins="INSERT INTO articulo_atributo (id_articulo,id_atributo, valor_atributo) 
							VALUES ('".$mod."','".$sel_atr_."','".$txt_valor_."')";print $ins."<br>";//die();
							$db->Execute($ins) or die($db->ErrorMsg());
						}						
					}
				}
			}
			elseif(isset($rs_fam->fields['id_articulo_atributo']))
			{
				$del="DELETE FROM articulo_atributo WHERE id_articulo_atributo='".$rs_fam->fields['id_articulo_atributo']."'";//print $del;// die();
				$db->Execute($del) or die($db->ErrorMsg());
			}
		}
	$rs_fam->MoveNext();
	}//die();
	//----GUARDAR FAMILIARES----
	
	echo "<script language='JavaScript' type='text/javascript'> location.href='lis_articulo.php?mensaje=Datos guardados satisfactoriamente.'</script>";
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<script type="text/javascript" class="js-code-basic">
$(document).ready(function() {
$(".js-basic-single_atr_1").select2();
$(".js-basic-single_atr_2").select2();
$(".js-basic-single_atr_3").select2();
$(".js-basic-single_atr_4").select2();
$(".js-basic-single_atr_5").select2();
});
</script>
<tr><td>
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script><script type="text/javascript">this.selectedIndex=1;tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

<script language="JavaScript" type="text/javascript">
function agregar() 
{
	for (i=3;i<=5;i++)
	{
		obj = document.getElementById('fam_' + i);//alert('fam_' + i);alert(obj.style.display);
		if(obj.style.display=='none')
		{
			obj.style.display = 'table-row';
			i=5;
		}
	}
}
</script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Art&iacute;culo</h2>			
			
			
			<div style='float:right;width:218px;'>			
				<?php
				include($x."pag/cont/articulo/variables.php");
				?>			
			</div>
			
			<?php
			$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
		</div>
		
		<div class="tab-page" id="tabPage3">
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
				
				$rs_fam->MoveFirst();
				for($f=1;$f<=5;$f++) 
				{						
				?>			
				<div id='fam_<?php print $f;?>' style='display:<?php if($f<3 OR isset($rs_fam->fields['id_atributo']))print 'table-row';else print 'none';?>;'>
					
					<div style='display:table-cell;height:22px;text-align:left;padding-left: 3%;'>
						<select <?php print $disable;?> class="js-basic-single_atr_<?php echo $f;?>" name="sel_atr_<?php print $f;?>" id="sel_atr_<?php print $f;?>">
							<option>----------------------Seleccionar----------------------</option>
							<?php $rs_f->MoveFirst();for($e=0;$e<$rs_f->RecordCount();$e++){?>					
								<option value="<?php print $rs_f->fields['id_atributo'];?>" <?php if($rs_f->fields['id_atributo']==$rs_fam->fields['id_atributo']){?> selected="selected"<?php }?>> <?php print $rs_f->fields['atributo'];?> </option>						
							<?php $rs_f->MoveNext();}?>
						</select>&nbsp;<a href="#modal_atr<?php print $f;?>"><img src="<?php print $x.'img/general/agregar.png';?>";></a>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<input <?php print $disable;?> type="text" size="60" name="txt_valor_<?php print $f;?>" id="txt_valor_<?php print $f;?>" value="<?php print $rs_fam->fields['valor_atributo'];?>">
					</div>					
				</div>
				
				<?php
				$rs_fam->MoveNext();
				}

				if($visualizar!=1)
				{
				?>
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;padding-left: 3%;'><a onclick='javascript:agregar();'><div class='boton' style='display:height:22px;width:110px;text-align:center;'>+ Agregar</div></a></div>
				</div>
				<?php }?>
			</div>
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
</div>


<script type="text/javascript">setupAllTabs();</script>
</td></tr>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>