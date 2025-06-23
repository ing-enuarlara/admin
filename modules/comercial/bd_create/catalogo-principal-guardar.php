<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');

$idPagina = 162;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

$subCategoria = 0;
if (!empty($_POST["marca"])) {
    $subCategoria = $_POST["marca"];
}

try {
    $idInsertU = Catalogo_Principal::Insert([
        'cprin_nombre' => $_POST["nombre"],
        'cprin_costo' => $_POST["costo"],
        'cprin_detalles' => $_POST["detalles"],
        'cprin_exitencia' => $_POST["existencia"],
        'cprin_marca' => $subCategoria,
        'cprin_categoria' => $_POST["categoria"],
        'cprin_tipo' => $_POST["tipo"],
        'cprin_palabras_claves' => $_POST["paClave"],
        'cprin_id_empresa' => $_SESSION["idEmpresa"],
        'cprin_fecha_creacion' => date('Y-m-d H:i:s'),
        'cprin_especificaciones' => $_POST["especificaciones"],
        'cprin_cod_ref' => $_POST["ref"]
    ]);
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}

// 1. Colores
if (!empty($_POST['especificaciones_colores'])) {
    foreach ($_POST['especificaciones_colores'] as $color) {
        Productos_Especificaciones::Insert([
            'cpt_value' => $color,
            'cpt_id_producto' => $idInsertU,
            'cpt_id_empresa' => $_SESSION["idEmpresa"],
            'cpt_tech_prin' => 'SI',
            'cpt_tipo' => 'COLOR'
        ]);
    }
}

// 2. Tallas
if (!empty($_POST['especificaciones_tallas'])) {
    foreach ($_POST['especificaciones_tallas'] as $talla) {
        Productos_Especificaciones::Insert([
            'cpt_value' => $talla,
            'cpt_id_producto' => $idInsertU,
            'cpt_id_empresa' => $_SESSION["idEmpresa"],
            'cpt_tech_prin' => 'SI',
            'cpt_tipo' => 'TALLA'
        ]);
    }
}

// 3. Otras
if (!empty($_POST['otras_labels']) && !empty($_POST['otras_values'])) {
    for ($i = 0; $i < count($_POST['otras_labels']); $i++) {
        $label = trim($_POST['otras_labels'][$i]);
        $value = trim($_POST['otras_values'][$i]);
        if ($label && $value) {
            Productos_Especificaciones::Insert([
                'cpt_lebel' => $label,
                'cpt_value' => $value,
                'cpt_id_producto' => $idInsertU,
                'cpt_id_empresa' => $_SESSION["idEmpresa"],
                'cpt_tech_prin' => 'SI',
                'cpt_tipo' => 'OTRO'
            ]);
        }
    }
}

if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftProducto']['name']) || !empty($_POST['urlProducto']))) {
    if (!empty($_FILES['ftProducto']['name'])) {
        $destino = RUTA_PROYECTO . "files/productos";
        $fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);
    }

    if (!empty($_POST['urlProducto'])) {
        $fileName = $_POST['urlProducto'];
    }

    Productos_Fotos::Insert([
        'cpf_id_producto' => $idInsertU,
        'cpf_fotos' => $fileName,
        'cpf_id_empresa' => $_SESSION["idEmpresa"],
        'cpf_principal' => 1,
        'cpf_tipo' => $_POST['tipoImg'],
        'cpf_fotos_prin' => SI
    ]);
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/catalogo-principal-editar.php?id=' . $idInsertU . '";</script>';
exit();
