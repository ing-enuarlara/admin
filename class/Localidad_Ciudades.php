<?php
require_once RUTA_PROYECTO . '/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_JoinImplements.php';

class Localidad_Ciudades extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDADMIN;

    public static $tableName = 'localidad_ciudades';

    public static $primaryKey = 'ciu_id';

    public static $tableAs = 'ciu';

    use BDT_Join;
}