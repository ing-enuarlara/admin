<?php
switch($_SERVER['HTTP_HOST']){
	case 'localhost':
        define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/ing-enuarlara.co/admin/');
        define('REDIRECT_ROUTE', 'http://localhost/ing-enuarlara.co/admin/');
        break;

	// case 'dominio.com.co':
        // define('RUTA_PROYECTO', '/home4/nose/public_html/dominio.com.co');
        // define('REDIRECT_ROUTE', 'https://dominio.com.co');
        // error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        // break;
}
include(RUTA_PROYECTO."sensitive.php");