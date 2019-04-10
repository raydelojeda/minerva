<?php
include_once($x."adodb519/adodb.inc.php");  //adodb library
include_once($x."coneccion/conn.php"); //conection
date_default_timezone_set ('America/Guayaquil');

class clases
{
	function Filtro($sel_filtro2,$txt_filtro2,$sel_filtro,$txt_filtro,$filtros,$sig_ant,$cant_pag,$ver,$colspan)
	{
		echo "<tr><td colspan='".$colspan."'>";
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
		print "<table class='tabla_filtro'><tr>";
		print "<td width='35%' align='right'>&nbsp;";
		//filtro extra								
		if($sel_filtro2=="cl")$txt_filtro2="";
		?>
		
			Filtro:
			<input <?php if($sel_filtro2!="" and $sel_filtro2!="cl" and $sel_filtro2!="no"){?> onkeypress="pulsar(event);" onblur="document.frm.submit();" <?php }?> name="txt_filtro2" type="text" value="<?php echo $txt_filtro2 ?>" size="10"/>
			<select onchange="document.frm.submit();" name="sel_filtro2">
			
			<?php if($sel_filtro2!="" and $sel_filtro2!="cl" and $sel_filtro2!="no"){?>
			<option value="<?php echo "cl" ?>">--Limpiar--</option>
			<?php } else{?>
			<option value="<?php echo "no" ?>">--Seleccionar--</option>
			<?php }
			
			
			// para llenar el combo del filtro
			for($colum=0;$colum<sizeof($filtros);$colum++) 
			{
			?>
				<option value="<?php echo $filtros[$colum]['field'];?>"<?php if($sel_filtro2==$filtros[$colum]['field']){ echo "selected";}?>>
					<?php echo $filtros[$colum]['columna'];?>
				</option>
			<?php 
			}
			// para llenar el combo del filtro
			?>
			
			</select>
			
		<?php
		//filtro extra
		print "</td>";
		print "<td width='35%' align='right'>";
		if($sel_filtro=="cl")$txt_filtro="";
		?>
		
			Filtro:
			<input <?php if($sel_filtro!="" and $sel_filtro!="cl" and $sel_filtro!="no"){ ?> onkeypress="pulsar(event);" onblur="document.frm.submit();"<?php }?> name="txt_filtro" type="text" value="<?php echo $txt_filtro ?>" size="10"/>
			<select  onchange="document.frm.submit();" name="sel_filtro">
			
			<?php if($sel_filtro!="" and $sel_filtro!="cl" and $sel_filtro!="no"){ ?>
			<option value="<?php echo "cl" ?>">--Limpiar--</option>
			<?php } else{?>
			<option value="<?php echo "no" ?>">--Seleccionar--</option>
			<?php }
			
			// para llenar el combo del filtro
			for($columna=0;$columna<sizeof($filtros);$columna++) 
			{
			?>
				<option value="<?php echo $filtros[$columna]['field'];?>"<?php if($sel_filtro==$filtros[$columna]['field']){ echo "selected";}?>>
					<?php echo $filtros[$columna]['columna'];?>
				</option>
			<?php 
			}
			// para llenar el combo del filtro
			?>
			
			</select>
		</td>
		
		<td width='30%' align='right'>								
		<?php
		print $sig_ant." ".$cant_pag."&nbsp;&nbsp;&nbsp;";
		?>										
					Ver:
					<select name="sel_#" onChange="document.frm.submit();">
						<option value="3" <?php if($ver==3){?>selected="selected" <?php } ?>>3</option>
						<option value="10" <?php if($ver==10){?>selected="selected" <?php } ?>>10</option>
						<option value="15" <?php if($ver==15){?>selected="selected" <?php } ?>>15</option>
						<option value="20" <?php if($ver==20){?>selected="selected" <?php } ?>>20</option>
						<option value="25" <?php if($ver==25){?>selected="selected" <?php } ?>>25</option>
						<option value="30" <?php if($ver==30){?>selected="selected" <?php } ?>>30</option>
						<option value="50" <?php if($ver==50){?>selected="selected" <?php } ?>>50</option>
						<option value="100" <?php if($ver==100){?>selected="selected" <?php } ?>>100</option>
						<option value="500" <?php if($ver==500){?>selected="selected" <?php } ?>>500</option>
						<option value="1000" <?php if($ver==1000){?>selected="selected" <?php } ?>>1000</option>
						<option value="5000" <?php if($ver==5000){?>selected="selected" <?php } ?>>5000</option>
						<option value="10000" <?php if($ver==10000){?>selected="selected" <?php } ?>>10000</option>
					</select> filas
				</td>								
			</tr>
		</table>
		<?php
		print "</td></tr>";
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
		//------- filtros, paginador etc.
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Encabezado($campos,$elemento,$order,$ordtype,$ordtypestr,$x)
	{
	$archivo_actual=substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['SCRIPT_FILENAME'])-strlen('imp_'.$elemento.'.php'), strlen($_SERVER['SCRIPT_FILENAME'])); // solo obtengo el nombre de la pagina donde estoy situado ejem: imp_empresa.php
	$imp=substr($archivo_actual,0,3);
		
