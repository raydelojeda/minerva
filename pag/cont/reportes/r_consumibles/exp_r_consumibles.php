<?php
include("../../../clases_pag.php");
if(!isset($obj_r_saldo))$obj_r_saldo = new clases_extras();// (NO TOCAR)

include("variables.php");
include($x."adodb519/toexport.inc.php");
include($x."plantillas/exp_header.php");
$objPHPExcel = new PHPExcel();
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

 
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>
<?php
$title = $titulo_sitio."-Listado-".$elemento;
$file = $title.".xlsx";

if(!isset($_POST['l_sql']))
{
	$datos=$pager->Render($rows_per_page=$ver);								
	$rs=$datos[0];
	$sig_ant=$datos[1];
	$cant_pag=$datos[2];
}
else
$rs=$db->Execute($_POST['l_sql']) or die($db->ErrorMsg());if($rs)
$obj->Descargar_archivo($file,$objPHPExcel,$objWriter,$info_emerg,$columna,$alias_col,$rs,$obj,$titulo_listar,$info_col,$db,$obj_r_saldo);
?>
<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/imp_footer.php");
?>