<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="bibl";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de libro"; // para el título
$elemento="libro"; // elemento o nomenclador al que se accede
$camino="pag/bibl/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/bibl/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los libros registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="libro";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_editorial';
$tabla_anidada[1]='n_autor';
$tabla_anidada[2]='n_genero_literario';
$tabla_anidada[3]='n_ubicacion';

$tabla_anidada2[0]='n_bloque';
$tabla_anidada2[1]='n_secc';
$tabla_anidada2[2]='n_division';

$campo_anidado=array();
$campo_anidado[0]='id_editorial';
$campo_anidado[1]='id_autor';
$campo_anidado[2]='id_genero_literario';
$campo_anidado[3]='id_ubicacion';

$campo_anidado2[0]='n_bloque.id_bloque';
$campo_anidado2[1]='n_secc.id_secc';
$campo_anidado2[2]='n_division.id_division';

$where=' AND n_ubicacion.id_bloque=n_bloque.id_bloque AND n_ubicacion.id_division=n_division.id_division AND n_ubicacion.id_secc=n_secc.id_secc ';

//$where=' AND (NOT EXISTS (SELECT 1 FROM n_autor WHERE libro.id_autor=n_autor.id_autor))';
$order=" no_ficha";

$field=array();
$field[0]='id_libro'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='no_ficha';
$field[2]='titulo';
$field[3]='anno';
$field[4]='isbn';
$field[5]='fecha_entrada';
$field[6]='costo';
$field[7]='prestado';
$field[8]='baja';
$field[9]=$tabla.'.id_editorial';
$field[10]='editorial';
$field[11]=$tabla.'.id_autor';
$field[12]='autor';
$field[13]=$tabla.'.id_genero_literario';
$field[14]='genero_literario';
$field[15]=$tabla.'.id_ubicacion';
$field[16]="concat(ubicacion,' - ',bloque,' - ',secc,' - ',division)";

$field_busqueda=array();
$field_busqueda[0]='no_ficha'; 
$field_busqueda[1]='titulo';
$field_busqueda[2]="anno";
$field_busqueda[3]='isbn';
$field_busqueda[4]="editorial";
$field_busqueda[5]='autor';
$field_busqueda[6]='genero_literario';
$field_busqueda[7]="ubicacion";

$alias_col=array();
$alias_col[0]='id_libro';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='prin';
$alias_col[2]='segn';
$alias_col[3]='pria';
$alias_col[4]='sega';
$alias_col[5]='ide';
$alias_col[6]='fec';
$alias_col[7]='dir';
$alias_col[8]='ema';
$alias_col[9]='id_e';
$alias_col[10]='edi';
$alias_col[11]='id_a';
$alias_col[12]='aut';
$alias_col[13]='id_g';
$alias_col[14]='gen';
$alias_col[15]='id_u';
$alias_col[16]='ubi';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='No ficha';
$columna[2]='T&iacute;tulo';
$columna[3]='A&ntilde;o';
$columna[4]='ISBN';
$columna[5]='Fecha registro';
$columna[6]='Costo';
$columna[7]='Prestado';
$columna[8]='Baja';
$columna[9]='Editorial';
$columna[10]='Editorial';
$columna[11]='Autor';
$columna[12]='Autor';
$columna[13]='G&eacute;nero';
$columna[14]='G&eacute;nero';
$columna[15]='Ubicaci&oacute;n';
$columna[16]='Ubicaci&oacute;n';

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

