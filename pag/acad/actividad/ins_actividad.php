<?php
include("variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$ins_sql='INSERT INTO '.$tabla.'('.$insert_field[1].','.$insert_field[3].','.$insert_field[5].','.$insert_field[6].','.$insert_field[7].') 
	VALUES("'.$_POST['campo0'].'","'.$_POST['campo1'].'","'.$_POST['campo2'].'","'.$_POST['campo3'].'","'.$_POST['campo4'].'")';print $ins_sql;
	$db->Execute($ins_sql) or die($db->ErrorMsg());
	
	$i_sql="SELECT LAST_INSERT_ID() AS myid";
	$rs_i=$db->Execute($i_sql) or die($db->ErrorMsg());
	
	/*$s_sql="select ".$insert_field[0].", ".$insert_field[1]." from ".$tabla."
	WHERE ".$insert_field[0]."='".$rs_i->fields['myid']."'";
	$rs_s=$db->Execute($s_sql) or die($db->ErrorMsg());
	
	print $rs_s->fields[$insert_field[0]].','.$rs_s->fields[$insert_field[1]];//van solo 2 parámetros*/
}
?>