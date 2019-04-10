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
$msg_ven='-Si los Datos en factura se encuentran con un error Ud. puede modificarlos antes de realizar la venta.<br><br>-Si el cliente es nuevo Ud. puede ingresar sus credenciales en los Datos en factura para realizar la venta y dejar guardados sus datos.<br><br>-En caso de ser cliente nuevo debe recibir como forma de pago lo que indica el sistema.';
// declaraciones


$elemento_titulo="de ventas"; // para el título
$elemento="venta"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las ventas registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="venta";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='cliente';
$tabla_anidada[1]='producto_precio';
$tabla_anidada[2]='n_factura';
$tabla_anidada[3]='n_forma_pago';

$tabla_anidada2[0]='persona';
$tabla_anidada2[1]='n_producto';
$tabla_anidada2[2]='n_punto_venta';

$campo_anidado=array();
$campo_anidado[0]='id_cliente';
$campo_anidado[1]='id_producto_precio';
$campo_anidado[2]='id_factura';
$campo_anidado[3]='id_forma_pago';

$campo_anidado2[0]='id_persona';
$campo_anidado2[1]='id_producto';
$campo_anidado2[2]='id_punto_venta';

$where=' AND persona.id_persona=cliente.id_persona AND producto_precio.id_producto=n_producto.id_producto AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta';

if (isset($_POST["txt_factura_ini"]))$_SESSION['txt_factura_ini'] = $_POST['txt_factura_ini'];if(isset($_SESSION['txt_factura_ini']))$txt_factura_ini = $_SESSION['txt_factura_ini'];//print $txt_factura_ini;
if (isset($_POST["txt_factura_fin"]))$_SESSION['txt_factura_fin'] = $_POST['txt_factura_fin'];if(isset($_SESSION['txt_factura_fin']))$txt_factura_fin = $_SESSION['txt_factura_fin'];//print $txt_factura_fin;//die();

if(!isset($txt_factura_ini))$txt_factura_ini = '';
if(!isset($txt_factura_fin))$txt_factura_fin = '';

if (isset($_POST["txt_fecha_ini"]))$_SESSION['txt_fecha_ini'] = $_POST['txt_fecha_ini'];if(isset($_SESSION['txt_fecha_ini']))$txt_fecha_ini = $_SESSION['txt_fecha_ini'];//print $txt_fecha_ini;
if (isset($_POST["txt_fecha_fin"]))$_SESSION['txt_fecha_fin'] = $_POST['txt_fecha_fin'];if(isset($_SESSION['txt_fecha_fin']))$txt_fecha_fin = $_SESSION['txt_fecha_fin'];//print $txt_fecha_fin;//die();

date_default_timezone_set("America/Guayaquil");
$hoy=date("Y-m-d");

if(!isset($txt_fecha_ini))$txt_fecha_ini=$hoy;
if(!isset($txt_fecha_fin))$txt_fecha_fin=$hoy;

$fecha_ini=$txt_fecha_ini." 00:00:00";
$fecha_fin=$txt_fecha_fin." 23:59:59";

if($fecha_ini)
$where .= " and venta.fecha_venta>='".$fecha_ini."'";
if($fecha_fin)
$where .= " and venta.fecha_venta<='".$fecha_fin."'";

if(isset($txt_factura_ini) AND $txt_factura_ini!='')
$where .= " and venta.no_factura>='".$txt_factura_ini."'";
if(isset($txt_factura_fin) AND $txt_factura_fin!='')
$where .= " and venta.no_factura<='".$txt_factura_fin."'";

$order=" id_pun, fac DESC";
$ver=1000;

$field[0]='id_venta'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='identificacion';
$field[2]="concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre)";//,' No factura: ',no_factura)";
$field[3]="concat(factura_apellidos,' ',factura_nombres,' - ',factura_cedula,' - ',factura_direccion,' - ',factura_telefono)";
$field[4]=$tabla.'.id_producto_precio';
$field[5]="concat(cod_producto,' - ',producto)";
$field[6]=$tabla.'.id_factura';
$field[7]='no_factura';
$field[8]='';
$field[9]='';
$field[10]='';
$field[11]='fecha_venta';
$field[12]="no_autorizo";
$field[13]=$tabla_anidada[1].'.id_punto_venta';
$field[14]="concat(punto_venta,' - ',descripcion)";
$field[15]=$tabla.'.id_forma_pago';
$field[16]="forma_pago";
$field[17]='anulada';
$field[18]='precio';
$field[19]='cantidad';

