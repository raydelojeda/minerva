<?php

$user="Administrador";
$password="123";




$dsn="bio";

$conn_access=odbc_connect($dsn,$user,$password);
if ($conn_access){
    echo "Conectado correctamente"; }
	
	$rs_access = odbc_exec ($conn_access, "SELECT * from CHECKINOUT, USERINFO WHERE USERINFO.USERID=CHECKINOUT.USERID"); 
	
		while ($fila = odbc_fetch_object($rs_access)){
          echo "<br>" . $fila->CHECKTIME."  ".$fila->Badgenumber;
       } 
   
 //odbc_close ($conn_access);
?>