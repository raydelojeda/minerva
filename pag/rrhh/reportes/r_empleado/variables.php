<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../../";// (NO TOCAR)
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


$elemento_titulo="de empleados"; // para el título
$elemento="r_empleado"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/reportes/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Reporte consolidado ".$elemento_titulo." activos en la instituci&oacute;n: listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los empleados registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="empleado";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='persona';
$tabla_anidada[1]='n_titulo';
$tabla_anidada[2]='n_dpto';
$tabla_anidada[3]='n_tipo_cuenta';
$tabla_anidada[4]='n_seccion';
$tabla_anidada[5]='n_tipo_contrato';
$tabla_anidada[6]='n_grupo_gastos';
$tabla_anidada[7]='n_sist_salario';
$tabla_anidada[8]='n_inst_educativa';
$tabla_anidada[9]='n_estado_civil';

$tabla_anidada2[0]='n_cargo';
$tabla_anidada2[1]='cargo_empleado';
$tabla_anidada2[2]='n_cargo AS n_c';
$tabla_anidada2[3]='ingreso_salida';
$tabla_anidada2[4]='n_causa_ing_sal';

$where=" AND empleado.id_cargo_jefe=n_cargo.id_cargo AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_c.id_cargo AND cargo_empleado.activo='1'
AND empleado.id_empleado=ingreso_salida.id_empleado AND n_causa_ing_sal.id_causa_ing_sal=ingreso_salida.id_causa_ing_sal AND baja='0'";

$campo_anidado=array();
$campo_anidado[0]='id_persona';
$campo_anidado[1]='id_titulo';
$campo_anidado[2]='id_dpto';
$campo_anidado[3]='id_tipo_cuenta';
$campo_anidado[4]='id_seccion';
$campo_anidado[5]='id_tipo_contrato';
$campo_anidado[6]='id_grupo_gastos';
$campo_anidado[7]='id_sist_salario';
$campo_anidado[8]='id_inst_educativa';
$campo_anidado[9]='id_estado_civil';

$f=0;$field[$f]=$tabla.'.id_empleado'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$f=$f+1;$field[$f]=$tabla.'.id_persona';
$f=$f+1;$field[$f]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion)";
$f=$f+1;$field[$f]=$tabla.'.id_estado_civil';
$f=$f+1;$field[$f]='estado_civil';
$f=$f+1;$field[$f]=$tabla.'.id_seccion';
$f=$f+1;$field[$f]='seccion';
$f=$f+1;$field[$f]=$tabla.'.id_dpto';
$f=$f+1;$field[$f]='dpto';
$f=$f+1;$field[$f]=$tabla.'.email_inst';
$f=$f+1;$field[$f]=$tabla.'.telefono_inst';
$f=$f+1;$field[$f]=$tabla.'.id_titulo';
$f=$f+1;$field[$f]='titulo';
$f=$f+1;$field[$f]=$tabla.'.id_inst_educativa';
$f=$f+1;$field[$f]='inst_educativa';
$f=$f+1;$field[$f]=$tabla.'.id_tipo_contrato';
$f=$f+1;$field[$f]='tipo_contrato';
$f=$f+1;$field[$f]=$tabla.'.id_grupo_gastos';
$f=$f+1;$field[$f]='grupo_gastos';
$f=$f+1;$field[$f]=$tabla.'.id_tipo_cuenta';
$f=$f+1;$field[$f]='tipo_cuenta';
$f=$f+1;$field[$f]=$tabla.'.numero_cuenta';
$f=$f+1;$field[$f]=$tabla.'.id_sist_salario';
$f=$f+1;$field[$f]='sist_salario';
$f=$f+1;$field[$f]=$tabla.'.id_biometrico';
$f=$f+1;$field[$f]=$tabla.'.id_cargo_jefe';
$f=$f+1;$field[$f]=$tabla_anidada2[0].'.cargo';
$f=$f+1;$field[$f]='n_c.cargo';
$f=$f+1;$field[$f]='fecha_ing_sal';
$f=$f+1;$field[$f]='causa_ing_sal';
$f=$f+1;$field[$f]='';
$f=$f+1;$field[$f]='fecha_nacimiento';

