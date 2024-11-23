<?php
switch($_SERVER['HTTP_HOST']){
	case 'localhost':
        define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/ing-enuarlara.co/admin/');
        define('REDIRECT_ROUTE', 'http://localhost/ing-enuarlara.co/admin/');
        error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        break;

        case 'adminzefe.ing-enuarlara.com';
        define('RUTA_PROYECTO', '/home3/ingenuar/adminzefe.ing-enuarlara.com/');
        define('REDIRECT_ROUTE', 'https://adminzefe.ing-enuarlara.com');
        error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        break;
}

include(RUTA_PROYECTO."sensitive.php");

switch (ENVIROMENT) {
        case 'LOCAL':
	include(RUTA_PROYECTO."/conexion-datos.php");
	break;

	case 'TEST':
	include(RUTA_PROYECTO."/conexion-datos-developer.php");
	break;

        case 'PROD':
        include(RUTA_PROYECTO."/conexion-datos-production.php");
        break;

        default:
        include(RUTA_PROYECTO."/conexion-datos.php");
        break;
}