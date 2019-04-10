<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

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


$elemento_titulo="de evaluaci&oacute;n de desempe&ntilde;o de: ".$_SESSION['nombre']; // para el título
$elemento="desempeno2"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las evaluaciones de desempe&ntilde;o registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="desempeno";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='empleado';
$tabla_anidada[1]='n_criterio';
$tabla_anidada[2]='n_evaluacion';
$tabla_anidada[3]='n_competencia';
$tabla_anidada[4]='n_periodo';
$tabla_anidada[5]='compromiso';
$tabla_anidada[6]='n_cargo';

$campo_anidado=array();
$campo_anidado[0]='id_empleado';
$campo_anidado[1]='id_criterio';
$campo_anidado[2]='id_evaluacion';
$campo_anidado[3]='id_competencia';
$campo_anidado[4]='id_periodo';
$campo_anidado[5]='id_compromiso';
$campo_anidado[6]='id_cargo';

$tabla_anidada2=array();
$tabla_anidada2[0]='persona';
$tabla_anidada2[1]='empleado as emp';
$tabla_anidada2[2]='persona as per';
$tabla_anidada2[3]='usuario';

$campo_anidado2=array();
$campo_anidado2[0]='id_persona';

$where=" AND empleado.id_persona=persona.id_persona AND desempeno.id_empleado_jefe=emp.id_empleado 
AND emp.id_persona=per.id_persona AND empleado.id_persona=usuario.id_persona ";

$where.="AND usuario='".$_SESSION['user']."' ORDER BY fecha_ini, ".$tabla_anidada2[0].'.id_persona,'.$tabla.".id_competencia, cod_criterio ASC";
$order=" ";
//$ver=1000;

$field[0]='id_desempeno'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla_anidada2[0].'.id_persona';
$field[2]=$tabla_anidada2[0].'.primer_nombre';
$field[3]=$tabla_anidada2[0].'.segundo_nombre';
$field[4]=$tabla_anidada2[0].'.primer_apellido';
$field[5]=$tabla_anidada2[0].'.segundo_apellido';
$field[6]="concat(fecha_ini,'/',fecha_fin,' - ',persona.identificacion,' - ',persona.primer_nombre,' ',persona.segundo_nombre,' ',persona.primer_apellido,' ',persona.segundo_apellido)";
$field[7]=$tabla.'.id_cargo';
$field[8]='cargo';
$field[9]=$tabla.'.id_criterio';
$field[10]='cod_criterio';
$field[11]='criterio';
$field[12]=$tabla.'.id_evaluacion';
$field[13]='cod_evaluacion';
$field[14]='evaluacion';
$field[15]='valor_e';
$field[16]='exp_eval';
$field[17]=$tabla.'.id_competencia';
$field[18]='competencia';
$field[19]=$tabla.'.id_compromiso';
$field[20]='compromiso';
$field[21]=$tabla.'.id_periodo';
$field[22]="concat(fecha_ini,'/',fecha_fin)";
$field[23]=$tabla.'.fecha';
$field[24]=$tabla.'.id_empleado_jefe';
$field[25]="concat(per.identificacion,' - ',per.primer_nombre,' ',per.segundo_nombre,' ',per.primer_apellido,' ',per.segundo_apellido)";

$field_busqueda=array();
$field_busqueda[0]='persona.primer_nombre'; 
$field_busqueda[1]='persona.segundo_nombre';
$field_busqueda[2]="persona.primer_apellido";
$field_busqueda[3]='persona.identificacion';
$field_busqueda[4]="persona.segundo_apellido";
$field_busqueda[5]="fecha_ini";
$field_busqueda[6]="fecha_fin";
$field_busqueda[7]="cod_criterio";
$field_busqueda[8]="criterio";
$field_busqueda[9]="competencia";

