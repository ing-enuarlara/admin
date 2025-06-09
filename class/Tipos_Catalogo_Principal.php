<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Tipos_Catalogo_Principal extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODCOMERCIAL;

    public static $tableName = 'comercial_tipo_catalogo_principal';

    public static $primaryKey = 'ctipop_id';

    public static $tableAs = 'ctipop';

    use BDT_Join;
}