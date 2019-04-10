<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

$repre_econ=0;

if(isset($_POST[$inputs[0]['name_input']]))
{
	include($x."pag/rrhh/persona/variables.php");
	$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
	
	
	if(isset($return[1]) AND $return[1]!='')
	{	
		$id_persona=$return[1];
		include("variables.php");
		$return=$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
		
		if(isset($return[1]) AND $return[1]!='')
		{
			$id_estudiante=$return[1];
			
			include($x."pag/acad/direccion_estudiante/variables.php");
			$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
			
			include($x."pag/acad/datos_clinicos/variables.php");
			
			$tipo_input[1]='hidden';
			$tipo_input[2]='';
			$value_input[1]=$id_estudiante;
			$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);
			$obj->Consulta_insert($field_unico,$tabla,$field,$label_input,$db,$insert_alias,$name_input,$insert_field,$tipo_input,$value_input,$x);
						
			for($f=1;$f<=5;$f++) 
			{
				if(isset($_POST['sel_fam_'.$f]))
				{
					if($_POST['sel_fam_'.$f]!=0)
					{
						if(isset($_POST['sel_par_'.$f]))
						{
							if($_POST['sel_par_'.$f]!=0)
							{	//print $_POST['sel_par_'.$f];
								$sel_fam=$_POST['sel_fam_'.$f];
								$sel_par=$_POST['sel_par_'.$f];
								if(isset($_POST['cbx_leg_'.$f]))$cbx_leg=$_POST['cbx_leg_'.$f];elseif($f==1)$cbx_leg=1;else $cbx_leg=0;
								if(isset($_POST['cbx_aca_'.$f]))$cbx_aca=$_POST['cbx_aca_'.$f];else $cbx_aca=0;
								if(isset($_POST['cbx_eco_'.$f]))$cbx_eco=$_POST['cbx_eco_'.$f];else $cbx_eco=0;
								if(isset($_POST['cbx_con_'.$f]))$cbx_con=$_POST['cbx_con_'.$f];else $cbx_con=0;
								if(isset($_POST['cbx_pue_'.$f]))$cbx_pue=$_POST['cbx_pue_'.$f];else $cbx_pue=0;
								if(isset($_POST['cbx_eme_'.$f]))$cbx_eme=$_POST['cbx_eme_'.$f];else $cbx_eme=0;
								
								$sql_f="SELECT familiar.id_familiar FROM familiar, persona WHERE 1 AND persona.id_persona=familiar.id_persona
								AND persona.id_persona='".$sel_fam."'";//print $sql_f; die();
								$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());

								if(!isset($rs_f->fields['id_familiar']))
								{								
									$ins_p="INSERT INTO familiar(id_persona) 
									VALUES ('".$sel_fam."')";//print $ins."<br>";
									$db->Execute($ins_p) or die($db->ErrorMsg());
									
									$i_sql="SELECT LAST_INSERT_ID() AS myid";
									$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
									
									$id_familiar=$rs->fields['myid'];
								}
								else
								$id_familiar=$rs_f->fields['id_familiar'];
								
								$ins="INSERT INTO familiar_estudiante (id_familiar, id_estudiante, id_parentesco, representante_legal, representante_aca, representante_eco, convive, puede_retirar, contacto_emergencia) 
								VALUES ('".$id_familiar."','".$return[1]."','".$sel_par."','".$cbx_leg."','".$cbx_aca."','".$cbx_eco."','".$cbx_con."','".$cbx_pue."','".$cbx_eme."')";//print $ins."<br>";die();
								$db->Execute($ins) or die($db->ErrorMsg());
							}
							else
							$mensaje='Debe escoger el parentesco del familiar '.$f;
						}
						else
						$mensaje='Debe escoger el parentesco del familiar '.$f;
					}
				}
			}
		}
	}
	
	if(isset($return[0]) AND $mensaje=='')
	$mensaje=$return[0];
	$obj->Imprimir_mensaje($mensaje);
	$mensaje='';
	$return[0]='';
	
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<script type="text/javascript" class="js-code-basic">
$(document).ready(function() {
$(".js-basic-single_fam_1").select2();
$(".js-basic-single_fam_2").select2();
$(".js-basic-single_fam_3").select2();
$(".js-basic-single_fam_4").select2();
$(".js-basic-single_fam_5").select2();
});
</script>
&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

