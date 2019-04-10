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


$elemento_titulo="del avance de a&ntilde;o"; // para el título
$elemento="cierre_subperiodo_evaluativo"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las clases registradas seg&uacute;n el cargo en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="clase";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_periodo_academico';
$tabla_anidada[1]='n_asignatura';
$tabla_anidada[2]='empleado_academico';


$tabla_anidada2[0]='empleado';
$tabla_anidada2[1]='persona';

$campo_anidado=array();
$campo_anidado[0]='id_periodo_academico';
$campo_anidado[1]='id_asignatura';
$campo_anidado[2]='id_empleado_academico';

$campo_anidado2[0]='id_empleado';
$campo_anidado2[1]='id_persona';

$where=' AND persona.id_persona=empleado.id_persona AND empleado_academico.id_empleado=empleado.id_empleado AND n_periodo_academico.activo="1"';

$field=array();
$field[0]='id_clase'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_periodo_academico';
$field[2]="concat(n_periodo_academico.nombre)";
$field[3]=$tabla.'.id_asignatura';
$field[4]="concat(abreviatura,' - ',asignatura)";
$field[5]=$tabla.'.nombre';
$field[6]="referencia";
$field[7]='codigo';
$field[8]="codigo_unico";
$field[9]=$tabla.'.id_empleado_academico';
$field[10]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion)";
$field[11]='peso';
$field[12]='';

$alias_col=array();
$alias_col[0]='id_clase';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_periodo_academico';
$alias_col[2]='periodo_academico';
$alias_col[3]='id_asignatura';
$alias_col[4]='asignatura';
$alias_col[5]='nombre';
$alias_col[6]='referencia';
$alias_col[7]='codigo';
$alias_col[8]='codigo_unico';
$alias_col[9]='id_empleado_academico';
$alias_col[10]='empleado_academico';
$alias_col[11]='peso';
$alias_col[12]='$obj2->cuantos_estudiantes_clase($db,$rs->fields["id_clase"])';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Per&iacute;odo acad&eacute;mico';
$columna[2]='Per&iacute;odo acad&eacute;mico';
$columna[3]='Asignatura';
$columna[4]='Asignatura';
$columna[5]='Nombre de la clase';
$columna[6]='Referencia';
$columna[7]='C&oacute;digo';
$columna[8]='C&oacute;digo agrupador';
$columna[9]='Profesor';
$columna[10]='Profesor';
$columna[11]='Peso';
$columna[12]='E';

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
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]='';
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]='';
$info_emerg[10]=1;
$info_emerg[11]=1;
$info_emerg[12]='';

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]='';
$info_col[3]='';
$info_col[4]='';
$info_col[5]=1;
$info_col[6]=1;
$info_col[7]='';
$info_col[8]='';
$info_col[9]='';
$info_col[10]=1;
$info_col[11]='';
$info_col[12]='calc';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='18%';
$ancho[6]='43%';
$ancho[7]='';
$ancho[8]='';
$ancho[9]='';
$ancho[10]='28%';
$ancho[11]='';
$ancho[12]='1%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_clase.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo');
$l_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Per&iacute;odo acad&eacute;mico');
$l_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Tutor');
$l_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Psic&oacute;logo');
$l_label_ayuda[3]=array('texto'=>$columna[10],'exp'=>'Inspector');
$l_label_ayuda[4]=array('texto'=>$columna[11],'exp'=>'Orden');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'2.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Asistente','accion'=>'Insertar');
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
$insert_field=array();
$insert_field[0]='id_clase'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_grado_paralelo';
$insert_field[2]='';
$insert_field[3]='id_periodo_academico';
$insert_field[4]='';
$insert_field[5]='id_tutor';
$insert_field[6]='';
$insert_field[7]='id_psicologo';
$insert_field[8]='';
$insert_field[9]='id_inspector';
$insert_field[10]='';
$insert_field[11]='orden';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[5];
$insert_alias[6]='';
$insert_alias[7]=$alias_col[7];
$insert_alias[8]='';
$insert_alias[9]=$alias_col[9];
$insert_alias[10]='';
$insert_alias[11]=$alias_col[11];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[4]; 
$name_input[4]=$alias_col[4]; 
$name_input[5]=$alias_col[6]; 
$name_input[6]=$alias_col[6];
$name_input[7]=$alias_col[8];
$name_input[8]=$alias_col[8];
$name_input[9]=$alias_col[10];
$name_input[10]=$alias_col[10];
$name_input[11]=$alias_col[11];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];
$label_input[4]=$columna[4];
$label_input[5]=$columna[6];
$label_input[6]=$columna[6];
$label_input[7]=$columna[8];
$label_input[8]=$columna[8];
$label_input[9]=$columna[10];
$label_input[10]=$columna[10];
$label_input[11]='Orden';

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]='';
$field_unico[10]='';
$field_unico[11]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='';
$tipo_input[4]='selectBD';
$tipo_input[5]='';
$tipo_input[6]='selectBD';
$tipo_input[7]='';
$tipo_input[8]='selectBD';
$tipo_input[9]='';
$tipo_input[10]='selectBD';
$tipo_input[11]='number';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=2;
$ff=4;
$g=6;
$gs=8;
$v=10;

