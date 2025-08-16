<?php
$nombrePagina = "productos.php";
if (empty($_REQUEST["nume"])) {
    $_REQUEST["nume"] = 1;
}

if (!empty($filtro)) {
    $numProductosBD = Productos::SelectJoin(
        $predicado,
        "cprod_id",
        [
            Tipos_Productos::class,
            Categorias::class,
            SubCategorias::class,
            Productos_Tallas::class
        ],
        "",
        "cprod_id"
    );

    $numRegistros = !empty($numProductosBD) ? count($numProductosBD) : 0;
} else {
    $numRegistros = Productos::numRows($predicado);
}

$registros = 10;
$pagina = !empty($_REQUEST['nume']) ? intval($_REQUEST["nume"]) : 1;
if (is_numeric($pagina)) {
    $inicio = (($pagina - 1) * $registros);
} else {
    $inicio = 1;
}