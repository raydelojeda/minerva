<?php
class reportes
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_libreta($db, $id_grado, $id_paralelo)
	{
		$sql_est="SELECT estudiante.id_estudiante as id_estudiante, curso_grado_paralelo_est.id_curso_grado_paralelo_est, n_grado_paralelo.id_grado_paralelo, n_grado_paralelo.abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
		FROM persona, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico 
		WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND persona.id_persona=estudiante.id_persona 
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
		AND n_grado_paralelo.id_grado='".$id_grado."'
		AND n_grado_paralelo.id_paralelo='".$id_paralelo."'
		ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
	?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:99%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:100%;width:22px;text-align:left;padding:1%;'>
								<?php
									//$parametros_extras="onChange=\"ejecutar_ajax('r_libreta/exportar_pdf_libreta.php','sel_estudiante_".$id_gra_par."', 'reportes');\"";
									$rs_p->MoveFirst();$cadena1="";$cadena2='';
									for($p=0;$p<$rs_p->RecordCount();$p++)
									{
										$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];

										$cadena1=$cadena1."if(document.getElementById('cbx_periodo_".$id_gra_par.$id_periodo_evaluativo."').checked)valor_".$id_gra_par.$id_periodo_evaluativo."=".$id_periodo_evaluativo.";else valor_".$id_gra_par.$id_periodo_evaluativo."=0;";
										$cadena2=$cadena2."+'&val".$p."='+valor_".$id_gra_par.$id_periodo_evaluativo;
							
									$rs_p->MoveNext();
									}
									
									$cadena3="var indice = document.frm.sel_estudiante_".$id_gra_par.".selectedIndex;var valor = document.frm.sel_estudiante_".$id_gra_par.".options[indice].value;if(valor==0)return false;location.href='r_libreta/exportar_pdf_libreta.php?id='+valor";
									
									$parametros_extras="onChange=\"".$cadena1.$cadena3.$cadena2.";\"";
									$this->select_filtro_est($rs_est, $parametros_extras, $id_gra_par);
									
									$rs_p->MoveFirst();
									for($p=0;$p<$rs_p->RecordCount();$p++)
									{	
										$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
										$abv_periodo=$rs_p->fields['abv_periodo'];
										print $abv_periodo.': ';
								?>
										<input name="cbx_periodo_<?php print $id_gra_par.$id_periodo_evaluativo;?>" checked="checked" id="cbx_periodo_<?php print $id_gra_par.$id_periodo_evaluativo;?>" type="checkbox" value="<?php print $id_periodo_evaluativo;?>"/>&nbsp;&nbsp;
								<?php
									$rs_p->MoveNext();
									}
								?>	
								<input name="hdn_id_grado_<?php print $id_gra_par;?>" id="hdn_id_grado_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_grado;?>"/>
								<input name="hdn_id_paralelo_<?php print $id_gra_par;?>" id="hdn_id_paralelo_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_paralelo;?>"/>
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
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_est($rs_est, $parametros_extras, $id_gra_par)
	{
		$ids='';
		$rs_est->MoveFirst();
		for($c=0;$c<$rs_est->RecordCount();$c++)
		{
			if($ids=='')
			$ids=$rs_est->fields['id_estudiante'];
			else
			$ids.='-'.$rs_est->fields['id_estudiante'];
		$rs_est->MoveNext();
		}
	?>	<select class="sel_estudiante_<?php print $id_gra_par;?>" name="sel_estudiante_<?php print $id_gra_par;?>" id="sel_estudiante_<?php print $id_gra_par;?>" <?php print $parametros_extras;?>>
			<option value="0">----------------------------Estudiante----------------------------</option>
			<option value="<?php print $ids;?>">-------------------------------Todos------------------------------</option>
			<?php $rs_est->MoveFirst();for($c=0;$c<$rs_est->RecordCount();$c++){?>
			
				<option value="<?php print $rs_est->fields['id_estudiante'];?>"><?php print $rs_est->fields['estudiante'];?></option>
				
			<?php $rs_est->MoveNext();}?>
		</select>&nbsp;&nbsp;
		<script type="text/javascript" class="js-code-basic">
			$(".sel_estudiante_<?php print $id_gra_par;?>").select2();
		</script>
	<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_cuadro_juntas($db, $id_grado, $id_paralelo)
	{
		$sql_est="SELECT estudiante.id_estudiante as id_estudiante, curso_grado_paralelo_est.id_curso_grado_paralelo_est, n_grado_paralelo.id_grado_paralelo, n_grado_paralelo.abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
		FROM persona, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico 
		WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND persona.id_persona=estudiante.id_persona 
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
		AND n_grado_paralelo.id_grado='".$id_grado."'
		AND n_grado_paralelo.id_paralelo='".$id_paralelo."'
		ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
	?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:99%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:100%;width:22px;text-align:left;padding:1%;'>
								<?php
									//$parametros_extras="onChange=\"ejecutar_ajax('r_libreta/exportar_pdf_libreta.php','sel_estudiante_".$id_gra_par."', 'reportes');\"";
									$rs_p->MoveFirst();$cadena1="";$cadena2='';
									for($p=0;$p<$rs_p->RecordCount();$p++)
									{
										$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];

										$cadena1=$cadena1."if(document.getElementById('cbx_periodo_cuadro_juntas_".$id_gra_par.$id_periodo_evaluativo."').checked)valor_".$id_gra_par.$id_periodo_evaluativo."=".$id_periodo_evaluativo.";else valor_".$id_gra_par.$id_periodo_evaluativo."=0;";
										$cadena2=$cadena2."+'&val".$p."='+valor_".$id_gra_par.$id_periodo_evaluativo;
							
									$rs_p->MoveNext();
									}
									
									$cadena3="var indice = document.frm.sel_estudiante_cuadro_juntas_".$id_gra_par.".selectedIndex;var valor = document.frm.sel_estudiante_cuadro_juntas_".$id_gra_par.".options[indice].value;if(valor==0)return false;location.href='r_cuadro_juntas/exportar_pdf_cuadro_juntas.php?id='+valor";
									
									$parametros_extras="onChange=\"".$cadena1.$cadena3.$cadena2.";\"";
									$this->select_filtro_est_cuadro_juntas($rs_est, $parametros_extras, $id_gra_par);
									
									$rs_p->MoveFirst();
									for($p=0;$p<$rs_p->RecordCount();$p++)
									{	
										$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
										$abv_periodo=$rs_p->fields['abv_periodo'];
										print $abv_periodo.': ';
								?>
										<input name="cbx_periodo_cuadro_juntas_<?php print $id_gra_par.$id_periodo_evaluativo;?>" checked="checked" id="cbx_periodo_cuadro_juntas_<?php print $id_gra_par.$id_periodo_evaluativo;?>" type="checkbox" value="<?php print $id_periodo_evaluativo;?>"/>&nbsp;&nbsp;
								<?php
									$rs_p->MoveNext();
									}
								?>	
								<input name="hdn_id_grado_cuadro_juntas_<?php print $id_gra_par;?>" id="hdn_id_grado_cuadro_juntas_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_grado;?>"/>
								<input name="hdn_id_paralelo_cuadro_juntas_<?php print $id_gra_par;?>" id="hdn_id_paralelo_cuadro_juntas_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_paralelo;?>"/>
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
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_est_cuadro_juntas($rs_est, $parametros_extras, $id_gra_par)
	{
		$ids='';
		$rs_est->MoveFirst();
		for($c=0;$c<$rs_est->RecordCount();$c++)
		{
			if($ids=='')
			$ids=$rs_est->fields['id_estudiante'];
			else
			$ids.='-'.$rs_est->fields['id_estudiante'];
		$rs_est->MoveNext();
		}
	?>	<select class="sel_estudiante_cuadro_juntas_<?php print $id_gra_par;?>" name="sel_estudiante_cuadro_juntas_<?php print $id_gra_par;?>" id="sel_estudiante_cuadro_juntas_<?php print $id_gra_par;?>" <?php print $parametros_extras;?>>
			<option value="0">----------------------------Estudiante----------------------------</option>
			<option value="<?php print $ids;?>">-------------------------------Todos------------------------------</option>
			<?php $rs_est->MoveFirst();for($c=0;$c<$rs_est->RecordCount();$c++){?>
			
				<option value="<?php print $rs_est->fields['id_estudiante'];?>"><?php print $rs_est->fields['estudiante'];?></option>
				
			<?php $rs_est->MoveNext();}?>
		</select>&nbsp;&nbsp;
		<script type="text/javascript" class="js-code-basic">
			$(".sel_estudiante_cuadro_juntas_<?php print $id_gra_par;?>").select2();
		</script>
	<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_promocion($db, $id_grado, $id_paralelo)
	{
		$sql_est="SELECT estudiante.id_estudiante as id_estudiante, curso_grado_paralelo_est.id_curso_grado_paralelo_est, n_grado_paralelo.id_grado_paralelo, n_grado_paralelo.abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
		FROM persona, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico 
		WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND persona.id_persona=estudiante.id_persona 
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
		AND n_grado_paralelo.id_grado='".$id_grado."'
		AND n_grado_paralelo.id_paralelo='".$id_paralelo."'
		ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
	?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:99%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:100%;width:22px;text-align:left;padding:1%;'>
								<?php
									$cadena3="var indice = document.frm.sel_estudiante_promocion_".$id_gra_par.".selectedIndex;var valor = document.frm.sel_estudiante_promocion_".$id_gra_par.".options[indice].value;if(valor==0)return false;location.href='r_promocion/exportar_pdf_promocion.php?id='+valor";
									
									$parametros_extras="onChange=\"".$cadena3.";\"";
									$this->select_filtro_est_promocion($rs_est, $parametros_extras, $id_gra_par);
								?>	
								<input name="hdn_id_grado_promocion_<?php print $id_gra_par;?>" id="hdn_id_grado_promocion_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_grado;?>"/>
								<input name="hdn_id_paralelo_promocion_<?php print $id_gra_par;?>" id="hdn_id_paralelo_promocion_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_paralelo;?>"/>
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
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_est_promocion($rs_est, $parametros_extras, $id_gra_par)
	{
		$ids='';
		$rs_est->MoveFirst();
		for($c=0;$c<$rs_est->RecordCount();$c++)
		{
			if($ids=='')
			$ids=$rs_est->fields['id_estudiante'];
			else
			$ids.='-'.$rs_est->fields['id_estudiante'];
		$rs_est->MoveNext();
		}
	?>	<select class="sel_estudiante_promocion_<?php print $id_gra_par;?>" name="sel_estudiante_promocion_<?php print $id_gra_par;?>" id="sel_estudiante_promocion_<?php print $id_gra_par;?>" <?php print $parametros_extras;?>>
			<option value="0">----------------------------Estudiante----------------------------</option>
			<option value="<?php print $ids;?>">-------------------------------Todos------------------------------</option>
			<?php $rs_est->MoveFirst();for($c=0;$c<$rs_est->RecordCount();$c++){?>
			
				<option value="<?php print $rs_est->fields['id_estudiante'];?>"><?php print $rs_est->fields['estudiante'];?></option>
				
			<?php $rs_est->MoveNext();}?>
		</select>&nbsp;&nbsp;
		<script type="text/javascript" class="js-code-basic">
			$(".sel_estudiante_promocion_<?php print $id_gra_par;?>").select2();
		</script>
	<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_matricula($db, $id_grado, $id_paralelo)
	{
		$sql_est="SELECT estudiante.id_estudiante as id_estudiante, curso_grado_paralelo_est.id_curso_grado_paralelo_est, n_grado_paralelo.id_grado_paralelo, n_grado_paralelo.abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
		FROM persona, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico 
		WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND persona.id_persona=estudiante.id_persona 
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
		AND n_grado_paralelo.id_grado='".$id_grado."'
		AND n_grado_paralelo.id_paralelo='".$id_paralelo."'
		ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
	?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:99%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:100%;width:22px;text-align:left;padding:1%;'>
								<?php
									$cadena3="var indice = document.frm.sel_estudiante_matricula_".$id_gra_par.".selectedIndex;var valor = document.frm.sel_estudiante_matricula_".$id_gra_par.".options[indice].value;if(valor==0)return false;location.href='../estudiante/planilla_matricula.php?id='+valor";
									
									$parametros_extras="onChange=\"".$cadena3.";\"";
									$this->select_filtro_est_matricula($rs_est, $parametros_extras, $id_gra_par);
								?>	
								<input name="hdn_id_grado_matricula_<?php print $id_gra_par;?>" id="hdn_id_grado_matricula_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_grado;?>"/>
								<input name="hdn_id_paralelo_matricula_<?php print $id_gra_par;?>" id="hdn_id_paralelo_matricula_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_paralelo;?>"/>
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
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_est_matricula($rs_est, $parametros_extras, $id_gra_par)
	{
		$ids='';
		$rs_est->MoveFirst();
		for($c=0;$c<$rs_est->RecordCount();$c++)
		{
			if($ids=='')
			$ids=$rs_est->fields['id_estudiante'];
			else
			$ids.='-'.$rs_est->fields['id_estudiante'];
		$rs_est->MoveNext();
		}
	?>	<select class="sel_estudiante_matricula_<?php print $id_gra_par;?>" name="sel_estudiante_matricula_<?php print $id_gra_par;?>" id="sel_estudiante_matricula_<?php print $id_gra_par;?>" <?php print $parametros_extras;?>>
			<option value="0">----------------------------Estudiante----------------------------</option>
			<option value="<?php print $ids;?>">-------------------------------Todos------------------------------</option>
			<?php $rs_est->MoveFirst();for($c=0;$c<$rs_est->RecordCount();$c++){?>
			
				<option value="<?php print $rs_est->fields['id_estudiante'];?>"><?php print $rs_est->fields['estudiante'];?></option>
				
			<?php $rs_est->MoveNext();}?>
		</select>&nbsp;&nbsp;
		<script type="text/javascript" class="js-code-basic">
			$(".sel_estudiante_matricula_<?php print $id_gra_par;?>").select2();
		</script>
	<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_ministerial($db, $id_grado, $id_paralelo)
	{
		$sql_est="SELECT estudiante.id_estudiante as id_estudiante, curso_grado_paralelo_est.id_curso_grado_paralelo_est, n_grado_paralelo.id_grado_paralelo, n_grado_paralelo.abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
		FROM persona, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico 
		WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND persona.id_persona=estudiante.id_persona 
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
		AND n_grado_paralelo.id_grado='".$id_grado."'
		AND n_grado_paralelo.id_paralelo='".$id_paralelo."'
		ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
	?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:99%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:100%;width:22px;text-align:left;padding:1%;'>
								<?php
									//$parametros_extras="onChange=\"ejecutar_ajax('r_libreta/exportar_pdf_libreta.php','sel_estudiante_".$id_gra_par."', 'reportes');\"";
									$rs_p->MoveFirst();$cadena1="";$cadena2='';
									for($p=0;$p<$rs_p->RecordCount();$p++)
									{
										$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];

										$cadena1=$cadena1."if(document.getElementById('cbx_periodo_ministerial_".$id_gra_par.$id_periodo_evaluativo."').checked)valor_".$id_gra_par.$id_periodo_evaluativo."=".$id_periodo_evaluativo.";else valor_".$id_gra_par.$id_periodo_evaluativo."=0;";
										$cadena2=$cadena2."+'&val".$p."='+valor_".$id_gra_par.$id_periodo_evaluativo;
							
									$rs_p->MoveNext();
									}
									
									$cadena3="var indice = document.frm.sel_estudiante_ministerial_".$id_gra_par.".selectedIndex;var valor = document.frm.sel_estudiante_ministerial_".$id_gra_par.".options[indice].value;if(valor==0)return false;location.href='r_ministerial/exportar_pdf_ministerial.php?id='+valor";
									
									$parametros_extras="onChange=\"".$cadena1.$cadena3.$cadena2.";\"";
									$this->select_filtro_est_ministerial($rs_est, $parametros_extras, $id_gra_par);
									
									$rs_p->MoveFirst();
									for($p=0;$p<$rs_p->RecordCount();$p++)
									{	
										$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
										$abv_periodo=$rs_p->fields['abv_periodo'];
										print $abv_periodo.': ';
								?>
										<input name="cbx_periodo_ministerial_<?php print $id_gra_par.$id_periodo_evaluativo;?>" checked="checked" id="cbx_periodo_ministerial_<?php print $id_gra_par.$id_periodo_evaluativo;?>" type="checkbox" value="<?php print $id_periodo_evaluativo;?>"/>&nbsp;&nbsp;
								<?php
									$rs_p->MoveNext();
									}
								?>	
								<input name="hdn_id_grado_ministerial_<?php print $id_gra_par;?>" id="hdn_id_grado_ministerial_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_grado;?>"/>
								<input name="hdn_id_paralelo_ministerial_<?php print $id_gra_par;?>" id="hdn_id_paralelo_ministerial_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_paralelo;?>"/>
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
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_est_ministerial($rs_est, $parametros_extras, $id_gra_par)
	{
		$ids='';
		$rs_est->MoveFirst();
		for($c=0;$c<$rs_est->RecordCount();$c++)
		{
			if($ids=='')
			$ids=$rs_est->fields['id_estudiante'];
			else
			$ids.='-'.$rs_est->fields['id_estudiante'];
		$rs_est->MoveNext();
		}
	?>	<select class="sel_estudiante_ministerial_<?php print $id_gra_par;?>" name="sel_estudiante_ministerial_<?php print $id_gra_par;?>" id="sel_estudiante_ministerial_<?php print $id_gra_par;?>" <?php print $parametros_extras;?>>
			<option value="0">----------------------------Estudiante----------------------------</option>
			<option value="<?php print $ids;?>">-------------------------------Todos------------------------------</option>
			<?php $rs_est->MoveFirst();for($c=0;$c<$rs_est->RecordCount();$c++){?>
			
				<option value="<?php print $rs_est->fields['id_estudiante'];?>"><?php print $rs_est->fields['estudiante'];?></option>
				
			<?php $rs_est->MoveNext();}?>
		</select>&nbsp;&nbsp;
		<script type="text/javascript" class="js-code-basic">
			$(".sel_estudiante_ministerial_<?php print $id_gra_par;?>").select2();
		</script>
	<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
}
?>
