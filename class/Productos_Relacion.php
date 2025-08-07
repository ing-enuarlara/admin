<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Productos_Relacion extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODCOMERCIAL;

    public static $tableName = 'comercial_productos_relacion';

    public static $primaryKey = 'cpre_id';

    public static $tableAs = 'cpre';

    use BDT_Join;
}