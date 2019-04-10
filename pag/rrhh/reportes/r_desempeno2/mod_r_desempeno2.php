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

$hoy=date("Y-m-d");
$sql_des="SELECT id_desempeno FROM desempeno, n_periodo WHERE 1 AND desempeno.id_periodo=n_periodo.id_periodo AND fecha_conclusion>='".$hoy."' AND id_desempeno='".$mod."'";//print $sql_des;
$rs_des=$db->Execute($sql_des) or die($db->ErrorMsg());//print $rs_des;

if($rs_des->fields['id_desempeno']=='')
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");

$s_rs=$obj->Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias);
if(!$s_rs)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");


if(isset($_POST[$inputs[5]['name_input']]))
{
	$sql_eval="SELECT valor_e FROM n_evaluacion WHERE id_evaluacion='".$_POST[$inputs[5]['name_input']]."'";
	$rs_eval=$db->Execute($sql_eval) or die($db->ErrorMsg());
	$valor_e=$rs_eval->fields['valor_e'];

	/*$sql_pond="SELECT valor_p FROM n_ponderacion WHERE id_ponderacion='".$_POST[$inputs[6]['name_input']]."'";
	$rs_pond=$db->Execute($sql_pond) or die($db->ErrorMsg());
	$valor_p=$rs_pond->fields['valor_p'];*/

	//------------------------Cálculo------------------------
	//------------------------Cálculo------------------------
	//------------------------Cálculo------------------------
	//$resultado_cri=round(bcdiv(bcmul($valor_e, $valor_p, 14), 100, 14),2);
	//------------------------Cálculo------------------------
	//------------------------Cálculo------------------------
	//------------------------Cálculo------------------------

	$u_sql="UPDATE desempeno SET id_evaluacion='".$_POST['cod_eval']."', resultado_cri='".$valor_e."', fecha='".$_POST['fecha']."' WHERE id_desempeno='".$mod."'";
	$db->Execute($u_sql) or $mensaje=$db->ErrorMsg();
	//print $u_sql;die();
	if(!$mensaje)
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php'</script>");
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
&nbsp;
<br>
<?php 
$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);//$input son las cajas de texto y $s_rs es el recordset para mostrar los datos en las cajas de texto
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>