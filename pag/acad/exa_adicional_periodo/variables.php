<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

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


$elemento_titulo="de examen adicional del per&iacute;odo evaluativo (Quimestre)"; // para el título
$elemento="exa_adicional_periodo"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto al examen adicional del per&ioacute;odo evaluativo, registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="n_exa_adicional_periodo";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_examen_periodo_eval';
$tabla_anidada[1]='n_examen_adicional';
$tabla_anidada[2]='n_tipo_examen';

$campo_anidado=array();
$campo_anidado[0]='id_examen_periodo_eval';
$campo_anidado[1]='id_examen_adicional';
$campo_anidado[2]='id_tipo_examen';

$tabla_anidada2=array();
$tabla_anidada2[0]='n_periodo_lectivo';
$tabla_anidada2[1]='n_conf_academica';
$tabla_anidada2[2]='n_asignatura';
$tabla_anidada2[3]='n_periodo_evaluativo';

$campo_anidado2=array();
$campo_anidado2[0]='id_periodo_lectivo';
$campo_anidado2[1]='id_conf_academica';
$campo_anidado2[2]='id_asignatura';
$campo_anidado2[3]='id_periodo_evaluativo';

$where=' AND n_asignatura.id_asignatura=n_examen_periodo_eval.id_asignatura AND n_periodo_evaluativo.id_periodo_evaluativo=n_examen_periodo_eval.id_periodo_evaluativo 
AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica AND n_conf_academica.activa="1"';

$field[0]=$tabla.'.id_exa_adicional_periodo'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_examen_adicional';
$field[2]="concat(abv_examen,' - ',examen_adicional)";
$field[3]=$tabla.'.id_tipo_examen';
$field[4]="tipo_examen";
$field[5]=$tabla.'.id_examen_periodo_eval';
$field[6]="concat(examen_eval,' - ',asignatura)";
$field[7]='publica_nota';
$field[8]='sustituye_nota';
$field[9]='orden';

$alias_col=array();
$alias_col[0]='ID_exa_adicional_periodo';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_examen_adicional';
$alias_col[2]='examen_adicional';
$alias_col[3]='id_tipo_examen';
$alias_col[4]='tipo_examen';
$alias_col[5]='id_examen_periodo_eval';
$alias_col[6]='examen_eval_asignatura';
$alias_col[7]='publica_nota';
$alias_col[8]='sustituye_nota';
$alias_col[9]='orden';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Nombre del examen adicional';
$columna[2]='Nombre del examen adicional';
$columna[3]='Tipo de examen';
$columna[4]='Tipo de examen';
$columna[5]='Examen evaluativo y asignatura';
$columna[6]='Examen evaluativo y asignatura';
$columna[7]='Publica la nota mayor';
$columna[8]='Sustituye la nota';
$columna[9]='Orden';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]='';
$info_emerg[4]=1;
$info_emerg[5]='';
$info_emerg[6]=1;
$info_emerg[7]=2;
$info_emerg[8]=2;
$info_emerg[9]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]=1;
$info_col[5]='';
$info_col[6]=1;
$info_col[7]=2;
$info_col[8]=2;
$info_col[9]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='23%';
$ancho[3]='';
$ancho[4]='15%';
$ancho[5]='';
$ancho[6]='25%';
$ancho[7]='15%';
$ancho[8]='15%';
$ancho[9]='5%';

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
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Nombre del examen adicional');
$l_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Tipo de examen adicional');
$l_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Examen evaluativo y asignatura al que pertenece el examen adicional');
$l_label_ayuda[3]=array('texto'=>$columna[7],'exp'=>'Publica la nota mayor (Define si se pone la nota del examen o la nota m&iacute;nima para aprobar.)');
$l_label_ayuda[4]=array('texto'=>$columna[8],'exp'=>'Orden de los ex&aacute;menes adicionales');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_exa_adicional_periodo2.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Gestionar','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[3]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[4]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[5]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[6]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_exa_adicional_periodo'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_examen_adicional'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_tipo_examen';
$insert_field[4]='';
$insert_field[5]='id_examen_periodo_eval';
$insert_field[6]='';
$insert_field[7]='publica_nota';
$insert_field[8]='sustituye_nota';
$insert_field[9]='orden';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[5];
$insert_alias[6]='';
$insert_alias[7]=$alias_col[7];
$insert_alias[8]=$alias_col[8];
$insert_alias[9]=$alias_col[9];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[4]; 
$name_input[4]=$alias_col[4]; 
$name_input[5]=$alias_col[6];
$name_input[6]=$alias_col[6]; 
$name_input[7]=$alias_col[7];
$name_input[8]=$alias_col[8];
$name_input[9]=$alias_col[9];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[4];
$label_input[4]=$columna[4];
$label_input[5]=$columna[6];
$label_input[6]='Examen lectivo y asignatura';
$label_input[7]='Se publica la nota del examen?';
$label_input[8]='Sustituye la nota del per&iacute;odo evaluativo?';
$label_input[9]=$columna[9];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]=2;
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='';
$tipo_input[4]='selectBD';
$tipo_input[5]='';
$tipo_input[6]='selectBD';
$tipo_input[7]='select';
$tipo_input[8]='select';
$tipo_input[9]='number';

