<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

$mod='';

$sql_r="select id_rol from n_rol where predeterminado='1'";//print $sql_p;
$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());

$sql_u="SELECT usuario.id_usuario FROM usuario WHERE 1 AND usuario='".$_SESSION['user']."'";//print $sql_f; die();
$rs_u=$db->Execute($sql_u) or die($db->ErrorMsg());

if(!isset($rs_r->fields["id_rol"]))
echo ("<script language='JavaScript' type='text/javascript'> location.href='../autenticacion.php?mensaje=No puede Editar su perfil, no hay rol predeterminado disponible.' </script>");

$sql_f="SELECT familiar.id_familiar FROM familiar, persona, usuario WHERE 1 AND persona.id_persona=familiar.id_persona
AND persona.id_persona=usuario.id_persona AND usuario='".$_SESSION['user']."'";//print $sql_f; die();
$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());

if(isset($rs_f->fields['id_familiar']))
{
	$mod=$rs_f->fields['id_familiar'];
	$s_rs=$obj->Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias);
}

//--------------LLENAR CAJAS PARA PERSONA--------------
$sql_p="SELECT persona.id_persona FROM  persona, usuario WHERE 1
AND persona.id_persona=usuario.id_persona AND usuario='".$_SESSION['user']."'";//print $sql_f; die();
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$id_persona=$rs_p->fields['id_persona'];
include($x."pag/rrhh/persona/variables.php");

$s_rs2=$obj->Consulta_llenar_cajas($id_persona,$insert_field,$tabla,$db,$columna,$insert_alias);
//--------------LLENAR CAJAS PARA PERSONA--------------

//--------------LLENAR CAJAS PARA PREFERENCIAS--------------
$sql_pre="SELECT envio_calificacion_baja, empleado.id_empleado FROM  persona, empleado, control_notificaciones_automaticas WHERE 1
AND persona.id_persona=empleado.id_persona 
AND control_notificaciones_automaticas.id_empleado=empleado.id_empleado
AND persona.id_persona='".$id_persona."'";//print $sql_f; die();
$rs_pre=$db->Execute($sql_pre) or die($db->ErrorMsg());

$sql_emp="SELECT id_empleado FROM empleado WHERE 1
AND id_persona='".$id_persona."'";//print $sql_f; die();
$rs_emp=$db->Execute($sql_emp) or die($db->ErrorMsg());
//--------------LLENAR CAJAS PARA PREFERENCIAS--------------

if(!$s_rs2)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_familiar.php'</script>");

