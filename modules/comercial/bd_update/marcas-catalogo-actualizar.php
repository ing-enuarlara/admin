<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');

$idPagina = 162;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

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

if (!empty($_POST["categorias"])) {
    foreach ($_POST["categorias"] as $categoria) {
        Sub_Categorias::deleteBeforeInsert(
            [
                "subca_marca" => $_POST["id"],
                "subca_cate" => $categoria,
                "subca_prin" => SI
            ],
            [
                "subca_marca" => $_POST["id"],
                "subca_cate" => $categoria,
                "subca_prin" => SI
            ]
        );
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/marcas-catalogo.php";</script>';
exit();
