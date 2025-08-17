<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Producto_Sub_Categorias extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODCOMERCIAL;

    public static $tableName = 'comercial_producto_subcate';

    public static $primaryKey = 'psct_id';

    public static $tableAs = 'psct';

    use BDT_Join;
}