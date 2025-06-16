<?php
$nombrePagina = "productos.php";
if (empty($_REQUEST["nume"])) {
    $_REQUEST["nume"] = 1;
}

$productosBD = Productos::SelectJoin(
    $predicado,
    "cprod_id, cprod_cod_ref, cprod_nombre, cprod_costo, cprod_exitencia, cprod_estado, cprod_categoria, cprod_marca, cprod_id_empresa, ccat_nombre, cmar_nombre",
    [
        Categorias::class,
        SubCategorias::class
    ]
);

$productosSiniwin = [];
if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV || $_SESSION["idEmpresa"] == 3) {
    try {
        $productos = Api_Siniwin::Productos();
    } catch (Exception $e) {
        echo "Error al conectar con la API: " . $e->getMessage();
    }
    if (!empty($productosApiSiniwin)) {
        foreach ($productosApiSiniwin as $productoApiSiniwin) {

            $productosSiniwin[] = [
                'cprod_id' => $productoApiSiniwin['ref'],
                'cprod_nombre' => $productoApiSiniwin['denomination'],
                'cprod_exitencia' => $productoApiSiniwin['Stock'] ?? 0,
                'cprod_costo' => $productoApiSiniwin['pvp_iva'] ?? 0,
                'cprod_detalles' => $productoApiSiniwin['observations'] ?? '',
                'cprod_descuento' => 0,
                'cprod_id_empresa' => 3,
                'cprod_estado' => 1,
                'ccat_nombre' => $productoApiSiniwin['family'] ?? '',
                'cmar_nombre' => '',
                'fuente' => 'apiSiniwin',
                'store' => $productoApiSiniwin['store'] ?? ''
            ];
        }
    }
}

if (!is_array($productosBD)) {
    $productosBD = [];
}
if (!is_array($productosSiniwin)) {
    $productosSiniwin = [];
}

$productosSinPaginar = array_merge($productosBD, $productosSiniwin);

// APLICAR FILTROS
$productosFiltrados = array_filter($productosSinPaginar, function ($producto) {
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
        $nombre = (string)($producto['cprod_nombre'] ?? '');
        $palabras = (string)($producto['cprod_palabras_claves'] ?? '');
        $search = $_REQUEST['search'];
        if (stripos($nombre, $search) === false && stripos($palabras, $search) === false) {
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
