<?php
    require_once("../../sesion.php");

    $idPagina = 17;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdAdmin->query("INSERT INTO clientes_admin (cliAdmi_nombre, cliAdmi_email, cliAdmi_telefono, cliAdmi_contacto_principal, cliAdmi_fecha_inicio, cliAdmi_fecha_fin, cliAdmi_aviso_previo)VALUES('" . $_POST["nombre"] . "', '" . $_POST["email"] . "', '" . $_POST["telefono"] . "', '" . $_POST["contacto"] . "', '" . $_POST["fechaIni"] . "', '" . $_POST["fechaFin"] . "', '" . $_POST["aviPrev"] . "')");
    $idInsert = mysqli_insert_id($conexionBdAdmin);

    if(isset($_POST["modulo"])){
        $numero = (count($_POST["modulo"]));
        if ($numero > 0) {
            $contador = 0;
            while ($contador < $numero) {
        
                $conexionBdAdmin->query("INSERT INTO modulos_clien_admin(mxca_id_modulo, mxca_id_cliAdmin)VALUES('" . $_POST["modulo"][$contador] . "','" . $idInsert . "')");
        
                $contador++;
            }
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-admin-editar.php?id=' . $idInsertU . '";</script>';
    exit();