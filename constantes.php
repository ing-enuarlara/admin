<?php
switch($_SERVER['HTTP_HOST']){
	case 'localhost':
        define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/admin/');
        define('REDIRECT_ROUTE', 'http://localhost/admin/');
        error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        break;

        case 'adminocb.oceanblue.es';
        define('RUTA_PROYECTO', '/var/www/vhosts/oceanblue.es/adminocb.oceanblue.es/admin/');
        define('REDIRECT_ROUTE', 'https://adminocb.oceanblue.es/admin/');
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