$alias_col=array();
$alias_col[0]='id_desempeno';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_empleado';
$alias_col[2]='primer_n';
$alias_col[3]='segundo_n';
$alias_col[4]='primer_a';
$alias_col[5]='segundo_a';
$alias_col[6]='id';
$alias_col[7]='id_cargo';
$alias_col[8]='cargo';
$alias_col[9]='id_criterio';
$alias_col[10]='cod_criterio';
$alias_col[11]='criterio';
$alias_col[12]='id_evaluacion';
$alias_col[13]='cod_eval';
$alias_col[14]='eval';
$alias_col[15]='valor';
$alias_col[16]='exp_eval';
$alias_col[17]='id_competencia';
$alias_col[18]='competencia';
$alias_col[19]='id_compromiso';
$alias_col[20]='compromiso';
$alias_col[21]='id_periodo';
$alias_col[22]='periodo';
$alias_col[23]='fecha';
$alias_col[24]='id_empleado_jefe';
$alias_col[25]='empleado_jefe';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Primer nombre';
$columna[2]='Primer nombre';
$columna[3]='Segundo nombre';
$columna[4]='Primer apellido';
$columna[5]='Segundo apellido';
$columna[6]='Identificaci&oacute;n';
$columna[7]='Cargo';
$columna[8]='Cargo';
$columna[9]='C&oacute;d. de criterio';
$columna[10]='C&oacute;d. de criterio';
$columna[11]='Criterio';
$columna[12]='C&oacute;d. de evaluaci&oacute;n';
$columna[13]='C&oacute;d. de evaluaci&oacute;n';
$columna[14]='Evaluaci&oacute;n';
$columna[15]='Valor de la evaluaci&oacute;n';
$columna[16]='Explicaci&oacute;n de evaluaci&oacute;n';
$columna[17]='Competencia';
$columna[18]='Competencia';
$columna[19]='Compromiso';
$columna[20]='Compromiso';
$columna[21]='Per&iacute;odo evaluado';
$columna[22]='Per&iacute;odo evaluado';
$columna[23]='Fecha';
$columna[24]='Evaluador';
$columna[25]='Evaluador';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]='';
$info_emerg[8]=1;
$info_emerg[9]='';
$info_emerg[10]=1;
$info_emerg[11]=1;
$info_emerg[12]='';
$info_emerg[13]=1;
$info_emerg[14]=1;
$info_emerg[15]=1;
$info_emerg[16]=1;
$info_emerg[17]='';
$info_emerg[18]=1;
$info_emerg[19]='';
$info_emerg[20]=1;
$info_emerg[21]='';
$info_emerg[22]=1;
$info_emerg[23]=1;
$info_emerg[24]='';
$info_emerg[25]=1;

$info_col[0]=''; // si se muestra o no la columna para listar, diferente de 1, 2 o vacío es para agrupar por un campo las filas, el número deber ser el colspan + 2, que haya número no significa que aparezca en columna
$info_col[1]='';
$info_col[2]='';
$info_col[3]='';
$info_col[4]='';
$info_col[5]='';
$info_col[6]=6;
$info_col[7]='';
$info_col[8]=1;
$info_col[9]='';
$info_col[10]=1;
$info_col[11]='';
$info_col[12]='';
$info_col[13]='';
$info_col[14]='';
$info_col[15]=1;
$info_col[16]='';
$info_col[17]='';
$info_col[18]=1;
$info_col[19]='';
$info_col[20]='';
$info_col[21]='';
$info_col[22]='';
$info_col[23]=1;
$info_col[24]='';
$info_col[25]='';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='25%';
$ancho[9]='';
$ancho[10]='9%';
$ancho[11]='';
$ancho[12]='';
$ancho[13]='';
$ancho[14]='';
$ancho[15]='13%';
$ancho[16]='';
$ancho[17]='';
$ancho[18]='43%';
$ancho[19]='';
$ancho[20]='';
$ancho[21]='';
$ancho[22]='';
$ancho[23]='8%';
$ancho[24]='';
$ancho[25]='';


$columna_suma[0]='';
$href_m=$x.'pag/rrhh/compromiso/mod_compromiso.php?mod='; // camino de la pagina para Editar
$var_mod='';

 // no hay Editar, el mismo es para la moficación del compromiso 
