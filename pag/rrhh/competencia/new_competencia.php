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
<?php
/*
 <body>
 <!--Título-->
 <h1>Crear pesta&ntilde;as solamente con CSS</h1>
 <!--Contenedor-->
 <div id="container">
  <!--Pesta&ntilde;a 1 activa por defecto-->
  <input id="tab-1" type="radio" name="tab-group" checked="checked" />
  <label for="tab-1">Pesta&ntilde;a 1</label>
  <!--Pesta&ntilde;a 2 inactiva por defecto-->
  <input id="tab-2" type="radio" name="tab-group" />
  <label for="tab-2">Pesta&ntilde;a 2</label>
  <!--Pesta&ntilde;a 3 inactiva por defecto-->
  <input id="tab-3" type="radio" name="tab-group" />
  <label for="tab-3">Pesta&ntilde;a 3</label>
  <!--Contenido a mostrar/ocultar-->
  <div id="content">
   <!--Contenido de la Pesta&ntilde;a 1-->
   <div id="content-1">
    <p class="left"><img src="http://ximg.es/160x120" alt="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum sit reprehenderit iusto harum minima. Assumenda, accusamus, perspiciatis inventore tempora qui pariatur quisquam? Deleniti, placeat ea nostrum officiis obcaecati temporibus quod. Ullam, in, adipisci autem at fugit ab tempore enim ratione nesciunt alias corporis vitae quo quod nostrum itaque vero iure?</p>
    <p class="left last"><img src="http://ximg.es/160x120" alt="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore, id blanditiis deserunt in molestiae excepturi incidunt molestias dolor sunt dolore obcaecati non repellat mollitia error placeat est exercitationem sit voluptates iure autem saepe voluptas harum unde perferendis modi provident labore voluptatum. Repudiandae, aspernatur sit harum quod vero quos sequi voluptas!</p>
   </div>
   <!--Contenido de la Pesta&ntilde;a 2-->
   <div id="content-2">
    <?php
	//include("../criterio/variables.php");
	$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
	
	?>
   </div>
   <!--Contenido de la Pesta&ntilde;a 3-->
	<div id="content-3">
    
	<?php
	include("../criterio/variables.php");
	$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
	
	?>

	</div>
  </div>
 </div>
</body>
*/?>
<script type="text/javascript">
function show(bloq) {
  obj = document.getElementById(bloq);
  obj.style.display = (obj.style.display=='none') ? 'block' : 'none';
}
</script>
<a onclick="show('layer')">Mostrar div</a>

<div id="layer1" style="display:none;">


<table id="layer"border='1' width='90%'>
<tr>
<td>
1
</td>
<td>
2
</td>
<td>
3
</td>
<td>
4
</td>
</tr>

<tr>
<td>
1
</td>
<td>
2
</td>
<td>
3
</td>
<td>
4
</td>
</tr>

<tr>
<td>
1
</td>
<td>
2
</td>
<td>
3
</td>
<td>
4
</td>
</tr>

<tr>
<td>
1
</td>
<td>
2
</td>
<td>
3
</td>
<td>
4
</td>
</tr>
</table>

</div>
<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>