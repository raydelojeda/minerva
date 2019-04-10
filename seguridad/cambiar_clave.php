<?php

$_SESSION["ok"] = '';
$_SESSION["modulo"]='';
$_SESSION["rol"] = '';
$_SESSION["user"] = '';
$_SESSION["id_user"] = '';
$_SESSION["md5_rol"]='';

include("variables.php");
include($x."plantillas/sec_header.php");

if (isset($_POST['btn_aceptar']) AND isset($_POST['txt_nclave'])) 
{
	$mensaje = "";
	$txt_user = strip_tags($_POST['txt_usuario']);
	$txt_pass = strip_tags($_POST['txt_pass']);
	$txt_nclave = strip_tags($_POST['txt_nclave']);
	$txt_nclave1 = strip_tags($_POST['txt_confirmar']);	
	
	if($txt_user == "" || $txt_pass == "" || $txt_nclave == "" || $txt_nclave1 == "" )
	 $mensaje="Debe llenar todos los campos";
	else
	{		 
		$clave_old = strip_tags($_POST['txt_pass']);
		$clave = strip_tags($_POST['txt_nclave']);
		$clave1 = strip_tags($_POST['txt_confirmar']);
		$txt_user = strip_tags($_POST['txt_usuario']);
		
		if($clave==$clave1)
		{
			

			$sql="select id_usuario, clave from usuario where usuario='$txt_user'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			$hash=$rs->fields["clave"];
		
			if(password_verify($clave_old, $hash))
			{ 
				$sql = "UPDATE usuario SET  clave = '".password_hash($clave, PASSWORD_BCRYPT)."' WHERE id_usuario = '".$rs->fields["id_usuario"]."'";//print $sql;	
				$rs = $db->Execute($sql) or $mensaje=$db->ErrorMsg();
				echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='autenticacion.php'</script>");
			} 
			else
			{$mensaje = "Nombre de usuario o clave incorrecto.";}
		}
		else
		{$mensaje = "Debe confirmar correctamente la nueva contraseña.";}	
	
	}		  	
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<script type="text/javascript">
var numeros="0123456789";
var letras="abcdefghyjklmnñopqrstuvwxyz";
var letras_mayusculas="ABCDEFGHYJKLMNÑOPQRSTUVWXYZ";

function tiene_numeros(texto){
   for(i=0; i<texto.length; i++){
      if (numeros.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

function tiene_letras(texto){
   texto = texto.toLowerCase();
   for(i=0; i<texto.length; i++){
      if (letras.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

function tiene_minusculas(texto){
   for(i=0; i<texto.length; i++){
      if (letras.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

function tiene_mayusculas(texto){
   for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}



function seguridad_clave(clave){
var seguridad = 0;
if (clave.length!=0)
{
	if (tiene_numeros(clave) && tiene_letras(clave))
	{
		seguridad += 30;
	}
	
	if (tiene_minusculas(clave) && tiene_mayusculas(clave))
	{
		seguridad += 30;
	}
	if (clave.length >= 4 && clave.length <= 5)
	{
		seguridad += 10;
	}
	else
	{
		if (clave.length >= 6 && clave.length < 8)
		{
			seguridad += 30;
		}
		else
		{
			if (clave.length >= 8)
			{
				seguridad += 40;
			}
		}
	}
}
return seguridad            
}  

function muestra_seguridad_clave(clave,formulario)
{
	seguridad=seguridad_clave(clave);
	formulario.seguridad.value=seguridad + "%";
	if(seguridad<30)
	formulario.seguridad.style.backgroundColor = "#FF0000";
	else if(seguridad>=30 && seguridad<40)
	formulario.seguridad.style.backgroundColor = "#FF4000";
	else if(seguridad>=40 && seguridad<60)
	formulario.seguridad.style.backgroundColor = "#FFBF00";
	else if(seguridad>=60 && seguridad<80)
	formulario.seguridad.style.backgroundColor = "#BFFF00";
	else if(seguridad=100)
	formulario.seguridad.style.backgroundColor = "#04B404";
}

function confirmar_clave(clave,formulario)
{	
	if(formulario.txt_nclave.value!=clave)
	{formulario.txt_confirmar.style.borderColor  = "#FF0000";formulario.coincide.style.color='#FF0000';formulario.coincide.value='La clave no coincide';}
	else if(formulario.txt_nclave.value==clave)
	{formulario.txt_confirmar.style.borderColor  = "#04B404";formulario.coincide.value='';}
}
</script>

<form name="frm" method="post" action="" onSubmit="javascript:valida_pass('cambiar');">          
	<table class="login">
		<tr>		
			<td class="intro_sup"> 
				<div align="center">
					<p><img id="cambio" src="../img/conf/seguridad.png" width="32" height="32"> 
					<b>Cambiar contrase&ntilde;a</b></p>				
				
					<table width="90%" class="tabla">						
						<tr height="10"> 
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr> 
							<td width="35%" align="right">Usuario:</td>
							<td width="65%"> <input placeholder="Ingrese el nombre de usuario" onKeyPress="javascript:Cambio('cambio');" tabindex="1" name="txt_usuario"id="txt_usuario" type="text"  class="auth" size="15" style="width:50%;"></td>
						</tr>
						
						<tr> 
							<td align="right">Clave:</td>
							<td><input placeholder="Ingrese la clave actual" name="txt_pass" id="txt_pass" onKeyPress="javascript:Cambio('cambio');" type="password" class="auth" tabindex="2" size="15" style="width:50%;"></td>
						</tr>
						
						<tr> 
							<td align="right">Nueva Clave:</td>
							<td>
								<input onkeyup="muestra_seguridad_clave(this.value, this.form)" placeholder="Ingrese la nueva clave" name="txt_nclave" id="txt_nclave" onKeyPress="javascript:Cambio('cambio');" type="password" class="auth" tabindex="3" size="15" style="width:50%;">*
								<input name="seguridad" type="text" size="5" style="border: 0px; background-color:#e4e4e4; text-decoration:italic;" disabled>
							</td>
						</tr>
						
						<tr> 
							<td align="right">Confirmar Nueva Clave:</td>
							<td>
								<input onkeyup="confirmar_clave(this.value, this.form)" placeholder="Por favor, confirma la nueva clave" name="txt_confirmar" id="txt_confirmar" onKeyPress="javascript:Cambio('cambio');" type="password" class="auth" tabindex="4" size="15" style="width:50%;">*
								<input name="coincide" type="text" size="25" style="border: 0px; background-color:#e4e4e4; text-decoration:italic;" onfocus="blur()">
							</td>
						</tr>
						
						<?php if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);?>
						
						<tr height="65"> 
							<td align="center" colspan="2">
								<input class="boton" name="btn_aceptar" type="submit" value="Aceptar" style="width:30%;">
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

