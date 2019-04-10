<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)

include($x."pag/rrhh/persona/variables.php");
$inputs2=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

include($x."pag/acad/curso_grado_paralelo_est/variables.php");
$inputs3=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

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
$msg_fam='-Solo saldr&aacute;n en el Acta de matr&iacute;cula los 2 primeros familiares seg&uacute;n el orden.<br><br>-Se considerar&aacute; representante econ&oacute;mico al primer familiar designado para ello seg&uacute;n el orden.<br><br>-Las facturas del estudiante saldr&aacute;n a nombre del representante econ&oacute;mico.<br><br>-De preferencia poner primero al representante econ&oacute;mico y despu&eacute;s al representante acad&eacute;mico.';
// declaraciones

$elemento_titulo="de estudiantes admitidos o matriculados en el per&iacute;odo actual"; // para el título
$elemento="estudiante"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Admitir o pasar de curso a estudiantes de un per&iacute;odo acad&eacute;mico anterior a otro siguiente."; //titulo del encabezado
$titulo_nuevo='Admitir o pasar de curso a estudiantes de un per&iacute;odo acad&eacute;mico anterior a otro siguiente.'; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Admitir o pasar de curso a estudiantes de un per&iacute;odo acad&eacute;mico anterior a otro siguiente."; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a pasar al curso siguiente a los estudiantes. Se debe escoger el per&iacute;odo que acaba de concluir y el per&iacute;odo que comienza para pasarlos de curso y per&iacute;odo acad&eacute;mico. Al hacer el pase el per&iacute;odo que comienza se activa.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="estudiante";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='persona';
$tabla_anidada[1]='curso_grado_paralelo_est';

$tabla_anidada2[0]='n_pais';
$tabla_anidada2[1]='n_genero';
$tabla_anidada2[2]='n_tipo_sangre';
$tabla_anidada2[3]='n_tipo_identificacion';
$tabla_anidada2[4]='n_grado_paralelo';
$tabla_anidada2[5]='n_seccion_academica';
$tabla_anidada2[6]='n_grado';
$tabla_anidada2[7]='n_tipo_grado';
$tabla_anidada2[8]='n_paralelo';
$tabla_anidada2[9]='n_periodo_academico';
$tabla_anidada2[10]='grado_paralelo_periodo';

$campo_anidado=array();
$campo_anidado[0]='id_persona';
$campo_anidado[1]='id_estudiante';

$campo_anidado2[0]='id_pais';
$campo_anidado2[1]='id_genero';
$campo_anidado2[2]='id_tipo_sangre';
$campo_anidado2[3]='id_tipo_identificacion';
$campo_anidado2[4]='id_grado_paralelo';
$campo_anidado2[5]='id_seccion_academica';
$campo_anidado2[6]='id_grado';
$campo_anidado2[7]='id_tipo_grado';
$campo_anidado2[8]='id_paralelo';
$campo_anidado2[9]='id_periodo_academico';
$campo_anidado2[10]='id_grado_paralelo_periodo';

$where=' AND n_pais.id_pais=persona.id_pais AND n_genero.id_genero=persona.id_genero AND n_tipo_sangre.id_tipo_sangre=persona.id_tipo_sangre 
AND n_tipo_identificacion.id_tipo_identificacion=persona.id_tipo_identificacion AND grado_paralelo_periodo.id_grado_paralelo_periodo=curso_grado_paralelo_est.id_grado_paralelo_periodo
AND n_grado_paralelo.id_tipo_grado=n_tipo_grado.id_tipo_grado AND n_grado_paralelo.id_grado=n_grado.id_grado AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica 
AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo AND n_periodo_academico.id_periodo_academico=grado_paralelo_periodo.id_periodo_academico AND n_periodo_academico.activo=1';

$order=" grado_paralelo_periodo.orden,primer_apellido,persona.segundo_apellido,persona.primer_nombre ASC";

$field=array();
$field[0]=$tabla.'.id_estudiante'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_persona';
$field[2]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion)";
$field[3]='identificacion';
$field[4]='fecha_nacimiento';
$field[5]='direccion';
$field[6]='email';
$field[7]='telefono1';
$field[8]='telefono2';
$field[9]='residencia';
$field[10]=$tabla_anidada[0].'.id_pais';
$field[11]='pais';
$field[12]=$tabla_anidada[0].'.id_genero';
$field[13]='genero';
$field[14]=$tabla_anidada[0].'.id_tipo_sangre';
$field[15]='tipo_sangre';
$field[16]=$tabla_anidada[0].'.id_tipo_identificacion';
$field[17]='tipo_identificacion';
$field[18]='lugar_nacimiento';
$field[19]='tipo_vivienda';
$field[20]='colegio_proviene';
$field[21]='razones_cambio';
$field[22]='tratamiento_profesional';
$field[23]='observaciones';
$field[24]=$tabla_anidada2[9].'.id_periodo_academico';
$field[25]="concat(nombre,' - ',fecha_ini,' / ',fecha_fin)";
$field[26]=$tabla_anidada2[6].'.id_grado';
$field[27]='grado';
$field[28]=$tabla_anidada2[10].'.orden';
$field[29]=$tabla_anidada2[4].'.abreviatura';
$field[30]='fecha_admision';
$field[31]='fecha_matricula';
$field[32]='codigo_matricula';
$field[33]='fecha_retiro';
$field[34]='cumplido';
$field[35]='camino_foto';

