<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="cont";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de inventario de activos fijos de todas las ubicaciones"; // para el título
$elemento="inventario"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los inventarios registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="inventario";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_articulo';
$tabla_anidada[1]='n_estado';
$tabla_anidada[2]='n_proveedor';
$tabla_anidada[3]='n_tipo_depreciacion';

$tabla_anidada2[0]='n_marca';
$tabla_anidada2[1]='n_modelo';

$campo_anidado=array();
$campo_anidado[0]='id_articulo';
$campo_anidado[1]='id_estado';
$campo_anidado[2]='id_proveedor';
$campo_anidado[3]='id_tipo_depreciacion';

$campo_anidado2[0]='n_marca.id_marca';
$campo_anidado2[1]='n_modelo.id_modelo';

$where=' AND n_marca.id_marca=n_articulo.id_marca AND n_modelo.id_modelo=n_articulo.id_modelo';
 
$order=" fec DESC";

$field=array();
$field[0]='id_inventario'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='no_inventario';
$field[2]='no_serie';
$field[3]='cantidad';
$field[4]='fecha_adquisicion';
$field[5]='costo';
$field[6]='depreciacion_ini';
$field[7]='tiempo_uso';
$field[8]='observacion';
$field[9]=$tabla.'.id_articulo';
$field[10]='cod_articulo';
$field[11]="concat(articulo,' - Marca: ',marca,' Modelo: ', modelo)";
$field[12]=$tabla.'.id_estado';
$field[13]='estado';
$field[14]=$tabla.'.id_proveedor';
$field[15]="concat(ruc,' - ',proveedor)";
$field[16]=$tabla.'.id_tipo_depreciacion';
$field[17]='tipo_depreciacion';
$field[18]='doc_factura';

$alias_col=array();
$alias_col[0]='id_inventario';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='inv';
$alias_col[2]='ser';
$alias_col[3]='cant';
$alias_col[4]='fec';
$alias_col[5]='cos';
$alias_col[6]='depre';
$alias_col[7]='uso';
$alias_col[8]='obs';
$alias_col[9]='id_articulo';
$alias_col[10]='cod_articulo';
$alias_col[11]='articulo';
$alias_col[12]='id_estado';
$alias_col[13]='estado';
$alias_col[14]='id_proveedor';
$alias_col[15]='proveedor';
$alias_col[16]='id_tipo_depreciacion';
$alias_col[17]='tipo_depreciacion';
$alias_col[18]='doc';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='No inventario';
$columna[2]='No serie';
$columna[3]='Cantidad';
$columna[4]='Fecha adquisici&oacute;n';
$columna[5]='Costo total';
$columna[6]='Depreciaci&oacuten inicial';
$columna[7]='Tiempo de uso inicial (meses)';
$columna[8]='Observaci&oacute;n';
$columna[9]='C&oacute;d. art&iacute;culo';
$columna[10]='C&oacute;d. art&iacute;culo';
$columna[11]='Art&iacute;culo';
$columna[12]='Estado';
$columna[13]='Estado';
$columna[14]='Proveedor';
$columna[15]='Proveedor';
$columna[16]='Tipo de depreciaci&oacute;n';
$columna[17]='Tipo de depreciaci&oacute;n';
$columna[18]='';

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

