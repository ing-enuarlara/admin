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

    try{
        $conexionBdComercial->query("INSERT INTO comercial_clientes(cli_tipo_doc, cli_documento, cli_usuario, cli_clave, cli_nombre, cli_email, cli_telefono, cli_pais, cli_ciudad, cli_ciudad_extranjera, cli_direccion, cli_categoria, cli_id_empresa)VALUES('" . $_POST["tipoDoc"] . "', '" . $_POST["documento"] . "', '" . $_POST["documento"] . "', SHA1('" . $_POST["clave"] . "'), '" . $_POST["nombre"] . "', '" . $_POST["email"] . "', '" . $_POST["celular"] . "', '" . $pais . "', '" . $ciudad . "', '" . $city . "', '" . $_POST["direccion"] . "', '" . $_POST["cliTipo"] . "', '" . $datosUsuarioActual['usr_id_empresa'] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
    $idInsertU = mysqli_insert_id($conexionBdComercial);
    
    try{
        $conexionBdAdministrativo->query("INSERT INTO administrativo_usuarios(usr_login,usr_clave,usr_tipo,usr_nombre,usr_email,usr_ciudad,usr_telefono,usr_id_empresa,usr_estado,usr_documento,usr_id_cliente)VALUES('" . $_POST["documento"] . "',SHA1('" . $_POST["clave"] . "'),5,'" . $_POST["nombre"] . "','" . $_POST["email"] . "','" . $ciudad . "','" . $_POST["celular"] . "','" . $datosUsuarioActual['usr_id_empresa'] . "',0,'" . $_POST["documento"] . "','" . $idInsertU . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-editar.php?id=' . $idInsertU . '";</script>';
    exit();