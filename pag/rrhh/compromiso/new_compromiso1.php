<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST[$inputs[0]['name_input']]))
{
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

 <!--Título-->
 <h1>Crear pestañas solamente con CSS</h1>
 <!--Contenedor-->
 <div id="container">
  <!--Pestaña 1 activa por defecto-->
  <input id="tab-1" type="radio" name="tab-group" checked="checked" />
  <label for="tab-1">Pestaña 1</label>
  <!--Pestaña 2 inactiva por defecto-->
  <input id="tab-2" type="radio" name="tab-group" />
  <label for="tab-2">Pestaña 2</label>
  <!--Pestaña 3 inactiva por defecto-->
  <input id="tab-3" type="radio" name="tab-group" />
  <label for="tab-3">Pestaña 3</label>
  <!--Contenido a mostrar/ocultar-->
  <div id="content">
   <!--Contenido de la Pestaña 1-->
   <div id="content-1">
    <p class="left"><img src="http://ximg.es/160x120" alt="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum sit reprehenderit iusto harum minima. Assumenda, accusamus, perspiciatis inventore tempora qui pariatur quisquam? Deleniti, placeat ea nostrum officiis obcaecati temporibus quod. Ullam, in, adipisci autem at fugit ab tempore enim ratione nesciunt alias corporis vitae quo quod nostrum itaque vero iure?</p>
    <p class="left last"><img src="http://ximg.es/160x120" alt="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore, id blanditiis deserunt in molestiae excepturi incidunt molestias dolor sunt dolore obcaecati non repellat mollitia error placeat est exercitationem sit voluptates iure autem saepe voluptas harum unde perferendis modi provident labore voluptatum. Repudiandae, aspernatur sit harum quod vero quos sequi voluptas!</p>
   </div>
   <!--Contenido de la Pestaña 2-->
   <div id="content-2">
    <p class="column-left"><img src="http://ximg.es/200x150" alt="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, est, nisi enim voluptates dicta quibusdam recusandae eveniet provident non at nostrum nesciunt laudantium omnis aliquam debitis magni expedita cumque tempore.</p>
    <p class="column-right"><img src="http://ximg.es/200x150" alt="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed, molestiae, officia repellendus quasi cumque dolor eius deserunt possimus aliquid neque nam assumenda veniam soluta enim commodi aperiam reprehenderit quia incidunt.</p>
   </div>
   <!--Contenido de la Pestaña 3-->
   <div id="content-3">
	<?php 
	$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
	if(isset($_GET['mensaje']))
	$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
$mensaje=$return[0];
	$obj->Imprimir_mensaje($mensaje);
	?>
   </div>
  </div>
 </div>




<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>