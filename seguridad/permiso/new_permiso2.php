<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

$checked="";
$disable="";
$no_mas="";

$sql_a="SELECT id_accion, accion FROM n_accion";
$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());

$sql_e="SELECT id_elemento, modulo, elemento, descripcion FROM n_elemento WHERE 1 ";

if(isset($_POST['sel_modulo']))
$sql_e=$sql_e."AND modulo='".$_POST['sel_modulo']."' ";

$sql_e=$sql_e."ORDER BY modulo, elemento";//print $sql_e;
$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());

$sql_bloq="SELECT permiso_bloqueado.id_permiso_bloqueado, permiso_bloqueado.id_elemento, permiso_bloqueado.id_accion FROM permiso_bloqueado";//print $sql."<br>";//die();
$rs_bloq=$db->Execute($sql_bloq) or die($db->ErrorMsg());//print $rs_bloq;

if(isset($_POST['checkbox']))
{	
	$rs_e->MoveFirst();
	for($e=0;$e<$rs_e->RecordCount();$e++)
	{
		$rs_a->MoveFirst();
		for($a=0;$a<$rs_a->RecordCount();$a++)
		{
			$cbx = (string) 'checkbox_'.$rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];
			if(isset($_POST[$cbx]))
			{
				$sql="SELECT permiso.id_permiso FROM n_rol, permiso, n_accion, n_elemento
				WHERE permiso.id_rol=n_rol.id_rol AND permiso.id_accion=n_accion.id_accion AND permiso.id_elemento=n_elemento.id_elemento 
				AND n_rol.id_rol='".$_POST['sel_rol']."' AND n_elemento.id_elemento='".$rs_e->fields['id_elemento']."' AND n_accion.id_accion='".$rs_a->fields['id_accion']."'";//print $sql."<br>";//die();
				$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;
				
				if($rs->fields[0]=='')
				{
					$i_sql="INSERT INTO permiso (id_rol, id_elemento, id_accion) VALUES ('".$_POST['sel_rol']."','".$rs_e->fields['id_elemento']."','".$rs_a->fields['id_accion']."')";//print $i_sql."<br>";
					$db->Execute($i_sql) or die($db->ErrorMsg());
				}
				else
				{
					$u_sql="UPDATE permiso SET id_elemento='".$rs_e->fields['id_elemento']."',id_accion='".$rs_a->fields['id_accion']."' WHERE id_permiso='".$rs->fields['id_permiso']."'";//print $u_sql."<br>";
					$db->Execute($u_sql) or die($db->ErrorMsg());
				}
			}
			else
			{
				$sql="SELECT permiso.id_permiso FROM n_rol, permiso, n_accion, n_elemento
				WHERE permiso.id_rol=n_rol.id_rol AND permiso.id_accion=n_accion.id_accion AND permiso.id_elemento=n_elemento.id_elemento 
				AND n_rol.id_rol='".$_POST['sel_rol']."' AND n_elemento.id_elemento='".$rs_e->fields['id_elemento']."' AND n_accion.id_accion='".$rs_a->fields['id_accion']."'";//print $sql."<br>";//die();
				$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;
				
				if($rs->fields[0]!='')
				{
					$d_sql="DELETE FROM permiso WHERE id_permiso='".$rs->fields['id_permiso']."'";//print $d_sql."<br>";
					$db->Execute($d_sql) or die($db->ErrorMsg());
				}
			}
		$rs_a->MoveNext();
		}
	$rs_e->MoveNext();
	}	
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;

<?php
$rs_e->MoveFirst();
$rs_a->MoveFirst();

$sql_r="SELECT id_rol,rol FROM n_rol ORDER BY rol";
$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());

$sql_m="SELECT distinct modulo FROM n_elemento ORDER BY modulo";
$rs_m=$db->Execute($sql_m) or die($db->ErrorMsg());