$alias_col=array();
$alias_col[0]='id_estudiante';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_p';
$alias_col[2]='per';
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
$alias_col[18]='luga';
$alias_col[19]='tipo';
$alias_col[20]='cole';
$alias_col[21]='razo';
$alias_col[22]='trat';
$alias_col[23]='obse';
$alias_col[24]='id_periodo_academico';
$alias_col[25]='periodo';
$alias_col[26]='id_grado';
$alias_col[27]='grado';
$alias_col[28]='id_paralelo';
$alias_col[29]='paralelo';
$alias_col[30]='fecha_admision';
$alias_col[31]='fecha_matricula';
$alias_col[32]='codigo_matricula';
$alias_col[33]='fecha_retiro';
$alias_col[34]='cumplido';
$alias_col[35]='foto';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Estudiante';
$columna[2]='Per&iacute;odo anterior';
$columna[3]='Per&iacute;odo siguiente';
$columna[4]='Nacimiento';
$columna[5]='Direcci&oacute;n';
$columna[6]='Correo';
$columna[7]='Tel&eacute;fono';
$columna[8]='Tel&eacute;fono';
$columna[9]='Residencia';
$columna[10]='Pa&iacute;s';
$columna[11]='Pa&iacute;s';
$columna[12]='G&eacute;nero';
$columna[13]='G&eacute;nero';
$columna[14]='Tipo de sangre';
$columna[15]='Tipo de sangre';
$columna[16]='Tipo de identificaci&oacute;n';
$columna[17]='Tipo de identificaci&oacute;n';
$columna[18]='Lugar de nacimiento';
$columna[19]='Tipo vivienda';
$columna[20]='Colegio que proviene';
$columna[21]='Razones del cambio';
$columna[22]='Tuvo tratamiento profesional';
$columna[23]='Observaciones';
$columna[24]='Per&iacute;odo acad&eacute;mico';
$columna[25]='Per&iacute;odo acad&eacute;mico';
$columna[26]='Curso';
$columna[27]='Curso';
$columna[28]='Paralelo';
$columna[29]='Paralelo';
$columna[30]='Fecha admisi&oacute;n';
$columna[31]='Fecha matr&iacute;cula';
$columna[32]='C&oacute;digo';
$columna[33]='Fecha retiro';
$columna[34]='A&ntilde;o cumplido';
$columna[35]='';

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
$field_col[21]=$alias_col[21];
$field_col[22]=$alias_col[22];
$field_col[23]=$alias_col[23];
$field_col[24]=$alias_col[24];
$field_col[25]=$alias_col[25];
$field_col[26]=$alias_col[26];
$field_col[27]=$alias_col[27];
$field_col[28]=$alias_col[28];
$field_col[29]=$alias_col[29];
$field_col[30]=$alias_col[30];
$field_col[31]=$alias_col[31];
$field_col[32]=$alias_col[32];
$field_col[33]=$alias_col[33];
$field_col[34]=$alias_col[34];
$field_col[35]=$alias_col[35];

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
$info_emerg[16]='';
$info_emerg[17]=1;
$info_emerg[18]=1;
$info_emerg[19]=2;
$info_emerg[20]='';
$info_emerg[21]='';
$info_emerg[22]='';
$info_emerg[23]=1;
$info_emerg[24]='';
$info_emerg[25]=1;
$info_emerg[26]='';
$info_emerg[27]='';
$info_emerg[28]='';
$info_emerg[29]=1;
$info_emerg[30]=1;
$info_emerg[31]=1;
$info_emerg[32]=1;
$info_emerg[33]=2;
$info_emerg[34]=2;
$info_emerg[35]='';

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]='';
$info_col[5]='';
$info_col[6]='';
$info_col[7]='';
$info_col[8]='';
$info_col[9]='';
$info_col[10]='';
$info_col[11]='';
$info_col[12]='';
$info_col[13]=1;
$info_col[14]='';
$info_col[15]='';
$info_col[16]='';
$info_col[17]='';
$info_col[18]='';
$info_col[19]='';
$info_col[20]='';
$info_col[21]='';
$info_col[22]='';
$info_col[23]='';
$info_col[24]='';
$info_col[25]=8;
$info_col[26]='';
$info_col[27]=1;
$info_col[28]='';
$info_col[29]=1;
$info_col[30]=1;
$info_col[31]='';
$info_col[32]=1;
$info_col[33]=2;
$info_col[34]='';
$info_col[35]='img_doc';

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='39%';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='';
$ancho[9]='';
$ancho[10]='';
$ancho[11]='';
$ancho[12]='';
$ancho[13]='7%';
$ancho[14]='';
$ancho[15]='';
$ancho[16]='';
$ancho[17]='';
$ancho[18]='';
$ancho[19]='';
$ancho[20]='';
$ancho[21]='';
$ancho[22]='';
$ancho[23]='';
$ancho[24]='';
$ancho[25]='';
$ancho[26]='';
$ancho[27]='19%';
$ancho[28]='';
$ancho[29]='9%';
$ancho[30]='8%';
$ancho[31]='';
$ancho[32]='5%';
$ancho[33]='8%';
$ancho[34]='';
$ancho[35]='1%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_estudiante.php?mod='; // camino de la pagina para Editar

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
$l_label_ayuda[8]=array('texto'=>$columna[11],'exp'=>'Pa&iacute;s del estudiante');
$l_label_ayuda[9]=array('texto'=>$columna[13],'exp'=>'G&eacute;nero del estudiante');
$l_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Tipo de sangre del estudiante');
$l_label_ayuda[11]=array('texto'=>$columna[17],'exp'=>'Tipo de identificaci&oacute;n del estudiante');
$l_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Lugar de nacimiento del estudiante');
$l_label_ayuda[13]=array('texto'=>$columna[19],'exp'=>'Vive en vivienda arrendada el estudiante?: Si o No');
$l_label_ayuda[14]=array('texto'=>$columna[20],'exp'=>'Colegio que proviene el estudiante');
$l_label_ayuda[15]=array('texto'=>$columna[21],'exp'=>'Razones del cambio de colegio del estudiante');
$l_label_ayuda[16]=array('texto'=>$columna[22],'exp'=>'Tuvo tratamiento profesional el estudiante');
$l_label_ayuda[17]=array('texto'=>$columna[23],'exp'=>'Observaciones generales sobre el cambio de colegio');
$l_label_ayuda[18]=array('texto'=>$columna[25],'exp'=>'Per&iacute;odo acad&eacute;mico al que se admite o matricula el estudiante');
$l_label_ayuda[19]=array('texto'=>$columna[27],'exp'=>'Curso del estudiante');
$l_label_ayuda[20]=array('texto'=>$columna[29],'exp'=>'Paralelo del estudiante');
$l_label_ayuda[21]=array('texto'=>$columna[30],'exp'=>'Fecha admisi&oacute;n');
$l_label_ayuda[22]=array('texto'=>$columna[31],'exp'=>'Fecha matr&iacute;cula');
$l_label_ayuda[23]=array('texto'=>$columna[32],'exp'=>'C&oacute;digo matr&iacute;cula');
$l_label_ayuda[24]=array('texto'=>$columna[33],'exp'=>'A&ntilde;o cumplido por el estudiante?: Si o No');
$l_label_ayuda[25]=array('texto'=>$columna[34],'exp'=>'Foto del estudiante');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'','href'=>'pasar_curso_estudiantes.php','onclic'=>'','src'=>$x.'img/general/graduar.png','nombre'=>'graduar','texto'=>'Graduar','accion'=>'Insertar');
$l_botones[1]=array('target'=>'','href'=>'#','onclic'=>'modif(\'planilla_matricula.php\')','src'=>$x.'img/general/doc.png','nombre'=>'planilla','texto'=>'Acta','accion'=>'Imprimir');
$l_botones[2]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[3]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[4]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[5]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[6]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[7]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
$insert_field=array();
$insert_field[0]='id_estudiante'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_persona'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='lugar_nacimiento';
$insert_field[4]='tipo_vivienda';
$insert_field[5]='colegio_proviene';
$insert_field[6]='razones_cambio';
$insert_field[7]='tratamiento_profesional';
$insert_field[8]='observaciones';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[18];
$insert_alias[4]=$alias_col[19];
$insert_alias[5]=$alias_col[20];
$insert_alias[6]=$alias_col[21];
$insert_alias[7]=$alias_col[22];
$insert_alias[8]=$alias_col[23];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[18];
$name_input[4]=$alias_col[19];
$name_input[5]=$alias_col[20];
$name_input[6]=$alias_col[21];
$name_input[7]=$alias_col[22];
$name_input[8]=$alias_col[23];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[18];
$label_input[4]=$columna[19];
$label_input[5]=$columna[20];
$label_input[6]=$columna[21];
$label_input[7]=$columna[22];
$label_input[8]=$columna[23];

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
$tipo_input[1]='hidden';
$tipo_input[2]='';
$tipo_input[3]='input';
$tipo_input[4]='select';
$tipo_input[5]='input';
$tipo_input[6]='textarea';
$tipo_input[7]='textarea';
$tipo_input[8]='textarea';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=2;
$j=4;
$h=19;
$r=9;
$c=33;
$y=34;
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