$field_busqueda=array();
$field_busqueda[0]='persona.primer_nombre'; 
$field_busqueda[1]='persona.segundo_nombre';
$field_busqueda[2]="persona.primer_apellido";
$field_busqueda[3]='persona.identificacion';
$field_busqueda[4]="persona.segundo_apellido";
$field_busqueda[5]='n_c.cargo';
$field_busqueda[6]=$tabla.'.email_inst';
$field_busqueda[7]="seccion";

$alias_col=array();
$alias_col[0]='id_empleado';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_persona';
$alias_col[2]='persona';
$alias_col[3]='ID_ESTADO_CIVIL';
$alias_col[4]='ESTADO_CIVIL';
$alias_col[5]='id_seccion';
$alias_col[6]='seccion';
$alias_col[7]='ID_DPTO';
$alias_col[8]='DPTO';
$alias_col[9]='EMAIL';
$alias_col[10]='TELEFONO';
$alias_col[11]='id_titulo';
$alias_col[12]='titulo';
$alias_col[13]='ID_INST_EDUC';
$alias_col[14]='INSTITUCION_EDUACATIVA';
$alias_col[15]='id_tipo_cont';
$alias_col[16]='tipo_contrato';
$alias_col[17]='id_grupo';
$alias_col[18]='grupo_gastos';
$alias_col[19]='id_tipo';
$alias_col[20]='tipo_cuenta';
$alias_col[21]='NUMERO_CUENTA';
$alias_col[22]='id_sistema';
$alias_col[23]='sistema_salario';
$alias_col[24]='NO_BIOMETRICO';
$alias_col[25]='ID_CARGO_JEFE';
$alias_col[26]='CARGO_JEFE';
$alias_col[27]='CARGO';
$alias_col[28]='FECHA_ING_SAL';
$alias_col[29]='CAUSA';
$alias_col[30]='$obj2->interval_date($rs->fields["FECHA_ING_SAL"],date("Y-m-d"))';
$alias_col[31]='fecha_nac';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Persona';
$columna[2]='Persona';
$columna[3]='Estado civil';
$columna[4]='Estado civil';
$columna[5]='Secci&oacute;n';
$columna[6]='Secci&oacute;n';
$columna[7]='Departamento';
$columna[8]='Departamento';
$columna[9]='Correo institucional';
$columna[10]='Extensi&oacute;n';
$columna[11]='T&iacute;tulo';
$columna[12]='T&iacute;tulo';
$columna[13]='Instituci&oacute;n educativa';
$columna[14]='Instituci&oacute;n educativa';
$columna[15]='Tipo de contrato';
$columna[16]='Tipo de contrato';
$columna[17]='Grupo de gastos';
$columna[18]='Grupo de gastos';
$columna[19]='Tipo de cuenta';
$columna[20]='Tipo de cuenta';
$columna[21]='N&uacute;mero de cuenta';
$columna[22]='Sistema de salario';
$columna[23]='Sistema de salario';
$columna[24]='Biom&eacute;trico';
$columna[25]='Cargo del jefe inmediato';
$columna[26]='Cargo del jefe inmediato';
$columna[27]='Cargo del empleado';
$columna[28]='Ingreso o salida';
$columna[29]='Causa de ingreso o salida';
$columna[30]='Tiempo de trabajo';
$columna[31]='Nacimiento';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]='';
$info_emerg[4]=1;
$info_emerg[5]='';
$info_emerg[6]=1;
$info_emerg[7]='';
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]=1;
$info_emerg[11]='';
$info_emerg[12]=1;
$info_emerg[13]='';
$info_emerg[14]=1;
$info_emerg[15]='';
$info_emerg[16]=1;
$info_emerg[17]='';
$info_emerg[18]=1;
$info_emerg[19]='';
$info_emerg[20]=1;
$info_emerg[21]=1;
$info_emerg[22]='';
$info_emerg[23]=1;
$info_emerg[24]=1;
$info_emerg[25]='';
$info_emerg[26]=1;
$info_emerg[27]=1;
$info_emerg[28]=1;
$info_emerg[29]=1;
$info_emerg[30]=1;
$info_emerg[31]=1;

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
$info_col[13]='';
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
$info_col[24]=1;
$info_col[25]='';
$info_col[26]=1;
$info_col[27]=1;
$info_col[28]=1;
$info_col[29]='';
$info_col[30]='calc';
$info_col[31]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='27%';
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
$ancho[13]='';
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
$ancho[24]='5%';
$ancho[25]='';
$ancho[26]='20%';
$ancho[27]='20%';
$ancho[28]='10%';
$ancho[29]='';
$ancho[30]='10%';
$ancho[31]='5%';