$combo_sql[$f] = "select id_grado_paralelo as id_grado_paralelo, concat(n_grado_paralelo.abreviatura,' - ',grado,' ',paralelo) as grado_paralelo from n_grado_paralelo, n_grado, n_paralelo 
WHERE 1 AND n_grado_paralelo.id_grado=n_grado.id_grado AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo ORDER BY grado ASC";

$opt_name=array();
$opt_name[$f][0]='grado_paralelo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value=array();
$opt_value[$f][0]='id_grado_paralelo';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';

$opt_sel=array();
$opt_sel[$f][0]='id_grado_paralelo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ff] = "select id_periodo_academico as id_periodo_academico, concat(n_periodo_academico.nombre,'  -  ',fecha_ini,'/',fecha_fin) as periodo_academico from n_periodo_academico WHERE activo='1' ORDER BY fecha_ini";

$opt_name[$ff][0]='periodo_academico';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$ff][0]='id_periodo_academico';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ff][1]='';

$opt_sel[$ff][0]='id_periodo_academico';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$g] = "SELECT DISTINCT empleado_academico.id_empleado_academico as id_tutor, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as tutor 
FROM persona,empleado,ingreso_salida, empleado_academico WHERE 1 AND empleado_academico.id_empleado=empleado.id_empleado AND empleado.id_persona=persona.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' ORDER BY primer_apellido,segundo_apellido";

$opt_name[$g][0]='tutor';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='id_tutor';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel[$g][0]='id_tutor';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$gs] = "SELECT DISTINCT empleado_academico.id_empleado_academico as id_psicologo, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as psicologo_academico 
FROM persona,empleado,ingreso_salida, empleado_academico WHERE 1 AND empleado_academico.id_empleado=empleado.id_empleado AND empleado.id_persona=persona.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' ORDER BY primer_apellido,segundo_apellido";

$opt_name[$gs][0]='psicologo_academico';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$gs][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$gs][0]='id_psicologo';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel[$gs][0]='id_psicologo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$gs][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$v] = "SELECT DISTINCT empleado_academico.id_empleado_academico as id_inspector, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as inspector_academico 
FROM persona,empleado,ingreso_salida, empleado_academico WHERE 1 AND empleado_academico.id_empleado=empleado.id_empleado AND empleado.id_persona=persona.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' ORDER BY primer_apellido,segundo_apellido";

$opt_name[$v][0]='inspector_academico';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$v][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$v][0]='id_inspector';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel[$v][0]='id_inspector';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$v][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='';
$dato_permit[6]='Rselec';
$dato_permit[7]='';
$dato_permit[8]='Rselec';
$dato_permit[9]='';
$dato_permit[10]='Rselec';
$dato_permit[11]='Rinput';

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
$onclic[10]='';
$onclic[11]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='';
$size[4]='50';
$size[5]='';
$size[6]='50';
$size[7]='';
$size[8]='50';
$size[9]='';
$size[10]='50';
$size[11]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$onsubmit="validar_form('sel_asignatura','','Rselec','sel_profesor','','Rselec','txt_nombre','','Rvarchar','txt_referencia','','Rvarchar','txt_codigo','','Rvarchar','txt_codigo_unico','','Rvarchar','txt_peso','','Rfloat')";

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo');
$n_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Per&iacute;odo acad&eacute;mico');
$n_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Tutor');
$n_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Psic&oacute;logo');
$n_label_ayuda[3]=array('texto'=>$columna[10],'exp'=>'Inspector');
$n_label_ayuda[4]=array('texto'=>$columna[11],'exp'=>'Orden');

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$m_botones=array(); // botonera que va a tener en el encabezado  (NO TOCAR) 
//$m_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$m_botones[0]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
//$m_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_Editar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo');
$m_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Per&iacute;odo acad&eacute;mico');
$m_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Tutor');
$m_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Psic&oacute;logo');
$m_label_ayuda[3]=array('texto'=>$columna[10],'exp'=>'Inspector');
$m_label_ayuda[4]=array('texto'=>$columna[11],'exp'=>'Orden');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>