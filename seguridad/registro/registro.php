<?php
$_SESSION['rol']='';
$_SESSION["md5_rol"]='';
$_SESSION['user']='';
$_SESSION['md5_password']='';
$_SESSION["ok"] = '';
$_SESSION["modulo"]="";

include("variables_registro_usuario.php");
include($x."plantillas/sec_header.php");

$sql_r="select id_rol from n_rol where predeterminado='1'";//print $sql_p;
$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());

if(!isset($rs_r->fields["id_rol"]))
echo ("<script language='JavaScript' type='text/javascript'> location.href='../autenticacion.php?mensaje=No puede registrarse, no hay rol predeterminado disponible.' </script>");

if(isset($_POST['aux_submit']))
{
	if($_POST['clave_registro']==$_POST['clave2'])
	{
		$sql_u="select usuario.id_usuario from usuario where usuario='".$_POST['usuario']."'";//print $sql_p;
		$rs_u=$db->Execute($sql_u) or die($db->ErrorMsg());
		
		if(!isset($rs_u->fields['id_usuario']))
		{
			
			//------------------------------------------------------------------------------------------
			$elem='tipo_sangre';
			$var_var='id_'.$elem;
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			if(!isset($rs->fields['id_'.$elem]))
			{
				$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
				$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
				
				$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
				
				$$var_var=$rs->fields['id_'.$elem];
			}
			else
			$$var_var=$rs->fields['id_'.$elem];
			//------------------------------------------------------------------------------------------
			
			//------------------------------------------------------------------------------------------
			$elem='tipo_identificacion';
			$var_var='id_'.$elem;
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			if(!isset($rs->fields['id_'.$elem]))
			{
				$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
				$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
				
				$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
				
				$$var_var=$rs->fields['id_'.$elem];
			}
			else
			$$var_var=$rs->fields['id_'.$elem];
			//------------------------------------------------------------------------------------------
			
			//------------------------------------------------------------------------------------------
			$elem='genero';
			$var_var='id_'.$elem;
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			if(!isset($rs->fields['id_'.$elem]))
			{
				$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
				$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
				
				$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
				
				$$var_var=$rs->fields['id_'.$elem];
			}
			else
			$$var_var=$rs->fields['id_'.$elem];
			//------------------------------------------------------------------------------------------
			
			//------------------------------------------------------------------------------------------
			$elem='pais';
			$var_var='id_'.$elem;
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			if(!isset($rs->fields['id_'.$elem]))
			{
				$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
				$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
				
				$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
				
				$$var_var=$rs->fields['id_'.$elem];
			}
			else
			$$var_var=$rs->fields['id_'.$elem];
			//------------------------------------------------------------------------------------------
			
			$sql_i="INSERT INTO persona (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, identificacion, fecha_nacimiento, direccion, email, telefono1, telefono2, residencia, id_genero, id_pais, id_tipo_sangre, id_tipo_identificacion) 
			VALUES ('".$_POST['prin']."', '".$_POST['segn']."', '".$_POST['pria']."', '".$_POST['sega']."', '".$_POST['ide']."', '".$_POST['fec']."', '".$_POST['dir']."', '".$_POST['ema']."', '".$_POST['tel1']."', '".$_POST['tel2']."', '".$_POST['res']."', '".$id_genero."', '".$id_pais."', '".$id_tipo_sangre."', '".$id_tipo_identificacion."')";//print $sql_i;
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$sql_p="select persona.id_persona from  persona where identificacion='".$_POST['ide']."'";//print $sql_p;
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
			$return[1]=$rs_p->fields['id_persona'];
			//$_POST['clave_registro']=md5($_POST['clave_registro']);	
			/*include("variables_registro_usuario.php");
			$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);*/
			//$id_usuario=$return[1];
			
			$sql_i="INSERT INTO usuario (usuario, clave, activo, id_persona) 
			VALUES ('".$_POST['usuario']."', '".md5($_POST['clave_registro'])."', '1', '".$return[1]."')";//print $sql_i;
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$i_sql="SELECT LAST_INSERT_ID() AS myid";
			$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
			
			$id_usuario=$rs->fields['myid'];
			
			for($r=0;$r<$rs_r->RecordCount();$r++)
			{
				$id_rol=$rs_r->fields['id_rol'];
				
				$sql_i="INSERT INTO usuario_rol (id_usuario, id_rol) 
				VALUES ('".$id_usuario."', '".$id_rol."')";//print $sql_i;
				$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
				
			$rs_r->MoveNext();
			}
			
			if(!$mensaje)
			echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../autenticacion.php?mensaje=Se ha creado su cuenta satisfactoriamente.'</script>");

		}
		else
		$mensaje='Ya existe el nombre de usuario.';
	}
	else
	$mensaje='Las claves no coinciden.';
	
	$obj->Imprimir_mensaje($mensaje);
}
?>
<form method="post" name="frm" id="frm" action="" enctype="multipart/form-data">
<table class="menubar" id="toolbar">
	<tr>
		<td class="img_encabezado"><img src="<?php echo $x.$img_encabezado;?>" width="48" height="48" border="0"></td>
		<td class="titulo_encabezado"><?php echo $titulo_nuevo;?></td>
		
		<?php for($btn=0;$btn<sizeof($n_botones);$btn++){?>
		
		<td class="botonera_encabezado"> 
			<div>
				<a class="toolbar" target="<?php print($n_botones[$btn]['target']);?>" href="<?php print($n_botones[$btn]['href']);?>" onClick="<?php print($n_botones[$btn]['onclic']);?>">
					<img src="<?php print($n_botones[$btn]['src']);?>" alt="<?php print($n_botones[$btn]['texto']);?>" name="<?php print($n_botones[$btn]['nombre']);?>" width="32" height="32" border="0" id="<?php print($n_botones[$btn]['nombre']);?>">
					<br>
					<?php print($n_botones[$btn]['texto']);?>	
				</a>
			</div>
		</td>
		
		<?php }?>
		
	</tr>
