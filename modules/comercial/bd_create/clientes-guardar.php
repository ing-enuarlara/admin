<?php
    require_once("../../sesion.php");

    $idPagina = 72;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    if(!validarClave($_POST["clave"])){
        echo '<script type="text/javascript">window.location.href="../bd_read/clientes-agregar.php?error=ER_2";</script>';
        exit();
    }

    $pais=$_POST["pais"];
    if(empty($_POST["pais"])){
        $pais="Colombia";
    }
    
    $ciudad=$_POST["ciudad"];
    $city=NULL;
    if($_POST["pais"]!="Colombia"){
        $ciudad=1122;
        $city=$_POST["ciuExtra"];
    }
    
    $conexionBdComercial->query("INSERT INTO comercial_clientes(cli_tipo_doc, cli_documento, cli_usuario, cli_clave, cli_nombre, cli_email, cli_telefono, cli_pais, cli_ciudad, cli_ciudad_extranjera, cli_direccion, cli_categoria, cli_id_empresa)VALUES('" . $_POST["tipoDoc"] . "', '" . $_POST["documento"] . "', '" . $_POST["documento"] . "', SHA1('" . $_POST["clave"] . "'), '" . $_POST["nombre"] . "', '" . $_POST["email"] . "', '" . $_POST["celular"] . "', '" . $pais . "', '" . $ciudad . "', '" . $city . "', '" . $_POST["direccion"] . "', '" . $_POST["cliTipo"] . "', '" . $datosUsuarioActual['usr_id_empresa'] . "')");

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-editar.php?id=' . $idInsertU . '";</script>';
    exit();