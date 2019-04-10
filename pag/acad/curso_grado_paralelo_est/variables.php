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


$elemento_titulo="del per&iacute;odo acad&eacute;mico, grado y paralelo del estudiante"; // para el título
$elemento="curso_grado_paralelo_est"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto al per&iacute;odo acad&eacute;mico, grado y paralelo de los estudiantes registrados seg&uacute;n el cargo en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="curso_grado_paralelo_est";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='estudiante';
$tabla_anidada[1]='grado_paralelo_periodo';

$tabla_anidada2[0]='persona';
$tabla_anidada2[1]='n_grado_paralelo';
$tabla_anidada2[2]='n_seccion_academica';
$tabla_anidada2[3]='n_grado';
$tabla_anidada2[4]='n_tipo_grado';
$tabla_anidada2[5]='n_paralelo';
$tabla_anidada2[6]='n_periodo_academico';

$campo_anidado=array();
$campo_anidado[0]='id_estudiante';
$campo_anidado[1]='id_grado_paralelo_periodo';

$campo_anidado2[0]='id_persona';
$campo_anidado2[1]='id_grado_paralelo';
$campo_anidado2[2]='id_seccion_academica';
$campo_anidado2[3]='id_grado';
$campo_anidado2[4]='id_tipo_grado';
$campo_anidado2[5]='id_paralelo';
$campo_anidado2[6]='id_periodo_academico';

$where=' AND persona.id_persona=estudiante.id_persona AND n_grado_paralelo.id_tipo_grado=n_tipo_grado.id_tipo_grado AND n_grado_paralelo.id_grado=n_grado.id_grado AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica 
AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo AND n_periodo_academico.id_periodo_academico=grado_paralelo_periodo.id_periodo_academico';

$field=array();
$field[0]='id_curso_grado_paralelo_est'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_grado_paralelo_periodo';
$field[2]="concat(n_grado_paralelo.abreviatura,' - ',grado,' ',paralelo)";
$field[3]='fecha_admision';
$field[4]='fecha_matricula';
$field[5]='codigo_matricula';
$field[6]='fecha_retiro';
$field[7]='cumplido';
$field[8]="concat(n_periodo_academico.nombre,' - ',fecha_ini,' / ',fecha_fin)";
$field[9]=$tabla.'.id_estudiante';
$field[10]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion)";

$alias_col=array();
$alias_col[0]='id_curso_grado_paralelo_est';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_grado_paralelo_periodo';
$alias_col[2]='grado_paralelo';
$alias_col[3]='fecha_admision';
$alias_col[4]='fecha_matricula';
$alias_col[5]='codigo_matricula';
$alias_col[6]='fecha_retiro';
$alias_col[7]='cumplido';
$alias_col[8]='periodo';
$alias_col[9]='id_estudiante';
$alias_col[10]='estudiante';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Grado y paralelo';
$columna[2]='Grado y paralelo';
$columna[3]='Fecha admisi&oacute;n';
$columna[4]='Fecha matr&iacute;cula';
$columna[5]='C&oacute;digo matr&iacute;cula';
$columna[6]='Fecha retiro';
$columna[7]='A&ntilde;o cumplido';
$columna[8]='Per&iacute;odo acad&eacute;mico';
$columna[9]='Estudiante';
$columna[10]='Estudiante';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=2;
$info_emerg[8]=1;
$info_emerg[9]='';
$info_emerg[10]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=1;
$info_col[6]=1;
$info_col[7]=2;
$info_col[8]=1;
$info_col[9]='';
$info_col[10]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='15%';
$ancho[3]='10%';
$ancho[4]='10%';
$ancho[5]='10%';
$ancho[6]='10%';
$ancho[7]='10%';
$ancho[8]='10%';
$ancho[9]='';
$ancho[10]='23%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_curso_grado_paralelo_est.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo del estudiante');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Fecha admisi&oacute;n del estudiante');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Fecha matr&iacute;cula del estudiante');
$l_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'C&oacute;digo matr&iacute;cula del estudiante');
$l_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Fecha retiro del estudiante');
$l_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'A&ntilde;o cumplido? Si o No');
$l_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Per&iacute;odo acad&eacute;mico');
$l_label_ayuda[7]=array('texto'=>$columna[10],'exp'=>'Estudiante');

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
$insert_field=array();
$insert_field[0]='id_curso_grado_paralelo_est'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_grado_paralelo_periodo';
$insert_field[2]='';
$insert_field[3]='fecha_admision';
$insert_field[4]='fecha_matricula';
$insert_field[5]='codigo_matricula';
$insert_field[6]='fecha_retiro';
$insert_field[7]='cumplido';
$insert_field[8]='id_estudiante';
$insert_field[9]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]=$alias_col[4];
$insert_alias[5]=$alias_col[5];
$insert_alias[6]=$alias_col[6];
$insert_alias[7]=$alias_col[7];
$insert_alias[8]=$alias_col[8];
$insert_alias[9]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[3]; 
$name_input[4]=$alias_col[4]; 
$name_input[5]=$alias_col[5]; 
$name_input[6]=$alias_col[6];
$name_input[7]=$alias_col[7];
$name_input[8]=$alias_col[9];
$name_input[9]=$alias_col[9];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];
$label_input[4]=$columna[4];
$label_input[5]=$columna[5];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];
$label_input[8]=$columna[8];
$label_input[9]=$columna[9];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]=1;
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]=2;
$field_unico[9]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='input';
$tipo_input[6]='input';
$tipo_input[7]='select';
$tipo_input[8]='hidden';
$tipo_input[9]='';

