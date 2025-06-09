<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');

$idPagina = 164;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

$subCategoria = 0;
if (!empty($_POST["marca"])) {
    $subCategoria = $_POST["marca"];
}

try {
    Catalogo_Principal::Update(
        [
            'cprin_nombre' => $_POST["nombre"],
            'cprin_costo' => $_POST["costo"],
            'cprin_detalles' => $_POST["detalles"],
            'cprin_exitencia' => $_POST["existencia"],
            'cprin_marca' => $subCategoria,
            'cprin_categoria' => $_POST["categoria"],
            'cprin_tipo' => $_POST["tipo"],
            'cprin_palabras_claves' => $_POST["paClave"],
            'cprin_estado' => $_POST["estado"],
            'cprin_fecha_creacion' => date('Y-m-d H:i:s'),
            'cprin_especificaciones' => $_POST["especificaciones"]
        ],
        [
            'cprin_id' => $_POST["id"]
        ]
    );
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
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
        Productos_Fotos::Update(
            [
                'cpf_fotos' => $fileName,
                'cpf_tipo' => $_POST['tipoImg']
            ],
            [
                'cpf_id_producto' => $_POST["id"],
                'cpf_principal' => 1
            ]
        );
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/catalogo-principal.php";</script>';
exit();
