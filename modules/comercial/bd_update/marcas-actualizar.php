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
    Sub_Categorias::Delete(
        [
            "subca_marca" => $_POST["id"],
            "subca_prin" => NO
        ]
    );
    foreach ($_POST["categorias"] as $categoria) {
        Sub_Categorias::Insert(
            [
                "subca_marca" => $_POST["id"],
                "subca_cate" => $categoria
            ]
        );
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/marcas.php";</script>';
exit();
