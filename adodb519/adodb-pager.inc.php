<?php

/*
	V5.19  23-Apr-2014  (c) 2000-2014 John Lim (jlim#natsoft.com). All rights reserved.
	  Released under both BSD license and Lesser GPL library license.
	  Whenever there is any discrepancy between the two licenses,
	  the BSD license will take precedence.
	  Set tabs to 4 for best viewing.

  	This class provides recordset pagination with
	First/Prev/Next/Last links.

	Feel free to modify this class for your own use as
	it is very basic. To learn how to use it, see the
	example in adodb/tests/testpaging.php.

	"Pablo Costa" <pablo@cbsp.com.br> implemented Render_PageLinks().

	Please note, this class is entirely unsupported,
	and no free support requests except for bug reports
	will be entertained by the author.

*/
class ADODB_Pager {
	var $id; 	// unique id for pager (defaults to 'adodb')
	var $db; 	// ADODB connection object
	var $sql; 	// sql used
	var $rs;	// recordset generated
	var $curr_page;	// current page number before Render() called, calculated in constructor
	var $rows;		// number of rows per page
    var $linksPerPage=10; // number of links per page in navigation bar
    var $showPageLinks;

	var $gridAttributes = 'width=100% border=1 bgcolor=white';

	// Localize text strings here
	var $first = "img/general/flecha_izq.png'/>";
	var $prev = "img/general/flecha_izq.png'/>";
	var $next = "img/general/flecha_der.png'/>";
	var $last = "img/general/flecha_der.png'/>";
	var $moreLinks = '...';
	var $startLinks = '...';
	var $gridHeader = false;
	var $htmlSpecialChars = true;
	var $page = 'Page';
	var $linkSelectedColor = 'red';
	var $cache = 0;  #secs to cache with CachePageExecute()

	//----------------------------------------------
	// constructor
	//
	// $db	adodb connection object
	// $sql	sql statement
	// $id	optional id to identify which pager,
	//		if you have multiple on 1 page.
	//		$id should be only be [a-z0-9]*
	//
	function ADODB_Pager(&$db,$sql,$id = 'adodb', $showPageLinks = false,$x)
	{
	global $PHP_SELF;
	global $CAMINO;

		$curr_page = $id.'_curr_page';
		if (!empty($PHP_SELF)) $PHP_SELF = htmlspecialchars($_SERVER['PHP_SELF']); // htmlspecialchars() to prevent XSS attacks
		$CAMINO = $x; // htmlspecialchars() to prevent XSS attacks

		$this->sql = $sql;
		$this->id = $id;
		$this->db = $db;
		$this->showPageLinks = $showPageLinks;

		$next_page = $id.'_next_page';

		if (isset($_GET[$next_page])) {
			$_SESSION[$curr_page] = (integer) $_GET[$next_page];
		}
		if (empty($_SESSION[$curr_page])) $_SESSION[$curr_page] = 1; ## at first page

		$this->curr_page = $_SESSION[$curr_page];

	}

	//---------------------------
	// Display link to first page
	function Render_First($anchor=true)
	{
	global $PHP_SELF;
	global $CAMINO;
		if ($anchor) {
	?>
		<a href="<?php echo $PHP_SELF,'?',$this->id;?>_next_page=1"><?php echo "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->first."<img height='7px' width='7px' border='0' src='".$CAMINO.$this->first;?></a> &nbsp;
	<?php
		} else {
			print "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->first."<img height='7px' width='7px' border='0' src='".$CAMINO.$this->first."&nbsp;&nbsp;&nbsp;";
		}
	}

	//--------------------------
	// Display link to next page
	function render_next($anchor=true)
	{
	global $PHP_SELF;
	global $CAMINO;

		if ($anchor) {
		?>
		<a href="<?php echo $PHP_SELF,'?',$this->id,'_next_page=',$this->rs->AbsolutePage() + 1 ?>"><?php echo "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->next;?></a> &nbsp;
		<?php
		} else {
			print "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->next."&nbsp;&nbsp;&nbsp;";
		}
	}

	//------------------
	// Link to last page
	//
	// for better performance with large recordsets, you can set
	// $this->db->pageExecuteCountRows = false, which disables
	// last page counting.
	function render_last($anchor=true)
	{
	global $PHP_SELF;
	global $CAMINO;

		if (!$this->db->pageExecuteCountRows) return;

		if ($anchor) {
		?>
			<a href="<?php echo $PHP_SELF,'?',$this->id,'_next_page=',$this->rs->LastPageNo() ?>"><?php echo "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->last."<img height='7px' width='7px' border='0' src='".$CAMINO.$this->last;?></a> &nbsp;&nbsp;
		<?php
		} else {
			print "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->last."<img height='7px' width='7px' border='0' src='".$CAMINO.$this->last."&nbsp;&nbsp;&nbsp;";
		}
	}

