<?php
require_once RUTA_PROYECTO . '/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_JoinImplements.php';

class Clientes_Modulos extends BDT_Tablas implements BDT_JoinImplements
{

    public static $schema = BDADMIN;

    public static $tableName = 'modulos_clien_admin';

    public static $primaryKey = 'mxca_id';

    public static $tableAs = 'mxca';

    use BDT_Join;
}
