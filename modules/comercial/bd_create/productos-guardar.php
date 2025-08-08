<?php
require_once("../../sesion.php");

$idPagina = 22;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");
require_once(RUTA_PROYECTO . 'class/Productos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');
require_once(RUTA_PROYECTO . 'class/Productos_Tallas.php');
require_once(RUTA_PROYECTO . 'class/Productos_Relacion.php');

$subCategoria = 0;
if (!empty($_POST["marca"])) {
    $subCategoria = $_POST["marca"];
}

$idInsertU = Productos::Insert([
    'cprod_nombre' => mysqli_real_escape_string($conexionBdComercial, $_POST["nombre"]),
    'cprod_costo' => $_POST["costo"],
    'cprod_detalles' => mysqli_real_escape_string($conexionBdComercial, $_POST["detalles"]),
    'cprod_exitencia' => $_POST["existencia"] ?? 0,
    'cprod_marca' => $subCategoria,
    'cprod_categoria' => $_POST["categoria"],
    'cprod_tipo' => $_POST["tipo"],
    'cprod_palabras_claves' => mysqli_real_escape_string($conexionBdComercial, $_POST["paClave"]),
    'cprod_id_empresa' => $_SESSION["idEmpresa"],
    'cprod_fecha_creacion' => date("Y-m-d H:i:s"),
    'cprod_especificaciones' => mysqli_real_escape_string($conexionBdComercial, $_POST["especificaciones"]),
    'cprod_cod_ref' => $_POST["ref"],
    'cprod_ean_code' => $_POST["codigoEAN"] ?? NULL,
    'cprod_descuento' => $_POST["desc"] ?? NULL
]);

// 1. Tallas
$maxLength = max(
    count($_POST['tallas'] ?? []),
    count($_POST['colores'] ?? []),
    count($_POST['colores2'] ?? []),
    count($_POST['stocks'] ?? []),
    count($_POST['referencias'] ?? []),
    count($_POST['codEan'] ?? [])
);
$totalStock = 0;
for ($i = 0; $i < $maxLength; $i++) {
    $talla = isset($_POST['tallas'][$i]) ? trim($_POST['tallas'][$i]) : '';
    $color = isset($_POST['colores'][$i]) ? trim($_POST['colores'][$i]) : '';
    $color2 = isset($_POST['colores2'][$i]) ? trim($_POST['colores2'][$i]) : '';
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
        'cpta_color' => $color,
        'cpta_color2' => $color2,
        'cpta_stock' => $stock,
        'cpta_referencia' => $referencia,
        'cpta_cod_ean' => $codEan,
        'cpta_producto' => $idInsertU,
        'cpta_empresa' => $_SESSION["idEmpresa"]
    ]);

    $totalStock += $stock;
}
// Actualizar existencia solo si totalStock > 0
if ($totalStock > 0) {
    Productos::Update(['cprod_exitencia' => $totalStock], ['cprod_id' => $idInsertU]);
}

// 3. Otras
if (!empty($_POST['otras_labels']) && !empty($_POST['otras_values'])) {
    for ($i = 0; $i < count($_POST['otras_labels']); $i++) {
        $label = trim($_POST['otras_labels'][$i]);
        $value = trim($_POST['otras_values'][$i]);
        if (!empty($label) && !empty($value)) {
            Productos_Especificaciones::Insert([
                'cpt_lebel' => $label,
                'cpt_value' => $value,
                'cpt_id_producto' => $idInsertU,
                'cpt_id_empresa' => $_SESSION["idEmpresa"],
                'cpt_tipo' => 'OTRO'
            ]);
        }
    }
}

// GUARDAR RELACION DE PRODUCTOS
if(!empty($_POST["productos"])){
    foreach ($_POST["productos"] AS $producto){
        Productos_Relacion::Insert([
            'cpre_producto' => $idInsertU,
            'cpre_producto_relacion' => $producto
        ]);
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/productos-editar.php?id=' . $idInsertU . '";</script>';
exit();
