<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');

$idPagina = 167;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftProducto']['name']) || !empty($_POST['urlProducto']))) {
    if (!empty($_FILES['ftProducto']['name'])) {
        $destino = RUTA_PROYECTO . "files/productos";
        $fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);
    }

    if (!empty($_POST['urlProducto'])) {
        $fileName = $_POST['urlProducto'];
    }

    try {
        $numFotos = Productos_Fotos::numRows([ 'cpf_id_producto' => $_POST['id'] ]);
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }

    $principal = $numFotos < 1 ? 1 : 0;
    try {
        Productos_Fotos::Insert([
            'cpf_id_producto' => $_POST['id'],
            'cpf_fotos' => $fileName,
            'cpf_id_empresa' => $_SESSION["idEmpresa"],
            'cpf_tipo' => $_POST['tipoImg'],
            'cpf_fotos_prin' => SI,
            'cpf_principal' => $principal
        ]);
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }
} else {
    echo '<script type="text/javascript">window.location.href="../bd_read/catalogo-principal-fotos.php?id=' . $_POST['id'] . '&warning=WN_1";</script>';
    exit();
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/catalogo-principal-fotos.php?id=' . $_POST['id'] . '&idInsertU=' . $idInsertU . '&success=SC_1";</script>';
exit();
