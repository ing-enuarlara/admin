<?php
    require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');

    $idPagina = 179;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $idInsertU = SubCategorias_Catalogo_Principal::Insert([
            "cmarp_nombre" => $_POST["nombre"],
            "cmarp_categoria" => $_POST["categoria"],
            "cmarp_menu" => $_POST["menu"],
            "cmarp_mas_productos" => $_POST["masJoyas"],
            "cmarp_id_empresa" => $_SESSION["idEmpresa"]
        ]);
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/marcas-catalogo-editar.php?id=' . $idInsertU . '";</script>';
    exit();