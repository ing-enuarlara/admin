<?php
    require_once("../../sesion.php");
    require_once(RUTA_PROYECTO . 'class/Categorias_Catalogo_Principal.php');

    $idPagina = 176;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        Categorias_Catalogo_Principal::Update(
            [
                "ccatp_id" => $_POST["id"],
                "ccatp_nombre" => $_POST["nombre"],
                "ccatp_menu" => $_POST["menu"],
                "ccatp_otros" => $_POST["footer"]
            ],
            [
                "ccatp_id" => $_POST["id"]
            ]
        );
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/categorias-catalogo.php";</script>';
    exit();