		// para poner el encabezado de columnas
		print "<tr class='encabezado_col'>";
		print "<td width='2%' align='center' >No</td>"; //numero de fila
			for($colum=0;$colum<sizeof($campos);$colum++)
			{
			
				print "<td ";if($campos[$colum]['info_col']=="input")print "align='center'";print "width='".$campos[$colum]['ancho']."'>";
				
				if($imp!='imp' and $imp!='exp' AND $campos[$colum]['info_col']!="calc" AND $campos[$colum]['info_col']!="input" AND $campos[$colum]['info_col']!="img_doc" AND $campos[$colum]['info_col']!="file_no_BD")
					print "<a href='lis_".$elemento.".php?order=".$campos[$colum]['field_col']."&type=".$ordtypestr."'>";
					
					print $campos[$colum]['columna']."&nbsp;";
					
					// para la flecha del ordenar
					if($campos[$colum]['field_col']==$order and $imp!='imp' and $imp!='exp' AND $campos[$colum]['info_col']!="input")
					{												
						if($ordtypestr=="asc" and $ordtype!="")
							print "<img height='7px' width='7px' border='0' src='".$x."img/general/flecha_abajo.png'/>";
						else 
							print "<img height='7px' width='7px' border='0' src='".$x."img/general/flecha_arriba.png'/>";												
					}
					// para la flecha del ordenar										
					if($imp!='imp' and $imp!='exp')
					print "</a>";					
					print "</td>";
			}
		if($imp!='imp' and $imp!='exp')
		{
			print "<td width='1%' >&nbsp;</td>"; //casilla para visualizar 
			print "<td width='2%' ><input name='checkbox' onclick='marcar();' type='checkbox'/></td>"; //casilla para marcar a todos
		}
		print "</tr>";
		// para poner el encabezado de columnas
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Filas($db,$elemento,$rs,$pag,$l_info_emergente,$cadenacheckboxp,$combo_sql,$alias_col,$opt_value,$opt_sel,$opt_name,$info_emerg,$columna,$info_col,$field_col,$href_m,$rs_sesion,$var_mod,$id_cadenacheckboxp,$x,$ancho,$obj2,$columna_suma)
	{
		
		
		$archivo_actual=substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['SCRIPT_FILENAME'])-strlen('imp_'.$elemento.'.php'), strlen($_SERVER['SCRIPT_FILENAME'])); // solo obtengo el nombre de la pagina donde estoy situado ejem: imp_empresa.php
		$imp=substr($archivo_actual,0,3);
		
		$aux_camp_g=1;
		$camp_g=0;
		$cadena_existe=0;
		$suma_columna=array();
		
		for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
		{
			$suma_columna[$cmp]=0;
		}
	
		// para crear las filas
		for($fila=0;$fila<$rs->RecordCount();$fila++)
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
			//$l_info_emergente=$this->reemplazar_caracter($l_info_emergente);
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
					
					if($aux_camp_g!=$camp_g)
					{
						if($fila!=0)
						//print "</table></td></tr>";<tr><td colspan='".$colspan1."'><table>
						
						print "<tr >";
						print "<td colspan='".$colspan."' class='row_grupo'>&nbsp;";
						 
						print "<a href='#' onclick='javascript:ocultar_filas(".$rs->fields[$field_col[0]].");'";
						print $camp_g;$aux_camp_g=$camp_g;
						print "</a>";
						
						print "</td>";
						
						print "<td class='row_grupo'>";//print 'www'.$id_cadenacheckboxp;
						if($id_cadenacheckboxp!='' AND $imp!='imp' AND $imp!='exp'){print "<input name='checkbox_".$rs->fields[$id_cadenacheckboxp]."' type='checkbox' value='checkbox'>";}else print '&nbsp;';					
						print "</td>";
						
						print "</tr>";//</table></td></tr>
						
						//if($fila<$rs->RecordCount()-1)
						//print "<tr><td colspan='".$colspan."'><table width='100%' cellpadding='0' id='".$rs->fields[$field_col[0]]."' style='display:block;'>";
						
						if(isset($rs->fields[$id_cadenacheckboxp]))
						{
							if($cadenacheckboxp == ""){$cadenacheckboxp = $rs->fields[$id_cadenacheckboxp];}
							else{$cadenacheckboxp .= ",".$rs->fields[$id_cadenacheckboxp];}
							$cadena_existe=1;
						}
						//print "  ppio11  ".$cadenacheckboxp." end <br>";
					}
				}
			}
			// para agrupar filas
			
			print "<tr ";if($pag % 2) print "class='row1'";else print "class='row0'";print " id='div_listado'>";
			print "<td width='2%' align='center'>".$pag."</td>"; //numero de fila
			
			for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
			{
				//$var_sum='suma_columna'.$cmp;
				//$$var_sum=0;
				//print 'suma_col:'.$suma_columna0;
				
			
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]==1 OR $info_col[$cmp]==2)
				{
					print "<td width='".$ancho[$cmp]."'>";
					
					if($imp!='imp' AND $imp!='exp')
					{						
						print "<a class='hlink'";
						//print "onmouseover=\"return overlib('".$l_info_emergente."', ABOVE, LEFT)\" onmouseout='return nd();'";
						
						$rs_sesion->MoveFirst();							
						$permiso=$this->Validar_mostrar_btn($rs_sesion,$elemento,'Editar');
						
						if($permiso=="ok" AND $href_m)
						{	
							if($var_mod)
							print "href=".$href_m.$rs->fields[$var_mod]; // en caso de que el Editar no sea del propio elemento
							else
							print "href=".$href_m.$rs->fields[$alias_col[0]];
						}
						print ">";
					}					
					
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
					
					if($imp!='imp' and $imp!='exp')
						print "</a>";
					
					print "</td>";
					
					print "</div>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="img_doc")
				{
					print "<td width='".$ancho[$cmp]."'>";
					if($imp!='imp' AND $imp!='exp')
					{
						if(isset($rs->fields[$field_col[$cmp]]))
						//print $field_col[$cmp];
						$camp=$rs->fields[$field_col[$cmp]];
						if(base64_encode($camp))
						$img="<img style=\'border-radius:8px;\' width=150px src=\'data:image/jpeg;base64,". base64_encode($camp). "\'/>";
						else
						$img="<img style=\'border-radius:8px;\' width=150px src=\'".$x."img/general/no_doc_big.png\'/>";
						
						print "<a class='hlink'";
						print "onmouseover=\"return overlib('".$img."', '', LEFT)\" onmouseout='return nd();'";
						
						$rs_sesion->MoveFirst();							
						$permiso=$this->Validar_mostrar_btn($rs_sesion,$elemento,'Editar');
						
						if($permiso=="ok" AND $href_m)
						print 'href="data:image/jpeg;base64,'. base64_encode($camp).'"';

						print ">";
										
						if(base64_encode($camp))
						echo '<img width="10px" height="10px" src="data:image/jpeg;base64,'. base64_encode($camp). '"/>';
						else
						echo '<img width="10px" height="10px" src="'.$x.'img/general/no_doc.png"/>';
						//print $camp;
					}
						
					if($imp!='imp' and $imp!='exp')
					print "</a>";
						
					print "</td>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
			
						
			
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="file_no_BD")
				{
					print "<td width='".$ancho[$cmp]."'>";
					if($imp!='imp' AND $imp!='exp')
					{
						if(isset($rs->fields[$field_col[$cmp]]))
						{
							if($rs->fields[$field_col[$cmp]]!='')
							{
								$img="<img src='".$x."img/general/adjuntar.png'/>";
								print "<a href='".$x."archivos/".$rs->fields[$field_col[$cmp]]."'  download='".$rs->fields[$field_col[$cmp]]."'>".$img."</a>";
							}
						}
					}
					print "</td>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="img_chec")
				{
					print "<td width='".$ancho[$cmp]."'>";
					if($imp!='imp' AND $imp!='exp')
					{
						$camp=$rs->fields[$field_col[$cmp]];
						
						if($camp==1)
						echo '<img width="10px" height="10px" src="'.$x.'img/general/si.png"/>';
						else
						echo '<img width="10px" height="10px" src="'.$x.'img/general/no.png"/>';
						//print $camp;
					}
						
					if($imp!='imp' and $imp!='exp')
					print "</a>";
						
					print "</td>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
				if($info_col[$cmp]=="calc")
				{
					print "<td width='".$ancho[$cmp]."'>";
					eval("\$str = $field_col[$cmp];");
					print $str;	
					print "</td>";
					
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
					print "<td align='center' width='".$ancho[$cmp]."'>";
					
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
					print "</td>";
				}
				//------------------------------------------
				//------------------------------------------
				//------------------------------------------
			}
			
			if($imp!='imp' AND $imp!='exp')
			{
				print "<td width='1%' align='center'>";
				if($href_m!='')
				{
					print "<a class='hlink'";
					print "onmouseover=\"return overlib('".$l_info_emergente."', ABOVE, LEFT)\" onmouseout='return nd();'";
				
					if($var_mod)
						print "href=".$href_m.$rs->fields[$var_mod].'&visualizar=1'; // en caso de que el Editar no sea del propio elemento
					else
						print "href=".$href_m.$rs->fields[$alias_col[0]].'&visualizar=1';
				
				print ">";
				echo '<img width="14px" height="14px" src="'.$x.'img/general/ver.png"/>';//print $href_m;
				print "</a>";
				}
				else
				{
					print "<a class='hlink'";
					print "onmouseover=\"return overlib('".$l_info_emergente."', ABOVE, LEFT)\" onmouseout='return nd();'";				
					print ">";
					echo '<img width="14px" height="14px" src="'.$x.'img/general/ver.png"/>';//print $href_m;
					print "</a>";
				}
								
				print "</td>"; //casilla para marcar a todos
				
				print "<td width='1%'>";
				
				if($id_cadenacheckboxp=='')
				{
					if($var_mod)
					print "<input name='checkbox_".$rs->fields[$var_mod]."' type='checkbox' value='checkbox'>";// en caso de que el Editar no sea del propio elemento
					else
					print "<input name='checkbox_".$rs->fields[$alias_col[0]]."' type='checkbox' value='checkbox'>";
				}
				else
				print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				print "</td>";
			}
			print "</tr>";
			
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
			
			$pag=$pag+1;
			$l_info_emergente="";
			
		$rs->MoveNext();		
		}
	// para agrupar filas
	/*for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
	{
		if($info_col[$cmp]!=1 AND $info_col[$cmp]!=2 AND $info_col[$cmp]!="img_doc" AND $info_col[$cmp]!="img_chec" AND $info_col[$cmp]!="calc" AND $info_col[$cmp]!="input" AND $info_col[$cmp]!="img_doc" AND $info_col[$cmp]!='')
		{ //print $fila."==".$rs->RecordCount();
			if($fila==$rs->RecordCount() AND $fila!=0)
			//print "</table></td></tr>";
			print "";
		}
	}*/
	
	

	
	//if(sizeof($suma_columna[$cmp])>0)
	//{
		print "<tr><td align='center' colspan='".sizeof($field_col)."'><b>";		
		for($sum=0;$sum<sizeof($columna_suma);$sum++)
		{
			if($columna_suma[$sum]!='')print $columna[$columna_suma[$sum]].': '.number_format(round($suma_columna[$columna_suma[$sum]],2), 2, ".", "").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}		
		print "</b></td></tr>";
	//}
		
		
		// para agrupar filas
		return $cadenacheckboxp;
		// para crear las filas 
		
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Pie($colspan)
	{
		print "<tr><td colspan='".$colspan."'>";
		// footer
		
		// footer
		print "</td></tr></table>";
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Encabezado_titulo($x,$img_encabezado,$titulo_listar,$botones,$rs_sesion,$elemento)
	{
	?>
	<table class="encabezado"cellpadding="0">
		<tr>
			<td>
				<table class="menubar" id="toolbar">
					<tr>
						<td class="img_encabezado"><img src="<?php echo $x.$img_encabezado;?>" width="48" height="48" border="0"></td>
						<td class="titulo_encabezado"><?php echo $titulo_listar;?></td>						
						<?php 
						 $this->Botonera($botones,$rs_sesion,$elemento);
						?>										 
					</tr>
				</table>
			</td>
		</tr>		
	</table>
	<?php
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
	function mini_encabezado_titulo($x,$img_encabezado,$titulo_listar,$botones,$rs_sesion,$elemento)
	{
	?>
	<table class="encabezado"cellpadding="0">
		<tr>
			<td>
				<table class="menubar mini_menubar" width='100%' id="toolbar">
					<tr>
						<td class="titulo_encabezado"><?php echo $titulo_listar;?></td>						
						<?php 
						 $this->mini_botonera($botones,$rs_sesion,$elemento);
						?>										 
					</tr>
				</table>
			</td>
		</tr>		
	</table>
	<?php
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function mini_botonera($botones,$rs_sesion,$elemento)
	{
		for($btn=0;$btn<sizeof($botones);$btn++)
		{
			$rs_sesion->MoveFirst();
			if($botones[$btn]['accion'])
			$permiso=$this->Validar_mostrar_btn($rs_sesion,$elemento,$botones[$btn]['accion']);
			else
			$permiso="ok";
			//print "<br>".$elemento."<br>".$botones[$btn]['accion'];
			if($permiso=="ok")
			{
				?>
					<td class="botonera_encabezado"> 
						<div>
							<a class="toolbar" target="<?php print($botones[$btn]['target']);?>" href="<?php print($botones[$btn]['href']);?>" onClick="<?php print($botones[$btn]['onclic']);?>">
								<img src="<?php print($botones[$btn]['src']);?>" alt="<?php print($botones[$btn]['texto']);?>" name="<?php print($botones[$btn]['nombre']);?>" width="16" height="16" border="0" id="<?php print($botones[$btn]['nombre']);?>">
								<br>
								<?php print($botones[$btn]['texto']);?>	
							</a>
						</div>
					</td>
				<?php
			}
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
	function Botonera($botones,$rs_sesion,$elemento)
	{
		for($btn=0;$btn<sizeof($botones);$btn++)
		{
			$rs_sesion->MoveFirst();
			if($botones[$btn]['accion'])
			$permiso=$this->Validar_mostrar_btn($rs_sesion,$elemento,$botones[$btn]['accion']);
			else
			$permiso="ok";
			//print "<br>".$elemento."<br>".$botones[$btn]['accion'];
			if($permiso=="ok")
			{
				?>
					<td class="botonera_encabezado"> 
						<div>
							<a class="toolbar" target="<?php print($botones[$btn]['target']);?>" href="<?php print($botones[$btn]['href']);?>" onClick="<?php print($botones[$btn]['onclic']);?>">
								<img src="<?php print($botones[$btn]['src']);?>" alt="<?php print($botones[$btn]['texto']);?>" name="<?php print($botones[$btn]['nombre']);?>" width="32" height="32" border="0" id="<?php print($botones[$btn]['nombre']);?>">
								<br>
								<?php print($botones[$btn]['texto']);?>	
							</a>
						</div>
					</td>
				<?php
			}
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Validar_sesion($db,$x)
	{//print $x;
		session_save_path($x."temp" );
		//session_start();
		//print $_SESSION["usuario"];die();
		if(isset($_SESSION["user"]))	
		{
			if($_SESSION["user"]!='')	
			{ 
				
				$sql="SELECT clave, usuario, usuario.id_usuario,clave,rol,accion,elemento,modulo, color_submodulo FROM usuario, usuario_rol, n_rol, permiso, n_accion, n_elemento
				WHERE usuario.id_usuario=usuario_rol.id_usuario AND usuario_rol.id_rol=n_rol.id_rol AND permiso.id_rol=n_rol.id_rol AND permiso.id_accion=n_accion.id_accion AND permiso.id_elemento=n_elemento.id_elemento 
				AND usuario='".$_SESSION["user"]."' ORDER BY modulo ,orden, elemento, accion ASC";//print $sql;die();
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
				$hash=$rs->fields["clave"];
				$id_usuario=$rs->fields["id_usuario"];
				
				$sql_ses="SELECT sesion_id FROM usuario, sesion	WHERE usuario.id_usuario=sesion.id_usuario AND usuario='".$_SESSION["user"]."'";
				$rs_ses=$db->Execute($sql_ses) or die($db->ErrorMsg());
				
				//print $rs_ses->fields["sesion_id"].' - '.md5(md5(md5($_SESSION["sid"])));
				if($rs_ses->fields["sesion_id"]==md5(md5(md5($_SESSION["sid"]))))//if(password_verify($_SESSION["password"], $hash))		
				{ 
					$_SESSION["md5_rol"] =  md5($rs->fields["rol"]);					
					$_SESSION["rol"] =  $rs->fields["rol"];
					$_SESSION['user'] = $rs->fields["usuario"];
					$_SESSION["id_user"] = $rs->fields["id_usuario"];
					//$_SESSION["password"] = $rs->fields["clave"];
					$_SESSION["ok"] = "ok";//print $_SESSION["ok"];
				}
				else
				echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='http://".$_SERVER['SERVER_NAME']."/minerva/seguridad/logout.php?mensaje=Su sesion ha caducado.' </script>");
			}
			
			if(isset($_SESSION["ok"]))
			{
				if($_SESSION["ok"]!="ok")
				{
					echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='http://".$_SERVER['SERVER_NAME']."/minerva/seguridad/logout.php' </script>");
				}
			}
			else
			echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='http://".$_SERVER['SERVER_NAME']."/minerva/seguridad/logout.php' </script>");
			
			return $rs;
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Validar_permiso($rs,$elemento,$accion)
	{
	$permiso="";
		if(isset($rs->fields[0]))
		{
			for($q=0;$q<$rs->RecordCount();$q++)
			{//print $rs->fields['elemento']."   ".$rs->fields['accion']."<br>";
				if($rs->fields['elemento']==$elemento AND $rs->fields['accion']==$accion)
				{
					$permiso="ok";break;
				}
				else
				{
					$permiso="";
					$mensaje='No tiene permisos para '.$accion.' el elemento: '.$elemento;
					//die();
				}
			$rs->MoveNext();
			}
		}
		if(!$permiso)echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='http://".$_SERVER['SERVER_NAME']."/minerva/seguridad/logout.php?mensaje=".$mensaje."' </script>");
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Validar_mostrar_btn($rs,$elemento,$accion)
	{
		for($b=0;$b<$rs->RecordCount();$b++)
		{//print $rs->fields['elemento']."   ".$rs->fields['accion']."<br>";
			if($rs->fields['elemento']==$elemento AND $rs->fields['accion']==$accion)
			{
				$permiso="ok";break;
			}
			else
			{
				$permiso="";
			}
		$rs->MoveNext();
		}//print $permiso;
	return $permiso;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Menu($rs_sesion,$x)
	{
		include($x."/menu_mod/clases_menu.php");
		$obj = new clases_menu(); // (NO TOCAR)
		
		if(isset($_GET["modulo"]))
		{
			$_SESSION["modulo"] = $_GET["modulo"];$modulo=$_GET["modulo"];
		}
		//print $_SESSION["modulo"];
		if(isset($_SESSION["ok"]))$ok = $_SESSION["ok"];else $ok='';//print $rs_sesion;
		?>
		
			<script language="JavaScript" type="text/javascript">			
			
			var dir=document.domain;//alert(dir);
			var site='/minerva';
			var img='/img/general/extrasmall/';
			var _cmSplit;
			 
			var myMenu =
			[
				[null,'<img src="https://'+dir+site+img+'/home.png" >',<?php if(isset($_SESSION["modulo"]) AND $_SESSION["modulo"]!='' AND $_SESSION["modulo"]!='mod'){?>'https://'+dir+site+'/pag/panel/modulo.php?modulo=<?php print $_SESSION["modulo"];?>'<?php }elseif($ok){?>'https://'+dir+site+'/pag/panel/panel.php'<?php }else {?>'https://'+dir+site+'/seguridad/autenticacion.php'<?php }?>,null,''],

				<?php if($_SESSION["modulo"] && $rs_sesion)$obj->menu_mod($rs_sesion);?>
				
				[null,'Servicios',null,null,'Servicios',
					['<img src="https://'+dir+site+img+'/exit.png" />','Cerrar Sesi&oacute;n','https://'+dir+site+'/seguridad/logout.php',null,'Salir del Sistema'],				
					['<img src="https://'+dir+site+img+'/password.png" />','Cambiar Contrase&ntilde;a','https://'+dir+site+'/seguridad/cambiar_clave.php',null,'Cambiar Contrase&ntilde;a'],
					<?php /*if($_SESSION["rol"]){?>
					['<img src="https://'+dir+site+img+'/estilo.png" />','Plantilla','https://'+dir+site+'/seguridad/cambiar_plantilla.php',null,'Plantilla'],
					<?php }*/?>
				],

				
				

				[null,'Ayuda',null,null,'Ayuda',
					['<img src="https://'+dir+site+img+'/help.png" />','Acerca del sistema','https://'+dir+site+'/pag/general/acerca.php',null,'Acerca del sistema'],	
				],
				_cmSplit,
				
				<?php if(isset($_SESSION["modulo"])){if($_SESSION["modulo"]!='' AND $_SESSION["modulo"]!='mod'){?>
				[null,'<img src="https://'+dir+site+img+'/salir.png" >','https://'+dir+site+'/pag/panel/panel.php?modulo=mod',null,''],
				<?php }}?>
			];
			cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
			
			</script>
		<?php
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Notificaciones($rs_sesion,$x,$db)
	{
		include($x."/menu_mod/clases_menu_notificaciones.php");
		$obj = new clases_menu_notificaciones(); // (NO TOCAR)
		
		if(isset($_GET["modulo"]))
		{
			$_SESSION["modulo"] = $_GET["modulo"];$modulo=$_GET["modulo"];
		}
//$obj->menu_mod($rs_sesion,$db);
		if(isset($_SESSION["ok"]))$ok = $_SESSION["ok"];else $ok='';//print $rs_sesion;
		?>
		
			<script language="JavaScript" type="text/javascript">			
			
			var dir=document.domain;//alert(dir);
			var site='/minerva';
			var img='/img/general/extrasmall/';
			var _cmSplit;
			 
			var myMenu =
			[
				<?php if(isset($rs_sesion))$obj->menu_mod($rs_sesion,$db);?>
			];
			cmDraw ('notificaciones_id', myMenu, 'hbl', cmThemeOffice, 'ThemeOffice');
			
			</script>
		<?php
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Header_menu($x,$img_banner,$nombre_empresa,$publicidad,$rol,$camino_logout,$usuario,$img_salir,$rs_sesion,$db)
	{
	if(isset($_SESSION["rol"]))$rol = $_SESSION["rol"];else $rol='';
	?>	
	
	<div align="center"class="contenido_general" id="contenido1">

	<table class="tabla_exterior" align='center' width='99%'cellpadding="0">
		<tr>
			<td cellpadding="0">
				<table class="tabla_header">
					<tr>
						<td class="tabla_exterior">
							
							
							<div style='display:table;width:100%;'>

								<div style='display:table-row;height:30px;background-color:#8A8A8A;'>
									<div style='text-shadow:1px;display:table-cell;color:#A51110;padding-left:2%;vertical-align:middle;line-height:40px;font-size:36px;text-align:left;FONT-FAMILY: Times New Roman;'><img height="50" border="0"src="<?php echo $x.'img/general/minerva_logo.png';?>"/></div>
									<div style='display:table-cell;width:400px;line-height:40px;text-align:right;vertical-align:middle;FONT-FAMILY: calibri;color:#fff;font-size:20px;padding:1%;'><img height="45" border="0"src="<?php echo $x.'img/general/logo FCEA.png';?>"/></div>
									<div style='display:table-cell;width:8px;line-height:40px;font-size:26px;color:#fff;text-align:center;vertical-align:middle;'>|</div>
									<div style='display:table-cell;width:145px;line-height:40px;text-align:center;vertical-align:middle;'><img height="45" border="0"src="<?php echo $x.$img_banner;?>"/></div>
									<div style='display:table-cell;width:8px;line-height:40px;font-size:26px;color:#fff;text-align:center;vertical-align:middle;'>|</div>
									<div style='display:table-cell;line-height:15px;padding:1%;text-align:left;vertical-align:middle;width:260px;font-size:12px;color:#fff;FONT-FAMILY: calibri;';><?php echo $publicidad;?></div>
								</div>
								
								<div style='display:table-row;line-height:0px;height:8px;background-color:#990000;border-top:3px solid #fff;'>
									<div style='display:table-cell;'>&nbsp;</div>
									<div style='display:table-cell;'>&nbsp;</div>
									<div style='display:table-cell;'>&nbsp;</div>
									<div style='display:table-cell;'>&nbsp;</div>
									<div style='display:table-cell;'>&nbsp;</div>
									<div style='display:table-cell;'>&nbsp;</div>
								</div>

							</div>
							
							
							
							
							
							<?php
							/*<div style='display:table-row;'>
									<div style='display:table-cell;height:22px;width:7%;text-align:left;'>&nbsp;</div>
									<div style='display:table-cell;height:22px;width:7%;text-align:left;'>&nbsp;</div>
									<div style='display:table-cell;height:22px;width:7%;text-align:left;'>&nbsp;</div>
									<div style='display:table-cell;height:22px;width:9%;text-align:left;'>&nbsp;</div>
								</div>
							<table class="header">
								<tr>
									<td width="20%"><div ><img height="40" border="0"src="<?php echo $x.$img_banner;?>"/></div></td>
									<td><div>&nbsp;&nbsp;&nbsp;<?php echo $nombre_empresa."&nbsp;-&nbsp;".$publicidad;?></div></td>
								</tr>
							</table>
							*/
							?>
						</td>
					</tr>
					<tr>
						<td class="tabla_exterior">
							<table class="menubar">
								<tr>
									<td style="padding-left:5px;text-align:left;" ><div id="myMenuID"></div>
									<?php
										if($x)$this->Menu($rs_sesion,$x);
									?>
									</td>

									<td style="padding-left:5px;text-align:left;" width="20%"><div id="notificaciones_id"></div>
										<?php
											if($usuario)$this->Notificaciones($rs_sesion,$x,$db);
										?>
									</td>
									<td class="intro_sup" align="right" width="7%" >
										<a class="intro_sup" onmouseover="return overlib('<?php print $rol;?>', ABOVE, LEFT);" onmouseout="return nd();" href="<?php echo $x.$camino_logout;?>" style="color: #333333; font-weight: bold">
											<?php print $usuario;?>&nbsp;<img  border="0"src="<?php echo $x.$img_salir;?>"/>&nbsp;
										</a>
									</td>
								</tr>
							</table>
	<?php
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function Descargar_archivo($file,$objPHPExcel,$objWriter,$info_emerg,$columna,$alias_col,$rs,$obj,$titulo_listar,$info_col,$db,$obj2)
	{
		
		$objPHPExcel->getProperties()->setCreator("Raydel Ojeda Figueroa");
		$objPHPExcel->getProperties()->setTitle($titulo_listar);
		$objPHPExcel->setActiveSheetIndex(0); //Elegimos la hoja 0
		$encabezados_exp=array();
		$datos_exp=array();
		$e=0;
		$col=0;
		$fila=3;
		
		for($exp=0;$exp<sizeof($columna);$exp++) 
		{
			if($info_emerg[$exp]!='' AND $info_emerg[$exp]!='img')
			{
				$encabezados_exp[$e]=$columna[$exp];	//print utf8_encode($columna[$exp])."<br>";	
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($e,2,utf8_encode($this->Reemplazar_a_tildes($columna[$exp])));
				
				$e=$e+1;
			}
		}	
	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,utf8_encode($this->Reemplazar_a_tildes($titulo_listar." ".date("d-m-Y"))));
		
		$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
		
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);


		$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);

		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startcolor' => array(
					'argb' => 'FFA0A0A0',
				),
				'endcolor' => array(
					'argb' => 'FFFFFFFF',
				),
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->applyFromArray($styleArray);


		while(!$rs->EOF)
		{
			for($exp=0;$exp<sizeof($columna);$exp++) 
			{
				if($info_emerg[$exp]!='' AND $info_emerg[$exp]!='img' AND $info_col[$exp]!="calc" AND $info_col[$exp]!="input" AND $info_col[$exp]!="img_doc" AND $info_col[$exp]!="file_no_BD")
				{
					$datos_exp[$col][$fila]=$rs->fields[$alias_col[$exp]];
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,$this->Reemplazar_a_tildes($rs->fields[$alias_col[$exp]]));
					$col=$col+1;
				}
				if($info_col[$exp]=="calc")
				{
					
					eval("\$str = $alias_col[$exp];");	
					$datos_exp[$col][$fila]=$str;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,utf8_encode($this->Reemplazar_a_tildes($str)));
					$col=$col+1;
				}
			}
		$fila=$fila+1;
		$col=0;
		$rs->MoveNext();
		}
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
		
		$objWriter->setOffice2003Compatibility(true);
		$objWriter->save($file);
			
		if (file_exists($file)) 
		{
			header('Content-Disposition: attachment; filename='.$file );
			header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Length: ' . filesize($file));
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			ob_clean();
			flush(); 
			readfile($file);
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function Reemplazar_a_tildes($cadena)
	{
		$original = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;");
		$tildes   = array("á", "é", "í", "ó", "ú", "ñ");
		$nueva_cadena = str_replace($original, $tildes, $cadena);
		//print $nueva_cadena;die();
		return $nueva_cadena;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Consulta_listar($field,$alias_col,$tabla,$tabla_anidada,$campo_anidado,$tabla_anidada2,$campo_anidado2,$where,$info_col,$operador,$select)
	{// consulta
		if(isset($select) AND $select!='')
			$l_sql=$select;
		else
		{
			$l_sql="SELECT ";
			
			$antepenultimo=sizeof($field)-2;
			$ultimo=sizeof($field)-1;
				
			for($cam=0;$cam<sizeof($field);$cam++) 
			{
				if($info_col[$cam]!="calc" AND $info_col[$cam]!="input")
				{
					if($l_sql!="SELECT ")
					{
						$l_sql=$l_sql.", ".$field[$cam]." as ".$alias_col[$cam];//print "111cam:".$cam." antepenultimo: ".$antepenultimo." ultimo: ".$ultimo. " info_col: ".$info_col[$cam]."<br>";
					}
					elseif($l_sql=="SELECT ")
					{
						$l_sql.=$operador;$l_sql=$l_sql.$field[$cam]." as ".$alias_col[$cam];//print "222cam:".$cam." antepenultimo: ".$antepenultimo." ultimo: ".$ultimo. " info_col: ".$info_col[$cam]."<br>";
					}
				}
			}
			
			$l_sql=$l_sql." FROM ".$tabla;
			for($sql=0;$sql<sizeof($tabla_anidada);$sql++) 
			{
				if($tabla_anidada[$sql])$l_sql=$l_sql.",".$tabla_anidada[$sql];
			}

			for($sql=0;$sql<sizeof($tabla_anidada2);$sql++) 
			{
				if(isset($tabla_anidada2[$sql]))$l_sql=$l_sql.",".$tabla_anidada2[$sql];
			}	
			
			$l_sql=$l_sql." WHERE 1 ";
			
			for($fld=0;$fld<sizeof($tabla_anidada);$fld++) 
			{
				if($tabla_anidada[$fld])$l_sql=$l_sql." AND ".$tabla.".".$campo_anidado[$fld]."=".$tabla_anidada[$fld].".".$campo_anidado[$fld];
			}
			
			if(isset($where))$l_sql=$l_sql.$where;
		}
		//print $l_sql;//die();
		return $l_sql;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------			
	function Generar_inputs($input,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,$contenedor,$visualizar)
	{
		$cont_insertar="";	
		
		if($visualizar==1)$disable='disabled style="background-color:#ddd"';else $disable='';

		$cont_insertar=$cont_insertar."<div style='display:table;width:100%;'>";
		
		for($edt=0;$edt<sizeof($input);$edt++) 
		{
			if($input[$edt]['tipo_input']!='hidden')
			{
				$cont_insertar=$cont_insertar."<div style='display:table-row;width: 100%;'><div style='height:22px;width:20%;display:table-cell;text-align:right;'> ";
				$cont_insertar=$cont_insertar.$input[$edt]['title'].":";//label
				$cont_insertar=$cont_insertar."</div><div style='display:table-cell;text-align:left;'>";			
			}
	
			$cont_insertar=$cont_insertar.$this->tipo_input($input, $edt, $s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias, $disable)."&nbsp;";//input		
			
			if(substr($input[$edt]['dato_permit'],0,1)=="R")$cont_insertar=$cont_insertar."*";			
			
			$cont_insertar=$cont_insertar."&nbsp;";
			if(isset($input[$edt]['texto_input']))
			$cont_insertar=$cont_insertar.$input[$edt]['texto_input'];// valor que va a tener el campo a la derecha como texto explicativo
			
			if($input[$edt]['tipo_input']!='hidden')$cont_insertar=$cont_insertar."</div></div>";
		}
		
		$cont_insertar=$cont_insertar."</div>";

		print $cont_insertar;
	}
	
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function tipo_input($input, $edt, $s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias, $disable)
	{
		$js='';$linea_input='';
		if($input[$edt]['size']>100)$size=100;else $size=$input[$edt]['size'];
		
		$num_valores=$input[$edt]['num_valores']; // $num_valores tiene el # del campo que es un selecBD
			
		if($input[$edt]['tipo_input']=='file')
		{				
			$linea_input="<input name='up_".$input[$edt]['name_input']."' id='up_".$input[$edt]['name_input']."' placeholder='' disabled='disabled' size='45'/>&nbsp;";
			$linea_input=$linea_input."<div class='upload'><input type='file' onchange='poner_valor_up(\"".$input[$edt]['name_input']."\");' placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			
			//if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			//else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input." /></div>";			
		}
		
		if($input[$edt]['tipo_input']=='file_no_BD')
		{				
			$linea_input="<input name='up_".$input[$edt]['name_input']."' id='up_".$input[$edt]['name_input']."' placeholder='' disabled='disabled' size='45'";
			
			if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input."/>&nbsp;";
			$linea_input=$linea_input."<div class='upload'><input type='file' onchange='poner_valor_up(\"".$input[$edt]['name_input']."\");' placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			
			
			
			$linea_input=$linea_input." /></div>";			
		}
		
		if($input[$edt]['tipo_input']=='number')
		{
			$linea_input="<input ".$disable." type='number' placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			
			if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='input')
		{
			$linea_input="<input ".$disable." ".$input[$edt]['evento']."  type='text' placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			
			if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='fecha')
		{
			$linea_input="<input ".$disable." type='date' placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			
			if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='color')
		{
			$linea_input="<input ".$disable." type='color' placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			
			if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='pass')
		{
			$linea_input="<input ".$disable." type='password' value='' placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='texto_input')
		{
			$linea_input="<input type='input' disabled style='background-color:#ddd' name='".$input[$edt]['name_input']."_visible' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."_visible' onclick='".$input[$edt]['onclic']."' size='".$size."' maxlength='".$input[$edt]['size']."'";
			
			if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			elseif($s_rs->fields[$input[$edt]['name_input']]=='')$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input." />";
			
			$linea_input=$linea_input."<input type='hidden' name='".$input[$edt]['name_input']."' id='".$input[$edt]['name_input']."'";
			
			if(!$s_rs)$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			elseif($s_rs->fields[$input[$edt]['name_input']]=='')$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; else $linea_input=$linea_input." value='".$s_rs->fields[$input[$edt]['name_input']]."'";//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='texto')//si tiene algo en el value aparecerá ese valor
		{	
			$linea_input=$input[$edt]['value_input']; 
			
			$linea_input=$linea_input."<input type='hidden' name='".$input[$edt]['name_input']."' id='".$input[$edt]['name_input']."'";
			$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='hidden')//es hidden cuando es un id de otra tabla
		{	
			$linea_input="<input type='hidden' name='".$input[$edt]['name_input']."' id='".$input[$edt]['name_input']."'";
			$linea_input=$linea_input." value='".$input[$edt]['value_input']."'"; 
			$linea_input=$linea_input." />";
		}
		
		if($input[$edt]['tipo_input']=='textarea')
		{
			$linea_input="<textarea ".$disable." placeholder='".$input[$edt]['placeholder']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."' onclick='".$input[$edt]['onclic']."' rows='4' cols='60'>";
			
			if(!$s_rs)$linea_input=$linea_input.$input[$edt]['value_input']; 
			else $linea_input=$linea_input.$s_rs->fields[$input[$edt]['name_input']];//field_col puede ser igual al name_input y a los alias, esta línea es para Editar
			
			$linea_input=$linea_input."</textarea>";
		}
		
		if(substr($input[$edt]['tipo_input'],0,6)=='select')
		{
		
			$js=$js. "$(\".js-example-basic-single".$edt."\").select2();";
			
			//print "size option:".sizeof($option)."<br>";
			if($input[$edt]['tipo_input']=='select')
			{		
				$linea_input="<select class='js-example-basic-single".$edt."' ".$disable." onchange='".$input[$edt]['onclic']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."'>";
				$linea_input=$linea_input."<option value='no' selected>----------------------------</option>";
				
				for($opt_val=0;$opt_val<sizeof($opt_value[$num_valores]);$opt_val++) 
				{
					$linea_input=$linea_input."<option size='".$size."' value='".$opt_value[$num_valores][$opt_val]."'";
					
					if($s_rs) // si hay $s_rs es que estamos modificando			
					{//print $s_rs->fields[$insert_alias[$num_valores]]." == ".$opt_value[$num_valores][$opt_val]."".$opt_name[$num_valores][$opt_val]."<br>";
						if($s_rs->fields[$insert_alias[$num_valores]]==$opt_value[$num_valores][$opt_val])
						{
							$linea_input=$linea_input." selected";
						}
					}
					else // si no hay$s_rs es que estamos insertarndo
					{
						if($opt_sel[$num_valores][$opt_val]=='selected')
						{							
							$linea_input=$linea_input." selected";							
						}
					}
					$linea_input=$linea_input.">".$opt_name[$num_valores][$opt_val]."</option>";
				}	
				$linea_input=$linea_input."</select>";
			}

			if($input[$edt]['tipo_input']=='select_1_valor_estatico')
			{		
				$linea_input="<select class='js-example-basic-single".$edt."' ".'disabled style="background-color:#ddd"'."  onchange='".$input[$edt]['onclic']."' name='".$input[$edt]['name_input']."_visible' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."_visible'>";
				$linea_input=$linea_input."<option value='no' selected>----------------------------</option>";
				
				for($opt_val=0;$opt_val<sizeof($opt_value[$num_valores]);$opt_val++) 
				{
					$linea_input=$linea_input."<option size='".$size."' value='".$opt_value[$num_valores][$opt_val]."'";
					
					if($s_rs) // si hay $s_rs es que estamos modificando			
					{
					/*print $s_rs.'<br>';
					print $insert_alias[$num_valores];
					print ' - ';
					print $s_rs->fields[$insert_alias[$num_valores]];
					print ' == '.$opt_value[$num_valores][$opt_val].'<br>';*/
						if($s_rs->fields[$insert_alias[$num_valores]]==$opt_value[$num_valores][$opt_val])
						{//print 'entraa';
							$linea_input=$linea_input." selected";
							$value=$opt_value[$num_valores][$opt_val];
						}
					}
					else // si no hay$s_rs es que estamos insertarndo
					{
						if($opt_sel[$num_valores][$opt_val]=='selected')
						{							
							$linea_input=$linea_input." selected";
							$value=$opt_value[$num_valores][$opt_val];							
						}
					}
					$linea_input=$linea_input.">".$opt_name[$num_valores][$opt_val]."</option>";
				}	
				$linea_input=$linea_input."</select>";
				
				$linea_input=$linea_input."<input type='hidden' name='".$input[$edt]['name_input']."' id='".$input[$edt]['name_input']."'";
				$linea_input=$linea_input." value='".$value."'"; 
				$linea_input=$linea_input." />";
			}
			
			elseif($input[$edt]['tipo_input']=='selectBD') // hay que hacer otro ciclo ya que $edt solo llega a los inputs mostrados
			{
			//print $combo_sql[$num_valores].$num_valores;
				$linea_input="<select  class='js-example-basic-single".$edt."' ".$disable." onchange='".$input[$edt]['onclic']."' name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."'>";
				$linea_input=$linea_input."<option value='no' selected>----------------------------</option>";
				
				$combo_rs=$db->Execute($combo_sql[$num_valores]) or die($db->ErrorMsg());		
				//print "cant: ".$combo_rs->RecordCount().$combo_rs;//print $s_rs;				
				for($opt_rs=0;$opt_rs<$combo_rs->RecordCount();$opt_rs++) 
				{		
					$value=$combo_rs->fields[$opt_value[$num_valores][0]]; // tiene el id
					$sel_campo=$combo_rs->fields[$opt_sel[$num_valores][0]]; // tiene el id
					$name=$combo_rs->fields[$opt_name[$num_valores][0]]; // tiene lo que muestra al usuario			
						
					$linea_input=$linea_input."<option width='".$size."' value=".$value;	
					//	
					if($s_rs)					
					{//print $s_rs->fields[$opt_sel[$num_valores][0]]." == ".$sel_campo."  num_valores:".$num_valores."  arreglo: ".$opt_sel[$num_valores][0]."<br>";
						if($s_rs->fields[$opt_sel[$num_valores][0]]==$sel_campo)
						{
							$linea_input=$linea_input." selected";
						}
					}
					$linea_input=$linea_input.">".$name."</option>";
					
				$combo_rs->MoveNext();					
				}	
				$linea_input=$linea_input."</select>";
			}
			
			elseif($input[$edt]['tipo_input']=='select_1_valor')
			{
				$linea_input="<select class='js-example-basic-single".$edt."' ".$disable." name='".$input[$edt]['name_input']."' title='".$input[$edt]['title']."' id='".$input[$edt]['name_input']."'>";
			
				$combo_rs=$db->Execute($combo_sql[$num_valores]) or die($db->ErrorMsg());					
				//print $combo_rs->RecordCount();
				for($opt_rs=0;$opt_rs<$combo_rs->RecordCount();$opt_rs++) 
				{	
					$value=$combo_rs->fields[$opt_value[$num_valores][0]]; // tiene el id
					$sel_campo=$combo_rs->fields[$opt_sel[$num_valores][0]]; // tiene el id
					$name=$combo_rs->fields[$opt_name[$num_valores][0]]; // tiene lo que muestra al usuario			
						//print $name." k ";
					
					$linea_input=$linea_input."<option value=".$value.">".$name."</option>";						
								
				$combo_rs->MoveNext();					
				}
				$linea_input=$linea_input."</select>";
			}	
		}	
		
		if($input[$edt]['tipo_input']=='texto_select')
		{
			$combo_rs=$db->Execute($combo_sql[$num_valores]) or $mensaje=$db->ErrorMsg();
			//print $combo_rs->RecordCount();
			for($opt_rs=0;$opt_rs<$combo_rs->RecordCount();$opt_rs++) 
			{	
				$value=$combo_rs->fields[$opt_value[$num_valores][0]]; // tiene el id
				$sel_campo=$combo_rs->fields[$opt_sel[$num_valores][0]]; // tiene el id
				$name=$combo_rs->fields[$opt_name[$num_valores][0]]; // tiene lo que muestra al usuario			
					//print $name." k ";
				
				//	
				if($s_rs)					
				{//print $s_rs->fields[$opt_sel[$num_valores][0]]." == ".$sel_campo."  num_valores:".$num_valores."  arreglo: ".$opt_sel[$num_valores][0]."<br>";
					if($s_rs->fields[$opt_sel[$num_valores][0]]==$sel_campo)
					{
						$linea_input=$linea_input.$name;
						$value=$sel_campo;
						break;
					}
				}				
			$combo_rs->MoveNext();					
			}

			$linea_input=$linea_input."<input type='hidden' name='".$input[$edt]['name_input']."' id='".$input[$edt]['name_input']."'";
			$linea_input=$linea_input." value='".$value."'"; 
			$linea_input=$linea_input." />";
		}
		?>
			<script type="text/javascript" class="js-code-basic">
			$(document).ready(function() {
			<?php print $js;?>
			});
			</script>			
		<?php
	return $linea_input;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function Imprimir_mensaje($mensaje)
	{
		if(isset($mensaje))
		{
			if($mensaje!='')
			{
	?>
			<script language="JavaScript" type="text/javascript">alertify.log('<?php echo $mensaje;?>');</script>
	<?php
			}
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
	function reemplazar_caracter($string)
	{
		$string = str_replace( array("\\", "¨", "~", "|", "\"", "·", "$", "&", "?", "'", "¿", "[", "^", "`", "]", "}", "{", "¨", "´", ">“, “< ", ";"), '', $string );
		return $string;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x)
	{
		$mensaje="";$entro="";$where="";$comb="";$valor="";$name="";
		for($uni=0;$uni<sizeof($field_unico);$uni++) 
		{	//print $uni.' - '.$field_unico[$uni].'<br>';
			if($field_unico[$uni]==1 AND $_POST[$name_input[$uni]]!='')
			{
				$s_sql="SELECT ".$insert_field[$uni]." as ".$insert_alias[$uni]." FROM ".$tabla." WHERE ".$insert_field[$uni]."='".$_POST[$name_input[$uni]]."'";//print $s_sql.'<br>';
				$s_rs=$db->Execute($s_sql) or $db->ErrorMsg();
				
				//print $insert_alias[$uni].'<br>'.$s_rs;
			
				if($s_rs->fields[$insert_alias[$uni]]!='')
				{
					$mensaje=$mensaje."<br>El campo ".$label_input[$uni]." debe ser &uacute;nico";
				}
			
			}
			
			if($field_unico[$uni]!=1 AND $field_unico[$uni]!='' AND $valor!=$field_unico[$uni]) // para ver si hay un constrain
			{
				$valor=$field_unico[$uni];
				for($con=0;$con<sizeof($field_unico);$con++)
				{
					if($field_unico[$con]==$valor)					
					{
						if($tipo_input[$con]=='hidden')
						{
							if($entro==1){$where=$where." AND ";$comb=$comb." y la del campo ";}//print $con." ".$name_input[$con];
							$where=$where.$insert_field[$con]."='".$value_input[$con]."'"; // $con-1 ya que el id va antes del campo a mostrar
							$entro=1;
							$comb=$comb.$label_input[$con];
						}
						else
						{
							if($entro==1){$where=$where." AND ";$comb=$comb." y la del campo ";}//print $con." ".$name_input[$con]." - ".$_POST[$name_input[$con]];
							$where=$where.$insert_field[$con]."='".$_POST[$name_input[$con]]."'"; // $con-1 ya que el id va antes del campo a mostrar
							$entro=1;
							$comb=$comb.$label_input[$con];
						}
					}
				}
				$s_sql="SELECT ".$field[0]." as ".$insert_alias[0]." FROM ".$tabla." WHERE ".$where;//print $s_sql."<br>";//die();
				$s_rs=$db->Execute($s_sql) or die($db->ErrorMsg());
				
				if(isset($s_rs->fields[$insert_alias[0]]))
				{
					$mensaje=$mensaje."<br>La combinaci&oacute;n del campo ".$comb." ya existe, debe ser &uacute;nica";
				}
			}
		}//print $mensaje;die();
		
		if(!$mensaje)
		{		
			// consulta
			$entro="";
			$i_sql="INSERT INTO ".$tabla."(";
			for($fld=1;$fld<sizeof($insert_field);$fld++) // recorrido para crear el insert de los campos de la tabla, el 1er elemento es la llave, es autonumerico
			{
				if($insert_field[$fld])
				{
					if($entro==1)$i_sql=$i_sql.",";$i_sql=$i_sql.$insert_field[$fld];$entro=1;//solo los que tienen label, el id de la tabla es autonumerico
				}
			}
			
			$entro="";
			$i_sql=$i_sql.") VALUES(";
			for($val=1;$val<sizeof($name_input);$val++) // se recorren los inputs mostrados para crear los values de los campos
			{
				if($tipo_input[$val]=='file')
				{
					$binario_nombre_temporal=$_FILES[$name_input[$val]]['tmp_name'];//print $binario_nombre_temporal;
					if($binario_nombre_temporal) 
					$binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
					else
					$binario_contenido='';
					
					if($entro==1)$i_sql=$i_sql.",";$i_sql=$i_sql."'".$binario_contenido."'";$entro=1;//print $i_sql;//solo los que tienen label, el id de la tabla es autonumerico
				}
				elseif($tipo_input[$val]=='file_no_BD')
				{
					if(isset($_FILES[$name_input[$val]]['name']))
					{
						if($_FILES[$name_input[$val]]['name']!='')
						{
							$name=date('Y-m-d H-i-s').' '.$_FILES[$name_input[$val]]['name'];
							$target_path = $x.'archivos/'.$name;					
						
							if(!move_uploaded_file($_FILES[$name_input[$val]]['tmp_name'], $target_path)) $mensaje="El adjunto no se ha subido.";
						}
					}
				
					if($entro==1)$i_sql=$i_sql.",";$i_sql=$i_sql."'".utf8_decode($name)."'";$entro=1;//print $i_sql;//solo los que tienen label, el id de la tabla es autonumerico
				}
				elseif($tipo_input[$val]=='hidden')
				{
					$value=$this->reemplazar_caracter($value_input[$val]);
					if($entro==1)$i_sql=$i_sql.",";$i_sql=$i_sql."'".$value."'";$entro=1;//print $i_sql;//solo los que tienen label, el id de la tabla es autonumerico
				}
				elseif($insert_field[$val])
				{
					//print $name_input[$val];
					$value=$this->reemplazar_caracter($_POST[$name_input[$val]]);
					if($entro==1)$i_sql=$i_sql.",";$i_sql=$i_sql."'".$value."'";$entro=1;//print $i_sql;//solo los que tienen label, el id de la tabla es autonumerico
				}
			}
			$i_sql=$i_sql.")";//print $i_sql.'<br><br>';
		
			$db->Execute($i_sql) or die($db->ErrorMsg());
			
			$i_sql="SELECT LAST_INSERT_ID() AS myid";
			$rs=$db->Execute($i_sql) or die($db->ErrorMsg());//print $rs->fields['myid'];//die();
			
			if(!$mensaje)
			$mensaje="Los datos se han guardado satisfactoriamente.";
			// consulta
		}
		
		$return[0]=$mensaje;
		if(isset($rs))
		$return[1]=$rs->fields['myid'];
		
		return $return;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias)
	{
		$entro="";
		if ($mod!="")
		{
			$s_sql_where = " WHERE ".$insert_field[0]."='".$mod."'";
		}
		else
		{return '';}

		$s_sql="SELECT ";
		for($as=0;$as<sizeof($insert_field);$as++)
		{
			if(isset($insert_field[$as]) AND isset($insert_alias[$as]))
			{
				if($insert_field[$as]!='' AND $insert_alias[$as]!='')
				{
					if($entro==1)$s_sql=$s_sql.",";$s_sql=$s_sql.$insert_field[$as]." as ".$insert_alias[$as];$entro=1;
				}
			}
		}
		$s_sql=$s_sql." FROM ".$tabla.$s_sql_where;//print $s_sql.'<br><br><br>';//die();
		$s_rs = $db->Execute($s_sql) or die($db->ErrorMsg());//print $s_rs;
		return $s_rs;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------		
	function Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x)
	{
		$mensaje="";$entro="";$where="";$comb="";$valor="";$name="";
		
		for($uni=0;$uni<sizeof($field_unico);$uni++)
		{
			if($field_unico[$uni]==1)
			{
				$s_sql="SELECT ".$insert_field[$uni]." as ".$insert_alias[$uni]." FROM ".$tabla." WHERE ".$insert_field[$uni]."='".$_POST[$name_input[$uni]]."' AND ".$insert_field[0]."!='".$mod."' AND ".$insert_field[$uni]."!=''";//print $s_sql."<br>";//die();
				$s_rs=$db->Execute($s_sql) or $mensaje=$db->ErrorMsg();
			
				if($s_rs->fields[$insert_alias[$uni]]!='')
				{
					$mensaje=$mensaje."<br>El campo ".$label_input[$uni]." debe ser &uacute;nico";
				}			
			}
		
			
			if($field_unico[$uni]!=1 AND $field_unico[$uni]!='' AND $valor!=$field_unico[$uni]) // para ver si hay un constrain unique
			{
				$valor=$field_unico[$uni];
				for($con=0;$con<sizeof($field_unico);$con++)
				{
					if($field_unico[$con]==$valor)					
					{
						//print $tipo_input[$con].'<br>';
						if($tipo_input[$con]=='hidden')
						{
							if($entro==1){$where=$where." AND ";$comb=$comb." y la del campo ";}//print $con." ".$name_input[$con];
							$where=$where.$insert_field[$con]."='".$value_input[$con]."'"; // $con-1 ya que el id va antes del campo a mostrar
							$entro=1;
							$comb=$comb.$label_input[$con];
						}
						else
						{
							if($entro==1){$where=$where." AND ";$comb=$comb." y la del campo ";}//print $con." ".$name_input[$con].'<br>';
							$where=$where.$insert_field[$con]."='".$_POST[$name_input[$con]]."'"; // $con-1 ya que el id va antes del campo a mostrar
							$entro=1;
							$comb=$comb.$label_input[$con];
						}
					}
				}
				$s_sql="SELECT ".$field[0]." as ".$insert_alias[0]." FROM ".$tabla." WHERE ".$where." AND ".$field[0]."!='".$mod."'";//print $s_sql."<br><br>";//die();
				$s_rs=$db->Execute($s_sql) or $mensaje=$db->ErrorMsg();
				//print $insert_alias[0];
				if($s_rs->fields[$insert_alias[0]]!='')
				{
					$mensaje=$mensaje."<br>La combinaci&oacute;n del campo ".$comb." ya existe, debe ser &uacute;nica";
				}
			}
		}
		$entro="";
		if(!$mensaje)
		{
			// consulta
			$u_sql="UPDATE ".$tabla." SET ";
			for($fld=1;$fld<sizeof($insert_field);$fld++)
			{				
				if($tipo_input[$fld]=='file')
				{
					if($_FILES[$name_input[$fld]]['size'] > 1000000 ) 
					{
						echo "No se pueden subir archivos con pesos mayores a 1MB";//die();
					} 
					else 
					{
						$binario_nombre_temporal=$_FILES[$name_input[$fld]]['tmp_name'];//print $binario_nombre_temporal;
						if($binario_nombre_temporal)
						{
							$binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
							if($entro==1)$u_sql=$u_sql.", ";$u_sql=$u_sql.$insert_field[$fld]."='".$binario_contenido."'";$entro=1;//solo los que tienen label, el id de la tabla es autonumerico
						}						
					}
				}
				elseif($tipo_input[$fld]=='file_no_BD')
				{
					if(isset($_FILES[$name_input[$fld]]['name']))
					{
						if($_FILES[$name_input[$fld]]['name']!='')
						{
							$name=date('Y-m-d H-i-s').' '.$_FILES[$name_input[$fld]]['name'];
							$target_path = $x.'archivos/'.$name;					
						
							if(!move_uploaded_file($_FILES[$name_input[$fld]]['tmp_name'], $target_path)) $mensaje="El adjunto no se ha subido.";
						}
					}
					if($name!=''){if($entro==1)$u_sql=$u_sql.", ";$u_sql=$u_sql.$insert_field[$fld]."='".utf8_decode($name)."'";$entro=1;}//solo los que tienen label, el id de la tabla es autonumerico
				}
				elseif($tipo_input[$fld]=='hidden')
				{
					$value=$this->reemplazar_caracter($value_input[$fld]);
					if($entro==1)$u_sql=$u_sql.", ";$u_sql=$u_sql.$insert_field[$fld]."='".$value."'";$entro=1;//solo los que tienen label, el id de la tabla es autonumerico
				}
				elseif($insert_field[$fld])
				{
					$value=$this->reemplazar_caracter($_POST[$name_input[$fld]]);
					if($entro==1)$u_sql=$u_sql.", ";$u_sql=$u_sql.$insert_field[$fld]."='".$value."'";$entro=1;//solo los que tienen label, el id de la tabla es autonumerico
				}				
			}			
			$u_sql=$u_sql." WHERE ".$field[0]."='".$mod."'";//print $u_sql.'<br>';//die();			
			$db->Execute($u_sql) or $mensaje=$db->ErrorMsg();
		}
		return $mensaje;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------			
	function Consulta_eliminar($db,$tabla,$field,$var_aux)
	{
	$mensaje='';
		if(!empty($var_aux))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
		{ 
			//print $var_aux;
			$var = explode(",",$var_aux);		
			
			if(count($var) != 0)
			{
				for ($i = 0; $i < count($var); next($var), $i++) 
				{				
					$id = current($var);
					$d_sql= "DELETE FROM ".$tabla." WHERE ".$field[0]."='".$id."'";//print $d_sql;
					$d_rs = $db->Execute($d_sql) or $mensaje.="Hay datos que no se pueden eliminar, existen dependencias de lo que se desea eliminar.<br><br>".$db->ErrorMsg();				
				}
			} 
		}
		return $mensaje;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function Validar_reglas($db,$tabla,$field,$var_aux)
	{
		if(!empty($var_aux))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
		{ 
			$var = explode(",",$var_aux);		
			
			if(count($var) != 0)
			{
				for ($i = 0; $i < count($var); next($var), $i++) 
				{
				
					$id = current($var);
					
					if($tabla=='cargo_empleado')
					{
					
					}
					$d_sql= "DELETE FROM ".$tabla." WHERE ".$field[0]."='".$id."'";//print $d_sql;
					$d_rs = $db->Execute($d_sql) or die($db->ErrorMsg()."Este mensaje no es un error como tal, lo que sucede es que existen datos que dependen de lo que se quiere eliminar. Por tanto se debe proceder a eliminar las entradas dependientes. Dé click en el botón <- Atrás del navegador.");//print $a;print $query_rs_delete;	
				} 		
			} 
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------			
	function Cadena_grafico_linea($rs_y)
	{
		$datos='';
		$rs_y->MoveFirst();//print $rs_y->RecordCount();
		for($eje_y=0;$eje_y<$rs_y->RecordCount();)
		{//print " for: ".$eje_y;
			if($datos=='')
			{
				$leyenda_ant=$rs_y->fields['leyenda'];
				
				$datos="{name:'".$rs_y->fields['leyenda']."',data:[".round($rs_y->fields['valor'],2);
				$eje_y=$eje_y+1;//print " Y1: ".$eje_y;
				$rs_y->MoveNext();
				for($dat_y=1;$dat_y<$rs_y->RecordCount();$dat_y++)
				{
					if($leyenda_ant==$rs_y->fields['leyenda'])
					{
						$datos=$datos.",".round($rs_y->fields['valor'],2);
						$eje_y=$eje_y+1;//print " Y2: ".$eje_y;
						$rs_y->MoveNext();
					}
				}
				$datos=$datos."]";
			}	
			else
			{//print " Y3: ".$eje_y;
				$leyenda_ant=$rs_y->fields['leyenda'];
				
				$datos=$datos."},{name:'".$rs_y->fields['leyenda']."',data:[".round($rs_y->fields['valor'],2);
				$eje_y=$eje_y+1;//print " Y4: ".$eje_y;
				$rs_y->MoveNext();
				for($i=$eje_y;$i<$rs_y->RecordCount();$i++)
				{
					if($leyenda_ant==$rs_y->fields['leyenda'])
					{
						$datos=$datos.",".round($rs_y->fields['valor'],2);
						$eje_y=$eje_y+1;//print " Y5: ".$eje_y;
						$rs_y->MoveNext();
					}
				}
				$datos=$datos."]";
			}
		}
		$datos=$datos."}";
	return $datos;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
function interval_date($init,$finish)
{ //print $init.' - '.$finish;
    //formateamos las fechas a segundos tipo 1374998435
    $diferencia = strtotime($finish) - strtotime($init);
	//print $diferencia;
 
    //comprobamos el tiempo que ha pasado en segundos entre las dos fechas
    //floor devuelve el número entero anterior, si es 5.7 devuelve 5
    if($diferencia < 60){
        $tiempo = floor($diferencia) . " segundos";
    }else if($diferencia >= 60 && $diferencia < 3600){
        $tiempo = floor($diferencia/60) . " minutos'";
    }else if($diferencia >= 3600 && $diferencia < 86400){
        $tiempo = floor($diferencia/3600) . " horas";
    }else if($diferencia >= 86400 && $diferencia < 2592000){
        $tiempo = floor($diferencia/86400) . " d&iacute;as";
    }else if($diferencia >= 2592000 && $diferencia < 31104000){
        $tiempo = floor($diferencia/2592000) . " meses";
    }else if($diferencia >= 31104000){
        $tiempo = floor($diferencia/31104000) . " a&ntilde;os";
    }else{
        $tiempo = "Error";
    }
    return $tiempo;
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
function enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto)
{
	if($host!='' AND $port!='' AND $sec!='' AND $from!='' AND $pass!='' AND $name AND $para!='')
	{
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = $host;
		$mail->Port = $port;
		$mail->SMTPSecure = $sec;
		$mail->SMTPAuth = true;
		$mail->Username = $from;
		$mail->Password = $pass;
		$mail->setFrom($from, $name);
		
		$para = explode(";",$para);
		for($r=0;$r<count($para);$r++)
		{$mail->addAddress($para[$r]);}
		//print $body; die();
		if($asunto!='')$mail->Subject = $asunto;
		if($body!='')$mail->msgHTML($body);
		if($adjunto!='')$mail->addAttachment($adjunto);

		if(!$mail->send())
		echo "Error: " . $mail->ErrorInfo;
	}
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
	function Convertir_cualitativo($resultado,$tipo)
	{
		if($tipo=='des')
		{
			if($resultado>=0 AND $resultado<25)
			$cualitativo='No';
			
			elseif($resultado>=25 AND $resultado<50)
			$cualitativo='D';
			
			elseif($resultado>=50 AND $resultado<75)
			$cualitativo='C';
			
			elseif($resultado>=75 AND $resultado<100)
			$cualitativo='B';
			
			elseif($resultado=100)
			$cualitativo='A';
		}
		return $cualitativo;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
	function saldo_disponible($db,$id_punto_venta,$id_cliente)
	{
		if(isset($id_cliente))
		{
			$sql_s="select SUM(saldo) AS suma_saldo from saldo WHERE 1 AND id_punto_venta='".$id_punto_venta."'
			AND saldo.id_cliente='".$id_cliente."'";//print "<br><br>".$sql_s;
			$rs_s=$db->Execute($sql_s) or print $db->ErrorMsg();
				
			$suma_saldo=$rs_s->fields["suma_saldo"];//print "saldo final".$suma_saldo;	
			
			$sql_v="select id_venta, SUM(precio*cantidad) AS suma_venta from venta, cliente, producto_precio
			where venta.id_cliente=cliente.id_cliente AND venta.id_producto_precio=producto_precio.id_producto_precio
			and anulada='0' AND	id_punto_venta='".$id_punto_venta."' and cliente.id_cliente='".$id_cliente."'";//print "<br><br>".$sql_v;			
			$rs_v=$db->Execute($sql_v) or die($db->ErrorMsg());
								
			$suma_venta=$rs_v->fields["suma_venta"];//print "suma_venta: ".$suma_venta;		
			$saldo_disponible=bcsub($suma_saldo, $suma_venta, 14);

			return $saldo_disponible;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function saldo_disponible_x($db,$id_punto_venta,$id_cliente,$fecha_ini,$fecha_fin)
	{
		if(isset($id_cliente))
		{
			$sql_s="select SUM(saldo) AS suma_saldo from saldo WHERE 1 AND id_punto_venta='".$id_punto_venta."'
			AND saldo.id_cliente='".$id_cliente."'";//print "<br><br>".$sql_s;
			
			if($fecha_ini)
			$sql_s .= " and saldo.fecha_ingreso>='".$fecha_ini."'";
			if($fecha_fin)
			$sql_s .= " and saldo.fecha_ingreso<='".$fecha_fin."'";
			
			$rs_s=$db->Execute($sql_s) or print $db->ErrorMsg();
				
			$suma_saldo=$rs_s->fields["suma_saldo"];//print "saldo final".$suma_saldo;	
			
			$sql_v="select id_venta, SUM(precio*cantidad) AS suma_venta from venta, cliente, producto_precio
			where venta.id_cliente=cliente.id_cliente AND venta.id_producto_precio=producto_precio.id_producto_precio
			and anulada='0' AND	id_punto_venta='".$id_punto_venta."' and cliente.id_cliente='".$id_cliente."'";
			
			if($fecha_ini)
			$sql_v .= " and venta.fecha_venta>='".$fecha_ini."'";
			if($fecha_fin)
			$sql_v .= " and venta.fecha_venta<='".$fecha_fin."'";//print "<br><br>".$sql_v;
			
			$rs_v=$db->Execute($sql_v) or die($db->ErrorMsg());
								
			$suma_venta=$rs_v->fields["suma_venta"];//print "suma_venta: ".$suma_venta;		
			$saldo_disponible=bcsub($suma_saldo, $suma_venta, 14);

			return $saldo_disponible;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calculos_x_factura($db,$no_factura)
	{
		$sql_iva = "select no_factura, cantidad, precio, graba_iva, anulada, fecha_venta from venta, producto_precio WHERE 1 AND venta.id_producto_precio=producto_precio.id_producto_precio AND no_factura='".$no_factura."'";			
		$rs_iva=$db->Execute($sql_iva) or die($db->ErrorMsg());//print $sql_iva."<br>";

		if(isset($rs_iva))
		{
			if($rs_iva->Fields("anulada")==0)
			{
				if ($rs_iva->RecordCount() > 0)
				{
					$t0=0;
					$t12=0;	
					$total=0;
					$rs_iva->MoveFirst();
					$fecha_venta=$rs_iva->Fields("fecha_venta");
					
					while (!$rs_iva->EOF)
					{
						$precio=$rs_iva->Fields("precio");	
						$incluye_iva=$rs_iva->Fields("graba_iva");
						$cantidad=$rs_iva->Fields("cantidad");

						$pre_cant=bcmul($precio, $cantidad,14);

						if($incluye_iva==1)
						$t0=bcadd($t0,$pre_cant,14);
						else
						$t12=bcadd($t12,$pre_cant,14);//print $t12."<br>";				

						$total=bcadd($total,$pre_cant,14);	

					$rs_iva->MoveNext();					  
					}
				}
				
				if($fecha_venta<"2016-06-01 00:00:00")
				{
					$t12=bcdiv($t12, 1.12,14);//print "<br>t12 despues  ".$t12;
					$iva=bcmul($t12,0.12,14);//print "<br>iva despues  ".$iva;
					$subtotal=bcadd($t0,$t12,14);
				}
				elseif($fecha_venta>="2016-06-01")
				{
					$t12=bcdiv($t12, 1.14,14);//print "<br>t12 despues  ".$t12;
					$iva=bcmul($t12,0.14,14);//print "<br>iva despues  ".$iva;
					$subtotal=bcadd($t0,$t12,14);
				}

				//if($rs_iva->fields["anulada"]==0)		
				//$megatotal=bcadd($megatotal,number_format($total, 2, '.', ''), 2);//$megatotal=bcadd($megatotal,$total, 14);
				
				$valores[0]=number_format(round($subtotal,2), 2, ".", "");
				$valores[1]=number_format(round($t0,2), 2, ".", "");
				$valores[2]=number_format(round($t12,2), 2, ".", "");
				$valores[3]=number_format(round($iva,2), 2, ".", "");
				$valores[4]=number_format(round($total,2), 2, ".", "");
				
				return $valores;
			}
			else
			{
				$valores[0]='';
				$valores[1]='';
				$valores[2]='';
				$valores[3]='';
				$valores[4]='';
			}
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calculo_subtotal_x($db,$precio,$cantidad,$anulada)
	{		
		if($anulada==0)
		{
			$subtotal=number_format(bcmul($precio, $cantidad,14), 2, ".", "");
			
			$valores[0]=number_format($precio,2,".", "");
			$valores[1]=number_format($precio,2,".", "");
			$valores[2]=$cantidad;
			$valores[3]=number_format($subtotal,2,".", "");
			
			return $valores;
		}
		else
		{
			$valores[0]='';
			$valores[1]='';
			$valores[2]='';
			$valores[3]='';
			$valores[4]='';
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consumible_disponible($db,$id_articulo)
	{
		if(isset($id_articulo))
		{
			$sql_i="SELECT SUM(cantidad) AS cant_ingresada FROM inventario_consumibles WHERE 1 AND id_articulo='".$id_articulo."'";//print $sql_i;
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$sql_c="SELECT SUM(cantidad) AS cant_consumida FROM pedido_consumible WHERE 1 AND id_articulo='".$id_articulo."'";//print $sql_c;
			$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
			
			if(isset($rs_c->fields['cant_consumida'])){$cantidad=$rs_i->fields['cant_ingresada']-$rs_c->fields['cant_consumida'];}else $cantidad=$rs_i->fields['cant_ingresada'];

			return $cantidad;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function cuantos_estudiantes_clase($db,$id_clase)
	{
		if(isset($id_clase))
		{
			$sql_c="SELECT id_clase_estudiante FROM clase_estudiante WHERE 1 AND retirado='0' AND id_clase='".$id_clase."'";//print $sql_i;
			$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());

			if(isset($rs_c->fields['id_clase_estudiante'])){$cantidad=$rs_c->RecordCount();}else $cantidad=0;

			return $cantidad;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function devolver_celda_excel_litela($fila,$columna)
	{
		if($fila>0 && $columna>0)
		{
			$col[0]='A';$col[1]='B';$col[2]='C';$col[3]='D';$col[4]='E';$col[5]='F';$col[6]='G';$col[7]='H';$col[8]='I';$col[9]='J';
			$col[10]='K';$col[11]='L';$col[12]='M';$col[13]='N';$col[14]='O';$col[15]='P';$col[16]='Q';$col[17]='R';$col[18]='S';$col[19]='T';
			$col[20]='U';$col[21]='V';$col[22]='W';$col[23]='X';$col[24]='Y';$col[25]='Z';
			
			if($columna<=25)
			{
				$literal=$col[$columna].$fila;
			}
			else
			{
				$resto=bcdiv($columna,26,0);
				$segunda_parte=$columna-bcmul($resto,26,0);//print 'segunda_parte'.$segunda_parte;
				
				$literal=$col[$resto-1].$col[$segunda_parte].$fila;
			}

			return $literal;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------

}
?>