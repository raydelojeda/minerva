<?php
include("variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$ins_sql='INSERT INTO '.$tabla.'(atributo) VALUES("'.$_POST['campo0'].'")';
	$db->Execute($ins_sql) or die($db->ErrorMsg());
	
	$i_sql="SELECT LAST_INSERT_ID() AS myid";
	$rs_i=$db->Execute($i_sql) or die($db->ErrorMsg());
	
	$s_sql="select id_atributo, atributo from n_atributo 
	WHERE id_atributo='".$rs_i->fields['myid']."'";
	$rs_s=$db->Execute($s_sql) or die($db->ErrorMsg());
	
	print $rs_s->fields['id_atributo'].','.$rs_s->fields['atributo'];//van solo 2 parámetros
}
?>