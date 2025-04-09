<?php
require_once("../../sesion.php");

$idPagina = 156;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

try {
    $conexionBdComercial->query("INSERT INTO comercial_ofertas(ofer_fecha_inicio, ofer_fecha_fin, ofer_title, ofer_descripcion, ofer_tipo, ofer_id_empresa) VALUES ('" . $_POST["fechaInicio"] . "', '" . $_POST["fechaFinal"] . "', '" . $_POST["titulo"] . "', '" . $_POST["descripcion"] . "', '" . $_POST["tipoOfertas"] . "', '" . $_SESSION["idEmpresa"] . "')");
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}

$idInsertU = mysqli_insert_id($conexionBdComercial);

if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftOferta']['name']) || !empty($_POST['urlImgOferta']))) {
    if (!empty($_FILES['ftOferta']['name'])) {
        $destino = RUTA_PROYECTO . "files/ofertas";
        $fileName = subirArchivosAlServidor($_FILES['ftOferta'], 'ofer', $destino);
    }

    if (!empty($_POST['urlImgOferta'])) {
        $fileName = $_POST['urlImgOferta'];
    }

    try {
        $conexionBdComercial->query("UPDATE comercial_ofertas SET ofer_img='" . $fileName . "', ofer_tipo_img = '" . $_POST['tipoImg'] . "' WHERE ofer_id = '" . $idInsertU . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }
}

if ($_POST["tipoOfertas"] != TODA && !empty($_POST["articulos"])) {
    foreach ($_POST["articulos"] as $articulo) {
        try {
            $conexionBdComercial->query("INSERT INTO comercial_ofertas_productos(cop_id_oferta, cop_id_articulo) VALUES ('" . $idInsertU . "', '" . $articulo . "')");
        } catch (Exception $e) {
            include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
        }
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/ofertas.php?idInsertU=' . $idInsertU . '&success=SC_1";</script>';
exit();
