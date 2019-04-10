<?php
include_once($x."adodb519/adodb.inc.php");  //adodb library
include_once($x."coneccion/conn.php"); //conection
date_default_timezone_set ('America/Guayaquil');

class clases_nuevas
{
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function listado($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name)
	{
		?>	
			<div style='display:table-row;'><div style='display:table-cell;'>
			<input name="hdn_x_include<?php print $name;?>" id="hdn_x_include<?php print $name;?>" type="hidden" value="<?php print $x_include;?>"/>
			<input name="hdn_x<?php print $name;?>" id="hdn_x<?php print $name;?>" type="hidden" value="<?php print $xxx;?>"/>
			<input name="hdn_dir<?php print $name;?>" id="hdn_dir<?php print $name;?>" type="hidden" value="<?php print $dir;?>"/>
			<input name="hdn_txt_filtro<?php print $name;?>" id="hdn_txt_filtro<?php print $name;?>" type="hidden" value="<?php print $txt_filtro;?>"/>
			<input name="hdn_ver<?php print $name;?>" id="hdn_ver<?php print $name;?>" type="hidden" value="<?php print $ver;?>"/>
			<input name="hdn_campo_orden<?php print $name;?>" id="hdn_campo_orden<?php print $name;?>" type="hidden" value="<?php print $campo_orden;?>"/>
			<input name="hdn_asc_desc<?php print $name;?>" id="hdn_asc_desc<?php print $name;?>" type="hidden" value="1"/>
			<input name="hdn_l_sql<?php print $name;?>" id="hdn_l_sql<?php print $name;?>" type="hidden" value="<?php print $l_sql;?>"/>
			<input name="hdn_permiso<?php print $name;?>" id="hdn_permiso<?php print $name;?>" type="hidden" value="<?php print $permiso;?>"/>
			<input name="hdn_name<?php print $name;?>" id="hdn_name<?php print $name;?>" type="hidden" value="<?php print $name;?>"/>
			</div></div>
		<?php
		
		$this->filtro_nuevo($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name);
		print "<div style='display:table;' id='div_listado".$name."' class='tabla_listar'>";
		$this->paginador($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name);
		$this->encabezado_nuevo($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name);
		$cadenacheckboxp=$this->filas_nuevas($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name);
		
		return $cadenacheckboxp;
	}	
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function filtro_nuevo($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name)
	{
		$x=$x_include;//print $x_include.$dir;
		include($x_include.$dir."/variables.php");
		$colspan=sizeof($campos)+3;
		
		
		
		$rs=$db->Execute($l_sql) or die($db->ErrorMsg());
		$cant_total_filas=$rs->RecordCount();
		
		$cant_total_pagina=round(bcdiv($cant_total_filas, $ver, 5),0);
		
		
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
		?>
		<div class='tabla_filtro' style='display:table;' >
		<div style='display:table-row;'>
		<div style='display:table-cell;text-align:left;vertical-align: middle;' >&nbsp;
		
			Filtro:
			<input onkeyUp="str=document.frm.txt_filtro<?php print $name;?>.value;if(str.length>2 || str.length==0){document.frm.txt_pagina<?php print $name;?>.value=1;ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');}" name="txt_filtro<?php print $name;?>" type="text" value="<?php print $txt_filtro;?>" size="40"/>
		</div>
		</div>
		</div>
		<br>
		<?php
		
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function paginador($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name)
	{
		$rs=$db->Execute($l_sql) or die($db->ErrorMsg());//print $pagina;
		$cant_total_filas=$rs->RecordCount();//print $cant_total_filas;
		
		$x=$x_include;
		include($x_include.$dir."/variables.php");
		
		$colspan=sizeof($campos)+3;
		$cant_total_pagina=ceil(bcdiv($cant_total_filas, $ver, 5));	/*colspan='<?php print $colspan;?>'*/
?>
	<div style='display:table-row;' id='div_paginador'>
		<div style='display:table-cell;align:left;vertical-align:middle;' >
	
			
			
			<div style='display:table;width:100%'>	
				<div style='display:table-row;'>
					<div style='display:table-cell;text-align:right;padding-right:1%;vertical-align:middle;height:30px;' >
						
						<a onClick="if(parseInt(document.frm.txt_pagina<?php print $name;?>.value)!=1){document.frm.txt_pagina<?php print $name;?>.value=1;ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');}">
							<img height="7px" width="7px" border="0" src="<?php print $xxx;?>img/general/flecha_izq.png">
							<img height="7px" width="7px" border="0" src="<?php print $xxx;?>img/general/flecha_izq.png">
						</a>
						&nbsp;
						<a onClick="if(parseInt(document.frm.txt_pagina<?php print $name;?>.value)>1)document.frm.txt_pagina<?php print $name;?>.value=parseInt(document.frm.txt_pagina<?php print $name;?>.value)-parseInt(1);ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');">
							<img height="7px" width="7px" border="0" src="<?php print $xxx;?>img/general/flecha_izq.png">
						</a>
						&nbsp;
						<a onClick="if(parseInt(document.frm.txt_pagina<?php print $name;?>.value)<<?php print $cant_total_pagina;?>)document.frm.txt_pagina<?php print $name;?>.value=parseInt(document.frm.txt_pagina<?php print $name;?>.value)+parseInt(1);ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');">
							<img height="7px" width="7px" border="0" src="<?php print $xxx;?>img/general/flecha_der.png">
						</a>
						&nbsp;
						<a onClick="if(parseInt(document.frm.txt_pagina<?php print $name;?>.value)!=<?php print $cant_total_pagina;?>){document.frm.txt_pagina<?php print $name;?>.value=<?php print $cant_total_pagina;?>;ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');}">
							<img height="7px" width="7px" border="0" src="<?php print $xxx;?>img/general/flecha_der.png">
							<img height="7px" width="7px" border="0" src="<?php print $xxx;?>img/general/flecha_der.png">
						</a>
						&nbsp;
						<input onkeyUp="if(parseInt(document.frm.txt_pagina<?php print $name;?>.value)><?php print $cant_total_pagina;?>)document.frm.txt_pagina<?php print $name;?>.value=1; ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');" name="txt_pagina<?php print $name;?>" type="text" value="<?php print $pagina;?>" size="3"/>/<?php print $cant_total_pagina;?>
															
						Ver:
						<select name="sel_filas<?php print $name;?>" onChange="document.frm.txt_pagina<?php print $name;?>.value=1;ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');">
							<option value="3" <?php if($ver==3){?>selected="selected" <?php } ?>>3</option>
							<option value="10" <?php if($ver==10){?>selected="selected" <?php } ?>>10</option>
							<option value="15" <?php if($ver==15){?>selected="selected" <?php } ?>>15</option>
							<option value="20" <?php if($ver==20){?>selected="selected" <?php } ?>>20</option>
							<option value="25" <?php if($ver==25){?>selected="selected" <?php } ?>>25</option>
							<option value="30" <?php if($ver==30){?>selected="selected" <?php } ?>>30</option>
							<option value="50" <?php if($ver==50){?>selected="selected" <?php } ?>>50</option>
							<option value="100" <?php if($ver==100){?>selected="selected" <?php } ?>>100</option>
							<option value="500" <?php if($ver==500){?>selected="selected" <?php } ?>>500</option>
						</select> filas
					</div>								
				</div>
			</div>
			
			
			
		</div>
	</div>

<?php
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function encabezado_nuevo($db, $x_include, $xxx, $dir, $txt_filtro, $pagina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name)
	{
		$x=$x_include;
		include($x_include.$dir."/variables.php");
		?>
		
		<div style='display:table-row;width:100%'>
		<div style='display:table-cell;' >
		
		<?php
		// para poner el encabezado de columnas
		print "<div style='display:table;width:100%;'>";
		print "<div style='display:table-row;' class='encabezado_col' >";
		print "<div style='display:table-cell;width:2%;text-align:left;vertical-align:middle;'>No</div>"; //numero de fila
			for($colum=0;$colum<sizeof($campos);$colum++)
			{
			
				print "<div style='display:table-cell;text-align:left;width:".$campos[$colum]['ancho'].";vertical-align:middle;'>";
				
				if($campos[$colum]['info_col']!="calc" AND $campos[$colum]['info_col']!="input" AND $campos[$colum]['info_col']!="img_doc" AND $campos[$colum]['info_col']!="file_no_BD")
				{	
				?>
					<a onclick="if(document.frm.hdn_campo_orden<?php print $name;?>.value!='<?php print $campos[$colum]['field_col'];?>'){document.frm.hdn_asc_desc<?php print $name;?>.value=1;document.frm.hdn_campo_orden<?php print $name;?>.value='<?php print $campos[$colum]['field_col'];?>';}else {if(document.frm.hdn_asc_desc<?php print $name;?>.value==1)document.frm.hdn_asc_desc<?php print $name;?>.value=0; else document.frm.hdn_asc_desc<?php print $name;?>.value=1;}ejecutar_ajax('<?php print $xxx;?>config/filtrar_listado.php','hdn_x<?php print $name;?>,hdn_dir<?php print $name;?>,txt_filtro<?php print $name;?>,txt_pagina<?php print $name;?>,sel_filas<?php print $name;?>,hdn_campo_orden<?php print $name;?>,hdn_asc_desc<?php print $name;?>,hdn_l_sql<?php print $name;?>,hdn_permiso<?php print $name;?>,hdn_name<?php print $name;?>','div_listado<?php print $name;?>');">
				<?php
				}	
					
				print $campos[$colum]['columna']."&nbsp;";
					
				// para la flecha del ordenar
				if($campos[$colum]['field_col']==$campo_orden AND $campos[$colum]['info_col']!="input")
				{												
					if($asc_desc==1)
						print "<img height='7px' width='7px' border='0' src='".$xxx."img/general/flecha_abajo.png'/>";
					else 
						print "<img height='7px' width='7px' border='0' src='".$xxx."img/general/flecha_arriba.png'/>";												
				}
				// para la flecha del ordenar										
				
				if($campos[$colum]['info_col']!="calc" AND $campos[$colum]['info_col']!="input" AND $campos[$colum]['info_col']!="img_doc" AND $campos[$colum]['info_col']!="file_no_BD")
				{	
					print "</a>";
				}
				print "</div>";
			}
		
			print "<div style='display:table-cell;width:1%;text-align:left;vertical-align:middle;'  >&nbsp;</div>"; //casilla para visualizar 
			print "<div style='display:table-cell;width:2%;text-align:left;vertical-align:middle;'  ><input name='checkbox' onclick='marcar();' type='checkbox'/></div>"; //casilla para marcar a todos
		
		print "</div>";
		// para poner el encabezado de columnas
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filas_nuevas($db, $x_include, $xxx, $dir, $txt_filtro, $paginaina, $ver, $campo_orden, $asc_desc, $l_sql, $permiso, $obj2, $name)
	{
	
	
		$x=$x_include;
		include($x_include.$dir."/variables.php");//print $id_cadenacheckboxp;
		$rs=$db->Execute($l_sql) or die($db->ErrorMsg());
		$colspan=sizeof($campos)+3;
		$x=$xxx;

		$aux_camp_g=1;
		$camp_g=0;
		$cadena_existe=0;
		$suma_columna=array();
		
		/*for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
		{
			$suma_columna[$cmp]=0;
		}*/
		
		$aux_ini=bcmul($ver,$paginaina,0)-$ver;
		$aux_fin=bcmul($ver,$paginaina,0);
		$no_fila=bcmul($ver,$paginaina,0)-$ver+1;
		
		//----ESTO ES PARA LA ULTIMA paginaINA
		if(bcadd($aux_ini,$ver,0)>$rs->RecordCount())
		$aux_fin=$rs->RecordCount();
		//----ESTO ES PARA LA ULTIMA paginaINA
		
		$rs->MoveFirst();
		
		for($f=0;$f<$aux_ini;$f++)
		{
			$rs->MoveNext();
		}
		
		//para crear las filas		
		for($fila=$aux_ini;$fila<$aux_fin;$fila++)
		{		
			// para llenar informacion emergente
			for($over=0;$over<sizeof($info_emerg);$over++) 
			{	
				if($info_emerg[$over] AND $info_col[$over]!="calc" AND $info_col[$over]!="input" AND $info_col[$over]!="img_doc" AND $info_col[$over]!="file_no_BD")//verifica si está activada la info emergente
				{
					if($info_emerg[$over]==2)//verifica si es 2 ya que en este caso es un selec estático y hay que mostrar los valores estáticos definidos en $opt_name
					{
						for($opt=0;$opt<=1;$opt++) // no interesa mostrar el primer elemento que corresponde al id de la tabla
						{//print "<br>size: ".count($opt_value,1)."over: ".$over."   opt: ".$opt."  value: ".$opt_value[$over][$opt]."   field: ".$rs->fields[$alias_col[$over]];
							if($opt_value[$over][$opt]==$rs->fields[$alias_col[$over]])
							{$alias=$opt_name[$over][$opt];$opt=count($opt_value,1)-2;}
							else
							$alias=$rs->fields[$alias_col[$over]];
						}
					}	
					else
					{
						$alias=$rs->fields[$alias_col[$over]];
					}	
						$l_info_emergente.="<b>".$columna[$over].":</b> ".$alias."<br>";					
				}
			}
			$l_info_emergente=str_replace('"','',$l_info_emergente);
			$l_info_emergente=str_replace("'",'',$l_info_emergente);
			$l_info_emergente=str_replace("\n",'',$l_info_emergente);
			// para llenar informacion emergente
			
			
			// para agrupar filas
			for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
			{
				$colspan=$info_col[$cmp]+1;
				$colspan1=$colspan - 1;
				
				if($info_col[$cmp]!=1 AND $info_col[$cmp]!=2 AND $info_col[$cmp]!="file_no_BD" AND $info_col[$cmp]!="img_doc" AND $info_col[$cmp]!="img_chec" AND $info_col[$cmp]!="calc" AND $info_col[$cmp]!="input" AND $info_col[$cmp]!="img_doc" AND $info_col[$cmp]!='')
				{
					$camp_g=$rs->fields[$field_col[$cmp]];					
					$camp_g="<b>".$columna[$cmp].":</b> ".$camp_g;
					
					//print "<div style='display:table;width:100%'>";
					
					if($aux_camp_g!=$camp_g)
					{
						if($fila!=0)
						//print "</table></div></div>";<tr><td colspan='".$colspan1."'><table>
						
						
						print "<div style='display:table-row;width:100%;'>";
							
							
								//print "<div style='display:table-cell;>".$ancho[$div]."</div>";
							//print '<div style="border: 1px solid black; position: absolute; width: 100%;">appears like colspan=2</div>';
							//print '<div>&nbsp; </div>';
							
							print "<div style='position:absolute;z-index:100;width:96%;line-height:35px;vertical-align:middle;'>&nbsp;";//colspan='".$colspan."' 
							 
							//print "<a href='#' onclick='javascript:ocultar_filas(".$rs->fields[$field_col[0]].");'";
							print $camp_g;if($id_cadenacheckboxp!=''){print "<input name='checkbox_".$rs->fields[$id_cadenacheckboxp]."' type='checkbox' value='checkbox'>";}else print '&nbsp;';
							//print "</a>";
							
							print "</div>";
							$aux_camp_g=$camp_g;
							/*for($div=1;$div<$colspan;$div++) 
							{
								print "<div style='block;' class='row_grupo'>";//print 'www'.$id_cadenacheckboxp;
											print '&nbsp;';
								print "</div>";
							}*/
							print "<div style='line-height:40px;' >";//print 'www'.$id_cadenacheckboxp;
										
							print "</div>";
						print "</div><br><br>";//tr
						
						
						//if($fila<$rs->RecordCount()-1)
						//print "<tr><td colspan='".$colspan."'><table width='100%' cellpadding='0' id='".$rs->fields[$field_col[0]]."' style='display:block;'>";
						
						if($id_cadenacheckboxp!='')
						{
							if($cadenacheckboxp == ""){$cadenacheckboxp = $rs->fields[$id_cadenacheckboxp];}
							else{$cadenacheckboxp .= ",".$rs->fields[$id_cadenacheckboxp];}
							$cadena_existe=1;
						}
						//print "  ppio11  ".$cadenacheckboxp." end <br>";
					}
					
					//print "</div>";//tabla
					
				}
			}
			// para agrupar filas
			
			
			
			print "<div style='display:table-row;' ";if($no_fila % 2) print "class='row1'";else print "class='row0'";print " >";
			print "<div style='display:table-cell;width:2%;' align='center'>".$no_fila."</div>"; //numero de fila
			
			for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
			{
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]==1 OR $info_col[$cmp]==2)
				{
					print "<div style='display:table-cell;width:".$ancho[$cmp].";text-align:left;'>";
					print "<a class='hlink'";
					
					if($permiso=="ok" AND $href_m)
					{	
						if($var_mod)
						print "href=".$href_m.$rs->fields[$var_mod]; // en caso de que el Editar no sea del propio elemento
						else
						print "href=".$href_m.$rs->fields[$alias_col[0]];
					}
					print ">";
					
					if($info_col[$cmp]==2)//verifica si es 2 ya que en este caso es un selec estático y hay que mostrar los valores estáticos definidos en $opt_name
					{	
						for($co=0;$co<=1;$co++) // no interesa mostrar el primer elemento que corresponde al id de la tabla
						{//print "<br>size: ".count($opt_value,1)."cmp: ".$cmp."   co: ".$co."  value: ".$opt_value[$cmp][$co]."   field: ".$rs->fields[$alias_col[$cmp]];
						
							if($opt_value[$cmp][$co]==$rs->fields[$alias_col[$cmp]])
							{$camp=$opt_name[$cmp][$co];$co=count($opt_value,1)-2;}
							else
							$camp=$rs->fields[$alias_col[$cmp]];
						}
					}
					else
					$camp=$rs->fields[$field_col[$cmp]];						
					print $camp;
					
					for($sum=0;$sum<sizeof($columna_suma);$sum++) 
					{
						if($cmp==$columna_suma[$sum] AND is_numeric($camp))
						{
							$suma_columna[$cmp]=$suma_columna[$cmp]+$camp;
						}
					}
					
					
						print "</a>";
					
					print "</div>";
				}
				
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="img_doc")
				{
					print "<div style='display:table-cell;width:".$ancho[$cmp].";text-align:left;'>";
					if(isset($rs->fields[$field_col[$cmp]]))
					//print $field_col[$cmp];
					$camp=$rs->fields[$field_col[$cmp]];
					if(base64_encode($camp))
					$img="<img style=\'border-radius:8px;\' width=150px src=\'data:image/jpeg;base64,". base64_encode($camp). "\'/>";
					else
					$img="<img style=\'border-radius:8px;\' width=150px src=\'".$xxx."img/general/no_doc_big.png\'/>";
					
					print "<a class='hlink'";
					print "onmouseover=\"return overlib('".$img."', '', LEFT)\" onmouseout='return nd();'";
					
					//$rs_sesion->MoveFirst();							
					//$permiso=$obj->Validar_mostrar_btn($rs_sesion,$elemento,'Editar');
					
					//if($permiso=="ok" AND $href_m)
					print 'href="data:image/jpeg;base64,'. base64_encode($camp).'"';

					print ">";
									
					if(base64_encode($camp))
					echo '<img width="10px" height="10px" src="data:image/jpeg;base64,'. base64_encode($camp). '"/>';
					else
					echo '<img width="10px" height="10px" src="'.$xxx.'img/general/no_doc.png"/>';
					//print $camp;
				
					print "</a>";
						
					print "</div>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
			
						
			
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="file_no_BD")
				{
					print "<div style='display:table-cell;width:".$ancho[$cmp].";text-align:left;'>";
					if($imp!='imp' AND $imp!='exp')
					{
						if(isset($rs->fields[$field_col[$cmp]]))
						{
							if($rs->fields[$field_col[$cmp]]!='')
							{
								$img="<img src='".$xxx."img/general/adjuntar.png'/>";
								print "<a href='".$xxx."archivos/".$rs->fields[$field_col[$cmp]]."'  download='".$rs->fields[$field_col[$cmp]]."'>".$img."</a>";
							}
						}
					}
					print "</div>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="img_chec")
				{
					print "<div style='display:table-cell;width:".$ancho[$cmp].";text-align:left;'>";
					if($imp!='imp' AND $imp!='exp')
					{
						$camp=$rs->fields[$field_col[$cmp]];
						
						if($camp==1)
						echo '<img width="10px" height="10px" src="'.$xxx.'img/general/si.png"/>';
						else
						echo '<img width="10px" height="10px" src="'.$xxx.'img/general/no.png"/>';
						//print $camp;
					}
						
					if($imp!='imp' and $imp!='exp')
					print "</a>";
						
					print "</div>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="calc")
				{
					print "<div style='display:table-cell;width:".$ancho[$cmp].";text-align:left;'>";
					eval("\$str = $field_col[$cmp];");
					print $str;	
					print "</div>";
					
					for($sum=0;$sum<sizeof($columna_suma);$sum++) 
					{
						if($cmp==$columna_suma[$sum] AND is_numeric($str))
						{
							$suma_columna[$cmp]=$suma_columna[$cmp]+$str;
						}
					}
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="input")
				{					
					print "<div style='display:table-cell;width:".$ancho[$cmp].";text-align:center;' >";
					
					if($var_mod)
					print "<select name='".$opt_name[$cmp][0].$rs->fields[$var_mod]."' id='".$opt_name[$cmp][0].$rs->fields[$var_mod]."'>";
					else
					print "<select name='".$opt_name[$cmp][0].$rs->fields[$alias_col[0]]."' id='".$opt_name[$cmp][0].$rs->fields[$alias_col[0]]."'>";
					
					print "<option value=0 selected>----------------------------</option>";
					//print $combo_sql[$cmp];
					$combo_rs=$db->Execute($combo_sql[$cmp]) or die($db->ErrorMsg());					
					//print "cant: ".$combo_rs->RecordCount().$combo_rs;
					//print $s_rs;
					for($opt_rs=0;$opt_rs<$combo_rs->RecordCount();$opt_rs++) 
					{	
						$value=$combo_rs->fields[$opt_value[$cmp][0]]; // tiene el id
						$sel_campo=$combo_rs->fields[$opt_sel[$cmp][0]]; // tiene el id
						$name=$combo_rs->fields[$opt_name[$cmp][0]]; // tiene lo que muestra al usuario			
							
						print "<option value=".$value;
						print ">".$name."</option>";
						
					$combo_rs->MoveNext();					
					}	
					print "</select>";
					print "</div>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				
			}
			
			
				print "<div style='display:table-cell;width:1%;text-align:center;'>";
				if($href_m!='')
				{
					print "<a class='hlink'";
					print "onmouseover=\"return overlib('".$l_info_emergente."', ABOVE, LEFT)\" onmouseout='return nd();'";
				
					if($var_mod)
						print "href=".$href_m.$rs->fields[$var_mod].'&visualizar=1'; // en caso de que el Editar no sea del propio elemento
					else
						print "href=".$href_m.$rs->fields[$alias_col[0]].'&visualizar=1';
				
				print ">";
				echo '<img width="14px" height="14px" src="'.$xxx.'img/general/ver.png"/>';//print $href_m;
				print "</a>";
				}
				else
				{
					print "<a class='hlink'";
					print "onmouseover=\"return overlib('".$l_info_emergente."', ABOVE, LEFT)\" onmouseout='return nd();'";				
					print ">";
					echo '<img width="14px" height="14px" src="'.$xxx.'img/general/ver.png"/>';//print $href_m;
					print "</a>";
				}
								
				print "</div>"; //casilla para marcar a todos
				
				print "<div style='display:table-cell;width:1%;' >";
				
				if($id_cadenacheckboxp=='')
				{
					if($var_mod)
					print "<input name='checkbox_".$rs->fields[$var_mod]."' type='checkbox' value='checkbox'>";// en caso de que el Editar no sea del propio elemento
					else
					print "<input name='checkbox_".$rs->fields[$alias_col[0]]."' type='checkbox' value='checkbox'>";
				}
				else
				print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				print "</div>";
			
			print "</div>";
			
			// $cadenacheckboxp contiene los id del elemento
			
			if($cadena_existe==0)
			{
				if($var_mod!='')
				{
					if($cadenacheckboxp == ""){$cadenacheckboxp = $rs->fields[$var_mod];}
					else{$cadenacheckboxp .= ",".$rs->fields[$var_mod];}
				}
				else
				{
					if($cadenacheckboxp == ""){$cadenacheckboxp = $rs->fields[$alias_col[0]];}
					else{$cadenacheckboxp .= ",".$rs->fields[$alias_col[0]];}
				}
			}
			//print "  ppio  ".$cadenacheckboxp." end <br>";
			// $cadenacheckboxp contiene los id del elemento
			
			$no_fila=$no_fila+1;
			$l_info_emergente="";
			
		$rs->MoveNext();		
		}

		/*print "<div style='display:table-row;'><div style='display:table-cell;' align='center' colspan='".sizeof($field_col)."'><b>";		
		for($sum=0;$sum<sizeof($columna_suma);$sum++)
		{
			if($columna_suma[$sum]!='')print $columna[$columna_suma[$sum]].': '.number_format(round($suma_columna[$columna_suma[$sum]],2), 2, ".", "").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}*/
		?>
		<input type="hidden" name="var_checkbox" value="<?php echo $cadenacheckboxp;?>">
		<input type="hidden" name="var_aux" value="">
		<input type="hidden" name="aux_submit" value="">
		<input type="hidden" name="camino" value="<?php echo $camino;?>">
		<input type="hidden" name="l_sql" value="<?php echo $l_sql;?>">
		<?php		
		//print "</b></div></div>";
		
		print "</div> </div></div></div>";
		
		
		
		// para agrupar filas
		return $cadenacheckboxp;
		// para crear las filas 

	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
}	