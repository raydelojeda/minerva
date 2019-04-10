<?php
$_SESSION['rol']='';
$_SESSION["md5_rol"]='';
$_SESSION['user']='';
$_SESSION['md5_password']='';
$_SESSION["ok"] = '';
$_SESSION["modulo"]="";
$x='../../';
include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection
include($x."plantillas/sec_header.php");

$token = $_GET['token'];

$sql = "SELECT * FROM reset_clave WHERE token = '".$token."'";//print $sql;
$rs=$db->Execute($sql) or die($db->ErrorMsg());

if($rs->RecordCount() > 0)
{
?>
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
</script>
	<form name="frm" action="cambiarpassword.php" method="post">          
	<table class="login">
		<tr>		
			<td class="intro_sup"> 
				<div align="center">
					<p><img id="cambio" src="../../img/conf/seguridad.png" width="32" height="32"> 
					<b>Restablecer contrase&ntilde;a</b></p>				
				
					<table width="90%" class="tabla">						
						<tr height="10"> 
							<td colspan="2">&nbsp;</td>
						</tr>
						
						<tr> 
							<td align="right">Clave:</td>
							<td>
								<input placeholder="Ingrese la nueva clave" onkeyup="muestra_seguridad_clave(this.value, this.form)"name="txt_pass" id="txt_pass"  type="password" class="auth" tabindex="2" size="15" style="width:50%;" required>
								<input name="seguridad" type="text" size="5" style="border: 0px; background-color:#e4e4e4; text-decoration:italic;" disabled>
							</td>
						</tr>
						
						<tr> 
							<td align="right">Nueva Clave:</td>
							<td>
								<input  placeholder="Repite la nueva clave" name="txt_pass1" id="txt_pass1"  type="password" class="auth" tabindex="3" size="15" style="width:50%;" required>
							</td>
						</tr>
				
						<tr height="65">
							<td align="center" colspan="2">
								<input type="hidden" name="token" value="<?php echo $token ?>">
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


<?php
}
else
{
	echo ("<script language='JavaScript' type='text/javascript'> location.href='../autenticacion.php?mensaje=Token incorrecto.' </script>");
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
$cadenacheckboxp='';
include($x."plantillas/sec_footer.php");
?>