$info_emerg=array();
$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=2;
$info_emerg[8]=2;
$info_emerg[9]='';
$info_emerg[10]=1;
$info_emerg[11]='';
$info_emerg[12]=1;
$info_emerg[13]='';
$info_emerg[14]=1;
$info_emerg[15]='';
$info_emerg[16]=1;

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]=1;
$info_col[3]=1;
$info_col[4]='';
$info_col[5]=1;
$info_col[6]='';
$info_col[7]=2;
$info_col[8]=2;
$info_col[9]='';
$info_col[10]='';
$info_col[11]='';
$info_col[12]='';
$info_col[13]='';
$info_col[14]='';
$info_col[15]='';
$info_col[16]=1;

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='8%';
$ancho[2]='35%';
$ancho[3]='6%';
$ancho[4]='';
$ancho[5]='10%';
$ancho[6]='';
$ancho[7]='6%';
$ancho[8]='5%';
$ancho[9]='';
$ancho[10]='';
$ancho[11]='';
$ancho[12]='';
$ancho[13]='';
$ancho[14]='';
$ancho[15]='';
$ancho[16]='26%';

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
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No ficha del libro');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'T&iacute;tulo del libro');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'A&ntilde;o del libro');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'ISBN del libro');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Fecha registro del libro');
$l_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Costo del libro');
$l_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Está prestado el libro?: Si o No');
$l_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Es baja el libro?: Si o No');
$l_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Editorial del libro');
$l_label_ayuda[9]=array('texto'=>$columna[12],'exp'=>'Autor del libro');
$l_label_ayuda[10]=array('texto'=>$columna[14],'exp'=>'G&eacute;nero literario del libro');
$l_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Ubicaci&oacute;n del libro');

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
$insert_field[0]='id_libro'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='no_ficha'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='titulo';
$insert_field[3]='anno';
$insert_field[4]='isbn';
$insert_field[5]='fecha_entrada';
$insert_field[6]='costo';
$insert_field[7]='prestado';
$insert_field[8]='baja';
$insert_field[9]='id_editorial';
$insert_field[10]='';
$insert_field[11]='id_autor';
$insert_field[12]=''; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[13]='id_genero_literario';
$insert_field[14]='';
$insert_field[15]='id_ubicacion';
$insert_field[16]='';

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
$insert_alias[13]=$alias_col[13];
$insert_alias[14]='';
$insert_alias[15]=$alias_col[15];
$insert_alias[16]='';

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
$name_input[13]=$alias_col[14]; 
$name_input[14]=$alias_col[14]; 
$name_input[15]=$alias_col[16]; 
$name_input[16]=$alias_col[16];

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
$label_input[10]=$columna[10];
$label_input[11]=$columna[11];
$label_input[12]=$columna[12];
$label_input[13]=$columna[13];
$label_input[14]=$columna[14];
$label_input[15]=$columna[15];
$label_input[16]=$columna[16];

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

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='input';
$tipo_input[6]='input';
$tipo_input[7]='select';
$tipo_input[8]='select';
$tipo_input[9]='';
$tipo_input[10]='selectBD';
$tipo_input[11]='';
$tipo_input[12]='selectBD';
$tipo_input[13]='';
$tipo_input[14]='selectBD';
$tipo_input[15]='';
$tipo_input[16]='selectBD';

// valores que va a tomar el campo tipo <select> en cada <option>
$ffff=7;
$h=8;
$f=10;
$ff=12;
$fff=14;
$t=16;
$combo_sql[$f] = "select id_editorial as id_e, editorial as edi from n_editorial";

$opt_name=array();
$opt_name[$f][0]='edi';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$f][2]='';
$opt_name[$f][3]='';

$opt_value=array();
$opt_value[$f][0]='id_e';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';
$opt_value[$f][2]='';
$opt_value[$f][3]='';

$opt_sel=array();
$opt_sel[$f][0]='id_e';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$f][2]='';
$opt_sel[$f][3]='';

$combo_sql[$ff] = "select id_autor as id_a, autor as aut from n_autor";

$opt_name[$ff][0]='aut';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$ff][2]='';
$opt_name[$ff][3]='';

$opt_value[$ff][0]='id_a';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ff][1]='';
$opt_value[$ff][2]='';
$opt_value[$ff][3]='';

