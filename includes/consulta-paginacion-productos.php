<?php
$nombrePagina = "productos.php";
if (empty($_REQUEST["nume"])) {
    $_REQUEST["nume"] = 1;
}
$sql = !empty($filtro) ? "SELECT cprod.cprod_id
    FROM comercial_productos cprod
    LEFT JOIN comercial_categorias ccat ON ccat.ccat_id = cprod.cprod_categoria
    LEFT JOIN comercial_marcas cmar ON cmar.cmar_id = cprod.cprod_marca
    LEFT JOIN comercial_productos_fotos cpf ON cpf.cpf_id_producto = cprod.cprod_id AND cpf.cpf_principal = 1
    INNER JOIN " . BDADMIN . ".clientes_admin cli ON cli.cliAdmi_id = cprod.cprod_id_empresa
    WHERE 1=1 {$filtroAdmin} {$filtro}" : "SELECT * FROM comercial_productos 
    INNER JOIN " . BDADMIN . ".clientes_admin ON cliAdmi_id=cprod_id_empresa 
    WHERE cprod_id=cprod_id {$filtroAdmin} {$filtro}";
try {
    $consulta = $conexionBdComercial->query($sql);
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}
$numRegistros = !empty($consulta) ? mysqli_num_rows($consulta) : 0;
$registros = 10;
$pagina = !empty($_REQUEST['nume']) ? intval($_REQUEST["nume"]) : 1;
if (is_numeric($pagina)) {
    $inicio = (($pagina - 1) * $registros);
} else {
    $inicio = 1;
}