</table>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
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
	if(formulario.clave_registro.value!=clave)
	{formulario.clave2.style.borderColor  = "#FF0000";formulario.coincide.style.color='#FF0000';formulario.coincide.value='La clave no coincide';}
	else if(formulario.clave_registro.value==clave)
	{formulario.clave2.style.borderColor  = "#04B404";formulario.coincide.value='';}
}
</script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Datos personales</h2>			
			
			<?php
			print "<div style='float:right;'><input name='cedula' type='text' size='42' style='border: 0px; background-color:ffffff; text-decoration:italic;' onfocus='blur();'></div>";
			include("variables_registro_persona.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
			print '* Requerido';
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
		</div>

		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Datos de usuario</h2>			
			
			
			<div style="display: table-row; width: 100%;">
			<div style="height: 22px; width: 35%; display: table-cell; text-align: right;">Nombre de usuario:</div>
			<div style="display: table-cell; text-align: left; width: 100%;">
			<input type="text" placeholder="Ingrese un nombre de usuario nuevo" name="usuario" title="Nombre de usuario" id="usuario" onclick="" size="40" maxlength="40" value=""/>
			*  
			<?php $msg='Para escoger un nombre de usuario, aconsejamos utilizar la letra inicial de su nombre o de ambos nombres, seguido del apellido. El nombre de usuario puede contener letras y n&uacute;meros, este debe ser &uacute;nico.';?>
			<a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
			
			</div>
			</div>
			<div style="display: table-row; width: 100%;">
			<div style="height: 22px; width: 35%; display: table-cell; text-align: right;">Clave:</div>
			<div style="display: table-cell; text-align: left; width: 100%;">
			<input type="password" onkeyup="muestra_seguridad_clave(this.value, this.form)" value="" placeholder="Ingrese una clave nueva" name="clave_registro" title="Clave" id="clave_registro" onclick="" size="40" maxlength="40"/>
			*
			<input name="seguridad" type="text" size="5" style="border: 0px; background-color:ffffff; text-decoration:italic;" disabled>
			
			</div>
			</div>
			<div style="display: table-row; width: 100%;">
			<div style="height: 22px; width: 35%; display: table-cell; text-align: right;">Confirmar clave:</div>
			<div style="display: table-cell; text-align: left; width: 100%;">
			<input type="password" value="" onkeyup="confirmar_clave(this.value, this.form)" placeholder="Ingrese nuevamente la clave" name="clave2" title="Confirmar clave" id="clave2" onclick="" size="40" maxlength="40"/>
			*
			<input name="coincide" type="text" size="25" style="border: 0px; background-color:ffffff; text-decoration:italic;" onfocus="blur()">
			</div>
			</div>
			<?php
			//include("variables_registro_usuario.php");		
			//$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
			
			
			
			print '* Requerido';			
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>			
		</div>
		
	</div>
</div>

<script type="text/javascript">setupAllTabs();</script>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/sec_footer.php");
?>