<?php
$nombrePagina = "productos.php";
if (empty($_REQUEST["nume"])) {
    $_REQUEST["nume"] = 1;
}

$productosBD = Productos::SelectJoin(
    $predicado,
    "cprod_id, cprod_cod_ref, cprod_nombre, cprod_costo, cprod_exitencia, cprod_estado, cprod_tipo, cprod_categoria, cprod_marca, cprod_id_empresa, ctipo_nombre, ccat_nombre, cmar_nombre, GROUP_CONCAT(cpta_referencia SEPARATOR ', ') AS cprod_referencias",
    [
        Tipos_Productos::class,
        Categorias::class,
        SubCategorias::class
    ],
    "LEFT JOIN " . Productos_Tallas::$schema . "." . Productos_Tallas::$tableName . " ON cpta_producto = cprod_id AND cpta_prin = 'NO'",
    "cprod_id",
    "",
    "cprod_id DESC"
);

// APLICAR FILTROS
$productosFiltrados = array_filter($productosBD, function ($producto) {
    if (!empty($_REQUEST['marca']) && ($producto['ctipo_nombre'] ?? '') != $_REQUEST['marca']) {
        return false;
    }
    if (!empty($_REQUEST['cate']) && ($producto['ccat_nombre'] ?? '') != $_REQUEST['cate']) {
        return false;
    }
    if (!empty($_REQUEST['subCate']) && ($producto['cmar_nombre'] ?? '') != $_REQUEST['subCate']) {
        return false;
    }
    if (!empty($_REQUEST['tipo']) && ($producto['cmar_nombre'] ?? '') != $_REQUEST['tipo']) {
        return false;
    }
    if (!empty($_REQUEST['pClave'])) {
        $palabras = (string)($producto['cprod_palabras_claves'] ?? '');
        if (stripos($palabras, $_REQUEST['pClave']) === false) {
            return false;
        }
    }
    if (!empty($_REQUEST['search'])) {
        $id = (string)($producto['cprod_id'] ?? '');
        $codRef = (string)($producto['cprod_cod_ref'] ?? '');
        $code = (string)($producto['cprod_ean_code'] ?? '');
        $marca = (string)($producto['ctipo_nombre'] ?? '');
        $categoria = (string)($producto['ccat_nombre'] ?? '');
        $subCate = (string)($producto['cmar_nombre'] ?? '');
        $nombre = (string)($producto['cprod_nombre'] ?? '');
        $palabras = (string)($producto['cprod_palabras_claves'] ?? '');
        $referencias = (string)($producto['cprod_referencias'] ?? '');
        $search = $_REQUEST['search'];
        if (stripos($nombre, $search) === false && stripos($palabras, $search) === false && stripos($id, $search) === false && stripos($codRef, $search) === false && stripos($code, $search) === false && stripos($marca, $search) === false && stripos($categoria, $search) === false && stripos($subCate, $search) === false && stripos($referencias, $search)) {
            return false;
        }
    }
    return true;
});

// PAGINACIÓN
$productosSinPaginar = array_values($productosFiltrados);

$numRegistros = !empty($productosSinPaginar) ? count($productosSinPaginar) : 0;
$registros = 10;
$pagina = !empty($_REQUEST['nume']) ? intval($_REQUEST["nume"]) : 1;
if (is_numeric($pagina)) {
    $inicio = (($pagina - 1) * $registros);
} else {
    $inicio = 1;
}

$productos = array_slice($productosSinPaginar, $inicio, $registros);
