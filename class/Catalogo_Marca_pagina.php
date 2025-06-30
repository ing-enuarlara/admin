<?php
require_once RUTA_PROYECTO.'/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO.'/class/Tables/BDT_JoinImplements.php';

class Catalogo_Marca_pagina extends BDT_Tablas implements BDT_JoinImplements {
    public static $schema = BDMODCOMERCIAL;

    public static $tableName = 'comercial_pagina_marca_catalogo';

    public static $primaryKey = 'cpmc_id';

    public static $tableAs = 'cpmc';

    use BDT_Join;
}