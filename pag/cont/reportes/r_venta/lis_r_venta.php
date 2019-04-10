<?php
include("../../../clases_pag.php");
if(!isset($obj_r_saldo))$obj_r_saldo = new clases_extras();// (NO TOCAR)
include("variables.php");
include($x."plantillas/lis_header.php");
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

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

$obj->Filtro($sel_filtro2,$txt_filtro2,$sel_filtro,$txt_filtro,$filtros,$sig_ant,$cant_pag,$ver,$colspan);// filtros del listar

print '<tr><td height="35" class="tabla_filtro" colspan="'.$colspan.'"><div align="center">Factura inicial:<input name="txt_factura_ini" type="text" value="'.$txt_factura_ini.'" size="10" maxlength="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Factura final:<input name="txt_factura_fin" type="text"value="'.$txt_factura_fin.'" size="10" maxlength="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha inicial:<input name="txt_fecha_ini" type="text" onclick="displayCalendar(document.frm.txt_fecha_ini,\'yyyy-mm-dd\',this,\'\',\'\',\'submit\');"  value="'.$txt_fecha_ini.'" size="10" maxlength="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha final:<input name="txt_fecha_fin" type="text" onclick="displayCalendar(document.frm.txt_fecha_fin,\'yyyy-mm-dd\',this,\'\',\'\',\'submit\');"  value="'.$txt_fecha_fin.'" size="10" maxlength="10"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  onclick="document.frm.submit();"> <b> >>> Buscar >>> </b></a></div></td></tr>';

$obj->Encabezado($campos,$elemento,$order,$ordtype,$ordtypestr,$x);// encabezados de columnas							
$cadenacheckboxp=$obj->Filas($db,$elemento,$rs,$pag,$l_info_emergente,$cadenacheckboxp,$combo_sql,$alias_col,$opt_value,$opt_sel,$opt_name,$info_emerg,$columna,$info_col,$field_col,$href_m,$rs_sesion,$var_mod,$id_cadenacheckboxp,$x,$ancho,$obj_r_saldo, $columna_suma);// generacion de filas
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);						

?>
<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/lis_footer.php");
?>