$combo_sql[$j] = "";

$opt_name[$j][0]='Arrendada';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$j][1]='Propia';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$j][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$j][1]='0';

$opt_sel[$j][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$j][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$y] = "";

$opt_name[$y][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$y][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$y][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$y][1]='0';

$opt_sel[$y][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$y][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$c] = "";

$opt_name[$c][0]='';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$c][1]='No retirado';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$c][0]='';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$c][1]='0000-00-00';

$opt_sel[$c][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$c][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$h] = "";

$opt_name[$h][0]='Arrendada';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$h][1]='Propia';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$h][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$h][1]='0';


$opt_sel[$h][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$h][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$r] = "";

$opt_name[$r][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$r][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$r][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$r][1]='0';

$opt_sel[$r][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$r][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='';
$dato_permit[3]='Rinput';
$dato_permit[4]='';
$dato_permit[5]='';
$dato_permit[6]='';
$dato_permit[7]='';
$dato_permit[8]='';

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
if(isset($return[1]))$value_input[1]=$return[1];else $value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]='';
$value_input[8]='';

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='';
$size[3]='10';
$size[4]='50';
$size[5]='50';
$size[6]='100';
$size[7]='100';
$size[8]='100';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
/*
$onsubmit="validar_form(";
$onsubmit=$onsubmit.$obj_var->Llenar_varios_onsubmit($inputs2);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs3);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
//$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs4);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
$onsubmit=$onsubmit.");";*/

