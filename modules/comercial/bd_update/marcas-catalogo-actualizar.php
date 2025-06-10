<?php
    require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');

    $idPagina = 162;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        SubCategorias_Catalogo_Principal::Update(
            [
                "cmarp_nombre" => $_POST["nombre"],
                "cmarp_categoria" => $_POST["categoria"],
                "cmarp_menu" => $_POST["menu"],
                "cmarp_mas_productos" => $_POST["masJoyas"]
            ],
            [
                "cmarp_id" => $_POST["id"]
            ]
        );
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/marcas-catalogo.php";</script>';
    exit();