<?php
include_once($x."config/variables.php");
include_once($x."config/clases.inc.php");

$obj = new clases(); // (NO TOCAR)
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)

$obj->Validar_permiso($rs_sesion,$elemento,"Insertar"); // (NO TOCAR)

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

<script language="javascript" type="text/javascript" src="<?php echo $x.$js_menu;?>"></script> 
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_tema_menu;?>" ></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_calendario;?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_info_emergente;?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_general;?>"></script>

<script language="javascript" type="text/javascript" src="<?php echo $x.$js_barra_floater;?>"></script>

<script type="text/javascript" src='<?php echo $x."js/alertify.js/lib/alertify.js";?>'></script>

<script type="text/javascript" src='<?php echo $x."js/jquery-1.11.3.min.js";?>'></script>

<script type="text/javascript" src='<?php echo $x."include/select2-4.0.0/dist/js/select2.min.js";?>'></script>

<body onload="loadBar();">
<form method="post" name="frm" id="frm" action="" enctype="multipart/form-data">

					<?php
						$obj->Header_menu($x,$img_banner,$nombre_empresa,$publicidad,$_SESSION["rol"],$camino_logout,$_SESSION["user"],$img_salir,$rs_sesion,$db);
						$obj->Encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$n_botones,$rs_sesion,$elemento);
					?>
					
					<table class="tabla_contenido">
						<tr>
							<td  class="contenido">
							<table align='center' class='tabla_listar'>
							<!--Inicio Contenido-->
							