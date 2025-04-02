<?php
$nombrePagina = "productos.php";
if (empty($_REQUEST["nume"])) {
    $_REQUEST["nume"] = 1;
}
$sql = !empty($filtro) ? "SELECT cprod.*, ccat_nombre, cmar_nombre, cpf_fotos, cpf_tipo, cliAdmi_id, cliAdmi_nombre FROM comercial_productos cprod 
    LEFT JOIN comercial_categorias ON ccat_id=cprod_categoria 
    LEFT JOIN comercial_marcas ON cmar_id=cprod_marca 
    LEFT JOIN comercial_productos_fotos ON cpf_id_producto=cprod_id AND cpf_principal=1 
    INNER JOIN " . BDADMIN . ".clientes_admin ON cliAdmi_id=cprod_id_empresa 
    WHERE cprod_id=cprod_id {$filtroAdmin} {$filtro}" : "SELECT * FROM comercial_productos 
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
