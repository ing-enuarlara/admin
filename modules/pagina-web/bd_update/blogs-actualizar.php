<?php
    require_once("../../sesion.php");

    $idPagina = 134;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdPaginaWeb->query("UPDATE blogs SET blogs_titulo='" . $_POST["titulo"] . "', blogs_contenido='" . $_POST["contenido"] . "', blogs_palabras_claves='" . $_POST["pClaves"] . "', blogs_id_categoria='" . $_POST["categoria"] . "', blogs_fecha_creacion='" . $_POST["fecha"] . "' WHERE blogs_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
    
	if (!empty($_FILES['imgnBlog']['name'])) {
		$destino = RUTA_PROYECTO."files/blogs";
		$fileName = subirArchivosAlServidor($_FILES['imgnBlog'], 'blg', $destino);

        try{
            $conexionBdPaginaWeb->query("UPDATE blogs SET blogs_imagen = '" . $fileName . "' WHERE blogs_id ='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/blogs.php";</script>';
    exit();