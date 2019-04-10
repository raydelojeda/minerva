<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
/*
include($x."pag/rrhh/persona/variables.php");
$inputs2=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

include($x."pag/acad/curso_grado_paralelo_est/variables.php");
$inputs3=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
*/
//include($x."pag/acad/matricula/variables.php");
//$inputs4=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

$_SESSION["modulo"]="acad";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
$msg_fam='-Solo saldr&aacute;n en el Acta de matr&iacute;cula los 2 primeros familiares seg&uacute;n el orden.<br><br>-Se consederar&aacute; representante econ&oacute;mico al primer familiar designado para ello seg&uacute;n el orden.<br><br>-Las facturas del estudiante saldr&aacute;n a nombre del representante econ&oacute;mico.<br><br>-De preferencia poner primero al representante econ&oacute;mico y despu&eacute;s al representante acad&eacute;mico.';
// declaraciones

$elemento_titulo="de datos cl&iacute;nicos del estudiante"; // para el título
$elemento="datos_clinicos"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los datos cl&iacute;nicos de estudiantes registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="datos_clinicos";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='estudiante';

/*$tabla_anidada2[0]='enfermedad_est';
$tabla_anidada2[1]='n_enfermedad';
$tabla_anidada2[2]='vacuna_est';
$tabla_anidada2[3]='n_vacuna';
$tabla_anidada2[4]='vacuna_est';
$tabla_anidada2[5]='n_vacuna';
$tabla_anidada2[6]='evolucion_est';
$tabla_anidada2[7]='eval_nutricional_est';*/
$tabla_anidada2[0]='n_genero';
$tabla_anidada2[1]='n_tipo_sangre';
$tabla_anidada2[2]='persona';

$campo_anidado=array();
$campo_anidado[0]='id_estudiante';

/*$campo_anidado2[0]='id_vacuna_est';
$campo_anidado2[1]='id_vacuna';
$campo_anidado2[2]='id_vacuna_est';
$campo_anidado2[3]='id_vacuna';
$campo_anidado2[4]='id_vacuna_est';
$campo_anidado2[5]='id_vacuna';
$campo_anidado2[6]='id_evolucion_est';
$campo_anidado2[7]='id_eval_nutricional_est';*/
$campo_anidado2[0]='id_genero';
$campo_anidado2[1]='id_tipo_sangre';
$campo_anidado2[2]='id_persona';

/*AND datos_clinicos.id_datos_clinicos=enfermedad_est.id_datos_clinicos
AND n_enfermedad.id_vacuna=enfermedad_est.id_vacuna
AND datos_clinicos.id_datos_clinicos=vacuna_est.id_datos_clinicos
AND n_vacuna.id_vacuna=vacuna_est.id_vacuna
AND datos_clinicos.id_datos_clinicos=vacuna_est.id_datos_clinicos
AND n_vacuna.id_vacuna=vacuna_est.id_vacuna
AND datos_clinicos.id_datos_clinicos=evolucion_est.id_datos_clinicos
AND datos_clinicos.id_datos_clinicos=eval_nutricional_est.id_datos_clinicos*/

$where=' AND n_genero.id_genero=persona.id_genero AND n_tipo_sangre.id_tipo_sangre=persona.id_tipo_sangre 
AND persona.id_persona=estudiante.id_persona
';

$order=" primer_apellido,persona.segundo_apellido,persona.primer_nombre ASC";

$field=array();
$field[0]=$tabla.'.id_datos_clinicos'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_estudiante';
$field[2]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion)";
$field[3]='identificacion';
$field[4]='fecha_nacimiento';
$field[5]='direccion';
$field[6]='email';
$field[7]='telefono1';
$field[8]='telefono2';
$field[9]='residencia';
$field[10]=$tabla_anidada2[0].'.id_genero';
$field[11]='genero';
$field[12]=$tabla_anidada2[1].'.id_tipo_sangre';
$field[13]='tipo_sangre';
$field[14]=$tabla.'.id_datos_clinicos';
$field[15]='vac_completa';
$field[16]='aut_medicar';
$field[17]='aut_vacunar';

$alias_col=array();
$alias_col[0]='id_datos_clinicos';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_est';
$alias_col[2]='est';
$alias_col[3]='ide';
$alias_col[4]='fec';
$alias_col[5]='dir';
$alias_col[6]='ema';
$alias_col[7]='tel1';
$alias_col[8]='tel2';
$alias_col[9]='res';
$alias_col[10]='id_pais';
$alias_col[11]='pais';
$alias_col[12]='id_g';
$alias_col[13]='gen';
$alias_col[14]='id_t';
$alias_col[15]='tip';
$alias_col[16]='id_i';
$alias_col[17]='tide';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Estudiante';
$columna[2]='Estudiante';
$columna[3]='Identificaci&oacute;n';
$columna[4]='Nacimiento';
$columna[5]='Direcci&oacute;n';
$columna[6]='Correo';
$columna[7]='Tel&eacute;fono';
$columna[8]='Tel&eacute;fono';
$columna[9]='Residencia';
$columna[10]='G&eacute;nero';
$columna[11]='G&eacute;nero';
$columna[12]='Tipo de sangre';
$columna[13]='Tipo de sangre';
$columna[14]='Datos';
$columna[15]='Vacunaci&oacute;n completa';
$columna[16]='Medicar';
$columna[17]='Vacunar';

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