$var_mod='';
$columna_suma[0]='';
$href_m=''; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[1]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona');
$l_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Estado civil del empleado');
$l_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Secci&oacute;n del empleado');
$l_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Departamento del empleado');
$l_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Correo institucional del empleado');
$l_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Tel&eacute;fono institucional del empleado');
$l_label_ayuda[6]=array('texto'=>$columna[12],'exp'=>'T&iacute;tulo del empleado');
$l_label_ayuda[7]=array('texto'=>$columna[14],'exp'=>'Instituci&oacute;n educativa del empleado');
$l_label_ayuda[8]=array('texto'=>$columna[16],'exp'=>'Tipo de contrato del empleado');
$l_label_ayuda[9]=array('texto'=>$columna[18],'exp'=>'Grupo de gastos del empleado');
$l_label_ayuda[10]=array('texto'=>$columna[20],'exp'=>'Tipo de cuenta del empleado');
$l_label_ayuda[11]=array('texto'=>$columna[22],'exp'=>'Sistema de salario del empleado');
$l_label_ayuda[12]=array('texto'=>$columna[24],'exp'=>'No biom&eacute;trico del empleado');
$l_label_ayuda[13]=array('texto'=>$columna[26],'exp'=>'Cargo del jefe del empleado');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[1]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_empleado'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_persona';// hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_estado_civil';
$insert_field[4]='';
$insert_field[5]='id_seccion';
$insert_field[6]='';
$insert_field[7]='id_dpto';
$insert_field[8]='';
$insert_field[9]='email_inst';
$insert_field[10]='telefono_inst';
$insert_field[11]='id_titulo';
$insert_field[12]='';
$insert_field[13]='id_inst_educativa';
$insert_field[14]='';
$insert_field[15]='id_tipo_contrato';
$insert_field[16]='';
$insert_field[17]='id_grupo_gastos';
$insert_field[18]='';
$insert_field[19]='id_tipo_cuenta';
$insert_field[20]='';
$insert_field[21]='numero_cuenta';
$insert_field[22]='id_sist_salario';
$insert_field[23]='';
$insert_field[24]='id_biometrico';
$insert_field[25]='id_cargo_jefe';
$insert_field[26]='';

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
$insert_alias[10]=$alias_col[10];
$insert_alias[11]=$alias_col[11];
$insert_alias[12]='';
$insert_alias[13]=$alias_col[13];
$insert_alias[14]='';
$insert_alias[15]=$alias_col[15];
$insert_alias[16]='';
$insert_alias[17]=$alias_col[17];
$insert_alias[18]='';
$insert_alias[19]=$alias_col[19];
$insert_alias[20]='';
$insert_alias[21]=$alias_col[21];
$insert_alias[22]=$alias_col[22];
$insert_alias[23]='';
$insert_alias[24]='NO_BIOMETRICO';
$insert_alias[25]=$alias_col[25];
$insert_alias[26]='';

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
$name_input[9]=$alias_col[9]; 
$name_input[10]=$alias_col[10]; 
$name_input[11]=$alias_col[12]; 
$name_input[12]=$alias_col[12]; 
$name_input[13]=$alias_col[14]; 
$name_input[14]=$alias_col[14]; 
$name_input[15]=$alias_col[16]; 
$name_input[16]=$alias_col[16]; 
$name_input[17]=$alias_col[18];
$name_input[18]=$alias_col[18]; 
$name_input[19]=$alias_col[20]; 
$name_input[20]=$alias_col[20]; 
$name_input[21]=$alias_col[21]; 
$name_input[22]=$alias_col[23]; 
$name_input[23]=$alias_col[23];
$name_input[24]=$alias_col[24]; 
$name_input[25]=$alias_col[26]; 
$name_input[26]=$alias_col[26]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[4];
$label_input[4]=$columna[4];
$label_input[5]=$columna[6];
$label_input[6]=$columna[6];
$label_input[7]=$columna[8];
$label_input[8]=$columna[8];
$label_input[9]=$columna[9];
$label_input[10]=$columna[10];
$label_input[11]=$columna[12];
$label_input[12]=$columna[12];
$label_input[13]=$columna[14];
$label_input[14]=$columna[14];
$label_input[15]=$columna[16];
$label_input[16]=$columna[16];
$label_input[17]=$columna[18];
$label_input[18]=$columna[18];
$label_input[19]=$columna[20];
$label_input[20]=$columna[20];
$label_input[21]=$columna[21];
$label_input[22]=$columna[23];
$label_input[23]=$columna[23];
$label_input[24]=$columna[24];
$label_input[26]=$columna[26];
$label_input[26]=$columna[26];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]=1;
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
$field_unico[20]='';
$field_unico[21]='';
$field_unico[22]='';
$field_unico[23]='';
$field_unico[24]=2;
$field_unico[25]='';
$field_unico[26]='';

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
$tipo_input[9]='input';
$tipo_input[10]='input';
$tipo_input[11]='';
$tipo_input[12]='selectBD';
$tipo_input[13]='';
$tipo_input[14]='selectBD';
$tipo_input[15]='';
$tipo_input[16]='selectBD';
$tipo_input[17]='';
$tipo_input[18]='selectBD';
$tipo_input[19]='';
$tipo_input[20]='selectBD';
$tipo_input[21]='input';
$tipo_input[22]='';
$tipo_input[23]='selectBD';
$tipo_input[24]='input';
$tipo_input[25]='';
$tipo_input[26]='selectBD';