if(isset($_POST['sel_rol']))
{
	$sql="SELECT n_elemento.id_elemento,n_accion.id_accion FROM n_rol, permiso, n_accion, n_elemento
	WHERE permiso.id_rol=n_rol.id_rol AND permiso.id_accion=n_accion.id_accion AND permiso.id_elemento=n_elemento.id_elemento 
	AND n_rol.id_rol='".$_POST['sel_rol']."'";//print $sql;//die();
	$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;
}
?>
<div align="center">
<table class="tabla_permiso" align="center">
	<tr >
		<td colspan="<?php print $rs_a->RecordCount()+1;?>" align="left">
			Rol:
			<select name="sel_rol" id="sel_rol" onchange="javascript:document.frm.submit();">
				<option value="0">---Seleccionar---</option>
				<?php for($r=0;$r<$rs_r->RecordCount();$r++){?>
				
					<option value="<?php print $rs_r->fields['id_rol'];?>" <?php if(isset($_POST['sel_rol'])){if($rs_r->fields['id_rol']==$_POST['sel_rol']){;?> selected="selected"<?php }}?> > <?php print $rs_r->fields['rol'];?> </option>
					
				<?php $rs_r->MoveNext();}?>
			</select>
			&nbsp;
			
			M&oacute;dulo:
			<select name="sel_modulo" id="sel_modulo" onchange="javascript:document.frm.submit();">
				<option value="0">---Seleccionar---</option>
				<?php for($m=0;$m<$rs_m->RecordCount();$m++){?>
				
					<option value="<?php print $rs_m->fields['modulo'];?>" <?php if(isset($_POST['sel_modulo'])){if($rs_m->fields['modulo']==$_POST['sel_modulo']){;?> selected="selected"<?php }}?> > <?php print $rs_m->fields['modulo'];?> </option>
					
				<?php $rs_m->MoveNext();}?>
			</select>
			&nbsp;
			
			Confirmar permisos:<input name='checkbox' type='checkbox'/>
		</td>
	</tr>
<?php 
if(isset($_POST['sel_rol']) AND isset($_POST['sel_modulo']))
{//print $_POST['sel_rol']."AND".$_POST['sel_modulo'];AND $_POST['sel_modulo']!=0
	if($_POST['sel_rol']!=0)
	{
?>	
	
	<tr class="encabezado">
		<td align="left">
		M&oacute;dulo/Elemento
		</td>
		
		<?php for($a=0;$a<$rs_a->RecordCount();$a++){?>
		<td height="30">
			<?php print $rs_a->fields['accion'];?>&nbsp;<input name='checkbox_<?php print $rs_a->fields['id_accion'];?>' onclick='marcar_p(<?php print $rs_a->fields['id_accion'];?>);' type='checkbox'/>
		</td>
		<?php $rs_a->MoveNext();}?>
	</tr>
	
	<?php for($e=0;$e<$rs_e->RecordCount();$e++){$rs_a->MoveFirst();?>	
	
	<tr>
		<td align="left" height="30">
		<?php
			//include("../../pag/".$rs_e->fields['modulo']."/".$rs_e->fields['elemento']."/variables.php");
			//$elemento_over="Administraci&oacute;n ".$elemento_titulo;
		?>
			<a class='hlink' onmouseover="return overlib('<?php print $rs_e->fields['descripcion'];?>', ABOVE, RIGHT)" onmouseout='return nd();'>
				<?php print $rs_e->fields['elemento'];?>
			</a>
		</td>
		
		<?php for($a=0;$a<$rs_a->RecordCount();$a++){?>
		<td>
			<?php			
			$rs_bloq->MoveFirst();
			if($no_mas=="")
			{
				for($b=0;$b<$rs_bloq->RecordCount();$b++)
				{	
					$no_mas=1;							
					if($rs_bloq->fields['id_elemento']==$rs_e->fields['id_elemento'] AND $rs_bloq->fields['id_accion']==$rs_a->fields['id_accion'])
					{$disable="disabled";break;}
					$rs_bloq->MoveNext();
				}
			}			
			
			$rs->MoveFirst();
			for($ea=0;$ea<$rs->RecordCount();$ea++)
			{			
				if($rs_e->fields['id_elemento']==$rs->fields['id_elemento'] AND $rs_a->fields['id_accion']==$rs->fields['id_accion'])
				{$checked="checked";break;}
				
			$rs->MoveNext();
			}
			?>
			
			<section>
				<div class="checkbox-2">
					<input class="checkbox_oculto" name='checkbox_<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];?>' <?php print $disable;?> <?php print $checked;?> type='checkbox' value='checkbox_<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion']?>'type="checkbox" id="<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];?>" />
					<label for="<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];?>"><?php if($disable)print "X";?></label>
				</div>
			</section>
		</td>
		<?php
			// $cadenacheckboxp contiene los id del elemento
			if($cadenacheckboxp == ""){$cadenacheckboxp = $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];}
			else{$cadenacheckboxp .= ",".$rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];}
			// $cadenacheckboxp contiene los id del elemento
		
			$rs_a->MoveNext();
			$checked="";$disable="";$no_mas="";
		}
		?>
	</tr>
	
<?php $rs_e->MoveNext();}
	}
}
?>

<div>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>