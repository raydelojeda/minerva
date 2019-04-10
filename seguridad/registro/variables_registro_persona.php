<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="rrhh";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de persona"; // para el título
$elemento="persona"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": Editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las personas registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="persona";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_pais';
$tabla_anidada[1]='n_genero';
$tabla_anidada[2]='n_tipo_sangre';
$tabla_anidada[3]='n_tipo_identificacion';

$campo_anidado=array();
$campo_anidado[0]='id_pais';
$campo_anidado[1]='id_genero';
$campo_anidado[2]='id_tipo_sangre';
$campo_anidado[3]='id_tipo_identificacion';

$order=" primer_apellido,segundo_apellido,primer_nombre,segundo_nombre DESC";

$field=array();
$field[0]='id_persona'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='primer_nombre';
$field[2]='segundo_nombre';
$field[3]='primer_apellido';
$field[4]='segundo_apellido';
$field[5]='identificacion';
$field[6]='fecha_nacimiento';
$field[7]='direccion';
$field[8]='email';
$field[9]='telefono1';
$field[10]='telefono2';
$field[11]='residencia';
$field[12]=$tabla.'.id_pais';
$field[13]='pais';
$field[14]=$tabla.'.id_genero';
$field[15]='genero';
$field[16]=$tabla.'.id_tipo_sangre';
$field[17]='tipo_sangre';
$field[18]=$tabla.'.id_tipo_identificacion';
$field[19]='tipo_identificacion';
$field[20]='camino_foto';

$alias_col=array();
$alias_col[0]='id_persona';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='prin';
$alias_col[2]='segn';
$alias_col[3]='pria';
$alias_col[4]='sega';
$alias_col[5]='ide';
$alias_col[6]='fec';
$alias_col[7]='dir';
$alias_col[8]='ema';
$alias_col[9]='tel1';
$alias_col[10]='tel2';
$alias_col[11]='res';
$alias_col[12]='id_p';
$alias_col[13]='pais';
$alias_col[14]='id_g';
$alias_col[15]='gen';
$alias_col[16]='id_t';
$alias_col[17]='tip';
$alias_col[18]='id_i';
$alias_col[19]='tide';
$alias_col[20]='c_f';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Primer nombre';
$columna[2]='Segundo nombre';
$columna[3]='Primer apellido';
$columna[4]='Segundo apellido';
$columna[5]='Identificaci&oacute;n';
$columna[6]='Nacimiento';
$columna[7]='Direcci&oacute;n';
$columna[8]='Correo';
$columna[9]='Tel&eacute;fono';
$columna[10]='Celular';
$columna[11]='Tiene residencia?';
$columna[12]='Nacionalidad';
$columna[13]='Nacionalidad';
$columna[14]='G&eacute;nero';
$columna[15]='G&eacute;nero';
$columna[16]='Tipo de sangre';
$columna[17]='Tipo de sangre';
$columna[18]='Tipo de identificaci&oacute;n';
$columna[19]='Tipo de identificaci&oacute;n';
$columna[20]='Foto';

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
$field_col[9]=$alias_col[9];
$field_col[10]=$alias_col[10];
$field_col[11]=$alias_col[11];
$field_col[12]=$alias_col[12];
$field_col[13]=$alias_col[13];
$field_col[14]=$alias_col[14];
$field_col[15]=$alias_col[15];
$field_col[16]=$alias_col[16];
$field_col[17]=$alias_col[17];
$field_col[18]=$alias_col[18];
$field_col[19]=$alias_col[19];
$field_col[20]=$alias_col[20];

$info_emerg=array();
$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]=1;
$info_emerg[11]=2;
$info_emerg[12]='';
$info_emerg[13]=1;
$info_emerg[14]='';
$info_emerg[15]=1;
$info_emerg[16]='';
$info_emerg[17]=1;
$info_emerg[18]='';
$info_emerg[19]=1;
$info_emerg[20]='';

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]='';
$info_col[3]=1;
$info_col[4]='';
$info_col[5]=1;
$info_col[6]='';
$info_col[7]='';
$info_col[8]=1;
$info_col[9]=1;
$info_col[10]='';
$info_col[11]=2;
$info_col[12]='';
$info_col[13]=1;
$info_col[14]='';
$info_col[15]=1;
$info_col[16]='';
$info_col[17]='';
$info_col[18]='';
$info_col[19]='';
$info_col[20]='img_doc';

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='15%';
$ancho[2]='';
$ancho[3]='15%';
$ancho[4]='';
$ancho[5]='12%';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='14%';
$ancho[9]='10%';
$ancho[10]='';
$ancho[11]='10%';
$ancho[12]='';
$ancho[13]='10%';
$ancho[14]='';
$ancho[15]='10%';
$ancho[16]='';
$ancho[17]='';
$ancho[18]='';
$ancho[19]='';
$ancho[20]='2%';

