<?php
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
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


$elemento_titulo="de jornada de trabajo"; // para el t�tulo
$elemento="jornada"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las jornadas de trabajo registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="n_jornada";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='c_vacaciones';
$tabla_anidada[1]='n_grupo';

$campo_anidado=array();
$campo_anidado[0]='id_vacaciones';
$campo_anidado[1]='id_grupo';

$field[0]='id_jornada'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='hora_ini';
$field[2]='hora_tardanza';
$field[3]='hora_sin_entrada';
$field[4]='hora_fin';
$field[5]='hora_antelacion';
$field[6]='hora_sin_salida';
$field[7]=$tabla.'.fecha_vigencia';
$field[8]='pago_horas_extras';
$field[9]=$tabla.'.id_vacaciones';
$field[10]='codigo';
$field[11]=$tabla.'.id_grupo';
$field[12]='grupo';

$alias_col=array();
$alias_col[0]='id_jornada';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='HORA_INICIAL';
$alias_col[2]='HORA_TARDANZA';
$alias_col[3]='HORA_SIN_ENTRADA';
$alias_col[4]='HORA_FIN';
$alias_col[5]='HORA_ANTELACION';
$alias_col[6]='HORA_SIN_SALIDA';
$alias_col[7]='FECHA_VIGENCIA';
$alias_col[8]='PAGO_HORAS_EXTRAS';
$alias_col[9]='ID_VAC';
$alias_col[10]='CODIGO';
$alias_col[11]='ID_GRU';
$alias_col[12]='GRUPO';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Hora inicial';
$columna[2]='Hora de tardanza';
$columna[3]='Hora sin entrada';
$columna[4]='Hora final';
$columna[5]='Hora de antelaci&oacute;n';
$columna[6]='Hora sin salida';
$columna[7]='Fecha';
$columna[8]='Pago de horas extras';
$columna[9]='C&oacute;digo';
$columna[10]='C&oacute;digo';
$columna[11]='Grupo';
$columna[12]='Grupo';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=2;
$info_emerg[9]='';
$info_emerg[10]=1;
$info_emerg[11]='';
$info_emerg[12]=1;


$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]=1;
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=1;
$info_col[6]=1;
$info_col[7]=1;
$info_col[8]='';
$info_col[9]='';
$info_col[10]=1;
$info_col[11]='';
$info_col[12]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='10%';
$ancho[2]='10%';
$ancho[3]='10%';
$ancho[4]='10%';
$ancho[5]='10%';
$ancho[6]='10%';
$ancho[7]='10%';
$ancho[8]='';
$ancho[9]='';
$ancho[10]='14%';
$ancho[11]='';
$ancho[12]='14%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_jornada.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Hora inicial de la jornada de trabajo');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Hora de entrada con tardanza de la jornada de trabajo');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Hora sin marcar la entrada de la jornada de trabajo');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Hora final de la jornada de trabajo');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Hora de salida con antelaci&oacute;n de la jornada de trabajo');
$l_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Hora sin marcar salida de la jornada de trabajo');
$l_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Fecha de vigencia de la jornada de trabajo');
$l_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Pago de horas extras de la jornada de trabajo');
$l_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de la configuraci&oacute;n de las vacaciones de la jornada de trabajo');
$l_label_ayuda[9]=array('texto'=>$columna[12],'exp'=>'Grupo de empleados regidos por la jornada de trabajo');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_jornada.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
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

$insert_field[0]='id_jornada'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='hora_ini'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='hora_tardanza';
$insert_field[3]='hora_sin_entrada';
$insert_field[4]='hora_fin';
$insert_field[5]='hora_antelacion';
$insert_field[6]='hora_sin_salida';
$insert_field[7]='fecha_vigencia';
$insert_field[8]='pago_horas_extras';
$insert_field[9]='id_vacaciones';
$insert_field[10]='';
$insert_field[11]='id_grupo';
$insert_field[12]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]=$alias_col[2];
$insert_alias[3]=$alias_col[3];
$insert_alias[4]=$alias_col[4];
$insert_alias[5]=$alias_col[5];
$insert_alias[6]=$alias_col[6];
$insert_alias[7]=$alias_col[7];
$insert_alias[8]=$alias_col[8];
$insert_alias[9]=$alias_col[9];
$insert_alias[10]='';
$insert_alias[11]=$alias_col[11];
$insert_alias[12]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[1];
$name_input[2]=$alias_col[2];
$name_input[3]=$alias_col[3];
$name_input[4]=$alias_col[4];
$name_input[5]=$alias_col[5];
$name_input[6]=$alias_col[6];
$name_input[7]=$alias_col[7];
$name_input[8]=$alias_col[8];
$name_input[9]=$alias_col[10];
$name_input[10]=$alias_col[10];
$name_input[11]=$alias_col[12];
$name_input[12]=$alias_col[12];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de m�s seg�n las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];
$label_input[4]=$columna[4];
$label_input[5]=$columna[5];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];
$label_input[8]=$columna[8];
$label_input[9]=$columna[9];
$label_input[10]=$columna[10];
$label_input[11]=$columna[11];
$label_input[12]=$columna[12];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser �nicos en la tabla en la BD, diferente de 1 y vac�o es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]=2;
$field_unico[10]='';
$field_unico[11]=2;
$field_unico[12]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='input';
$tipo_input[6]='input';
$tipo_input[7]='input';
$tipo_input[8]='select';
$tipo_input[9]='';
$tipo_input[10]='selectBD';
$tipo_input[11]='';
$tipo_input[12]='selectBD';

