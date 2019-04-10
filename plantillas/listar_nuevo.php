<?php //print $elemento.$_SESSION["elemento"];
$group='';

if(isset($elemento) AND isset($_SESSION["elemento"]))
{
	if($_SESSION["elemento"]!=$elemento)
	{
		$_SESSION["elemento"]=$elemento;
		$_SESSION["txt_ir"]="";
		$_SESSION["ver"]="";
		$_SESSION["order"]="";
		$_SESSION["type"]="";
		$_SESSION["txt_filtro"]="";
		$_SESSION["sel_filtro"]="";
		$_SESSION["txt_filtro2"]="";
		$_SESSION["sel_filtro2"]="";	
	}
}
elseif(!isset($_SESSION["elemento"]))
$_SESSION["elemento"]=$elemento;
?>
