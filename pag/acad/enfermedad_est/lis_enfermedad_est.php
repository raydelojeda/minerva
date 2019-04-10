<?php 
include("variables.php");
include($x."plantillas/lis_header.php");
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>
<?php
/*$sql_nota="SELECT id_estudiante FROM estudiante";//print $sql_nota.'<br>';
$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());

for($e=0;$e<$rs_nota->RecordCount();$e++)
{

$ins_nota="INSERT INTO direccion_estudiante(direccion_ppal, nombre, calle_ppal, numero, id_estudiante) 
VALUES('1','Domicilio','Calle','#', '".$rs_nota->fields['id_estudiante']."')";//print $ins_nota.'<br>';
$db->Execute($ins_nota) or die($db->ErrorMsg());

$rs_nota->MoveNext();
}*/

// declaraciones
$colspan=sizeof($campos)+3;
// declaraciones
								
$datos=$pager->Render($rows_per_page=$ver);								
$rs=$datos[0];
$sig_ant=$datos[1];
$cant_pag=$datos[2];

$obj->Filtro($sel_filtro2,$txt_filtro2,$sel_filtro,$txt_filtro,$filtros,$sig_ant,$cant_pag,$ver,$colspan);// filtros del listar
$obj->Encabezado($campos,$elemento,$order,$ordtype,$ordtypestr,$x);// encabezados de columnas							
$cadenacheckboxp=$obj->Filas($db,$elemento,$rs,$pag,$l_info_emergente,$cadenacheckboxp,$combo_sql,$alias_col,$opt_value,$opt_sel,$opt_name,$info_emerg,$columna,$info_col,$field_col,$href_m,$rs_sesion,$var_mod,$id_cadenacheckboxp,$x,$ancho,'',$columna_suma);// generacion de filas

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