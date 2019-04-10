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

$s_rs=$obj->Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias);

//--------------LLENAR CAJAS PARA PERSONA--------------
$sql_p="SELECT id_persona FROM estudiante WHERE id_estudiante='".$mod."'";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$id_persona=$rs_p->fields['id_persona'];
include($x."pag/rrhh/persona/variables.php");

$s_rs2=$obj->Consulta_llenar_cajas($id_persona,$insert_field,$tabla,$db,$columna,$insert_alias);
//--------------LLENAR CAJAS PARA PERSONA--------------

//--------------LLENAR CAJAS PARA CURSO, GRADO, PARALELO Y ESTUDIANTE--------------
$sql_c="SELECT id_curso_grado_paralelo_est FROM curso_grado_paralelo_est WHERE id_estudiante='".$mod."'";//print $sql_c;
$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());

$id_curso_grado_paralelo_est=$rs_c->fields['id_curso_grado_paralelo_est'];
//include($x."pag/acad/curso_grado_paralelo_est/variables.php");

$sql_c="SELECT id_curso_grado_paralelo_est as id_curso_grado_paralelo_est,id_grado_paralelo_periodo as id_grado_paralelo_periodo, retirado, fecha_admision as fecha_admision,fecha_matricula as fecha_matricula,codigo_matricula as codigo_matricula,fecha_retiro as fecha_retiro,cumplido as cumplido,id_estudiante as periodo 
FROM curso_grado_paralelo_est WHERE id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_c;
$s_rs3=$db->Execute($sql_c) or die($db->ErrorMsg());
//--------------LLENAR CAJAS PARA CURSO, GRADO, PARALELO Y ESTUDIANTE--------------

//--------------LLENAR FAMILIARES--------------
$sql_fam="SELECT id_familiar_estudiante, id_familiar, n_parentesco.id_parentesco, representante_legal, representante_aca, representante_eco, convive, puede_retirar, contacto_emergencia FROM familiar_estudiante, n_parentesco 
WHERE 1 AND n_parentesco.id_parentesco=familiar_estudiante.id_parentesco AND id_estudiante='".$mod."'";//print $sql_fam;
$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());

//--------------LLENAR FAMILIARES--------------

//--------------LLENAR CAJAS PARA MATRICULA--------------
/*$sql_m="SELECT id_matricula FROM matricula WHERE id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_m.'<br>';
$rs_m=$db->Execute($sql_m) or die($db->ErrorMsg());

$id_matricula=$rs_m->fields['id_matricula'];
include($x."pag/acad/matricula/variables.php");

$s_rs4=$obj->Consulta_llenar_cajas($id_matricula,$insert_field,$tabla,$db,$columna,$insert_alias);*/
//--------------LLENAR CAJAS PARA MATRICULA--------------

if(!$s_rs OR !$s_rs2 OR !$s_rs3 OR !$rs_fam)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_estudiante.php'</script>");


