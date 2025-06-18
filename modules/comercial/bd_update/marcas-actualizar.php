<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias.php');
require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');

$idPagina = 36;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

SubCategorias::Update(
    [
        "cmar_nombre" => $_POST["nombre"],
        "cmar_menu" => $_POST["menu"],
        "cmar_mas_productos" => $_POST["masJoyas"]
    ],
    ["cmar_id" => $_POST["id"]]
);

if (!empty($_POST["categorias"])) {
    foreach ($_POST["categorias"] as $categoria) {
        Sub_Categorias::deleteBeforeInsert(
            [
                "subca_marca" => $_POST["id"],
                "subca_cate" => $categoria
            ],
            [
                "subca_marca" => $_POST["id"],
                "subca_cate" => $categoria,
                "subca_prin" => NO
            ]
        );
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/marcas.php";</script>';
exit();
