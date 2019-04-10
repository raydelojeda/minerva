<?php
include("camino.php");
include($x."plantillas/pla_header.php");
include("variables.php");

if($b>=6){$aux=$b;}else {$aux=0;}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<br>
	<table align="center" class="panel">
		<tr> 
			<td colspan="2" class="panel_header">				
				<img src="../../img/general/minerva.png" width="60" height="60">&nbsp;&nbsp;<?php print $titulo_sitio;?> - <?php print $titulo_modulo;?>			
			</td>
		</tr>
		<tr> 
			<td>
				<table class="modulo">
					<tr> 
					<?php if(isset($_GET['mensaje']))
					$mensaje=$_GET['mensaje'];
					if(isset($return[0]))
					$mensaje=$return[0];
					$obj->Imprimir_mensaje($mensaje);?>
						<td colspan="3" rowspan="4"width="49%">
							<img style="border-radius: 12px 12px 12px 12px;-moz-border-radius: 12px 12px 12px 12px;-webkit-border-radius: 12px 12px 12px 12px;border: 0px" width="50%" src="../../img/<?php print $modulo;?>/panel/<?php print $img_modulo;?>">
						</td>
					</tr>					
					
					<?php for($m=0;$m<9;$m++){?>
					<tr> 
					
						<td width="16%" >
						<?php if($m<$b){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }else {?><div id="btn_sp">&nbsp;</div><?php }?>
						</td>
											
						<td width="16%">
						<?php $m=$m+1;if($m<$b){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }else {?><div id="btn_sp">&nbsp;</div><?php }?>
						</td>
						
						<td width="16%">
						<?php $m=$m+1;if($m<$b){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }else {?><div id="btn_sp">&nbsp;</div><?php }?>
						</td>
												
					</tr>
					<?php }?>
					
					<?php for($m=9;$m<$aux;$m++){?>
					<tr> 
					
						<td width="16%">
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						</td>						
						
					
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>						
						
						
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>					
						
					
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>
						
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
							</a>
						<?php }?>
						</td>
						
						<td width="16%">
						<?php $m=$m+1;if($m<sizeof($titulo_pag)){?>
							<a href="<?php print $link_pag[$m];?>">	
								<div style="background-color: <?php print $color[$m];?>" id="btn" onMouseOut="this.style.cssText='background-color: <?php print $color[$m];?>'" onMouseOver="this.style.cssText='background-color:#555'"><div id="btn_int"><img id="img_btn" src="<?php print $ico_pag[$m];?>" ></div>&nbsp;<p><?php print $titulo_pag[$m];?></p></div>
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
		

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/sec_footer.php");
?>