<script language="JavaScript" type="text/javascript">
function agregar() 
{
	for (i=3;i<=5;i++)
	{
		obj = document.getElementById('fam_' + i);//alert('fam_' + i);alert(obj.style.display);
		if(obj.style.display=='none')
		{
			obj.style.display = 'table-row';
			i=5;
		}
	}
}

function valida_parentesco() 
{
	msg='';
	for (i=1;i<=5;i++)
	{ //alert (eval('document.frm.sel_fam_' + i + '.value'));
		
		
		if(eval('document.frm.sel_fam_' + i + '.value')!=0 && eval('document.frm.sel_par_' + i + '.value')==0)
		{
			if(msg!='')msg=msg+'<br>';
			
			msg=msg+'Debe escoger el parentesco del familiar '+i;
		}
	}
	if(msg!='')
	{
		alertify.error(msg);
	}
	else <?php print $onsubmit;?>	
}
</script>
<tr>
<td>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Datos personales</h2>			

			<?php
			print "<div style='float:right;'><input name='cedula' type='text' size='42' style='border: 0px; background-color:ffffff; text-decoration:italic;' onfocus='blur();'></div>";
			include($x."pag/rrhh/persona/variables.php");
			$tipo_input[7]='hidden';
			$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
			
		</div>
		
		<script language="JavaScript" type="text/javascript">
			valida_cedula();
		</script>
		
		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Direcci&oacute;n</h2>			
			
			
			<?php
			include($x."pag/acad/direccion_estudiante/variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
			
		</div>

		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Datos adicionales</h2>			
			
			<?php
			include("variables.php");
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
			
		</div>
		
		<div class="tab-page" id="tabPage3">
			<h2 class="tab">Familiares</h2>			
			
			<div style='display:table;width:100%;'>
			
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:48%;text-align:left;padding-left: 1%;'></div>
					<div style='display:table-cell;height:22px;width:8%;text-align:left;'></div>
					<div style='display:table-cell;height:15px;width:24%;text-align:center;border-bottom: 1px solid black; position: absolute;'>Representante</div>
					<div style='display:table-cell;height:32px;width:7%;text-align:left;'>&nbsp;</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:left;'>&nbsp;</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:left;'>&nbsp;</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:left;'>&nbsp;</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:left;'>&nbsp;</div>
					<div style='display:table-cell;height:22px;width:9%;text-align:left;'>&nbsp;</div>
				</div>
			
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:48%;text-align:left;padding-left: 1%;'>Familiar&nbsp;<a onMouseOver="return overlib('<?php print $msg_fam;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a></div>
					<div style='display:table-cell;height:22px;width:8%;text-align:left;'>Parentesco</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:center;'>&iquest;Legal?</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:center;'>&iquest;Acad&eacute;mico?</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:center;'>&iquest;Econ&oacute;mico?</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:center;'>&iquest;Convive?</div>
					<div style='display:table-cell;height:22px;width:7%;text-align:center;'>&iquest;Puede retirar?</div>
					<div style='display:table-cell;height:22px;width:9%;text-align:center;'>&iquest;Contacto emergencia?</div>
				</div>
				
				<?php
				$sql_f="SELECT persona.id_persona, primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,identificacion	FROM persona, usuario 
				WHERE persona.id_persona=usuario.id_persona AND usuario='".$_SESSION["user"]."'";
				$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
				
				$sql_p="SELECT id_parentesco, parentesco FROM n_parentesco";
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());					
				?>
				
				<div id='fam_1' style='display:<?php if($f>2)print 'none';else print 'table-row';?>;'>
					
					<div style='display:table-cell;height:22px;text-align:left;padding-left: 1%;'>
						<select class="js-basic-single_fam_1" name="sel_fam_1" id="sel_fam_1">
							<?php $rs_f->MoveFirst();for($e=0;$e<$rs_f->RecordCount();$e++){?>					
								<option value="<?php print $rs_f->fields['id_persona'];?>"> <?php print $rs_f->fields['primer_apellido'].' '.$rs_f->fields['segundo_apellido'].' '.$rs_f->fields['primer_nombre'].' '.$rs_f->fields['segundo_nombre'].' - '.$rs_f->fields['identificacion'];?> </option>						
							<?php $rs_f->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<select name="sel_par_1" id="sel_par_1">
							<option value='0'>---Seleccionar---</option>
							<?php $rs_p->MoveFirst();for($e=0;$e<$rs_p->RecordCount();$e++){?>					
								<option value="<?php print $rs_p->fields['id_parentesco'];?>"> <?php print $rs_p->fields['parentesco'];?> </option>						
							<?php $rs_p->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:center;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_leg_1' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_leg_1" disabled />
								<label for="cbx_leg_1"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_aca_1' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_aca_1" />
								<label for="cbx_aca_1"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_eco_1' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_eco_1" />
								<label for="cbx_eco_1"></label>
							</div>
						</section>
					</div>
						
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_con_1' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_con_1" />
								<label for="cbx_con_1"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_pue_1' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_pue_1" />
								<label for="cbx_pue_1"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_eme_1' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_eme_1" />
								<label for="cbx_eme_1"></label>
							</div>
						</section>
					</div>
					
				</div>
				
				<?php
				$sql_f="SELECT persona.id_persona, primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,identificacion	FROM persona";
				$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
				
				for($f=2;$f<=5;$f++)
				{						
				?>			
				<div id='fam_<?php print $f;?>' style='display:<?php if($f>2)print 'none';else print 'table-row';?>;'>
					
					<div style='display:table-cell;height:22px;text-align:left;padding-left: 1%;'>
						<select class="js-basic-single_fam_<?php echo $f;?>" name="sel_fam_<?php print $f;?>" id="sel_fam_<?php print $f;?>">
							<option value='0'>----------------------Seleccionar----------------------</option>
							<?php $rs_f->MoveFirst();for($e=0;$e<$rs_f->RecordCount();$e++){?>					
								<option value="<?php print $rs_f->fields['id_persona'];?>"> <?php print $rs_f->fields['primer_apellido'].' '.$rs_f->fields['segundo_apellido'].' '.$rs_f->fields['primer_nombre'].' '.$rs_f->fields['segundo_nombre'].' - '.$rs_f->fields['identificacion'];?> </option>						
							<?php $rs_f->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<select name="sel_par_<?php print $f;?>" id="sel_par_<?php print $f;?>">
							<option value='0'>---Seleccionar---</option>
							<?php $rs_p->MoveFirst();for($e=0;$e<$rs_p->RecordCount();$e++){?>					
								<option value="<?php print $rs_p->fields['id_parentesco'];?>"> <?php print $rs_p->fields['parentesco'];?> </option>						
							<?php $rs_p->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:center;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_leg_<?php print $f;?>' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_leg_<?php print $f;?>" />
								<label for="cbx_leg_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_aca_<?php print $f;?>' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_aca_<?php print $f;?>" />
								<label for="cbx_aca_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_eco_<?php print $f;?>' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_eco_<?php print $f;?>" />
								<label for="cbx_eco_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
						
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_con_<?php print $f;?>' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_con_<?php print $f;?>" />
								<label for="cbx_con_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_pue_<?php print $f;?>' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_pue_<?php print $f;?>" />
								<label for="cbx_pue_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input class="checkbox_oculto" name='cbx_eme_<?php print $f;?>' value='1' <?php if($f<3)print 'checked';?> type="checkbox" id="cbx_eme_<?php print $f;?>" />
								<label for="cbx_eme_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
				</div>
				
				<?php
				}

				if($visualizar!=1)
				{
				?>
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;padding-left: 1%;padding-top: 1%;'><a onclick='javascript:agregar();'><div class='boton' style='display:height:22px;width:110px;text-align:center;'>+ Agregar</div></a></div>
				</div>
				<?php }?>
			</div>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Datos cl&iacute;nicos</h2>			

			<?php
			include($x."pag/acad/datos_clinicos/variables.php");
			$tipo_input[1]='hidden';
			$tipo_input[2]='';
			$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
			?>
			
		</div>
		
	</div>
</div>

<script type="text/javascript">setupAllTabs();</script>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>