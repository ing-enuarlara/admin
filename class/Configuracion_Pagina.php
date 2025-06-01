<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Configuracion_Pagina extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODPAGINAWEB;

    public static $tableName = 'configuracion';

    public static $primaryKey = 'conf_id';

    public static $tableAs = 'conf';

    use BDT_Join;
}