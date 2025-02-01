<?php
    require_once("../../sesion.php");

    $idPagina = 132;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdPaginaWeb->query("INSERT INTO blogs(blogs_titulo, blogs_contenido, blogs_palabras_claves, blogs_responsable, blogs_id_empresa)VALUES('" . $_POST["titulo"] . "', '" . $_POST["contenido"] . "', '" . $_POST["pClaves"] . "', '" . $datosUsuarioActual['usr_id'] . "', '".$configuracion['conf_id_empresa']."')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdPaginaWeb);
    
	if (!empty($_FILES['imgnBlog']['name'])) {
		$destino = RUTA_PROYECTO."files/blogs";
		$fileName = subirArchivosAlServidor($_FILES['imgnBlog'], 'blg', $destino);

        try{
            $conexionBdPaginaWeb->query("UPDATE blogs SET blogs_imagen = '" . $fileName . "' WHERE blogs_id ='" . $idInsertU . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/blogs.php";</script>';
    exit();