$alias_col=array();
$alias_col[0]='id_venta';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='identificacion';
$alias_col[2]='per';
$alias_col[3]='d_fac';
$alias_col[4]='id_p';
$alias_col[5]='pro';
$alias_col[6]='id_f';
$alias_col[7]='fac';
$alias_col[8]='$obj2->calculo_subtotal_x($db,$rs->fields["pre"],$rs->fields["can"],$rs->fields["anu"])[1];';
$alias_col[9]='$obj2->calculo_subtotal_x($db,$rs->fields["pre"],$rs->fields["can"],$rs->fields["anu"])[2];';
$alias_col[10]='$obj2->calculo_subtotal_x($db,$rs->fields["pre"],$rs->fields["can"],$rs->fields["anu"])[3];';
$alias_col[11]='fec';
$alias_col[12]='aut';
$alias_col[13]='id_pun';
$alias_col[14]='pun';
$alias_col[15]='id_for';
$alias_col[16]='forma';
$alias_col[17]='anu';
$alias_col[18]='pre';
$alias_col[19]='can';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Indentificaci&oacute;n';
$columna[2]='Persona';
$columna[3]='Datos de factura';
$columna[4]='Producto';
$columna[5]='Producto';
$columna[6]='No autorizo';
$columna[7]='No factura';
$columna[8]='Precio';
$columna[9]='Cantidad';
$columna[10]='Subtotal';
$columna[11]='Fecha de venta';
$columna[12]='No autorizo';
$columna[13]='Punto de venta';
$columna[14]='Punto de venta';
$columna[15]='Forma pago';
$columna[16]='Forma pago';
$columna[17]='A';
$columna[18]='Precio';
$columna[19]='Cantidad';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]='';
$info_emerg[5]=1;
$info_emerg[6]='';
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]=1;
$info_emerg[11]=1;
$info_emerg[12]=1;
$info_emerg[13]='';
$info_emerg[14]=1;
$info_emerg[15]='';
$info_emerg[16]=1;
$info_emerg[17]=2;
$info_emerg[18]='';
$info_emerg[19]='';

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]='1';
$info_col[3]='';
$info_col[4]='';
$info_col[5]=1;
$info_col[6]='';
$info_col[7]=1;
$info_col[8]='calc';
$info_col[9]='calc';
$info_col[10]='calc';
$info_col[11]=1;
$info_col[12]='';
$info_col[13]='';
$info_col[14]=11;
$info_col[15]='';
$info_col[16]=1;
$info_col[17]=2;
$info_col[18]='';
$info_col[19]='';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='8%';
$ancho[2]='25%';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='28%';
$ancho[6]='';
$ancho[7]='6%';
$ancho[8]='4%';
$ancho[9]='3%';
$ancho[10]='4%';
$ancho[11]='12%';
$ancho[12]='';
$ancho[13]='';
$ancho[14]='';
$ancho[15]='';
$ancho[16]='7%';
$ancho[17]='1%';
$ancho[18]='';
$ancho[19]='';

