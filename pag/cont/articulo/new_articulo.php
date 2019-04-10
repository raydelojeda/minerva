<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	if($_POST[$inputs[0]['name_input']]!='')
	{
		include($x."pag/cont/articulo/variables.php");
		$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
		
		if(isset($return[1]) AND $return[1]!='')
		{	
			$id_articulo=$return[1];
			for($f=1;$f<=5;$f++) 
			{//print 'uno:'.$f.'<br>';
				if(isset($_POST['sel_atr_'.$f]))
				{//print 'dos:'.$f.'<br>';
					if($_POST['sel_atr_'.$f]!=0)
					{//print 'tres:'.$f.'<br>';
						if(isset($_POST['txt_valor_'.$f]))
						{//print 'cuatro:'.$f.'<br>';
							if($_POST['txt_valor_'.$f]!='')
							{//print 'cinco:'.$f.'<br>';
								$sel_atr=$_POST['sel_atr_'.$f];
								$txt_valor=$_POST['txt_valor_'.$f];
								
								$ins="INSERT INTO articulo_atributo (id_articulo, id_atributo, valor_atributo) 
								VALUES ('".$id_articulo."','".$sel_atr."','".$txt_valor."')";//print $ins."<br>";
								$db->Execute($ins) or die($db->ErrorMsg());
							}
						}
					}
				}
			}		
		}
	}
	
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
$mensaje='';
$return[0]='';	
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
&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

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
			
			
			<?php
			include($x."pag/cont/articulo/variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			
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

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>