// valores que va a tomar el campo tipo <select> en cada <option>
$e=12;
$f=10;
$g=8;
$combo_sql[$f] = "select id_vacaciones as ID_VAC, codigo as CODIGO from c_vacaciones order by fecha_vigencia desc";

$opt_name=array();
$opt_name[$f][0]='CODIGO';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Adem�s puedes tener del campo de la tabla en caso de selectBD


$opt_value=array();
$opt_value[$f][0]='ID_VAC';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel=array();
$opt_sel[$f][0]='ID_VAC';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$e] = "select id_grupo as ID_GRU, grupo as GRUPO from n_grupo";

$opt_name[$e][0]='GRUPO';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Adem�s puedes tener del campo de la tabla en caso de selectBD
$opt_value[$e][0]='ID_GRU';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$e][0]='ID_GRU';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$g] = "";

$opt_name[$g][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='No';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$g][1]='0';

$opt_sel[$g][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rvarchar';
$dato_permit[2]='Rvarchar';
$dato_permit[3]='Rvarchar';
$dato_permit[4]='Rvarchar';
$dato_permit[5]='Rvarchar';
$dato_permit[6]='Rvarchar';
$dato_permit[7]='Rvarchar';
$dato_permit[8]='Rvarchar';
$dato_permit[9]='';
$dato_permit[10]='Rselec';
$dato_permit[11]='';
$dato_permit[12]='Rselec';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]=date('Y-m-d');
$value_input[8]='';
$value_input[9]='';
$value_input[10]='';
$value_input[11]='';
$value_input[12]='';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='displayCalendar(document.frm.'.$name_input[1].',"hh:ii",this,1);';
$onclic[2]='displayCalendar(document.frm.'.$name_input[2].',"hh:ii",this,1);';
$onclic[3]='displayCalendar(document.frm.'.$name_input[3].',"hh:ii",this,1);';
$onclic[4]='displayCalendar(document.frm.'.$name_input[4].',"hh:ii",this,1);';
$onclic[5]='displayCalendar(document.frm.'.$name_input[5].',"hh:ii",this,1);';
$onclic[6]='displayCalendar(document.frm.'.$name_input[6].',"hh:ii",this,1);';
$onclic[7]='displayCalendar(document.frm.'.$name_input[7].',"yyyy-m-d",this);';
$onclic[8]='';
$onclic[9]='';
$onclic[10]='';
$onclic[11]='';
$onclic[12]='';

$size[0]='50'; // tama�o del <input> (NO TOCAR)
$size[1]='20';
$size[2]='20';
$size[3]='20';
$size[4]='20';
$size[5]='20';
$size[6]='20';
$size[7]='10';
$size[8]='50';
$size[9]='';
$size[10]='50';
$size[11]='';
$size[12]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acci�n y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Hora inicial de la jornada de trabajo');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Hora de entrada con tardanza de la jornada de trabajo');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Hora sin marcar la entrada de la jornada de trabajo');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Hora final de la jornada de trabajo');
$n_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Hora de salida con antelaci&oacute;n de la jornada de trabajo');
$n_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Hora sin marcar salida de la jornada de trabajo');
$n_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Fecha de vigencia de la jornada de trabajo');
$n_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Pago de horas extras de la jornada de trabajo');
$n_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de la configuraci&oacute;n de las vacaciones de la jornada de trabajo');
$n_label_ayuda[9]=array('texto'=>$columna[12],'exp'=>'Grupo de empleados regidos por la jornada de trabajo');

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
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acci�n y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Hora inicial de la jornada de trabajo');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Hora de entrada con tardanza de la jornada de trabajo');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Hora sin marcar la entrada de la jornada de trabajo');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Hora final de la jornada de trabajo');
$m_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Hora de salida con antelaci&oacute;n de la jornada de trabajo');
$m_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Hora sin marcar salida de la jornada de trabajo');
$m_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Fecha de vigencia de la jornada de trabajo');
$m_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Pago de horas extras de la jornada de trabajo');
$m_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de la configuraci&oacute;n de las vacaciones de la jornada de trabajo');
$m_label_ayuda[9]=array('texto'=>$columna[12],'exp'=>'Grupo de empleados regidos por la jornada de trabajo');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
?>