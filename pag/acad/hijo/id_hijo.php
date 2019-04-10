<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

$sql_p="select id_persona as id_p, primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,identificacion from persona ORDER BY primer_apellido, segundo_apellido ASC";//print $sql_m;
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());//print $rs_p;

if(isset($_POST['identificacion']))
{
	if($_POST['identificacion']!='')
	{
		/*if(strpos($_POST['identificacion2'], ' '))
		$pos_final=strpos($_POST['identificacion2'], ' ');
		else
		$pos_final=strlen($_POST['identificacion2']);
	
	
		$id=substr($_POST['identificacion2'], 0, $pos_final);
		//print $id;*/
		
		$sql_id="select id_persona from persona WHERE identificacion='".$_POST['identificacion']."'";//print $sql_id;
		$rs_id=$db->Execute($sql_id) or die($db->ErrorMsg());//print $rs_p;
		//die();
		if(isset($rs_id->fields['id_persona']))
		{
			$sql_p="SELECT id_estudiante FROM estudiante WHERE id_persona='".$rs_id->fields['id_persona']."'";
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

			if(isset($rs_p->fields['id_estudiante']))
			$mensaje='El estudiante ya existe, contacte a la instituci&oacute;n o a su representante para agregarse Ud. como familiar.';
			else
			$mensaje='La identificaci&oacute;n ya pertenece a un empleado o familiar.';
		
			
		}
		else
		echo ("<script language='JavaScript' type='text/javascript'> location.href='new_hijo.php?ident=".$_POST['identificacion']."'</script>");
	}
	else
	$mensaje='El campo Identificaci&oacute;n es requerido';
}
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);	
$mensaje='';
$return[0]='';
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

<script type="text/javascript">
function most()
{/*
	obj1 = document.getElementById('identificacion1');
	obj2 = document.getElementById('identificacion2');
	obj2.focus();
	obj2.value=obj1.value;
	obj1.style.display = 'none';
	obj2.style.display = 'block';
	
	*/
}

function valida_parentesco() 
{
	
	document.frm.submit();
}

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
function valida_cedula(cedula)
{
	document.frm.cedula.value=valida_ced(cedula);//cedula;
}

/*onkeypress="setTimeout(most, 1000);
<input type="search" onkeyup="valida_cedula(this.value)" onchange="valida_cedula(this.value)"onclick="valida_cedula(this.value)" placeholder="C&eacute;dula/Pasaporte" autocomplete="off" list="identificacion" name="identificacion2" id="identificacion2" size="50" style="display:none;" required/>

	
		
		<datalist id="identificacion" style="display: none;" onchange="valida_cedula(this.value)"onclick="valida_cedula(this.value)">
			<?php $rs_p->MoveFirst();for($e=0;$e<$rs_p->RecordCount();$e++){?>	
				<option onclick="valida_cedula(this.value)" value="<?php print $rs_p->fields['identificacion'].' ('.$rs_p->fields['primer_apellido'].' '.$rs_p->fields['segundo_apellido'].' '.$rs_p->fields['primer_nombre'].' '.$rs_p->fields['segundo_nombre'].')';?>">
			<?php $rs_p->MoveNext();}?>
		</datalist>
*/
</script>
<tr>
	<td align="right" height="50" width='25%'>
		Identificaci&oacute;n:
	</td>
		
	<td width='75%'>
		<input type="search" onkeyup="valida_cedula(this.value);" placeholder="C&eacute;dula/Pasaporte" autocomplete="off" name="identificacion" id="identificacion" maxlength='10' size="15"/>
	
	
		<input name="cedula" type="text" size="50" style="border: 0px; background-color:ffffff; text-decoration:italic;" onfocus="blur()">
	</td>
</tr>
<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>