$var_mod='';
$columna_suma[0]='';
$href_m=$x.$camino.'/mod_'.$elemento.'.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Primer nombre de la persona');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Segundo nombre de la persona');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Primer apellido de la persona');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Segundo apellido de la persona');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Identificaci&oacute;n de la persona');
$l_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Nacimiento de la persona');
$l_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Direcci&oacute;n de la persona');
$l_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Correo electr&oacute;nico de la persona');
$l_label_ayuda[8]=array('texto'=>$columna[9],'exp'=>'Tel&eacute;fono de la persona');
$l_label_ayuda[9]=array('texto'=>$columna[10],'exp'=>'Tel&eacute;fono de la persona');
$l_label_ayuda[10]=array('texto'=>$columna[11],'exp'=>'Residencia de la persona');
$l_label_ayuda[11]=array('texto'=>$columna[13],'exp'=>'Pa&is de nacimiento de la persona');
$l_label_ayuda[12]=array('texto'=>$columna[15],'exp'=>'G&eacute;nero de la persona');
$l_label_ayuda[13]=array('texto'=>$columna[17],'exp'=>'Tipo de sangre de la persona');

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
$evento[1]='onkeyup="valida_cedula();" maxlength="10"';

$insert_field=array();
$insert_field[0]='id_persona'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='identificacion';// hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='primer_nombre'; 
$insert_field[3]='segundo_nombre';
$insert_field[4]='primer_apellido';
$insert_field[5]='segundo_apellido';
$insert_field[6]='fecha_nacimiento';
$insert_field[7]='direccion';
$insert_field[8]='email';
$insert_field[9]='telefono1';
$insert_field[10]='telefono2';
$insert_field[11]='residencia';
$insert_field[12]='id_pais'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[13]='';
$insert_field[14]='id_genero';
$insert_field[15]='';
$insert_field[16]='id_tipo_sangre';
$insert_field[17]='';
$insert_field[18]='id_tipo_identificacion';
$insert_field[19]='';
//$insert_field[20]='camino_foto';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[5];
$insert_alias[2]=$alias_col[1];
$insert_alias[3]=$alias_col[2];
$insert_alias[4]=$alias_col[3];
$insert_alias[5]=$alias_col[4];
$insert_alias[6]=$alias_col[6];
$insert_alias[7]=$alias_col[7];
$insert_alias[8]=$alias_col[8];
$insert_alias[9]=$alias_col[9];
$insert_alias[10]=$alias_col[10];
$insert_alias[11]=$alias_col[11];
$insert_alias[12]=$alias_col[12];
$insert_alias[13]='';
$insert_alias[14]=$alias_col[14];
$insert_alias[15]='';
$insert_alias[16]=$alias_col[16];
$insert_alias[17]='';
$insert_alias[18]=$alias_col[18];
$insert_alias[19]='';
//$insert_alias[20]=$alias_col[20];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[5]; 
$name_input[2]=$alias_col[1]; 
$name_input[3]=$alias_col[2]; 
$name_input[4]=$alias_col[3]; 
$name_input[5]=$alias_col[4]; 
$name_input[6]=$alias_col[6]; 
$name_input[7]=$alias_col[7]; 
$name_input[8]=$alias_col[8]; 
$name_input[9]=$alias_col[9]; 
$name_input[10]=$alias_col[10]; 
$name_input[11]=$alias_col[11]; 
$name_input[12]=$alias_col[13]; 
$name_input[13]=$alias_col[13]; 
$name_input[14]=$alias_col[15]; 
$name_input[15]=$alias_col[15]; 
$name_input[16]=$alias_col[17]; 
$name_input[17]=$alias_col[17];
$name_input[18]=$alias_col[19]; 
$name_input[19]=$alias_col[19];
//$name_input[20]=$alias_col[20];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[5]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[1];
$label_input[3]=$columna[2];
$label_input[4]=$columna[3];
$label_input[5]=$columna[4];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];
$label_input[8]=$columna[8];
$label_input[9]=$columna[9];
$label_input[10]=$columna[10];
$label_input[11]=$columna[11];
$label_input[12]=$columna[12];
$label_input[13]=$columna[13];
$label_input[14]=$columna[14];
$label_input[15]=$columna[15];
$label_input[16]=$columna[16];
$label_input[17]=$columna[17];
$label_input[18]=$columna[18];
$label_input[19]=$columna[19];
//$label_input[20]=$columna[20];

