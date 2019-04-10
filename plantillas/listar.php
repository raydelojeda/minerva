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


//if(!isset($_SESSION["txt_ir"]))$_SESSION["txt_ir"]='';
//if(isset($_POST['txt_ir']))$txt_ir = $_POST['txt_ir'];else $txt_ir=$_SESSION["txt_ir"];
//$_SESSION["txt_ir"]=$txt_ir;
/*if(isset($_POST['txt_ir']))
{header("Location:lis_".$elemento.".php?adodb_next_page=".$txt_ir);}*/

//print $_SESSION["ver"];
//if(!isset($_SESSION["ver"]))$_SESSION["ver"]='';//$ver = $_SESSION["ver"];
if(isset($_POST["sel_#"]))$_SESSION["ver"] = $_POST["sel_#"];
if(isset($_SESSION['ver']))$ver = $_SESSION["ver"];
if(!isset($ver) OR $ver=='')$ver=10;


if(!isset($_SESSION["order"]))$_SESSION["order"]='';
if(isset($_GET["order"])) $order = $_GET["order"];elseif(isset($order)) //$order = $_SESSION["order"];
$_SESSION["order"]=$order;elseif(isset($_SESSION["order"])) $order = $_SESSION["order"];


if (isset($_GET["type"])) $ordtype = $_GET["type"];else $ordtype="";
if ($ordtype == "desc"){$ordtypestr = "asc";} else{$ordtypestr = "desc";} 


if(!isset($_SESSION["txt_filtro"]))$_SESSION["txt_filtro"]='';
if(isset($_POST['txt_filtro']))$txt_filtro = $_POST['txt_filtro'];else $txt_filtro=$_SESSION["txt_filtro"];
$_SESSION["txt_filtro"]=$txt_filtro;

if(!isset($_SESSION["sel_filtro"]))$_SESSION["sel_filtro"]='';
if(isset($_POST['sel_filtro']))$sel_filtro = $_POST['sel_filtro'];else $sel_filtro=$_SESSION["sel_filtro"];
$_SESSION["sel_filtro"]=$sel_filtro;

if(!isset($_SESSION["sel_filtro2"]))$_SESSION["sel_filtro2"]='';
if(isset($_POST['sel_filtro2']))$sel_filtro2 = $_POST['sel_filtro2'];else $sel_filtro2=$_SESSION["sel_filtro2"];
$_SESSION["sel_filtro2"]=$sel_filtro2;

if(!isset($_SESSION["txt_filtro2"]))$_SESSION["txt_filtro2"]='';
if(isset($_POST['txt_filtro2']))$txt_filtro2 = $_POST['txt_filtro2'];else $txt_filtro2=$_SESSION["txt_filtro2"];
$_SESSION["txt_filtro2"]=$txt_filtro2;




if ($txt_filtro!='' && $sel_filtro!='' && $sel_filtro!="no" && $sel_filtro!="cl") 
{
	$l_sql .= " AND ";
	
	if($sel_filtro2==$sel_filtro AND $txt_filtro2!='' AND $txt_filtro!='')
	$l_sql .="(";
	
	$l_sql .="$sel_filtro like '%$txt_filtro%'";
}



if ($txt_filtro2!='' && $sel_filtro2!='' && $sel_filtro2!='no' && $sel_filtro2!="cl") 
{
	if($sel_filtro2==$sel_filtro AND $txt_filtro2!='' AND $txt_filtro!='')
	{
		$concat="OR";
		//$group=" group by id_".$elemento;
	}
	else
	$concat="AND";
	
	if (!($txt_filtro!='' && $sel_filtro!='' && $sel_filtro!="no" && $sel_filtro!="cl"))
	{
		if($sel_filtro2==$sel_filtro AND $txt_filtro2!='' AND $txt_filtro!='')
		$concat .=" (";
	}
	
	$l_sql .=  " ".$concat." $sel_filtro2 like '%$txt_filtro2%'";
	
	if($sel_filtro2==$sel_filtro AND $txt_filtro2!='' AND $txt_filtro!='')
	$l_sql .=")";
	
	//if($group)$l_sql .= $group;
}
elseif (($txt_filtro2!='' && $sel_filtro2!='' && $sel_filtro2!='no' && $sel_filtro2!="cl") OR ($txt_filtro!='' && $sel_filtro!='' && $sel_filtro!="no" && $sel_filtro!="cl"))
{
	if($sel_filtro2==$sel_filtro AND $txt_filtro2!='' AND $txt_filtro!='')
	$l_sql .=")";
}

if (isset($order) && $order!='') $l_sql .= " order by $order";
if (isset($ordtype) && $ordtype!='') $l_sql .= " " .str_replace("'", "''", $ordtype);//print $l_sql;
?>