$id_cadenacheckboxp=$alias_col[0]; // para suplantar el id del checkbox

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[3]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Primer nombre del evaluado');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Segundo nombre del evaluado');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Primer apellido del evaluado');
$l_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Segundo apellido del evaluado');
$l_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Identificaci&oacute;n del evaluado');
$l_label_ayuda[5]=array('texto'=>$columna[8],'exp'=>'Cargo del empleado');
$l_label_ayuda[6]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de criterio');
$l_label_ayuda[7]=array('texto'=>$columna[11],'exp'=>'Criterio');
$l_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'C&oacute;digo de evaluaci&oacute;n');
$l_label_ayuda[9]=array('texto'=>$columna[14],'exp'=>'Evaluaci&oacute;n');
$l_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Valor de la evaluaci&oacute;n');
$l_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Explicaci&oacute;n de la evaluaci&oacute;n');
$l_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Competencia');
$l_label_ayuda[13]=array('texto'=>$columna[20],'exp'=>'Compromiso del evaluado ');
$l_label_ayuda[14]=array('texto'=>$columna[21],'exp'=>'Per&iacute;odo evaluado');
$l_label_ayuda[15]=array('texto'=>$columna[25],'exp'=>'Jefe del evaluado');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
//$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'planilla_'.$elemento.'.php\')','src'=>$x.'img/general/pdf.png','nombre'=>'editar','texto'=>'Planilla','accion'=>'Imprimir');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'planilla_resumen_desempeno2.php\')','src'=>$x.'img/general/pdf.png','nombre'=>'editar','texto'=>'Resumen','accion'=>'Imprimir');
//$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[2]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[3]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[4]=array('target'=>'_self','href'=>'graf_colum_basica_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/grafico_barra.png','nombre'=>'grafico','texto'=>'Gr&aacute;fico','accion'=>'Visualizar');
$l_botones[5]=array('target'=>'_self','href'=>'graf_linea_basica_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/grafico.png','nombre'=>'grafico','texto'=>'Gr&aacute;fico','accion'=>'Visualizar');
$l_botones[6]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_empleado'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='salario'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='numero_cuenta';
$insert_field[3]='fecha_ingreso';
$insert_field[4]='fecha_baja';
$insert_field[5]='observacion_baja';
$insert_field[6]='id_persona';
$insert_field[7]='';
$insert_field[8]='id_titulo';
$insert_field[9]='';
$insert_field[10]='id_motivo_baja';
$insert_field[11]='';
$insert_field[12]='id_tipo_cuenta';
$insert_field[13]='';
$insert_field[14]='id_seccion';
$insert_field[15]='';
$insert_field[16]='id_tipo_contrato';
$insert_field[17]='';
$insert_field[18]='id_grupo_gastos'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[19]='';
$insert_field[20]='id_sist_salario';
$insert_field[21]='';
$insert_field[22]='id_cargo';
$insert_field[23]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]=$alias_col[2];
$insert_alias[3]=$alias_col[3];
$insert_alias[4]=$alias_col[4];
$insert_alias[5]=$alias_col[5];
$insert_alias[6]=$alias_col[6];
$insert_alias[7]='';
$insert_alias[8]=$alias_col[14];
$insert_alias[9]='';
$insert_alias[10]=$alias_col[16];
$insert_alias[11]='';
$insert_alias[12]=$alias_col[18];
$insert_alias[13]='';
$insert_alias[14]=$alias_col[20];
$insert_alias[15]='';
$insert_alias[16]=$alias_col[22];
$insert_alias[17]='';
$insert_alias[18]=$alias_col[24];
$insert_alias[19]='';
$insert_alias[20]=$alias_col[25];
$insert_alias[21]='';
$insert_alias[22]=$alias_col[25];
$insert_alias[23]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[1]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[3]; 
$name_input[4]=$alias_col[4]; 
$name_input[5]=$alias_col[5]; 
$name_input[6]=$alias_col[7]; 
$name_input[7]=$alias_col[7]; 
$name_input[8]=$alias_col[14]; 
$name_input[9]=$alias_col[14]; 
$name_input[10]=$alias_col[16]; 
$name_input[11]=$alias_col[16]; 
$name_input[12]=$alias_col[18]; 
$name_input[13]=$alias_col[18]; 
$name_input[14]=$alias_col[20]; 
$name_input[15]=$alias_col[20]; 
$name_input[16]=$alias_col[22]; 
$name_input[17]=$alias_col[22];
$name_input[18]=$alias_col[24]; 
$name_input[19]=$alias_col[24]; 
$name_input[20]=$alias_col[25]; 
$name_input[21]=$alias_col[25]; 
$name_input[22]=$alias_col[25]; 
$name_input[23]=$alias_col[25]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];
$label_input[4]=$columna[4];
$label_input[5]=$columna[5];
$label_input[6]='Persona';
$label_input[7]='Persona';
$label_input[8]=$columna[15];
$label_input[9]=$columna[15];
$label_input[10]=$columna[17];
$label_input[11]=$columna[17];
$label_input[12]=$columna[19];
$label_input[13]=$columna[19];
$label_input[14]=$columna[21];
$label_input[15]=$columna[21];
$label_input[16]=$columna[23];
$label_input[17]=$columna[23];
$label_input[18]=$columna[25];
$label_input[19]=$columna[25];
$label_input[20]=$columna[25];
$label_input[21]=$columna[25];
$label_input[22]=$columna[25];
$label_input[23]=$columna[25];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]=1;
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]=2;
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
$field_unico[20]='';
$field_unico[21]='';
$field_unico[22]='';
$field_unico[23]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='input';
$tipo_input[6]='';
$tipo_input[7]='selectBD';
$tipo_input[8]='';
$tipo_input[9]='selectBD';
$tipo_input[10]='';
$tipo_input[11]='selectBD';
$tipo_input[12]='';
$tipo_input[13]='selectBD';
$tipo_input[14]='';
$tipo_input[15]='selectBD';
$tipo_input[16]='';
$tipo_input[17]='selectBD';
$tipo_input[18]='';
$tipo_input[19]='selectBD';
$tipo_input[20]='';
$tipo_input[21]='selectBD';
$tipo_input[22]='';
$tipo_input[23]='selectBD';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=7;
$ff=9;
$fff=11;
$ffff=13;
$fffff=15;
$ffffff=17;
$fffffff=19;
$ffffffff=21;
$fffffffff=23;