	//---------------------------------------------------
	// original code by "Pablo Costa" <pablo@cbsp.com.br>
        function render_pagelinks()
        {
        global $PHP_SELF;
            $pages        = $this->rs->LastPageNo();
            $linksperpage = $this->linksPerPage ? $this->linksPerPage : $pages;
            for($i=1; $i <= $pages; $i+=$linksperpage)
            {
                if($this->rs->AbsolutePage() >= $i)
                {
                    $start = $i;
                }
            }
			$numbers = '';
            $end = $start+$linksperpage-1;
			$link = $this->id . "_next_page";
            if($end > $pages) $end = $pages;


			if ($this->startLinks && $start > 1) {
				$pos = $start - 1;
				$numbers .= "<a href=$PHP_SELF?$link=$pos>$this->startLinks</a>  ";
            }

			for($i=$start; $i <= $end; $i++) {
                if ($this->rs->AbsolutePage() == $i)
                    $numbers .= "<font color=$this->linkSelectedColor><b>$i</b></font>  ";
                else
                     $numbers .= "<a href=$PHP_SELF?$link=$i>$i</a>  ";

            }
			if ($this->moreLinks && $end < $pages)
				$numbers .= "<a href=$PHP_SELF?$link=$i>$this->moreLinks</a>  ";
            print $numbers . ' &nbsp; ';
        }
	// Link to previous page
	function render_prev($anchor=true)
	{
	global $PHP_SELF;
	global $CAMINO;
		if ($anchor) {
	?>
		<a href="<?php echo $PHP_SELF,'?',$this->id,'_next_page=',$this->rs->AbsolutePage() - 1 ?>"><?php echo "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->prev;?></a> &nbsp;
	<?php
		} else {
			print "<img height='7px' width='7px' border='0' src='".$CAMINO.$this->prev."&nbsp;&nbsp;";
		}
	}

	//--------------------------------------------------------
	// Simply rendering of grid. You should override this for
	// better control over the format of the grid
	//
	// We use output buffering to keep code clean and readable.
	function RenderGrid()
	{
	global $gSQLBlockRows; // used by rs2html to indicate how many rows to display
		include_once(ADODB_DIR.'/tohtml.inc.php');
		ob_start();
		$gSQLBlockRows = $this->rows;
		rs2html($this->rs,$this->gridAttributes,$this->gridHeader,$this->htmlSpecialChars);
		$s = ob_get_contents();
		ob_end_clean();
		print $s;
		return $s;
	}

	//-------------------------------------------------------
	// Navigation bar
	//
	// we use output buffering to keep the code easy to read.
	function RenderNav()
	{
		ob_start();
		if (!$this->rs->AtFirstPage()) {
			$this->Render_First();
			$this->Render_Prev();
		} else {
			$this->Render_First(false);
			$this->Render_Prev(false);
		}
        if ($this->showPageLinks){
            $this->Render_PageLinks();
        }
		if (!$this->rs->AtLastPage()) {
			$this->Render_Next();
			$this->Render_Last();
		} else {
			$this->Render_Next(false);
			$this->Render_Last(false);
		}
		$s = ob_get_contents();
		ob_end_clean();
		return $s;
	}

	//-------------------
	// This is the footer
	function RenderPageCount()
	{
		global $PHP_SELF;
		if (!$this->db->pageExecuteCountRows) return '';
		$lastPage = $this->rs->LastPageNo();
		if ($lastPage == -1) $lastPage = 1; // check for empty rs.
		if ($this->curr_page > $lastPage) $this->curr_page = 1;
		
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		if(!isset($_POST['txt_ir']))
		$_POST['txt_ir']='';
		
		/*if(isset($_POST['txt_ir']) OR isset($_GET['adodb_next_page']))
		{
			if(isset($_POST['txt_ir']))
			header("Location:".$PHP_SELF."?adodb_next_page=".$_POST['txt_ir']);
			
			return "<font size=-1><input onblur='document.frm.submit();' name='txt_ir' type='text' value='".$_GET['adodb_next_page']."' size='3' >/".$lastPage."</font>";
		}
		else*/
		//document.frm.action=\"".$PHP_SELF."?adodb_next_page=".$_POST['txt_ir']."\";
		return "<font size=-1><input onblur='document.frm.submit();' name='txt_ir' type='text' value='".$this->curr_page."' size='3' >/".$lastPage."</font>";
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		
	}

	//-----------------------------------
	// Call this class to draw everything.
	function Render($rows=10)
	{
	global $ADODB_COUNTRECS;

		$this->rows = $rows;

		if ($this->db->dataProvider == 'informix') $this->db->cursorType = IFX_SCROLL;

		$savec = $ADODB_COUNTRECS;
		if ($this->db->pageExecuteCountRows) $ADODB_COUNTRECS = true;
		if ($this->cache)
			$rs = $this->db->CachePageExecute($this->cache,$this->sql,$rows,$this->curr_page);
		else
			$rs = $this->db->PageExecute($this->sql,$rows,$this->curr_page);
		$ADODB_COUNTRECS = $savec;

		$this->rs = $rs;
		if (!$rs) {
			print "<h3>Query failed: $this->sql</h3>";
			return;
		}

		if (!$rs->EOF && (!$rs->AtFirstPage() || !$rs->AtLastPage()))
			$header = $this->RenderNav();
		else
			$header = "&nbsp;";

		//$grid = $this->RenderGrid();//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		$footer = $this->RenderPageCount();
		
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		$datos=array();
		$datos[0]=$rs;
		$datos[1]=$header;
		$datos[2]=$footer;
		return $datos;
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		
		
		//$this->RenderLayout($header,$grid,$footer);//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------

		//$rs->Close();//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
		//$this->rs = false;//-------MODIFICADO POR RAYDEL OJEDA 23-11-2014--------
	}

	//------------------------------------------------------
	// override this to control overall layout and formating
	function RenderLayout($header,$grid,$footer,$attributes='border=1 bgcolor=beige')
	{
		echo "<table ".$attributes."><tr><td>",
				$header,
			"</td></tr><tr><td>",
				$grid,
			"</td></tr><tr><td>",
				$footer,
			"</td></tr></table>";
	}
}






