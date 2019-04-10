<?php
//$x="../";// (NO TOCAR)
if(isset($_SESSION["estilo"]))
{
	if($_SESSION["estilo"]=='')
	$_SESSION["estilo"]='claro';
}
else
$_SESSION["estilo"]='claro';

$tema_sitio="css/".$_SESSION["estilo"].".css"; // tema del sitio
$tema_sitio_imprimir="css/imprimir.css"; // tema del sitio
$tema_menu="css/menu_".$_SESSION["estilo"].".css"; // tema del menu
$tema_calendario="css/calendario.css"; // tema calendario
$tema_ayuda="css/help.css";

$js_calendario="js/calendario.js"; // js del calendario
$js_tema_menu="js/menu/tema_menu.js"; // js tema del menu
$js_menu="js/menu/menu.js"; // js del menu
$js_info_emergente="js/info_emergente.js"; // js informacion emergente de la celda
$js_general="js/general.js"; // js generales
$js_barra_floater="js/barra/floater.js"; // js de la barra flotante
$js_menu_admin="js/menu/admin.js"; // js para el menu del administrador
$js_menu_invitado="js/menu/invitado.js"; // js para el menu de invitado 

$camino_atenticacion="seguridad/autenticacion.php"; // ubicación para la autenticacion y verificacion de usuario, camino que redirecciona el index.php de cada carpeta
$camino_logout="seguridad/logout.php"; // camino para el archivo de salida del sistema

$fav_icon="img/general/fav_icon.ico"; // icono favorito
$img_banner="img/general/banner.png"; // imagen para encabezado
$img_salir="img/general/exit.gif";
$logo="img/general/logo.png";
$logo_sistema="img/general/minerva_logo.png";

$titulo_sitio="Minerva"; //titulo del sitio segun nombre empresa
$_SESSION['titulo_sitio']="Minerva"; //titulo del sitio segun nombre empresa
$nombre_empresa="Fundaci&oacute;n Cultural Educativa Ambato";
$nombre_sucursal="Unidad Educativa Atenas";
$publicidad="Somos la Organizaci&oacute;n responsable de la formaci&oacute;n de personas felices e &iacute;ntegras, con conciencia social y capacidades para triunfar.";
$mail_sistema="minerva@atenas.edu.ec";
$clave_mail="Ray130865";
$url='minerva.atenas.edu.ec';
$mail_soporte="soporte_minerva@atenas.edu.ec";


/*
$tabla_anidada=array();
$tabla_anidada2=array();
$campo_anidado2=array();
$campo_anidado=array();
$alias_col=array();
$field_col=array();
$insert_alias=array();
$name_input=array(); 
$label_input=array();
$field_unico=array();
$tipo_input=array();
$opt_name=array();
$opt_value=array();
$opt_sel=array();
$placeholder=array();*/

?>