$combo_sql[$f] = "select id_persona as id_persona, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as persona from persona";

$opt_name=array();
$opt_name[$f][0]='persona';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value=array();
$opt_value[$f][0]='id_persona';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel=array();
$opt_sel[$f][0]='id_persona';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ff] = "select id_titulo as id_titulo, titulo as titulo from n_titulo";

$opt_name[$ff][0]='titulo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ff][0]='id_titulo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ff][0]='id_titulo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fff] = "select id_motivo_baja as id_motivo, motivo_baja as motivo_baja from n_motivo_baja";

$opt_name[$fff][0]='motivo_baja';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fff][0]='id_motivo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fff][0]='id_motivo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffff] = "select id_tipo_cuenta as id_tipo, tipo_cuenta as tipo_cuenta from n_tipo_cuenta";

$opt_name[$ffff][0]='tipo_cuenta';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffff][0]='id_tipo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffff][0]='id_tipo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fffff] = "select id_seccion as id_seccion, seccion as seccion from n_seccion";

$opt_name[$fffff][0]='seccion';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fffff][0]='id_seccion';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fffff][0]='id_seccion';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffffff] = "select id_tipo_contrato as id_tipo_cont, tipo_contrato as tipo_contrato from n_tipo_contrato";

$opt_name[$ffffff][0]='tipo_contrato';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffffff][0]='id_tipo_cont';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffffff][0]='id_tipo_cont';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fffffff] = "select id_grupo_gastos as id_grupo, grupo_gastos as grupo_gastos from n_grupo_gastos";

$opt_name[$fffffff][0]='grupo_gastos';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fffffff][0]='id_grupo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fffffff][0]='id_grupo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffffffff] = "select id_sist_salario as id_sistema, sist_salario as sist_salario from n_sist_salario";