// valores que va a tomar el campo tipo <select> en cada <option>
$e=2;
$f=4;
$r=6;
$k=7;
$l=8;

$opt_name=array();$opt_value=array();$opt_sel=array();
$combo_sql[$e] = "SELECT id_examen_adicional as id_examen_adicional, concat(abv_examen,' - ',examen_adicional) as examen_adicional 
FROM n_examen_adicional WHERE 1";

$opt_name[$e][0]='examen_adicional';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$e][0]='id_examen_adicional';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$e][0]='id_examen_adicional';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$f] = "select id_tipo_examen as id_tipo_examen, concat(tipo_examen) as tipo_examen FROM n_tipo_examen WHERE 1";

$opt_name[$f][0]='tipo_examen';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$f][0]='id_tipo_examen';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$f][0]='id_tipo_examen';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$r] = "SELECT id_examen_periodo_eval as id_examen_periodo_eval, concat(examen_eval,' - ',asignatura) as examen_eval_asignatura
FROM n_asignatura, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica WHERE 1 AND n_examen_periodo_eval.id_asignatura=n_asignatura.id_asignatura 
AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica AND n_conf_academica.activa='1'";

$opt_name[$r][0]='examen_eval_asignatura';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$r][0]='id_examen_periodo_eval';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$r][0]='id_examen_periodo_eval';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$opt_name[$k][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$k][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$k][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$k][1]='0';

$opt_sel[$k][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$k][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$opt_name[$l][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$l][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$l][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$l][1]='0';

$opt_sel[$l][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$l][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='';
$dato_permit[6]='Rselec';
$dato_permit[7]='Rselec';
$dato_permit[8]='Rselec';
$dato_permit[9]='Rentero';

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

$texto_input[6]='Al que pertenece el examen adicional';
$texto_input[7]='Nota del examen o nota para aprobar';
$texto_input[8]='Si es "Si" ser&iacute;a la nota del per&iacute;odo. Si es "No" se calcular&iacute;a la nota del per&iacute;odo evaluativo seg&uacute;n los pesos.';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';
$onclic[9]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='';
$size[4]='50';
$size[5]='';
$size[6]='50';
$size[7]='50';
$size[8]='50';
$size[9]='10';

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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Nombre del examen adicional');
$n_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Tipo de examen adicional');
$n_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Examen evaluativo y asignatura al que pertenece el examen adicional');
$n_label_ayuda[3]=array('texto'=>$columna[7],'exp'=>'Publica la nota mayor (Define si se pone la nota del examen o la nota m&iacute;nima para aprobar.)');
$n_label_ayuda[4]=array('texto'=>$columna[8],'exp'=>'Orden de los ex&aacute;menes adicionales');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Nombre del examen adicional');
$m_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Tipo de examen adicional');
$m_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Examen evaluativo y asignatura al que pertenece el examen adicional');
$m_label_ayuda[3]=array('texto'=>$columna[7],'exp'=>'Publica la nota mayor (Define si se pone la nota del examen o la nota m&iacute;nima para aprobar.)');
$m_label_ayuda[4]=array('texto'=>$columna[8],'exp'=>'Orden de los ex&aacute;menes adicionales');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>