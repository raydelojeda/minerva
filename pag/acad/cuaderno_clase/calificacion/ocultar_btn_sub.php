<?php
include("var_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");
if(!isset($obj))$obj = new clases();// (NO TOCAR)

if(isset($_POST['campo0']))
{
	$id_subperiodo_evaluativo=$_POST['campo0'];
	$id_clase=$_POST['campo1'];
	
	$tipo=substr($id_subperiodo_evaluativo, 0, 2);
	$id_periodo=substr($id_subperiodo_evaluativo, 2, strlen($id_subperiodo_evaluativo));
	
	if($tipo=='s_')
	{
		$sql_i="SELECT cerrado, subperiodo_evaluativo FROM cierre_subperiodo_evaluativo, n_subperiodo_evaluativo WHERE 1 AND cierre_subperiodo_evaluativo.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
		AND n_subperiodo_evaluativo.id_subperiodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $sql_i.'<br>';
		$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		if(isset($rs_i->fields['cerrado']))
		{
			if($rs_i->fields['cerrado']=='0')
			{
				?>
					<a href="#modal_ins_actividad"><div class="boton" width="100px" height="22px" border="0"> + Insertar actividad </div></a>
				<?php
			}
			elseif($rs_i->fields['cerrado']=='1')
			{
				print 'El '.$rs_i->fields['subperiodo_evaluativo'].' est&aacute; bloqueado.';
				?>
					<img width="25px" src='<?php print "../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png";?>'>
				<?php
			}
		}
		else
		{
			?>
				<a href="#modal_ins_actividad"><div class="boton" width="100px" height="22px" border="0"> + Insertar actividadddd </div></a>
			<?php
		}
	}
	elseif($tipo=='p_')
	{
		$sql_i="SELECT cerrado, periodo_evaluativo FROM cierre_periodo_evaluativo, n_periodo_evaluativo WHERE 1 AND cierre_periodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_periodo_evaluativo.id_periodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $sql_i.'<br>';
		$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		if(isset($rs_i->fields['cerrado']))
		{
			if($rs_i->fields['cerrado']=='1')
			{
				print 'El '.$rs_i->fields['periodo_evaluativo'].' est&aacute; bloqueado.';
				?>
					<img width="25px" src='<?php print "../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png";?>'>
				<?php
			}
		}
	}
	elseif($tipo=='l_')
	{
		$sql_i="SELECT cerrado, periodo_lectivo FROM cierre_periodo_lectivo, n_periodo_lectivo WHERE 1 AND cierre_periodo_lectivo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_periodo_lectivo.id_periodo_lectivo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $sql_i.'<br>';
		$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		if(isset($rs_i->fields['cerrado']))
		{
			if($rs_i->fields['cerrado']=='1')
			{
				print 'El '.$rs_i->fields['periodo_lectivo'].' est&aacute; bloqueado.';
				?>
					<img width="25px" src='<?php print "../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png";?>'>
				<?php
			}
		}
	}
}
?>