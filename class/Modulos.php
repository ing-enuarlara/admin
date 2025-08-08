<?php
require_once RUTA_PROYECTO . '/class/Tables/BDT_Join.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_tablas.php';
require_once RUTA_PROYECTO . '/class/Tables/BDT_JoinImplements.php';

class Modulos extends BDT_Tablas implements BDT_JoinImplements
{

    public const DASHBOARD              = 1;
    public const ADMINISTRATIVO         = 2;
    public const COMERCIAL              = 3;
    public const MI_CUENTA              = 4;
    public const SISTEMA                = 5;
    public const CLIENTES_ADMIN         = 6;
    public const PAGINA_WEB             = 7;
    public const EDITAR_PERFIL          = 8;
    public const MIS_VENTAS             = 9;
    public const MIS_PEDIDOS            = 10;
    public const CAMBIAR_CLAVE          = 11;
    public const MI_CALENDARIO          = 12;
    public const MENSAJES               = 13;
    public const ROLES                  = 14;
    public const USUARIOS               = 15;
    public const CLIENTES               = 16;
    public const CATALOGO_PRINCIPAL     = 17;
    public const PRODUCTOS              = 18;
    public const OFERTAS                = 19;
    public const COTIZACIONES           = 20;
    public const PEDIDOS                = 21;
    public const REMISIONES             = 22;
    public const FACTURACION            = 23;
    public const CONFIG_SISTEMA         = 24;
    public const PAGINAS                = 25;
    public const MODULOS                = 26;
    public const HISTORIAL_ACCIONES     = 27;
    public const BLOGS                  = 28;
    public const SLIDERS_BANNERS        = 29;
    public const RESENAS                = 30;
    public const CONFIG_PAGINA          = 31;
    public const COLOR_PAGINA           = 32;
    public const PAGINAS_LEGALES        = 33;
    public const CATEGORIAS_CATALOGO    = 34;
    public const SUBCATEGORIAS_CATALOGO = 35;
    public const TIPOS_ARTICULOS        = 36;
    public const ARTICULOS              = 37;
    public const CATEGORIAS             = 38;
    public const SUBCATEGORIAS          = 39;
    public const TIPOS_PRODUCTOS        = 40;
    public const PRODUCTO               = 41;
    public const COMBOS                 = 42;

    public static $schema = BDMODSISTEMA;

    public static $tableName = 'sistema_modulos';

    public static $primaryKey = 'mod_id';

    public static $tableAs = 'mod';

    use BDT_Join;
}
