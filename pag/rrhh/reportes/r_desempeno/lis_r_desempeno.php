<?php 
include("variables.php");
include($x."plantillas/lis_header_nueva.php");
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>
<?php
include($x."config/clases.php");
$obj_nuevo = new clases_nuevas();

$colspan=sizeof($campos)+3;
$rs_sesion->MoveFirst();							
$permiso=$obj->Validar_mostrar_btn($rs_sesion,$elemento,'Editar');
							
$dir="pag/rrhh/reportes/r_desempeno";
$txt_filtro='';
$pag=1;
$ver=10;
$campo_orden='';
$asc_desc='';
$x_include=$x;//print  $l_sql;
						
$cadenacheckboxp=$obj_nuevo->listado($db, $x_include, $x, $dir, $txt_filtro, $pag, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, '', '');// generacion de filas

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
include($x."plantillas/lis_footer_nueva.php");
?>