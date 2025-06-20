<?php
    require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');
    require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');

    $idPagina = 179;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $idInsertU = SubCategorias_Catalogo_Principal::Insert([
        "cmarp_nombre" => $_POST["nombre"],
        "cmarp_menu" => $_POST["menu"],
        "cmarp_mas_productos" => $_POST["masJoyas"],
        "cmarp_id_empresa" => $_SESSION["idEmpresa"]
    ]);

    if(!empty($_POST["categorias"])){
        foreach ($_POST["categorias"] as $categoria) {
            Sub_Categorias::Insert([
                "subca_marca" => $idInsertU,
                "subca_cate" => $categoria,
                "subca_prin" => SI
            ]);
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/marcas-catalogo-editar.php?id=' . $idInsertU . '";</script>';
    exit();