// valores que va a tomar el campo tipo <select> en cada <option>
$e=8;
$f=2;
$ff=12;
$fff=14;
$ffff=20;
$fffff=6;
$ffffff=16;
$fffffff=18;
$ffffffff=23;
$fffffffff=4;
$ffffffffff=26;

$opt_name=array();$opt_value=array();$opt_sel=array();
$combo_sql[$e] = "select id_dpto as ID_DPTO, DPTO as DPTO from n_dpto ORDER BY DPTO";

$opt_name[$e][0]='DPTO';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$e][0]='ID_DPTO';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$e][0]='ID_DPTO';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$f] = "select id_persona as id_persona, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as persona from persona ORDER BY primer_apellido";

$opt_name[$f][0]='persona';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$f][0]='id_persona';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$f][0]='id_persona';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ff] = "select id_titulo as id_titulo, titulo as titulo from n_titulo ORDER BY titulo";

$opt_name[$ff][0]='titulo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ff][0]='id_titulo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ff][0]='id_titulo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fff] = "select id_inst_educativa as ID_INST_EDUC, inst_educativa as INSTITUCION_EDUACATIVA from n_inst_educativa ORDER BY inst_educativa";

$opt_name[$fff][0]='INSTITUCION_EDUACATIVA';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fff][0]='ID_INST_EDUC';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fff][0]='ID_INST_EDUC';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffff] = "select id_tipo_cuenta as id_tipo, tipo_cuenta as tipo_cuenta from n_tipo_cuenta ORDER BY tipo_cuenta";

$opt_name[$ffff][0]='tipo_cuenta';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffff][0]='id_tipo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffff][0]='id_tipo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fffff] = "select id_seccion as id_seccion, seccion as seccion from n_seccion ORDER BY seccion";

$opt_name[$fffff][0]='seccion';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fffff][0]='id_seccion';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fffff][0]='id_seccion';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffffff] = "select id_tipo_contrato as id_tipo_cont, tipo_contrato as tipo_contrato from n_tipo_contrato ORDER BY tipo_contrato";

$opt_name[$ffffff][0]='tipo_contrato';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffffff][0]='id_tipo_cont';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffffff][0]='id_tipo_cont';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fffffff] = "select id_grupo_gastos as id_grupo, grupo_gastos as grupo_gastos from n_grupo_gastos ORDER BY grupo_gastos";

$opt_name[$fffffff][0]='grupo_gastos';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fffffff][0]='id_grupo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fffffff][0]='id_grupo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffffffff] = "select id_sist_salario as id_sistema, sist_salario as sist_salario from n_sist_salario ORDER BY sist_salario";

$opt_name[$ffffffff][0]='sist_salario';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffffffff][0]='id_sistema';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffffffff][0]='id_sistema';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fffffffff] = "select id_estado_civil as ID_ESTADO_CIVIL, estado_civil as ESTADO_CIVIL from n_estado_civil ORDER BY estado_civil";

