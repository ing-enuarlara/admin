<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');

$idPagina = 57;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftProducto']['name'][0]) || !empty($_POST['urlProducto']))) {
    $fileNames = [];
    if (!empty($_FILES['ftProducto']['name'][0])) {
        $destino = RUTA_PROYECTO . "files/productos";

        foreach ($_FILES['ftProducto']['tmp_name'] as $i => $tmpName) {
            if ($_FILES['ftProducto']['error'][$i] === UPLOAD_ERR_OK) {
                $nuevoNombre = uniqid('ftp_') . '.' . pathinfo($_FILES['ftProducto']['name'][$i], PATHINFO_EXTENSION);
                move_uploaded_file($tmpName, $destino . '/' . $nuevoNombre);
                $fileNames[] = $nuevoNombre;
            }
        }
    }

    if (!empty($_POST['urlProducto'])) {
        $fileNames[] = $_POST['urlProducto'];
    }

    try {
        $numFotos = Productos_Fotos::numRows([ 'cpf_id_producto' => $_POST['id'], 'cpf_fotos_prin' => NO ]);
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }

    $esPrimera = $numFotos < 1;
    foreach ($fileNames as $i => $fileName) {
        try {
            Productos_Fotos::Insert([
                'cpf_id_producto' => $_POST['id'],
                'cpf_fotos' => $fileName,
                'cpf_id_empresa' => $_SESSION["idEmpresa"],
                'cpf_tipo' => $_POST['tipoImg'],
                'cpf_principal' => $esPrimera && $i === 0 ? 1 : 0
            ]);
        } catch (Exception $e) {
            include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
        }
    }
    $idInsertU = 11;
} else {
    echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id=' . $_POST['id'] . '&warning=WN_1";</script>';
    exit();
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id=' . $_POST['id'] . '&idInsertU=' . $idInsertU . '&success=SC_1";</script>';
exit();