$info_emerg=array();
$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]='';
$info_emerg[11]=1;
$info_emerg[12]='';
$info_emerg[13]=1;
$info_emerg[14]='';
$info_emerg[15]=1;
$info_emerg[16]='';
$info_emerg[17]=1;
$info_emerg[18]='';

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]='';
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=1;
$info_col[6]='';
$info_col[7]='';
$info_col[8]='';
$info_col[9]='';
$info_col[10]='';
$info_col[11]=1;
$info_col[12]='';
$info_col[13]='';
$info_col[14]='';
$info_col[15]=1;
$info_col[16]='';
$info_col[17]='';
$info_col[18]='file_no_BD';

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='10%';
$ancho[2]='';
$ancho[3]='6%';
$ancho[4]='10%';
$ancho[5]='6%';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='';
$ancho[9]='';
$ancho[10]='';
$ancho[11]='35%';
$ancho[12]='';
$ancho[13]='';
$ancho[14]='';
$ancho[15]='29%';
$ancho[16]='';
$ancho[17]='';
$ancho[18]='1%';

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
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No inventario del art&iacute;culo');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'No serie del art&iacute;culo');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Cantidad del art&iacute;culo');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha adquisici&oacute;n del art&iacute;culo');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Costo del art&iacute;culo');
$l_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Depreciaci&oacuten inicial del art&iacute;culo');
$l_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Documento de factura');
$l_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Observaci&oacute;n');
$l_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'C&oacute;d. art&iacute;culo');
$l_label_ayuda[9]=array('texto'=>$columna[11],'exp'=>'Art&iacute;culo');
$l_label_ayuda[10]=array('texto'=>$columna[13],'exp'=>'Estado del art&iacute;culo');
$l_label_ayuda[11]=array('texto'=>$columna[15],'exp'=>'Proveedor del art&iacute;culo');
$l_label_ayuda[12]=array('texto'=>$columna[17],'exp'=>'Tipo de depreciaci&oacute;n del art&iacute;culo');

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
$insert_field[0]='id_inventario'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_articulo';
$insert_field[2]='';
$insert_field[3]='no_inventario'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[4]='no_serie';
$insert_field[5]='cantidad';
$insert_field[6]='fecha_adquisicion';
$insert_field[7]='costo';
$insert_field[8]='depreciacion_ini';
$insert_field[9]='tiempo_uso';
$insert_field[10]='doc_factura';
$insert_field[11]='observacion';
$insert_field[12]='id_estado';
$insert_field[13]='';
$insert_field[14]='id_proveedor';
$insert_field[15]='';
$insert_field[16]='id_tipo_depreciacion';
$insert_field[17]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[9];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[1];
$insert_alias[4]=$alias_col[2];
$insert_alias[5]=$alias_col[3];
$insert_alias[6]=$alias_col[4];
$insert_alias[7]=$alias_col[5];
$insert_alias[8]=$alias_col[6];
$insert_alias[9]=$alias_col[7];
$insert_alias[10]=$alias_col[18];
$insert_alias[11]=$alias_col[8];
$insert_alias[12]=$alias_col[12];
$insert_alias[13]='';
$insert_alias[14]=$alias_col[14];
$insert_alias[15]='';
$insert_alias[16]=$alias_col[16];
$insert_alias[17]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[11]; 
$name_input[2]=$alias_col[11];
$name_input[3]=$alias_col[1]; 
$name_input[4]=$alias_col[2]; 
$name_input[5]=$alias_col[3]; 
$name_input[6]=$alias_col[4]; 
$name_input[7]=$alias_col[5]; 
$name_input[8]=$alias_col[6]; 
$name_input[9]=$alias_col[7]; 
$name_input[10]=$alias_col[18]; 
$name_input[11]=$alias_col[8]; 
$name_input[12]=$alias_col[13]; 
$name_input[13]=$alias_col[13]; 
$name_input[14]=$alias_col[15]; 
$name_input[15]=$alias_col[15]; 
$name_input[16]=$alias_col[17]; 
$name_input[17]=$alias_col[17];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[10];// label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[11];
$label_input[3]=$columna[1]; 
$label_input[4]=$columna[2];
$label_input[5]=$columna[3];
$label_input[6]=$columna[4];
$label_input[7]=$columna[5];
$label_input[8]=$columna[6];
$label_input[9]=$columna[7];
$label_input[10]='Documento de factura (jpg menor a 50Kb)';
$label_input[11]=$columna[8];
$label_input[12]=$columna[12];
$label_input[13]=$columna[13];
$label_input[14]=$columna[14];
$label_input[15]=$columna[15];
$label_input[16]=$columna[16];
$label_input[17]=$columna[17];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]=1;
$field_unico[4]=1;
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
$field_unico[17]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='texto_input';
$tipo_input[6]='input';
$tipo_input[7]='input';
$tipo_input[8]='input';
$tipo_input[9]='input';
$tipo_input[10]='file_no_BD';
$tipo_input[11]='textarea';
$tipo_input[12]='';
$tipo_input[13]='selectBD';
$tipo_input[14]='';
$tipo_input[15]='selectBD';
$tipo_input[16]='';
$tipo_input[17]='selectBD';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=2;
$ff=13;
$fff=15;
$t=17;
$combo_sql[$f] = "SELECT n_articulo.id_articulo AS id_articulo, concat(articulo,' - Marca:',marca,' Modelo:', modelo) AS articulo FROM n_articulo, n_marca, n_modelo 
WHERE 1 AND activo_fijo='1' AND n_articulo.id_marca=n_marca.id_marca AND n_articulo.id_modelo=n_modelo.id_modelo ORDER BY articulo";

$opt_name=array();
$opt_name[$f][0]='articulo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$f][2]='';
$opt_name[$f][3]='';

$opt_value=array();
$opt_value[$f][0]='id_articulo';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';
$opt_value[$f][2]='';
$opt_value[$f][3]='';

$opt_sel=array();
$opt_sel[$f][0]='id_articulo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$f][2]='';
$opt_sel[$f][3]='';

$combo_sql[$ff] = "select id_estado as id_estado, estado as estado from n_estado";

$opt_name[$ff][0]='estado';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$ff][2]='';
$opt_name[$ff][3]='';

$opt_value[$ff][0]='id_estado';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ff][1]='';
$opt_value[$ff][2]='';
$opt_value[$ff][3]='';

$opt_sel[$ff][0]='id_estado';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$ff][2]='';
$opt_sel[$ff][3]='';

$combo_sql[$fff] = "select id_proveedor as id_proveedor, concat(proveedor,' - ',ruc) as proveedor from n_proveedor";

