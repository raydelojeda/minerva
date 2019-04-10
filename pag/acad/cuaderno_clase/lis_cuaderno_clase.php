<?php
include("camino.php");
include($x."plantillas/pla_header.php");

include("../clase/variables.php");

if(isset($rs_sesion->fields[0]))
{
	$rs_sesion->MoveFirst();
	for($q=0;$q<$rs_sesion->RecordCount();$q++)
	{
		if($rs_sesion->fields['elemento']=='todos_cuadernos_clase' AND $rs_sesion->fields['accion']=="Visualizar")
		{
			$todos="ok";break;
		}
		else
		{
			$todos="";
		}
	$rs_sesion->MoveNext();
	}
}

/*if(!isset($tabla_anidada2))$tabla_anidada2='';if(!isset($campo_anidado2))$campo_anidado2='';if(!isset($where))$where='';if(!isset($operador))$operador='';if(!isset($select))$select='';
$l_sql=$obj->Consulta_listar($field,$alias_col,$tabla,$tabla_anidada,$campo_anidado,$tabla_anidada2,$campo_anidado2,$where,$info_col,$operador,$select);//
include($x."plantillas/listar.php");//print $l_sql;*/

include("var_lis.php");
if($b>=6){$aux=$b;}else {$aux=0;}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<form name='frm'>
<br>
	<table align="center" class="panel">
		<tr> 
			<td colspan="2" class="panel_header">				
				<img src="<?php print $x;?>img/general/minerva.png" width="60" height="60">&nbsp;&nbsp;Cuadernos de clase			
			</td>
		</tr>
		<tr> 
			<td>
				<table class="tabla_filtro">
					<tr>
						<td style='width:100%;text-align:left;padding-left:2%;'>
							Filtro:
							<input type="text" size="40" value="" name="txt_filtro" onkeyup="str=document.frm.txt_filtro.value;if(str.length>2 || str.length==0){ejecutar_ajax('filtrar_cuaderno_clase.php','txt_filtro','cuadernos_clase');}">
						</td>
					</tr>	
				</table>
				<br>
				<table class="modulo" id='cuadernos_clase'>
					<tr> 
					<?php if(isset($_GET['mensaje']))
					$mensaje=$_GET['mensaje'];
					if(isset($return[0]))
					$mensaje=$return[0];
					$obj->Imprimir_mensaje($mensaje);?>
						<td colspan="3" rowspan="4"width="49%">
							<img style="border-radius: 12px 12px 12px 12px;-moz-border-radius: 12px 12px 12px 12px;-webkit-border-radius: 12px 12px 12px 12px;border: 0px" width="30%" src="<?php print $x.'img/'.$modulo.'/'.$elemento.'/'.$elemento.'.png';?>">
						</td>
					</tr>					
					
					<?php for($m=0;$m<9;$m++){?>
					<tr> 
					
						<td width="16%" >
						<?php if($m<$b){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }else {?><div id="btn_sp">&nbsp;</div><?php }?>
						</td>
											
						<td width="16%">
						<?php $m=$m+1;if($m<$b){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }else {?><div id="btn_sp">&nbsp;</div><?php }?>
						</td>
						
						<td width="16%">
						<?php $m=$m+1;if($m<$b){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }else {?><div id="btn_sp">&nbsp;</div><?php }?>
						</td>
												
					</tr>
					<?php }?>
					
					<?php for($m=9;$m<$aux;$m++){?>
					<tr> 
					
						<td width="16%">
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						</td>						
						
					
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>						
						
						
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>					
						
					
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>
						
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>
						
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#B3C4DD'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>
						
					</tr>
					<?php }?>
					
				
				</table>
			</td>			
		</tr>
	</table>	
	
<br>		
		
</form>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/sec_footer.php");
?>