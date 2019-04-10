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


$elemento_titulo="de inventario de material gastable en almac&eacute;n o proveedur&iacute;a"; // para el título
$elemento="inventario_consumibles"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los inventario_consumibless registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="inventario_consumibles";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_articulo';
$tabla_anidada[1]='n_proveedor';

$tabla_anidada2[0]='n_marca';
$tabla_anidada2[1]='n_modelo';

$campo_anidado=array();
$campo_anidado[0]='id_articulo';
$campo_anidado[1]='id_proveedor';

$campo_anidado2[0]='n_marca.id_marca';
$campo_anidado2[1]='n_modelo.id_modelo';

$where=' AND n_marca.id_marca=n_articulo.id_marca AND n_modelo.id_modelo=n_articulo.id_modelo';

$order=" fec DESC";

$field=array();
$field[0]='id_inventario_consumibles'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='cantidad';
$field[2]='fecha_adquisicion';
$field[3]='costo';
$field[4]='observacion';
$field[5]=$tabla.'.id_articulo';
$field[6]='cod_articulo';
$field[7]="concat(articulo,' - Marca: ',marca,' Modelo: ', modelo)";
$field[8]=$tabla.'.id_proveedor';
$field[9]="concat(ruc,' - ',proveedor)";
$field[10]='doc_factura';

$alias_col=array();
$alias_col[0]='id_inventario_consumibles';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='cant';
$alias_col[2]='fec';
$alias_col[3]='cos';
$alias_col[4]='obs';
$alias_col[5]='id_articulo';
$alias_col[6]='cod_articulo';
$alias_col[7]='articulo';
$alias_col[8]='id_proveedor';
$alias_col[9]='proveedor';
$alias_col[10]='doc';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Cantidad';
$columna[2]='Fecha adquisici&oacute;n';
$columna[3]='Costo total';
$columna[4]='Observaci&oacute;n';
$columna[5]='C&oacute;d. art&iacute;culo';
$columna[6]='C&oacute;d. art&iacute;culo';
$columna[7]='Art&iacute;culo';
$columna[8]='Proveedor';
$columna[9]='Proveedor';
$columna[10]='';

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

$info_emerg=array();
$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]='';
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]='';
$info_emerg[9]=1;
$info_emerg[10]='';

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]=1;
$info_col[3]='';
$info_col[4]='';
$info_col[5]='';
$info_col[6]='';
$info_col[7]=1;
$info_col[8]='';
$info_col[9]=1;
$info_col[10]='file_no_BD';

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='6%';
$ancho[2]='9%';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='';
$ancho[6]='';
$ancho[7]='35%';
$ancho[8]='';
$ancho[9]='34%';
$ancho[10]='1%';

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
$l_label_ayuda[1]=array('texto'=>$columna[1],'exp'=>'Cantidad del art&iacute;culo');
$l_label_ayuda[2]=array('texto'=>$columna[2],'exp'=>'Fecha adquisici&oacute;n del art&iacute;culo');
$l_label_ayuda[3]=array('texto'=>$columna[3],'exp'=>'Costo del art&iacute;culo');
$l_label_ayuda[4]=array('texto'=>$columna[4],'exp'=>'Observaci&oacute;n');
$l_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'C&oacute;d. art&iacute;culo');
$l_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Art&iacute;culo');
$l_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Proveedor del art&iacute;culo');
$l_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Documento de factura');

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
$insert_field[0]='id_inventario_consumibles'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_articulo';
$insert_field[2]='';
$insert_field[3]='cantidad'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[4]='fecha_adquisicion';
$insert_field[5]='costo';
$insert_field[6]='observacion';
$insert_field[7]='id_proveedor';
$insert_field[8]='';
$insert_field[9]='doc_factura';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[5];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[1];
$insert_alias[4]=$alias_col[2];
$insert_alias[5]=$alias_col[3];
$insert_alias[6]=$alias_col[4];
$insert_alias[7]=$alias_col[8];
$insert_alias[8]='';
$insert_alias[9]=$alias_col[10];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[6]; 
$name_input[2]=$alias_col[6]; 
$name_input[3]=$alias_col[1]; 
$name_input[4]=$alias_col[2]; 
$name_input[5]=$alias_col[3]; 
$name_input[6]=$alias_col[4]; 
$name_input[7]=$alias_col[9]; 
$name_input[8]=$alias_col[9]; 
$name_input[9]=$alias_col[10];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[7]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[7];
$label_input[3]=$columna[1];
$label_input[4]=$columna[2];
$label_input[5]=$columna[3];
$label_input[6]=$columna[4];
$label_input[7]=$columna[8];
$label_input[8]=$columna[8];
$label_input[9]='Documento de factura';

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='number';
$tipo_input[4]='input';
$tipo_input[5]='input';
$tipo_input[6]='textarea';
$tipo_input[7]='';
$tipo_input[8]='selectBD';
$tipo_input[9]='file_no_BD';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=2;
$fff=8;

