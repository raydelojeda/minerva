<!--Fin Contenido-->
						<input type="hidden" name="var_checkbox" value="<?php echo $cadenacheckboxp;?>">
						<input type="hidden" name="aux_submit" value="">						
						</table><br>
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	<tr>
		<td class="footer">
			<table class="footer">
				<tr>					
					<td class="footer"><?php echo $nombre_empresa . " - " . $nombre_sucursal;?></td>					
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>

<div id='menu1' class='portal'>
	<div class="barra">
		<table class="tabla_barra" id="toolbar">
			<tr> 
				<td>				
					<?php 
						print "<font size='2'>".$titulo_listar."<font>";
						$obj->Botonera($l_botones,$rs_sesion,$elemento);
					?>				
				</td>
			</tr>								
		</table>
	</div>
</div>

 <!--fin contenido1-->
</form>
</body>
</html>