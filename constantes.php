<?php
switch($_SERVER['HTTP_HOST']){
	case 'localhost':
        define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/admin/');
        define('REDIRECT_ROUTE', 'http://localhost/admin/');
        define('ENVIROMENT', 'PROD');
        error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        break;

        case 'adminocb.oceanblue.es';
        define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/');
        define('REDIRECT_ROUTE', 'https://adminocb.oceanblue.es/');
        define('ENVIROMENT', 'PROD');
        error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        break;

        case 'adminocb.ing-enuarlara.com';
        define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/admin/');
        define('REDIRECT_ROUTE', 'https://adminocb.ing-enuarlara.com/admin/');
        define('ENVIROMENT', 'PROD');
        error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
        break;

        case 'preview.trtmotorcycle.es';
        define('RUTA_PROYECTO', $_SERVER['DOCUMENT_ROOT'].'/cPanel/');
        define('REDIRECT_ROUTE', 'https://preview.trtmotorcycle.es/cPanel/');
        define('ENVIROMENT', 'TRT');
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

	case 'TRT':
	include(RUTA_PROYECTO."/conexion-datos-trt.php");
	break;

        default:
        include(RUTA_PROYECTO."/conexion-datos.php");
        break;
}

define('TIPO_IMG', 'IMG');
define('TIPO_URL', 'URL');

define('SI', 'SI');
define('NO', 'NO');
define('SI_N', 1);
define('NO_N', 0);

define('MENU_PADRE', 'menu-padre');
define('SUB_MENU', 'sub-menu');
define('MENU', 'menu');

define('TODA', 'TODA');
define('PROD', 'PROD');
define('CATE', 'CATE');
define('SUB_CATE', 'SUB_CATE');
define('TIPO', 'TIPO');