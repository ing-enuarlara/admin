<?php
    require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Tipos_Catalogo_Principal.php');

    $idPagina = 188;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        Tipos_Catalogo_Principal::Update(
            [
                "ctipop_nombre" => $_POST["nombre"],
                "ctipop_estado" => $_POST["estado"]
            ],
            [
                "ctipop_id" => $_POST["id"]
            ]
        );
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/tipo-articulos.php";</script>';
    exit();