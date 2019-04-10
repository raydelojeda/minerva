<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="cont";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de cliente"; // para el título
$elemento="cliente"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las clientes registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="cliente";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='persona';

$campo_anidado=array();
$campo_anidado[0]='id_persona';

$order=" factura_apellidos,factura_nombres DESC";

$field[0]='id_cliente'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='factura_nombres';
$field[2]='factura_apellidos';
$field[3]='factura_cedula';
$field[4]='factura_direccion';
$field[5]='factura_telefono';
$field[6]='permite_credito';
$field[7]=$tabla.'.id_persona';
$field[8]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion)";

$field_busqueda=array();
$field_busqueda[0]='persona.primer_nombre'; 
$field_busqueda[1]='persona.segundo_nombre';
$field_busqueda[2]="persona.primer_apellido";
$field_busqueda[3]='persona.identificacion';
$field_busqueda[4]="persona.segundo_apellido";
$field_busqueda[5]='factura_cedula';

$alias_col=array();
$alias_col[0]='id_cliente';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='f_nom';
$alias_col[2]='f_ape';
$alias_col[3]='f_ced';
$alias_col[4]='f_dir';
$alias_col[5]='f_tel';
$alias_col[6]='permite';
$alias_col[7]='id_p';
$alias_col[8]='per';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Nombres en factura';
$columna[2]='Apellidos en factura';
$columna[3]='Identificaci&oacute;n en factura';
$columna[4]='Direcci&oacute;n en factura';
$columna[5]='Tel&eacute;fono en factura';
$columna[6]='Permite cr&eacute;dito';
$columna[7]='Cliente';
$columna[8]='Cliente';

$field_col=array();
$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];
$field_col[4]=$alias_col[4];
$field_col[5]=$alias_col[5];
$field_col[6]=$alias_col[6];
$field_col[7]=$alias_col[7];
$field_col[8]=$alias_col[8];

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=2;
$info_emerg[7]='';
$info_emerg[8]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]=1;
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=1;
$info_col[6]=2;
$info_col[7]='';
$info_col[8]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='11%';
$ancho[2]='11%';
$ancho[3]='9%';
$ancho[4]='28%';
$ancho[5]='9%';
$ancho[6]='5%';
$ancho[7]='';
$ancho[8]='25%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_'.$elemento.'.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Nombres en factura del cliente');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Apellidos en factura del cliente');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n en factura del cliente');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Direcci&oacute;n en factura del cliente');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Tel&eacute;fono en factura del cliente');
$l_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Permite cr&eacute;dito: Si o No');
$l_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Cliente');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[3]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[4]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[5]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
$evento[5]='onkeyup="valida_cedula();" maxlength="10"';

$insert_field[0]='id_cliente'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_persona';// hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='factura_nombres'; 
$insert_field[4]='factura_apellidos';
$insert_field[5]='factura_cedula';
$insert_field[6]='factura_direccion';
$insert_field[7]='factura_telefono';
$insert_field[8]='permite_credito';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[7];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[1];
$insert_alias[4]=$alias_col[2];
$insert_alias[5]=$alias_col[3];
$insert_alias[6]=$alias_col[4];
$insert_alias[7]=$alias_col[5];
$insert_alias[8]=$alias_col[6];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[8]; 
$name_input[2]=$alias_col[8]; 
$name_input[3]=$alias_col[1]; 
$name_input[4]=$alias_col[2]; 
$name_input[5]=$alias_col[3]; 
$name_input[6]=$alias_col[4]; 
$name_input[7]=$alias_col[5]; 
$name_input[8]=$alias_col[6]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[8]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[8];
$label_input[3]=$columna[1];
$label_input[4]=$columna[2];
$label_input[5]=$columna[3];
$label_input[6]=$columna[4];
$label_input[7]=$columna[5];
$label_input[8]=$columna[6];


$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=1;
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='input';
$tipo_input[6]='input';
$tipo_input[7]='input';
$tipo_input[8]='select';

// valores que va a tomar el campo tipo <select> en cada <option>
$g=8;
$j=6;
$f=2;

//$combo_sql[$f] = "select id_persona as id_p, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as per from persona WHERE 1 AND NOT EXISTS (SELECT 1 FROM cliente WHERE cliente.id_persona = persona.id_persona) ORDER BY primer_apellido";
$combo_sql[$f] = "select id_persona as id_p, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as per from persona ORDER BY primer_apellido";


$opt_name=array();
$opt_name[$f][0]='per';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$f][2]='';
$opt_name[$f][3]='';

$opt_value=array();
$opt_value[$f][0]='id_p';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';
$opt_value[$f][2]='';
$opt_value[$f][3]='';

$opt_sel=array();
$opt_sel[$f][0]='id_p';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$f][2]='';
$opt_sel[$f][3]='';

$combo_sql[$g] = "";

$opt_name[$g][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$g][1]='0';


$opt_sel[$g][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$j] = "";

$opt_name[$j][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$j][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$j][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$j][1]='0';


$opt_sel[$j][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$j][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='Rvarchar';
$dato_permit[4]='varchar';
$dato_permit[5]='varchar';
$dato_permit[6]='varchar';
$dato_permit[7]='varchar';
$dato_permit[8]='Rselec';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]='';
$value_input[8]='';

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='50';
$size[6]='50';
$size[7]='50';
$size[8]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Nombres en factura del cliente');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Apellidos en factura del cliente');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n en factura del cliente');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Direcci&oacute;n en factura del cliente');
$n_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Tel&eacute;fono en factura del cliente');
$n_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Permite cr&eacute;dito: Si o No');
$n_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Cliente');

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$m_botones=array(); // botonera que va a tener en el encabezado  (NO TOCAR) 
$m_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$m_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$m_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_Editar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Nombres en factura del cliente');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Apellidos en factura del cliente');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n en factura del cliente');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Direcci&oacute;n en factura del cliente');
$m_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Tel&eacute;fono en factura del cliente');
$m_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Permite cr&eacute;dito: Si o No');
$m_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Cliente');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
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
	document.frm.cedula.value=valida_ced(document.frm.f_ced.value);//cedula;
}
</script>