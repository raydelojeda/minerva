<?php 
include("variables.php");

include($x."plantillas/lis_header.php");
include($x."pag/clases_pag.php");
$obj_div = new clases_div();
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>

<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );

function marcar()
{	
	arr_a = String(document.frm.var_checkbox1.value).split(","); //alert(document.frm.var_checkbox.value);
	chequeado = eval("document.frm.checkbox_a.checked");
	for (i=0;i<arr_a.length;i++)
	{//alert (arr_a[i]);
	eval('checkbox = document.frm.checkbox_'+arr_a[i]);
	
	  if (chequeado)
	 checkbox.checked = true; 
	 else
	 checkbox.checked = false; 
	}
	
	arr_a = String(document.frm.var_checkbox2.value).split(","); //alert(document.frm.var_checkbox.value);
	chequeado = eval("document.frm.checkbox_b.checked");
	for (i=0;i<arr_a.length;i++)
	{//alert (arr_a[i]);
	eval('checkbox = document.frm.checkbox_'+arr_a[i]);
	
	  if (chequeado)
	 checkbox.checked = true; 
	 else
	 checkbox.checked = false; 
	} 
}
</script>

&nbsp;
<br>
<?php 

// declaraciones
$colspan=sizeof($campos)+3;
// declaraciones
								
$datos=$pager->Render($rows_per_page=$ver);								
$rs=$datos[0];
$sig_ant=$datos[1];
$cant_pag=$datos[2];

if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);						

?>
<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Bandeja de entrada</h2>			
			
			
			<div style='display:table;width:100%;'>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:30%;text-align:left;padding-left: 1%;'>
					
						<?php
						
							print "<div style='display:table;width:100%;' class='tabla_listar'>";
							print "<div style='display:table-row;'>";
							print "<div style='display:table-cell;' class='contenido' colspan='".$colspan."'>";

							//$obj_div->Filtro($sel_filtro2,$txt_filtro2,$sel_filtro,$txt_filtro,$filtros,$sig_ant,$cant_pag,$ver,$colspan,'1');// filtros del listar
							$obj_div->Encabezado($campos,$elemento,$order,$ordtype,$ordtypestr,$x,'a');// encabezados de columnas							
							$cadenacheckboxp1=$obj_div->Filas($db,$elemento,$rs,$pag,$l_info_emergente,$cadenacheckboxp,$combo_sql,$alias_col,$opt_value,$opt_sel,$opt_name,$info_emerg,$columna,$info_col,$field_col,$href_m,$rs_sesion,$var_mod,$id_cadenacheckboxp,$x,$ancho,'',$columna_suma);// generacion de filas
						?>
					</div>					
				</div>
			</div>	
		</div>
		
<?php

include("variables_enviados.php");	
if(!isset($tabla_anidada2))$tabla_anidada2='';if(!isset($campo_anidado2))$campo_anidado2='';if(!isset($where))$where='';if(!isset($operador))$operador='';if(!isset($select))$select='';

$l_sql=$obj->Consulta_listar($field,$alias_col,$tabla,$tabla_anidada,$campo_anidado,$tabla_anidada2,$campo_anidado2,$where,$info_col,$operador,$select);//
include($x."plantillas/listar.php");//print $l_sql;
$pager = new ADODB_Pager($db,$l_sql,'','',$x);

$datos=$pager->Render($rows_per_page=$ver);								
$rs=$datos[0];
$sig_ant=$datos[1];
$cant_pag=$datos[2];
?>		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Enviados</h2>
			
			<div style='display:table;width:100%;'>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:30%;text-align:left;padding-left: 1%;'>
						<?php 
							$obj_div->Filtro($sel_filtro2,$txt_filtro2,$sel_filtro,$txt_filtro,$filtros,$sig_ant,$cant_pag,$ver,$colspan,'2');// filtros del listar
							$obj_div->Encabezado($campos,$elemento,$order,$ordtype,$ordtypestr,$x,'b');// encabezados de columnas							
							$cadenacheckboxp2=$obj_div->Filas($db,$elemento,$rs,$pag,$l_info_emergente,$cadenacheckboxp,$combo_sql,$alias_col,$opt_value,$opt_sel,$opt_name,$info_emerg,$columna,$info_col,$field_col,$href_m,$rs_sesion,$var_mod,$id_cadenacheckboxp,$x,$ancho,'',$columna_suma);// generacion de filas
						?>
					</div>					
				</div>
			</div>	
		</div>
		<?php  
		if($cadenacheckboxp1!='' AND $cadenacheckboxp2!='')$cadenacheckboxp=$cadenacheckboxp1.','.$cadenacheckboxp2;
		elseif($cadenacheckboxp1!='' AND $cadenacheckboxp2=='') $cadenacheckboxp=$cadenacheckboxp1;
		elseif($cadenacheckboxp1=='' AND $cadenacheckboxp2!='') $cadenacheckboxp=$cadenacheckboxp2;
		?>
	</div>					
</div>

<script type="text/javascript">setupAllTabs();</script>
<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/lis_footer.php");
?>