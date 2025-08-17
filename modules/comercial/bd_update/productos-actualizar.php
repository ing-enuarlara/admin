<?php
require_once("../../sesion.php");

$idPagina = 24;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");
require_once(RUTA_PROYECTO . 'class/Productos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');
require_once(RUTA_PROYECTO . 'class/Productos_Tallas.php');
require_once(RUTA_PROYECTO . 'class/Productos_Relacion.php');
require_once(RUTA_PROYECTO . 'class/Producto_Categorias.php');
require_once(RUTA_PROYECTO . 'class/Producto_Sub_Categorias.php');

$codRef = $_POST["ref"] != $_POST["id"] ? $_POST["ref"] : NULL;
Productos::Update(
    [
        'cprod_nombre' => mysqli_real_escape_string($conexionBdComercial, $_POST["nombre"]),
        'cprod_costo' => $_POST["costo"],
        'cprod_detalles' => mysqli_real_escape_string($conexionBdComercial, $_POST["detalles"]),
        'cprod_exitencia' => $_POST["existencia"] ?? 0,
        'cprod_tipo' => $_POST["tipo"],
        'cprod_palabras_claves' => mysqli_real_escape_string($conexionBdComercial, $_POST["paClave"]),
        'cprod_estado' => $_POST["estado"],
        'cprod_especificaciones' => mysqli_real_escape_string($conexionBdComercial, $_POST["especificaciones"]),
        'cprod_nucleo_web' => $_POST["nucleo"] ?? NULL,
        'cprod_cod_ref' => $codRef,
        'cprod_ean_code' => $_POST["codigoEAN"] ?? NULL,
        'cprod_descuento' => $_POST["desc"] ?? NULL
    ],
    ['cprod_id' => $_POST["id"]]
);

// Guardamos Categorias
if (!empty($_POST['categoria'])) {
    Producto_Categorias::Delete( [ 'prct_producto' => $_POST["id"] ] );
    foreach ($_POST['categoria'] as $categoria) {
        Producto_Categorias::Insert(
            [
                'prct_producto' => $_POST["id"],
                'prct_categoria' => $categoria,
                'prct_id_empresa' => $_SESSION["idEmpresa"]
            ]
        );
    }
} else {
    Producto_Categorias::Delete( [ 'prct_producto' => $_POST["id"] ] );
}

// Guardamos SubCategorias
if (!empty($_POST['marca'])) {
    Producto_Sub_Categorias::Delete( [ 'psct_producto' => $_POST["id"] ] );
    foreach ($_POST['marca'] as $categoria) {
        Producto_Sub_Categorias::Insert(
            [
                'psct_producto' => $_POST["id"],
                'psct_subcategoria' => $categoria,
                'psct_id_empresa' => $_SESSION["idEmpresa"]
            ]
        );
    }
} else {
    Producto_Sub_Categorias::Delete( [ 'psct_producto' => $_POST["id"] ] );
}

// 1. Tallas
Productos_Tallas::Delete([
    'cpta_producto' => $_POST["id"],
    'cpta_prin' => NO
]);
$maxLength = max(
    count($_POST['tallas'] ?? []),
    count($_POST['stocks'] ?? []),
    count($_POST['referencias'] ?? []),
    count($_POST['codEan'] ?? [])
);
$totalStock = 0;
for ($i = 0; $i < $maxLength; $i++) {
    $talla = isset($_POST['tallas'][$i]) ? trim($_POST['tallas'][$i]) : '';
    $stock = isset($_POST['stocks'][$i]) ? max(0, intval($_POST['stocks'][$i])) : 0;
    $referencia = isset($_POST['referencias'][$i]) ? trim($_POST['referencias'][$i]) : '';
    $codEan = isset($_POST['codEan'][$i]) ? trim($_POST['codEan'][$i]) : '';

    // Si los tres están vacíos, omitir esta fila
    if (empty($talla) && empty($color) && $stock === 0 && empty($referencias)) {
        continue;
    }

    // Insertar
    Productos_Tallas::Insert([
        'cpta_talla' => $talla,
        'cpta_stock' => $stock,
        'cpta_referencia' => $referencia,
        'cpta_cod_ean' => $codEan,
        'cpta_producto' => $_POST["id"],
        'cpta_empresa' => $_SESSION["idEmpresa"]
    ]);

    $totalStock += $stock;
}
// Actualizar existencia solo si totalStock > 0
if ($totalStock > 0) {
    Productos::Update(['cprod_exitencia' => $totalStock], ['cprod_id' => $_POST["id"]]);
}

// 2. Otras
if (!empty($_POST['otras_labels']) && !empty($_POST['otras_values'])) {
    Productos_Especificaciones::Delete(
        [
            'cpt_id_producto' => $_POST["id"],
            'cpt_tech_prin' => NO,
            'cpt_tipo' => 'OTRO'
        ]
    );
    for ($i = 0; $i < count($_POST['otras_labels']); $i++) {
        $label = trim($_POST['otras_labels'][$i]);
        $value = trim($_POST['otras_values'][$i]);
        if (!empty($label) && !empty($value)) {
            Productos_Especificaciones::Insert(
                [
                    'cpt_lebel' => $label,
                    'cpt_value' => $value,
                    'cpt_id_producto' => $_POST["id"],
                    'cpt_id_empresa' => $_SESSION["idEmpresa"],
                    'cpt_tipo' => 'OTRO'
                ]
            );
        }
    }
} else {
    Productos_Especificaciones::Delete(
        [
            'cpt_id_producto' => $_POST["id"],
            'cpt_tech_prin' => NO,
            'cpt_tipo' => 'OTRO'
        ]
    );
}

// GUARDAR RELACION DE PRODUCTOS
if(!empty($_POST["productos"])){
    Productos_Relacion::Delete(['cpre_producto' => $_POST["id"]]);
    foreach ($_POST["productos"] AS $producto){
        $existe = Productos_Relacion::numRows([
            'cpre_producto' => $producto,
            'cpre_producto_relacion' => $_POST["id"]
        ]);
        if ( $existe < 1 ) {
            Productos_Relacion::Insert([
                'cpre_producto' => $_POST["id"],
                'cpre_producto_relacion' => $producto
            ]);
        }
    }
} else {
    Productos_Relacion::Delete(['cpre_producto' => $_POST["id"]]);
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/productos.php";</script>';
exit();