$placeholder=array();
$placeholder[0]='id_persona';
$placeholder[1]='C&eacute;dula o pasaporte';
$placeholder[2]='Ingrese su primer nombre'; 
$placeholder[3]='Ingrese su segundo nombre';
$placeholder[4]='Ingrese su apellido paterno';
$placeholder[5]='Ingrese su apellido materno';
$placeholder[6]='Fecha';
$placeholder[7]='Ingrese la direcci&oacute;n de su domicilio';
$placeholder[8]='Ingrese su correo electr&oacute;nico';
$placeholder[9]='Tel&eacute;fono convencional';
$placeholder[10]='Ingrese su celular';
$placeholder[11]='';
$placeholder[12]=''; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$placeholder[13]='';
$placeholder[14]='';
$placeholder[15]='';
$placeholder[16]='';
$placeholder[17]='';
$placeholder[18]='';
$placeholder[19]='';

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
$field_unico[9]='';
$field_unico[10]='';
$field_unico[11]='';
$field_unico[12]='';
$field_unico[13]='';
$field_unico[14]='';
$field_unico[15]='';
$field_unico[16]='';
$field_unico[17]='';
$field_unico[18]='';
$field_unico[19]='';
//$field_unico[20]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='input';
$tipo_input[6]='input';
$tipo_input[7]='textarea';
$tipo_input[8]='input';
$tipo_input[9]='input';
$tipo_input[10]='input';
$tipo_input[11]='select';
$tipo_input[12]='hidden';
$tipo_input[13]='';
$tipo_input[14]='hidden';
$tipo_input[15]='';
$tipo_input[16]='hidden';
$tipo_input[17]='';
$tipo_input[18]='hidden';
$tipo_input[19]='';
//$tipo_input[20]='file';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=13;
$ff=15;
$fff=17;
$ffff=11;
$t=19;
$combo_sql[$f] = "select id_pais as id_p, pais as pais from n_pais";

$opt_name=array();
$opt_name[$f][0]='pais';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
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

$combo_sql[$ff] = "select id_genero as id_g, genero as genero from n_genero";

$opt_name[$ff][0]='genero';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$ff][2]='';
$opt_name[$ff][3]='';

$opt_value[$ff][0]='id_g';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ff][1]='';
$opt_value[$ff][2]='';
$opt_value[$ff][3]='';

$opt_sel[$ff][0]='id_g';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$ff][2]='';
$opt_sel[$ff][3]='';

$combo_sql[$fff] = "select id_tipo_sangre as id_t, tipo_sangre as tipo_sangre from n_tipo_sangre";

$opt_name[$fff][0]='tipo_sangre';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$fff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$fff][2]='';
$opt_name[$fff][3]='';

$opt_value[$fff][0]='id_t';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$fff][1]='';
$opt_value[$fff][2]='';
$opt_value[$fff][3]='';

$opt_sel[$fff][0]='id_t';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$fff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$fff][2]='';
$opt_sel[$fff][3]='';

$combo_sql[$t] = "select id_tipo_identificacion as id_i, tipo_identificacion as tide from n_tipo_identificacion";


$opt_name[$t][0]='tide';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$t][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$t][2]='';
$opt_name[$t][3]='';

$opt_value[$t][0]='id_i';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$t][1]='';
$opt_value[$t][2]='';
$opt_value[$t][3]='';

$opt_sel[$t][0]='id_i';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$t][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$t][2]='';
$opt_sel[$t][3]='';

$opt_name[$ffff][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ffff][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$ffff][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ffff][1]='0';

