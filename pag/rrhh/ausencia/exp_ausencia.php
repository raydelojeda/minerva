<?php
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
							
$datos=$pager->Render($rows_per_page=$ver);								
$rs=$datos[0];
//print $rs."<br>";//die();

if($rs)
$obj->Descargar_archivo($file,$objPHPExcel,$objWriter,$info_emerg,$columna,$alias_col,$rs,$obj,$titulo_listar,$info_col,'','');	
?>
<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/exp_footer.php");
?>

