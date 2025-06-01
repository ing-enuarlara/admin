<?php
require_once RUTA_PROYECTO . '/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_JoinImplements.php';

class Localidad_Departamentos extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDADMIN;

    public static $tableName = 'localidad_departamentos';

    public static $primaryKey = 'dep_id';

    public static $tableAs = 'dep';

    use BDT_Join;
}