$info_emerg=array();
$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]='';
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=2;
$info_emerg[10]='';
$info_emerg[11]=1;
$info_emerg[12]='';
$info_emerg[13]=1;
$info_emerg[14]='';
$info_emerg[15]=1;
$info_emerg[16]=2;
$info_emerg[17]=2;

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]=1;
$info_col[5]='';
$info_col[6]='';
$info_col[7]='';
$info_col[8]='';
$info_col[9]='';
$info_col[10]='';
$info_col[11]=1;
$info_col[12]='';
$info_col[13]=1;
$info_col[14]='';
$info_col[15]='';
$info_col[16]=2;
$info_col[17]=2;

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='35%';
$ancho[3]='';
$ancho[4]='13%';
$ancho[5]='';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='';
$ancho[9]='';
$ancho[10]='';
$ancho[11]='15%';
$ancho[12]='';
$ancho[13]='';
$ancho[14]='15%';
$ancho[15]='';
$ancho[16]='10%';
$ancho[17]='10%';

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
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Estudiante');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n del estudiante');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Nacimiento del estudiante');
$l_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Direcci&oacute;n del estudiante');
$l_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Correo del estudiante');
$l_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Tel&eacute;fono del estudiante');
$l_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Celular del estudiante');
$l_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Residencia del estudiante: Si o No');
$l_label_ayuda[8]=array('texto'=>$columna[11],'exp'=>'G&eacute;nero del estudiante');
$l_label_ayuda[9]=array('texto'=>$columna[14],'exp'=>'Tipo de sangre del estudiante');
$l_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'El estudiante tiene vacunaci&oacute;n completa?: Si o No');
$l_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Al estudiante se le puede medicar?');
$l_label_ayuda[11]=array('texto'=>$columna[17],'exp'=>'Al estudiante se le puede vacunar?');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
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
$insert_field[0]='id_vacuna_est'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_datos_clinicos'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='altura';
$insert_field[4]='peso';
$insert_field[5]='fecha';

$insert_alias=array();
$insert_alias[0]='id_vacuna_est'; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]='id_datos_clinicos';
$insert_alias[2]='datos';
$insert_alias[3]='altura';
$insert_alias[4]='peso';
$insert_alias[5]='fecha_eval';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$insert_alias[2]; 
$name_input[2]=$insert_alias[2]; 
$name_input[3]=$insert_alias[3];
$name_input[4]=$insert_alias[4];
$name_input[5]=$insert_alias[5];

$label_input=array();
$label_input[0]=''; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=''; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]='';
$label_input[3]='Altura';
$label_input[4]='Peso';
$label_input[5]='Fecha';

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='hidden';
$tipo_input[2]='';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='input';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=4;

/*$combo_sql[$f] = "select id_vacuna as id_vacuna, vacuna as vacuna 
FROM n_vacuna ORDER BY vacuna";*/

$opt_name=array();
$opt_name[$f][0]='vacuna';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$f][2]='';
$opt_name[$f][3]='';

$opt_value=array();
$opt_value[$f][0]='id_vacuna';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';
$opt_value[$f][2]='';
$opt_value[$f][3]='';

$opt_sel=array();
$opt_sel[$f][0]='id_vacuna';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$f][2]='';
$opt_sel[$f][3]='';
// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='';
$dato_permit[3]='';
$dato_permit[4]='';
$dato_permit[5]='';

$placeholder=array();

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
if(isset($id_estudiante))$value_input[1]=$id_estudiante;else $value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';

$texto_input=array();
$texto_input[3]='metros';
$texto_input[4]='Kg';

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='displayCalendar(document.frm.'.$name_input[5].',"yyyy-mm-dd",this);';

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

$onsubmit="validar_form(";
//$onsubmit=$onsubmit.$obj_var->Llenar_varios_onsubmit($inputs2);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
//$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
//$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs3);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
//$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs4);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
$onsubmit=$onsubmit.");";

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Estudiante');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Datos cl&iacute;nicos del estudiante (cl&iacute;nica de preferencia)');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Indicaciones a la cl&iacute;nica');
$n_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Observaciones generales');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Cumpli&oacute; esquema de vacunaci&oacute;n? Si o No');
$n_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Razones de no cumplimiento del esquema de vacunaci&oacute;n');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Estudiante');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Datos cl&iacute;nicos del estudiante (cl&iacute;nica de preferencia)');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Indicaciones a la cl&iacute;nica');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Observaciones generales');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Cumpli&oacute; esquema de vacunaci&oacute;n? Si o No');
$m_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Razones de no cumplimiento del esquema de vacunaci&oacute;n');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>