<?php
    require_once("../../sesion.php");

    $idPagina = 34;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    require_once(RUTA_PROYECTO . 'class/SubCategorias.php');
    require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');
    
    $idInsertU = SubCategorias::Insert([
        "cmar_nombre" => $_POST["nombre"],
        "cmar_menu" => $_POST["menu"],
        "cmar_mas_productos" => $_POST["masJoyas"],
        "cmar_id_empresa" => $_SESSION["idEmpresa"]
    ]);

    if(!empty($_POST["categorias"])){
        foreach ($_POST["categorias"] as $categoria) {
            Sub_Categorias::Insert([
                "subca_marca" => $idInsertU,
                "subca_cate" => $categoria
            ]);
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/marcas-editar.php?id=' . $idInsertU . '";</script>';
    exit();