<?php
    require_once("../../sesion.php");

    $idPagina = 24;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

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
    cprod_estado='" . $_POST["estado"] . "', 
    cprod_fecha_creacion=new()
    WHERE cprod_id='" . $_POST["id"] . "'");
    
	if ($_FILES['ftProducto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/productos";
		$fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);

        $conexionBdComercial->query("UPDATE comercial_productos_fotos SET cpf_fotos='" . $fileName . "' WHERE cpf_id_producto='" . $_POST["id"] . "' AND cpf_principal=1");
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos.php";</script>';
    exit();