if(isset($_POST[$inputs[0]['name_input']]))
{
	include($x."pag/rrhh/persona/variables.php");
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$id_persona,$tipo_input,$value_input,$x);
	$obj->Imprimir_mensaje($mensaje);
	
	$return[1]=$id_persona;//print $return[1];
	
	if(isset($rs_f->fields['id_familiar']))
	{
		include("variables.php");
		$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
		$obj->Imprimir_mensaje($mensaje);
	}
	else
	{
		if(isset($return[1]) AND $return[1]!='')
		{	
			include("variables.php");
			$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
		}
	}
	
	$id_usuario=$rs_u->fields['id_usuario'];
	for($r=0;$r<$rs_r->RecordCount();$r++)
	{
		$id_rol=$rs_r->fields['id_rol'];		
		
		$sql_us="SELECT usuario.id_usuario FROM usuario, usuario_rol WHERE 1 AND usuario.id_usuario=usuario_rol.id_usuario
		AND usuario.id_usuario='".$id_usuario."' AND usuario_rol.id_rol='".$id_rol."'";//print $sql_us; //
		$rs_us=$db->Execute($sql_us) or die($db->ErrorMsg());
		
		if(!isset($rs_us->fields['id_usuario']))
		{
			$sql_i="INSERT INTO usuario_rol (id_usuario, id_rol) 
			VALUES ('".$id_usuario."', '".$id_rol."')";//print $sql_i;die();
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
		}
		
	$rs_r->MoveNext();
	}
	if(isset($rs_emp->fields['id_empleado']))
	{
		if(isset($_POST['cbx_notif']))$cbx_notif=$_POST['cbx_notif'];else $cbx_notif=0;
		if(isset($rs_pre->fields['envio_calificacion_baja']))
		{
			$upd="UPDATE control_notificaciones_automaticas SET envio_calificacion_baja='".$cbx_notif."' WHERE id_empleado='".$rs_pre->fields['id_empleado']."'";//print $upd;// die();
			$db->Execute($upd) or die($db->ErrorMsg());
		}
		else
		{	
			$sql_i="INSERT INTO control_notificaciones_automaticas (envio_calificacion_baja, id_empleado) 
			VALUES ('".$cbx_notif."', '".$rs_emp->fields['id_empleado']."')";//print $sql_i;die();
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
		}
	}
	
	if(!$mensaje)
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='".$x."pag/panel/panel.php?mensaje=Datos guardados satisfactoriamente.'</script>");
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script><script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Datos personales</h2>
			
			<?php
			print "<div style='position:absolute;right:10%;z-index:5;valign:top;'><input name='cedula' type='text' size='42' style='border: 0px; background-color:ffffff; text-decoration:italic;' onfocus='blur();'></div>";
			?>
			
			<div style='position:absolute;right:1%;z-index:5;valign:top;'>			
				<?php				
				include($x."pag/rrhh/persona/variables.php");				
				$camp=$s_rs2->fields[$field_col[20]];			
				if(base64_encode($camp))
				echo '<img style="margin:3px;border-radius:8px;" width="100px" src="data:image/jpeg;base64,'. base64_encode($camp). '"/>';
				else
				echo '<img style="margin:3px;border-radius:8px;" width="100px" src="'.$x.'img/general/no_disponible.png"/>';
				?>			
			</div>
			
			<?php
			
			$obj->Generar_inputs($inputs,$s_rs2,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
		</div>
		
		<script language="JavaScript" type="text/javascript">
			valida_cedula();
		</script>

		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Datos adicionales</h2>			

			<div style='position:absolute;right:1%;z-index:5;'>			
				<?php
				include($x."pag/rrhh/persona/variables.php");
				
				$camp=$s_rs2->fields[$field_col[20]];			
				if(base64_encode($camp))
				echo '<img style="margin:3px;border-radius:8px;" width="100px" src="data:image/jpeg;base64,'. base64_encode($camp). '"/>';
				else
				echo '<img style="margin:3px;border-radius:8px;" width="100px" src="'.$x.'img/general/no_disponible.png"/>';
				?>			
			</div>
			
			<!--<div style='display:table;height:300px;width:70%;'>-->
			
			<?php
			include("variables.php");
			
			if(isset($s_rs))
			$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			else
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>			
		</div>
		
		<?php if(isset($rs_emp->fields['id_empleado'])){?>
		
		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Preferencias</h2>
			
			<div style='display:table;width:100%;'>
				<div style='display:table-row'>
					<div style='display:table-cell;height:22px;text-align:right;width:30%;'>
						Enviar correo autom&aacute;ticamente en bajas calificaciones:
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;width:70%;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_notif' value='1' <?php if($rs_pre->fields['envio_calificacion_baja']=='1')print 'checked';?> type="checkbox" id="cbx_notif" />
								<label for="cbx_notif"></label>
							</div>
						</section>
					</div>
				</div>
			</div>	
		</div>
		<?php }?>
		
	</div>
</div>

<script type="text/javascript">setupAllTabs();</script>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>
<script type="text/javascript">
function valida_ced(cedula)
{
	//alert(cedula);
	var msg='';

     //Preguntamos si la cedula consta de 10 digitos
     if(cedula.length == 10){
        
        //Obtenemos el digito de la region que sonlos dos primeros digitos
        var digito_region = cedula.substring(0,2);
        
        //Pregunto si la region existe ecuador se divide en 24 regiones
        if( digito_region >= 1 && digito_region <=24 ){
          
          // Extraigo el ultimo digito
          var ultimo_digito   = cedula.substring(9,10);

          //Agrupo todos los pares y los sumo
          var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));

          //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
          var numero1 = cedula.substring(0,1);
          var numero1 = (numero1 * 2);
          if( numero1 > 9 ){ var numero1 = (numero1 - 9); }

          var numero3 = cedula.substring(2,3);
          var numero3 = (numero3 * 2);
          if( numero3 > 9 ){ var numero3 = (numero3 - 9); }

          var numero5 = cedula.substring(4,5);
          var numero5 = (numero5 * 2);
          if( numero5 > 9 ){ var numero5 = (numero5 - 9); }

          var numero7 = cedula.substring(6,7);
          var numero7 = (numero7 * 2);
          if( numero7 > 9 ){ var numero7 = (numero7 - 9); }

          var numero9 = cedula.substring(8,9);
          var numero9 = (numero9 * 2);
          if( numero9 > 9 ){ var numero9 = (numero9 - 9); }

          var impares = numero1 + numero3 + numero5 + numero7 + numero9;

          //Suma total
          var suma_total = (pares + impares);

          //extraemos el primero digito
          var primer_digito_suma = String(suma_total).substring(0,1);

          //Obtenemos la decena inmediata
          var decena = (parseInt(primer_digito_suma) + 1)  * 10;

          //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
          var digito_validador = decena - suma_total;

          //Si el digito validador es = a 10 toma el valor de 0
          if(digito_validador == 10)
            var digito_validador = 0;

          //Validamos que el digito validador sea igual al de la cedula
          if(digito_validador == ultimo_digito){
            msg='La c\u00e9dula: ' + cedula + ' es correcta';
			document.frm.cedula.style.color='#04B404';
          }else{
            msg='La identificacion: ' + cedula + ' no es una c\u00e9dula';
			document.frm.cedula.style.color='#FF0000';
          }
          
        }else{
          // imprimimos en consola si la region no pertenece
          msg='Si es una c\u00e9dula no pertenece a ninguna regi\u00f3n';
		  document.frm.cedula.style.color='#FF0000';
        }
     }else{
	 //alert(cedula);
        //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
        msg='Si es una c\u00e9dula tiene menos de 10 d\u00edgitos';
		document.frm.cedula.style.color='#FF0000';
     }  
return msg
}
function valida_cedula()
{	
	//alert(cedula);
	document.frm.cedula.value=valida_ced(document.frm.ide.value);//cedula;
}
</script>