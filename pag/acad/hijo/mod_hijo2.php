<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

if($visualizar==1)$disable='disabled style="background-color:#ddd"';else $disable='';

$repre_econ=0;

if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}
$sql_p="SELECT id_estudiante FROM estudiante WHERE id_persona='".$mod."'";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$id_estudiante=$rs_p->fields['id_estudiante'];
$s_rs=$obj->Consulta_llenar_cajas($id_estudiante,$insert_field,$tabla,$db,$columna,$insert_alias);

//--------------LLENAR CAJAS PARA PERSONA--------------
$id_persona=$mod;
include($x."pag/rrhh/persona/variables.php");

$s_rs2=$obj->Consulta_llenar_cajas($id_persona,$insert_field,$tabla,$db,$columna,$insert_alias);
//--------------LLENAR CAJAS PARA PERSONA--------------

//--------------LLENAR FAMILIARES--------------
$sql_fam="SELECT id_familiar_estudiante, id_familiar, n_parentesco.id_parentesco, representante_legal, representante_aca, representante_eco, convive, puede_retirar, contacto_emergencia FROM familiar_estudiante, n_parentesco 
WHERE 1 AND n_parentesco.id_parentesco=familiar_estudiante.id_parentesco AND id_estudiante='".$id_estudiante."'";//print $sql_fam;
$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());
//--------------LLENAR FAMILIARES--------------

if(!isset($rs_p->fields['id_estudiante']))
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='id_hijo.php?mensaje=".utf8_encode("La identificación ya pertenece a un empleado o familiar.")."'</script>");

if(!$s_rs OR !$s_rs2 OR !$rs_fam)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_hijo.php'</script>");

