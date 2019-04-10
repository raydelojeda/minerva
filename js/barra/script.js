var TxInicial = 11;
var textoHtml;
var numCol = 1;
var dos = false;
function zoom(Factor)
{
	tx = document.getElementById("cuba_text1");
	if (Factor==0){TxInicial=11;}else{
	TxInicial = TxInicial + Factor;}
	if((TxInicial >= 9)&&(TxInicial <= 13))
	{
		tx.style.fontSize = TxInicial+"px";
	}
	else
	{
		TxInicial = TxInicial - Factor;
	}
	if (numCol > 1)
	{
		tb = document.getElementById("tablaColumnas");
		tb.style.fontSize = TxInicial+"px";
	}
	switch (TxInicial){
		case 9:  document.getElementById('font_less').src = 'img/font_less_d.gif';
				 document.getElementById('font').src = 'img/font.gif';
				 document.getElementById('font_plus').src = 'img/font_plus.gif';
				 break;
		case 11: document.getElementById('font_less').src = 'img/font_less.gif';
				 document.getElementById('font').src = 'img/font_d.gif';
				 document.getElementById('font_plus').src = 'img/font_plus.gif';
				 break;
		case 13: document.getElementById('font_less').src = 'img/font_less.gif';
				 document.getElementById('font').src = 'img/font.gif';
				 document.getElementById('font_plus').src = 'img/font_plus_d.gif';
				 break;
		default: document.getElementById('font_less').src = 'img/font_less.gif';
				 document.getElementById('font').src = 'img/font.gif';
				 document.getElementById('font_plus').src = 'img/font_plus.gif';
				 break;
	}
}
function CogerTexto()
{
	texto = document.getElementById("cuba_text1");
	textoHtml = texto.innerHTML;
	zoom(0);
	
}
function columnas() {
	tiene_tabla = TieneTabla();
	if (tiene_tabla == false)
	{
		var ini, fin
		if (!dos)
		{
			var StrNumCol = prompt("número de columnas", 1);
			numCol = parseInt(StrNumCol);
		}
		else
		{
			dos = false;
			numCol=2;
		}
		if (!isNaN(numCol) && numCol>1){
	
		texto = document.getElementById("cuba_text1");
		texto.innerHTML = "";
		var browserinfos=navigator.userAgent;
		var opera=browserinfos.match(/Opera/);
		if (document.all && (!(opera)))
		{ 
			var newTable = document.createElement("<table id='tablaColumnas' class='cuba_text' cellpadding='5' border='0' width='95%' ></table>")
			var newRow = newTable.insertRow();
		}else{
			var newTable = document.createElement("table");
			newTable.setAttribute("border", "0");
			newTable.setAttribute("width", "95%");
			newTable.setAttribute("align", "left");
			newTable.setAttribute("cellpadding", "5");
			newTable.setAttribute("cellspacing", "7");
			newTable.setAttribute("class", "cuba_text");
			newTable.setAttribute("id", "tablaColumnas");
			var newRow = document.createElement("tr"); 
			newTable.appendChild(newRow);
		}
		 
		fin = -1;
		var ancho = Math.floor(100 / numCol) + "%";
		for(i=1; i<=numCol; i++) {
			if (document.all && (!(opera)))
			{
				var newCell = newRow.insertCell();
				newCell.width =  ancho;
				newCell.vAlign = "top";
			}else{
				var newCell = document.createElement("td"); 
				newRow.appendChild(newCell);			
				newCell.setAttribute("width", ancho);
				newCell.setAttribute("vAlign", "top");
				var celdaVacia = document.createElement("td"); 
			}
	
			// DIVIDIR TEXTO
			ini = fin + 1;
			fin += Math.floor(textoHtml.length / numCol);
			if (fin  > textoHtml.length || i == numCol)
			   fin = textoHtml.length;
			// NO CORTAR TAGS
			var j;
			for(j=ini+fin-1; j>=ini && textoHtml.charAt(j) != ">" && textoHtml.charAt(j) != "<"; j--);
			if (textoHtml.charAt(j) == "<")
			   for(; fin<textoHtml.length && textoHtml.charAt(fin) != ">"; fin++);
			// ACABAR EN BLANCO O PUNTO
			if (textoHtml.charAt(fin) != " " && textoHtml.charAt(fin) != ".")
			   for(; fin<textoHtml.length && textoHtml.charAt(fin) != " " && textoHtml.charAt(fin) != "."; fin++);
	
			newCell.innerHTML = textoHtml.substring(ini, fin);
		 }
		 texto.appendChild(newTable)
	
	   }
	   else
	   {
		   texto.innerHTML = textoHtml;
		   numCol = 1;
	   }
	}
	else
	{
		alert('Este contenido no puede ser dividido en columnas');
	}
}
function TieneTabla()
{
	if(document.getElementById("tabla"))
	{
		return(true);
	}
	else
	{
		return(false);
	}
}
function start()
{
	dos = true;
	CogerTexto();
	tiene_tabla = TieneTabla();
	if (tiene_tabla == false)
	{
		columnas();
	}
	/*loadBar();*/
}
