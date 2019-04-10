<?php
$x='../../../';
include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection

if(isset($_POST['campo0']))
{	
	$txt_filtro=$_POST['campo0'];
	
	$filtro=" AND (abreviatura like '%".$txt_filtro."%' OR asignatura like '%".$txt_filtro."%' OR clase.nombre like '%".$txt_filtro."%' OR referencia like '%".$txt_filtro."%' 
	OR codigo like '%".$txt_filtro."%' OR primer_apellido like '%".$txt_filtro."%' OR primer_nombre like '%".$txt_filtro."%')";

	include("var_lis.php");
	if($b>=6){$aux=$b;}else {$aux=0;}
?>
	<tr> 
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
	<?php }
					
	
}
?>