$opt_name[$ffffffff][0]='sist_salario';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffffffff][0]='id_sistema';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffffffff][0]='id_sistema';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fffffffff] = "select id_cargo as id_cargo, cargo as cargo from n_cargo";

$opt_name[$fffffffff][0]='cargo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fffffffff][0]='id_cargo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fffffffff][0]='id_cargo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rfloat';
$dato_permit[2]='entero';
$dato_permit[3]='Rfecha';
$dato_permit[4]='fecha';
$dato_permit[5]='varchar';
$dato_permit[6]='';
$dato_permit[7]='Rselec';
$dato_permit[8]='';
$dato_permit[9]='Rselec';
$dato_permit[10]='';
$dato_permit[11]='selec';
$dato_permit[12]='';
$dato_permit[13]='Rselec';
$dato_permit[14]='';
$dato_permit[15]='Rselec';
$dato_permit[16]='';
$dato_permit[17]='Rselec';
$dato_permit[18]='';
$dato_permit[19]='Rselec';
$dato_permit[20]='';
$dato_permit[21]='Rselec';
$dato_permit[22]='';
$dato_permit[23]='Rselec';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]=date('Y-m-d');
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

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='displayCalendar(document.frm.'.$name_input[3].',"yyyy-m-d",this);';
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

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='20';
$size[6]='10';
$size[7]='100';
$size[8]='50';
$size[9]='10';
$size[10]='10';
$size[11]='50';
$size[12]='';
$size[13]='50';
$size[14]='';
$size[15]='50';
$size[16]='';
$size[17]='50';
$size[18]='';
$size[19]='50';
$size[20]='';
$size[21]='50';
$size[22]='';
$size[23]='50';


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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Primer nombre del evaluado');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Segundo nombre del evaluado');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Primer apellido del evaluado');
$n_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Segundo apellido del evaluado');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Identificaci&oacute;n del evaluado');
$n_label_ayuda[5]=array('texto'=>$columna[8],'exp'=>'Cargo del empleado');
$n_label_ayuda[6]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de criterio');
$n_label_ayuda[7]=array('texto'=>$columna[11],'exp'=>'Criterio');
$n_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'C&oacute;digo de evaluaci&oacute;n');
$n_label_ayuda[9]=array('texto'=>$columna[14],'exp'=>'Evaluaci&oacute;n');
$n_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Valor de la evaluaci&oacute;n');
$n_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Explicaci&oacute;n de la evaluaci&oacute;n');
$n_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Competencia');
$n_label_ayuda[13]=array('texto'=>$columna[20],'exp'=>'Compromiso del evaluado ');
$n_label_ayuda[14]=array('texto'=>$columna[21],'exp'=>'Per&iacute;odo evaluado');
$n_label_ayuda[15]=array('texto'=>$columna[25],'exp'=>'Jefe del evaluado');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Primer nombre del evaluado');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Segundo nombre del evaluado');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Primer apellido del evaluado');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Segundo apellido del evaluado');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Identificaci&oacute;n del evaluado');
$m_label_ayuda[5]=array('texto'=>$columna[8],'exp'=>'Cargo del empleado');
$m_label_ayuda[6]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de criterio');
$m_label_ayuda[7]=array('texto'=>$columna[11],'exp'=>'Criterio');
$m_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'C&oacute;digo de evaluaci&oacute;n');
$m_label_ayuda[9]=array('texto'=>$columna[14],'exp'=>'Evaluaci&oacute;n');
$m_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Valor de la evaluaci&oacute;n');
$m_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Explicaci&oacute;n de la evaluaci&oacute;n');
$m_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Competencia');
$m_label_ayuda[13]=array('texto'=>$columna[20],'exp'=>'Compromiso del evaluado ');
$m_label_ayuda[14]=array('texto'=>$columna[21],'exp'=>'Per&iacute;odo evaluado');
$m_label_ayuda[15]=array('texto'=>$columna[25],'exp'=>'Jefe del evaluado');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>