if(isset($_POST[$inputs[0]['name_input']]))
{
	include($x."pag/rrhh/persona/variables.php");
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$id_persona,$tipo_input,$value_input,$x);
	$obj->Imprimir_mensaje($mensaje);//print $mensaje;
	
	$return[1]=$id_persona;//print $return[1];
	include("variables.php");
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
	$obj->Imprimir_mensaje($mensaje);
	
	//----GUARDAR FAMILIARES----
	$rs_fam->MoveFirst();
	for($fam=1;$fam<=5;$fam++)
	{
		if(isset($_POST['sel_fam_'.$fam]))
		{
			if($_POST['sel_fam_'.$fam]!=0)
			{
				if(isset($_POST['sel_par_'.$fam]))
				{
					if($_POST['sel_par_'.$fam]!=0)
					{
						$sel_fam=$_POST['sel_fam_'.$fam];
						$sel_par=$_POST['sel_par_'.$fam];
						if(isset($_POST['cbx_leg_'.$fam]))$cbx_leg=$_POST['cbx_leg_'.$fam];else $cbx_leg=0;
						if(isset($_POST['cbx_aca_'.$fam]))$cbx_aca=$_POST['cbx_aca_'.$fam];else $cbx_aca=0;
						if(isset($_POST['cbx_eco_'.$fam]))$cbx_eco=$_POST['cbx_eco_'.$fam];else $cbx_eco=0;
						if(isset($_POST['cbx_con_'.$fam]))$cbx_con=$_POST['cbx_con_'.$fam];else $cbx_con=0;
						if(isset($_POST['cbx_pue_'.$fam]))$cbx_pue=$_POST['cbx_pue_'.$fam];else $cbx_pue=0;
						if(isset($_POST['cbx_eme_'.$fam]))$cbx_eme=$_POST['cbx_eme_'.$fam];else $cbx_eme=0;
						
						if(isset($rs_fam->fields['id_familiar_estudiante']))
						{
							$upd="UPDATE familiar_estudiante SET id_familiar='".$sel_fam."',id_parentesco='".$sel_par."',representante_legal='".$cbx_leg."', representante_aca='".$cbx_aca."',
							representante_eco='".$cbx_eco."',convive='".$cbx_con."',puede_retirar='".$cbx_pue."',contacto_emergencia='".$cbx_eme."' WHERE id_familiar_estudiante='".$rs_fam->fields['id_familiar_estudiante']."'";//print $upd;// die();
							$db->Execute($upd) or die($db->ErrorMsg());						
						}
						else
						{
							$ins="INSERT INTO familiar_estudiante (id_familiar, id_estudiante, id_parentesco, representante_legal, representante_aca, representante_eco, convive, puede_retirar, contacto_emergencia) 
							VALUES ('".$sel_fam."','".$mod."','".$sel_par."','".$cbx_leg."','".$cbx_aca."','".$cbx_eco."','".$cbx_con."','".$cbx_pue."','".$cbx_eme."')";//print $ins."<br>";
							$db->Execute($ins) or die($db->ErrorMsg());
						}						
					}
					else
					$mensaje='Debe escoger el parentesco del familiar '.$fam;
				}
				else
				$mensaje='Debe escoger el parentesco del familiar '.$fam;
			}
			elseif(isset($rs_fam->fields['id_familiar_estudiante']))
			{
				$del="DELETE FROM familiar_estudiante WHERE id_familiar_estudiante='".$rs_fam->fields['id_familiar_estudiante']."'";//print $del;// die();
				$db->Execute($del) or die($db->ErrorMsg());
			}
		}			
	$rs_fam->MoveNext();
	}
	//----GUARDAR FAMILIARES----
	
	echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_hijo.php?mensaje=Datos guardados satisfactoriamente.'</script>");
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
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script><script type="text/javascript">this.selectedIndex=1;tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

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
</script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Datos personales</h2>			
			
			
			<div style='float:right;width:150px;'>			
				<?php
				include($x."pag/rrhh/persona/variables.php");
				
				$camp=$s_rs2->fields[$field_col[20]];			
				if(base64_encode($camp))
				echo '<img style="margin:3px;border-radius:8px;" width="150px" src="data:image/jpeg;base64,'. base64_encode($camp). '"/>';
				else
				echo '<img style="margin:3px;border-radius:8px;" width="150px" src="'.$x.'img/general/no_disponible.png"/>';
				?>			
			</div>
			
			<?php
			$obj->Generar_inputs($inputs,$s_rs2,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
		</div>

		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Datos adicionales</h2>			
			
			
			<div style='float:right;width:150px;'>			
				<?php
				include($x."pag/rrhh/persona/variables.php");
				
				$camp=$s_rs2->fields[$field_col[20]];			
				if(base64_encode($camp))
				echo '<img style="margin:3px;border-radius:8px;" width="150px" src="data:image/jpeg;base64,'. base64_encode($camp). '"/>';
				else
				echo '<img style="margin:3px;border-radius:8px;" width="150px" src="'.$x.'img/general/no_disponible.png"/>';
				?>			
			</div>
			
			<?php
			include("variables.php");
			$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
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
					<div style='display:table-cell;height:22px;width:48%;text-align:left;padding-left: 3%;'></div>
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
				$sql_f="SELECT familiar.id_familiar, persona.id_persona, primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,identificacion, usuario FROM persona, usuario, familiar
				WHERE 1 AND persona.id_persona=familiar.id_persona AND persona.id_persona=usuario.id_persona";
				$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
				
				$sql_p="SELECT id_parentesco, parentesco FROM n_parentesco";
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());	
				
				$rs_fam->MoveFirst();
				
				
				for($f=1;$f<=5;$f++) 
				{
					$readonly='';
					$rs_f->MoveFirst();
					for($e=0;$e<$rs_f->RecordCount();$e++)
					{	//print $rs_f->fields['id_familiar'].' = '.$rs_fam->fields['id_familiar'].' && '.$rs_f->fields['usuario'].' = '.$_SESSION["user"].'<br>';
						if($rs_f->fields['id_familiar']==$rs_fam->fields['id_familiar'] AND $rs_f->fields['usuario']==$_SESSION["user"])
						{$readonly='disabled';break;}
					$rs_f->MoveNext();
					}
					
				?>			
				<div id='fam_<?php print $f;?>' style='display:<?php if($f<3 OR isset($rs_fam->fields['id_familiar']))print 'table-row';else print 'none';?>;'>
					
					<div style='display:table-cell;height:22px;text-align:left;padding-left: 1%;'>
						<select <?php print $disable;?> class="js-basic-single_fam_<?php echo $f;?>" name="sel_fam_<?php print $f;?>" id="sel_fam_<?php print $f;?>" <?php print $readonly;?>>
							<option>----------------------Seleccionar----------------------</option>
							<?php $rs_f->MoveFirst();for($e=0;$e<$rs_f->RecordCount();$e++){?>					
								<option value="<?php print $rs_f->fields['id_familiar'];?>" <?php if($rs_f->fields['id_familiar']==$rs_fam->fields['id_familiar']){?> selected="selected"<?php }?> > <?php print $rs_f->fields['primer_apellido'].' '.$rs_f->fields['segundo_apellido'].' '.$rs_f->fields['primer_nombre'].' '.$rs_f->fields['segundo_nombre'].' - '.$rs_f->fields['identificacion'];?> </option>						
							<?php $rs_f->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<select <?php print $disable;?> name="sel_par_<?php print $f;?>" id="sel_par_<?php print $f;?>">
							<option>---Seleccionar---</option>
							<?php $rs_p->MoveFirst();for($e=0;$e<$rs_p->RecordCount();$e++){?>					
								<option value="<?php print $rs_p->fields['id_parentesco'];?>" <?php if($rs_p->fields['id_parentesco']==$rs_fam->fields['id_parentesco']){?> selected="selected"<?php }?>> <?php print $rs_p->fields['parentesco'];?> </option>						
							<?php $rs_p->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:center;'>
						<section>
							<div class="checkbox-3">
								<input <?php print $disable;?> class="checkbox_oculto" name='cbx_leg_<?php print $f;?>' <?php print $readonly;?> value='1' <?php if(isset($rs_fam->fields['id_familiar']) AND $rs_fam->fields['representante_legal']==1)print 'checked'; if($f<3 AND !isset($rs_fam->fields['id_familiar']))print 'checked';?> type="checkbox" id="cbx_leg_<?php print $f;?>" />
								<label for="cbx_leg_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input <?php print $disable;?> class="checkbox_oculto" name='cbx_aca_<?php print $f;?>' value='1' <?php if(isset($rs_fam->fields['id_familiar']) AND $rs_fam->fields['representante_aca']==1)print 'checked'; if($f<3 AND !isset($rs_fam->fields['id_familiar']))print 'checked';?> type="checkbox" id="cbx_aca_<?php print $f;?>" />
								<label for="cbx_aca_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input <?php print $disable;?> class="checkbox_oculto" name='cbx_eco_<?php print $f;?>' value='1' <?php if(isset($rs_fam->fields['id_familiar']) AND $rs_fam->fields['representante_eco']==1)print 'checked'; if($f<3 AND !isset($rs_fam->fields['id_familiar']))print 'checked';?> type="checkbox" id="cbx_eco_<?php print $f;?>" />
								<label for="cbx_eco_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
						
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input <?php print $disable;?> class="checkbox_oculto" name='cbx_con_<?php print $f;?>' value='1' <?php if(isset($rs_fam->fields['id_familiar']) AND $rs_fam->fields['convive']==1)print 'checked'; if($f<3 AND !isset($rs_fam->fields['id_familiar']))print 'checked';?> type="checkbox" id="cbx_con_<?php print $f;?>" />
								<label for="cbx_con_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input <?php print $disable;?> class="checkbox_oculto" name='cbx_pue_<?php print $f;?>' value='1' <?php if(isset($rs_fam->fields['id_familiar']) AND $rs_fam->fields['puede_retirar']==1)print 'checked'; if($f<3 AND !isset($rs_fam->fields['id_familiar']))print 'checked';?> type="checkbox" id="cbx_pue_<?php print $f;?>" />
								<label for="cbx_pue_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section>
							<div class="checkbox-3">
								<input <?php print $disable;?> class="checkbox_oculto" name='cbx_eme_<?php print $f;?>' value='1' <?php if(isset($rs_fam->fields['id_familiar']) AND $rs_fam->fields['contacto_emergencia']==1)print 'checked'; if($f<3 AND !isset($rs_fam->fields['id_familiar']))print 'checked';?> type="checkbox" id="cbx_eme_<?php print $f;?>" />
								<label for="cbx_eme_<?php print $f;?>"></label>
							</div>
						</section>
					</div>
					
				</div>
				
				<?php
				$rs_fam->MoveNext();
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
		
	</div>
</div>

<script type="text/javascript">setupAllTabs();</script>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>