$var_mod='';
$columna_suma[0]=10;
$href_m='mod_'.$elemento.'.php?mod='; // camino de la pagina para Editar
$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Venta','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Anular','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[3]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona que realiza la compra');
$l_label_ayuda[1]=array('texto'=>$columna[5],'exp'=>'Producto a vender');
$l_label_ayuda[2]=array('texto'=>$columna[7],'exp'=>'No de autorizo del SRI');
$l_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Cantidad a vender');
$l_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Precio');
$l_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Fecha de venta');
$l_label_ayuda[6]=array('texto'=>$columna[11],'exp'=>'Anulada: Si o No');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Venta','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'new_pension.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Pensi&oacute;n','accion'=>'Insertar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'anular_'.$elemento.'.php\')','src'=>$x.'img/cont/venta/anular.png','nombre'=>'editar','texto'=>'Anular','accion'=>'Editar');
$l_botones[3]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'habilitar_'.$elemento.'.php\')','src'=>$x.'img/cont/venta/habilitar.png','nombre'=>'editar','texto'=>'Habilitar','accion'=>'Editar');
$l_botones[4]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[5]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[6]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[7]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[8]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_venta'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='cantidad'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='fecha_venta';
$insert_field[3]='no_factura';
$insert_field[4]='anulada';
$insert_field[5]='id_forma_pago';
$insert_field[6]='';
$insert_field[7]='id_cliente';
$insert_field[8]='';
$insert_field[9]='id_producto_precio';
$insert_field[10]='';
$insert_field[11]='id_factura';
$insert_field[12]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]='cant';
$insert_alias[2]='fec';
$insert_alias[3]='nof';
$insert_alias[4]='anu';
$insert_alias[5]='id_for';
$insert_alias[6]='';
$insert_alias[7]='id_cliente';
$insert_alias[8]='';
$insert_alias[9]='id_p';
$insert_alias[10]='';
$insert_alias[11]='id_fac';
$insert_alias[12]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]='cant';
$name_input[2]='fec';
$name_input[3]='nof';
$name_input[4]='anu';
$name_input[5]='forma';
$name_input[6]='forma';
$name_input[7]='clien';
$name_input[8]='clien';
$name_input[9]='prod';
$name_input[10]='prod';
$name_input[11]='fac';
$name_input[12]='fac';

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[8]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[11];
$label_input[3]=$columna[7];
$label_input[4]='Anulada';
$label_input[5]=$columna[16];
$label_input[6]=$columna[16];
$label_input[7]=$columna[2];
$label_input[8]=$columna[2];
$label_input[9]=$columna[5];
$label_input[10]=$columna[5];
$label_input[11]=$columna[7];
$label_input[12]=$columna[7];

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
$field_unico[10]='';
$field_unico[11]='';
$field_unico[12]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='texto_input';
$tipo_input[2]='input';
$tipo_input[3]='input';
$tipo_input[4]='select';
$tipo_input[5]='';
$tipo_input[6]='selectBD';
$tipo_input[7]='';
$tipo_input[8]='texto_select';
$tipo_input[9]='';
$tipo_input[10]='texto_select';
$tipo_input[11]='';
$tipo_input[12]='texto_select';

// valores que va a tomar el campo tipo <select> en cada <option>
$j=17;
$f=6;
$t=8;
$m=10;
$n=12;
$k=4;
$combo_sql[$f] = "select id_forma_pago as id_for, forma_pago as forma from n_forma_pago WHERE para_venta='1' ORDER BY forma";

$opt_name=array();
$opt_name[$f][0]='forma';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value=array();
$opt_value[$f][0]='id_for';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';

$opt_sel=array();
$opt_sel[$f][0]='id_for';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$t] = "select cliente.id_cliente as id_cliente, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as cliente from cliente, persona WHERE cliente.id_persona=persona.id_persona";

$opt_name[$t][0]='cliente';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$t][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$t][0]='id_cliente';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$t][1]='';

$opt_sel[$t][0]='id_cliente';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$t][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$j] = "";

$opt_name[$j][0]='<img width=10px src='.$x.'img/general/no.png>';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$j][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$j][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$j][1]='0';


$opt_sel[$j][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$j][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$k] = "";

$opt_name[$k][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$k][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$k][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$k][1]='0';

$opt_sel[$k][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$k][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$m] = "select id_producto_precio as id_p, concat(cod_producto,' - ',producto) as prod from producto_precio,n_producto WHERE producto_precio.id_producto=n_producto.id_producto";

$opt_name[$m][0]='prod';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$m][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$m][0]='id_p';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$m][1]='';

$opt_sel[$m][0]='id_p';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$m][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$n] = "select id_factura as id_fac, concat(punto_venta,' - ',descripcion) as fac from n_factura,n_punto_venta WHERE n_factura.id_punto_venta=n_punto_venta.id_punto_venta AND estado='1'";

$opt_name[$n][0]='fac';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_value[$n][0]='id_fac';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$n][0]='id_fac';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='';
$dato_permit[3]='';
$dato_permit[4]='';
$dato_permit[5]='';
$dato_permit[6]='';
$dato_permit[7]='';
$dato_permit[8]='';
$dato_permit[9]='';
$dato_permit[10]='';
$dato_permit[11]='';
$dato_permit[12]='';

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

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='50';
$size[6]='50';
$size[7]='50';
$size[8]='50';
$size[9]='50';
$size[10]='50';
$size[11]='50';
$size[12]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"submit('venta.php');",'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No de autorizo del SRI');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Inicio del facturero');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Fin del facturero');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha de emisi&oacute;n del facturero');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Fecha de vencimiento del facturero');
$n_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Activo: Si o No');
$n_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Punto de venta');

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
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No de autorizo del SRI');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Inicio del facturero');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Fin del facturero');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha de emisi&oacute;n del facturero');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Fecha de vencimiento del facturero');
$m_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Activo: Si o No');
$m_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Punto de venta');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>