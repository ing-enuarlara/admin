<?php
    require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Tipos_Catalogo_Principal.php');

    $idPagina = 186;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $idInsertU = Tipos_Catalogo_Principal::Insert(
            [
                "ctipop_nombre" => $_POST["nombre"],
                "ctipop_estado" => 1,
                "ctipop_id_empresa" => $_SESSION["idEmpresa"]
            ]
        );
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/tipo-articulos-editar.php?id=' . $idInsertU . '";</script>';
    exit();