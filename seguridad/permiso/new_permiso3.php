<?php 


include("variables.php");
$titulo_nuevo="Administraci&oacute;n de bloqueo de permisos";
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

$checked="";

$sql_a="SELECT id_accion,accion FROM n_accion";
$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());

$sql_e="SELECT id_elemento,modulo,elemento FROM n_elemento ORDER BY modulo, elemento";
$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());

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
				$sql="SELECT permiso_bloqueado.id_permiso_bloqueado FROM permiso_bloqueado, n_accion, n_elemento
				WHERE permiso_bloqueado.id_accion=n_accion.id_accion AND permiso_bloqueado.id_elemento=n_elemento.id_elemento 
				AND n_elemento.id_elemento='".$rs_e->fields['id_elemento']."' AND n_accion.id_accion='".$rs_a->fields['id_accion']."'";//print $sql."<br>";//die();
				$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;
				
				if($rs->fields[0]=='')
				{
					$i_sql="INSERT INTO permiso_bloqueado (id_elemento, id_accion) VALUES ('".$rs_e->fields['id_elemento']."','".$rs_a->fields['id_accion']."')";//print $i_sql."<br>";
					$db->Execute($i_sql) or die($db->ErrorMsg());
				}
				else
				{
					$u_sql="UPDATE permiso_bloqueado SET id_elemento='".$rs_e->fields['id_elemento']."',id_accion='".$rs_a->fields['id_accion']."' WHERE id_permiso_bloqueado='".$rs->fields['id_permiso_bloqueado']."'";//print $u_sql."<br>";
					$db->Execute($u_sql) or die($db->ErrorMsg());
				}
			}
			else
			{
				$sql="SELECT permiso_bloqueado.id_permiso_bloqueado FROM permiso_bloqueado, n_accion, n_elemento
				WHERE permiso_bloqueado.id_accion=n_accion.id_accion AND permiso_bloqueado.id_elemento=n_elemento.id_elemento 
				AND n_elemento.id_elemento='".$rs_e->fields['id_elemento']."' AND n_accion.id_accion='".$rs_a->fields['id_accion']."'";//print $sql."<br>";//die();
				$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;
				
				if($rs->fields[0]!='')
				{
					$d_sql="DELETE FROM permiso_bloqueado WHERE id_permiso_bloqueado='".$rs->fields['id_permiso_bloqueado']."'";//print $d_sql."<br>";
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
<br>
<?php
$rs_e->MoveFirst();
$rs_a->MoveFirst();

$sql="SELECT n_elemento.id_elemento,n_accion.id_accion FROM permiso_bloqueado, n_accion, n_elemento
WHERE permiso_bloqueado.id_accion=n_accion.id_accion AND permiso_bloqueado.id_elemento=n_elemento.id_elemento 
";//print $sql;//die();
$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs;

?>
<div align="center">
<table class="tabla_permiso" align="center">
	<tr >
		<td colspan="<?php print $rs_a->RecordCount()+1;?>" align="left">
			
			&nbsp;
			Confirmar:<input name='checkbox' type='checkbox'/>
		</td>
	</tr>
	
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
			<?php print $rs_e->fields['modulo']." / ".$rs_e->fields['elemento'];?>
		</td>
		
		<?php for($a=0;$a<$rs_a->RecordCount();$a++){?>
		<td>
			<?php
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
					<input class="checkbox_oculto" name='checkbox_<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];?>' <?php print $checked;?> type='checkbox' value='checkbox_<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion']?>'type="checkbox" id="<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];?>" />
					<label for="<?php print $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];?>"></label>
				</div>
			</section>
		</td>
		<?php
			// $cadenacheckboxp contiene los id del elemento
			if($cadenacheckboxp == ""){$cadenacheckboxp = $rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];}
			else{$cadenacheckboxp .= ",".$rs_e->fields['id_elemento'].$rs_a->fields['id_accion'];}
			// $cadenacheckboxp contiene los id del elemento
		
			$rs_a->MoveNext();
			$checked="";
		}
		?>
	</tr>

	
	<?php $rs_e->MoveNext();}
	
	?>
	
</table>
<div>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/sec_footer.php");
?>