$combo_sql[$f] = "SELECT n_articulo.id_articulo AS id_articulo, concat(articulo,' - Marca:',marca,' Modelo:', modelo) AS articulo FROM n_articulo, n_marca, n_modelo 
WHERE 1 AND activo_fijo='0' AND n_articulo.id_marca=n_marca.id_marca AND n_articulo.id_modelo=n_modelo.id_modelo ORDER BY articulo";

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

// valores que va a tomar el campo tipo <select> en cada <option>
$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='Rentero';
$dato_permit[4]='Rfecha';
$dato_permit[5]='Rfloat';
$dato_permit[6]='varchar';
$dato_permit[7]='';
$dato_permit[8]='Rselec';
$dato_permit[9]='varchar';

$texto_input[8]='<a href="#modal0"><img src="'.$x.'img/general/agregar.png";></a>';

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='1';
$value_input[4]=date('Y-m-d');
$value_input[5]='1';
$value_input[6]='';
$value_input[7]='';
$value_input[8]='';
$value_input[9]='';

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='ejecutar_ajax("'.$x.$camino.'/sel_atributos.php","cod_articulo","div_atributos")';
$onclic[3]='';
$onclic[4]='displayCalendar(document.frm.'.$name_input[4].',"yyyy-m-d",this)';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';
$onclic[9]='';

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='5';
$size[4]='10';
$size[5]='50';
$size[6]='100';
$size[7]='';
$size[8]='50';
$size[9]='50';

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
$n_label_ayuda[1]=array('texto'=>$columna[1],'exp'=>'Cantidad del art&iacute;culo');
$n_label_ayuda[2]=array('texto'=>$columna[2],'exp'=>'Fecha adquisici&oacute;n del art&iacute;culo');
$n_label_ayuda[3]=array('texto'=>$columna[3],'exp'=>'Costo del art&iacute;culo');
$n_label_ayuda[4]=array('texto'=>$columna[4],'exp'=>'Observaci&oacute;n');
$n_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'C&oacute;d. art&iacute;culo');
$n_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Art&iacute;culo');
$n_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Proveedor del art&iacute;culo');
$n_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Documento de factura');

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
$m_label_ayuda[1]=array('texto'=>$columna[1],'exp'=>'Cantidad del art&iacute;culo');
$m_label_ayuda[2]=array('texto'=>$columna[2],'exp'=>'Fecha adquisici&oacute;n del art&iacute;culo');
$m_label_ayuda[3]=array('texto'=>$columna[3],'exp'=>'Costo del art&iacute;culo');
$m_label_ayuda[4]=array('texto'=>$columna[4],'exp'=>'Observaci&oacute;n');
$m_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'C&oacute;d. art&iacute;culo');
$m_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Art&iacute;culo');
$m_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Proveedor del art&iacute;culo');
$m_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Documento de factura');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>