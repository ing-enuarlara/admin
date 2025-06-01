<?php
require_once RUTA_PROYECTO . '/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_JoinImplements.php';

class Localidad_Paises extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDADMIN;

    public static $tableName = 'localidad_paises';

    public static $primaryKey = 'pais_id';

    public static $tableAs = 'pais';

    use BDT_Join;
}