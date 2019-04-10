// JavaScript Document
function validate_search()
{
 	if (document.frm_buscar.search1.value != "")
	{
		document.frm_buscar.submit();
	}
	else
	{
		return (false);
	}
}

/*-----------------------Para abrir ventanas---------------------------------*/
function abrir(valor) {
  window.open(valor,'','width=500,height=400,menubar,resizable,toolbar,titlebar,status,directories,location,scrollbars=yes');
}
/*---------------------------------------------------------------------------*/


/* --------------------------------------------------------------------*/
/*Get object */
function getObj(objID)
	{
	if (document.getElementById) {return document.getElementById(objID);}
	else if (document.all) {return document.all[objID];}
	else if (document.layers) {return document.layers[objID];}
	}
	
	
	// DEFINE VARIABLES

// whitespace characters
var whitespace = " \t\n\r";
var defaultEmptyOK = false

var intLimit = 15

function isEmpty(s){
// Check whether string s is empty.
	 return ((s == null) || (s.length == 0))
}

// Returns true if string s is empty or 
// whitespace characters only.

function isWhitespace(s)

{	 var i;

		// Is s empty?
		if (isEmpty(s)) return true;

		for (i = 0; i < s.length; i++)
		{	 
		// Check that current character isn't whitespace.
		var c = s.charAt(i);

		if (whitespace.indexOf(c) == -1) return false;
		}

		// All characters are whitespace.
		return true;
}

// E-mail Validation
function isEmail (s)
{	 if (isEmpty(s)) 
			 if (isEmail.arguments.length == 1) return defaultEmptyOK;
			 else return (isEmail.arguments[1] == true);
	 
		// is s whitespace?
		if (isWhitespace(s)) return false;
		
		// there must be >= 1 character before @, so we
		// start looking at character position 1 
		// (i.e. second character)
		var i = 1;
		var sLength = s.length;

		// look for @
		while ((i < sLength) && (s.charAt(i) != "@"))
		{ i++
		}

		if ((i >= sLength) || (s.charAt(i) != "@")) return false;
		else i += 2;

		// look for .
		while ((i < sLength) && (s.charAt(i) != "."))
		{ i++
		}

		// there must be at least one character after the .
		if ((i >= sLength - 1) || (s.charAt(i) != ".")) return false;
		else return true;
}	


/* Efemerides*/

function UpdateMonths()
{
document.form_efemerides.submit(); 
}


/*cambiar de idioma*/
function language(language)
{
	if (language == 'es')
	{
	
	}
	else if (language == 'en')
	{
		
	}
}


/**Email*/
function mail()
{
}