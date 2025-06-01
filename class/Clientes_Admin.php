<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Clientes_Admin extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDADMIN;

    public static $tableName = 'clientes_admin';

    public static $primaryKey = 'cliAdmi_id';

    public static $tableAs = 'cliAdmi';

    use BDT_Join;
}