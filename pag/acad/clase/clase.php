<?php
class clase
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function asignaturas_clase($db, $x, $id_grado)
	{
?>
		
		
		<br>
		<div class='tabla_filtro' style='display:table;width:98%;margin-left:auto;margin-right:auto'>
		<div style='display:table-row;'>
		<div style='display:table-cell;'>
			<?php
			$this->filtro($id_grado);//print $js;
			?>
			
			<div class='tabla_listar' style='display:table;margin-left:auto;margin-right:auto;' id="tabla_asig_<?php print $id_grado;?>">
			<div style='display:table-row;'>
			<div style='display:table-cell;'>
		
			<?php 
			$this->tabla($db, $x, $id_grado,"");
			?>
			</div>
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
	function filtro($id_grado)
	{
	?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:99%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:100%;width:22px;text-align:left;padding:1%;'>
								<input onkeyup="ejecutar_ajax('filtrar_asignaturas.php','txt_filtro_<?php print $id_grado;?>,hdn_id_grado_<?php print $id_grado;?>', 'tabla_asig_<?php print $id_grado;?>');" name="txt_filtro_<?php print $id_grado;?>" id="txt_filtro_<?php print $id_grado;?>" type="text" size="30" placeholder="Filtrar"/>
								
								<input name="hdn_id_grado_<?php print $id_grado;?>" id="hdn_id_grado_<?php print $id_grado;?>" type="hidden" value="<?php print $id_grado;?>"/>
								
							</div>
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
	function tabla($db, $x, $id_grado, $rs)
	{
		$sql="SELECT id_asignatura as id_asignatura, abreviatura, asignatura FROM n_asignatura";
		if(!$rs){$rs=$db->Execute($sql) or die($db->ErrorMsg());}
		
		if(!isset($rs->fields['id_asignatura']))
		{
			?>
				<div style='display:table;margin-left:auto;margin-right:auto;width:100%;'>
					<div class='row1' style='display:table-row;'>
						<div style='display:table-cell;padding-left:2%;width:100%;'>No se encontraron resultados.</div>
					</div>
				</div>
			<?php
		}
		else
		{
			for($fila=0;$fila<$rs->RecordCount();$fila++)
			{
			?>
				<div style='display:table;margin-left:auto;margin-right:auto;width:100%;'>
					<div <?php if($fila % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
						<div style='display:table-cell;padding-left:2%;width:90%;'>
							<?php print $rs->fields['asignatura'];?>
						</div>
						<div class='flecha_derecha'style='display:table-cell;width:10%;aling:right;'>
							<a  id='vinculo_<?php print $rs->fields['id_asignatura'].$id_grado;?>' onclick="agregar_fila(<?php print $rs->fields['id_asignatura'].$id_grado;?>,<?php print $id_grado;?>)">
								<img src='<?php print $x;?>img/general/mini_flecha_der.png' width='16px' height='16px'/>
							</a>
					
							
							<input name="hdn_id_asig_<?php print $rs->fields['id_asignatura'].$id_grado;?>" id="hdn_id_asig_<?php print $rs->fields['id_asignatura'].$id_grado;?>" type="hidden" value="<?php print $rs->fields['id_asignatura'];?>"/>
							
							
						</div>
					</div>
				</div>
			<?php
			$rs->MoveNext();
			}
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function asignaturas_seleccionadas($db, $x, $id_grado)
	{
	
?>
		<br>
		<div class='tabla_filtro' style='display:table;width:98%;margin-left:auto;margin-right:auto'>
		<div style='display:table-row;'>
		<div style='display:table-cell;'>
		
			
			
			<div class='tabla_listar' style='display:table;margin-left:auto;margin-right:auto;padding-top:1%;' id="tabla_seleccionadas_<?php print $id_grado;?>">
			<div style='display:table-row;'>
			<div style='display:table-cell;'>
				<div style='display:table;margin-left:auto;margin-right:auto;width:100%;' id='no_asig_<?php print $id_grado;?>'>
				<div class='row1' style='display:table-row;'>
				<div style='display:table-cell;padding-left:2%;width:100%;font-weight:bold;'>
					No hay asignaturas seleccionadas para este curso.
				</div>
				</div>
				</div>
				
				<div style='display:none;margin-left:auto;margin-right:auto;width:100%;' id='pro_asig_<?php print $id_grado;?>'>
				<div class='row1' style='display:table-row;'>
				<div style='display:table-cell;padding-left:2%;width:5%;'></div>
				<div style='display:table-cell;padding-left:2%;width:40%;'></div>
				<div style='display:table-cell;padding-left:2%;width:55%;aling:center;font-weight:bold;'>
					Debe seleccionar un profesor para cada asignatura.
				</div>
				</div>
				</div>
				<?php
				$this->tabla_seleccionadas($db, $id_grado, $x);
				?>
			</div>
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
	function tabla_seleccionadas($db, $id_grado, $x)
	{
		$hay='';
		
		$sql="SELECT id_asignatura as id_asignatura, abreviatura, asignatura FROM n_asignatura";
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		$sql_grado="SELECT n_grado.abreviatura AS abv_gra FROM n_grado WHERE 1 AND id_grado='".$id_grado."'";
		$rs_grado=$db->Execute($sql_grado) or die($db->ErrorMsg());
		
		if(isset($rs->fields['asignatura']))
		{
			$sql_pro="select id_empleado_academico, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as empleado_academico 
			from empleado, persona, empleado_academico WHERE 1 AND persona.id_persona=empleado.id_persona AND empleado_academico.id_empleado=empleado.id_empleado ORDER BY primer_apellido, segundo_apellido, primer_nombre, segundo_nombre";
			$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());
			
			for($fila=0;$fila<$rs->RecordCount();$fila++)
			{//print $fila;
				$hay=$hay."<div style='display:none;margin-left:auto;margin-right:auto;width:100%;' id='".$rs->fields['id_asignatura'].$id_grado."'>";
					$hay=$hay."<div class='row_blanca' style='display:table-row;'>";
						
						$hay=$hay."<div style='display:table-cell;padding-left:2%;width:5%;'>";
							
							$id_grado_sel="tabla_seleccionadas_".$id_grado;
							
							$hay=$hay."<a  onclick='quitar_fila(".$rs->fields['id_asignatura'].$id_grado.",".$id_grado.")'>";
								$hay=$hay."<img src='".$x."img/general/mini_flecha_izq.png' width='16px' height='16px'/>";
							$hay=$hay."</a>";
							
						$hay=$hay."</div>";
						
						$hay=$hay."<div style='display:table-cell;padding-left:2%;width:40%;'>";
							$hay=$hay.$rs->fields['asignatura'];
						$hay=$hay."</div>";
						
						$hay=$hay."<div style='display:table-cell;width:55%;aling:center;'>";
									
							$hay=$hay."<select class='basic_single".$rs->fields['id_asignatura'].$id_grado."' name='sel_profesor_".$rs->fields['id_asignatura'].$id_grado."' title='Profesor de la asignatura: ".$rs->fields['asignatura']." en el curso: ".$rs_grado->fields['abv_gra']."' id='sel_profesor_".$rs->fields['id_asignatura'].$id_grado."'>";
								$hay=$hay."<option value=''>---Profesor de la asignatura: ".$rs->fields['asignatura']."---</option>";
								$rs_pro->MoveFirst();for($pro=0;$pro<$rs_pro->RecordCount();$pro++){
								$hay=$hay."<option value='".$rs_pro->fields['id_empleado_academico']."'";if(isset($_POST['sel_profesor'])){if($rs_pro->fields['id_empleado_academico']==$_POST['sel_profesor']){$hay=$hay."selected='selected'";}}$hay=$hay.">".$rs_pro->fields['empleado_academico']."</option>";
								$rs_pro->MoveNext();}
							$hay=$hay."</select>";
							
							$hay=$hay."<input name='hdn_id_asig_".$rs->fields['id_asignatura'].$id_grado."' id='hdn_id_asig_".$rs->fields['id_asignatura'].$id_grado."' type='hidden' value='".$rs->fields['id_asignatura']."'/>";
						$hay=$hay."</div>";
						
					$hay=$hay."</div>";
				$hay=$hay."</div>";
				
				
			
			$rs->MoveNext();
			}print $hay;
		}
	//$hay=$hay.$resto;print $resto;
	
	//print "<script type='text/javascript'>".$js."alert('si ejecuta');</script>";
	?>
	<input name="hdn_resto_tabla_<?php print $id_grado;?>" id="hdn_resto_tabla_<?php print $id_grado;?>" type="hidden" value="<?php print $hay;?>"/>
	
	

	
	<?php
	}
}
?>