// valores que va a tomar el campo tipo <select> en cada <option>
$ff=2;
$j=7;

$combo_sql[$ff] = "select id_grado_paralelo_periodo as id_grado_paralelo_periodo, concat(n_grado_paralelo.abreviatura,' - ',grado,' ',paralelo) as grado_paralelo from grado_paralelo_periodo, n_grado_paralelo, n_grado, n_paralelo, n_periodo_academico
WHERE 1 AND n_grado_paralelo.id_grado=n_grado.id_grado AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo AND n_periodo_academico.id_periodo_academico=grado_paralelo_periodo.id_periodo_academico AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_periodo_academico.activo='1' ORDER BY orden ASC";

$opt_name[$ff][0]='grado_paralelo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$ff][0]='id_grado_paralelo_periodo';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ff][1]='';

$opt_sel[$ff][0]='id_grado_paralelo_periodo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$j] = "";

$opt_name[$j][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$j][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$j][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$j][1]='0';

$opt_sel[$j][0]='';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$j][1]='selected';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='Rfecha';
$dato_permit[4]='fecha';
$dato_permit[5]='input';
$dato_permit[6]='fecha';
$dato_permit[7]='Rselec';
$dato_permit[8]='';
$dato_permit[9]='Rselec';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]=date('Y-m-d');
$value_input[4]='';
if(isset($codigo_matricula))$value_input[5]=$codigo_matricula;else $value_input[5]='';
$value_input[6]='';
$value_input[7]='';
if(isset($return[1]))$value_input[8]=$return[1];else $value_input[8]='';
$value_input[9]='';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='displayCalendar(document.frm.'.$name_input[3].',"yyyy-mm-dd",this);';
$onclic[4]='displayCalendar(document.frm.'.$name_input[4].',"yyyy-mm-dd",this);';
$onclic[5]='';
$onclic[6]='displayCalendar(document.frm.'.$name_input[6].',"yyyy-mm-dd",this);';
$onclic[7]='';
$onclic[8]='';
$onclic[9]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='10';
$size[3]='10';
$size[4]='10';
$size[5]='10';
$size[6]='10';
$size[7]='50';
$size[8]='';
$size[9]='50';

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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo del estudiante');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Fecha admisi&oacute;n del estudiante');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Fecha matr&iacute;cula del estudiante');
$n_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'C&oacute;digo matr&iacute;cula del estudiante');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Fecha retiro del estudiante');
$n_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'A&ntilde;o cumplido? Si o No');
$n_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Per&iacute;odo acad&eacute;mico');
$n_label_ayuda[7]=array('texto'=>$columna[10],'exp'=>'Estudiante');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo del estudiante');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Fecha admisi&oacute;n del estudiante');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Fecha matr&iacute;cula del estudiante');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'C&oacute;digo matr&iacute;cula del estudiante');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Fecha retiro del estudiante');
$m_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'A&ntilde;o cumplido? Si o No');
$m_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Per&iacute;odo acad&eacute;mico');
$m_label_ayuda[7]=array('texto'=>$columna[10],'exp'=>'Estudiante');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>