$opt_name[$fffffffff][0]='ESTADO_CIVIL';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fffffffff][0]='ID_ESTADO_CIVIL';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fffffffff][0]='ID_ESTADO_CIVIL';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffffffffff] = "select id_cargo as ID_CARGO_JEFE, cargo as CARGO_JEFE FROM n_cargo ORDER BY CARGO_JEFE";

$opt_name[$ffffffffff][0]='CARGO_JEFE';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffffffffff][0]='ID_CARGO_JEFE';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffffffffff][0]='ID_CARGO_JEFE';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

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
$dato_permit[9]='email';
$dato_permit[10]='entero';
$dato_permit[11]='';
$dato_permit[12]='Rselec';
$dato_permit[13]='';
$dato_permit[14]='Rselec';
$dato_permit[15]='';
$dato_permit[16]='Rselec';
$dato_permit[17]='Rselec';
$dato_permit[18]='';
$dato_permit[19]='';
$dato_permit[20]='Rselec';
$dato_permit[21]='varchar';
$dato_permit[22]='';
$dato_permit[23]='Rselec';
$dato_permit[24]='input';
$dato_permit[25]='';
$dato_permit[26]='Rselec';

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
$value_input[21]='';
$value_input[22]='';
$value_input[23]='';
$value_input[24]='';
$value_input[25]='';
$value_input[26]='';

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
$onclic[21]='';
$onclic[22]='';
$onclic[23]='';
$onclic[24]='';
$onclic[25]='';
$onclic[26]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='20';
$size[6]='10';
$size[7]='100';
$size[8]='50';
$size[9]='50';
$size[10]='10';
$size[11]='';
$size[12]='50';
$size[13]='';
$size[14]='50';
$size[15]='';
$size[16]='50';
$size[17]='';
$size[18]='50';
$size[19]='';
$size[20]='50';
$size[21]='15';
$size[22]='';
$size[23]='50';
$size[24]='5';
$size[25]='';
$size[26]='50';


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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona');
$n_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Estado civil del empleado');
$n_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Secci&oacute;n del empleado');
$n_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Departamento del empleado');
$n_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Correo institucional del empleado');
$n_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Tel&eacute;fono institucional del empleado');
$n_label_ayuda[6]=array('texto'=>$columna[12],'exp'=>'T&iacute;tulo del empleado');
$n_label_ayuda[7]=array('texto'=>$columna[14],'exp'=>'Instituci&oacute;n educativa del empleado');
$n_label_ayuda[8]=array('texto'=>$columna[16],'exp'=>'Tipo de contrato del empleado');
$n_label_ayuda[9]=array('texto'=>$columna[18],'exp'=>'Grupo de gastos del empleado');
$n_label_ayuda[10]=array('texto'=>$columna[20],'exp'=>'Tipo de cuenta del empleado');
$n_label_ayuda[11]=array('texto'=>$columna[22],'exp'=>'Sistema de salario del empleado');
$n_label_ayuda[12]=array('texto'=>$columna[24],'exp'=>'No biom&eacute;trico del empleado');
$n_label_ayuda[13]=array('texto'=>$columna[26],'exp'=>'Cargo del jefe del empleado');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona');
$m_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Estado civil del empleado');
$m_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Secci&oacute;n del empleado');
$m_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Departamento del empleado');
$m_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Correo institucional del empleado');
$m_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Tel&eacute;fono institucional del empleado');
$m_label_ayuda[6]=array('texto'=>$columna[12],'exp'=>'T&iacute;tulo del empleado');
$m_label_ayuda[7]=array('texto'=>$columna[14],'exp'=>'Instituci&oacute;n educativa del empleado');
$m_label_ayuda[8]=array('texto'=>$columna[16],'exp'=>'Tipo de contrato del empleado');
$m_label_ayuda[9]=array('texto'=>$columna[18],'exp'=>'Grupo de gastos del empleado');
$m_label_ayuda[10]=array('texto'=>$columna[20],'exp'=>'Tipo de cuenta del empleado');
$m_label_ayuda[11]=array('texto'=>$columna[22],'exp'=>'Sistema de salario del empleado');
$m_label_ayuda[12]=array('texto'=>$columna[24],'exp'=>'No biom&eacute;trico del empleado');
$m_label_ayuda[13]=array('texto'=>$columna[26],'exp'=>'Cargo del jefe del empleado');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>