if(isset($_POST['aux_submit']))
{
	if($_POST['aux_submit']=='ok')
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
								
								if($cbx_eco==1 && $repre_econ==0)
								{								
									$repre_econ=1;
									$id_familiar_estudiante=$rs_fam->fields['id_familiar_estudiante'];
									
									$sql_f="SELECT concat(primer_nombre,' ',segundo_nombre) AS nombres, concat(primer_apellido,' ', segundo_apellido) AS apellidos, identificacion, direccion, telefono1 
									FROM persona, familiar, familiar_estudiante WHERE persona.id_persona=familiar.id_persona AND familiar.id_familiar=familiar_estudiante.id_familiar AND familiar_estudiante.id_familiar_estudiante='".$id_familiar_estudiante."'";//print $sql_f.'<br>';
									$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());//print $rs_p;
									
									$sql_c="SELECT id_cliente FROM persona,cliente WHERE persona.id_persona=cliente.id_persona AND persona.id_persona='".$id_persona."'";
									$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
									
									if(!isset($rs_c->fields[0]))
									{
										$ins="INSERT INTO cliente (factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, permite_credito, id_persona) 
										VALUES ('".$rs_f->fields['nombres']."','".$rs_f->fields['apellidos']."','".$rs_f->fields['identificacion']."','".$rs_f->fields['direccion']."','".$rs_f->fields['telefono1']."','1','".$id_persona."')";//print $i_sql."<br>";
										$db->Execute($ins) or die($db->ErrorMsg());
									}
									/*else
									{
										$upd="UPDATE cliente SET factura_nombres='".$rs_f->fields['nombres']."',factura_apellidos='".$rs_f->fields['apellidos']."',factura_cedula='".$rs_f->fields['identificacion']."',
										factura_direccion='".$rs_f->fields['direccion']."',factura_telefono='".$rs_f->fields['telefono1']."',permite_credito='1' WHERE id_persona='".$id_persona."'";//print $upd;// die();
										$db->Execute($upd) or die($db->ErrorMsg());
									}*/
								}							
							}
							else
							{
								$ins="INSERT INTO familiar_estudiante (id_familiar, id_estudiante, id_parentesco, representante_legal, representante_aca, representante_eco, convive, puede_retirar, contacto_emergencia) 
								VALUES ('".$sel_fam."','".$mod."','".$sel_par."','".$cbx_leg."','".$cbx_aca."','".$cbx_eco."','".$cbx_con."','".$cbx_pue."','".$cbx_eme."')";//print $ins."<br>";
								$db->Execute($ins) or die($db->ErrorMsg());
								
								if($cbx_eco==1 && $repre_econ==0)
								{								
									$repre_econ=1;
									$i_sql="SELECT LAST_INSERT_ID() AS myid";
									$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
									$id_familiar_estudiante=$rs->fields['myid'];
									
									$sql_f="SELECT concat(primer_nombre,' ',segundo_nombre) AS nombres, concat(primer_apellido,' ', segundo_apellido) AS apellidos, identificacion, direccion, telefono1 
									FROM persona, familiar, familiar_estudiante WHERE persona.id_persona=familiar.id_persona AND familiar.id_familiar=familiar_estudiante.id_familiar AND familiar_estudiante.id_familiar_estudiante='".$id_familiar_estudiante."'";//print $sql_p;
									$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());//print $rs_p;
									
									$sql_c="SELECT id_cliente FROM persona,cliente WHERE persona.id_persona=cliente.id_persona AND persona.id_persona='".$id_persona."'";
									$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
									
									if(!isset($rs_c->fields[0]))
									{
										$ins="INSERT INTO cliente (factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, permite_credito, id_persona) 
										VALUES ('".$rs_f->fields['nombres']."','".$rs_f->fields['apellidos']."','".$rs_f->fields['identificacion']."','".$rs_f->fields['direccion']."','".$rs_f->fields['telefono1']."','1','".$id_persona."')";//print $i_sql."<br>";
										$db->Execute($ins) or die($db->ErrorMsg());
									}
									/*else
									{
										$upd="UPDATE cliente SET factura_nombres='".$rs_f->fields['nombres']."',factura_apellidos='".$rs_f->fields['apellidos']."',factura_cedula='".$rs_f->fields['identificacion']."',
										factura_direccion='".$rs_f->fields['direccion']."',factura_telefono='".$rs_f->fields['telefono1']."',permite_credito='1' WHERE id_persona='".$id_persona."'";//print $upd;// die();
										$db->Execute($upd) or die($db->ErrorMsg());
									}*/
								}
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
		
		
		
		/*if($repre_econ==0)
		{
			$upd="UPDATE cliente SET factura_nombres='CONSUMIDOR',factura_apellidos='FINAL',factura_cedula='999999999999',
			factura_direccion='',factura_telefono='',permite_credito='0' WHERE id_persona='".$id_persona."'";//print $upd;// die();
			$db->Execute($upd) or die($db->ErrorMsg());
		}*/
		//----GUARDAR FAMILIARES----
		
		if(isset($_POST['cbx_retirado']))$cbx_retirado=$_POST['cbx_retirado'];else $cbx_retirado=0;
		if(isset($_POST['cbx_cumplido']))$cbx_cumplido=$_POST['cbx_cumplido'];else $cbx_cumplido=0;
		
		$upd="UPDATE curso_grado_paralelo_est SET fecha_admision='".$_POST['fecha_admision']."', fecha_matricula='".$_POST['fecha_matricula']."', 
		codigo_matricula='".$_POST['codigo_matricula']."', retirado='".$cbx_retirado."', fecha_retiro='".$_POST['fecha_retiro']."', cumplido='".$cbx_cumplido."'
		WHERE id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $upd; die();
		$db->Execute($upd) or die($db->ErrorMsg());
		
		if($cbx_retirado=='1')
		{
			$u_sql="UPDATE clase_estudiante SET fecha_salida='".$_POST['fecha_retiro']."', retirado='1' WHERE id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $i_sql."<br>";
			$db->Execute($u_sql) or die($db->ErrorMsg());
		}
		
		
		/*$return[1]=$mod;//print $return[1];
		include($x."pag/acad/curso_grado_paralelo_est/variables.php");
		$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$columna,$db,$id_curso_grado_paralelo_est,$tipo_input,$value_input,$x);
		$obj->Imprimir_mensaje($mensaje);*/

		if($mensaje=='')
		{
			if($_POST['fecha_matricula']!='0000-00-00' && $_POST['codigo_matricula']!='')
			{
			?>
				<script language="JavaScript" type="text/javascript">
					alertify.confirm("Desea imprimir el Acta de Matr&iacute;cula?", function (e){
					if(e) 
					{
						
						document.frm.action='planilla_matricula.php';//alert(act);
						document.frm.var_aux.value=<?php echo $mod;?>;
						document.frm.submit();
						alertify.success("Has pulsado '" + alertify.labels.ok + "'");
					} 
					else 
					{ 
						alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
						location.href='lis_estudiante.php?mensaje=Datos guardados satisfactoriamente.'
					}
					});				
				</script>
			<?php
			}
			else
			echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_estudiante.php?mensaje=Datos guardados satisfactoriamente.'</script>");
		}
	}
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
$(".js-basic-single_paralelo").select2();
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
	else if(retirado.style.display=="none")
	validar_form('ide','','Rvarchar','prin','','Rvarchar','segn','','varchar','pria','','Rvarchar','sega','','varchar','fec','','Rfecha','dir','','varchar','ema','','email','tel1','','varchar','tel2','','varchar','res','','Rselec','pais','','Rselec','gen','','Rselec','tip','','Rselec','tide','','Rselec','c_f','','varchar','luga','','Rinput','grado_paralelo','','Rselec','fecha_admision','','Rfecha','fecha_matricula','','fecha','codigo_matricula','','input'); 
	else
	validar_form('ide','','Rvarchar','prin','','Rvarchar','segn','','varchar','pria','','Rvarchar','sega','','varchar','fec','','Rfecha','dir','','varchar','ema','','email','tel1','','varchar','tel2','','varchar','res','','Rselec','pais','','Rselec','gen','','Rselec','tip','','Rselec','tide','','Rselec','c_f','','varchar','luga','','Rinput','grado_paralelo','','Rselec','fecha_admision','','Rfecha','fecha_matricula','','fecha','codigo_matricula','','input','fecha_retiro','','Rfecha','cumplido','','Rselec'); 
}

