<?php
//============================================================+
// File name   : tcpdf_include_once.php
// Begin       : 2008-05-14
// Last Update : 2014-12-10
//
// Description : Search and include_once the TCPDF library.
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Search and include_once the TCPDF library.
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Include the main class.
 * @author Nicola Asuni
 * @since 2013-05-14
 */

// always load alternative config file for examples
require_once('config/tcpdf_config_alt.php');

// Include the main TCPDF library (search the library on the following directories).
$tcpdf_include_once_dirs = array(
	realpath('../tcpdf.php'),
	'/usr/share/php/tcpdf/tcpdf.php',
	'/usr/share/tcpdf/tcpdf.php',
	'/usr/share/php-tcpdf/tcpdf.php',
	'/var/www/tcpdf/tcpdf.php',
	'/var/www/html/tcpdf/tcpdf.php',
	'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ($tcpdf_include_once_dirs as $tcpdf_include_once_path) {
	if (@file_exists($tcpdf_include_once_path)) {
		require_once($tcpdf_include_once_path);
		break;
	}
}

//============================================================+
// END OF FILE
//============================================================+
