<?php
include("variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$ins_sql='INSERT INTO '.$tabla.'(id_gru, subgrupo) VALUES("'.$_POST['campo0'].'", "'.$_POST['campo1'].'")';
	$db->Execute($ins_sql) or die($db->ErrorMsg());
	
	$i_sql="SELECT LAST_INSERT_ID() AS myid";
	$rs_i=$db->Execute($i_sql) or die($db->ErrorMsg());
	
	$s_sql="select id_subgrupo, concat(subgrupo,' - ',gru,' - ',familia) as gru from n_subgrupo, n_gru, n_familia 
	WHERE n_gru.id_gru=n_subgrupo.id_gru AND n_gru.id_familia=n_familia.id_familia AND id_subgrupo='".$rs_i->fields['myid']."' ORDER BY gru";
	$rs_s=$db->Execute($s_sql) or die($db->ErrorMsg());
	
	print $rs_s->fields['id_subgrupo'].','.$rs_s->fields['gru'];//van solo 2 parámetros
}
?>