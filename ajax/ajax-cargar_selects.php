<?php
include("../modules/sesion.php");

header('Content-Type: application/json');

$tipo = $_GET['tipo'] ?? null;
$response = [];

if (!$tipo) {
    echo json_encode($response);
    exit;
}

$idEmpresa = $_SESSION["idEmpresa"];
$esDev = $_SESSION["datosUsuarioActual"]["usr_tipo"] == DEV;

$whereEmpresa = !$esDev ? "WHERE " : "";
switch ($tipo) {
  case PROD:
    $where = !$esDev ? "WHERE cprod_id_empresa='$idEmpresa'" : "";
    $query = "SELECT cprod_id AS id, cprod_nombre AS nombre FROM comercial_productos $where";
    break;

  case CATE:
    $where = !$esDev ? "WHERE ccat_id_empresa='$idEmpresa'" : "";
    $query = "SELECT ccat_id AS id, ccat_nombre AS nombre FROM comercial_categorias $where";
    break;

  case SUB_CATE:
    $where = !$esDev ? "WHERE cmar_id_empresa='$idEmpresa'" : "";
    $query = "SELECT cmar_id AS id, cmar_nombre AS nombre FROM comercial_marcas $where";
    break;

  case TIPO:
    $where = !$esDev ? "AND ctipo_id_empresa='$idEmpresa'" : "";
    $query = "SELECT ctipo_id AS id, ctipo_nombre AS nombre FROM comercial_tipo_productos WHERE ctipo_estado=1 $where";
    break;

  default:
    echo json_encode([]);
    exit;
}

try {
    $result = $conexionBdComercial->query($query);
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre']
        ];
    }
} catch (Exception $e) {
    $response = ['error' => 'Error al cargar datos'];
}

echo json_encode($response);
