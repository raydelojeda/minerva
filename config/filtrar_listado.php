<?php
$x='../';
include($x."adodb519/adodb-pager.inc.php");
include($x."config/variables.php");
include($x."config/clases.php");
include($x."config/clases.inc.php");

$clases_nuevas = new clases_nuevas();
$obj2 = new clases();

if(isset($_POST['campo0']))
{	
	$x_include=$x;
	
	$x=$x_include;
	$dir=$_POST['campo1'];
	$name=$_POST['campo9'];
	include($x_include.$dir."/variables".$name.".php");
	if(!isset($obj2))$obj2='';
	
	$xxx=$_POST['campo0'];
	
	$txt_filtro=$_POST['campo2'];
	$pag=$_POST['campo3'];
	$ver=$_POST['campo4'];
	$campo_orden=$_POST['campo5'];
	$asc_desc=$_POST['campo6'];
	$l_sql=$_POST['campo7'];
	$permiso=$_POST['campo8'];
	
	$pos_order = strpos($l_sql, 'ORDER');

	if($txt_filtro!='')
	{		
		$filtro=explode(' ',$txt_filtro);
		
		$pos = strpos($l_sql, 'GROUP');
		
		if($pos==false)
		$pos = strpos($l_sql, 'ORDER');
		
		if($pos != false)
		{
			$l_sql_1 = substr($l_sql, 0, $pos); 
			$l_sql_2 = substr($l_sql, $pos);
			
			$l_sql=$l_sql_1;
		}
		
		for($f=0;$f<sizeof($filtro);$f++)
		{		
			$filtro[$f]=trim($filtro[$f]);
			if($filtro[$f]!='')
			{
				$l_sql .= " AND ( ";		
				$primero=0;
				
				for($i=0;$i<sizeof($field_busqueda);$i++)
				{
					if($field_busqueda[$i]!='')
					{
						if($primero==0)
						{
							$primero=1;
							$l_sql .= $field_busqueda[$i]." like '%".$filtro[$f]."%' ";						
						}
						else
						{
							$l_sql .= " OR ".$field_busqueda[$i]." like '%".$filtro[$f]."%' ";
						}				
					}
				}
				$l_sql .= " ) ";
			}
		}
		
		if($pos != false)
		{
			$l_sql .= $l_sql_2;
		}
		
		/*$primero=0;
		
		for($i=0;$i<sizeof($field_busqueda);$i++)
		{
			if($field_busqueda[$i]!='')
			{
				if($primero==0)
				{
					$primero=1;
					$l_sql .= " AND ".$field_busqueda[$i]." != '' AND ".$field_busqueda[$i]." != 'null'";
				}
				else
				{
					$l_sql .= " AND ".$field_busqueda[$i]." != '' AND ".$field_busqueda[$i]." != 'null'";
				}				
			}
		}*/
	}
	
	if($campo_orden!="" && $pos_order == false)
	{
		$l_sql .= " ORDER BY ".$campo_orden;
		
		if($asc_desc==1)
		{$l_sql .= " ASC";}
		elseif($asc_desc==0)
		{$l_sql .= " DESC";}
	}	
	//print $l_sql;
	//print $pag;
	$clases_nuevas->paginador($db, $x_include, $xxx, $dir, $txt_filtro, $pag, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name);
	$clases_nuevas->encabezado_nuevo($db, $x_include, $xxx, $dir, $txt_filtro, $pag, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name);
	$clases_nuevas->filas_nuevas($db, $x_include, $xxx, $dir, $txt_filtro, $pag, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name);
}
?>