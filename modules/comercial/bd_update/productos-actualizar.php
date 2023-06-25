<?php
    require_once("../../sesion.php");

    $idPagina = 24;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	// if ($_FILES['foto']['name'] != "") {
	// 	$destino = RUTA_PROYECTO."files/productos";
	// 	$fileName = subirArchivosAlServidor($_FILES['foto'], 'pro', $destino);
    
    //     $conexionBdComercial->query("UPDATE comercial_productos SET cprod_foto='" . $fileName . "' WHERE cprod_id='" . $_POST["id"] . "'");
	// }
    $subCategoria=0;
    if(!empty($_POST["marca"])){
        $subCategoria=$_POST["marca"];
    }
    
    $conexionBdComercial->query("UPDATE comercial_productos SET 
    cprod_nombre='" . $_POST["nombre"] . "', 
    cprod_costo='" . $_POST["costo"] . "', 
    cprod_detalles='" . $_POST["detalles"] . "', 
    cprod_exitencia='" . $_POST["existencia"] . "', 
    cprod_marca='" . $subCategoria . "', 
    cprod_categoria='" . $_POST["categoria"] . "', 
    cprod_tipo='" . $_POST["tipo"] . "', 
    cprod_palabras_claves='" . $_POST["paClave"] . "', 
    cprod_estado='" . $_POST["estado"] . "'
     WHERE cprod_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos.php";</script>';
    exit();