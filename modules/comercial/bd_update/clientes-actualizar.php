<?php
    require_once("../../sesion.php");

    $idPagina = 73;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

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
        $conexionBdComercial->query("UPDATE comercial_clientes SET 
        cli_nombre='" . $_POST["nombre"] . "',
        cli_tipo_doc='" . $_POST["tipoDoc"] . "',
        cli_documento='" . $_POST["documento"] . "',
        cli_categoria='" . $_POST["cliTipo"] . "',
        cli_email='" . $_POST["email"] . "',
        cli_telefono='" . $_POST["celular"] . "',
        cli_ciudad='" . $ciudad . "',
        cli_usuario='" . $_POST["documento"] . "',
        cli_direccion='" . $_POST["direccion"] . "',
        cli_estado_cliente='" . $_POST["cliEstado"] . "',
        cli_pais='" . $pais . "',
        cli_ciudad_extranjera='" . $city . "'
        
        WHERE cli_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

	if ($_FILES['ftClientes']['name'] != "") {
		$destino = RUTA_PROYECTO."files/clientes";
		$fileName = subirArchivosAlServidor($_FILES['ftClientes'], 'ftc', $destino);

        try{
            $conexionBdComercial->query("UPDATE comercial_clientes SET cli_logo= '" . $fileName . "' WHERE cli_id='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    if (!empty($_POST["clave"]) && $_POST["cambiarClave"] == 1) {
    
        $validarClave=validarClave($_POST["clave"]);
        if($validarClave!=true){
            echo '<script type="text/javascript">window.location.href="../bd_read/clientes-editar.php?error=ER_2";</script>';
            exit();
        }

        try{
            $conexionBdComercial->query("UPDATE comercial_clientes SET cli_clave= SHA1('" . $_POST["clave"] . "') WHERE cli_id='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes.php";</script>';
    exit();