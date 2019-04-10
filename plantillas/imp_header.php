<?php
include_once($x."adodb519/adodb-pager.inc.php"); //paginationprint "yes";
include_once($x."config/variables.php");
include_once($x."config/clases.inc.php");

$obj = new clases(); // (NO TOCAR)
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)

$obj->Validar_permiso($rs_sesion,$elemento,"Imprimir"); // (NO TOCAR)

if(!isset($tabla_anidada2))$tabla_anidada2='';if(!isset($campo_anidado2))$campo_anidado2='';if(!isset($where))$where='';if(!isset($operador))$operador='';if(!isset($select))$select='';
$l_sql=$obj->Consulta_listar($field,$alias_col,$tabla,$tabla_anidada,$campo_anidado,$tabla_anidada2,$campo_anidado2,$where,$info_col,$operador,$select);//die();
include_once($x."plantillas/listar.php");
$pager = new ADODB_Pager($db,$l_sql,'','',$x);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $titulo_sitio;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_sitio_imprimir;?>"/>
<link rel="shortcut icon" href="<?php echo $x.$fav_icon;?>"/> 
</head>

<script language="javascript" type="text/javascript" src="<?php echo $x.$js_general;?>"></script>

<body onload="window.print();">
	<div align="center">
		<table class="tabla_contenido">
			<tr>
				<td class="contenido"><div class="titulo"><?php echo $titulo_listar;?></div>
				<hr width="98%">
				<table align='center' class='tabla_listar'>
				<!--Inicio Contenido-->
								