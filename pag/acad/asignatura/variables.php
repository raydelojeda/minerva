<?php
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="acad";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de asignatura"; // para el t�tulo
$elemento="asignatura"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las asignaturas registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="n_asignatura";// tabla de la BD

$tabla_anidada=array();
//$tabla_anidada[0]='n_asignatura';
//$tabla_anidada[1]='';

$campo_anidado=array();
//$campo_anidado[0]='id_asignatura';
//$campo_anidado[1]='';

$field[0]='id_asignatura'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='asignatura';
$field[2]='abreviatura';
$field[3]='aporta_promedio';
$field[4]='cuantitativa';
$field[5]='mostrar_reportes_ofic';
$field[6]='foto';

$field_busqueda=array();
$field_busqueda[0]='asignatura'; 
$field_busqueda[1]='abreviatura';

$alias_col=array();
$alias_col[0]='id_asignatura';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='asignatura';
$alias_col[2]='abreviatura';
$alias_col[3]='aporta_promedio';
$alias_col[4]='cuantitativa';
$alias_col[5]='mostrar_reportes_ofic';
$alias_col[6]='foto';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Nombre';
$columna[2]='Abreviatura';
$columna[3]='Aporta a promedios';
$columna[4]='Cuantitativa';
$columna[5]='Mostrar en reportes oficiales';
$columna[6]='';

$field_col=array();
$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];
$field_col[4]=$alias_col[4];
$field_col[5]=$alias_col[5];
$field_col[6]=$alias_col[6];

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=2;
$info_emerg[4]=2;
$info_emerg[5]=2;
$info_emerg[6]='';

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]=1;
$info_col[3]=2;
$info_col[4]=2;
$info_col[5]=2;
$info_col[6]='img_doc';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='32%';
$ancho[2]='15%';
$ancho[3]='15%';
$ancho[4]='15%';
$ancho[5]='20%';
$ancho[6]='1%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_asignatura.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Nombre de la asignatura');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Abreviatura de la asignatura');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Aporta a promedios la asignatura?: Si o no');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Es cuantitativa la asignatura?: Si o no (La asignatura que no sea cuantitativa ser&aacute; cualitativa)');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Mostrar en reportes oficiales la asignatura?: Si o no (La asignatura que se muestra en reportes oficiales se muestra en la libreta ministerial)');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_asignatura.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
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

$insert_field[0]='id_asignatura'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='asignatura'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='abreviatura';
$insert_field[3]='aporta_promedio';
$insert_field[4]='cuantitativa';
$insert_field[5]='mostrar_reportes_ofic';
$insert_field[6]='foto';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]=$alias_col[2];
$insert_alias[3]=$alias_col[3];
$insert_alias[4]=$alias_col[4];
$insert_alias[5]=$alias_col[5];
$insert_alias[6]=$alias_col[6];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[1];
$name_input[2]=$alias_col[2];
$name_input[3]=$alias_col[3];
$name_input[4]=$alias_col[4];
$name_input[5]=$alias_col[5];
$name_input[6]=$alias_col[6];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de m�s seg�n las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];
$label_input[4]=$columna[4];
$label_input[5]=$columna[5];
$label_input[6]='Foto';

$field_unico=array();
$field_unico[0]=''; // fields que deben ser �nicos en la tabla en la BD, diferente de 1 y vac�o es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=1;
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='select';
$tipo_input[4]='select';
$tipo_input[5]='select';
$tipo_input[6]='file';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=3;
$r=4;
$w=5;
$combo_sql[$f] = "";

$opt_name[$f][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='No';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value[$f][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='0';

$opt_sel[$f][0]='';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$r] = "";

$opt_name[$r][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$r][1]='No';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value[$r][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$r][1]='0';

$opt_sel[$r][0]='';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$r][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$w] = "";

$opt_name[$w][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$w][1]='No';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value[$w][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$w][1]='0';

$opt_sel[$w][0]='';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$w][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rvarchar';
$dato_permit[2]='Rvarchar';
$dato_permit[3]='Rselec';
$dato_permit[4]='Rselec';
$dato_permit[5]='Rselec';
$dato_permit[6]='varchar';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='aporta_promedios();';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';

$size[0]='50'; // tama�o del <input> (NO TOCAR)
$size[1]='50';
$size[2]='20';
$size[3]='50';
$size[4]='50';
$size[5]='50';
$size[6]='50';

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
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Nombre de la asignatura');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Abreviatura de la asignatura');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Aporta a promedios la asignatura?: Si o no');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Es cuantitativa la asignatura?: Si o no (La asignatura que no sea cuantitativa ser&aacute; cualitativa)');
$n_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Mostrar en reportes oficiales la asignatura?: Si o no (La asignatura que se muestra en reportes oficiales se muestra en la libreta ministerial)');

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
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Nombre de la asignatura');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Abreviatura de la asignatura');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Aporta a promedios la asignatura?: Si o no');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Es cuantitativa la asignatura?: Si o no (La asignatura que no sea cuantitativa ser&aacute; cualitativa)');
$m_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Mostrar en reportes oficiales la asignatura?: Si o no (La asignatura que se muestra en reportes oficiales se muestra en la libreta ministerial)');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
?>