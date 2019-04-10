<?php
//session_start(); // (NO TOCAR)
include_once($x."config/variables.php");
include_once($x."config/clases.inc.php");
$cadenacheckboxp="";

if(!isset($_SESSION["user"]))
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='".$x."seguridad/autenticacion.php?mensaje=".utf8_encode("Su sesión ha caducado.")."'</script>");

$obj = new clases(); // (NO TOCAR)
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $titulo_sitio;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_sitio;?>"/> 
<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_menu;?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_calendario;?>" media="screen"/>
<link rel="shortcut icon" href="<?php echo $x.$fav_icon;?>"/>

<link rel="stylesheet" href='<?php echo $x."js/alertify.js/themes/alertify.core.css";?>' />
<link rel="stylesheet" href='<?php echo $x."js/alertify.js/themes/alertify.default.css";?>' />
</head>

<script language="javascript" type="text/javascript" src="<?php echo $x.$js_menu;?>" ></script> 
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_tema_menu;?>" ></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_calendario;?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_info_emergente;?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_general;?>"></script>

<script type="text/javascript" src='<?php echo $x."js/alertify.js/lib/alertify.js";?>'></script>

<body>
<?php
	$obj->Header_menu($x,$img_banner,$nombre_empresa,$publicidad,$_SESSION["rol"],$camino_logout,$_SESSION["user"],$img_salir,$rs_sesion,$db);
?>
					<table class="tabla_contenido">
						<tr>
							<td  class="contenido">
							
							<!--Inicio Contenido-->