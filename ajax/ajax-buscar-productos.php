<?php
include("../modules/sesion.php");
require_once(RUTA_PROYECTO . "class/Productos.php");
require_once(RUTA_PROYECTO . "class/Productos_Tallas.php");

$search = $_GET["term"];
$idProducto = $_GET["idProducto"] ?? NULL;
$esEditar = $idProducto != NULL ? "cprod_id != {$idProducto} AND " : "";

Productos_Tallas::foreignKey(Productos_Tallas::LEFT, [
    "cpta_producto" => 'cprod_id',
    "cpta_prin" => "'" . NO . "'"
]);
$result = Productos::SelectJoin(
    [
        "cprod_id_empresa" => $_SESSION["idEmpresa"],
        Productos::OTHER_PREDICATE => "{$esEditar}(cprod_id LIKE '%$search%' OR cprod_nombre LIKE '%$search%' OR cprod_cod_ref LIKE '%$search%' OR cprod_ean_code LIKE '%$search%')"

    ],
    "cprod_id, cprod_cod_ref, cprod_ean_code, cprod_nombre, cprod_id_empresa, GROUP_CONCAT(cpta_referencia SEPARATOR ', ') AS cprod_referencias, GROUP_CONCAT(cpta_cod_ean SEPARATOR ', ') AS cprod_cod_ean",
    [
        Productos_Tallas::class
    ],
    "",
    "cprod_id",
    "",
    "cprod_id DESC"
);


$results = [];
foreach ($result AS $row) {
    $results[] = [

        "id" => $row["cprod_id"],
        "text" => strtoupper($row["cprod_nombre"]),
    ];
}

echo json_encode($results);
?>
