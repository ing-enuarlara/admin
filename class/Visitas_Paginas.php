<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Visitas_Paginas extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODPAGINAWEB;

    public static $tableName = 'visitas_paginas';

    public static $primaryKey = 'vis_id';

    public static $tableAs = 'vis';

    use BDT_Join;
}