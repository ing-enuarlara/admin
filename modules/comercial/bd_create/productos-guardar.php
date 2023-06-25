<?php
    require_once("../../sesion.php");

    $idPagina = 22;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $subCategoria=0;
    if(!empty($_POST["marca"])){
        $subCategoria=$_POST["marca"];
    }
    
    $conexionBdComercial->query("INSERT INTO comercial_productos(cprod_nombre, cprod_costo, cprod_detalles, cprod_exitencia, cprod_marca, cprod_categoria, cprod_tipo, cprod_palabras_claves, cprod_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["costo"] . "', '" . $_POST["detalles"] . "', '" . $_POST["existencia"] . "', '" . $subCategoria . "', '" . $_POST["categoria"] . "', '" . $_POST["tipo"] . "', '" . $_POST["paClave"] . "', '" . $datosUsuarioActual['usr_id_empresa'] . "')");

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos-editar.php?id=' . $idInsertU . '";</script>';
    exit();