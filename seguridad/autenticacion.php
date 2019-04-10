<?php
$_SESSION['rol']='';
$_SESSION["md5_rol"]='';
$_SESSION['user']='';
$_SESSION['md5_password']='';
$_SESSION["ok"] = '';
$_SESSION["modulo"]="";

include("variables.php");
include($x."plantillas/sec_header.php");

if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];

if(isset($_POST['txt_usuario']) AND isset($_POST['txt_pass']))//  AND $_POST['txt_usuario']!="Usuario"  AND $_POST['txt_pass']!="Clave"
{
	$txt_user = strip_tags($_POST['txt_usuario']);
	$txt_pass = strip_tags($_POST['txt_pass']);
	$code = strip_tags($_POST['code']);	
	
	if($txt_user != "Usuario" && $txt_pass != "Clave" && $code!= '')
	{	
		
		//print md5($_POST[ 'code' ]) .' - '. $_SESSION[ 'key' ];
		if(md5($code) == $_SESSION[ 'key' ] )
		{
			//$md5_password = md5($_POST['txt_pass']);//print $md5_password;
			
			//$password_ingresado = password_hash($_POST['txt_pass'], PASSWORD_DEFAULT);
			//$password_ingresado = password_hash($_POST['txt_pass'], PASSWORD_BCRYPT);
			//print $password_ingresado;die();
			
			
			$md5_user = md5($_POST['txt_usuario']);

			$sql="SELECT clave, primer_nombre, segundo_nombre, primer_apellido, rol, usuario.id_usuario FROM usuario, usuario_rol, persona, n_rol 
			WHERE usuario.id_persona=persona.id_persona AND usuario.id_usuario=usuario_rol.id_usuario AND usuario_rol.id_rol=n_rol.id_rol 
			AND usuario='".$txt_user."'";//print $sql;
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			if(isset($rs->fields["id_usuario"]))
			{
				$hash=$rs->fields["clave"];
				$id_usuario=$rs->fields["id_usuario"];
				
				if(password_verify($_POST['txt_pass'], $hash))
				{ 
					session_save_path($x."temp" );
					$sesion_id = md5(md5(md5(session_id())));//print $sesion_id;//die();
					
					/*$sql_est="SELECT estilo FROM usuario, n_estilo, estilo_usuario 
					WHERE usuario.id_usuario=estilo_usuario.id_usuario AND n_estilo.id_estilo=estilo_usuario.id_estilo AND usuario='$txt_user' AND clave='$md5_password'";
					$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
					
					if($rs_est->fields[0])
					$_SESSION["estilo"] = $rs_est->fields["estilo"];
					else*/
					$_SESSION["estilo"] = 'claro';
					
					$sql_ses="SELECT sesion_id FROM usuario, sesion	WHERE usuario.id_usuario=sesion.id_usuario AND usuario='".$txt_user."'";
					$rs_ses=$db->Execute($sql_ses) or die($db->ErrorMsg());
					
					if(isset($rs_ses->fields["sesion_id"]))
					{
						$sql="UPDATE sesion SET sesion_id='".$sesion_id."' WHERE id_usuario='".$id_usuario."'";
						$db->Execute($sql) or die($db->ErrorMsg());
					}
					else
					{
						$sql="INSERT INTO sesion (sesion_id, id_usuario) VALUES ('".$sesion_id."', '".$id_usuario."')";
						$db->Execute($sql) or die($db->ErrorMsg());
					}
					
					
					$_SESSION["sid"] =  session_id();			
					$_SESSION["rol"] =  $rs->fields["rol"];
					$_SESSION["user"] = $txt_user;//print $_SESSION['user'];
					$_SESSION["id_user"] = $rs->fields["id_usuario"];
					$_SESSION["password"] = $_POST['txt_pass'];
					$_SESSION["ok"] = "ok";//die();
					$_SESSION["modulo"]="mod";//print $_SESSION["modulo"];
					//print $sql;
					$nombre=$rs->fields["primer_nombre"];
					if($rs->fields["segundo_nombre"])
					$nombre.=" ".$rs->fields["segundo_nombre"];
					if($rs->fields["primer_apellido"])
					$nombre.=" ".$rs->fields["primer_apellido"];

					$_SESSION["nombre"]=$nombre;
					
					echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../pag/panel/panel.php?mensaje=".$rs->fields["primer_nombre"]." ".$rs->fields["segundo_nombre"].", Ud. se ha autenticado como ".$_SESSION["rol"].".'</script>");
				}
				else
				{$mensaje = "Clave incorrecta.";}
			}
			else
			{$mensaje = "Ha ocurrido uno de los siguientes errores: Nombre de usuario incorrecto o el usuario aún no tiene premisos para ingresar.";}
		}
		else
		$mensaje = "El c&oacute;digo ingresado es incorrecto.";
	}
	else
	$mensaje = "Debe llenar todos los datos para entar al sistema.";
}
//elseif(!$mensaje)
//$mensaje = "Debe ingresar todos los datos para entar al sistema.";
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<form name="frm" method="post" action="" onLoad="document.frm.txt_usuario.value='Usuario';" onSubmit="javascript:valida_pass('autenticacion');">          
	<table class="login">
		<tr> 
			<td width="50%" align="center" valign="middle"> 
				<div class="login-text">
					Bienvenido/a al sistema <?php print $titulo_sitio;?> de la <?php print $nombre_empresa;?>! 
					<p>Tiene que usar un Nombre de Usuario y Contrase&ntilde;a 
					válidos para acceder al sistema.</p>
					<p align="center"><a onMouseOver="return overlib('Según su Usuario y Clave tendrá diferentes niveles de acceso.', ABOVE, RIGHT);"onMouseOut="return nd();"> <img src="../img/conf/help.png" width="16" height="16"></a></p>
				</div>
			</td>	
			
			<td class="intro_sup"> 
				<div align="center">
					<p>&nbsp;</p>
					<p><img id="cambio" src="../img/conf/seguridad.png" width="32" height="32"> 
					<b>Acceder al Sistema</b></p>				
				
					<table width="80%" class="tabla">						
						<tr height="20"> 
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" width="100%" align="center"> <input placeholder="Usuario"onKeyPress="javascript:Cambio('cambio');" onBlur="javascript:Requerido('txt_usuario');" tabindex="1" name="txt_usuario" type="text"  class="auth" id="txt_usuario" required></td>
						</tr>
						
						<tr>
							<td colspan="2" align="center"><input placeholder="Clave" name="txt_pass" onKeyPress="javascript:Cambio('cambio');" onBlur="javascript:Requerido('txt_pass');" type="password" class="auth" id="txt_pass" tabindex="2" required></td>
						</tr>
						<?php						
						if(isset($mensaje))
						{
							if($mensaje!='')
							{	
						?>
						<script language="JavaScript" type="text/javascript">alertify.error('<?php echo $mensaje;?>');</script>
						<?php
							$mensaje='';
							$_GET['mensaje']='';
							}
						}
						?>
						
						<tr height="45"> 
							<td colspan="2" align="center"><img height="35px"; src="captcha-code/captcha.php" border="0" />&nbsp;<input style="height:25px;" type="text" name="code" width="25" /></td>
						</tr>
						
						<tr height="45"> 
							<td colspan="2" align="center"><input class="boton" name="btn_aceptar" type="submit"  value="Entrar"></td>
						</tr>
						
						<?php
						$sql_r="select id_rol from n_rol where predeterminado='1'";//print $sql_p;
						$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
						?>
						
						<tr height="40"> 
							<td colspan="2" align="right"><?php if(isset($rs_r->fields["id_rol"])){?><a href='registro/registro.php'>Crear cuenta</a><?php }?>&nbsp;&nbsp;&nbsp;<a href='enviar_mail_reset.php'>Recuperar contrase&ntilde;a</a>&nbsp;&nbsp;</td>
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