$opt_sel[$ff][0]='id_a';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$ff][2]='';
$opt_sel[$ff][3]='';

$combo_sql[$fff] = "select id_genero_literario as id_g, genero_literario as gen from n_genero_literario";

$opt_name[$fff][0]='gen';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$fff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$fff][2]='';
$opt_name[$fff][3]='';

$opt_value[$fff][0]='id_g';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$fff][1]='';
$opt_value[$fff][2]='';
$opt_value[$fff][3]='';

$opt_sel[$fff][0]='id_g';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$fff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$fff][2]='';
$opt_sel[$fff][3]='';

$combo_sql[$t] = "SELECT id_ubicacion as id_u, concat(ubicacion,' - ',bloque,' - ',secc,' - ',division) as ubi 
FROM n_ubicacion, n_bloque, n_division, n_secc WHERE 1 AND n_ubicacion.id_bloque=n_bloque.id_bloque AND n_ubicacion.id_division=n_division.id_division AND n_ubicacion.id_secc=n_secc.id_secc ORDER BY bloque,secc,division";

$opt_name[$t][0]='ubi';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$t][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$t][2]='';
$opt_name[$t][3]='';

$opt_value[$t][0]='id_u';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$t][1]='';
$opt_value[$t][2]='';
$opt_value[$t][3]='';

$opt_sel[$t][0]='id_u';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$t][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$t][2]='';
$opt_sel[$t][3]='';

$opt_name[$ffff][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ffff][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$ffff][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ffff][1]='0';

$opt_sel[$ffff][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ffff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$opt_name[$h][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$h][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$h][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$h][1]='0';

$opt_sel[$h][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$h][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rvarchar';
$dato_permit[2]='Rvarchar';
$dato_permit[3]='entero';
$dato_permit[4]='varchar';
$dato_permit[5]='Rfecha';
$dato_permit[6]='float';
$dato_permit[7]='Rselec';
$dato_permit[8]='Rselec';
$dato_permit[9]='';
$dato_permit[10]='Rselec';
$dato_permit[11]='';
$dato_permit[12]='Rselec';
$dato_permit[13]='';
$dato_permit[14]='Rselec';
$dato_permit[15]='';
$dato_permit[16]='Rselec';

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]=date('Y-m-d');;
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

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='displayCalendar(document.frm.'.$name_input[5].',"yyyy-m-d",this);';
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

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='100';
$size[3]='50';
$size[4]='50';
$size[5]='10';
$size[6]='10';
$size[7]='50';
$size[8]='50';
$size[9]='';
$size[10]='50';
$size[11]='';
$size[12]='50';
$size[13]='';
$size[14]='50';
$size[15]='';
$size[16]='50';

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
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No ficha del libro');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'T&iacute;tulo del libro');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'A&ntilde;o del libro');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'ISBN del libro');
$n_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Fecha registro del libro');
$n_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Costo del libro');
$n_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Está prestado el libro?: Si o No');
$n_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Es baja el libro?: Si o No');
$n_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Editorial del libro');
$n_label_ayuda[9]=array('texto'=>$columna[12],'exp'=>'Autor del libro');
$n_label_ayuda[10]=array('texto'=>$columna[14],'exp'=>'G&eacute;nero literario del libro');
$n_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Ubicaci&oacute;n del libro');

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
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No ficha del libro');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'T&iacute;tulo del libro');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'A&ntilde;o del libro');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'ISBN del libro');
$m_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Fecha registro del libro');
$m_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Costo del libro');
$m_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Está prestado el libro?: Si o No');
$m_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Es baja el libro?: Si o No');
$m_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Editorial del libro');
$m_label_ayuda[9]=array('texto'=>$columna[12],'exp'=>'Autor del libro');
$m_label_ayuda[10]=array('texto'=>$columna[14],'exp'=>'G&eacute;nero literario del libro');
$m_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Ubicaci&oacute;n del libro');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>