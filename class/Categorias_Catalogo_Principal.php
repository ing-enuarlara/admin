<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Categorias_Catalogo_Principal extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODCOMERCIAL;

    public static $tableName = 'comercial_categoria_catalogo_principal';

    public static $primaryKey = 'ccatp_id';

    public static $tableAs = 'ccatp';

    use BDT_Join;
}