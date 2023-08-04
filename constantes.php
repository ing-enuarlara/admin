<?php
define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/ing-enuarlara.co/admin/');
require_once(RUTA_PROYECTO."/sensitive.php");

define('EMAIL_SENDER', 'enuar2110@gmail.com');
define('NAME_SENDER', '@ing_enuarlara.co');

switch($_SERVER['HTTP_HOST']){
	case 'localhost':
        define('REDIRECT_ROUTE', 'http://localhost/ing-enuarlara.co/admin/');
        error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        break;

	// case 'dominio.com.co':
        // define('REDIRECT_ROUTE', 'https://dominio.com.co');
        // error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        // break;
}