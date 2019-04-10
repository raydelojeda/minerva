<?php
$_SESSION["modulo"]='mod';
include("variables.php");

if (isset($_POST['btn_aceptar'])) 
{
	$mensaje = "";
	$sel_estilo = $_POST['sel_estilo'];

	$sql_e="select estilo_usuario.id_estilo_usuario, estilo, descripcion from usuario, n_estilo, estilo_usuario 
	WHERE usuario.id_usuario=estilo_usuario.id_usuario AND n_estilo.id_estilo=estilo_usuario.id_estilo AND usuario='".$_SESSION["user"]."'";
	$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());

	if($rs_e->fields["id_estilo_usuario"])	
	{ 
		$sql = "UPDATE estilo_usuario SET  id_estilo = '".$_POST['sel_estilo']."' WHERE id_estilo_usuario = '".$rs_e->fields["id_estilo_usuario"]."'";//print $sql;	
		$rs = $db->Execute($sql) or $mensaje=$db->ErrorMsg();
		
		$sql_u="select estilo from n_estilo, estilo_usuario 
		WHERE n_estilo.id_estilo=estilo_usuario.id_estilo AND estilo_usuario.id_estilo='".$_POST['sel_estilo']."'";
		$rs_u=$db->Execute($sql_u) or die($db->ErrorMsg());
	
		$_SESSION["estilo"] = $rs_u->fields["estilo"];
	} 
	else
	{
		$sql = "INSERT INTO estilo_usuario(id_estilo,id_usuario)VALUES('".$_POST['sel_estilo']."','".$_SESSION["id_user"]."')";//print $sql;	
		$rs = $db->Execute($sql) or $mensaje=$db->ErrorMsg();
		
		$sql_u="select estilo from usuario, n_estilo, estilo_usuario 
		WHERE usuario.id_usuario=estilo_usuario.id_usuario AND n_estilo.id_estilo=estilo_usuario.id_estilo AND usuario.id_usuario='".$_SESSION["id_user"]."'";
		$rs_u=$db->Execute($sql_u) or die($db->ErrorMsg());
	
		$_SESSION["estilo"] = $rs_u->fields["estilo"];
	}
	
}

include($x."plantillas/sec_header.php");

$sql_u="select n_estilo.id_estilo, descripcion from usuario, n_estilo, estilo_usuario 
WHERE usuario.id_usuario=estilo_usuario.id_usuario AND n_estilo.id_estilo=estilo_usuario.id_estilo AND usuario.id_usuario='".$_SESSION["id_user"]."'";//print $sql_u;
$rs_u=$db->Execute($sql_u) or die($db->ErrorMsg());//print $rs_u;

$sql_est="select id_estilo, descripcion from n_estilo";
$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());//print $_SESSION["estilo"];
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<form name="frm" method="post" action="">          
	<table class="login">
		<tr>		
			<td class="intro_sup"> 
				<div align="center">
					<p><img id="cambio" src="../img/conf/estilo.png" width="32" height="32"> 
					<b>Cambiar plantilla</b></p>				
				
					<table width="80%" class="tabla">						
						<tr height="10"> 
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr> 
							<td width="15%" align="right">Plantilla:</td>
							<td width="55%">
								<select name="sel_estilo" id="sel_estilo">
									<option>----------------------------------------Seleccionar----------------------------------------</option>
									<?php for($e=0;$e<$rs_est->RecordCount();$e++){?>
									
										<option value="<?php print $rs_est->fields['id_estilo'];?>" <?php if($rs_est->fields['id_estilo']==$rs_u->fields['id_estilo']){?> selected="selected"<?php }?> > <?php print $rs_est->fields['descripcion'];?> </option>
										
									<?php $rs_est->MoveNext();}?>
								</select>
							</td>
						</tr>
						
						<?php if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);?>
						
						<tr height="65"> 
							<td align="center" colspan="2">
								<input class="boton" name="btn_aceptar" type="submit" value="Aceptar">
							</td>
						</tr>							
					</table>
				</div>
				<p>&nbsp;</p>
			</td>
		</tr>

	</table>
	<p>&nbsp;</p>
</form>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/sec_footer.php");
?>

