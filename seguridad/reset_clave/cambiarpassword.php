<?php
$x='../../';
include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection

$password1 = $_POST['txt_pass'];
$password2 = $_POST['txt_pass1'];
$token = $_POST['token'];

if($password1 != "" && $password2 != "" && $token != "")
{

	$sql = "SELECT * FROM reset_clave WHERE token = '$token'";
	$rs=$db->Execute($sql) or die($db->ErrorMsg());
	
	if($rs->RecordCount() > 0)
	{
		if(isset($rs->fields['id_usuario']))
		{
			if( $password1 === $password2 )
			{
				$sql = "UPDATE usuario SET clave = '".password_hash($password1, PASSWORD_BCRYPT)."' WHERE id_usuario = ".$rs->fields['id_usuario'];
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
				if(isset($rs))
				{
					$sql = "DELETE FROM reset_clave WHERE token = '$token';";
					$rs=$db->Execute($sql) or die($db->ErrorMsg());
					$mensaje='La clave se ha actualizado correctamente.';
				}
				else
				{
					$mensaje='Ocurri&oacute; un error.';
				}
			}
			else
			{
				$mensaje='Las claves no coinciden.';
			}

		}
		else
		{
			$mensaje='El token no es correcto.';
		}	
	}
	else
	{
		$mensaje='El token no es correcto.';
	}

}
else
{
	$mensaje='Debe llenar todos los datos.';
}

echo ("<script language='JavaScript' type='text/javascript'> location.href='../autenticacion.php?mensaje=".$mensaje.".' </script>");
?>