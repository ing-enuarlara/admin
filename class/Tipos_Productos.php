<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Tipos_Productos extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODCOMERCIAL;

    public static $tableName = 'comercial_marca_productos';

    public static $primaryKey = 'ctipo_id';

    public static $tableAs = 'ctipo';

    use BDT_Join;
}