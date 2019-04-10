<?php
	function generarLinkTemporal($idusuario){

		include("../../adodb519/adodb.inc.php");  //adodb library
		include("../../coneccion/conn.php"); //conection

		$cadena = $idusuario.rand(1,9999999).date('Y-m-d');
		$token = md5(md5(md5($cadena)));
		
		$sql = "INSERT INTO reset_clave (id_usuario, token, caducidad) VALUES($idusuario,'$token',NOW());";
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		
		if(isset($rs)){
			$enlace = 'https://'.$_SERVER["SERVER_NAME"].'/minerva/seguridad/reset_clave/restablecer.php?token='.$token;
			return $enlace;
		}
		else
			return FALSE;
	}

	function enviarEmail($email, $link)
	{
		$x='../../';
		include($x."config/variables.php");
		include($x."config/clases.inc.php");
		$clases = new clases();
		
		date_default_timezone_set('Etc/UTC');
		include_once("../../include/PHPMailer-master/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		
		$body = '<p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
 			<p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
 			<p>
 				<strong>Enlace para restablecer tu contraseña</strong><br>
 				<a href="'.$link.'"> Restablecer contraseña </a>
 			</p>
			
			<p>
 				<strong>Si no funciona el enlace lo puede copiar y pegar en la URL del navegador</strong><br>
 				'.$link.'
			</p>';
		$body = utf8_decode($body);
		
		$host="smtp.gmail.com";
		$port=465;
		$sec="ssl";
		$from=$mail_sistema;
		$pass=$clave_mail;
		$name=$nombre_sucursal." - ".$titulo_sitio;
		$para=$email;//$rs_fam->fields['email'];
		$asunto="Recuperar clave de acceso";
		$adjunto="";
		$clases->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
	}
	
include_once("../../adodb519/adodb.inc.php");  //adodb library
include_once("../../coneccion/conn.php"); //conection

$email = strip_tags($_POST['email']);
$respuesta = new stdClass();

if($email != ""){   
	

	$sql = " SELECT * FROM usuario, persona WHERE usuario.id_persona=persona.id_persona AND email = '".$email."'";
	$rs=$db->Execute($sql) or die($db->ErrorMsg());

	if($rs->RecordCount() > 0)
	{
		
		$linkTemporal = generarLinkTemporal($rs->fields['id_usuario']);
		if($linkTemporal){
			enviarEmail($email, $linkTemporal);
			$respuesta->mensaje = '<div class="alert alert-info"> Un correo ha sido enviado a su cuenta de email con las instrucciones para restablecer la contraseña </div>';
		}
	}
	else
	{
		$sql = " SELECT * FROM usuario, persona, empleado WHERE persona.id_persona=empleado.id_persona AND usuario.id_persona=persona.id_persona AND email_inst = '".$email."'";
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		if($rs->RecordCount() > 0)
		{
			$linkTemporal = generarLinkTemporal($rs->fields['id_usuario']);
			if($linkTemporal){
				enviarEmail($email, $linkTemporal);
				$respuesta->mensaje = '<div class="alert alert-info"> Un correo ha sido enviado a su cuenta de email con las instrucciones para restablecer la contraseña </div>';
			}
		}
		else
		$respuesta->mensaje = '<div class="alert alert-warning"> No existe una cuenta asociada a ese correo.</div>';
	}
	
}
else
	$respuesta->mensaje= "Debes introducir el email de la cuenta.";
echo json_encode( $respuesta );