</script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane">
		<div class="tab-page">
			<h2 class="tab">Datos personales</h2>
			
			<?php
			print "<div style='position:absolute;right:10%;z-index:5;valign:top;'><input name='cedula' type='text' size='42' style='border: 0px; background-color:ffffff; text-decoration:italic;' onfocus='blur();'></div>";
			?>
			
			<div style='position:absolute;right:1%;z-index:5;'>			
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
		
		<script language="JavaScript" type="text/javascript">
			valida_cedula();
		</script>

		<div class="tab-page">
			<h2 class="tab">Datos adicionales</h2>
			
			<div style='position:absolute;right:1%;z-index:5;'>			
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
		
		<div class="tab-page">
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
				$sql_f="SELECT id_familiar, primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,identificacion FROM persona, familiar WHERE 1 AND persona.id_persona=familiar.id_persona";
				$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
				
				$sql_p="SELECT id_parentesco, parentesco FROM n_parentesco";
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
				
				$rs_fam->MoveFirst();
				
				for($f=1;$f<=5;$f++) 
				{					//	
				?>
				
				
				
				<div id='fam_<?php print $f;?>' style='display:<?php if($f<3 OR isset($rs_fam->fields['id_familiar']))print 'table-row';else print 'none';?>;'>
					
					<div style='display:table-cell;height:22px;text-align:left;padding-left: 1%;'>
						<select <?php print $disable;?>  class="js-basic-single_fam_<?php echo $f;?>" name="sel_fam_<?php print $f;?>" id="sel_fam_<?php print $f;?>">
							<option value='0'>----------------------Seleccionar----------------------</option>
							<?php $rs_f->MoveFirst();for($e=0;$e<$rs_f->RecordCount();$e++){?>					
								<option value="<?php print $rs_f->fields['id_familiar'];?>" <?php if($rs_f->fields['id_familiar']==$rs_fam->fields['id_familiar']){?> selected="selected"<?php }?>> <?php print $rs_f->fields['primer_apellido'].' '.$rs_f->fields['segundo_apellido'].' '.$rs_f->fields['primer_nombre'].' '.$rs_f->fields['segundo_nombre'].' - '.$rs_f->fields['identificacion'];?> </option>						
							<?php $rs_f->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:left;'>
						<select <?php print $disable;?> name="sel_par_<?php print $f;?>" id="sel_par_<?php print $f;?>">
							<option value='0'>---Seleccionar---</option>
							<?php $rs_p->MoveFirst();for($e=0;$e<$rs_p->RecordCount();$e++){?>					
								<option value="<?php print $rs_p->fields['id_parentesco'];?>" <?php if($rs_p->fields['id_parentesco']==$rs_fam->fields['id_parentesco']){?> selected="selected"<?php }?>> <?php print $rs_p->fields['parentesco'];?> </option>						
							<?php $rs_p->MoveNext();}?>
						</select>
					</div>
					
					<div style='display:table-cell;height:22px;text-align:center;'>
						<section>
							<div class="checkbox-3">
								<input <?php print $disable;?> class="checkbox_oculto" name='cbx_leg_<?php print $f;?>' value='1' <?php if(isset($rs_fam->fields['id_familiar']) AND $rs_fam->fields['representante_legal']==1)print 'checked'; if($f<3 AND !isset($rs_fam->fields['id_familiar']))print 'checked';?> type="checkbox" id="cbx_leg_<?php print $f;?>" />
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
		
		<div class="tab-page">
			<h2 class="tab">Admisi&oacute;n y matr&iacute;cula</h2>
			
			<div style='position:absolute;right:1%;z-index:5;'>			
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
			$sql_par = "select id_grado_paralelo_periodo as id_grado_paralelo_periodo, concat(n_grado_paralelo.abreviatura,' - ',grado,' ',paralelo) as grado_paralelo from grado_paralelo_periodo, n_grado_paralelo, n_grado, n_paralelo, n_periodo_academico
			WHERE 1 AND n_grado_paralelo.id_grado=n_grado.id_grado AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo AND n_periodo_academico.id_periodo_academico=grado_paralelo_periodo.id_periodo_academico AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_periodo_academico.activo='1' ORDER BY orden ASC";
			$rs_p=$db->Execute($sql_par) or die($db->ErrorMsg());
			?>	
			
			<div style='display:table;width:100%;'>			
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;'>
						Grado y paralelo:
					</div>
					<div style='display:table-cell;height:22px;text-align:left;'>
						<select class="js-basic-single_paralelo" name="sel_paralelo" id="sel_paralelo">
							<option value='0'>----------------------Seleccionar----------------------</option>
							<?php $rs_p->MoveFirst();for($e=0;$e<$rs_p->RecordCount();$e++){?>					
								<option value="<?php print $rs_p->fields['id_grado_paralelo_periodo'];?>" <?php if($rs_p->fields['id_grado_paralelo_periodo']==$s_rs3->fields['id_grado_paralelo_periodo']){?> selected="selected"<?php }?>> <?php print $rs_p->fields['grado_paralelo'];?> </option>						
							<?php $rs_p->MoveNext();}?>
						</select>*
					</div>
				</div>
				
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;'>
						Fecha de admisi&oacute;n:
					</div>
					<div style='display:table-cell;height:22px;text-align:left;'>
						<input id="fecha_admision" type="text" value="<?php print $s_rs3->fields['fecha_admision'];?>" maxlength="10" size="10" onclick='displayCalendar(document.frm.fecha_admision,"yyyy-mm-dd",this);' title="Fecha de admisi&oacute;n" name="fecha_admision" placeholder="">*
					</div>
				</div>
				
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;'>
						Fecha de matr&iacute;cula:
					</div>
					<div style='display:table-cell;height:22px;text-align:left;'>
						<input id="fecha_matricula" type="text" value="<?php if($s_rs3->fields['fecha_matricula']!='0000-00-00')print $s_rs3->fields['fecha_matricula'];?>" maxlength="10" size="10" onclick='displayCalendar(document.frm.fecha_matricula,"yyyy-mm-dd",this);' title="Fecha de matr&iacute;cula" name="fecha_matricula" placeholder="">*
					</div>
				</div>
				
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;'>
						C&oacute;digo de matr&iacute;cula:
					</div>
					<div style='display:table-cell;height:22px;text-align:left;'>
						<input id="codigo_matricula" type="text" value="<?php print $s_rs3->fields['codigo_matricula'];?>" maxlength="10" size="10" title="C&oacute;digo de matr&iacute;cula" name="codigo_matricula" placeholder="">*
					</div>
				</div>
				
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:25%;text-align:right;'>
						Retirado:
					</div>
					<div style='display:table-cell;height:22px;text-align:left;'>
						<section style='width:25px;text-align:left;'>
							<div class="checkbox-3" style='text-align:left;'>
								<input onChange='retirado1=document.getElementById("retirado1");if(retirado1.style.display=="none")retirado1.style.display="table-row";else retirado1.style.display="none";retirado=document.getElementById("retirado");if(retirado.style.display=="none")retirado.style.display="table-row";else retirado.style.display="none";' class="checkbox_oculto" name='cbx_retirado' value='1' <?php if(isset($s_rs3->fields['retirado']) AND $s_rs3->fields['retirado']==1)print 'checked';?> type="checkbox" id="cbx_retirado" />
								<label for="cbx_retirado"></label>
							</div>
						</section>
					</div>
				</div>
				
				
					<div id='retirado' <?php if(isset($s_rs3->fields['retirado']) AND $s_rs3->fields['retirado']==0){?>style='display:none;'<?php }else{?>style='display:table-row;'<?php }?>>
						<div style='display:table-cell;height:22px;width:25%;text-align:right;'>
							Fecha de retiro:
						</div>
						<div style='display:table-cell;height:22px;text-align:left;'>
							<input id="fecha_retiro" type="text" value="<?php if($s_rs3->fields['fecha_retiro']!='0000-00-00')print $s_rs3->fields['fecha_retiro'];?>" onclick='displayCalendar(document.frm.fecha_retiro,"yyyy-mm-dd",this);' maxlength="10" size="10" title="Fecha de retiro" name="fecha_retiro" placeholder="">
						</div>
					</div>
					
					<div id='retirado1' <?php if(isset($s_rs3->fields['retirado']) AND $s_rs3->fields['retirado']==0){?>style='display:none;'<?php }else{?>style='display:table-row;'<?php }?>>
						<div style='display:table-cell;height:22px;width:25%;text-align:right;'>
							A&ntilde;o cumplido:
						</div>
						<div style='display:table-cell;height:22px;text-align:left;'>
							<section style='width:25px;text-align:left;'>
								<div class="checkbox-3" style='text-align:left;'>
									<input class="checkbox_oculto" name='cbx_cumplido' value='1' <?php if(isset($s_rs3->fields['cumplido']) AND $s_rs3->fields['cumplido']==1)print 'checked';?> type="checkbox" id="cbx_cumplido" />
									<label for="cbx_cumplido"></label>
								</div>
							</section>
						</div>
					</div>
				
				
			</div>
			
			<?php
			//include($x."pag/acad/curso_grado_paralelo_est/variables.php");
			//$obj->Generar_inputs($inputs,$s_rs3,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li',$visualizar);
			if(isset($_GET['mensaje']))
			$mensaje=$_GET['mensaje'];
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
			
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