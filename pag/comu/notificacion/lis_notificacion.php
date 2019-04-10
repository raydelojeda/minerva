<?php 
include("variables.php");
include($x."plantillas/lis_header_nueva.php");
include($x."config/clases.php");
$obj_nuevo = new clases_nuevas();
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>

<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane(document.getElementById("tabPane1"));


</script>

&nbsp;
<br>
<?php 

$colspan=sizeof($campos)+3;
$rs_sesion->MoveFirst();							
$permiso=$obj->Validar_mostrar_btn($rs_sesion,$elemento,'Editar');
							
$dir=$camino;
$txt_filtro='';
$pag=1;
$ver=10;
$campo_orden='';
$asc_desc='';
$x_include_once=$x;

?>
<br>				

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Bandeja de entrada</h2>			
			
			<div style='display:table;width:100%;'>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:100%;text-align:left;padding-left: 1%;'>
						
						<?php						
						$cadenacheckboxp=$obj_nuevo->listado($db, $x_include_once, $x, $dir, $txt_filtro, $pag, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, '', '');// generacion de filas
						?>
					</div>					
				</div>
			</div>			
			
		</div>
		
		<?php
		include("variables_enviados.php");//
		$l_sql=$obj->Consulta_listar($field,$alias_col,$tabla,$tabla_anidada,$campo_anidado,$tabla_anidada2,$campo_anidado2,$where,$info_col,$operador,$select);//
		
		$colspan=sizeof($campos)+3;
		$obj = new clases();
		$rs_sesion=$obj->Validar_sesion($db,$x);
		$rs_sesion->MoveFirst();							
		$permiso=$obj->Validar_mostrar_btn($rs_sesion,$elemento,'Editar');
		
		$dir=$camino;
		$txt_filtro='';
		$pag=1;
		$ver=10;
		$campo_orden='';
		$asc_desc='';
		$x_include_once=$x;
		?>
		<div class="tab-page" id="tabPage2" >
			<h2 class="tab">Bandeja de enviados</h2>			
			
			<div style='display:table;width:100%;'>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:100%;text-align:left;padding-left: 1%;'>
						
						<?php
						$cadenacheckboxp=$obj_nuevo->listado($db, $x_include_once, $x, $dir, $txt_filtro, $pag, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, '', '_enviados');// generacion de filas
						?>
					</div>					
				</div>
			</div>			
			
		</div>
	</div>					
</div>
<script type="text/javascript">setupAllTabs();</script>


<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
						if(isset($_GET['mensaje']))
						$mensaje=$_GET['mensaje'];
						if(isset($return[0]))
						$mensaje=$return[0];
						$obj->Imprimir_mensaje($mensaje);
 include($x."plantillas/lis_footer_nueva.php");
?>