$opt_sel[$ffff][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ffff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
// valores que va a tomar el campo tipo <select> en cada <option>
$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rvarchar';
$dato_permit[2]='Rvarchar';
$dato_permit[3]='varchar';
$dato_permit[4]='Rvarchar';
$dato_permit[5]='varchar';
$dato_permit[6]='fecha';
$dato_permit[7]='varchar';
$dato_permit[8]='Remail';
$dato_permit[9]='Rvarchar';
$dato_permit[10]='varchar';
$dato_permit[11]='Rselec';
$dato_permit[12]='';
$dato_permit[13]='selec';
$dato_permit[14]='';
$dato_permit[15]='selec';
$dato_permit[16]='';
$dato_permit[17]='selec';
$dato_permit[18]='';
$dato_permit[19]='selec';
$dato_permit[20]='varchar';

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]='';
$value_input[8]='';
$value_input[9]='';
$value_input[10]='';
$value_input[11]='';
$value_input[12]='';
$value_input[13]='';
$value_input[14]='';
$value_input[15]='';
$value_input[16]='';
$value_input[17]='';
$value_input[18]='';
$value_input[19]='';
$value_input[20]='';

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='displayCalendar(document.frm.'.$name_input[6].',"yyyy-m-d",this);';
$onclic[7]='';
$onclic[8]='';
$onclic[9]='';
$onclic[10]='';
$onclic[11]='';
$onclic[12]='';
$onclic[13]='';
$onclic[14]='';
$onclic[15]='';
$onclic[16]='';
$onclic[17]='';
$onclic[18]='';
$onclic[19]='';
$onclic[20]='';

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='20';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='50';
$size[6]='10';
$size[7]='150';
$size[8]='50';
$size[9]='20';
$size[10]='20';
$size[11]='50';
$size[12]='';
$size[13]='50';
$size[14]='';
$size[15]='50';
$size[16]='';
$size[17]='50';
$size[18]='';
$size[19]='50';
$size[20]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit2=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit2,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Primer nombre de la persona');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Segundo nombre de la persona');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Primer apellido de la persona');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Segundo apellido de la persona');
$n_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Identificaci&oacute;n de la persona');
$n_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Nacimiento de la persona');
$n_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Direcci&oacute;n de la persona');
$n_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Correo electr&oacute;nico de la persona');
$n_label_ayuda[8]=array('texto'=>$columna[9],'exp'=>'Tel&eacute;fono de la persona');
$n_label_ayuda[9]=array('texto'=>$columna[10],'exp'=>'Tel&eacute;fono de la persona');
$n_label_ayuda[10]=array('texto'=>$columna[11],'exp'=>'Residencia de la persona');
$n_label_ayuda[11]=array('texto'=>$columna[13],'exp'=>'Pa&is de nacimiento de la persona');
$n_label_ayuda[12]=array('texto'=>$columna[15],'exp'=>'G&eacute;nero de la persona');
$n_label_ayuda[13]=array('texto'=>$columna[17],'exp'=>'Tipo de sangre de la persona');

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$m_botones=array(); // botonera que va a tener en el encabezado  (NO TOCAR) 
$m_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit2,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$m_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$m_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_Editar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Primer nombre de la persona');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Segundo nombre de la persona');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Primer apellido de la persona');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Segundo apellido de la persona');
$m_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Identificaci&oacute;n de la persona');
$m_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Nacimiento de la persona');
$m_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Direcci&oacute;n de la persona');
$m_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Correo electr&oacute;nico de la persona');
$m_label_ayuda[8]=array('texto'=>$columna[9],'exp'=>'Tel&eacute;fono de la persona');
$m_label_ayuda[9]=array('texto'=>$columna[10],'exp'=>'Tel&eacute;fono de la persona');
$m_label_ayuda[10]=array('texto'=>$columna[11],'exp'=>'Residencia de la persona');
$m_label_ayuda[11]=array('texto'=>$columna[13],'exp'=>'Pa&is de nacimiento de la persona');
$m_label_ayuda[12]=array('texto'=>$columna[15],'exp'=>'G&eacute;nero de la persona');
$m_label_ayuda[13]=array('texto'=>$columna[17],'exp'=>'Tipo de sangre de la persona');

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
	document.frm.cedula.value=valida_ced(document.frm.ide.value);//cedula;
}
</script>