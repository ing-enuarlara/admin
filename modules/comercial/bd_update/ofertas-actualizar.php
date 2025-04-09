<?php
    require_once("../../sesion.php");

    $idPagina = 158;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdComercial->query("UPDATE comercial_ofertas SET 
        ofer_fecha_inicio='" . $_POST["fechaInicio"] . "', 
        ofer_fecha_fin='" . $_POST["fechaFinal"] . "', 
        ofer_title='" . $_POST["titulo"] . "', 
        ofer_descripcion='" . $_POST["descripcion"] . "',
        ofer_activo='" . $_POST["activo"] . "', 
        ofer_tipo='" . $_POST["tipoOfertas"] . "'
        WHERE ofer_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftOferta']['name']) || !empty($_POST['urlImgOferta']))) {
        if (!empty($_FILES['ftOferta']['name'])) {
            $destino = RUTA_PROYECTO . "files/ofertas";
            $fileName = subirArchivosAlServidor($_FILES['ftOferta'], 'ofer', $destino);
        }
    
        if (!empty($_POST['urlImgOferta'])) {
            $fileName = $_POST['urlImgOferta'];
        }
    
        try {
            $conexionBdComercial->query("UPDATE comercial_ofertas SET ofer_img='" . $fileName . "', ofer_tipo_img = '" . $_POST['tipoImg'] . "' WHERE ofer_id = '" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
        }
    }

    $arrayProds = json_decode($_POST['articulosActuales'], true);

    if ($_POST["tipoOfertas"] != TODA && !empty($_POST["articulos"])) {
        if ($_POST["tipoOfertas"] != $_POST["tipoOfertaActual"] ) {
            try {
                $conexionBdComercial->query("DELETE FROM comercial_ofertas_productos WHERE cop_id_oferta='" . $_POST["id"] . "'");
            } catch (Exception $e) {
                include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
            }

            foreach ($_POST["articulos"] as $articulo) {
                try {
                    $conexionBdComercial->query("INSERT INTO comercial_ofertas_productos(cop_id_oferta, cop_id_articulo) VALUES ('" . $_POST["id"] . "', '" . $articulo . "')");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                }
            }
        } else {
            $arrayGuardar = array_diff($_POST["articulos"], $arrayProds);
            foreach ($arrayGuardar as $articulo) {
                try {
                    $conexionBdComercial->query("INSERT INTO comercial_ofertas_productos(cop_id_oferta, cop_id_articulo) VALUES ('" . $_POST["id"] . "', '" . $articulo . "')");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                }
            }

            $arrayEliminar = array_diff($arrayProds, $_POST["articulos"]);
            foreach ($arrayEliminar as $articulo) {
                try {
                    $conexionBdComercial->query("DELETE FROM comercial_ofertas_productos WHERE cop_id_oferta='" . $_POST["id"] . "' AND cop_id_articulo='" . $articulo . "'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                }
            }
        }
    } elseif (!empty($arrayProds)) {
        try {
            $conexionBdComercial->query("DELETE FROM comercial_ofertas_productos WHERE cop_id_oferta='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/ofertas.php?success=SC_3";</script>';
    exit();