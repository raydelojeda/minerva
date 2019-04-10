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
for($btn=0;$btn<sizeof($l_botones_ayuda);$btn++) 
{
  print '<li><u>'.$l_botones_ayuda[$btn]['texto'].':</u> Pulse el icono &lsquo;'.$l_botones_ayuda[$btn]['texto'].'&rsquo; para '.$l_botones_ayuda[$btn]['exp'].'.</li>';
}
?>
</ul>
<p><strong>Paginador</strong><br />
  <br />
  A la derecha y arriba del listado se muestra un paginador que permite navegar entre las p&aacute;ginas.</p>
<p><strong>Filtro y Men&uacute; &quot;Seleccionar&quot; </strong></p>
<p>Permite acelerar la b&uacute;squeda en el listado reduciendo el n&uacute;mero 
  de datos mostrados, seleccionando aquellos que tengan ciertas condiciones. Puede 
  filtrar por palabra clave o parte de ella. Elija en el men&uacute; seleccionar 
  un nombre de columna para comenzar la b&uacute;squeda. </p>
  <p>Los listados constan de 2 filtros como mínimo. </p>
<p><strong>Encabezado de las Columnas</strong></p>
<ul>
  <li> Esta fila muestra el nombre de las columnas. Pulse el encabezado para reorganizar 
    la columna en orden diferente.</li>
</ul>
<strong>Descripción de las Columnas</strong> 
<ul>
  <li><u>No:</u> N&uacute;mero de filas mostradas.</li>
<?php
for($btn=0;$btn<sizeof($l_label_ayuda);$btn++) 
{
  print '<li><u>'.$l_label_ayuda[$btn]['texto'].':</u> '.$l_label_ayuda[$btn]['exp'].'.</li>';
}

if(isset($ayuda))
print '<br>'.nl2br($ayuda);
?>

  
</ul>
<br><br>

<h3>Centro de Ayuda</h3>
</body>
</html>