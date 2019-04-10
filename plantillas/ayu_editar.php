<?php
include_once("variables.php");
include_once($x."adodb519/adodb.inc.php");  //adodb library
include_once($x."coneccion/conn.php"); //conection
include_once($x."config/variables.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es_ES" xml:lang="es_ES">
<head>
<title>Ayuda</title>
<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_ayuda;?>"/>
<link rel="shortcut icon" href="<?php echo $x.$fav_icon;?>"/> 

</head>
<body>
<?php include_once($x.$_GET["var"]);?>
<h1> <?php echo $titulo_ayuda;?></h1>

<p> <?php echo $intro_ayuda;?><br />
  <br />
  <strong>Iconos de la Barra de Herramientas</strong> </p>
<ul>
<?php
for($btn=0;$btn<sizeof($n_botones_ayuda);$btn++) 
{
  print '<li><u>'.$n_botones_ayuda[$btn]['texto'].':</u> Pulse el icono &lsquo;'.$n_botones_ayuda[$btn]['texto'].'&rsquo; para '.$n_botones_ayuda[$btn]['exp'].'.</li>';
}
?>
</ul>

</ul>
<strong>Descripción de las Cajas de texto</strong> 
<ul>
 
<?php
for($btn=0;$btn<sizeof($n_label_ayuda);$btn++) 
{
  print '<li><u>'.$n_label_ayuda[$btn]['texto'].':</u> '.$n_label_ayuda[$btn]['exp'].'.</li>';
}
?>

  
</ul>
<br><br>

<h3>Centro de Ayuda</h3>
</body>
</html>