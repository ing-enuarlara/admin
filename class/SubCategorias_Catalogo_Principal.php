<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class SubCategorias_Catalogo_Principal extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODCOMERCIAL;

    public static $tableName = 'comercial_marca_catalogo_principal';

    public static $primaryKey = 'cmarp_id';

    public static $tableAs = 'cmarp';

    use BDT_Join;
}