$onsubmit="validar_form('sel_per_ant','','Rselec','sel_per_sig','','Rselec')";

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables_pasar_curso_estudiantes.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'acaba de concluir');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'va a comenzar');

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//print $_GET["visualizar"];
$m_botones=array(); // botonera que va a tener en el encabezado  (NO TOCAR) 
$b=0;if(!isset($_GET["visualizar"]))$m_botones[$b]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit2,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');else $b=-1;
$m_botones[$b+1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$m_botones[$b+2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_Editar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Estudiante');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n del estudiante');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Nacimiento del estudiante');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Direcci&oacute;n del estudiante');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Correo del estudiante');
$m_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Tel&eacute;fono del estudiante');
$m_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Celular del estudiante');
$m_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Residencia del estudiante: Si o No');
$m_label_ayuda[8]=array('texto'=>$columna[11],'exp'=>'Pa&iacute;s del estudiante');
$m_label_ayuda[9]=array('texto'=>$columna[13],'exp'=>'G&eacute;nero del estudiante');
$m_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Tipo de sangre del estudiante');
$m_label_ayuda[11]=array('texto'=>$columna[17],'exp'=>'Tipo de identificaci&oacute;n del estudiante');
$m_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Lugar de nacimiento del estudiante');
$m_label_ayuda[13]=array('texto'=>$columna[19],'exp'=>'Vive en vivienda arrendada el estudiante?: Si o No');
$m_label_ayuda[14]=array('texto'=>$columna[20],'exp'=>'Colegio que proviene el estudiante');
$m_label_ayuda[15]=array('texto'=>$columna[21],'exp'=>'Razones del cambio de colegio del estudiante');
$m_label_ayuda[16]=array('texto'=>$columna[22],'exp'=>'Tuvo tratamiento profesional el estudiante');
$m_label_ayuda[17]=array('texto'=>$columna[23],'exp'=>'Observaciones generales sobre el cambio de colegio');
$m_label_ayuda[18]=array('texto'=>$columna[25],'exp'=>'Per&iacute;odo acad&eacute;mico al que se admite o matricula el estudiante');
$m_label_ayuda[19]=array('texto'=>$columna[27],'exp'=>'Curso del estudiante');
$m_label_ayuda[20]=array('texto'=>$columna[29],'exp'=>'Paralelo del estudiante');
$m_label_ayuda[21]=array('texto'=>$columna[30],'exp'=>'Fecha admisi&oacute;n');
$m_label_ayuda[22]=array('texto'=>$columna[31],'exp'=>'Fecha matr&iacute;cula');
$m_label_ayuda[23]=array('texto'=>$columna[32],'exp'=>'C&oacute;digo matr&iacute;cula');
$m_label_ayuda[24]=array('texto'=>$columna[33],'exp'=>'A&ntilde;o cumplido por el estudiante?: Si o No');
$m_label_ayuda[25]=array('texto'=>$columna[34],'exp'=>'Foto del estudiante');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>