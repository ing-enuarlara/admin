<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');

$idPagina = 164;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

$subCategoria = 0;
if (!empty($_POST["marca"])) {
    $subCategoria = $_POST["marca"];
}

$codRef = $_POST["ref"] != $_POST["id"] ? $_POST["ref"] : NULL;
Catalogo_Principal::Update(
    [
        'cprin_nombre' => $_POST["nombre"],
        'cprin_costo' => $_POST["costo"],
        'cprin_detalles' => $_POST["detalles"],
        'cprin_exitencia' => $_POST["existencia"],
        'cprin_marca' => $subCategoria,
        'cprin_categoria' => $_POST["categoria"],
        'cprin_tipo' => $_POST["tipo"],
        'cprin_palabras_claves' => $_POST["paClave"],
        'cprin_estado' => $_POST["estado"],
        'cprin_especificaciones' => $_POST["especificaciones"],
        'cprin_cod_ref' => $codRef
    ],
    [
        'cprin_id' => $_POST["id"]
    ]
);

// 1. Colores
if (!empty($_POST['especificaciones_colores'])) {
    Productos_Especificaciones::Delete(
        [
            'cpt_id_producto' => $_POST["id"],
            'cpt_tech_prin' => SI,
            'cpt_tipo' => 'COLOR'
        ]
    );
    foreach ($_POST['especificaciones_colores'] as $color) {
        Productos_Especificaciones::Insert(
            [
                'cpt_value' => $color,
                'cpt_id_producto' => $_POST["id"],
                'cpt_id_empresa' => $_SESSION["idEmpresa"],
                'cpt_tech_prin' => SI,
                'cpt_tipo' => 'COLOR'
            ]
        );
    }
}

// 2. Tallas
if (!empty($_POST['especificaciones_tallas'])) {
    Productos_Especificaciones::Delete(
        [
            'cpt_id_producto' => $_POST["id"],
            'cpt_tech_prin' => SI,
            'cpt_tipo' => 'TALLA'
        ]
    );
    foreach ($_POST['especificaciones_tallas'] as $talla) {
        Productos_Especificaciones::Insert(
            [
                'cpt_value' => $talla,
                'cpt_id_producto' => $_POST["id"],
                'cpt_id_empresa' => $_SESSION["idEmpresa"],
                'cpt_tech_prin' => SI,
                'cpt_tipo' => 'TALLA'
            ]
        );
    }
}

// 3. Otras
if (!empty($_POST['otras_labels']) && !empty($_POST['otras_values'])) {
    Productos_Especificaciones::Delete(
        [
            'cpt_id_producto' => $_POST["id"],
            'cpt_tech_prin' => SI,
            'cpt_tipo' => 'OTRO'
        ]
    );
    for ($i = 0; $i < count($_POST['otras_labels']); $i++) {
        $label = trim($_POST['otras_labels'][$i]);
        $value = trim($_POST['otras_values'][$i]);
        if ($label && $value) {
            Productos_Especificaciones::Insert(
                [
                    'cpt_lebel' => $label,
                    'cpt_value' => $value,
                    'cpt_id_producto' => $_POST["id"],
                    'cpt_id_empresa' => $_SESSION["idEmpresa"],
                    'cpt_tech_prin' => SI,
                    'cpt_tipo' => 'OTRO'
                ]
            );
        }
    }
}

if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftProducto']['name']) || !empty($_POST['urlProducto']))) {
    if (!empty($_FILES['ftProducto']['name'])) {
        $destino = RUTA_PROYECTO . "files/productos";
        $fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);
    }

    if (!empty($_POST['urlProducto'])) {
        $fileName = $_POST['urlProducto'];
    }

    Productos_Fotos::Update(
        [
            'cpf_fotos' => $fileName,
            'cpf_tipo' => $_POST['tipoImg']
        ],
        [
            'cpf_id_producto' => $_POST["id"],
            'cpf_principal' => 1,
            'cpf_fotos_prin' => SI
        ]
    );
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/catalogo-principal.php";</script>';
exit();
