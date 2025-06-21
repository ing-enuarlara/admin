<?php
require_once("../../sesion.php");

$idPagina = 24;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');

$subCategoria = 0;
if (!empty($_POST["marca"])) {
    $subCategoria = $_POST["marca"];
}

try {
    $conexionBdComercial->query("UPDATE comercial_productos SET 
        cprod_nombre='" . $_POST["nombre"] . "', 
        cprod_costo='" . $_POST["costo"] . "', 
        cprod_detalles='" . $_POST["detalles"] . "', 
		 cprod_especificaciones='" . $_POST["especificaciones"] . "',
        cprod_exitencia='" . $_POST["existencia"] . "', 
        cprod_marca='" . $subCategoria . "', 
        cprod_categoria='" . $_POST["categoria"] . "', 
        cprod_tipo='" . $_POST["tipo"] . "', 
        cprod_palabras_claves='" . $_POST["paClave"] . "', 
        cprod_estado='" . $_POST["estado"] . "', 
        cprod_fecha_creacion=now()
        WHERE cprod_id='" . $_POST["id"] . "'");
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}

// 1. Colores
if (!empty($_POST['especificaciones_colores'])) {
    Productos_Especificaciones::Delete(
        [
            'cpt_id_producto' => $_POST["id"],
            'cpt_tech_prin' =>NO,
            'cpt_tipo' => 'COLOR'
        ]
    );
    foreach ($_POST['especificaciones_colores'] as $color) {
        Productos_Especificaciones::Insert(
            [
                'cpt_value' => $color,
                'cpt_id_producto' => $_POST["id"],
                'cpt_id_empresa' => $_SESSION["idEmpresa"],
                'cpt_tipo' => 'COLOR'
            ]
        );
    }
}

// 2. Tallas
if (!empty($_POST['especificaciones_tallas'])) {
    Productos_Especificaciones::Delete(
        [
            'cpt_id_producto' => $_POST["id"],
            'cpt_tech_prin' => NO,
            'cpt_tipo' => 'TALLA'
        ]
    );
    foreach ($_POST['especificaciones_tallas'] as $talla) {
        Productos_Especificaciones::Insert(
            [
                'cpt_value' => $talla,
                'cpt_id_producto' => $_POST["id"],
                'cpt_id_empresa' => $_SESSION["idEmpresa"],
                'cpt_tipo' => 'TALLA'
            ]
        );
    }
}

// 3. Otras
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
        if ($label && $value) {
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
}

if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftProducto']['name']) || !empty($_POST['urlProducto']))) {
    if (!empty($_FILES['ftProducto']['name'])) {
        $destino = RUTA_PROYECTO . "files/productos";
        $fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);
    }

    if (!empty($_POST['urlProducto'])) {
        $fileName = $_POST['urlProducto'];
    }

    try {
        $conexionBdComercial->query("UPDATE comercial_productos_fotos SET cpf_fotos='" . $fileName . "', cpf_tipo = '" . $_POST['tipoImg'] . "' WHERE cpf_id_producto='" . $_POST["id"] . "' AND cpf_principal=1");
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/productos.php";</script>';
exit();