$opt_name[$fff][0]='proveedor';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$fff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$fff][2]='';
$opt_name[$fff][3]='';

$opt_value[$fff][0]='id_proveedor';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$fff][1]='';
$opt_value[$fff][2]='';
$opt_value[$fff][3]='';

$opt_sel[$fff][0]='id_proveedor';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$fff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$fff][2]='';
$opt_sel[$fff][3]='';

$combo_sql[$t] = "select id_tipo_depreciacion as id_tipo_depreciacion, tipo_depreciacion as tipo_depreciacion from n_tipo_depreciacion";


$opt_name[$t][0]='tipo_depreciacion';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$t][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$t][2]='';
$opt_name[$t][3]='';

$opt_value[$t][0]='id_tipo_depreciacion';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$t][1]='';
$opt_value[$t][2]='';
$opt_value[$t][3]='';

$opt_sel[$t][0]='id_tipo_depreciacion';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$t][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$t][2]='';
$opt_sel[$t][3]='';

// valores que va a tomar el campo tipo <select> en cada <option>
$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='varchar';
$dato_permit[4]='varchar';
$dato_permit[5]='Rentero';
$dato_permit[6]='Rfecha';
$dato_permit[7]='Rfloat';
$dato_permit[8]='Rentero';
$dato_permit[9]='Rentero';
$dato_permit[10]='varchar';
$dato_permit[11]='varchar';
$dato_permit[12]='';
$dato_permit[13]='Rselec';
$dato_permit[14]='';
$dato_permit[15]='Rselec';
$dato_permit[16]='';
$dato_permit[17]='Rselec';

$texto_input=array();
$texto_input[0]=''; // valor que va a tener el campo a la derecha como texto explicativo, no es necesario k llegue hasta el final
$texto_input[3]='&nbsp;<a onMouseOver="return overlib(\'Para ingresar el art&iacute;culo en almac&eacute;n no es obligatorio el -No inventario- ya que este puede asignarse posteriormente.\', ABOVE, RIGHT);" onMouseOut="return nd();"><img src="'.$x.'img/general/help.png";></a>';
$texto_input[13]='<a href="#modal0"><img src="'.$x.'img/general/agregar.png";></a>';
$texto_input[15]='<a href="#modal1"><img src="'.$x.'img/general/agregar.png";></a>';
$texto_input[17]='<a href="#modal2"><img src="'.$x.'img/general/agregar.png";></a>';

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='1';
$value_input[6]=date('Y-m-d');
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

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='ejecutar_ajax("'.$x.$camino.'/sel_atributos.php","articulo","div_atributos")';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='displayCalendar(document.frm.'.$name_input[6].',"yyyy-m-d",this)';
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

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='30';
$size[4]='30';
$size[5]='5';
$size[6]='10';
$size[7]='10';
$size[8]='10';
$size[9]='10';
$size[10]='10';
$size[11]='50';
$size[12]='';
$size[13]='50';
$size[14]='';
$size[15]='50';
$size[16]='';
$size[17]='50';

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
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No inventario del art&iacute;culo');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'No serie del art&iacute;culo');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Cantidad del art&iacute;culo');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha adquisici&oacute;n del art&iacute;culo');
$n_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Costo del art&iacute;culo');
$n_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Depresiaci&oacuten inicial del art&iacute;culo');
$n_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Documento de factura');
$n_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Observaci&oacute;n');
$n_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'C&oacute;d. art&iacute;culo');
$n_label_ayuda[9]=array('texto'=>$columna[11],'exp'=>'Art&iacute;culo');
$n_label_ayuda[10]=array('texto'=>$columna[13],'exp'=>'Estado del art&iacute;culo');
$n_label_ayuda[11]=array('texto'=>$columna[15],'exp'=>'Proveedor del art&iacute;culo');
$n_label_ayuda[12]=array('texto'=>$columna[17],'exp'=>'Tipo de depreciaci&oacute;n del art&iacute;culo');

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
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No inventario del art&iacute;culo');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'No serie del art&iacute;culo');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Cantidad del art&iacute;culo');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha adquisici&oacute;n del art&iacute;culo');
$m_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Costo del art&iacute;culo');
$m_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Depresiaci&oacuten inicial del art&iacute;culo');
$m_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Documento de factura');
$m_label_ayuda[7]=array('texto'=>$columna[8],'exp'=>'Observaci&oacute;n');
$m_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'C&oacute;d. art&iacute;culo');
$m_label_ayuda[9]=array('texto'=>$columna[11],'exp'=>'Art&iacute;culo');
$m_label_ayuda[10]=array('texto'=>$columna[13],'exp'=>'Estado del art&iacute;culo');
$m_label_ayuda[11]=array('texto'=>$columna[15],'exp'=>'Proveedor del art&iacute;culo');
$m_label_ayuda[12]=array('texto'=>$columna[17],'exp'=>'Tipo de depreciaci&oacute;n del art&iacute;culo');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>