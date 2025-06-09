<?php
$nombrePagina = "catalogo-principal.php";
if (empty($_REQUEST["nume"])) {
    $_REQUEST["nume"] = 1;
}

$productosBD = Catalogo_Principal::SelectJoin(
    $predicado,
    "cprin_id, cprin_cod_ref, cprin_nombre, cprin_costo, cprin_exitencia, cprin_estado, cprin_categoria, cprin_marca, cprin_id_empresa, ccatp_nombre, cmarp_nombre",
    [
        Categorias_Catalogo_Principal::class,
        SubCategorias_Catalogo_Principal::class
    ]
);

$numRegistros = !empty($productosBD) ? count($productosBD) : 0;
$registros = 10;
$pagina = !empty($_REQUEST['nume']) ? intval($_REQUEST["nume"]) : 1;
if (is_numeric($pagina)) {
    $inicio = (($pagina - 1) * $registros);
} else {
    $inicio = 1;
}

$productos = array_slice($productosBD, $inicio, $registros);