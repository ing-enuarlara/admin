<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Paginas extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODSISTEMA;

    public static $tableName = 'sistema_paginas';

    public static $primaryKey = 'pag_id';

    public static $tableAs = 'pag';

    use BDT_Join;
}