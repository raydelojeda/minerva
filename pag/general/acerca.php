<?php
include("../../config/variables.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es_ES" xml:lang="es_ES">
<head>
<title><?php print $titulo_sitio;?></title>
<link href="../../css/help.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table align="center" width="900" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td>
        <h1>Centro de Ayuda - <?php print $titulo_sitio;?></h1>
      <p> <strong><?php print $titulo_sitio;?></strong></p>
	  
	  <p>
	  Minerva es el nombre en latín de la diosa griega Atenea (diosa de la civilización, sabiduría, estrategia, de las artes, de la justicia y de la habilidad, protectora de la ciudad griega "Atenas").
	  </p>
      <p> <strong>ERP - <?php print $nombre_sucursal;?></strong></p>
      <p>Versi&oacute;n: 2 </p>
      <p>Fecha:26 octubre 2015</p>
      <p><?php print $nombre_empresa;?></p>
      <p><?php print $nombre_sucursal;?></p>
      <p>Departamento de Sistemas - Ecuador</p>
      <p>Autor:
	  <li>Ing. Raydel Ojeda Figueroa</li>     
      </p>
     
      <br />
      <ul>
        <li><font size="1">Advertencia: este programa est&aacute; protegido por 
          las leyes de derechos de autor. La 
          reproducci&oacute;n o distribuci&oacute;n no autorizadas de este programa, 
          o de cualquier parte del mismo, pueden dar lugar a penalizaciones tanto 
          civiles como penales y ser&aacute;n objeto de todas las acciones judiciales 
          que correspondan.</font><br />
        </li>
      </ul>      
      <p align="center"> 
        <input   class="boton" name="btn_aceptar" onclick="history.back();"  type="submit" value="Volver"  width="97" height="22" border="0" />
      </p>
      <p>&nbsp;</p>
      <h3> Centro de Ayuda - <?php print $titulo_sitio;?></h3>
	</td>
  </tr>
</table>

</body>
</html>